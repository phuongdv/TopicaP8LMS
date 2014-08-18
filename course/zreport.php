<?php // $Id: report.php,v 1.6.2.2 2008/11/29 14:30:56 skodak Exp $
      // Display all the interfaces for importing data into a specific course

    require_once('../config.php');

    $id = required_param('id', PARAM_INT);   // course id to import TO

    if (!$course = get_record('course', 'id', $id)) {
        error("That's an invalid course id");
    }

    require_login($course);

    $context = get_context_instance(CONTEXT_COURSE, $course->id);
    require_capability('moodle/site:viewreports', $context); // basic capability for listing of reports

    $strreports = get_string('reports');

    $navlinks = array();
    $navlinks[] = array('name' => $strreports, 'link' => null, 'type' => 'misc');
    $navigation = build_navigation($navlinks);
    print_header($course->fullname.': '.$strreports, $course->fullname.': '.$strreports, $navigation);

    $directories = get_list_of_plugins('course/report');

/*    foreach ($directories as $directory) {
        $pluginfile = $CFG->dirroot.'/course/report/'.$directory.'/mod.php';
        if (file_exists($pluginfile)) {
            ob_start();
            include($pluginfile);  // Fragment for listing
            $html = ob_get_contents();
            ob_end_clean();
            // add div only if plugin accessible
            if ($html !== '') {
                echo '<div class="plugin">';
                echo $html;
                echo '</div>';
            }
        }
    }*/

$hocvien = mysql_query("SELECT DISTINCT u.id, u.username, u.firstname, u.lastname, u.email, u.city, u.country, u.picture, u.lang, u.timezone, u.emailstop, u.maildisplay, u.imagealt, COALESCE( ul.timeaccess, 0 ) AS lastaccess, r.hidden, ctx.id AS ctxid, ctx.path AS ctxpath, ctx.depth AS ctxdepth, ctx.contextlevel AS ctxlevel
FROM mdl_user u
LEFT OUTER JOIN mdl_context ctx ON ( u.id = ctx.instanceid
AND ctx.contextlevel ='.CONTEXT_USER.' ) 
JOIN mdl_role_assignments r ON u.id = r.userid
LEFT OUTER JOIN mdl_user_lastaccess ul ON ( r.userid = ul.userid
AND ul.courseid =$course->id ) 
WHERE (

r.contextid =$context->id
OR r.contextid
IN ( 14, 10, 1 ) 

)
AND u.deleted =0
AND (

ul.courseid =$course->id
OR ul.courseid IS NULL 

)
AND u.username != 'guest'
AND r.roleid NOT 
IN ( 1, 2, 3, 4, 6, 8, 11 ) 
ORDER BY id ASC , r.hidden DESC 

");



$lecture = mysql_query("SELECT cm.id, COUNT('x') AS numviews, MAX(time) AS lasttime

              FROM mdl_course_modules cm

                   JOIN mdl_modules m ON m.id = cm.module

                   JOIN mdl_log l     ON l.cmid = cm.id

             WHERE cm.course =$course->id AND l.action LIKE 'view%' AND m.visible = 1

          GROUP BY cm.id ");


echo "<table width='100%' border='1'>
<tr>
<th>ID Hoc Vien</th>
<th>Hoc Vien</th>

</tr>";

while($row = mysql_fetch_array($hocvien))
  {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['lastname'] . " " . $row['firstname'] ."</td>";

  echo "</tr>";
  }
/*
while($row = mysql_fetch_array($lecture))
  {
  echo "<tr>";
  echo "<td>" . $row['lastname'] . "</td>";
  echo "</tr>";
  }*/
echo "</table>";


    print_footer();
?>
