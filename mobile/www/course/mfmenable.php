<?php // $Id

//  Keitai enables modules in a course

    require("../../../config.php");

    require_login();

    $sectionreturn = optional_param('sr', '', PARAM_INT);
    $enable = optional_param( 'enable',0,PARAM_INT );
    $disable = optional_param( 'disable',0,PARAM_INT );

    if (!empty($enable)){
        $cmid=$enable;
        $action='enable';
    } elseif (!empty($disable)){
        $cmid=$disable;
        $action='disable';
    } else
    {
        error('No action specified');
    };
   if (! $cm = get_record("course_modules", "id", $cmid)) {
        error("This course module doesn't exist");
    }

    if (! $course = get_record("course", "id", $cm->course)) {
        error("This course doesn't exist");
    }

    $context = get_context_instance(CONTEXT_COURSE, $course->id);
    if (!has_capability('moodle/course:manageactivities', $context)) {
        error("You don't have permission to enable activities for mobile phone access!");
    }
    switch ($action) {
        case "enable":

            $toinsert=new object();
            $toinsert->cmid=$cmid;
            $toinsert->timemodified=time();
            
            if (!insert_record('mfm_enable', $toinsert)){
                error('Couldn\'t insert record to enable this module for keitai display');
            }
            break;

        case "disable":
            if (!delete_records('mfm_enable', 'cmid', $cmid)){
                error('Couldn\'t delete record to disable this module for keitai display');
            }
            break;

        default:

    }


    if (!empty($SESSION->returnpage)) {
        $return = $SESSION->returnpage;
        unset($SESSION->returnpage);
        redirect($return);
    } else {
        redirect("$CFG->wwwroot/course/view.php?id=$course->id#section-$sectionreturn");
    }
    exit;
?>
