<?PHP  // $Id: complete.php,v 1.13 2008/03/18 04:22:51 jamiesensei Exp $

/// This page prints a particular instance of a feedback form 
// and processes form input.

   mfm_setup();
   require_once("lib.php"); // lib.php in normal feedback mod
   require_once($CFG->mfm_dirroot.'/mod/feedback/lib.php'); // mfm lib.php

   $id=required_param('id', PARAM_INT);   

   $formdata = data_submitted('nomatch');
   //merge formdata with data saved in session
   if($formdata!==false){
     if(!$SESSION->feedback->is_started == true){
        mfm_error('Session error or you have pressed Submit button more than once by mistake. Detected when trying to save page feedback.', $CFG->wwwroot.'/course/view.php?id='.$course->id);
     }
     if (!isset($SESSION->feedback->formdata)){
        $SESSION->feedback->formdata=$formdata;
     } else {
        $merged=(object)array_merge((array)$SESSION->feedback->formdata, (array)$formdata);         
        $formdata=$SESSION->feedback->formdata=$merged;
        
     }
   }elseif (isset($SESSION->feedback->formdata)){
    unset ($SESSION->feedback->formdata);
   }
   $page=mfm_get_page_no(0);
  if (! $cm = get_record("course_modules", "id", $id)) {
     mfm_error("Course Module ID was incorrect");
  }

  if (! $course = get_record("course", "id", $cm->course)) {
     mfm_error("Course is misconfigured");
  }

  if (! $feedback = get_record("feedback", "id", $cm->instance)) {
     mfm_error("Course module is incorrect");
  }
   
