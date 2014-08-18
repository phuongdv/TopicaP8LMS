<?PHP // $Id: view.php,v 1.168.2.24 2008/12/01 22:06:55 skodak Exp $

//  Display profile for a particular user

    require_once("../config.php");
    require_once($CFG->dirroot.'/user/profile/lib.php');
    require_once($CFG->dirroot.'/tag/lib.php');

	$name =	$USER->username;

    $id      = optional_param('id',     0,      PARAM_INT);   // user id
    $course  = optional_param('course', SITEID, PARAM_INT);   // course id (defaults to Site)
    $enable  = optional_param('enable', '');                  // enable email
    $disable = optional_param('disable', '');                 // disable email

    if (empty($id)) {         // See your own profile by default
        require_login();
        $id = $USER->id;
    }
	//print_r($USER);
    if (! $user = get_record("user", "id", $id) ) {
        error("No such user in this course");
    }

    if (! $course = get_record("course", "id", $course) ) {
        error("No such course id");
    }

/// Make sure the current user is allowed to see this user

    if (empty($USER->id)) {
       $currentuser = false;
    } else {
       $currentuser = ($user->id == $USER->id);
    }

    if ($course->id == SITEID) {
        $coursecontext = get_context_instance(CONTEXT_SYSTEM);   // SYSTEM context
    } else {
        $coursecontext = get_context_instance(CONTEXT_COURSE, $course->id);   // Course context
    }
    $usercontext   = get_context_instance(CONTEXT_USER, $user->id);       // User context
    $systemcontext = get_context_instance(CONTEXT_SYSTEM);   // SYSTEM context

    if (!empty($CFG->forcelogin) || $course->id != SITEID) {
        // do not force parents to enrol
        if (!get_record('role_assignments', 'userid', $USER->id, 'contextid', $usercontext->id)) {
            require_login($course->id);
        }
    }

    if (!empty($CFG->forceloginforprofiles)) {
        require_login();
        if (isguest()) {
            redirect("$CFG->wwwroot/login/index.php");
        }
    }

    $strpersonalprofile = get_string('personalprofile');
    $strparticipants = get_string("participants");
    $struser = get_string("user");

    $fullname = fullname($user, has_capability('moodle/site:viewfullnames', $coursecontext));

    $navlinks = array();
    if (has_capability('moodle/course:viewparticipants', $coursecontext) || has_capability('moodle/site:viewparticipants', $systemcontext)) {
        $navlinks[] = array('name' => $strparticipants, 'link' => "index.php?id=$course->id", 'type' => 'misc');
    }

/// If the user being shown is not ourselves, then make sure we are allowed to see them!

    if (!$currentuser) {
        if ($course->id == SITEID) {  // Reduce possibility of "browsing" userbase at site level
            if ($CFG->forceloginforprofiles and !isteacherinanycourse()
                    and !isteacherinanycourse($user->id)
                    and !has_capability('moodle/user:viewdetails', $usercontext)) {  // Teachers can browse and be browsed at site level. If not forceloginforprofiles, allow access (bug #4366)

                $navlinks[] = array('name' => $struser, 'link' => null, 'type' => 'misc');
                $navigation = build_navigation($navlinks);

                print_header("$strpersonalprofile: ", "$strpersonalprofile: ", $navigation, "", "", true, "&nbsp;", navmenu($course));
                print_heading(get_string('usernotavailable', 'error'));
                print_footer($course);
                exit;
            }
        } else {   // Normal course
            // check capabilities
            if (!has_capability('moodle/user:viewdetails', $coursecontext) && 
                !has_capability('moodle/user:viewdetails', $usercontext)) {
                print_error('cannotviewprofile');
            }

            if (!has_capability('moodle/course:view', $coursecontext, $user->id, false)) {
                if (has_capability('moodle/course:view', $coursecontext)) {
                    $navlinks[] = array('name' => $fullname, 'link' => null, 'type' => 'misc');
                    $navigation = build_navigation($navlinks);
                    print_header("$strpersonalprofile: ", "$strpersonalprofile: ", $navigation, "", "", true, "&nbsp;", navmenu($course));
                    print_heading(get_string('notenrolled', '', $fullname));
                } else {
                    $navlinks[] = array('name' => $struser, 'link' => null, 'type' => 'misc');
                    $navigation = build_navigation($navlinks);
                    print_header("$strpersonalprofile: ", "$strpersonalprofile: ", $navigation, "", "", true, "&nbsp;", navmenu($course));
                    print_heading(get_string('notenrolledprofile'));
                }
                print_continue($_SERVER['HTTP_REFERER']);
                print_footer($course);
                exit;
            }
        }


        // If groups are in use, make sure we can see that group
        if (groups_get_course_groupmode($course) == SEPARATEGROUPS and !has_capability('moodle/site:accessallgroups', $coursecontext)) {
            require_login();

            ///this is changed because of mygroupid
            $gtrue = (bool)groups_get_all_groups($course->id, $user->id);
            if (!$gtrue) {
                $navigation = build_navigation($navlinks);
                print_header("$strpersonalprofile: ", "$strpersonalprofile: ", $navigation, "", "", true, "&nbsp;", navmenu($course));
                print_error("groupnotamember", '', "../course/view.php?id=$course->id");
            }
        }
    }


/// We've established they can see the user's name at least, so what about the rest?

    $navlinks[] = array('name' => $fullname, 'link' => null, 'type' => 'misc');

    $navigation = build_navigation($navlinks);

    print_header("$course->fullname: $strpersonalprofile: $fullname", $course->fullname,
                 $navigation, "", "", true, "&nbsp;", navmenu($course));


    if (($course->id != SITEID) and ! isguest() ) {   // Need to have access to a course to see that info
        if (!has_capability('moodle/course:view', $coursecontext, $user->id)) {
            print_heading(get_string('notenrolled', '', $fullname));
            print_footer($course);
            die;
        }
    }

    if ($user->deleted) {
        print_heading(get_string('userdeleted'));
        if (!has_capability('moodle/user:update', $coursecontext)) {
            print_footer($course);
            die;
        }
    }

/// OK, security out the way, now we are showing the user

    add_to_log($course->id, "user", "view", "view.php?id=$user->id&course=$course->id", "$user->id");

    if ($course->id != SITEID) {
        $user->lastaccess = false;
        if ($lastaccess = get_record('user_lastaccess', 'userid', $user->id, 'courseid', $course->id)) {
            $user->lastaccess = $lastaccess->timeaccess;
        }
    }


/// Get the hidden field list
    if (has_capability('moodle/user:viewhiddendetails', $coursecontext)) {
        $hiddenfields = array();
    } else {
        $hiddenfields = array_flip(explode(',', $CFG->hiddenuserfields));
    }

/// Print tabs at top
/// This same call is made in:
///     /user/view.php
///     /user/edit.php
///     /course/user.php

    $currenttab = 'hieuscm';
    $showroles = 1;
    if (!$user->deleted) {
        include('tabs.php');
    }


	echo "<iframe src =\"http://publicdata.scm.topica.vn/PublicData.TVU/xmldata/$name.xml\" width=\"100%\" height=\"800px\" scrolling =\"auto\" framespacing=\"0\" border=\"0\" frameborder=\"0\"></iframe>";

    print_footer($course);

/// Functions ///////

function print_row($left, $right) {
    echo "\n<tr><td class=\"label c0\">$left</td><td class=\"info c1\">$right</td></tr>\n";
}

?>
