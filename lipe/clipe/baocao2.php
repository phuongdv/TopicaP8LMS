
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Report</title>
</head>

<body  topmargin="10">
<?php
require_once( 'config.php' );
$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
$mysqli->select_db($dbmain);

//$mysqli->query("SET NAMES 'utf8'");
echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"tb_main\" width=\"1024\" align=\"center\">";
echo "<tr height=\"20\" bgcolor=\"#999999\"><td>ID</td><td>H�?</td><td>Tên</td><td>Tuần 1</td><td>Tuần 2</td></tr>";
$ad = $mysqli->query("select * from mdl_user where id in (select distinct userid from mdl_course_display where course = 4)");
	while($dd = $ad->fetch_assoc()) 
	{   echo "<tr  height=\"20\">";
		echo "<td>".$dd['id'] . "</td>" ."<td>".$dd['lastname'] ."</td>"."<td>". $dd['firstname']."</td>" ;
		u_co($dd['id'],4);
		//u_in_c($dd['id'],4);
		
		echo "</tr>" ;
	}
$ad->close();


function u_post ($u_id,$st,$en,$fo){
	global $mysqli;
		$sql1 = "select count(*)  from mdl_forum_posts where created BETWEEN UNIX_TIMESTAMP('$st') and UNIX_TIMESTAMP('$en') and discussion in (select id from mdl_forum_discussions where forum = $fo)  and userid = $u_id;";
	//	echo $sql1.'<br>';
		$ad1 = $mysqli->query($sql1);
			while($dd1 = $ad1->fetch_assoc()) 
			{
				echo "<td>".'post'.':'.' '.$dd1['count(*)']."</td>";
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
				echo "<td>".'grade'."</td>"."<td>".$dd2['grade'].':'."</td>";
			}
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
				echo "";
				u_m_week ($u_id,$dd4['week_number'],$c_id);
			}
		$ad4->close();
}
function u_in_c ($u_id,$c_id){
	global $mysqli;
	$sql5 = "select * from huy_setting_calendar where c_id = $c_id;";
	echo $sql5 ;
	$ad5 = $mysqli->query($sql5);
	while ($ar = $ad5->fetch_assoc())
	{
		echo $ar['week_number'];
	}
	$ad5->close();
	
}

$mysqli->close();
echo "</table>";
?>


</body>
</html>