/*      //nur wenn nicht anonym, dann require_login()
   if($feedback->anonymous != FEEDBACK_ANONYMOUS_YES) {
      mfm_require_login($course->id);
      if(isguest()){
         mfm_error(mfm_get_string('error'));
      }
   }*/
   
   if($feedback->anonymous != FEEDBACK_ANONYMOUS_YES) {
      mfm_require_login($course->id);
   } else {
      mfm_require_course_login($course);
   }

    $capabilities = feedback_load_capabilities($cm->id);
    
    if($feedback->anonymous == FEEDBACK_ANONYMOUS_YES) {
        $capabilities->complete = true;
    }
   
    if(!$capabilities->complete OR $capabilities->siteadmin) {
        mfm_error(mfm_get_string('error'));
    }

    /// Print the page header
    $strfeedbacks = get_string("modulenameplural", "feedback");
    $strfeedback  = get_string("modulename", "feedback");
    $buttontext = update_module_button($cm->id, $course->id, $strfeedback);
    
    $navlinks = array();
    $navlinks[] = array('name' => $strfeedbacks, 'link' => "index.php?id=$course->id", 'type' => 'activity');
    $navlinks[] = array('name' => format_string($feedback->name), 'link' => "", 'type' => 'activityinstance');
    
    $navigation = mfm_build_navigation($navlinks);
    mfm_print_header_simple(format_string($feedback->name), "", $navigation);    

   
  
   
   //additional check for multiple-submit (prevent browsers back-button). the main-check is in view.php

   $feedback_can_submit = true;
   if($feedback->multiple_submit == 0 ) {
      if($multiple_count = get_record('feedback_tracking', 'userid', $USER->id, 'feedback', $feedback->id)) {
         $feedback_can_submit = false;
      }
   }
   //get the feedbackitems
   $feedbackitems = get_records('feedback_item', 'feedback', $feedback->id, 'position');
    if (!$feedbackitems){
        mfm_error('No questions found in this feedback activity.', $CFG->wwwroot.'/course/view.php?id='.$course->id);
    }   
    $feedbackitemstoprint = array();
    $itemnr = 0;
    foreach($feedbackitems as $feedbackitem){
       if($feedbackitem->hasvalue == 1) {
          $itemnr++;
       }
       if ($itemnr==$page+1){
           $feedbackitemstoprint[] = $feedbackitem;
           $itempos = $feedbackitem->position;
       }
    }
   if($feedback_can_submit) {

      //saving the items
      if(isset($formdata->savevalues)){
         if(!$SESSION->feedback->is_started == true){
            mfm_error('Session error or you have pressed Submit button more than once by mistake. Detected when trying to save all pages.', $CFG->wwwroot.'/course/view.php?id='.$course->id);
         }
         //checken, ob alle required items einen wert haben
         if(feedback_check_values((array)$formdata, $itempos, $itempos)) {
            if($formdata->anonymous == FEEDBACK_ANONYMOUS_YES){
               $userid = 0;
            }else {
               $userid = $USER->id;
            }
            if($new_completed_id = feedback_save_values((array)$formdata, $userid)){
               $savereturn = 'saved';
               if($userid > 0) {
                  add_to_log($course->id, "feedback", "submit", "view.php?id=$cm->id", "$feedback->name");
                  feedback_email_teachers($cm, $feedback, $course, $userid);
               }else {
                  feedback_email_teachers_anonym($cm, $feedback, $course, $userid);
               }
               //tracking the submit
               $multiple_count = null;
               $multiple_count->userid = $USER->id;
               $multiple_count->feedback = $feedback->id;
               $multiple_count->completed = $new_completed_id;
               $multiple_count->count = 1;
               insert_record('feedback_tracking', $multiple_count);
               unset($SESSION->feedback->is_started);
               if (isset($SESSION->feedback->formdata)){
                unset($SESSION->feedback->formdata);
               }
               
            }else {
               $savereturn = 'failed';
            }
         }else {
            $savereturn = 'missing';
         }
      }
      
      
      $feedbackcompleted = get_record_select('feedback_completed','feedback='.$feedback->id.' AND userid='.$USER->id);
   
   /// Print the main part of the page
   ///////////////////////////////////////////////////////////////////////////
   ///////////////////////////////////////////////////////////////////////////
   ///////////////////////////////////////////////////////////////////////////
      mfm_print_heading($feedback->name);
      if(isset($savereturn) && $savereturn == 'saved') {
         echo '<p align="center"><b><font color="green">'.mfm_get_string('entries_saved','feedback').'</font></b></p>';
         if( intval($feedback->publish_stats) == 1) {
            echo '<p align="center"><a href="analysis.php?id=' . $id . '">';
            echo mfm_get_string('completed_feedbacks', 'feedback').'</a>';
            echo '</p>';
         }
         if($course->id == 1) {
            mfm_print_continue($CFG->wwwroot);
         } else {
            mfm_print_continue($CFG->wwwroot.'/course/view.php?id='.$course->id);
         }
      }else {
         if(isset($savereturn) && $savereturn == 'failed') {
            echo '<p align="center"><b><font color="red">'.mfm_get_string('saving_failed','feedback').'</font></b></p>';
            //mfm_print_continue('view.php?id='.$id);
         }
   
         if(isset($savereturn) && $savereturn == 'missing') {
            echo '<p align="center"><b><font color="red">'.mfm_get_string('saving_failed_because_missing_items','feedback').'</font></b></p>';
            //mfm_print_continue('view.php?id='.$id);
         }
   
         //Elemente ausgeben
         if(is_array($feedbackitemstoprint)){
            echo '<form name="frm" method="post" action="'.$CFG->wwwroot.'/mod/feedback/complete.php">';
            echo '<input type="hidden" name="sesskey" value="' . $USER->sesskey . '" />';
            switch ($feedback->anonymous) {
               //case FEEDBACK_ANONYMOUS_USER:
               //   echo '<tr><th colspan="3" align="center"><input type="checkbox" name="anonymous" value="1" checked="checked">&nbsp;'.mfm_get_string('anonymous', 'feedback').'</th></tr>';
               //   break;
               case FEEDBACK_ANONYMOUS_YES:
                  echo '<input type="hidden" name="anonymous" value="1" /><input type="hidden" name="anonymous_response" value="'.FEEDBACK_ANONYMOUS_YES.'" />'.mfm_get_string('anonymous', 'feedback');
                  break;
               case FEEDBACK_ANONYMOUS_NO:
                  echo '<input type="hidden" name="anonymous" value="0" /><input type="hidden" name="anonymous_response" value="'.FEEDBACK_ANONYMOUS_NO.'" />';
                  break;
            }
            //checken, ob required-elements existieren
            $countreq = count_records('feedback_item', 'feedback', $feedback->id, 'required', 1);
            if($countreq > 0) {
               echo '<font color="red">(*)' . mfm_get_string('items_are_required', 'feedback') . '</font>';
            }
            
            foreach($feedbackitemstoprint as $feedbackitem){
               $frmvaluename = $feedbackitem->typ . '_'. $feedbackitem->id;
               $value =  isset($formdata->{$frmvaluename})?$formdata->{$frmvaluename}:NULL;
               
               echo '<br>';
               if($feedbackitem->hasvalue == 1) {
                  echo $page+1 . '.)&nbsp;';
               }
               mfm_feedback_print_item($feedbackitem, $value);
               echo '<br>';
            }
            
            echo '<input type="hidden" name="id" value="'.$id.'" />';
            echo '<input type="hidden" name="feedbackid" value="'.$feedback->id.'" />';
            echo '<input type="hidden" name="completedid" value="'.(isset($feedbackcompleted->id)?$feedbackcompleted->id:'').'" />';
            echo '<input type="hidden" name="courseid" value="'.$course->id.'" />';
            $numpages=$itemnr;
            // Print the navigation panel if required
            if ($numpages > 1) {
                echo '<form action="'.$CFG->wwwroot.'/mod/feedback/analysis.php" method="POST" >';
                echo '<input type="hidden" name="id" value="'.$id."\" />\n";
                echo '<input type="hidden" id="page" name="page" value="'.$page."\" />\n";
                 
                // Print navigation panel
                echo "<br />\n";
                echo "<center>\n";
                if ($page < $numpages - 1) {
                    // Print next link
                    $strnext = mfm_get_string('next');
                    echo "<input type=\"submit\" name=\"pageno".($page + 1)."\" value=\"(" . $strnext.")\" />\n";
                }else
                {
                    echo '<center><input name="savevalues" type="submit" value="'.mfm_get_string('save_entries','feedback').'" /></center>';
                	
                }
                echo "</center>";
                echo "<br />\n";
                echo "<center>\n";
                if ($page > 0) {
                   // Print previous link
                   $strprev = mfm_get_string('previous');
                   echo '<input type="submit" name="pageno'.($page - 1).'" value="(' . $strprev.')" />'."\n";
                }
                for ($i = 0; $i < $numpages; $i++) {
                   if ($i == $page) {
                        echo ($i+1);
                   } else {
                        echo "<input type=\"submit\" name=\"pageno".$i."\" value=\"" . ($i+1)."\" />\n";
                   }
                }
            
                echo "</center>";
                echo "<br />\n";
            } else
            {
                echo '<center><input name="savevalues" type="submit" value="'.mfm_get_string('save_entries','feedback').'" /></center>';
            	
            }
            echo '</form>';
            
            if($course->id == 1) {
               echo '<form name="frm" action="'.$CFG->wwwroot.'" method="post" onsubmit=" ">';
            } else {
               echo '<form name="frm" action="'.$CFG->wwwroot.'/course/view.php?id='.$course->id.'" method="post" onsubmit=" ">';
            }
            echo '<input type="hidden" name="sesskey" value="' . $USER->sesskey . '" />';
            echo '<center><input type="submit" value="'.mfm_get_string('cancel').'" /></center>';
            echo '</form>';
            $SESSION->feedback->is_started = true;
         }
      }
   }else {
         echo '<h2><font color="red">'.mfm_get_string('this_feedback_is_already_submitted', 'feedback').'</font></h2>';
         mfm_print_continue($CFG->wwwroot.'/course/view.php?id='.$course->id);
   }
/// Finish the page
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////

   mfm_print_footer($course);
   die;

?>
