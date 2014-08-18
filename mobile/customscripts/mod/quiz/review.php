<?php  // $Id: review.php,v 1.12 2008/02/07 05:32:54 jamiesensei Exp $
/**
* This page prints a review of a particular quiz attempt
*
* @license http://www.gnu.org/copyleft/gpl.html GNU Public License
* @package quiz
*/

    mfm_setup();

    require_once("locallib.php");
    require_once($CFG->mfm_dirroot.'/question/type/questiontype.php');

    $attempt = required_param('attempt', PARAM_INT);    // A particular attempt ID for review
    $page = optional_param('page', 0, PARAM_INT); // The required page
    $showall = optional_param('showall', 0, PARAM_BOOL);

    if (! $attempt = get_record("quiz_attempts", "id", $attempt)) {
        mfm_error("No such attempt ID exists");
    }
    if (! $quiz = get_record("quiz", "id", $attempt->quiz)) {
        mfm_error("The quiz with id $attempt->quiz belonging to attempt $attempt is missing");
    }
    if (! $course = get_record("course", "id", $quiz->course)) {
        mfm_error("The course with id $quiz->course that the quiz with id $quiz->id belongs to is missing");
    }
    if (! $cm = get_coursemodule_from_instance("quiz", $quiz->id, $course->id)) {
        mfm_error("The course module for the quiz with id $quiz->id is missing");
    }

    if (!count_records('question_sessions', 'attemptid', $attempt->uniqueid)) {
        // this question has not yet been upgraded to the new model
        quiz_upgrade_states($attempt);
    }

    mfm_require_login($course->id, false, $cm);
    $context = get_context_instance(CONTEXT_MODULE, $cm->id);
    $isteacher = has_capability('mod/quiz:preview', get_context_instance(CONTEXT_MODULE, $cm->id));
    $options = quiz_get_reviewoptions($quiz, $attempt, $context);
        //never show any popup for mfm

    if (!$isteacher) {
        if (!$attempt->timefinish) {
            mfm_redirect('attempt.php?q='.$quiz->id);
        }
        // If not even responses are to be shown in review then we
        // don't allow any review
        if (!($quiz->review & QUIZ_REVIEW_RESPONSES)) {
            mfm_redirect('view.php?q='.$quiz->id);
        }
        if ((time() - $attempt->timefinish) > 120) { // always allow review right after attempt
            if ((!$quiz->timeclose or time() < $quiz->timeclose) and !($quiz->review & QUIZ_REVIEW_OPEN)) {
                mfm_redirect('view.php?q='.$quiz->id, mfm_get_string("noreviewuntil", "quiz", userdate($quiz->timeclose)));
            }
            if ($quiz->timeclose and time() >= $quiz->timeclose and !($quiz->review & QUIZ_REVIEW_CLOSED)) {
                mfm_redirect('view.php?q='.$quiz->id, mfm_get_string("noreview", "quiz"));
            }
        }
        if ($attempt->userid != $USER->id) {
            mfm_error("This is not your attempt!", 'view.php?q='.$quiz->id);
        }
    }

    add_to_log($course->id, "quiz", "review", "review.php?id=$cm->id&amp;attempt=$attempt->id", "$quiz->id", "$cm->id");

/// Print the page header

    $strquizzes = mfm_get_string("modulenameplural", "quiz");
    $strreview  = mfm_get_string("review", "quiz");
    $strscore  = mfm_get_string("score", "quiz");
    $strgrade  = mfm_get_string("grade");
    $strbestgrade  = mfm_get_string("bestgrade", "quiz");
    $strtimetaken     = mfm_get_string("timetaken", "quiz");
    $strtimecompleted = mfm_get_string("completedon", "quiz");
    $stroverdue = mfm_get_string("overdue", "quiz");


    mfm_print_header_simple(format_string($quiz->name), "",
             "<a href=\"view.php?id=$cm->id\">".format_string($quiz->name,true)."</a> -> $strreview",
             "", "", true, '');

    mfm_print_heading(format_string($quiz->name));

/// Load all the questions and states needed by this script

    // load the questions needed by page
    $pagelist = $showall ? quiz_questions_in_quiz($attempt->layout) : quiz_questions_on_page($attempt->layout, $page);
    $sql = "SELECT q.*, i.grade AS maxgrade, i.id AS instance".
           "  FROM {$CFG->prefix}question q,".
           "       {$CFG->prefix}quiz_question_instances i".
           " WHERE i.quiz = '$quiz->id' AND q.id = i.question".
           "   AND q.id IN ($pagelist)";
    if (!$questions = get_records_sql($sql)) {
        mfm_error('No questions found');
    }

    // Load the question type specific information
    if (!get_question_options($questions)) {
        mfm_error('Could not load question options');
    }

    // Restore the question sessions to their most recent states
    // creating new sessions where required
    if (!$states = get_question_states($questions, $quiz, $attempt)) {
        mfm_error('Could not restore question sessions');
    }

