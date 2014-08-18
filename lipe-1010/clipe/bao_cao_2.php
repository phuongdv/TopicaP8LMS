
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report</title>
</head>

<body  style="padding:30px">

<?php
require_once( 'config.php' );
if ( isset($_REQUEST['cid']) && $_REQUEST['cid'] != ''){
$c_id = $_REQUEST['cid'];
$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
$mysqli->select_db($dbmain);
$mysqli->query("SET NAMES 'utf8'");
	$ad = $mysqli->query("select * from mdl_user where id in (select distinct userid from mdl_course_display where course = $c_id) and id not in (select userid from mdl_role_assignments where roleid in (1,2,3,4))");

	while($dd = $ad->fetch_assoc()) 
	{
		echo $dd['id'] . '	' .$dd['lastname'] . ' ' . $dd['firstname']. '	';
		u_co($dd['id'],$c_id);
		//u_in_c($dd['id'],4);
		echo '<br>';
	}
$ad->close();
$mysqli->close();
}
function u_post ($u_id,$st,$en,$fo){
	global $mysqli;
		$sql1 = "select count(*)  from mdl_forum_posts where created BETWEEN UNIX_TIMESTAMP('$st') and UNIX_TIMESTAMP('$en') and discussion in (select id from mdl_forum_discussions where forum = $fo)  and userid = $u_id;";
	//	echo $sql1.'<br>';
		$ad1 = $mysqli->query($sql1);
			while($dd1 = $ad1->fetch_assoc()) 
			{
				echo 'Post: '.$dd1['count(*)'].':';
			}
		$ad1->close();
}

function u_grade ($u_id,$st,$en,$quiz){
		global $mysqli;
			$sql2 = "select grade from mdl_quiz_grades where quiz = $quiz and userid = $u_id;";
	//	echo $sql2.'<br>';
		$ad2 = $mysqli->query($sql2);
		if ( $mysqli->affected_rows > 0 ){
			while($dd2 = $ad2->fetch_assoc()) 
			{
				echo 'grade: '.$dd2['grade'].':';
			}
		} else { echo 'grade: N/A'; }
		$ad2->close();
}

function u_m_week ($u_id,$w_n,$c_id){
			global $mysqli;
		$sql3 = "select c.week_number,c.start_date,c.end_date,l.lipe_type,l.active_id from huy_setting_calendar c, huy_setting_lipe l where c.week_number = l.week_number and c.c_id = $c_id and c.week_number = $w_n;";
	//	echo $sql2.'<br>';
		$ad3 = $mysqli->query($sql3);
			while($dd3 = $ad3->fetch_assoc()) 
			{
				if( $dd3['lipe_type'] == 'I'){
			//	echo '@'.$u_id.'@'.$dd3['start_date'].'@'.$dd3['end_date'].'@'.$dd3['active_id'].'#F';
				u_post ($u_id,$dd3['start_date'],$dd3['end_date'],$dd3['active_id']);
			//	echo '<br>';
				} else {
			//	echo '@'.$u_id.'@'.$dd3['start_date'].'@'.$dd3['end_date'].'@'.$dd3['active_id'].'#E';
				u_grade ($u_id,$dd3['start_date'],$dd3['end_date'],$dd3['active_id']);
			//	echo '<br>';
				}
				//
			}
		$ad3->close();
			
}

function u_co ($u_id,$c_id){
	global $mysqli;
		$sql4 = "select * from huy_setting_calendar where c_id = $c_id;";
		//echo $sql4.'<br>';
		$ad4 = $mysqli->query($sql4);
			while($dd4 = $ad4->fetch_assoc()) 
			{
				echo 'Tuan '.$dd4['week_number'].' :';
				u_m_week ($u_id,$dd4['week_number'],$c_id);
			}
		$ad4->close();
}

?>


</body>
</html>