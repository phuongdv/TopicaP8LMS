<?php  // $Id: view.php,v 1.12 2008/02/07 04:26:50 jamiesensei Exp $

// This page prints a particular instance of quiz

    mfm_setup();

    require_once($CFG->libdir.'/gradelib.php');
    require_once($CFG->dirroot.'/mod/quiz/locallib.php');

    $id   = optional_param('id', 0, PARAM_INT); // Course Module ID, or
    $q    = optional_param('q',  0, PARAM_INT);  // quiz ID
    $edit = optional_param('edit', -1, PARAM_BOOL);
    if ($id) {
        if (! $cm = get_record("course_modules", "id", $id)) {
            mfm_error("There is no coursemodule with id $id");
        }

        if (! $course = get_record("course", "id", $cm->course)) {
            mfm_error("Course is misconfigured");
        }

        if (! $quiz = get_record("quiz", "id", $cm->instance)) {
            mfm_error("The quiz with id $cm->instance corresponding to this coursemodule $id is missing");
        }

    } else {
        if (! $quiz = get_record("quiz", "id", $q)) {
            mfm_error("There is no quiz with id $q");
        }
        if (! $course = get_record("course", "id", $quiz->course)) {
            mfm_error("The course with id $quiz->course that the quiz with id $q belongs to is missing");
        }
        if (! $cm = get_coursemodule_from_instance("quiz", $quiz->id, $course->id)) {
            mfm_error("The course module for the quiz with id $q is missing");
        }
    }

    mfm_require_login($course->id, false, $cm);
    $context = get_context_instance(CONTEXT_MODULE, $cm->id);
    $canpreview = has_capability('mod/quiz:preview', $context);

    add_to_log($course->id, "quiz", "view", "view.php?id=$cm->id", $quiz->id, $cm->id);

    $timenow = time();

// Print the page header

    $USER->editing = false;

    if($course->id == SITEID) {
        $breadcrumbs = array();
    }
    else {
        $breadcrumbs = array($course->shortname => $CFG->wwwroot.'/course/view.php?id='.$course->id);
    }

    $breadcrumbs[format_string($quiz->name)]            = $CFG->wwwroot.'/mod/quiz/view.php?id='.$cm->id;
    $total     = count($breadcrumbs);
    $current   = 1;
    $crumbtext = '';
    foreach($breadcrumbs as $text => $href) {
        if($current++ == $total) {
            $crumbtext .= ' '.$text;
        }
        else {
            $crumbtext .= ' <a href="'.$href.'">'.$text.'</a> ->';
        }
    }
    mfm_print_header(strip_tags($course->fullname), $course->fullname, $crumbtext, '',
                 '',
                 true, '', mfm_user_login_string($SITE));


    $available = ($quiz->timeopen < $timenow and ($timenow < $quiz->timeclose or !$quiz->timeclose)) || $canpreview;

