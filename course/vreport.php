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

$query = "select
mdl_course.fullname,
count(mdl_log.action)
solanview
from
mdl_course,mdl_log
where
mdl_course.id=mdl_log.course and mdl_log.action = 'view' and mdl_course.id ='$id'
group by mdl_course.fullname";

$result = mysql_query($query);
echo"<table width=\"500\" border=\"1\">
  <tr>
    <td>ten lop</td>
    <td>so lan view</td>
  </tr>";
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
    echo "<tr>
    <td>{$row['fullname']}</td>
    <td>{$row['solanview']}</td>
  </tr>" ;
}







while($row = mysql_fetch_array($hocvien))
  {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['lastname'] . " " . $row['firstname'] ."</td>";
  echo "<td>" . $row['lastname'] . " " . $row['firstname'] ."</td>";
  echo "<td>" . $row['lastname'] . " " . $row['firstname'] ."</td>";
  echo "<td>" . $row['lastname'] . " " . $row['firstname'] ."</td>";
  echo "<td>" . $row['lastname'] . " " . $row['firstname'] ."</td>";
  echo "<td>" . $row['lastname'] . " " . $row['firstname'] ."</td>";
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
