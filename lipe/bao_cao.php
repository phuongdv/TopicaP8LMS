<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Report</title>
</head>

<body  topmargin="0px"  leftmargin="0" rightmargin="0">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
    	<td height="50" bgcolor="#999999">
        	
        </td>
   	</tr>
	<tr>
    	<td align="center">
        	<table cellpadding="0" cellspacing="0" border="0" style="border:dotted 1px #CCC;" width="1000" align="center" bgcolor="#F0F0F0">
            	<tr>
            		<td width="30" align="center"  class="tb_row">ID</td>
        			<td width="120"  class="tb_row">Họ</td>
        			<td width="100"  class="tb_row">Tên</td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
	<tr>
    	<td >
<?php
require_once( 'config.php' );
$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
$mysqli->select_db($dbmain);
if ( isset($_REQUEST['cid']) && $_REQUEST['cid'] != ''){
$c_id = $_REQUEST['cid'];}
$mysqli->query("SET NAMES 'utf8'");
echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border:solid 1px #CCC;\" width=\"1000\" align=\"center\" class=\"tb_main\">";
/*echo "<tr height=\"20\" bgcolor=\"#999999\"><td>ID</td><td>Họ</td><td>Tên</td><td colspan=\"2\" align=\"center\" >Tuần 1</td><td colspan=\"2\" align=\"center\">Tuần 2</td></tr>";*/
$ad = $mysqli->query("select * from mdl_user where id in (select distinct userid from mdl_course_display where course = $c_id) and id not in (select userid from mdl_role_assignments where roleid in (1,2,3,4,8) );");
	while($dd = $ad->fetch_assoc()) 
	{   echo "<tr  height=\"25\">";
		echo "<td  width=\"30\" align=\"center\" class=\"tb_row\">".$dd['id'] . "</td>" ."<td width=\"120\" class=\"tb_row\">".$dd['lastname'] ."</td>"."<td width=\"100\" class=\"tb_row\">". $dd['firstname']."</td>" ;
		u_co($dd['id'],$c_id);
		//u_in_c($dd['id'],4);
		
		echo "</tr>" ;
	}
$ad->close();


function u_post ($u_id,$st,$en,$fo){
	global $mysqli;
		$sql1 = "select count(*)  from mdl_forum_posts where created BETWEEN $st and $en and discussion in (select id from mdl_forum_discussions where forum = $fo)  and userid = $u_id;";
	//	echo $sql1.'<br>';
		$ad1 = $mysqli->query($sql1);
			while($dd1 = $ad1->fetch_assoc()) 
			{
				echo "<td class=\"tb_row\" align=\"center\">".'post'.':'.' '.$dd1['count(*)']."</td>";
			}
		$ad1->close();
}

function u_grade ($u_id,$st,$en,$quiz){
		global $mysqli;
			$sql2 = "select grade from mdl_quiz_grades where quiz = $quiz and userid = $u_id;";
	//	echo $sql2.'<br>';
		$ad2 = $mysqli->query($sql2);
		if($mysqli->affected_rows > 0){
			while($dd2 = $ad2->fetch_assoc()) 
			{
				echo "<td class=\"tb_row\" bgcolor=\"#E0DEFA\" align=\"center\">".'grade : '.$dd2['grade']."</td>"."<td width=\"10\">"."</td>";
			}
		$ad2->close();
		}
		else {echo "<td class=\"tb_row\" bgcolor=\"#E0DEFA\" align=\"center\">".'grade : '."n/a"."</td>"."<td width=\"10\">"."</td>";}
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
				echo "<td class=\"tb_row\" bgcolor=\"#E8E8E8\" align=\"center\" >".'<b>Tuan '.$dd4['week_number']."</b></td>";
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
		</td>
	</tr>
</table>

</body>
</html>