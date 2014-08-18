<?PHP  // $Id: lib.php,v 1.5 2008/03/18 04:20:49 jamiesensei Exp $

class mfm_feedback_item_radiorated extends feedback_item_radiorated {
    function print_analysed($item, $itemnr = 0, $groupid = false) {
    	global $CFG;
       $sep_dec = get_string('separator_decimal', 'feedback');
       if(substr($sep_dec, 0, 2) == '[['){
          $sep_dec = FEEDBACK_DECIMAL;
       }
       
       $sep_thous = get_string('separator_thousand', 'feedback');
       if(substr($sep_thous, 0, 2) == '[['){
          $sep_thous = FEEDBACK_THOUSAND;
       }
       $analysedItem = $this->get_analysed($item, $groupid);
       if($analysedItem) {
          $itemnr++;
          echo $itemnr . '.)&nbsp;' . $analysedItem[1].'<br>';
          $analysedVals = $analysedItem[2];
          $pixnr = 0;
          $avg = 0.0;
          foreach($analysedVals as $val) {
             /*
             if( function_exists("bcmod")) {
                $pix = $CFG->mfm_wwwroot.'/mod/feedback/pics/' . bcmod($pixnr, 10) . '.gif';
             }else {
                $pix = $CFG->mfm_wwwroot.'/mod/feedback/pics/0.gif';
             }
             $pixnr++;
             $pixwidth = intval($val->quotient * 100);
             */
             $avg += $val->avg;
             echo '<b>' . trim($val->answertext) . ' ('.$val->value.') :</b> ' . $val->answercount . '<br>';
          }
          $avg = number_format(($avg), 2, $sep_dec, $sep_thous);
          echo '<b>'.get_string('average', 'feedback').' : '.$avg.'</b>';
       }
       return $itemnr;
    }
    
    function print_item($item, $value = false, $readonly = false){
       $lines = explode (FEEDBACK_RADIO_LINE_SEP, stripslashes_safe($item->presentation));
       $requiredmark =  ($item->required == 1)?'<font color="red">*</font>':'';
        echo text_to_html(stripslashes_safe($item->name) . $requiredmark, true, false, false).'<br>';
       $index = 1;
       $checked = '';
       if($readonly){
          foreach($lines as $line){
             if($value == $index){
                $radio_value = explode(FEEDBACK_RADIORATED_VALUE_SEP, $line);
                echo text_to_html('('.$radio_value[0].') '.$radio_value[1], true, false, false).'<br>';
                break;
             }
             $index++;
          }
       } else {
          foreach($lines as $line){
             if($value == $index){
                $checked = 'checked="checked"';
             }else{
                $checked = '';
             }
             $radio_value = explode(FEEDBACK_RADIORATED_VALUE_SEP, $line);
             echo '<input type="radio" '.
                   'name="'.$item->typ. '_' . $item->id.'" '.
                   'value="'.$index.'" '.$checked.' />';
             echo text_to_html('('.$radio_value[0].') '.$radio_value[1], true, false, false).'<br>';
             $index++;
          }
          /*
          if($item->required == 1) {
             echo '<input type="hidden" name="'.$item->typ . '_' . $item->id.'" value="1" />';
          }
          */
       }
    }
}
?>