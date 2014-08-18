<?PHP  // $Id: lib.php,v 1.5 2008/02/13 09:19:42 jamiesensei Exp $
class mfm_feedback_item_dropdownrated extends feedback_item_dropdownrated {
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
             echo trim($val->answertext) . ' ('.$val->value.') : ' . $val->answercount .'<br>';
          }
          $avg = number_format(($avg), 2, $sep_dec, $sep_thous);
          echo '<b>'.mfm_get_string('average', 'feedback').': '.$avg.'</b><br>';
       }
       return $itemnr;
    }
    
    function print_item($item, $value = false, $readonly = false){
       $lines = explode (FEEDBACK_DROPDOWN_LINE_SEP, stripslashes_safe($item->presentation));
       $requiredmark =  ($item->required == 1)?'<font color="red">*</font>':'';
    
       echo text_to_html(stripslashes_safe($item->name) . $requiredmark, true, false, false).'<br>';
       $index = 1;
       $selected = '';
       if($readonly){
          foreach($lines as $line){
             if($value == $index){
                $dropdown_value = explode(FEEDBACK_DROPDOWN_VALUE_SEP, $line);
                echo text_to_html($dropdown_value[1], true, false, false);
                break;
             }
             $index++;
          }
       } else {
          echo '<select name="'. $item->typ . '_' . $item->id . '">';
          echo '<option value="0">&nbsp;</option>';
          foreach($lines as $line){
             if($value == $index){
                $selected = 'selected="selected"';
             }else{
                $selected = '';
             }
             $dropdown_value = explode(FEEDBACK_DROPDOWN_VALUE_SEP, $line);
             echo '<option value="'. $index.'" '. $selected.'>'. clean_text('('.$dropdown_value[0].') '.$dropdown_value[1]).'</option>';
    
             $index++;
          }
          echo '</select>';
       }
    }
}
?>