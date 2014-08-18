<?php // $Id: report.php,v 1.6.2.2 2008/11/29 14:30:56 skodak Exp $
      // Display all the interfaces for importing data into a specific course

    require_once('../config.php');

    if ($course->id != SITEID) {
        require_login($course);
    } else if (!isloggedin()) {
        if (empty($SESSION->wantsurl)) {
            $SESSION->wantsurl = $CFG->httpswwwroot.'/user/edit.php';
        }
        redirect($CFG->httpswwwroot.'/login/index.php');
    }
    
    $PAGE       = page_create_object(PAGE_COURSE_VIEW, SITEID);
    $pageblocks = blocks_setup($PAGE);
    $editing    = $PAGE->user_is_editing();
    $preferred_width_left  = bounded_number(BLOCK_L_MIN_WIDTH, blocks_preferred_width($pageblocks[BLOCK_POS_LEFT]),
                                            BLOCK_L_MAX_WIDTH);
    $preferred_width_right = bounded_number(BLOCK_R_MIN_WIDTH, blocks_preferred_width($pageblocks[BLOCK_POS_RIGHT]),
                                            BLOCK_R_MAX_WIDTH);
    print_header($SITE->fullname, $SITE->fullname, 'home', '',
                 '<meta name="description" content="'. strip_tags(format_text($SITE->summary, FORMAT_HTML)) .'" />',
                 true, '', user_login_string($SITE).$langmenu);

?>


  <?php
    $lt = (empty($THEME->layouttable)) ? array('left', 'middle', 'right') : $THEME->layouttable;
    foreach ($lt as $column) {
        switch ($column) {
            case 'left':
            break;
            case 'middle':

    print_container_start();
	include("report/index.php");
    print_container_end();

            break;
            case 'right':
            break;
        }
    }
?>


<?php
    print_footer('home');     // Please do not modify this line
?>
