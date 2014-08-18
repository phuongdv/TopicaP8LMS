<?PHP  //
$mfm_feedback_names = mfm_feedback_load_feedback_items('mod/feedback/item');
//max. Breite des grafischen Balkens in der Auswertung

////////////////////////////////////////////////
//Funktionen zum Handling des Moduls
////////////////////////////////////////////////
///Items holen
function mfm_feedback_load_feedback_items($dir) {
    global $CFG;
   $names =get_list_of_plugins($dir, '', $CFG->mfm_dirroot);
   
   foreach($names as $name) {
      require_once($CFG->mfm_dirroot.'/'.$dir.'/'.$name.'/lib.php');
   }
   return $names;
}

//gibt ein feedbackitem aus
function mfm_feedback_create_template($item, $value = false, $readonly = false){
   if($readonly)$ro = 'readonly="readonly" disabled="disabled"';
      
   $classname = 'mfm_feedback_item_'.$item->typ;
   $obj = new $classname();
   $obj->print_item($item, $value, $readonly);
}

/**
 * prints errors from $SESSION->feedback->errors array and resets errors
 * from actionlib.php
 */
function mfm_feedback_print_errors() {
 
    global $SESSION;
        
    if(empty($SESSION->feedback->errors)) {
        return;
    }

    if($SESSION->feedback->debuglevel==FEEDBACK_ACTION_DEBUG_SILENT) {
        $SESSION->feedback->errors = array(); //just remove errors, no reporting
        return;
    }
    
    mfm_print_heading(mfm_get_string('handling_error', 'feedback'));

    if ($SESSION->feedback->debuglevel==FEEDBACK_ACTION_DEBUG_VERBOSE) {
        echo '<p align="center"><b><font color="black"><pre>';
        print_r($SESSION->feedback->errors) . "\n";
        echo '</pre></font></b></p>';
    }
    
    echo '<br><br>';
    $SESSION->feedback->errors = array(); //remove errors
} 
function mfm_feedback_print_item($item, $value = false, $readonly = false){
   if($readonly)$ro = 'readonly="readonly" disabled="disabled"';
      
   $classname = 'mfm_feedback_item_'.$item->typ;
   $obj = new $classname();
   $obj->print_item($item, $value, $readonly);
}
////////////////////////////////////////////////
////////////////////////////////////////////////
////////////////////////////////////////////////
//Handling der Values
////////////////////////////////////////////////
/*function tmp_save_feedback_values($data, $usrid, $tmpcompletedid=0)
{
   $timemodified = time();
   if(($usrid == 0)&&($tmpcompletedid==0)) {
      return create_feedback_values($data, $usrid, $timemodified);
   }
   if(!$completed = get_record('feedback_completed', 'id', $data['completedid'])){
      return create_feedback_values($data, $usrid, $timemodified);
   }else{
      $completed->timemodified = $timemodified;
      return update_feedback_values($data, $usrid, $completed);
   }
}*/


?>
