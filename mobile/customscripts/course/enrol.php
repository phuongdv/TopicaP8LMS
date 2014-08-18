<?php // $Id: enrol.php,v 1.12 2008/02/08 03:05:32 jamiesensei Exp $
      // Depending on the current enrolment method, this page 
      // presents the user with whatever they need to know when 
      // they try to enrol in a course.

    mfm_setup();
    require_once("$CFG->mfm_dirroot/course/lib.php");
    require_once("$CFG->mfm_dirroot/enrol/enrol.class.php");
    
    $id           = required_param('id', PARAM_INT);
    $loginasguest = optional_param('loginasguest', 0, PARAM_BOOL);
    
    if (!isloggedin()) {
        $wwwroot = $CFG->wwwroot;
        if (!empty($CFG->loginhttps)) {
            $wwwroot = str_replace('http:','https:', $wwwroot);
        }
        // do not use require_login here because we are usually comming from it
        mfm_redirect($wwwroot.'/login/index.php');
    }
    
    if (! $course = get_record("course", "id", $id) ) {
        mfm_error("That's an invalid course id");
    }

    if (! $context = get_context_instance(CONTEXT_COURSE, $course->id) ) {
        mfm_error("That's an invalid course id");
    }



/// do not use when in course login as
    if (!empty($USER->realuser) and $USER->loginascontext->contextlevel == CONTEXT_COURSE) {
        mfm_print_error('loginasnoenrol', '', $CFG->wwwroot.'/course/view.php?id='.$USER->loginascontext->instanceid);
    }

    $enrol = enrolment_factory::factory($course->enrol); // do not use if (!$enrol... here, it can not work in PHP4 - see MDL-7529

/// Refreshing all current role assignments for the current user

    load_all_capabilities();

/// Double check just in case they are actually enrolled already 
/// This might occur if they were enrolled during this session

    if (has_capability('moodle/course:view', $context) and !has_capability('moodle/legacy:guest', $context, NULL, false)) {
        if ($SESSION->wantsurl) {
            $destination = $SESSION->wantsurl;
            unset($SESSION->wantsurl);
        } else {
            $destination = "$CFG->wwwroot/course/view.php?id=$course->id";
        }

        mfm_redirect($destination);
    }
/// Check if the course is a meta course
    if ($course->metacourse) {
        mfm_print_header_simple();
        mfm_notice(mfm_get_string('coursenotaccessible'), "$CFG->wwwroot/index.php");
    }
    
/// Users can't enroll to site course
    if ($course->id == SITEID) {
        mfm_print_header_simple();
        mfm_notice(mfm_get_string('enrollfirst'), $CFG->wwwroot);
    }

/// Double check just in case they are enrolled to start in the future 

    if ($course->enrolperiod) {   // Only active if the course has an enrolment period in effect
        if ($roles = get_user_roles($context, $USER->id)) {
            foreach ($roles as $role) {
                if ($role->timestart and ($role->timestart >= time())) {
                    $message = get_string('enrolmentnotyet', '', userdate($student->timestart));
                    mfm_print_header();
                    mfm_notice($message, "$CFG->wwwroot/index.php");
                }
            }
        }
    }

/// Check if the course is enrollable
    if (!method_exists($enrol, 'print_entry')) {
        mfm_print_header_simple();
        mfm_notice(get_string('enrolmentnointernal'), $CFG->wwwroot);
    }
    if (!$course->enrollable ||
            ($course->enrollable == 2 && $course->enrolstartdate > 0 && $course->enrolstartdate > time()) ||
            ($course->enrollable == 2 && $course->enrolenddate > 0 && $course->enrolenddate <= time())
            ) {
        mfm_print_header_simple();
        mfm_notice(mfm_get_string('notenrollable'), $CFG->wwwroot);
    }

/// Check the submitted enrollment key if there is one

    if ($form = data_submitted()) {
        $enrol->check_entry($form, $course);
    }

    $enrol->print_entry($course);
/// Easy!
    die();

?>
