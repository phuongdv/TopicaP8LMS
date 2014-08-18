<?php  // $Id: lib.php,v 1.17 2008/02/06 09:28:36 jamiesensei Exp $
   // Library of useful functions


/**
 * Just gets a raw list of all modules in a course.
 * This function only lists mfm enabled activities.
 *
 * @uses $CFG
 * @param int $courseid The id of the course as found in the 'course' table.
 * @return object
 * @todo Finish documenting this function
 */
function mfm_get_course_mods($courseid) {
    global $CFG;

    return get_records_sql("SELECT cm.*, m.name as modname " .
                            "FROM {$CFG->prefix}modules m, " .
                            "{$CFG->prefix}course_modules cm, " .
                            "{$CFG->prefix}mfm_enable en " .
                            "WHERE cm.course = '$courseid' " .
                            "AND cm.module = m.id " .
                            "AND en.cmid=cm.id");
}



function mfm_get_all_mods($courseid, &$mods, &$modnames, &$modnamesplural, &$modnamesused) {
// Returns a number of useful structures for course displays
    global $CFG;
    $mods          = NULL;    // course modules indexed by id
    $modnames      = NULL;    // all course module names (except resource!)
    $modnamesplural= NULL;    // all course module names (plural form)
    $modnamesused  = NULL;    // course module names used

    if ($allmods = get_records("modules")) {
        foreach ($allmods as $mod) {
            if ($mod->visible) {
                $modnames[$mod->name] = mfm_get_string("modulename", "$mod->name");
                $modnamesplural[$mod->name] = mfm_get_string("modulenameplural", "$mod->name");
            }
        }
        asort($modnames);
    } else {
        mfm_error("No modules are installed!");
    }

    if ($rawmods = mfm_get_course_mods($courseid)) {
        foreach($rawmods as $mod) {    // Index the mods
            if (empty($modnames[$mod->modname])) {
                continue;
            }
            $mods[$mod->id] = $mod;
            $mods[$mod->id]->modfullname = $modnames[$mod->modname];
            if (!$mod->visible and !has_capability('moodle/course:viewhiddenactivities', get_context_instance(CONTEXT_COURSE, $courseid))) {
                continue;
            }
            // Check groupings
            if (!groups_course_module_visible($mod)) {
                continue;
            }
            $modnamesused[$mod->modname] = $modnames[$mod->modname];
        }
        if ($modnamesused) {
            asort($modnamesused, SORT_LOCALE_STRING);
        }
    }else {
        //this course has no mfm enabled activities
        //this must be because activities have been deleted but there 
        //course module and mfm_enable records are still there.
        execute_sql('DELETE FROM '. $CFG->prefix . 'mfm_enable en USING '
            . $CFG->prefix . 'course_module cm WHERE cm.id=en.cmid AND '.
            'cm.course='.$courseid.';', false);
    }

    unset($modnames['resource']);
    unset($modnames['label']);
}


function mfm_print_section($course, $section, $mods, $modnamesused, $absolute=false, $width="100%") {
/// Prints a section full of activity modules
    global $CFG, $USER;

    static $initialised;

    static $groupbuttons;
    static $groupbuttonslink;
    static $isediting;
    static $ismoving;
    static $strmovehere;
    static $strmovefull;
    static $strunreadpostsone;

    static $untracked;
    static $usetracking;

    $labelformatoptions = New stdClass;

    if (!isset($initialised)) {
        $groupbuttons     = ($course->groupmode or (!$course->groupmodeforce));
        $groupbuttonslink = (!$course->groupmodeforce);
        $isediting = isediting($course->id);
        $ismoving = $isediting && ismoving($course->id);
        if ($ismoving) {
            $strmovehere = mfm_get_string("movehere");
            $strmovefull = strip_tags(mfm_get_string("movefull", "", "'$USER->activitycopyname'"));
        }
        include_once($CFG->dirroot.'/mod/forum/lib.php');
        if ($usetracking = forum_tp_can_track_forums()) {
            $strunreadpostsone    = mfm_get_string('unreadpostsone', 'forum');
            $untracked = forum_tp_get_untracked_forums($USER->id, $course->id);
        }
        $initialised = true;
    }
    $labelformatoptions->noclean = true;

    $modinfo = unserialize($course->modinfo);

    if (!empty($section->sequence)) {

        $sectionmods = explode(",", $section->sequence);

        foreach ($sectionmods as $modnumber) {
            if (empty($mods[$modnumber])) {
                continue;
            }
            $mod = $mods[$modnumber];
            if (!coursemodule_visible_for_user($mod)) {
                // full visibility check
                continue;
            }
            $instancename = urldecode($modinfo[$modnumber]->name);
                $instancename = format_string($instancename, true,  $course->id);

            if (!empty($modinfo[$modnumber]->extra)) {
                $extra = urldecode($modinfo[$modnumber]->extra);
            } else {
                $extra = "";
            }

            if (!empty($modinfo[$modnumber]->icon)) {
                $icon = "$CFG->pixpath/".urldecode($modinfo[$modnumber]->icon);
            } else {
                $icon = "$CFG->modpixpath/$mod->modname/icon.gif";
            }

/*                if ($mod->indent) {
                    print_spacer(12, 20 * $mod->indent, false);
                }*/

            if ($mod->modname == "label") {
                echo format_text($extra, FORMAT_HTML, $labelformatoptions);
            } else { // Normal activity
                $linkcss = "";
                echo '<img src="'.$icon.'" />'.
                     ' <a href="'.$CFG->wwwroot.'/mod/'.$mod->modname.'/view.php?id='.$mod->id.'">'.
                     $instancename.'</a>';
            }
            echo '<br>';
        }

    }
}



