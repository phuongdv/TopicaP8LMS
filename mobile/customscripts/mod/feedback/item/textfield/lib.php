<?PHP  // $Id: lib.php,v 1.8 2008/02/13 09:19:41 jamiesensei Exp $
class mfm_feedback_item_textfield extends feedback_item_textfield {
    function print_analysed($item, $itemnr = 0, $groupid = false) {
       $values = feedback_get_group_values($item, $groupid);
       $values=array_reverse($values);
       //last five values
       if (count($values)>5){
           $fullcount=count($values);
           $values=array_values($values); //convert to array starting at 0
           $values=array_splice($values, 0, 5);
           $truncated=true;
       }else
       {
        $truncated=false;
       }
       if($values) {
          //echo '<table>';2
          $itemnr++;
          echo $itemnr . '.) ' . stripslashes_safe($item->name).'<br>';
          if ($truncated){
            echo mfm_get_string('only_last_five','feedback', $fullcount).'<br>';
          }
          echo '<br>';
          foreach($values as $value) {
             echo '-'.str_replace("\n", '<br>', $value->value).'<br>';
          }
       }
       return $itemnr;
    }
    
    function print_item($item, $value = false, $readonly = false){
       $presentation = explode ("|", $item->presentation);
       $requiredmark =  ($item->required == 1)?'<font color="red">*</font>':'';
        echo text_to_html(stripslashes_safe($item->name) . $requiredmark, true, false, false).'<br>';
       if($readonly){
          echo $value?$value:'&nbsp;';
       }else {
          echo '<input type="text" name="'.$item->typ . '_' . $item->id.'" '.
                   'istyle="1" '.
                    'size="'.$presentation[0].'" '.
                   'maxlength="'. $presentation[1].'"' .
                   'value="'.($value?$value:'').'" />';
       }
    }
}

?>
