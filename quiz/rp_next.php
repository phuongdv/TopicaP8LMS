<?php
// create by vietth

require_once("../../config.php");global $CFG;require_once($CFG->libdir.'/phpmailer51/class.phpmailer.php');
require_login();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
$current=time();
$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
$dbname = $CFG->dbname;
    mysql_select_db($dbname);
	mysql_query("SET NAMES 'utf8'");
	$query_string = "select mdl_quiz.timeclose time,FROM_UNIXTIME(mdl_quiz.timeclose) ngay from mdl_quiz,mdl_course where mdl_quiz.course=mdl_course.id and timeclose >= '".$current."' GROUP BY  mdl_quiz.timeclose ";
	
	$data = mysql_query($query_string);
		echo '<div align="center"><table width="800" border="1">
  <tr>
    <td width="50" align="center">Stt</td>
    <td align="center">Ngày</td>
    <td align="center">Số Bài </td>
    <td align="center">Course</td>
  </tr>';
    
    while($info = mysql_fetch_array( $data )) 
     { 
     
 
     echo '<tr>';
     echo '<td > </td>'; 	
     echo "<td align=\"center\">".$info['ngay']."</td>"; 
       $sql_countquiz="select count(id) count from mdl_quiz where timeclose='".$info['time']."'";
       
       $quizdata=mysql_query($sql_countquiz);
       $quizcount=mysql_fetch_array( $quizdata );
       echo '<td align="center">'.$quizcount['count'].'</td>';
       $sql_course="select distinct (mdl_quiz.course) courseid,mdl_course.fullname coursename from mdl_quiz,mdl_course where mdl_course.id=mdl_quiz.course and mdl_quiz.timeclose='".$info['time']."'";
 
       $coursedata=mysql_query($sql_course);
      // $courses=mysql_fetch_array( $coursedatadata );
      echo '<td align="center">';
       while($courses=mysql_fetch_array( $coursedata)) 
       {
       	echo"<a target=\"_blank\" href=\"http://elearning.hou.topica.vn/course/view.php?id=".$courses['courseid']."\"><br>". $courses['coursename']."</a>";
       }
       echo "</td></tr>";
   
  
 } 
 echo'</table></div>';
	
	$mysqli->close();

print_footer($site); 
?>