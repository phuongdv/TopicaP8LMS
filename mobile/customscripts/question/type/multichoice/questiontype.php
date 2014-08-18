<?php  // $Id: questiontype.php,v 1.4 2006/06/22 08:00:11 jamiesensei Exp $

///////////////////
/// MULTICHOICE ///
///////////////////

/// QUESTION TYPE CLASS //////////////////

///
/// This class contains some special features in order to make the
/// question type embeddable within a multianswer (cloze) question
///

class mfm_question_multichoice_qtype extends question_multichoice_qtype {

    function print_question(&$question, &$state, $number, $cmoptions, $options) {
        //just call mfm_print_question which is common to all questions in mfm
        //this is defined in ../questiontype.php
        mfm_print_question($this, $question, $state, $number, $cmoptions, $options);
    }

    function print_question_formulation_and_controls(&$question, &$state, $cmoptions, $options) {

        global $CFG;
        $answers = &$question->options->answers;
        $correctanswers = $this->get_correct_responses($question, $state);
        $readonly = empty($options->readonly) ? '' : 'readonly="readonly"';

        $formatoptions = new stdClass;
        $formatoptions->noclean = true;
        $formatoptions->para = false;

        // Print formulation
        $questiontext =  format_text($question->questiontext,
                         $question->questiontextformat,
                         $formatoptions, $cmoptions->course);
        //$image = get_question_image($question, $cmoptions->course);    
        
        // Print input controls and alternatives
        $answerprompt = ($question->options->single) ? get_string('singleanswer', 'quiz') :
            get_string('multipleanswers', 'quiz');

        // Print each answer in a separate row
        foreach ($state->options->order as $key => $aid) {
            $answer = &$answers[$aid];
            $qnumchar = chr(ord('a') + $key);

            if ($question->options->single) {
                $type = 'type="radio"';
                $name   = "name=\"{$question->name_prefix}\"";
                $checked = (isset($state->responses['']) and $aid == $state->responses[''])?'checked="checked"':'';
            } else {
                $type = ' type="checkbox" ';
                $name   = "name=\"{$question->name_prefix}{$aid}\"";
                $checked = isset($state->responses[$aid])
                     ? 'checked="checked"' : '';
            }
            $a->id   = $question->name_prefix . $aid;

            // Print the control
            // Print the control
            if (!$options->readonly){
                $a->control = "<input $name $checked $type value=\"$aid\" />";
            } else {
                $a->control =(!empty($checked))?'* ':'o ';
            }    
            
            // Print the text by the control highlighting if correct responses
            // should be shown and the current answer is the correct answer in
            // the single selection case or has a positive score in the multiple
            // selection case
            if ((($options->feedback && $question->options->single) || $options->readonly) &&!empty($checked)){
                if (is_array($correctanswers) && in_array($aid, $correctanswers)) {
                    $a->text= format_text("$qnumchar. $answer->answer", FORMAT_MOODLE ,
                         $formatoptions, $cmoptions->course) .
                          '<img src="'.$CFG->mfm_wwwroot .'/pix/correct.gif" />';
                } else {
                    $a->text= format_text("$qnumchar. $answer->answer", FORMAT_MOODLE,
                     $formatoptions, $cmoptions->course) . '<img src="'.$CFG->mfm_wwwroot .'/pix/wrong.gif" />';
                }
            } else {
                 $a->text= format_text("$qnumchar. $answer->answer", FORMAT_MOODLE,
                 $formatoptions, $cmoptions->course) ;
            }

            // Print feedback if feedback is on
            $a->feedback = (($options->feedback || $options->correct_responses) && $checked) ?
               $feedback = format_text($answer->feedback, true, $formatoptions, $cmoptions->course) : '';
            $anss[] = clone($a);

            

        }
        include("$CFG->mfm_dirroot/question/type/multichoice/display.html");
    }
}
//// END OF CLASS ////

//////////////////////////////////////////////////////////////////////////
//// INITIATION - Without this line the question type is not in use... ///
//////////////////////////////////////////////////////////////////////////
$QTYPES[MULTICHOICE]= new mfm_question_multichoice_qtype();

?>
