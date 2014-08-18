<?php
/**
 * This function checks that the current user is logged in and has the
 * required privileges
 *
 * mfm function is the same as regular function except it calls mfm_redirect instead
 * regular redirect.
 *
 *
 * @uses $CFG
 * @uses $SESSION
 * @uses $USER
 * @uses $FULLME
 * @uses SITEID
 * @uses $MoodleSession
 * @param int $courseid id of the course
 * @param bool $autologinguest
 * @param object $cm course module object
 */
function mfm_require_login($courseid=0, $autologinguest=true, $cm=null) {

    global $CFG, $COURSE, $SESSION, $USER, $FULLME, $MoodleSession;
    // Redefine global $COURSE if we can
    global $course;  // We use the global hack once here so it doesn't need to be used again
    if (is_object($course)) {
        $COURSE = clone($course);
    } else if ($courseid) {
        $COURSE = get_record('course', 'id', $courseid);
    }

/// If the user is not even logged in yet then make sure they are
    if (!isloggedin()) {
        //NOTE: $USER->site check was obsoleted by session test cookie,
        //      $USER->confirmed test is in login/index.php
        $SESSION->wantsurl = $FULLME;
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $SESSION->fromurl  = $_SERVER['HTTP_REFERER'];
        }
        if ($autologinguest and $CFG->autologinguests and $courseid and ($courseid == SITEID or get_field('course','guest','id',$courseid)) ) {
            $loginguest = '?loginguest=true';
        } else {
            $loginguest = '';
        }
        if (empty($CFG->loginhttps)) {
            mfm_redirect($CFG->wwwroot .'/login/index.php'. $loginguest);
        } else {
            $wwwroot = str_replace('http:','https:', $CFG->wwwroot);
            mfm_redirect($wwwroot .'/login/index.php'. $loginguest);
        }
        exit;
    }

    // Make sure current IP matches the one for this session (if required)
    if (!empty($CFG->tracksessionip)) {
        if ($USER->sessionIP != md5(getremoteaddr())) {
            mfm_error(mfm_get_string('sessionipnomatch', 'error'));
        }
    }

    // Make sure the USER has a sesskey set up.  Used for checking script parameters.
    sesskey();

    // Check that the user has agreed to a site policy if there is one
    if (!empty($CFG->sitepolicy)) {
        if (!$USER->policyagreed) {
            $SESSION->wantsurl = $FULLME;
            mfm_redirect($CFG->wwwroot .'/user/policy.php');
        }
    }

    // Fetch the system context, we are going to use it a lot.
    $sysctx = get_context_instance(CONTEXT_SYSTEM);

    // If the site is currently under maintenance, then print a message
    if (!has_capability('moodle/site:config', $sysctx)) {
        if (file_exists($CFG->dataroot.'/'.SITEID.'/maintenance.html')) {
            mfm_print_maintenance_message();
            exit;
        }
    }