function mfm_make_categories_list(&$list, &$parents, $category=NULL, $path="") {
/// Given an empty array, this function recursively travels the
/// categories, building up a nice list for display.  It also makes
/// an array that list all the parents for each category.

    // initialize the arrays if needed
    if (!is_array($list)) {
        $list = array(); 
    }
    if (!is_array($parents)) {
        $parents = array(); 
    }

    if ($category) {
        if ($path) {
            $path = $path.' / '.$category->name;
        } else {
            $path = $category->name;
        }
        $list[$category->id] = $path;
    } else {
        $category->id = 0;
    }

    if ($categories = get_categories($category->id)) {   // Print all the children recursively
        foreach ($categories as $cat) {
            if (!empty($category->id)) {
                if (isset($parents[$category->id])) {
                    $parents[$cat->id]   = $parents[$category->id];
                }
                $parents[$cat->id][] = $category->id;
            }
            mfm_make_categories_list($list, $parents, $cat, $path);
        }
    }
}


function mfm_print_whole_category_list($category=NULL, $displaylist=NULL, $parentslist=NULL, $depth=-1) {
/// Recursive function to print out all the categories in a nice format
/// with or without courses included
    global $CFG;

    if (isset($CFG->max_category_depth) && ($depth >= $CFG->max_category_depth)) {
        return;
    }

    if (!$displaylist) {
        mfm_make_categories_list($displaylist, $parentslist);
    }

    if ($category) {
        if ($category->visible or iscreator()) {
            mfm_print_category_info($category, $depth);
        } else {
            return;  // Don't bother printing children of invisible categories
        }

    } else {
        $category->id = "0";
    }

    if ($categories = get_categories($category->id)) {   // Print all the children recursively
        $countcats = count($categories);
        $count = 0;
        $first = true;
        $last = false;
        foreach ($categories as $cat) {
            $count++;
            if ($count == $countcats) {
                $last = true;
            }
            $up = $first ? false : true;
            $down = $last ? false : true;
            $first = false;

            mfm_print_whole_category_list($cat, $displaylist, $parentslist, $depth + 1);
        }
    }
}
/*
// this function will return $options array for choose_from_menu, with whitespace to denote nesting.

function make_categories_options() {
    mfm_make_categories_list($cats,$parents);
    foreach ($cats as $key => $value) {
        if (array_key_exists($key,$parents)) {
            if ($indent = count($parents[$key])) {
                for ($i = 0; $i < $indent; $i++) {
                    $cats[$key] = '&nbsp;'.$cats[$key];
                }
            }
        }
    }
    return $cats;
}*/

