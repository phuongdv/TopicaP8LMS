<?php // $Id: index.php,v 1.11 2008/01/25 09:12:28 jamiesensei Exp $
      // For most people, just lists the course categories
      // Allows the admin to create, delete and rename course categories

    mfm_setup();
    require_once($CFG->mfm_dirroot.'/course/lib.php');


    if (!$site = get_site()) {
        mfm_error("Site isn't defined!");
    }

    if ($CFG->forcelogin) {
        mfm_require_login();
    }



/// Unless it's an editing admin, just print the regular listing of courses/categories

//    $countcategories = count_records("course_categories");

////    if ($countcategories > 1) {
//        $strcourses = mfm_get_string("courses");
//        $strcategories = mfm_get_string("categories");
//        mfm_print_header("$site->shortname: $strcategories", $strcourses, 
//                      $strcategories, "", "", true, update_categories_button());
//        mfm_print_heading($strcategories);
//        print_whole_category_list();
////    } else {
        $strfulllistofcourses = mfm_get_string("fulllistofcourses");
        mfm_print_header("$site->shortname: $strfulllistofcourses", $strfulllistofcourses, $strfulllistofcourses,
                     '', '', true, update_categories_button());
        mfm_print_courses(0, "80%");
//    }

    mfm_print_footer();
    die();
?>
