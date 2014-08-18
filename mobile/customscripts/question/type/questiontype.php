<?php

/**
* Prints the question including the number, grading details, content,
* feedback and interactions
*
* This function prints the question including the question number,
* grading details, content for the question, any feedback for the previously
* submitted responses and the interactions. The default implementation calls
* various other methods to print each of these parts and most question types
* will just override those methods.
* @todo Use CSS stylesheet
* @param object $question The question to be rendered. Question type
*                         specific information is included. The
*                         maximum possible grade is in ->maxgrade. The name
*                         prefix for any named elements is in ->name_prefix.
* @param object $state    The state to render the question in. The grading
*                         information is in ->grade, ->raw_grade and
*                         ->penalty. The current responses are in
*                         ->responses. This is an associative array (or the
*                         empty string or null in the case of no responses
*                         submitted). The last graded state is in
*                         ->last_graded (hence the most recently graded
*                         responses are in ->last_graded->responses). The
*                         question type specific information is also
*                         included.
* @param integer $number  The number for this question.
* @param object $cmoptions
* @param object $options  An object describing the rendering options.
*/
function mfm_print_question(&$questiontypeobj, &$question, &$state, $number, $cmoptions, $options) {
    /* The default implementation should work for most question types
    provided the member functions it calls are overridden where required.
    The layout is determined by the template question.html 
    */
    global $CFG;

    // For editing teachers print a link to an editing popup window
    /*$editlink = '';
    if (isteacheredit($cmoptions->course)) {
        $stredit = mfm_get_string('edit');
        $linktext = '<img src="'.$CFG->pixpath.'/t/edit.gif" border="0" alt="'.$stredit.'" />';
        $editlink = link_to_popup_window('/question/question.php?id='.$question->id, $stredit, $linktext, 450, 550, $stredit, '', true);
    }*/

    $grade = '';
    if ($question->maxgrade and $options->scores) {
        if ($cmoptions->optionflags & QUESTION_ADAPTIVE) {
            $grade = (!$state->last_graded->event == QUESTION_EVENTGRADE) ? '--/' : round($state->last_graded->grade, $cmoptions->decimalpoints).'/';
        }
        $grade .= $question->maxgrade;
    }

/*    $history = '';
    if(isset($options->history) and $options->history) {
        if ($options->history == 'all') {
            // show all states
            $states = get_records_select('question_states', "attempt = '$state->attempt' AND question = '$question->id' AND event > '0'", 'seq_number DESC');
        } else {
            // show only graded states
            $states = get_records_select('question_states', "attempt = '$state->attempt' AND question = '$question->id' AND event = '".QUESTION_EVENTGRADE."'", 'seq_number DESC');
        }
        if (count($states) > 1) {
            $strreviewquestion = mfm_get_string('reviewresponse', 'quiz');
            unset($table);
            $table->head  = array (
                mfm_get_string('numberabbr', 'quiz'),
                mfm_get_string('action', 'quiz'),
                mfm_get_string('response', 'quiz'),
                mfm_get_string('time'),
                mfm_get_string('score', 'quiz'),
                mfm_get_string('penalty', 'quiz'),
                mfm_get_string('grade', 'quiz'),
            );
            $table->align = array ('center', 'center', 'left', 'left', 'left', 'left', 'left');
            $table->size = array ('', '', '', '', '', '', '');
            $table->width = '100%';
            foreach ($states as $st) {
                $b = ($state->id == $st->id) ? '<b>' : '';
                $be = ($state->id == $st->id) ? '</b>' : '';
                $table->data[] = array (
                    ($state->id == $st->id) ? '<b>'.$st->seq_number.'</b>' : link_to_popup_window ('/question/reviewquestion.php?state='.$st->id.'&amp;number='.$number, 'reviewquestion', $st->seq_number, 450, 650, $strreviewquestion, 'none', true),
                    $b.mfm_get_string('event'.$st->event, 'quiz').$be,
                    $b.$questiontypeobj->response_summary($st).$be,
                    $b.userdate($st->timestamp, mfm_get_string('timestr', 'quiz')).$be,
                    $b.round($st->raw_grade, $cmoptions->decimalpoints).$be,
                    $b.round($st->penalty, $cmoptions->decimalpoints).$be,
                    $b.round($st->grade, $cmoptions->decimalpoints).$be
                );
            }
            $history = make_table($table);
        }
    }*/
    include "$CFG->mfm_dirroot/question/type/question.html";
}


/**
* Loads the questiontype.php file for each question type
*
* These files in turn instantiate the corresponding question type class
* and adds it to the $QTYPES array
*/
function mfm_quiz_load_questiontypes() {
    global $QTYPES;
    global $CFG;
    $qtypenames= get_list_of_plugins('question/type','',$CFG->mfm_dirroot);
    foreach($qtypenames as $qtypename) {
        // Instanciates all plug-in question types
        $qtypefilepath= $CFG->mfm_dirroot."/question/type/$qtypename/questiontype.php";

        //echo "Loading $qtypename from $qtypefilepath<br>"; // Uncomment for debugging
        if (is_readable($qtypefilepath)) {
            require_once($qtypefilepath);
            //echo "Success<br>"; // Uncomment for debugging
        }
    }
}
mfm_quiz_load_questiontypes();