/// Print infobox
    if ($isteacher and $attempt->userid == $USER->id) {
        // the teacher is at the end of a preview. Print button to start new preview
        unset($buttonoptions);
        $buttonoptions['q'] = $quiz->id;
        $buttonoptions['forcenew'] = true;
        echo '<center>';
        mfm_print_single_button($CFG->wwwroot.'/mod/quiz/attempt.php', $buttonoptions, mfm_get_string('startagain', 'quiz'));
        echo '</center>';
    } else { // print number of the attempt
        mfm_print_heading(mfm_get_string('reviewofattempt', 'quiz', $attempt->attempt));
    }
    $timelimit = (int)$quiz->timelimit * 60;
    $overtime = 0;

    if ($attempt->timefinish) {
        if ($timetaken = ($attempt->timefinish - $attempt->timestart)) {
            if($timelimit && $timetaken > ($timelimit + 60)) {
                $overtime = $timetaken - $timelimit;
                $overtime = format_time($overtime);
            }
            $timetaken = format_time($timetaken);
        } else {
            $timetaken = "-";
        }
    } else {
        $timetaken = mfm_get_string('unfinished', 'quiz');
    }




/// Print the navigation panel if required
    $numpages = quiz_number_of_pages($attempt->layout);
    if ($numpages > 1 and !$showall) {
        //print_paging_bar($numpages, $page, 1, 'review.php?attempt='.$attempt->id.'&amp;');
        echo '<center><a href="review.php?attempt='.$attempt->id.'&amp;showall=true">';
        mfm_print_string('showall', 'quiz');
        echo '</a></center>';
    }

/// Print all the questions

    $pagequestions = explode(',', $pagelist);
    $number = quiz_first_questionnumber($attempt->layout, $pagelist);
    foreach ($pagequestions as $i) {
        if (!isset($questions[$i])) {
            echo '<strong>' . $number . '</strong><br />';
            mfm_notify(mfm_get_string('errormissingquestion', 'quiz', $i));
            $number++; // Just guessing that the missing question would have lenght 1
            continue;
        }
        $options = quiz_get_reviewoptions($quiz, $attempt, $context);
        $options->validation = QUESTION_EVENTVALIDATE === $states[$i]->event;
        $options->history = ($isteacher and !$attempt->preview) ? 'all' : 'graded';
        // Print the question
        if ($i > 0) {
            echo "<br />\n";
        }
        echo '<hr width="40%">';
        print_question($questions[$i], $states[$i], $number, $quiz, $options);
        $number += $questions[$i]->length;
        echo '<hr width="40%">';
    }

    // Print the navigation panel if required
    if ($numpages > 1 and !$showall) {
        print_paging_bar($numpages, $page, 1, 'review.php?attempt='.$attempt->id.'&amp;');
    }

    if ($isteacher and count($attempts = get_records_select('quiz_attempts', "quiz = '$quiz->id' AND userid = '$attempt->userid'", 'attempt ASC')) > 1) {
        // print list of attempts
        $attemptlist = '';
        foreach ($attempts as $at) {
            $attemptlist .= ($at->id == $attempt->id)
                ? '<strong>'.$at->attempt.'</strong>, '
                :  '<a href="review.php?attempt='.$at->id.($showall?'&amp;showall=true':'').'">'.$at->attempt.'</a>, ';
        }
        echo mfm_get_string('attempts', 'quiz').': '. trim($attemptlist, ' ,')."<br>\n";
    }

    echo(mfm_get_string('startedon', 'quiz').': '. userdate($attempt->timestart)."<br>\n");
    if ($attempt->timefinish) {
        echo("$strtimecompleted: ". userdate($attempt->timefinish)."<br>\n");
        echo("$strtimetaken: ". $timetaken."<br>\n");
    }
    if (!empty($overtime)) {
        echo("$stroverdue: ". $overtime."<br>\n");
    }
//    if ($quiz->grade and $quiz->sumgrades) {
//        if($overtime) {
//            $result->sumgrades = "0";
//            $result->grade = "0.0";
//        }
//        
//        // if the student has ungraded essay(s), notify him/her of it
//        list($ungradedessays, $usercount) = $QTYPES[ESSAY]->get_ungraded_count($quiz, $attempt->userid, $attempt->id);
//        if ($ungradedessays) {
//            $ungradednotice = '<br /><strong>'.mfm_get_string('ungradednotice', 'quiz', $ungradedessays).'</strong>';
//        } else {
//            $ungradednotice = '';
//        }
//        
//        $percentage = round(($attempt->sumgrades/$quiz->sumgrades)*100, 0);
//        $grade = round(($attempt->sumgrades/$quiz->sumgrades)*$quiz->grade, $CFG->quiz_decimalpoints);
//        $rawscore = round($attempt->sumgrades, $CFG->quiz_decimalpoints);
//        $table->data[] = array("$strscore:", "$rawscore/$quiz->sumgrades ($percentage %)");
//        $table->data[] = array("$strgrade:", $grade.mfm_get_string('outof', 'quiz').$quiz->grade.$ungradednotice);
//    }
    mfm_print_footer($course);
    die();
?>
