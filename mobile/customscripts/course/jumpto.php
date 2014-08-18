<?php  // $Id: jumpto.php,v 1.10 2006/06/22 08:00:10 jamiesensei Exp $

/*
 *  Jumps to a given relative or Moodle absolute URL.
 *  Mostly used for accessibility.
 *
 */

    mfm_setup();

    $jump = optional_param('jump', '', PARAM_RAW);

    if (strpos($jump, $CFG->wwwroot) === 0) {            // Anything on this site
        mfm_redirect(urldecode($jump));
    } else if (preg_match('/^[a-z]+\.php\?/', $jump)) { 
        mfm_redirect(urldecode($jump));
    }

    mfm_redirect($_SERVER['HTTP_REFERER']);   // Return to sender, just in case

?>
