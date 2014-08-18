<?PHP  // 
   mfm_setup();
   require_once("lib.php"); // lib.php in normal feedback mod
   require_once("$CFG->mfm_dirroot/mod/feedback/lib.php"); // mfm lib.php

   $id=required_param('id', PARAM_INT);   
   $courseid = optional_param('courseid', false, PARAM_INT);

   if ($id) {
      if (! $cm = get_coursemodule_from_id('feedback', $id)) {
         mfm_error("Course Module ID was incorrect");
      }
    
      if (! $course = get_record("course", "id", $cm->course)) {
         mfm_error("Course is misconfigured");
      }
    
      if (! $feedback = get_record("feedback", "id", $cm->instance)) {
         mfm_error("Course module is incorrect");
      }
   }

    $capabilities = feedback_load_capabilities($cm->id);

    if($feedback->anonymous == FEEDBACK_ANONYMOUS_YES AND !$capabilities->edititems) {
        $capabilities->complete = true;
    }
    
    //check whether the feedback is located and! started from the mainsite
    if($course->id == SITEID AND !$courseid) {
        $courseid = SITEID;
    }
    
    if($feedback->anonymous != FEEDBACK_ANONYMOUS_YES) {
        require_login($course->id);
    } else {
        require_course_login($course);
    }

   if($feedback->anonymous == FEEDBACK_ANONYMOUS_NO) {
      add_to_log($course->id, "feedback", "view", "view.php?id=$cm->id", "$feedback->name", $cm->id);
   }

    /// Print the page header
    $strfeedbacks = get_string("modulenameplural", "feedback");
    $strfeedback  = get_string("modulename", "feedback");
    
    $navigation = mfm_build_navigation(array(), $cm);
    
    mfm_print_header_simple(format_string($feedback->name), "", $navigation);
    //ishidden check.
    if ((empty($cm->visible) and !$capabilities->viewhiddenactivities) AND $course->id != SITEID) {
        mfm_notice(get_string("activityiscurrentlyhidden"));
    }

/// Print the main part of the page
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
      mfm_print_heading($feedback->name);
      echo text_to_html($feedback->summary).'<br>';

    if($capabilities->edititems) {
        mfm_print_heading(get_string("page_after_submit", "feedback"), '', 4);
        // print_simple_box_start('center', '80%');
        echo format_text($feedback->page_after_submit);
    }
    
    if( (intval($feedback->publish_stats) == 1) AND !( $capabilities->viewreports) ) {
        if($multiple_count = count_records('feedback_tracking', 'userid', $USER->id, 'feedback', $feedback->id)) {
            echo '<center><a href="'.htmlspecialchars('analysis.php?id=' . $id . '&courseid='.$courseid).'">';
            echo mfm_get_string('completed_feedbacks', 'feedback').'</a>';
            echo '</center><br />';
        }
    }
    //####### completed-start
    if($capabilities->complete AND !$capabilities->edititems) {
        //check, whether the feedback is open (timeopen, timeclose)
        $checktime = time();
        if(($feedback->timeopen > $checktime) OR ($feedback->timeclose < $checktime AND $feedback->timeclose > 0)) {
            echo '<h2><font color="red">'.get_string('feedback_is_not_open', 'feedback').'</font></h2>';
            mfm_print_continue($CFG->wwwroot.'/course/view.php?id='.$course->id);
            mfm_print_footer($course);
            exit;
        }
        
        //check multiple Submit
        $feedback_can_submit = true;
        if($feedback->multiple_submit == 0 ) {
            if(feedback_is_already_submitted($feedback->id, $courseid)) {
                $feedback_can_submit = false;
            }
        }
        if($feedback_can_submit) {
            //if the user is not known so we cannot save the values temporarly
            if(!isset($USER->username) OR $USER->username == 'guest') {
                $completefile = 'complete_guest.php';
                $guestid = $USER->sesskey;
            }else {
                $completefile = 'complete.php';
                $guestid = false;
            }
            if($feedbackcompletedtmp = feedback_get_current_completed($feedback->id, true, $courseid, $guestid)) {
                if($startpage = feedback_get_page_to_continue($feedback->id, $courseid, $guestid)) {
                    echo '<a href="'.htmlspecialchars($completefile.'?id='.$id.'&gopage='.$startpage.'&courseid='.$courseid).'">'.get_string('continue_the_form', 'feedback').'</a>';
                }else {
                    echo '<a href="'.htmlspecialchars($completefile.'?id='.$id.'&gopage=0&courseid='.$courseid).'">'.get_string('continue_the_form', 'feedback').'</a>';
                }
            }else {
                echo '<a href="'.htmlspecialchars($completefile.'?id='.$id.'&gopage=0&courseid='.$courseid).'">'.get_string('complete_the_form', 'feedback').'</a>';
            }
        }else {
            echo '<h2><font color="red">'.get_string('this_feedback_is_already_submitted', 'feedback').'</font></h2>';
            if($courseid) {
                mfm_print_continue($CFG->wwwroot.'/course/view.php?id='.$courseid);
            }else {
                mfm_print_continue($CFG->wwwroot.'/course/view.php?id='.$course->id);
            }
        }
    }
/// Finish the page
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////

   mfm_print_footer($course);
   die;

?>
