<?php 

/**
 * This function is the same as require_login but with output tailored to the small screen
 *  * 
 * @param string $capability - name of the capability
 * @param object $context - a context object (record from context table)
 * @param integer $userid - a userid number
 * @param bool $doanything - if false, ignore do anything
 * @param string $errorstring - an errorstring
 * @param string $stringfile - which stringfile to get it from
 */
function mfm_require_capability($capability, $context, $userid=NULL, $doanything=true,
                            $errormessage='nopermissions', $stringfile='') {

    global $USER, $CFG;

    /* Empty $userid means current user, if the current user is not logged in,
     * then make sure they are (if needed).
     * Originally there was a check for loaded permissions - it is not needed here.
     * Context is now required parameter, the cached $CONTEXT was only hiding errors.
     */
    $errorlink = '';

    if (empty($userid)) {
        if ($context->contextlevel == CONTEXT_COURSE) {
            mfm_require_login($context->instanceid);

        } else if ($context->contextlevel == CONTEXT_MODULE) {
            if (!$cm = get_record('course_modules', 'id', $context->instanceid)) {
                mfm_error('Incorrect module');
            }
            if (!$course = get_record('course', 'id', $cm->course)) {
                mfm_error('Incorrect course.');
            }
            mfm_require_course_login($course, true, $cm);
            $errorlink = $CFG->wwwroot.'/course/view.php?id='.$cm->course;

        } else if ($context->contextlevel == CONTEXT_SYSTEM) {
            if (!empty($CFG->forcelogin)) {
                mfm_require_login();
            }

        } else {
            mfm_require_login();
        }
    }

/// OK, if they still don't have the capability then print a nice error message

    if (!has_capability($capability, $context, $userid, $doanything)) {
        $capabilityname = get_capability_string($capability);
        mfm_print_error($errormessage, $stringfile, $errorlink, $capabilityname);
    }
}
?>