/// groupmembersonly access control
    if (!empty($CFG->enablegroupings) and $cm and $cm->groupmembersonly and !has_capability('moodle/site:accessallgroups', get_context_instance(CONTEXT_MODULE, $cm->id))) {
        if (isguestuser() or !groups_has_membership($cm)) {
            mfm_error(get_string('groupmembersonlyerror', 'group'), $CFG->wwwroot.'/course/view.php?id='.$cm->course);
        }
    }

    // Fetch the course context, and prefetch its child contexts
    if (!isset($COURSE->context)) {
        if ( ! $COURSE->context = get_context_instance(CONTEXT_COURSE, $COURSE->id) ) {
            mfm_print_error('nocontext');        
        }
    }
    if ($COURSE->id == SITEID) {
        /// Eliminate hidden site activities straight away
        if (!empty($cm) && !$cm->visible 
            && !has_capability('moodle/course:viewhiddenactivities', $COURSE->context)) {
                mfm_redirect($CFG->wwwroot, mfm_get_string('activityiscurrentlyhidden'));
        }
        return;
    } else {
        /// Check if the user can be in a particular course
        if (empty($USER->access['rsw'][$COURSE->context->path])) {
            //
            // Spaghetti logic construct
            // 
            // - able to view course?
            // - able to view category?
            // => if either is missing, course is hidden from this user
            //
            // It's carefully ordered so we run the cheap checks first, and the
            // more costly checks last...
            //
            if (! (($COURSE->visible || has_capability('moodle/course:viewhiddencourses', $COURSE->context))
                   && (course_parent_visible($COURSE)) || has_capability('moodle/course:viewhiddencourses', 
                                                                        get_context_instance(CONTEXT_COURSECAT,
                                                                                             $COURSE->category)))) {
                mfm_print_header_simple();
                mfm_notice(get_string('coursehidden'), $CFG->wwwroot .'/');
            }
        }    
        
    /// Non-guests who don't currently have access, check if they can be allowed in as a guest

        if ($USER->username != 'guest' and !has_capability('moodle/course:view', $COURSE->context)) {
            if ($COURSE->guest == 1) {
                 // Temporarily assign them guest role for this context, if it fails later user is asked to enrol
                 $USER->access = load_temp_role($COURSE->context, $CFG->guestroleid, $USER->access);
            }
        }

    /// If the user is a guest then treat them according to the course policy about guests

        if (has_capability('moodle/legacy:guest', $COURSE->context, NULL, false)) {
            switch ($COURSE->guest) {    /// Check course policy about guest access

                case 1:    /// Guests always allowed 
                    if (!has_capability('moodle/course:view', $COURSE->context)) {    // Prohibited by capability
                        mfm_print_header_simple();
                        mfm_notice(mfm_get_string('guestsnotallowed', '', format_string($COURSE->fullname)), "$CFG->wwwroot/login/index.php");
                    }
                    if (!empty($cm) and !$cm->visible) { // Not allowed to see module, send to course page
                        mfm_redirect($CFG->wwwroot.'/course/view.php?id='.$cm->course,
                                 mfm_get_string('activityiscurrentlyhidden'));
                    }

                    return;   // User is allowed to see this course

                    break;

                case 2:    /// Guests allowed with key
                    if (!empty($USER->enrolkey[$COURSE->id])) {   // Set by enrol/manual/enrol.php
                        return true;
                    }
                    //  otherwise drop through to logic below (--> enrol.php)
                    break;

                default:    /// Guests not allowed
                    $strloggedinasguest = get_string('loggedinasguest');
                    mfm_print_header_simple('', '',
                            mfm_build_navigation(array(array('name' => $strloggedinasguest, 'link' => null, 'type' => 'misc'))));
                    mfm_notice(get_string('guestsnotallowed', '', format_string($COURSE->fullname)), "$CFG->wwwroot/login/index.php");

                    break;
            }

    /// For non-guests, check if they have course view access

        } else if (has_capability('moodle/course:view', $COURSE->context)) {
            if (!empty($USER->realuser)) {   // Make sure the REAL person can also access this course
                if (!has_capability('moodle/course:view', $COURSE->context, $USER->realuser)) {
                    mfm_print_header_simple();
                    mfm_notice(get_string('studentnotallowed', '', fullname($USER, true)), $CFG->wwwroot .'/');
                }
            }

        /// Make sure they can read this activity too, if specified

            if (!empty($cm) and !$cm->visible and !has_capability('moodle/course:viewhiddenactivities', $COURSE->context)) { 
                mfm_redirect($CFG->wwwroot.'/course/view.php?id='.$cm->course, get_string('activityiscurrentlyhidden'));
            }
            return;   // User is allowed to see this course

        }

        // Currently not enrolled in the course, so see if they want to enrol
        $SESSION->wantsurl = $FULLME;
        mfm_redirect($CFG->wwwroot .'/course/enrol.php?id='. $courseid);
        die;
    }
}
/**
 * This is a weaker version of {@link require_login()} which only requires login
 * when called from within a course rather than the site page, unless
 * the forcelogin option is turned on.
 *
 * @uses $CFG
 * @param object $course The course object in question
 * @param bool $autologinguest Allow autologin guests if that is wanted
 * @param object $cm Course activity module if known
 */
function mfm_require_course_login($course, $autologinguest=true, $cm=null) {
    global $CFG;
    if (!empty($CFG->forcelogin)) {
        mfm_require_login();
    }
    if ($course->id != SITEID) {
        mfm_require_login($course->id, $autologinguest, $cm);
    }
}
/**
 * Returns a localized string.
 *
 * This function checks for a string in a local language file for mfm.
 * This necessary to customise strings that are too long for mobile phones. 
 * @uses $CFG
 * @param string $identifier The key identifier for the localized string
 * @param string $module The module where the key identifier is stored. If none is specified then moodle.php is used.
 * @param mixed $a An object, string or number that can be used
 * within translation strings
 * @return string The localized string.
 */
