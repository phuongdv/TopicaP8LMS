<?PHP  //shows an analysed view of feedback

   mfm_setup();
   require_once("lib.php"); // lib.php in normal feedback mod
   require_once("$CFG->mfm_dirroot/mod/feedback/lib.php"); // mfm lib.php
 
   $id=required_param('id', PARAM_INT);   
   $formdata = data_submitted('nomatch');
   $page=mfm_get_page_no();
    $lstgroupid = optional_param('lstgroupid', -2, PARAM_INT); //groupid (aus der Listbox gewaehlt)

    //check, whether a group is selected
    if($lstgroupid == -1) {
        $SESSION->feedback->lstgroupid = false;
    }else {
        if((!isset($SESSION->feedback->lstgroupid)) || $lstgroupid != -2)
            $SESSION->feedback->lstgroupid = $lstgroupid;
    }

   if ($id) {
      if (! $cm = get_record("course_modules", "id", $id)) {
         mfm_error("Course Module ID was incorrect");
      }
    
      if (! $course = get_record("course", "id", $cm->course)) {
         mfm_error("Course is misconfigured");
      }
    
      if (! $feedback = get_record("feedback", "id", $cm->instance)) {
         mfm_error("Course module is incorrect");
      }
   }
   
    if(isset($SESSION->feedback->lstgroupid)) {
        if($tmpgroup = groups_get_group($SESSION->feedback->lstgroupid)) {
            if($tmpgroup->courseid != $course->id) {
                $SESSION->feedback->lstgroupid = false;
            }
        }else {
            $SESSION->feedback->lstgroupid = false;
        }
    }
    
   mfm_require_login($course->id);
   
   $capabilities = feedback_load_capabilities($cm->id);

   if( !( (intval($feedback->publish_stats) == 1)  || $capabilities->viewreports)) {
      mfm_error('You don\'t have access to the analysis of this activity\'s poll results.');
   }
   
/// Print the page header

   if ($course->category) {
      $navigation = "<a href=\"../../course/view.php?id=$course->id\">$course->shortname</a> ->";
   }

   $strfeedbacks = mfm_get_string("modulenameplural", "feedback");
   $strfeedback  = mfm_get_string("modulename", "feedback");

   mfm_print_header("$course->shortname: $feedback->name", "$course->fullname",
                "$navigation $feedback->name", 
                "", "", true, '', 
                '');

   mfm_print_heading($feedback->name);
      
   
   //analysierte Items ausgeben

   
   //get the groupid
   //lstgroupid is the choosen id
   $mygroupid = $SESSION->feedback->lstgroupid;

   //get completed feedbacks
   $completedscount = feedback_get_completeds_group_count($feedback, $mygroupid);
   
    //show the group, if available
    if($mygroupid and $group = get_record('groups', 'id', $mygroupid)) {
        echo '<b>'.get_string('group').': '.$group->name. '</b><br />';
    }
   //show the count
   echo '<b>'.mfm_get_string('completed_feedbacks', 'feedback').': '.$completedscount. '</b><br />';
   
   // get the items of the feedback
   $items = get_records_select('feedback_item', 'feedback = '. $feedback->id . ' AND hasvalue = 1', 'position');
   //show the count
   if(is_array($items)){
   	echo '<b>'.mfm_get_string('question', 'feedback').': '.($page+1).' / ' .sizeof($items). ' </b><hr />';
   } else {
	$items=array();
   }

   $itemnr = $page;
   //print the items in an analysed form
   //foreach($items as $item) {
      $items=array_values($items);
      $item=$items[$page];
      $feedback_item_class_name = 'mfm_feedback_item_'.$item->typ;
      $feedback_item_object = new $feedback_item_class_name();
      $itemnr = $feedback_item_object->print_analysed($item, $itemnr, $mygroupid);
      echo '<br>';
   //}
    $numpages=count($items);
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
        echo '</form>';
    }
        
   mfm_print_footer($course);
   die;

?>
