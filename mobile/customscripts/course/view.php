<?php // $Id: view.php,v 1.12 2008/01/25 09:12:28 jamiesensei Exp $

//  Display the course home page.


    mfm_setup();

    require_once($CFG->mfm_dirroot.'/course/lib.php');

    $id          = optional_param('id', 0, PARAM_INT);

    $name        = optional_param('name', '', PARAM_RAW);

    $idnumber    = optional_param('idnumber', '', PARAM_RAW);

    if (empty($id) && empty($name) && empty($idnumber)) {
        mfm_error("Must specify course id, short name or idnumber");
    }

    if (!empty($name)) {
        if (! ($course = get_record('course', 'shortname', $name)) ) {
            mfm_error('Invalid short course name');
        }
    } else if (!empty($idnumber)) {
        if (! ($course = get_record('course', 'idnumber', $idnumber)) ) {
            mfm_error('Invalid course idnumber');
        }
    } else {
        if (! ($course = get_record('course', 'id', $id)) ) {
            mfm_error('Invalid course id');
        }
    }

    mfm_require_login($course->id);



    add_to_log($course->id, 'course', 'view', "view.php?id=$course->id", "$course->id");

    $course->format = clean_param($course->format, PARAM_ALPHA);
    if (!file_exists($CFG->dirroot.'/course/format/'.$course->format.'/format.php')) {
        $course->format = 'weeks';  // Default format is weeks
    }

   $USER->editing = false;

   $USER->studentview = false;


    $SESSION->fromdiscussion = $CFG->wwwroot .'/course/view.php?id='. $course->id;

    if ($course->id == SITEID) {      // This course is not a real course.
        mfm_redirect($CFG->wwwroot .'/');
    }

    $crumbtext = $course->shortname;

    mfm_print_header(strip_tags($course->fullname), $course->fullname, $crumbtext, '',
                 '',
                 true, '', mfm_user_login_string($SITE));


    mfm_get_all_mods($course->id, $mods, $modnames, $modnamesplural, $modnamesused);

    if (! $sections = get_all_sections($course->id)) {   // No sections found
        // Double-check to be extra sure
        if (! $section = get_record('course_sections', 'course', $course->id, 'section', 0)) {
            $section->course = $course->id;   // Create a default section.
            $section->section = 0;
            $section->visible = 1;
            $section->id = insert_record('course_sections', $section);
        }
        if (! $sections = get_all_sections($course->id) ) {      // Try again
            mfm_error('Error finding or creating section structures for this course');
        }
    }
    foreach($sections as $sectionno => $sectioniterator){
        if (!empty($sectioniterator->sequence)) {
    
            $sectionmods = explode(",", $sectioniterator->sequence);
    
            foreach ($sectionmods as $modnumber) {
                if (!empty($mods[$modnumber])) {
                    $sections[$sectionno]->mfmvisible=true;
                    break;   
                }else
                {
                    $sections[$sectionno]->mfmvisible=false;   
                    
                }
            }
        }
    }

    if (empty($course->modinfo)) {       // Course cache was never made
        rebuild_course_cache($course->id);
        if (! $course = get_record('course', 'id', $course->id) ) {
            mfm_error("That's an invalid course id");
        }
    }

    require($CFG->mfm_dirroot.'/course/format/'. $course->format .'/format.php');  // Include the actual course format

    mfm_print_footer(NULL, $course);
    exit;

?>
