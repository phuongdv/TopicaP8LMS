<head>
<meta http-equiv="refresh" content="2" />
</head>
<?php
ini_set('display_errors','On');
    require_once("../config.php");
	
	mysql_connect($CFG->dbhost,$CFG->dbuser ,$CFG->dbpass ) or die(mysql_error()); 
	mysql_select_db($CFG->dbname) or die(mysql_error()); 
	
	 $data = mysql_query("SELECT * FROM mdl_course where id not in (1333,1) limit 0,1");
set_time_limit(0);
 while($info = mysql_fetch_array( $data )) 
 {  
    $id     = $info['id'];
	   if (! $course = get_record("course", "id", $id)) {
        error("Course ID was incorrect (can't find it)");
    }
    $category = get_record("course_categories", "id", $course->category);
    $navlinks = array();	
    $strdeletingcourse = get_string("deletingcourse", "", format_string($course->shortname));
    $navlinks[] = array('name' => $stradministration, 'link' => "../$CFG->admin/index.php", 'type' => 'misc');
    $navlinks[] = array('name' => $strcategories, 'link' => "index.php", 'type' => 'misc');
    $navlinks[] = array('name' => $category->name, 'link' => "category.php?id=$course->category", 'type' => 'misc');
    $navlinks[] = array('name' => $strdeletingcourse, 'link' => null, 'type' => 'misc');
    delete_course($course);
    fix_course_sortorder(); //update course count in catagories
 } 
	   

	
?>