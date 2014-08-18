<?php
    ini_set('display_errors','On');
	require_once("../../config.php");
	require_login();
	global $CFG, $QTYPES;
	$startdate	=	$_POST['startdate'];
	$enddate	=	$_POST['enddate'];
	$gv			=	$_POST['gvcm'];
	$ok			=	$_POST['ok'];
	$excel	=   $_POST['excel'];
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
	$mysqli->query("SET NAMES utf8");
	$lastsunday=strtotime("last Sunday");
	$lastmonday=strtotime("-6 day",$lastsunday);
	// begin 
	
	$datesql='';
	
	if($startdate=='' && $enddate=='')
		{
		$datesql="where tim.startdate >='".date('Y-m-d',$lastmonday)."'
				   and   tim.enddate <='".date('Y-m-d',$lastsunday)."'";
		}
	else 
        {
		$datesql="where tim.startdate >='".$startdate."'
				   and   tim.enddate <= '".$enddate."'";
		}	
	$gvsql='';
	if ($gv!='')
	 {
	  $gvsql="where GVCM like '%".$gv."%'";  
	 }
	$sql="select distinct c.id cid,c.fullname,	from_unixtime(c.startdate,'%d-%m-%Y') startdate,
       (
			select GROUP_CONCAT(u.username)
			FROM
				mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE r.id='4'
			AND  c.id=cid
			GROUP BY 'ALL'
			) GVCM,
      (
			select GROUP_CONCAT(u.username)
			FROM
				mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE r.id='14'
			AND  c.id=cid
			GROUP BY 'ALL'
			) GVHD,
       tim.stttuan,tim.nhanxet,tim.dh_tuantoi,tim.cardgv,tim.emailsent
from mdl_course c
INNER join vietth_tam tim
on c.id = tim.course ".$datesql."  order by c.startdate desc ";
//echo $sql;
// create view
  $sql_create_view = "create view tim_report_vietth as ".$sql;
  
	   // debug
	    // echo $sql_create_view;
			//die();
//====================== end sql ===========================================================================	
	   
	    echo $startdate;
	    $view = $mysqli->query($sql_create_view);
	
	    $sql = "select * from tim_report_vietth  $gvsql";
	//	echo $sql;
		$ad = $mysqli->query($sql);
		$stt=1;
		$str='';
		$ex_data=array();
         while($dd = $ad->fetch_assoc()) 
			{
			 $ex_data[]=$dd;	
			 if($stt%2)
			 {
			 $str.="<tr style=\"background:#ccc\"><td>$stt</td>";
			 }
			 else
			 {
			 $str.="<tr><td>$stt</td>";
			 }
			
	
			 $str.="      
					      <td><a href=\"http://elearning.tvu.topica.vn/tim/?c=".$dd['cid']."\" >".$dd['fullname']."</a></td>
						  <td>".$dd['startdate']."</td>
					      <td>".$dd['GVCM']."</td>
					      <td>".$dd['GVHD']."</td>
					      <td>".$dd['stttuan']."</td>
					      <td>".($dd['nhanxet']=='' ? 'Không' : 'Có')."</td>
					      <td>".($dd['dh_tuantoi']=='' ? 'Không' : 'Có')."</td>
					      <td>".($dd['cardgv']=='' ? 'Không':'Có')."</td>
					      <td>".($dd['emailsent']==0 ?'Không' :'Có')."</td>
						  <td>".checkgv($dd['cid'])."</td>";
                    $stt=$stt+1;
			}	
	

	function checkgv($cid)
	{
	  global $mysqli;
	  $sql = "select count(DISTINCT u.id) count
		FROM
			mdl_user u
		INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
		INNER JOIN mdl_context ct ON ct.id = ra.contextid
		INNER JOIN mdl_course c ON c.id = ct.instanceid
		INNER JOIN mdl_role r ON r.id = ra.roleid
		INNER JOIN mdl_course_categories cc ON cc.id = c.category
		WHERE r.id in (4,14)
        and c.id = ".$cid;	    
		$ad = $mysqli->query($sql);
        $dd = $ad->fetch_assoc();	  
	    $check_gv= $dd["count"];
		if($check_gv==1)
		return 'GVCM/GVHD';
		else
	    return '';		
	}
	
		
	 $ad = $mysqli->query('DROP VIEW  tim_report_vietth');	
	if($excel!='')
	{
		$columtitle=array();
		$columtitle[0]=array(	'ID course',
								'Course',
								'Startdate',
								'GVCM',
								'GVHD',
								'Tuần học',
								'Nhận xét',
								'Định hướng',
								'Card GV',
								'Email',
							);
		include('excel.php');
		die();
		
	}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TIM REPORT</title>
<script src="datetimepicker_css.js"></script>
</head>

<body >
<div style="font-family:Arial, Helvetica, sans-serif;font-size:12pt;color:#810c15" ><strong>BÁO CÁO T.I.M</strong></div>
<div style="font-family:Arial, Helvetica, sans-serif;font-size:10px;color:#000">
<?php
    echo '';
	echo date('d-m-Y',$lastmonday);
	echo ' -';
	echo date('d-m-Y',$lastsunday);
?>	
  <form id="form1" name="form1" method="post" action="">
   <table>
   <tr>
   <td>Tìm theo tên gvcm:<input type="text" value="<?php echo $gv; ?>" name="gvcm"></td>
	<td>Từ tuần (thứ 2):</td>
	<td><input type="text" id="startdate" name="startdate" value="<?php echo $startdate;?>">
		<img src="images2/cal.gif" onclick="javascript:NewCssCal('startdate','yyyyMMdd')" style="cursor:pointer"/>
		</td>
	<td> đến (chủ nhật):</td> 
	<td><input type="text" id="enddate" name="enddate" value="<?php echo $enddate;?>">
		<img src="images2/cal.gif" onclick="javascript:NewCssCal('enddate','yyyyMMdd')" style="cursor:pointer"/>
		</td>
	<td><input type="submit" name="ok" value=" Xem  "></td>
	<td><input type="submit" name="excel" id="excel" value="  Xuất Excel  " /></td>
   </tr>
</table>
  </form>
  <table style="font-family:Arial, Helvetica, sans-serif;font-size:9pt;color:#000" width="100%" border="0" cellspacing="2" cellpadding="5">
    <tr style="color:#810c15;font-weight:bold;font-size:10pt">
      <td height="60"><div align="center">Stt</div></td>
      <td><div align="center">Course</div></td>
	  <td><div align="center">Startdate</div></td>
      <td><div align="center">GVCM</div></td>
      <td><div align="center">GVHD</div></td>
      <td><div align="center">Tuần học</div></td>
      <td><div align="center">Nhận xét</div></td>
      <td><div align="center">Định hướng</div></td>
      <td><div align="center">Card GV</div></td>
      <td><div align="center">Email</div></td>
	    <td><div align="center">Ghi chú</div></td>
    </tr>
   <?php echo $str;?>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>
