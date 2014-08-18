<?php // $Id: lib.php,v 1.9 2008/02/13 09:19:41 jamiesensei Exp $ 
class mfm_feedback_item_picture extends feedback_item_picture {
    /**
     * outputs HTML presenting the distribution of answers
     * 
     * Outputs HTML code to browser window, which shows
     * the distribution of answers to feedback item $item
     * 
     * @param object $item contains the item data (a record from prefix_feedback_item table)
     * @param integer $itemnr used for ordering items list for viewing
     * @param boolean $groupid 
     * @return integer 
     */
    function print_analysed($item, $itemnr = 0, $groupid = false)
    {
        global $CFG;
       $sep_dec = get_string('separator_decimal', 'feedback');
       if(substr($sep_dec, 0, 2) == '[['){
          $sep_dec = FEEDBACK_DECIMAL;
       }
       
       $sep_thous = get_string('separator_thousand', 'feedback');
       if(substr($sep_thous, 0, 2) == '[['){
          $sep_thous = FEEDBACK_THOUSAND;
       }
       $analysedItem = $this->get_analysed($item, $groupid); //compute the distribution of received answers        
        // do we have anlyzed items to show?
       if($analysedItem) {
          $itemnr++;
          echo $itemnr . '.)&nbsp;' . $analysedItem[1].'<br><br>';
          // outputs running index of item together with the question associated with the item
            $analysedVals = $analysedItem[2];
            $pixnr = 0; 
            // create suitably wide picture to present a horizontal bar proportional to the number of answers received
            foreach($analysedVals as $val) {
                if (function_exists("bcmod")) {
                    $pix = $CFG->mfm_wwwroot.'/mod/feedback/pics/' . bcmod($pixnr, 10) . '.gif'; // define the colour of the bar
                } else {
                    $pix = $CFG->mfm_wwwroot.'/mod/feedback/pics/0.gif';
                } 
                $pixnr++;
                $pixwidth = intval($val->quotient * 100);
                $quotient = number_format(($val->quotient * 100), 2, $sep_dec, $sep_thous);
                list($picname) = explode('.', trim($val->answertext)); //removing file name extension        
                // create HTML for a horizontal graph showing distribution of answers
                echo '<img src="' . $CFG->mfm_wwwroot . FEEDBACK_PICTURE_FILES . '/' . $picname . '.gif" />'.$picname.' <br>' 
                . '<img src="' . $pix . '" height="5" vspace="5" width="' . $pixwidth . '%" /><br>'
                 . $val->answercount . (($val->quotient > 0)?'&nbsp;(' . $quotient . '&nbsp;%)':'').'<br>';
            } 
        } 
        return $itemnr;
    } 
    
    /**
     * outputs HTML for picture item
     * 
     * Outputs HTML code to browser window showing the picture item,
     * item may have already a $value (a sumitted form has been received), and
     * it is possible to show only the selected picture ($readonly=true)
     * 
     * Radio button values are numbered starting from 1 ($index)
     * 
     * @param object $item contains the item data (a record from prefix_feedback_item table)
     * @param integer $value gives the index to the selected picture (if any)
     * @param boolean $readonly if true, only the selected picture is shown
     */
    function print_item($item, $value = false, $readonly = false)
    {
        global $CFG;
        global $SESSION;
    
        $presentation = explode ("|", $item->presentation);
        $requiredmark = ($item->required == 1)?'<font color="red">*</font>':'';
        echo text_to_html(stripslashes_safe($item->name) . $requiredmark, true, false, false).'<br>';
        $index = 1;
        $checked = '';
        if ($readonly) {
            // here we want to show the selected picture only, $value must be provided
            // this is used by feedback/show_entries.php, for example
            foreach($presentation as $pic) {
                if ($value == $index) {
        	        list($picname) = explode('.', $pic); //removing file name extension        
       
                    echo '<img vspace="5" src="' . $CFG->mfm_wwwroot . FEEDBACK_PICTURE_FILES . '/' . $picname . '.gif" /><br clear="all">';
                    break;
                } 
                $index++;
            } 
        } else {
            // this is what we want most of the time, to show the picture item so that answering is possible
            // item may have already a value, after a failed saving attempt, say)
            $currentpic = 0;
            $piccount = count($presentation);
    
            foreach($presentation as $pic) {
                // do we have somehting already selected?
                if ($value == $index) {
                    $checked = 'checked="checked"';
                } else {
                    $checked = '';
                } 
                // generate the HTML for the item
                list($picname) = explode('.', $pic); //removing file name extension        
                 echo '<input type="radio" '.
                       'name="'.$item->typ. '_' . $item->id.'" '.
                       'value="'.$index.'" '.$checked.' />';
                echo '<img vspace="5" src="' . $CFG->mfm_wwwroot . FEEDBACK_PICTURE_FILES . '/' . $picname . '.gif" />'.$picname.'<br clear="all">';
                $currentpic++;
                $index++;
            } 
        } 
    } 
}
?>
