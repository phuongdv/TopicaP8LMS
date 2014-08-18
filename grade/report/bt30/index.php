<?php
require_once '../../../config.php';
require_once $CFG->libdir.'/gradelib.php';
require_once $CFG->dirroot.'/grade/lib.php';
require_once $CFG->dirroot.'/grade/report/grader/lib.php';
$courseid      = $_GET['id'];        // course id
require_login($course);
print_header("Xem kết quả BT30, BT72 ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");

 $mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);	
 $mysqli->select_db($CFG->dbname);	    
 $mysqli->query("SET NAMES 'utf8'");
 
 
 // xem  course nay co quiz nao trong bt30
 $sql_get_quiz = "select * from mdl_quiz where id in (select distinct quizid from vietth_q169_de where course_id=$courseid) order by id";

 $rc_quiz = $mysqli->query($sql_get_quiz);

 while($quiz = $rc_quiz->fetch_assoc())
 {
	 $arr_quiz[] = $quiz;
 }
 

// lay ra ds hoc vien cua lop

$sql_user ="SELECT u.id,CONCAT_WS(' ' ,u.lastname,u.firstname) ho_ten
			FROM mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			where c.id = $courseid 
      and roleid = 5
      ORDER BY u.firstname, u.lastname";
	  //echo $sql_user;
 $rc = $mysqli->query($sql_user);
 ?>
 <div align="left" style="font-weight:bold;font-size:13pt;color:#810c15" >Mã màn hình: F-270713: Chức năng xem danh sách điểm BT30, BT72</div>
 <div align="center"><a style="font-weight:bold;font-size:13pt;color:#810c15" href="/grade/report/grader/index.php?id=<?php echo $courseid;?>" >Quay lại block Điểm</a></div>
 <table width="944" border="1" cellpadding="3">
  <tr bgcolor="#ccc" style="color:#810c15;font-size:12pt">
    <th>Họ tên</th>
   
    <?php
	foreach($arr_quiz as $quiz)
	{
		echo  '<th>'.$quiz['name'].'</th>';
	}
	?>
  </tr>



 <?php
 
 
 while($arr_hv = $rc->fetch_assoc())
 {
   echo  '<tr>
    <td>'.$arr_hv['ho_ten'].'</td>';
     
	foreach($arr_quiz as $quiz)
	{
		echo  '<td align="center">'.get_diem($arr_hv['id'],$quiz['id'],$quiz['grademethod']).'</td>';
	}

  echo'</tr>' ;
 }
?>
 </table><br /><br />
 
 <div align="center"><a style="font-weight:bold;font-size:13pt;color:#810c15" href="/grade/report/grader/index.php?id=<?php echo $courseid;?>" >Quay lại block Điểm</a></div>
<?php 
function get_diem($uid,$quizid,$quiz_grade_method)
 {
	global $mysqli;
	if($quiz_grade_method == 2) // trung binh
	{
	 $sql  = "select avg(sumgrade) grade from vietth_q169_attempts where userid = ".$uid." and deleted=0 and status='submited' and quiz = ".$quizid;				
     $rc = $mysqli->query($sql);
	 $dd = $rc->fetch_assoc();
	 if ($dd['grade']==null) return '';
	 $bt30grade = round($dd['grade'],1);
	 return $bt30grade;

	}
	else
	{
	$sql  = "select max(sumgrade) grade from vietth_q169_attempts where userid = ".$uid." and deleted=0 and status='submited' and quiz = ".$quizid;					    $rc = $mysqli->query($sql);
    $dd = $rc->fetch_assoc();
	if ($dd['grade']==null) return '';
    $bt30grade = round($dd['grade'],1);	
	return $bt30grade;
	}
 
 }

print_footer($course);

?>