function mfm_print_category_info($category, $depth) {
/// Prints the category info in indented fashion
/// This function is only used by mfm_print_whole_category_list() above

    global $CFG;
    static $strallowguests, $strrequireskey, $strsummary;

    if (empty($strsummary)) {
        $strallowguests = mfm_get_string('allowguests');
        $strrequireskey = mfm_get_string('requireskey');
        $strsummary = mfm_get_string('summary');
    }

    $catlinkcss = $category->visible ? '' : ' class="dimmed" ';

    $frontpage = explode(',', $CFG->frontpage);
    $frontpage = $frontpage?array_flip($frontpage):array();
    if (isset($frontpage[FRONTPAGECOURSELIST])) {
        $catimage = '<img src="'.$CFG->pixpath.'/i/course.gif" width="16" height="16" border="0" />';
    } else {
        $catimage = "&nbsp";
    }

    echo "\n\n".'<table border="0" cellpadding="3" cellspacing="0" width="100%">';

    if (isset($frontpage[FRONTPAGECOURSELIST])) {
        $courses = get_courses($category->id, 'c.sortorder ASC', 'c.id,c.sortorder,c.visible,c.fullname,c.shortname,c.password,c.summary,c.guest,c.cost,c.currency');

        echo "<tr>";

        if ($depth) {
            $indent = $depth*30;
            $rows = count($courses) + 1;
            echo '<td rowspan="'.$rows.'" valign="top" width="'.$indent.'">';
            print_spacer(10, $indent);
            echo '</td>';
        }

        echo '<td valign="top">'.$catimage.'</td>';
        echo '<td valign="top" width="100%" class="category name">';
        echo '<a '.$catlinkcss.' href="'.$CFG->wwwroot.'/course/category.php?id='.$category->id.'">'.$category->name.'</a>';
        echo '</td>';
        echo '<td class="category info">&nbsp;</td>';
        echo '</tr>';

        if ($courses && !(isset($CFG->max_category_depth)&&($depth>=$CFG->max_category_depth-1))) {
            foreach ($courses as $course) {
                $linkcss = $course->visible ? '' : ' class="dimmed" ';
                echo '<tr><td valign="top" width="30">&nbsp;';
                echo '</td><td valign="top" width="100%" class="course name">';
                echo '<a '.$linkcss.' href="'.$CFG->wwwroot.'/course/view.php?id='.$course->id.'">'.$course->fullname.'</a>';
                echo '</td><td align="right" valign="top" nowrap="nowrap" class="course info">';
                if ($course->guest ) {
                    echo '<a href="'.$CFG->wwwroot.'/course/view.php?id='.$course->id.'">';
                    echo '<img hspace="1" height="16" width="16" border="0" src="'.$CFG->pixpath.'/i/guest.gif" /></a>';
                } else {
                    echo '<img height="16" width="18" border="0" src="'.$CFG->pixpath.'/spacer.gif" />';
                }
                if ($course->password) {
                    echo '<a href="'.$CFG->wwwroot.'/course/view.php?id='.$course->id.'">';
                    echo '<img hspace="1" height="16" width="16" border="0" src="'.$CFG->pixpath.'/i/key.gif" /></a>';
                } else {
                    echo '<img height="16" width="18" border="0" src="'.$CFG->pixpath.'/spacer.gif" />';
                }
                if ($course->summary) {
                    link_to_popup_window ('/course/info.php?id='.$course->id, 'courseinfo',
                                          '<img hspace="1" height="16" width="16" border="0" src="'.$CFG->pixpath.'/i/info.gif" />',
                                           400, 500, $strsummary);
                } else {
                    echo '<img height="16" width="18" border="0" src="'.$CFG->pixpath.'/spacer.gif" />';
                }
                echo '</td></tr>';
            }
        }
    } else {

        if ($depth) {
            $indent = $depth*20;
            echo '<td valign="top" width="'.$indent.'">';
            print_spacer(10, $indent);
            echo '</td>';
        }

        echo '<td valign="top" width="100%" class="category name">';
        echo '<a '.$catlinkcss.' href="'.$CFG->wwwroot.'/course/category.php?id='.$category->id.'">'.$category->name.'</a>';
        echo '</td>';
        echo '<td valign="top" class="category number">';
        if ($category->coursecount) {
            echo $category->coursecount;
        }
        echo '</td></tr>';
    }
    echo '</table>';
}


function mfm_print_courses($category, $width="100%") {
/// Category is 0 (for all courses) or an object

    global $CFG;

    if (empty($category)) {
        $categories = get_categories(0);  // Parent = 0   ie top-level categories only
        if (count($categories) == 1) {
            $category   = array_shift($categories);
            $courses    = get_courses($category->id, 'c.sortorder ASC', 'c.id,c.sortorder,c.visible,c.fullname,c.shortname,c.password,c.summary,c.teacher,c.cost,c.currency,c.enrol');
        } else {
            $courses    = get_courses('all', 'c.sortorder ASC', 'c.id,c.sortorder,c.visible,c.fullname,c.shortname,c.password,c.summary,c.teacher,c.cost,c.currency,c.enrol');
        }
        unset($categories);
    } else {
        $categories = get_categories($category->id);  // sub categories
        $courses    = get_courses($category->id, 'c.sortorder ASC', 'c.id,c.sortorder,c.visible,c.fullname,c.shortname,c.password,c.summary,c.teacher,c.cost,c.currency,c.enrol');
    }
    $coursewithmfmactivities = false;
    if ($courses) {
        foreach ($courses as $course) {
            $coursewithmfmactivities = mfm_print_course($course, $width) || $coursewithmfmactivities;
            echo '<hr>';
        }
    } 
    if (!$coursewithmfmactivities){
        mfm_print_heading(mfm_get_string('nocoursesyet'));
    }

}


