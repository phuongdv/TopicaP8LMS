<?php  // $Id: questiontype.php,v 1.5 2008/02/07 05:35:02 jamiesensei Exp $

/////////////
/// MATCH ///
/////////////

/// QUESTION TYPE CLASS //////////////////
class mfm_question_match_qtype extends question_match_qtype {

    function print_question(&$question, &$state, $number, $cmoptions, $options) {
        //just call mfm_print_question which is common to all questions in mfm
        //this is defined in ../questiontype.php
        mfm_print_question($this, $question, $state, $number, $cmoptions, $options);
    }
    function print_question_formulation_and_controls(&$question, &$state, $cmoptions, $options) {
        global $CFG;
        $subquestions   = $state->options->subquestions;
        $correctanswers = $this->get_correct_responses($question, $state);
        $nameprefix     = $question->name_prefix;
        $answers        = array();
        $responses      = &$state->responses;

        $formatoptions->noclean = true;
        $formatoptions->para = false;


        foreach ($subquestions as $subquestion) {
            foreach ($subquestion->options->answers as $ans) {
                $answers[$ans->id] = $ans->answer;
            }
        }

        // Shuffle the answers
        $answers = draw_rand_array($answers, count($answers));

        
        // Print formulation
        $questiontext = format_text($question->questiontext,
                         $question->questiontextformat,
                         $formatoptions, $cmoptions->course);
        //$image = get_question_image($question, $cmoptions->course);
        
        ///// Print the input controls //////
        foreach ($subquestions as $key => $subquestion) {
            /// Subquestion text:
            $a->text = format_text($subquestion->questiontext,
                $question->questiontextformat, $formatoptions, $cmoptions->course);

            /// Drop-down list:
            $menuname = $nameprefix.$subquestion->id;
/*            // below was needed for mobile phones %25 is the code for %
            $menuname = str_replace('%', '%25', $menuname);*/
            $response = isset($state->responses[$subquestion->id])
                        ? $state->responses[$subquestion->id] : '0';
            if ($options->correct_responses
                and isset($correctanswers[$subquestion->id])
                and ($correctanswers[$subquestion->id] == $response)) {
                $mark='<img src="'.$CFG->mfm_wwwroot .'/pix/correct.gif" />';
            } elseif ($options->correct_responses
                and isset($correctanswers[$subquestion->id])) {
                $mark = '<img src="'.$CFG->mfm_wwwroot .'/pix/wrong.gif" />';
            }else {
                $mark ='';
            }
            
            if ($options->readonly) {
                $a->control =  ' -> '.($response ? $answers[$response] :'');
                    
                
            } else
            {
                $a->control = choose_from_menu($answers, $menuname, $response, 'choose', '', 0,
                 true, $options->readonly);
            }

            // Neither the editing interface or the database allow to provide
            // fedback for this question type.
            // However (as was pointed out in bug bug 3294) the randomsamatch
            // type which reuses this method can have feedback defined for
            // the wrapped shortanswer questions.
//            if ($options->feedback
//             && !empty($subquestion->options->answers[$responses[$key]]->feedback)) {
//                print_comment($subquestion->options->answers[$responses[$key]]->feedback);
//            }
            $a->control .= $mark;
            $anss[] = clone($a);
        }
        include("$CFG->mfm_dirroot/question/type/match/display.html");
        
    }



}
//// END OF CLASS ////

//////////////////////////////////////////////////////////////////////////
//// INITIATION - Without this line the question type is not in use... ///
//////////////////////////////////////////////////////////////////////////
$QTYPES[MATCH]= new mfm_question_match_qtype();

?>
