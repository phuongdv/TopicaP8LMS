<?PHP  // $Id: lib.php,v 1.8 2008/02/13 09:19:42 jamiesensei Exp $
class mfm_feedback_item_dropdown extends feedback_item_dropdown {
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
          foreach($analysedVals as $val) {
             if( function_exists("bcmod")) {
                $pix = $CFG->mfm_wwwroot.'/mod/feedback/pics/' . bcmod($pixnr, 10) . '.gif';
             }else {
                $pix = $CFG->mfm_wwwroot.'/mod/feedback/pics/0.gif';
             }
             $pixnr++;
             $pixwidth = intval($val->quotient * 100);
             $quotient = number_format(($val->quotient * 100), 2, $sep_dec, $sep_thous);
             echo trim($val->answertext) . '<br><img src="'.$pix.'" height="5" vspace="5" width="'.$pixwidth.'%" /><br>'
              . $val->answercount . (($val->quotient > 0)?'&nbsp;('. $quotient . '&nbsp;%)':'').'<br>';
          }
       }
       return $itemnr;
    }
    
    function print_item($item, $value = false, $readonly = false){
       $presentation = explode ("|", stripslashes_safe($item->presentation));
       $requiredmark =  ($item->required == 1)?'<font color="red">*</font>':'';
    
       echo text_to_html(stripslashes_safe($item->name) . $requiredmark, true, false, false).'<br>';
       $index = 1;
       $selected = '';
       if($readonly){
          foreach($presentation as $dropdown){
             if($value == $index){
                echo text_to_html($dropdown, true, false, false);
                break;
             }
             $index++;
          }
       } else {
        echo '<select name="'. $item->typ .'_' . $item->id.'">
             <option value="0">&nbsp;</option>';
          foreach($presentation as $dropdown){
             if($value == $index){
                $selected = 'selected="selected"';
             }else{
                $selected = '';
             }
         echo '<option value="'.$index.'" '.$selected.'>'
            .text_to_html($dropdown, true, false, false)
            .'</option>';
             $index++;
          }
          echo '</select>';
       }
    }
}
?>