function mfm_print_course($course, $width="100%") {

    global $CFG, $USER;
    if (!mfm_get_course_mods($course->id)) {
        return false;
    }
    if ($course->id===SITEID) {
        return false;
    }
    if (isset($course->context)) {
        $context = $course->context;
    } else {
        $context = get_context_instance(CONTEXT_COURSE, $course->id);
    }
    
    echo '<strong><a href="'.$CFG->wwwroot.'/course/view.php?id='.$course->id.'">'.
         $course->fullname.'</a></strong><br />';
    
    if (!empty($CFG->coursemanager)) {
        $managerroles = split(',', $CFG->coursemanager);
        $canseehidden = has_capability('moodle/role:viewhiddenassigns', $context);
        $namesarray = array();
        if (isset($course->managers)) {
            if (count($course->managers)) {
                $rusers = $course->managers;
                $canviewfullnames = has_capability('moodle/site:viewfullnames', $context);
                
                 /// Rename some of the role names if needed
                if (isset($context)) {
                    $aliasnames = get_records('role_names', 'contextid', $context->id,'','roleid,contextid,text');
                }

                foreach ($rusers as $ra) {
                    if ($ra->hidden == 0 || $canseehidden) {
                        $fullname = fullname($ra->user, $canviewfullnames); 

                        if (isset($aliasnames[$ra->roleid])) {
                            $ra->rolename = $aliasnames[$ra->roleid]->text;
                        }

                        $namesarray[] = format_string($ra->rolename) 
                            . ': <a href="'.$CFG->wwwroot.'/user/view.php?id='.$ra->user->id.'&amp;course='.SITEID.'">'
                            . $fullname . '</a>'; 
                    }
                }
            }
        } else {
            $rusers = get_role_users($managerroles, $context, 
                                     true, '', 'r.sortorder ASC, u.lastname ASC', $canseehidden);
            if (is_array($rusers) && count($rusers)) {
                $canviewfullnames = has_capability('moodle/site:viewfullnames', $context);
                foreach ($rusers as $teacher) {
                    $fullname = fullname($teacher, $canviewfullnames); 
                    $namesarray[] = format_string($teacher->rolename).': '.$fullname;
                }
            }
        }
        if (!empty($namesarray)) {
            echo "<ul>\n<li>";
            echo implode('</li><li>', $namesarray);
            echo "</li></ul>\n";
        }
    }


    require_once("$CFG->dirroot/enrol/enrol.class.php");
    $enrol = enrolment_factory::factory($course->enrol);
    echo $enrol->get_access_icons($course);
    $options = NULL;
    $options->noclean = true;
    $options->para = false;
    echo format_text($course->summary, FORMAT_MOODLE, $options,  $course->id);
    echo '<br><br>';
    return true;
}


function mfm_print_my_moodle() {
/// Prints custom user information on the home page.
/// Over time this can include all sorts of information

    global $USER, $CFG;

    if (!isset($USER->id)) {
        mfm_error("It shouldn't be possible to see My Moodle without being logged in.");
    }

    if ($courses = get_my_courses($USER->id)) {
        foreach ($courses as $course) {
            if (!$course->category) {
                continue;
            }
            mfm_print_course($course, "100%");
        }

        if (count_records("course") > (count($courses) + 1) ) {  // Some courses not being displayed
            echo "<table width=\"100%\"><tr><td align=\"center\">";
            print_course_search("", false, "short");
            echo "</td><td align=\"center\">";
            mfm_print_single_button("$CFG->wwwroot/course/index.php", NULL, mfm_get_string("fulllistofcourses"), "get");
            echo "</td></tr></table>\n";
        }
    } else {
        if (count_records("course_categories") > 1) {
            print_simple_box_start("center", "100%", "#FFFFFF", 5, "categorybox");
            mfm_print_whole_category_list();
            print_simple_box_end();
        } else {
            mfm_print_courses(0, "100%");
        }
    }
}


?>
