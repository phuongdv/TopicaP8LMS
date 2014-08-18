<?php
/// STANDARD WEB PAGE PARTS ///////////////////////////////////////////////////

/**
 * Print a standard header
 *
 * @uses $USER
 * @uses $CFG
 * @uses $SESSION
 * @param string $title Appears at the top of the window
 * @param string $heading Appears at the top of the page
 * @param string $navigation Premade navigation string (for use as breadcrumbs links)
 * @param string $focus Indicates form element to get cursor focus on load eg  inputform.password
 * @param string $meta Meta tags to be added to the header
 * @param boolean $cache Should this page be cacheable?
 * @param string $button HTML code for a button (usually for module editing)
 * @param string $menu HTML code for a popup menu
 * @param boolean $usexml use XML for this page
 * @param string $bodytags This text will be included verbatim in the <body> tag (useful for onload() etc)
 */
function mfm_print_header ($title='', $heading='', $navigation='', $focus='', $meta='',
                       $cache=true, $button='&nbsp;', $menu='', $usexml=false, $bodytags='') {

    global $USER, $CFG, $THEME, $SESSION, $ME, $SITE, $HTTPSPAGEREQUIRED;
    
/// This makes sure that the header is never repeated twice on a page
    if (defined('HEADER_PRINTED')) {


        if ($CFG->debug > 7) {
            mfm_notify('print_header() was called more than once - this should not happen.  Please check the code for this page closely. Note: error() and redirect() are now safe to call after print_header().');
        }
        return;


    }
    define('HEADER_PRINTED', 'true');

/// This is an ugly hack to be replaced later by a proper global $COURSE
    global $course;
    if (!empty($course->lang)) {
        $CFG->courselang = $course->lang;
    }
    if (!empty($course->theme)) {
        if (!empty($CFG->allowcoursethemes)) {
            $CFG->coursetheme = $course->theme;
            theme_setup();
        }
    }

/// We have to change some URLs in styles if we are in a $HTTPSPAGEREQUIRED page
    if (!empty($HTTPSPAGEREQUIRED)) {
        $CFG->themewww = str_replace('http:', 'https:', $CFG->themewww);
        $CFG->pixpath = str_replace('http:', 'https:', $CFG->pixpath);
        $CFG->modpixpath = str_replace('http:', 'https:', $CFG->modpixpath);
        foreach ($CFG->stylesheets as $key => $stylesheet) {
            $CFG->stylesheets[$key] = str_replace('http:', 'https:', $stylesheet);
        }
    }

    //no meta for mfm
    $meta = '';


    if ($navigation == 'home') {
        $home = true;
        $navigation = '';
    } else {
        $home = false;
    }

/// This is another ugly hack to make navigation elements available to print_footer later
    $THEME->title      = $title;
    $THEME->heading    = $heading;
    $THEME->navigation = $navigation;
    $THEME->button     = $button;
    $THEME->menu       = $menu;
    $navmenulist = isset($THEME->navmenulist) ? $THEME->navmenulist : '';

    if ($button == '') {
        $button = '&nbsp;';
    }

    if (!$menu and $navigation) {
        if (empty($CFG->loginhttps)) {
            $wwwroot = $CFG->wwwroot;
        } else {
            $wwwroot = str_replace('http','https',$CFG->wwwroot);
        }
        if (isset($course->id)) {
            $menu = mfm_user_login_string($course);
        } else {
            $menu = mfm_user_login_string($SITE);
        }
    }


    $encoding = current_charset();
    if (!empty($CFG->courselang)) {
        moodle_setlocale();
    }
    $SESSION->encoding = $encoding;

    if ($cache) {  // Allow caching on "back" (but not on normal clicks)
        @header('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
        @header('Pragma: no-cache');
        @header('Expires: ');
    } else {       // Do everything we can to always prevent clients and proxies caching
        @header('Cache-Control: no-store, no-cache, must-revalidate');
        @header('Cache-Control: post-check=0, pre-check=0', false);
        @header('Pragma: no-cache');
        @header('Expires: Mon, 20 Aug 1969 09:23:00 GMT');
        @header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

    }
    @header('Accept-Ranges: none');


    // Clean up the title

//    $title = str_replace('"', '&quot;', $title);
    $title = strip_tags($title);

    include ($CFG->themedir.current_theme().'/header.html');

}

/**
 * This version of print_header is simpler because the course name does not have to be
 * provided explicitly in the strings. It can be used on the site page as in courses
 * Eventually all print_header could be replaced by print_header_simple
 *
 * @param string $title Appears at the top of the window
 * @param string $heading Appears at the top of the page
 * @param string $navigation Premade navigation string (for use as breadcrumbs links)
 * @param string $focus Indicates form element to get cursor focus on load eg  inputform.password
 * @param string $meta Meta tags to be added to the header
 * @param boolean $cache Should this page be cacheable?
 * @param string $button HTML code for a button (usually for module editing)
 * @param string $menu HTML code for a popup menu
 * @param boolean $usexml use XML for this page
 * @param string $bodytags This text will be included verbatim in the <body> tag (useful for onload() etc)
 */
function mfm_print_header_simple($title='', $heading='', $navigation='', $focus='', $meta='',
                       $cache=true, $button='&nbsp;', $menu='', $usexml=false, $bodytags='') {

    global $COURSE;                // The same hack is used in print_header


    mfm_print_header($COURSE->shortname .': '. $title, $COURSE->fullname .' '. $heading, $navigation, $focus, $meta,
                       $cache, $button, $menu, $usexml, $bodytags);
}
/**
 * Can provide a course object to make the footer contain a link to
 * to the course home page, otherwise the link will go to the site home
 *
 * @uses $CFG
 * @uses $USER
 * @param course $course {@link $COURSE} object containing course information
 * @param ? $usercourse ?
 * @todo Finish documenting this function
 */
function mfm_print_footer($course=NULL, $usercourse=NULL) {
    global $USER, $CFG, $THEME;

/// Course links
    if ($course) {
        if ($course === 'none') {          // Don't print any links etc
            $homelink = '';
            $loggedinas = '';
            $home  = false;
        } else if ($course === 'home') {   // special case for site home page - please do not remove
            $course = get_site();
            $homelink  = 
               '<img width="34" height="30" src="'.$CFG->mfm_wwwroot.'/pix/moodlelogosmall.gif" border="0" alt="moodlelogo" />';
            $home  = true;
        } else {
            $homelink = '<a href="'.$CFG->wwwroot.
                        '/course/view.php?id='.$course->id.'">'.$course->shortname.'</a>';
            $home  = false;
        }
    } else {
        $course = get_site();  // Set course as site course by default
        $homelink = '<a href="'.$CFG->wwwroot.'/">'.mfm_get_string('home').'</a>';
        $home  = false;
    }
    /// Set up some other navigation links (passed from print_header by ugly hack)
    $menu        = isset($THEME->menu) ? str_replace('navmenu', 'navmenufooter', $THEME->menu) : '';
    $title       = isset($THEME->title) ? $THEME->title : '';
    $button      = isset($THEME->button) ? $THEME->button : '';
    $heading     = isset($THEME->heading) ? $THEME->heading : '';
    $navigation  = isset($THEME->navigation) ? $THEME->navigation : '';
    $navmenulist = isset($THEME->navmenulist) ? $THEME->navmenulist : '';


/// Set the user link if necessary
    if (!$usercourse and is_object($course)) {
        $usercourse = $course;
    }

    if (!isset($loggedinas)) {
        $loggedinas = mfm_user_login_string($usercourse, $USER);
    }

    if ($loggedinas == $menu) {
        $menu = '';
    }

/// Provide some performance info if required
    $performanceinfo = '';
    if (defined('MDL_PERF') || $CFG->debug > 7 || $CFG->perfdebug > 7) {
        $perf = get_performance_info();
        if (defined('MDL_PERFTOLOG')) {
            error_log("PERF: " . $perf['txt']);
        }
        if (defined('MDL_PERFTOFOOT') || $CFG->debug > 7 || $CFG->perfdebug > 7) {
            $performanceinfo = $perf['html'];
        }
    }


/// Include the actual footer file

    include ($CFG->themedir.current_theme().'/footer.html');
    
}
function mfm_print_heading_block($heading, $class='') {
    echo '<strong><p>'.stripslashes($heading).'</p></strong>';
}

/**
 * Prints text in a format for use in headings.
 *
 * @param string $text The text to be displayed
 * @param string $align The alignment of the printed paragraph of text
 * @param int $size The size to set the font for text display.
 */
 function mfm_print_heading($text, $align='', $size=2, $class='main') {
    if ($align) {
        $align = ' align="'.$align.'"';
    }
    echo "<strong><h$size $align>".stripslashes_safe($text)."</h$size></strong><br />";
}

/**
 * This function will build the navigation string to be used by print_header
 * and others.
 *
 * It automatically generates the site and course level (if appropriate) links.
 *
 * If you pass in a $cm object, the method will also generate the activity (e.g. 'Forums')
 * and activityinstances (e.g. 'General Developer Forum') navigation levels.
 *
 * If you want to add any further navigation links after the ones this function generates,
 * the pass an array of extra link arrays like this:
 * array(
 *     array('name' => $linktext1, 'link' => $url1, 'type' => $linktype1),
 *     array('name' => $linktext2, 'link' => $url2, 'type' => $linktype2)
 * )
 * The normal case is to just add one further link, for example 'Editing forum' after
 * 'General Developer Forum', with no link.
 * To do that, you need to pass
 * array(array('name' => $linktext, 'link' => '', 'type' => 'title'))
 * However, becuase this is a very common case, you can use a shortcut syntax, and just
 * pass the string 'Editing forum', instead of an array as $extranavlinks.
 *
 * At the moment, the link types only have limited significance. Type 'activity' is
 * recognised in order to implement the $CFG->hideactivitytypenavlink feature. Types
 * that are known to appear are 'home', 'course', 'activity', 'activityinstance' and 'title'.
 * This really needs to be documented better. In the mean time, try to be consistent, it will
 * enable people to customise the navigation more in future.
 *
 * When passing a $cm object, the fields used are $cm->modname, $cm->name and $cm->course.
 * If you get the $cm object using the function get_coursemodule_from_instance or
 * get_coursemodule_from_id (as recommended) then this will be done for you automatically.
 * If you don't have $cm->modname or $cm->name, this fuction will attempt to find them using
 * the $cm->module and $cm->instance fields, but this takes extra database queries, so a
 * warning is printed in developer debug mode.
 *
 * @uses $CFG
 * @uses $THEME
 *
 * @param mixed $extranavlinks - Normally an array of arrays, keys: name, link, type. If you
 *      only want one extra item with no link, you can pass a string instead. If you don't want
 *      any extra links, pass an empty string.
 * @param mixed $cm - optionally the $cm object, if you want this function to generate the
 *      activity and activityinstance levels of navigation too.
 *
 * @return $navigation as an object so it can be differentiated from old style
 *      navigation strings.
 */
function mfm_build_navigation($extranavlinks, $cm = null) {
    global $CFG, $COURSE;

    if (is_string($extranavlinks)) {
        if ($extranavlinks == '') {
            $extranavlinks = array();
        } else {
            $extranavlinks = array(array('name' => $extranavlinks, 'link' => '', 'type' => 'title'));
        }
    }

    $navlinks = array();

    //Site name
    if ($site = get_site()) {
        $navlinks[] = array(
                'name' => format_string($site->shortname),
                'link' => "$CFG->wwwroot/",
                'type' => 'home');
    }

    // Course name, if appropriate.
    if (isset($COURSE) && $COURSE->id != SITEID) {
        $navlinks[] = array(
                'name' => format_string($COURSE->shortname),
                'link' => "$CFG->wwwroot/course/view.php?id=$COURSE->id",
                'type' => 'course');
    }

    // Activity type and instance, if appropriate.
    if (is_object($cm)) {
        if (!isset($cm->modname)) {
            debugging('The field $cm->modname should be set if you call build_navigation with '.
                    'a $cm parameter. If you get $cm using get_coursemodule_from_instance or '.
                    'get_coursemodule_from_id, this will be done automatically.', DEBUG_DEVELOPER);
            if (!$cm->modname = get_field('modules', 'name', 'id', $cm->module)) {
                error('Cannot get the module type in build navigation.');
            }
        }
        if (!isset($cm->name)) {
            debugging('The field $cm->name should be set if you call build_navigation with '.
                    'a $cm parameter. If you get $cm using get_coursemodule_from_instance or '.
                    'get_coursemodule_from_id, this will be done automatically.', DEBUG_DEVELOPER);
            if (!$cm->name = get_field($cm->modname, 'name', 'id', $cm->instance)) {
                error('Cannot get the module name in build navigation.');
            }
        }
        $navlinks[] = array(
                'name' => get_string('modulenameplural', $cm->modname),
                'link' => $CFG->wwwroot . '/mod/' . $cm->modname . '/index.php?id=' . $cm->course,
                'type' => 'activity');
        $navlinks[] = array(
                'name' => format_string($cm->name),
                'link' => $CFG->wwwroot . '/mod/' . $cm->modname . '/view.php?id=' . $cm->id,
                'type' => 'activityinstance');
    }

    //Merge in extra navigation links
    $navlinks = array_merge($navlinks, $extranavlinks);

    // Work out whether we should be showing the activity (e.g. Forums) link.
    // Note: build_navigation() is called from many places --
    // install & upgrade for example -- where we cannot count on the
    // roles infrastructure to be defined. Hence the $CFG->rolesactive check.
    if (!isset($CFG->hideactivitytypenavlink)) {
        $CFG->hideactivitytypenavlink = 0;
    }
    if ($CFG->hideactivitytypenavlink == 2) {
        $hideactivitylink = true;
    } else if ($CFG->hideactivitytypenavlink == 1 && $CFG->rolesactive &&
            !empty($COURSE->id) && $COURSE->id != SITEID) {
        if (!isset($COURSE->context)) {
            $COURSE->context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
        }
        $hideactivitylink = !has_capability('moodle/course:manageactivities', $COURSE->context);
    } else {
        $hideactivitylink = false;
    }

    //Construct an unordered list from $navlinks
    //Accessibility: heading hidden from visual browsers by default.
    $lastindex = count($navlinks) - 1;
    $i = -1; // Used to count the times, so we know when we get to the last item.
    $first = true;
    $navigation = '';
    foreach ($navlinks as $navlink) {
        $i++;
        $last = ($i == $lastindex);
        if (!is_array($navlink)) {
            continue;
        }
        if ($navlink['type'] == 'activity' && !$last && $hideactivitylink) {
            continue;
        }
        if (!$first) {
            $navigation .= ' -> ';
        }
        if ((!empty($navlink['link'])) && !$last) {
            $navigation .= "<a href=\"{$navlink['link']}\">";
        }
        $navigation .= "{$navlink['name']}";
        if ((!empty($navlink['link'])) && !$last) {
            $navigation .= "</a>";
        }

        $first = false;
    }

    return(array('newnav' => true, 'navlinks' => $navigation));
}

/**
 * Prints breadcrumbs links
 *
 * @uses $CFG
 * @param string $navigation The breadcrumbs string to be printed
 */
function mfm_print_navigation ($navigation, $separator=0, $return=false) {
   global $CFG, $USER;

    if ($navigation) {
        if (is_newnav($navigation)) {
            if ($return) {
                return($navigation['navlinks']);
            } else {
                echo $navigation['navlinks'];
                return;
            }
        } else {
            if (! $site = get_site()) {
                $site->shortname = mfm_get_string('home');
            }
            // &raquo; is not supported in imode :
            //$navigation = str_replace('->', '&raquo;', $navigation);
            $navigation = '<a href="'. $CFG->wwwroot .'/">'. $site->shortname .'</a> -> '. $navigation;
            if ($return) {
                return($navigation);
            } else {
                echo $navigation;
                return;
            }
        }       
    }
}
/**
 * Redirects the user to another page, after printing a notice
 *
 * @param string $url The url to take the user to
 * @param string $message The text message to display to the user about the redirect, if any
 * @param string $delay How long before refreshing to the new page at $url?
 * @todo '&' needs to be encoded into '&amp;' for XHTML compliance,
 *      however, this is not true for javascript. Therefore we
 *      first decode all entities in $url (since we cannot rely on)
 *      the correct input) and then encode for where it's needed
 *      echo "<script type='text/javascript'>alert('Redirect $url');</script>";
 */
function mfm_redirect($url, $message='', $delay='0') {

    global $CFG;
    //$url     = clean_text($url);
    if (!preg_match('/^(http|https):/i', $url)) { // relative url
        if (!empty($CFG->wwwroot)) {
            $urlparts = parse_url($CFG->wwwroot);
        }
    
        if (!empty($urlparts['host'])) {
            $hostname = $urlparts['host'];
        } else if (!empty($_SERVER['SERVER_NAME'])) {
            $hostname = $_SERVER['SERVER_NAME'];
        } else if (!empty($_ENV['SERVER_NAME'])) {
            $hostname = $_ENV['SERVER_NAME'];
        } else if (!empty($_SERVER['HTTP_HOST'])) {
            $hostname = $_SERVER['HTTP_HOST'];
        } else if (!empty($_ENV['HTTP_HOST'])) {
            $hostname = $_ENV['HTTP_HOST'];
        } else {
            notify('Warning: could not find the name of this server!');
            return false;
        }
    
        if (!empty($urlparts['port'])) {
            $hostname .= ':'.$urlparts['port'];
        } else if (!empty($_SERVER['SERVER_PORT'])) {
            if ($_SERVER['SERVER_PORT'] != 80 && $_SERVER['SERVER_PORT'] != 443) {
                $hostname .= ':'.$_SERVER['SERVER_PORT'];
            }
        }
    
        if (isset($_SERVER['HTTPS'])) {
            $protocol = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
        } else if (isset($_SERVER['SERVER_PORT'])) { # Apache2 does not export $_SERVER['HTTPS']
            $protocol = ($_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';
        } else {
            $protocol = 'http://';
        }
    
        $url_prefix = $protocol.$hostname;

        if (!empty($_SERVER['REQUEST_URI'])) {
            $absolute=$url_prefix. dirname($_SERVER['REQUEST_URI']);
    
        } else if (!empty($_SERVER['PHP_SELF'])) {
            $absolute=$url_prefix. dirname($_SERVER['PHP_SELF']);
    
        } else if (!empty($_SERVER['SCRIPT_NAME'])) {
            $absolute=$url_prefix. dirname($_SERVER['SCRIPT_NAME']);
    
        } else if (!empty($_SERVER['URL'])) {     // May help IIS (not well tested)
            $absolute=$url_prefix. dirname($_SERVER['URL']);
    
        }
        $url=$absolute.'/'.$url;
    }
    
    if (!empty($CFG->usesid) && !isset($_COOKIE[session_name()])){
        $url=sid_process_url($url);
    }

    $message = clean_text($message);

    $url = html_entity_decode($url); // for php < 4.3.0 this is defined in moodlelib.php
    $url = str_replace(array("\n", "\r"), '', $url); // some more cleaning
    $encodedurl = htmlentities($url);
    $tmpstr = clean_text('<a href="'.$encodedurl.'" />'); //clean encoded URL
    $encodedurl = substr($tmpstr, 9, strlen($tmpstr)-13);
    $url = addslashes(html_entity_decode($encodedurl));
    if (empty($message)) {
        header('Location: '.$url); 
    } else {
        mfm_print_header('', '', '', '');
        echo '<center>';
        echo '<p>'. $message .'</p>';
        echo '<p>( <a href="'. $encodedurl .'">'. mfm_get_string('continue') .'</a> )</p>';
        echo '</center>';
    }
    die;
}
/**
 * Returns text to be displayed to the user which reflects their login status
 *
 * @uses $CFG
 * @uses $USER
 * @param course $course {@link $COURSE} object containing course information
 * @param user $user {@link $USER} object containing user information
 * @return string
 */
function mfm_user_login_string($course=NULL, $user=NULL) {
    global $USER, $CFG, $SITE;

    if (empty($user) and isset($USER->id)) {
        $user = $USER;
    }

    if (empty($course)) {
        $course = $SITE;
    }


    if (empty($CFG->loginhttps)) {
        $wwwroot = $CFG->wwwroot;
    } else {
        $wwwroot = str_replace('http','https',$CFG->wwwroot);
    }

    if (isset($user->id) and $user->id) {
        $fullname = fullname($user, true);
        $username = $fullname;
        if (isset($user->username) && $user->username == 'guest') {
            $loggedinas = mfm_get_string('loggedinasguest').
                      " (<a href=\"$wwwroot/login/index.php\">".mfm_get_string('login').'</a>)';
        } else {
            $loggedinas = mfm_get_string('loggedinas', 'moodle', $username).
                      " (<a href=\"$CFG->wwwroot/login/logout.php\">".mfm_get_string('logout').'</a>)';
        }
    } else {
        $loggedinas = mfm_get_string('loggedinnot', 'moodle').
                      " (<a href=\"$wwwroot/login/index.php\">".mfm_get_string('login').'</a>)';
    }
    return $loggedinas;
}
/**
 * Implements a complete little popup form
 *
 * @uses $CFG
 * @param string $common  The URL up to the point of the variable that changes
 * @param array $options  Alist of value-label pairs for the popup list
 * @param string $formname Name must be unique on the page
 * @param string $selected The option that is already selected
 * @param string $nothing The label for the "no choice" option
 * @param string $help The name of a help page if help is required
 * @param string $helptext The name of the label for the help button
 * @param boolean $return Indicates whether the function should return the text
 *         as a string or echo it directly to the page being rendered
 * @param string $targetwindow The name of the target page to open the linked page in.
 * @return string If $return is true then the entire form is returned as a string.
 * @todo Finish documenting this function<br>
 */
function mfm_popup_form($common, $options, $formname, $selected='', $nothing='choose', $help='', $helptext='', $return=false, $targetwindow='self') {

    global $CFG;
    static $go, $choose;   /// Locally cached, in case there's lots on a page

    if (empty($options)) {
        return '';
    }

    if (!isset($go)) {
        $go = mfm_get_string('go');
    }

    if ($nothing == 'choose') {
        if (!isset($choose)) {
            $choose = mfm_get_string('choose');
        }
        $nothing = $choose.'...';
    }

    $startoutput = '<form action="'.$CFG->wwwroot.'/course/jumpto.php"'.
                        ' method="get"'.
                        '>';

    $output = '<select name="jump">'."\n";


    $inoptgroup = false;
    foreach ($options as $value => $label) {

       if (!empty($CFG->usesid) && !isset($_COOKIE[session_name()]))
        {
            $url=sid_process_url( $common . $value );
        } else
        {
            $url=$common . $value;
        }
        $optstr = '   <option value="' . $url . '"';

        if ($value == $selected) {
            $optstr .= ' selected="selected"';
        }

        if ($label) {
            $optstr .= '>'. $label .'</option>' . "\n";
        } else {
            $optstr .= '>'. $value .'</option>' . "\n";
        }

        $output .= $optstr;

    }



    $output .= '</select>';
    $output .= '<input type="submit" value="'.$go.'" />';
    $output .= '</form>' . "\n";

    if ($help) {
        $button = helpbutton($help, $helptext, 'moodle', true, false, '', true);
    } else {
        $button = '';
    }

    if ($return) {
        return $startoutput.$button.$output;
    } else {
        echo $startoutput.$button.$output;
    }
}
/**
 * Print a message along with "Yes" and "No" links for the user to continue.
 *
 * @param string $message The text to display
 * @param string $linkyes The link to take the user to if they choose "Yes"
 * @param string $linkno The link to take the user to if they choose "No"
 */
function mfm_notice_yesno ($message, $linkyes, $linkno) {

    global $CFG;

    $message = clean_text($message);
    $linkyes = clean_text($linkyes);
    $linkno = clean_text($linkno);

    echo '<p align="center">'. $message .'</p>';
    mfm_print_single_button($linkyes, NULL, mfm_get_string('yes'), 'post', $CFG->framename);
    mfm_print_single_button($linkno, NULL, mfm_get_string('no'), 'post', $CFG->framename);
}

/**
 * Print a self contained form with a single submit button.
 *
 * @param string $link ?
 * @param array $options ?
 * @param string $label ?
 * @param string $method ?
 * @todo Finish documenting this function
 */
function mfm_print_single_button($link, $options, $label='OK', $method='get', $target='_self') {
    echo '<form action="'. $link .'" method="'. $method .'" >';
    if ($options) {
        foreach ($options as $name => $value) {
            echo '<input type="hidden" name="'. $name .'" value="'. $value .'" />';
        }
    }
    echo '<center><input type="submit" value="'. $label .'" /></center></form>';
}
/**
 * Print a bold message in an optional color.
 *
 * @param string $message The message to print out
 * @param string $style Optional style to display message text in
 * @param string $align Alignment option
 */
function mfm_notify ($message, $style='', $align='center') {

    $message = clean_text($message);

    echo '<h2 align="'. $align .'">'. $message .'</h2>'."<br />\n";
}
/**
 * Print a link to continue on to another page.
 *
 * @uses $CFG
 * @param string $link The url to create a link to.
 */
function mfm_print_continue($link) {

    if (!$link) {
        $link = $_SERVER['HTTP_REFERER'];
    }

    mfm_print_single_button($link, NULL, mfm_get_string('continue'), 'post');
}

/**
 * Print an error page displaying an error message.
 *
 *
 * @uses $SESSION
 * @uses $CFG
 * @param string $message The message to display to the user about the error.
 * @param string $link The url where the user will be prompted to continue. If no url is provided the user will be directed to the site index page.
 */
function mfm_error ($message, $link='') {
    global $CFG, $SESSION;

    if (! defined('HEADER_PRINTED')) {
        //header not yet printed
        mfm_print_header(get_string('error'));
    }    
    echo '<br />';

    $message = clean_text($message);   // In case nasties are in here
    echo $message.'<br><br>';

    if (!$link) {
        if ( !empty($SESSION->fromurl) ) {
            $link = $SESSION->fromurl;
            unset($SESSION->fromurl);
        } else {
            $link = $CFG->wwwroot .'/';
        }
    }
    mfm_print_continue($link);
    mfm_print_footer();
    die;
}

function mfm_print_error($errorcode){
        if (empty($module) || $module == 'moodle' || $module == 'core') {
        $module = 'error';
        $modulelink = 'moodle';
    } else {
        $modulelink = $module;
    }
    
    mfm_error(mfm_get_string($errorcode, 'error'));
}

/**
 * Start mbstring output buffering to convert from internal encoding to 
 * encoding $charset. Throws an error if mbstring extension not available.
 *
 * @param string $charset The character set to convert all output to.
 */
function mfm_setup($charset='SJIS') {
    global $CFG, $USER;
    defined('MOODLE_INTERNAL') or die('Direct access to this script is forbidden.');
    if(function_exists('mb_http_output')){
        // Enable output character encoding conversion only for this page
        
        // Set HTTP output character encoding to SJIS
        mb_http_output($charset);
        mb_internal_encoding(current_charset());
        // Start buffering and specify "mb_output_handler" as
        // callback function
        ob_start('mb_output_handler');
    } else    {
        mfm_error("You need to install the mbstring PHP extension in order for Moodle for Mobiles to be able to display Japanese characters.");
    }
    /*
    //logging of mobile accesses turn this on to see who is accessing your site and log whether they have cookies on.
    $filename = "{$CFG->dataroot}/mfm_log.txt";
    $somecontent = date("l dS of F Y h:i:s A").' : '.((isset($USER->username))?$USER->username:'no user name').' : '.$_SERVER['HTTP_USER_AGENT'].' : '.$CFG->mfm_agent.' : '.
     ((!empty($CFG->usesid) && !isset($_COOKIE[session_name()]))?'Cookie Not Set':'Cookie Set')."\n";
    
    // Let's make sure the file exists and is writable first.
    if (!is_writable($filename)) {
       if (!$handle = fopen($filename, 'w')) {
            mfm_error("Cannot open file ($filename)");
            exit;
       }
    }else{
       // In our example we're opening $filename in append mode.
       // The file pointer is at the bottom of the file hence 
       // that's where $somecontent will go when we fwrite() it.
       if (!$handle = fopen($filename, 'a')) {
            mfm_error("Cannot open file ($filename)");
            exit;
       }
    }
    
    // Write $somecontent to our opened file.
    if (fwrite($handle, $somecontent) === FALSE) {
       mfm_error("Cannot write to file ($filename)");
       exit;
    }
    fclose($handle);
    
    */

}
/**
 * Print a message and exit.
 *
 * @uses $CFG
 * @param string $message ?
 * @param string $link ?
 * @todo Finish documenting this function
 */
function mfm_notice ($message, $link='') {
    global $CFG;

    $message = clean_text($message);
    $link    = clean_text($link);

    if (!$link) {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $link = $_SERVER['HTTP_REFERER'];
        } else {
            $link = $CFG->wwwroot .'/';
        }
    }

    echo '<br />';
    echo '<centre>';
    echo($message);
    echo '</centre>';
    print_continue($link);
    mfm_print_footer(get_site());
    die;
}

/**
 * Filter html removing tags we don't want to send to mobile phones and otherwise
 * formatting html so it will work on a phone.
 * This function can be used as a quick fix to convert some xhtml to chtml.
 *
 * @param string $text
 * @return string filtered text.
 */
 function mfm_filter($text){
     global $redirectto;
     $redirectto='';
     $needle='#<meta http\-equiv\="refresh" content="([^;]*);\s*url=([^"]*)" />#';
     if (0!==preg_match($needle, $text,$httpequivparts)){
         if ($httpequivparts[1]==='0'){
             //no message
             mfm_redirect($httpequivparts[2]);
         } else
         {
             //find the message * TODO not tested
             preg_match('/<center><p>(.*?)<\/p><p>\( <a href="/',$text,$bodyparts);
            mfm_redirect($httpequivparts[2], $bodyparts[1], $httpequivparts[1]);
         }
     }
     $search = array(
         //replace any &amp; within href with &
        '/(<\s*(a|form)\s[^>]*(href|action)\s*=\s*\'[^\']*)&amp;([^\']*\')/i',
        '/(<\s*(a|form)\s[^>]*(href|action)\s*=\s*"[^"]*)&amp;([^"]*")/i',
        //get rid of target parameter in html
        '/(<\s*(a|form)\s[^>]*)(target\s*=\s*\'[^\']*\')/i',
        '/(<\s*(a|form)\s[^>]*)(target\s*=\s*"[^"]*")/i',
        //no tables or div tags
        '#<\s*/?\s*(table|td|div)[^>]*>#i',
        '#<\s*/?\s*tr[^>]*>#i');
     $replacements = array(
         '\1&\4',
         '\1&\4',
         '\1',
         '\1',
         
         '',
         '<br>');
     
     $text=preg_replace($search, $replacements, $text);

     return $text;
 }
 /**
* Print a box with quiz start and due dates
*
* @param object $quiz
*/
function mfm_quiz_view_dates($quiz) {
    if (!$quiz->timeopen && !$quiz->timeclose) {
        return;
    }

    if ($quiz->timeopen) {
        echo mfm_get_string('availabledate','assignment').':';
        echo userdate($quiz->timeopen).'<br>';
    }
    if ($quiz->timeclose) {
        echo mfm_get_string('duedate','assignment').':';
        echo userdate($quiz->timeclose).'<br>';
    }
    echo '<hr width="60%">';
}
function mfm_get_page_no($default=0){
    //in mfm we can't use javascript to pass the pageno. The page no is passed as part of the name of a submit button
    //the name of the submit button is called pagenoxx where xx is the next page no to go to. So if 
    //$_POST['pagenoxx'] is set we know one of the navigation panel submit buttons has been pressed.
    $page=$default;
    $submittedvars=array_keys($_POST);
    foreach ($submittedvars as $submittedvar) {
        if (strpos($submittedvar, 'pageno')===0){
            $page=intval(substr($submittedvar, 6));
            continue;
        }
    };   
    return $page;
};



/**
 * Prints a maintenance message from /maintenance.html
 */
function mfm_print_maintenance_message () {
    global $CFG, $SITE;

    mfm_print_header(strip_tags($SITE->fullname), $SITE->fullname, 'home');
    mfm_print_heading(mfm_get_string('sitemaintenance', 'admin'));
    @include($CFG->dataroot.'/1/maintenance.html');
    mfm_print_footer();
}

?>
