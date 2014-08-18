<?PHP  // $Id: lib.php,v 1.7 2008/02/13 09:19:41 jamiesensei Exp $
class mfm_feedback_item_check extends feedback_item_check {
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
          echo $itemnr . '.)&nbsp;' . $analysedItem[1].'<br><br>';
          $analysedVals = $analysedItem[2];
          $pixnr = 0;
          foreach($analysedVals as $val) {
             if( function_exists("bcmod")) {
                $pix = ($CFG->mfm_wwwroot).'/mod/feedback/pics/' . bcmod($pixnr, 10) . '.gif';
             }else {
                $pix = ($CFG->mfm_wwwroot).'/mod/feedback/pics/0.gif';
             }
             $pixnr++;
             $pixwidth = intval($val->quotient * 100);
             $quotient = number_format(($val->quotient * 100), 2, $sep_dec, $sep_thous);
             echo trim($val->answertext) . '<br><img src="'.$pix.'" height="5" vspace="5" width="'.$pixwidth.'%" /><br>' 
                . $val->answercount . (($val->quotient > 0)?'&nbsp;('. $quotient . ' %)':'').'<br>';
          }
       }
       return $itemnr;
    }
    
    function print_item($item, $value = false, $readonly = false){
       $presentation = explode ("|", stripslashes_safe($item->presentation));
       if (is_array($value)) {
          $values = $value;
       }else {
          $values = explode("|", $value);
       }
       $requiredmark =  ($item->required == 1)?'<font color="red">*</font>':'';
       echo text_to_html(stripslashes_safe($item->name) . $requiredmark, true, false, false).'<br>';
       $index = 1;
       $checked = '';
       if($readonly){
          foreach($presentation as $check){
             foreach($values as $val) {
                if($val == $index){
                   echo text_to_html($check . '<br>', true, false, false);
                   break;
                }
             }
             $index++;
          }
       } else {
          foreach($presentation as $check){
             foreach($values as $val) {
                if($val == $index){
                   $checked = 'checked="checked"';
                   break;
                }else{
                   $checked = '';
                }
             }
             echo '<input type="checkbox"
                   name="'.$item->typ. '_' . $item->id.'[]"
                   value="'.$index.'" '.$checked.' />';
             echo text_to_html($check, true, false, false).'<br>';
             $index++;
          }
       }
        echo '<input type="hidden" name="'.$item->typ. '_' . $item->id.'[]" value="" />';
    }
}
?>