<?php   /// $Id: enrol.php,v 1.6 2008/02/08 03:05:32 jamiesensei Exp $
///////////////////////////////////////////////////////////////////////////
//                                                                       //
// NOTICE OF COPYRIGHT                                                   //
//                                                                       //
// Moodle - Modular Object-Oriented Dynamic Learning Environment         //
//          http://moodle.org                                            //
//                                                                       //
// Copyright (C) 2004  Martin Dougiamas  http://moodle.com               //
//                                                                       //
// This program is free software; you can redistribute it and/or modify  //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation; either version 2 of the License, or     //
// (at your option) any later version.                                   //
//                                                                       //
// This program is distributed in the hope that it will be useful,       //
// but WITHOUT ANY WARRANTY; without even the implied warranty of        //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         //
// GNU General Public License for more details:                          //
//                                                                       //
//          http://www.gnu.org/copyleft/gpl.html                         //
//                                                                       //
///////////////////////////////////////////////////////////////////////////


/**
* enrolment_plugin_manual is the default enrolment plugin
*
* This class provides all the functionality for an enrolment plugin
* In fact it includes all the code for the default, "manual" method
* so that other plugins can override these as necessary.
*/

class mfm_enrolment_plugin_manual extends enrolment_plugin_manual{



/**
* Prints the entry form/page for this enrolment
*
* This is only called from course/enrol.php
* Most plugins will probably override this to print payment 
* forms etc, or even just a notice to say that manual enrolment 
* is disabled
*
* @param    course  current course object
*/
function print_entry($course) {
    global $CFG, $USER, $SESSION, $THEME;

    $strloginto = get_string("loginto", "", $course->shortname);
    $strcourses = get_string("courses");


/// Automatically enrol into courses without password

    $context = get_context_instance(CONTEXT_SYSTEM, SITEID);

    if ($course->password == "") {   // no password, so enrol

        if (has_capability('moodle/legacy:guest', $context, $USER->id, false)) {
            add_to_log($course->id, "course", "guest", "view.php?id=$course->id", "$USER->id");

        } else if (empty($_GET['confirm']) && empty($_GET['cancel'])) {

            mfm_print_header($strloginto, $course->fullname, "<a href=\".\">$strcourses</a> -> $strloginto");
            echo "<br />";
            mfm_notice_yesno(get_string("enrolmentconfirmation"), "enrol.php?id=$course->id&confirm=1", "enrol.php?id=$course->id&cancel=1");
            mfm_print_footer();
            exit;

        } elseif (!empty($_GET['confirm'])) {
            if (!enrol_into_course($course, $USER, 'manual')) {
                mfm_print_error('couldnotassignrole');
            }
            // force a refresh of mycourses
            unset($USER->mycourses);

            if ($SESSION->wantsurl) {
                $destination = $SESSION->wantsurl;
                unset($SESSION->wantsurl);
            } else {
                $destination = "$CFG->wwwroot/course/view.php?id=$course->id";
            }

            mfm_redirect($destination);
        } elseif (!empty($_GET['cancel'])) {
            unset($SESSION->wantsurl);
            mfm_redirect($CFG->wwwroot);
        }
    }

    $teacher = get_teacher($course->id);
    if (!isset($password)) {
        $password = "";
    }


    mfm_print_header($strloginto, $course->fullname, "<a href=\".\">$strcourses</a> -> $strloginto", "form.password");

    mfm_print_course($course, "80%");

    include("$CFG->mfm_dirroot/enrol/manual/enrol.html");

    mfm_print_footer();

}



/**
* The other half to print_entry, this checks the form data
*
* This function checks that the user has completed the task on the 
* enrolment entry page and then enrolls them.
*
* @param    form    the form data submitted, as an object
* @param    course  the current course, as an object
*/
function check_entry($form, $course) {
    global $CFG, $USER, $SESSION, $THEME;

    if (empty($form->password)) {
        $form->password = '';
    }

    if (empty($course->password)) {
        // do not allow entry when no course password set
        // automatic login when manual primary, no login when secondary at all!!
        mfm_error('illegal enrolment attempted');
    }

    $groupid = $this->check_group_entry($course->id, $form->password);

    if ((stripslashes($form->password) == $course->password) or ($groupid !== false) ) {

        if (isguestuser()) { // only real user guest, do not use this for users with guest role
            $USER->enrolkey[$course->id] = true;
            add_to_log($course->id, 'course', 'guest', 'view.php?id='.$course->id, getremoteaddr());

        } else {  /// Update or add new enrolment
            if (enrol_into_course($course, $USER, 'manual')) {
                // force a refresh of mycourses
                unset($USER->mycourses);
                if ($groupid !== false) {
                    if (!groups_add_member($groupid, $USER->id)) {
                        mfm_print_error('couldnotassigngroup');
                    }
                }
            } else {
                mfm_print_error('couldnotassignrole');
            }
        }

        if ($SESSION->wantsurl) {
            $destination = $SESSION->wantsurl;
            unset($SESSION->wantsurl);
        } else {
            $destination = "$CFG->wwwroot/course/view.php?id=$course->id";
        }

        mfm_redirect($destination);

    } else {
        $this->errormsg = get_string('enrolmentkeyhint', '', substr($course->password,0,1));
    }
}



} /// end of class

?>