function mfm_get_string($identifier, $module='', $a=NULL) {

    global $CFG;
    
    $langconfigstrs = array('alphabet', 'backupnameformat', 'firstdayofweek', 'locale', 
                            'localewin', 'localewincharset', 'oldcharset',                            'parentlanguage', 'strftimedate', 'strftimedateshort', 'strftimedatetime',
                            'strftimedaydate', 'strftimedaydatetime', 'strftimedayshort', 'strftimedaytime',
                            'strftimemonthyear', 'strftimerecent', 'strftimerecentfull', 'strftimetime',
                            'thischarset', 'thisdirection', 'thislanguage');
    
    if (!empty($CFG->unicodedb)) {
        $filetocheck = 'langconfig.php';
        $defaultlang = 'en_utf8';
        if (in_array($identifier, $langconfigstrs)) {
            $module = 'langconfig';  //This strings are under langconfig.php for 1.6 lang packs
        }
    } else {
        $filetocheck = 'moodle.php';
        $defaultlang = 'en';
    }

    $lang = current_language();

    if ($module == '') {
        $module = 'moodle';
    }

    // if $a happens to have % in it, double it so sprintf() doesn't break
    if ($a) {
        $a = clean_getstring_data( $a );
    }

/// Define the major locations of language strings for this module

    $locations = array( $CFG->mfm_dirroot.'/lang/', $CFG->dataroot.'/lang/',  $CFG->dirroot.'/lang/' );    
    if ($module != 'moodle' && $module != 'langconfig') {
        if (strpos($module, 'block_') === 0) {  // It's a block lang file
            $locations[] =  $CFG->mfm_dirroot.'/blocks/'.substr($module, 6).'/lang/';
            $locations[] =  $CFG->dirroot.'/blocks/'.substr($module, 6).'/lang/';
        } else if (strpos($module, 'report_') === 0) {  // It's a report lang file
            $locations[] =  $CFG->mfm_dirroot .'/admin/report/'.substr($module, 7).'/lang/';
            $locations[] =  $CFG->mfm_dirroot .'/course/report/'.substr($module, 7).'/lang/';
            $locations[] =  $CFG->dirroot .'/admin/report/'.substr($module, 7).'/lang/';
            $locations[] =  $CFG->dirroot .'/course/report/'.substr($module, 7).'/lang/';
        } else {                                // It's a normal activity
            $locations[] =  $CFG->mfm_dirroot.'/mod/'.$module.'/lang/';
            $locations[] =  $CFG->dirroot.'/mod/'.$module.'/lang/';
        }
    }

/// First check all the normal locations for the string in the current language

    foreach ($locations as $location) {
        $locallangfile = $location.$lang.'_local'.'/'.$module.'.php';    //first, see if there's a local file
        if (file_exists($locallangfile)) {
            if ($result = get_string_from_file($identifier, $locallangfile, "\$resultstring")) {
                eval($result);
                return $resultstring;
            }
        }
        //if local directory not found, or particular string does not exist in local direcotry
        $langfile = $location.$lang.'/'.$module.'.php';
        if (file_exists($langfile)) {
            if ($result = get_string_from_file($identifier, $langfile, "\$resultstring")) {
                eval($result);
                return $resultstring;
            }
        }
    }

/// If the preferred language was English we can abort now
    if ($lang == 'en_utf8') {
        return '[['.$identifier.']]';
    }

/// Is a parent language defined?  If so, try to find this string in a parent language file

    foreach ($locations as $location) {
        $langfile = $location.$lang.'/'.$filetocheck;
        if (file_exists($langfile)) {
            if ($result = get_string_from_file('parentlanguage', $langfile, "\$parentlang")) {
                eval($result);
                if (!empty($parentlang)) {   // found it!

                    //first, see if there's a local file for parent
                    $locallangfile = $location.$parentlang.'_local'.'/'.$module.'.php';    
                    if (file_exists($locallangfile)) {
                        if ($result = get_string_from_file($identifier, $locallangfile, "\$resultstring")) {
                            eval($result);
                            return $resultstring;
                        }
                    }

                    //if local directory not found, or particular string does not exist in local direcotry
                    $langfile = $location.$parentlang.'/'.$module.'.php';
                    if (file_exists($langfile)) {
                        if ($result = get_string_from_file($identifier, $langfile, "\$resultstring")) {
                            eval($result);
                            return $resultstring;
                        }
                    }
                }
            }
        }
    }

/// Our only remaining option is to try English

    foreach ($locations as $location) {
        $locallangfile = $location.$defaultlang.'_local/'.$module.'.php';    //first, see if there's a local file
        if (file_exists($locallangfile)) {
            if ($result = get_string_from_file($identifier, $locallangfile, "\$resultstring")) {
                eval($result);
                return $resultstring;
            }
        }

        //if local_en not found, or string not found in local_en
        $langfile = $location.$defaultlang.'/'.$module.'.php';

        if (file_exists($langfile)) {
            if ($result = get_string_from_file($identifier, $langfile, "\$resultstring")) {
                eval($result);
                return $resultstring;
            }
        }
    }
/// And, because under 1.6 en is defined as en_utf8 child, me must try 
/// if it hasn't been queried before.
    if ($defaultlang  == 'en') {
        $defaultlang = 'en_utf8';
        foreach ($locations as $location) {
            $locallangfile = $location.$defaultlang.'_local/'.$module.'.php';    //first, see if there's a local file
            if (file_exists($locallangfile)) {
                if ($result = get_string_from_file($identifier, $locallangfile, "\$resultstring")) {
                    eval($result);
                    return $resultstring;
                }
            }

            //if local_en not found, or string not found in local_en
            $langfile = $location.$defaultlang.'/'.$module.'.php';

            if (file_exists($langfile)) {
                if ($result = get_string_from_file($identifier, $langfile, "\$resultstring")) {
                    eval($result);
                    return $resultstring;
                }
            }
        }
    }

    return '[['.$identifier.']]';
}
/**
 * Prints out a translated string.
 *
 * Prints out a translated string using the return value from the {@link mfm_get_string()} function.
 *
 * Example usage of this function when the string is in the moodle.php file:<br>
 * <code>
 * echo '<strong>';
 * mfm_print_string('wordforstudent');
 * echo '</strong>';
 * </code>
 *
 * Example usage of this function when the string is not in the moodle.php file:<br>
 * <code>
 * echo '<h1>';
 * mfm_print_string('typecourse', 'calendar');
 * echo '</h1>';
 * </code>
 *
 * @param string $identifier The key identifier for the localized string
 * @param string $module The module where the key identifier is stored. If none is specified then moodle.php is used.
 * @param mixed $a An object, string or number that can be used
 * within translation strings
 */