// Print the main part of the page

    mfm_print_heading(format_string($quiz->name));

    if (trim(strip_tags($quiz->intro))) {
        $formatoptions->noclean = true;
        echo(format_text($quiz->intro, FORMAT_MOODLE, $formatoptions));
    }

    if ($quiz->attempts > 1) {
        echo "<p align=\"center\">".mfm_get_string("attemptsallowed", "quiz").": $quiz->attempts</p>";
        echo "<p align=\"center\">".mfm_get_string("grademethod", "quiz").": ".$QUIZ_GRADE_METHOD[$quiz->grademethod]."</p>";
    } else {
        echo "<br />";
    }
    if ($available) {
        if ($quiz->timelimit) {
            echo "<p align=\"center\">".mfm_get_string("quiztimelimit","quiz", format_time($quiz->timelimit * 60))."</p>";
        }
        mfm_quiz_view_dates($quiz);
    } else if ($timenow < $quiz->timeopen) {
        echo "<p align=\"center\">".mfm_get_string("quiznotavailable", "quiz", userdate($quiz->timeopen));
    } else {
        echo "<p align=\"center\">".mfm_get_string("quizclosed", "quiz", userdate($quiz->timeclose));
    }

    if (isguestuser()) {

        $wwwroot = $CFG->wwwroot.'/login/index.php';
        if (!empty($CFG->loginhttps)) {
            $wwwroot = str_replace('http','https', $wwwroot);
        }

        mfm_notice_yesno(mfm_get_string('guestsno', 'quiz').'<br /><br />'.mfm_get_string('liketologin'),
                     $wwwroot, $CFG->wwwroot.'/course/view.php?id='.$course->id);
        mfm_print_footer($course);
        exit;
    }

    if ($attempts = quiz_get_user_attempts($quiz->id, $USER->id)) {
        $numattempts = count($attempts);
    } else {
        $numattempts = 0;
    }

    $unfinished = false;
    if ($unfinishedattempt =  quiz_get_user_attempt_unfinished($quiz->id, $USER->id)) {
        $attempts[] = $unfinishedattempt;
        $unfinished = true;
    }

    $strattempt       = mfm_get_string("attempt", "quiz");
    $strtimetaken     = mfm_get_string("timetaken", "quiz");
    $strtimecompleted = mfm_get_string("timecompleted", "quiz");
    $strgrade         = mfm_get_string("grade");
    $strmarks         = mfm_get_string('marks', 'quiz');
    $strbestgrade     = quiz_get_grading_option_name($quiz->grademethod);

    // Work out the final grade, checking whether it was overridden in the gradebook.
    $mygrade = quiz_get_best_grade($quiz, $USER->id);
    $mygradeoverridden = false;
    $gradebookfeedback = '';

    $grading_info = grade_get_grades($course->id, 'mod', 'quiz', $quiz->id, $USER->id);
    if (!empty($grading_info->items)) {
        $item = $grading_info->items[0];
        if (isset($item->grades[$USER->id])) {
            $grade = $item->grades[$USER->id];

            if ($grade->overridden) {
                $mygrade = $grade->grade + 0; // Convert to number.
                $mygradeoverridden = true;
            }
            if (!empty($grade->str_feedback)) {
                $gradebookfeedback = $grade->str_feedback;
            }
        }
    }

    $overallstats=1;

