<?php  // $Id: index.php,v 1.15 2008/02/06 09:28:37 jamiesensei Exp $
       // index.php - the front page.
    mfm_setup();

    require_once($CFG->mfm_dirroot.'/course/lib.php');
    

    if ($CFG->forcelogin) {
        require_login();
    }

    if (get_moodle_cookie() == '') {   
        set_moodle_cookie('nobody');   // To help search for cookies on login page
    }

    if (!empty($USER->id)) {
        add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
    }

    if (empty($CFG->langmenu)) {
        $langmenu = '';
    } else {
        $currlang = current_language();
        $langs = mfm_get_list_of_languages();
        $langmenu = mfm_popup_form ($CFG->wwwroot .'/index.php?lang=', $langs, 'chooselang', $currlang, '', '', '', true);
    }


    mfm_print_header(strip_tags($SITE->fullname), $SITE->fullname, 'home', '',
                 '<meta name="description" content="'. s(strip_tags($SITE->summary)) .'" />',
                 true, '', mfm_user_login_string($SITE).$langmenu);

/// Print Section
    if ($SITE->numsections > 0) {

        if (!$section = get_record('course_sections', 'course', $SITE->id, 'section', 1)) {
            delete_records('course_sections', 'course', $SITE->id, 'section', 1); // Just in case
            $section->course = $SITE->id;
            $section->section = 1;
            $section->summary = '';
            $section->sequence = '';
            $section->visible = 1;
            $section->id = insert_record('course_sections', $section);
        }
        if (!empty($section->sequence)) {
    
            mfm_get_all_mods($SITE->id, $mods, $modnames, $modnamesplural, $modnamesused);
            $sectionmods = explode(",", $section->sequence);

            $section->mfmvisible=false;   
    
            foreach ($sectionmods as $modnumber) {
                if (!empty($mods[$modnumber])) {
                    $section->mfmvisible=true;
                    break;   
                }
            }
        }

        if (!empty($section->mfmvisible)){
            echo '<hr>';
            if (!empty($section->summary)){
                $options = NULL;
                $options->noclean = true;
                echo format_text($section->summary, FORMAT_HTML, $options).'<br>';
            }

            mfm_print_section($SITE, $section, $mods, $modnamesused, true);
    
            echo '<hr>';
        }
    }

    foreach (explode(',',$CFG->frontpage) as $v) {
        switch ($v) {     /// Display the main part of the front page.
            case strval(FRONTPAGENEWS):
/* news disabled for now on mobiles
                if ($SITE->newsitems) { // Print forums only when needed
                    require_once($CFG->dirroot .'/mod/forum/lib.php');

                    if (! $newsforum = forum_get_course_forum($SITE->id, 'news')) {
                        error('Could not find or create a main news forum for the site');
                    }

                    if (isset($USER->id)) {
                        $SESSION->fromdiscussion = $CFG->wwwroot;
                        if (forum_is_subscribed($USER->id, $newsforum->id)) {
                            $subtext = mfm_get_string('unsubscribe', 'forum');
                        } else {
                            $subtext = mfm_get_string('subscribe', 'forum');
                        }
                        $headertext = '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>'.
                            '<td><div class="title">'.$newsforum->name.'</div></td>'.
                            '<td><div class="link"><a href="mod/forum/subscribe.php?id='.$newsforum->id.'">'.$subtext.'</a></div></td>'.
                            '</tr></table>';
                    } else {
                        $headertext = $newsforum->name;
                    }

                    mfm_print_heading_block($headertext);
                    forum_print_latest_discussions($SITE, $newsforum, $SITE->newsitems);
                }
*/
            break;


/*            case FRONTPAGECATEGORYNAMES:

                print_heading_block(mfm_get_string('categories'));
                print_simple_box_start('center', '100%', '', 5, 'categorybox');
                print_whole_category_list();
                /*print_simple_box_end();
                print_course_search('', false, 'short');
            break;*/

            case FRONTPAGETOPICONLY:    // Do nothing!!  :-)
            break;
            case FRONTPAGECOURSELIST:
            default:

/*                if (isloggedin() && !isset($USER->admin) && empty($CFG->disablemycourses)) {
                    mfm_print_heading_block(mfm_get_string('mycourses'));
                    print_my_moodle();
                } else {
                    if (count_records('course_categories') > 1) {
                        if ($v == FRONTPAGECOURSELIST) {
                            mfm_print_heading_block(mfm_get_string('availablecourses'));
                        } else {
                            mfm_print_heading_block(mfm_get_string('categories'));
                        }
                        echo '<hr>';
                        print_whole_category_list();
                        echo '<hr>';
                    } else {*/
                        mfm_print_heading_block(mfm_get_string('availablecourses'));
                        mfm_print_courses(0, '100%');
   /*                   }
                }*/
            break;

        }
        echo '<br />';
    }
    mfm_print_footer('home');     // Please do not modify this line
    exit;
?>
