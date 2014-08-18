<?php // $Id: format.php,v 1.13 2008/03/18 04:44:09 jamiesensei Exp $
      // Display the whole course as "topics" made of of modules
      // In fact, this is very similar to the "weeks" format, in that
      // each "topic" is actually a week.  The main difference is that
      // the dates aren't printed - it's just an aesthetic thing for
      // courses that aren't so rigidly defined by time.
      // Included from "view.php"
    $topic = optional_param('topic', -1, PARAM_INT);

    if ($topic != -1) {
        $displaysection = course_set_display($course->id, $topic);
    } else {
        if (isset($USER->display[$course->id])) {       // for admins, mostly
            $displaysection = $USER->display[$course->id];
        } else {
            $displaysection = course_set_display($course->id, 0);
        }
    }

    $context = get_context_instance(CONTEXT_COURSE, $course->id);

    mfm_print_heading_block(mfm_get_string('topicoutline'), 'outline');


/// Print Section 0

    $section = 0;
    $thissection = $sections[$section];

    if (!empty($thissection->mfmvisible) &&($thissection->summary or $thissection->sequence or isediting($course->id))) {
        $summaryformatoptions->noclean = true;
        echo format_text($thissection->summary, FORMAT_HTML, $summaryformatoptions).'<br>';

        mfm_print_section($course, $thissection, $mods, $modnamesused);
        echo '<hr width="60%">';

    }


/// Now all the normal modules by topic
/// Everything below uses "section" terminology - each "section" is a topic.

    $timenow = time();
    $section = 1;
    $sectionmenu = array();

    while ($section <= $course->numsections) {

        if (!empty($sections[$section])) {
            $thissection = $sections[$section];

        } else {
            unset($thissection);
            $thissection->course = $course->id;   // Create a new section structure
            $thissection->section = $section;
            $thissection->summary = '';
            $thissection->visible = 1;
            if (!$thissection->id = insert_record('course_sections', $thissection)) {
                mfm_notify('Error inserting new topic!');
            }
        }

        $showsection = (!empty($thissection->mfmvisible) &&(has_capability('moodle/course:viewhiddensections', $context)
                                     or $thissection->visible or !$course->hiddensections));

        if (!empty($displaysection) and $displaysection != $section) {
            if ($showsection) {
                $strsummary = strip_tags(format_string($thissection->summary,true));
                if (strlen($strsummary) < 57) {
                    $strsummary = ' - '.$strsummary;
                } else {
                    $strsummary = ' - '.substr($strsummary, 0, 60).'...';
                }
                $sectionmenu['topic='.$section] = s($section);
            }
            $section++;
            continue;
        }

        if ($showsection) {

            if ($displaysection == $section) {      // Show the zoom boxes
                echo '<a href="view.php?id='.$course->id.'&amp;topic=0#section-'.$section.'">'.
                     '<img align="right" src="'.$CFG->pixpath.'/i/all.gif" height="25" width="16" border="0" /></a>';
            } else {
                $strshowonlytopic = mfm_get_string('showonlytopic', '', $section);
                echo '<a href="view.php?id='.$course->id.'&amp;topic='.$section.'">'.
                     '<img align="right" src="'.$CFG->pixpath.'/i/one.gif" height="16" width="16" border="0" /></a>';
            }
            $currenttopic = ($course->marker == $section);

            if (!has_capability('moodle/course:viewhiddensections', $context) and !$thissection->visible) {   // Hidden for students
                echo mfm_get_string('notavailable');
            } else {
                $summaryformatoptions->noclean = true;
                echo format_text($thissection->summary, FORMAT_HTML, $summaryformatoptions).'<br>';
                mfm_print_section($course, $thissection, $mods, $modnamesused);
            }
            echo '<hr width="60%">';


        }

        $section++;
    }

    if (count($sectionmenu)>1) {
        echo mfm_popup_form($CFG->wwwroot.'/course/view.php?id='.$course->id.'&', $sectionmenu,
                   'sectionmenu', '', mfm_get_string('jumpto'), '', '', true);
    }


?>