/*
Won't worry about printing past attempts for now.

/// Now print table with existing attempts

    if ($numattempts) {
    /// prepare table header
        if ($quiz->grade and $quiz->sumgrades) { // Grades used so have more columns in table
            if ($quiz->grade <> $quiz->sumgrades) {
                $table->head = array($strattempt, $strtimetaken, $strtimecompleted, "$strmarks / $quiz->sumgrades", "$strgrade / $quiz->grade");
                $table->align = array("center", "center", "left", "right", "right");
                $table->size = array("", "", "", "", "");
            } else {
                $table->head = array($strattempt, $strtimetaken, $strtimecompleted, "$strgrade / $quiz->grade");
                $table->align = array("center", "center", "left", "right");
                $table->size = array("", "", "", "");
            }

        } else {  // No grades are being used
            $table->head = array($strattempt, $strtimetaken, $strtimecompleted);
            $table->align = array("center", "center", "left");
            $table->size = array("", "", "");
        }

    /// One row for each attempt
        foreach ($attempts as $attempt) {

        /// prepare strings for time taken and date completed
            $timetaken = '';
            $datecompleted = '';
            if ($attempt->timefinish > 0) { // attempt has finished
                $timetaken = format_time($attempt->timefinish - $attempt->timestart);
                $datecompleted = userdate($attempt->timefinish);
            } else if ($available) { // The student can continue this attempt, so put appropriate link
                $timetaken = format_time(time() - $attempt->timestart);
                $strconfirmstartattempt = addslashes(mfm_get_string("confirmstartattempt","quiz"));
                $datecompleted  = "\n".'<script language="javascript" type="text/javascript">';
                $datecompleted .= "\n<!--\n"; // -->
                if (!empty($CFG->usesid) && !isset($_COOKIE[session_name()])) {
                    $attempturl=sid_process_url("attempt.php?id=$cm->id");
                } else {
                    $attempturl="attempt.php?id=$cm->id";
                };
                if (!empty($quiz->popup)) {
                    $datecompleted .= "var windowoptions = 'left=0, top=0, height='+window.screen.height+
                     ', width='+window.screen.width+', channelmode=yes, fullscreen=yes, scrollbars=yes, '+
                     'resizeable=no, directories=no, toolbar=no, titlebar=no, location=no, status=no, '+
                     'menubar=no';\n";
                    $jslink  = 'javascript:';
                    if ($quiz->timelimit) {
                        $jslink .=  "if (confirm('$strconfirmstartattempt')) ";
                    }
                    $jslink .= "var popup = window.open(\\'$attempturl\\', \\'quizpopup\\', windowoptions);";
                } else {
                    $jslink = $attempturl;
                }

                $linktext = mfm_get_string('continueattemptquiz', 'quiz');
                $datecompleted .= "document.write('<a href=\"$jslink\" alt=\"$linktext\">$linktext</a>');";
                $datecompleted .= "\n-->\n";
                $datecompleted .= '</script>';
                $datecompleted .= '<noscript>';
                $datecompleted .= '<strong>'.mfm_get_string('noscript', 'quiz').'</strong>';
                $datecompleted .= '</noscript>';
            } else { // attempt was not completed but is also not available any more.
                $timetaken = format_time($quiz->timeclose - $attempt->timestart);
                $datecompleted = $quiz->timeclose ? userdate($quiz->timeclose) : '';
            }

        /// prepare strings for attempt number, mark and grade
            if ($quiz->grade and $quiz->sumgrades) {
                $attemptmark  = round($attempt->sumgrades,$quiz->decimalpoints);
                $attemptgrade = round(($attempt->sumgrades/$quiz->sumgrades)*$quiz->grade,$quiz->decimalpoints);

                // highlight the highest grade if appropriate
                if ($attemptgrade == $mygrade and ($quiz->grademethod == QUIZ_GRADEHIGHEST)) {
                    $attemptgrade = "<span class=\"highlight\">$attemptgrade</span>";
                }

                // if attempt is closed and review is allowed then make attemptnumber and
                // mark and grade into links to review page
                if (quiz_review_allowed($quiz) and $attempt->timefinish > 0) {
                    if ($quiz->popup) { // need to link to popup window
                        $attemptmark = link_to_popup_window ("/mod/quiz/review.php?q=$quiz->id&amp;attempt=$attempt->id", 'quizpopup', round($attempt->sumgrades,$quiz->decimalpoints), '+window.screen.height+', '+window.screen.width+', '', $windowoptions, true);
                        $attemptgrade = link_to_popup_window ("/mod/quiz/review.php?q=$quiz->id&amp;attempt=$attempt->id", 'quizpopup', $attemptgrade, '+window.screen.height+', '+window.screen.width+', '', $windowoptions, true);
                        $attempt->attempt = link_to_popup_window ("/mod/quiz/review.php?q=$quiz->id&amp;attempt=$attempt->id", 'quizpopup', "#$attempt->attempt", '+window.screen.height+', '+window.screen.width+', '', $windowoptions, true);
                    } else {
                        $attemptmark = "<a href=\"review.php?q=$quiz->id&amp;attempt=$attempt->id\">".round($attempt->sumgrades,$quiz->decimalpoints).'</a>';
                        $attemptgrade = "<a href=\"review.php?q=$quiz->id&amp;attempt=$attempt->id\">$attemptgrade</a>";
                        $attempt->attempt = "<a href=\"review.php?q=$quiz->id&amp;attempt=$attempt->id\">#$attempt->attempt</a>";
                    }
                }

                if ($quiz->grade <> $quiz->sumgrades) {
                    $table->data[] = array( $attempt->attempt,
                                            $timetaken,
                                            $datecompleted,
                                            $attemptmark, $attemptgrade);
                } else {
                    $table->data[] = array( $attempt->attempt,
                                            $timetaken,
                                            $datecompleted,
                                            $attemptgrade);
                }
            } else {  // No grades are being used
                if (quiz_review_allowed($quiz)) {
                    if($attempt->timefinish > 0) {
                        $attempt->attempt = "<a href=\"review.php?q=$quiz->id&amp;attempt=$attempt->id\">#$attempt->attempt</a>";
                    } else {
                        $attempt->attempt = "<a href=\"attempt.php?id=$id\">#$attempt->attempt</a>";
                    }
                }
                $table->data[] = array( $attempt->attempt,
                                        $timetaken,
                                        $datecompleted);
            }
        }
        print_table($table);
    }
*/
    if (!$quiz->questions) {
        mfm_print_heading(mfm_get_string("noquestions", "quiz"));
    } else {
        if ($numattempts < $quiz->attempts or !$quiz->attempts) {
          
            if ($available) {
                $options["id"] = $cm->id;
                //if overall stats are allowed (no attemps' grade not visible),
                //and there is at least one attempt, and quiz->grade:
                if ($overallstats and $numattempts and $quiz->grade) {
                    mfm_print_heading("$strbestgrade: $mygrade / $quiz->grade.");
                }
                $strconfirmstartattempt = addslashes(mfm_get_string("confirmstartattempt","quiz"));
                echo "<br />";
                echo "</p>";
                $buttontext = ($numattempts) ? mfm_get_string('reattemptquiz', 'quiz') : mfm_get_string('attemptquiznow', 'quiz');
                $buttontext = ($unfinished) ? mfm_get_string('continueattemptquiz', 'quiz') : $buttontext;
                if ($quiz->delay1 or $quiz->delay2) {
                     //quiz enforced time delay
                     $lastattempt_obj = get_record_select('quiz_attempts', "quiz = $quiz->id AND attempt = $numattempts AND userid = $USER->id", 'timefinish');
                     if ($lastattempt_obj) {
                         $lastattempt = $lastattempt_obj->timefinish;
                     }
                     if($numattempts == 1 && $quiz->delay1) {
                         if ($timenow - $quiz->delay1 > $lastattempt) {
                              print_attempt_button($cm->id, $buttontext);
                         }
                         else {
                             $notify_msg = get_string('temporaryblocked', 'quiz') . '<b>'. userdate($lastattempt + $quiz->delay1). '<b>';
                             mfm_notify($notify_msg);
                         }
                     }
                     else if($numattempts > 1 && $quiz->delay2) {
                         if ($timenow - $quiz->delay2 > $lastattempt) {
                              print_attempt_button($cm->id, $buttontext);
                         }
                         else {
                              $notify_msg = get_string('temporaryblocked', 'quiz') . '<b>'. userdate($lastattempt + $quiz->delay2). '<b>';
                              mfm_notify($notify_msg);
                         }
                     }
                     else {
                        print_attempt_button($cm->id, $buttontext);
                     }
                }
                else {
                    print_attempt_button($cm->id, $buttontext);
               }      
            }
        } else {
            mfm_print_heading(mfm_get_string("nomoreattempts", "quiz"));
            //if $quiz->grade and $quiz->sumgrades, and student is allowed to 
            //see summary statistics (no attempt's grade is concealed),
            //show the student their final grade
            if ($quiz->grade and $quiz->sumgrades and $overallstats) {
                mfm_print_heading(mfm_get_string("yourfinalgradeis", "quiz", "$mygrade / $quiz->grade"));
            }
            if ($gradebookfeedback) {
                mfm_print_heading(get_string('comment', 'quiz'), '', 3);
                echo '<p>'.$gradebookfeedback.'</p>';
            }
            mfm_print_continue('../../course/view.php?id='.$course->id);
        }
    }
// Finish the page
   mfm_print_footer($course);
   function print_attempt_button($cmid, $buttontext){
        echo '<center>';
        mfm_print_single_button("attempt.php", array('id'=>$cmid),$buttontext) ;
        echo '</center>';
   }


die();
?>
