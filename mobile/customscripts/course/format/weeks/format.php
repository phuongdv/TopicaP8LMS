<?php // $Id: format.php,v 1.12 2008/02/06 09:28:37 jamiesensei Exp $
      // Display the whole course as "weeks" made of of modules
      // Included from "view.php"



    $week = optional_param('week', -1, PARAM_INT);


    $stradd          = mfm_get_string('add');
    $stractivities   = mfm_get_string('activities');
    $strshowallweeks = mfm_get_string('showallweeks');
    $strweek         = mfm_get_string('week');

    mfm_print_heading_block(mfm_get_string('weeklyoutline'), 'outline');

/// Print Section 0 with general activities

    $section = 0;
    $thissection = $sections[$section];

    if (!empty($thissection->mfmvisible) &&($thissection->summary or $thissection->sequence or isediting($course->id))) {
        $summaryformatoptions->noclean = true;
        echo format_text($thissection->summary, FORMAT_HTML, $summaryformatoptions);

        mfm_print_section($course, $thissection, $mods, $modnamesused);
        echo '<hr width="60%">';

    }


/// Now all the normal modules by week
/// Everything below uses "section" terminology - each "section" is a week.

    $timenow = time();
    $weekdate = $course->startdate;    // this should be 0:00 Monday of that week
    $weekdate += 7200;                 // Add two hours to avoid possible DST problems
    $section = 1;
    $sectionmenu = array();
    $weekofseconds = 604800;
    $course->enddate = $course->startdate + ($weekofseconds * $course->numsections);

    $strftimedateshort = ' '.mfm_get_string('strftimedateshort');

    if ($week != -1) {
        $displaysection = course_set_display($course->id, $week);
    } else {
        if (isset($USER->display[$course->id])) {
            $displaysection = $USER->display[$course->id];
        } else {
            //display only current week
            $thisweek=ceil(($course->startdate - $timenow)/ $weekofseconds); 
            if (empty($sections[$thisweek])|| empty($sections[$thisweek]->mfmvisible)){
                $thisweek=0;//display all weeks if there is no section for the current week
            }
            $displaysection = course_set_display($course->id, $thisweek);
        }
    }
    
    while ($weekdate < $course->enddate) {

        $nextweekdate = $weekdate + ($weekofseconds);
        $weekday = userdate($weekdate, $strftimedateshort);
        $endweekday = userdate($weekdate+518400, $strftimedateshort);

        if (!empty($sections[$section])) {
            $thissection = $sections[$section];

        } else {
            unset($thissection);
            $thissection->course = $course->id;   // Create a new week structure
            $thissection->section = $section;
            $thissection->summary = '';
            $thissection->visible = 1;
            if (!$thissection->id = insert_record('course_sections', $thissection)) {
                mfm_notify('Error inserting new week!');
            }
        }
        
        $context = get_context_instance(CONTEXT_COURSE, $course->id);

        $showsection = (!empty($thissection->mfmvisible) &&((has_capability('moodle/course:viewhiddensections', $context) or $thissection->visible or !$course->hiddensections)));

        if (!empty($displaysection) and $showsection) {
            $sectionmenu['week='.$section] = s("$strweek $section");
        }
        if (!empty($displaysection) and $displaysection != $section) {  // Check this week is visible
            $section++;
            $weekdate = $nextweekdate;
            continue;
        }

        if ($showsection) {

            $currentweek = (($weekdate <= $timenow) && ($timenow < $nextweekdate));

            if ($displaysection == $section) {
                echo '<a href="view.php?id='.$course->id.'&amp;week=0" >'.
                     '<img align="right" src="'.$CFG->pixpath.'/i/all.gif" height="25" width="16" border="0" /></a>';
            } else {
                $strshowonlyweek = mfm_get_string("showonlyweek", "", $section);
                echo '<a href="view.php?id='.$course->id.'&amp;week='.$section.'" >'.
                     '<img align="right" src="'.$CFG->pixpath.'/i/one.gif" height="16" width="16" border="0" /></a>';
            }

            if (!has_capability('moodle/course:viewhiddensections', $context) and !$thissection->visible) {   // Hidden for students
                echo $weekday.' - '.$endweekday.' ('.mfm_get_string('notavailable').')<br>';

            } else {
                echo $weekday.' - '.$endweekday.'<br>';

                $summaryformatoptions->noclean = true;
                echo format_text($thissection->summary, FORMAT_HTML, $summaryformatoptions);

                mfm_print_section($course, $thissection, $mods, $modnamesused);

            }

            echo '<hr width="60%">';

        }

        $section++;
        $weekdate = $nextweekdate;
    }

    if (count($sectionmenu)>1) {
        echo mfm_popup_form($CFG->wwwroot.'/course/view.php?id='.$course->id.'&amp;', $sectionmenu,
                   'sectionmenu', 'week='.$displaysection, mfm_get_string('jumpto'), '', '', true);
    }


?>
