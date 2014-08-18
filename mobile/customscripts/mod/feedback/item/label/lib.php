<?PHP  // $Id: lib.php,v 1.7 2008/02/13 09:19:41 jamiesensei Exp $
class mfm_feedback_item_label extends feedback_item_label {
    function print_item($item){
        echo stripslashes_safe($item->presentation).'<br>';
    }
}
?>