function mfm_print_string($identifier, $module='', $a=NULL) {
    echo mfm_get_string($identifier, $module, $a);
}
/**
 * Returns a list of language codes and their full names
 * hides the _local files from everyone.
 * We need this to replace language names that include html entities that keitais
 * don't support.
 * @uses $CFG
 * @return array An associative array with contents in the form of LanguageCode => LanguageName
 */
function mfm_get_list_of_languages() {
    global $CFG;

    $languages = array();

/// Depending upon $CFG->unicodedb, we are going to check moodle.php or langconfig.php
    if (!empty($CFG->unicodedb)) {
        $filetocheck = 'langconfig.php';
    } else {
        $filetocheck = 'moodle.php';
    }

    if ( (!defined('FULLME') || FULLME !== 'cron')
         && !empty($CFG->langcache) && file_exists($CFG->dataroot .'/cache/mfm_languages')) {
        // read from cache
        $lines = file($CFG->dataroot .'/cache/mfm_languages');
        foreach ($lines as $line) {
            $line = trim($line);
            if (preg_match('/^(\w+)\s+(.+)/', $line, $matches)) {
                $languages[$matches[1]] = $matches[2];
            }
        }
        unset($lines); unset($line); unset($matches);
        return $languages;
    }

    if (!empty($CFG->langlist)) {       // use admin's list of languages
        $langlist = explode(',', $CFG->langlist);
        foreach ($langlist as $lang) {
            $lang = trim($lang);   //Just trim spaces to be a bit more permissive
            if (strstr($lang, '_local')!==false) {
                continue;
            }
            if (substr($lang, -5) == '_utf8') {   //Remove the _utf8 suffix from the lang to show
                $shortlang = substr($lang, 0, -5);
            } else {
                $shortlang = $lang;
            }            
        /// Search under dirroot/lang
       /// If $CFG->unicodedb = false, ignore new lang packs
            if (empty($CFG->unicodedb)) {
                if (file_exists($CFG->dirroot .'/lang/'. $lang .'/langconfig.php')) {
                    continue;
                }
            }
            if (file_exists($CFG->dirroot .'/lang/'. $lang .'/'. $filetocheck)) {
                include($CFG->dirroot .'/lang/'. $lang .'/'. $filetocheck);
                if (!empty($string['thislanguage'])) {
                    $languages[$lang] = $string['thislanguage'].' ('. $lang .')';
                }
                unset($string);
            } 
        /// If $CFG->unicodedb = false, ignore new lang packs
            if (empty($CFG->unicodedb)) {
                if (file_exists($CFG->dataroot .'/lang/'. $lang .'/langconfig.php')) {
                    continue;
                }
            }            
            if (file_exists($CFG->dataroot .'/lang/'. $lang .'/'. $filetocheck)) {
                /// And moodledata/lang
                include($CFG->dataroot .'/lang/'. $lang .'/'. $filetocheck);
                if (!empty($string['thislanguage'])) {
                    $languages[$lang] = $string['thislanguage'].' ('. $shortlang .')';
                }
                unset($string);
            }
        //this is included not to add to the lang list but to override language names that
        //use html entities.
            if (file_exists($CFG->mfm_dirroot.'/lang/'. $lang .'/'. $filetocheck)) {
                @include($CFG->mfm_dirroot.'/lang/'. $lang .'/'. $filetocheck);
                if (!empty($string['thislanguage'])&&!empty($languages[$lang])) {
                    $languages[$lang] = $string['thislanguage'] .' ('. $shortlang .')';
                }
                unset($string);
            } 
        }
    } else {
    /// Fetch langs from moodle/lang directory
        $langdirs = get_list_of_plugins('lang');
    /// Fetch langs from moodledata/lang directory
        $langdirs2 = get_list_of_plugins('lang', '', $CFG->dataroot);
    /// Merge both lists of langs
        $langdirs = array_merge($langdirs, $langdirs2);
    /// Sort all
        asort($langdirs);
    /// Get some info from each lang (first from moodledata, then from moodle)
        foreach ($langdirs as $lang) {
            if (strstr($lang, '_local')!==false) {
                continue;
            }
            if (substr($lang, -5) == '_utf8') {   //Remove the _utf8 suffix from the lang to show
                $shortlang = substr($lang, 0, -5);
            } else {
                $shortlang = $lang;
            }
        /// Search under moodledata/lang
        /// If $CFG->unicodedb = false, ignore new lang packs
            if (empty($CFG->unicodedb)) {
                if (file_exists($CFG->dataroot .'/lang/'. $lang .'/langconfig.php')) {
                    continue;
                }
            }
            if (file_exists($CFG->dataroot .'/lang/'. $lang .'/'. $filetocheck)) {
                include($CFG->dataroot .'/lang/'. $lang .'/'. $filetocheck);
                if (!empty($string['thislanguage'])) {
                    $languages[$lang] = $string['thislanguage'] .' ('. $shortlang .')';
                }
                unset($string);
            } 
        /// And dirroot/lang
        /// If $CFG->unicodedb = false, ignore new lang packs
            if (empty($CFG->unicodedb)) {
                if (file_exists($CFG->dirroot .'/lang/'. $lang .'/langconfig.php')) {
                    continue;
                }
            }
            if (file_exists($CFG->dirroot .'/lang/'. $lang .'/'. $filetocheck)) {
                include($CFG->dirroot .'/lang/'. $lang .'/'. $filetocheck);
                if (!empty($string['thislanguage'])) {
                    $languages[$lang] = $string['thislanguage'] .' ('. $shortlang .')';
                }
                unset($string);
            }
            if (file_exists($CFG->mfm_dirroot.'/lang/'. $lang .'/'. $filetocheck)) {
                include($CFG->mfm_dirroot.'/lang/'. $lang .'/'. $filetocheck);
                if (!empty($string['thislanguage'])&&!empty($languages[$lang])) {
                    $languages[$lang] = $string['thislanguage'] .' ('. $shortlang .')';
                }
                unset($string);
            } 
        }
    }

    if ( defined('FULLME') && FULLME === 'cron' && !empty($CFG->langcache)) {
        if ($file = fopen($CFG->dataroot .'/cache/mfm_languages', 'w')) {
            foreach ($languages as $key => $value) {
                fwrite($file, "$key $value\n");
            }
            fclose($file);
        } 
    }

    return $languages;
}

?>