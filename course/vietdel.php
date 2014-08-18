<?php
    require_once("../config.php");
	
	    $id     = required_param('id', PARAM_INT);   
		
	   if (! $course = get_record("course", "id", $id)) {
        error("Course ID was incorrect (can't find it)");
    }

    $category = get_record("course_categories", "id", $course->category);
    $navlinks = array();	
	 add_to_log(SITEID, "course", "delete", "view.php?id=$course->id", "$course->fullname (ID $course->id)");

    $strdeletingcourse = get_string("deletingcourse", "", format_string($course->shortname));

    $navlinks[] = array('name' => $stradministration, 'link' => "../$CFG->admin/index.php", 'type' => 'misc');
    $navlinks[] = array('name' => $strcategories, 'link' => "index.php", 'type' => 'misc');
    $navlinks[] = array('name' => $category->name, 'link' => "category.php?id=$course->category", 'type' => 'misc');
    $navlinks[] = array('name' => $strdeletingcourse, 'link' => null, 'type' => 'misc');
    $navigation = build_navigation($navlinks);

    print_header("$site->shortname: $strdeletingcourse", $site->fullname, $navigation);

    print_heading($strdeletingcourse);

    delete_course($course);
    fix_course_sortorder(); //update course count in catagories

    print_heading( get_string("deletedcourse", "", format_string($course->shortname)) );

    print_continue("category.php?id=$course->category");

    print_footer();

	
?>