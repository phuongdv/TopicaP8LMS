
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report</title>
</head>

<body  style="padding:30px">

<?php
require_once( 'config.php' );
$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
$mysqli->select_db($dbmain);
$mysqli->query("SET NAMES 'utf8'");
//uer:144,2009-03-12,2009-03-29,3
function u_post ($u_id,$st,$en,$fo){
	global $mysqli;
		$sql1 = "select count(*)  from mdl_forum_posts where created BETWEEN UNIX_TIMESTAMP('$st') and UNIX_TIMESTAMP('$en') and discussion in (select id from mdl_forum_discussions where forum = $fo)  and userid = $u_id;";
		echo $sql1.'<br>';
		$ad1 = $mysqli->query($sql1);
			while($dd1 = $ad1->fetch_assoc()) 
			{
				echo $dd1['count(*)'];
			}
		$ad1->close();
}

function u_grade ($u_id,$st,$en,$quiz){
		global $mysqli;
			$sql2 = "select grade from mdl_quiz_grades where quiz = $quiz and userid = $u_id;";
	//	echo $sql2.'<br>';
		$ad2 = $mysqli->query($sql2);
			while($dd2 = $ad2->fetch_assoc()) 
			{
				echo $dd2['grade'];
			}
		$ad2->close();
}

function u_m_week ($u_id,$w_n,$c_id){
			global $mysqli;
		$sql2 = "select c.week_number,c.start_date,c.end_date,l.lipe_type,l.active_id from huy_setting_calendar c, huy_setting_lipe l where c.week_number = l.week_number and c.c_id = $c_id and c.week_number = $w_n;";
	//	echo $sql2.'<br>';
		$ad2 = $mysqli->query($sql2);
			while($dd2 = $ad2->fetch_assoc()) 
			{
				if( $dd2['lipe_type'] == 'I'){
				u_post ($u_id,$dd2['start_date'],$dd2['end_date'],$dd2['active_id']);
				} else {u_grade ($u_id,$dd2['start_date'],$dd2['end_date'],$dd2['active_id']);}
				echo '@'.$u_id.'@'.$dd2['start_date'].'@'.$dd2['end_date'].'@'.$dd2['active_id'].'#';
			}
		$ad2->close();
			
}

u_post (144,'2009-03-12','2009-03-29',3);
//u_grade (144,'2009-03-12','2009-03-29',11);
u_m_week (144,1,4);
$mysqli->close();

?>


</body>
</html>