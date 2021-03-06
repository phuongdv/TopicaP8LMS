<?php
$starttime = microtime(true);
include('global.php');
require_login();
$ex_sql='';
$date_crit='';
if($_POST['start']!='')
{
$ex_sql .= " and time >= ".strtotime($_POST['start']);
$start=strtotime($_POST['start']);
$date_crit .= 'Từ '.date('d-m-Y',$start);
}
if($_POST['end']!='')
{
$ex_sql .= " and time <= ".strtotime($_POST['end']);
$end=strtotime($_POST['end']);
$date_crit .= ' Đến '.date('d-m-Y',$end);
}

/* $sql = "SELECT
	DISTINCT(c.shortname),
  c.id cid,
 (SELECT count(u.id)
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
				WHERE  r.id=5 and c.id=cid) so_hv,
(select count(*) from tblthread where courseid = cid) so_h2472
FROM
	mdl_course c
INNER JOIN tblthread thr ON thr.courseid = c.id"; */

$sql ="select slc.courseid cid,shortname,slhv
from lmsreport_sl_hv_course slc
where courseid in (select id from mdl_course
where id not in(1,1333,1711,98))
";
$arr_report = $DB->fetch_assoc($sql);


function count_h2472($c_id,$start_time=0,$end_time=0)
 {
  global $DB;
  $sql ="select count(*) count from tblthread where courseid = $c_id";
  $result = $DB->fetch_assoc($sql);
  return $result[0]['count'];
 }
 
function get_ds_hv($c_id)
{
	global $DB;
	$sql ="SELECT u.username username
					FROM mdl_user u
					INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
					INNER JOIN mdl_context ct ON ct.id = ra.contextid
					INNER JOIN mdl_course c ON c.id = ct.instanceid
					INNER JOIN mdl_role r ON r.id = ra.roleid
					INNER JOIN mdl_course_categories cc ON cc.id = c.category
					WHERE  r.id=5 and c.id=$c_id";
	$result = $DB->fetch_assoc($sql);
	$arr_username = array();
		foreach ($result as $username)
		{
		$arr_username[] = $username['username'];
		}
		$str_ds_hv = "'";
		$str_ds_hv .= implode("','",$arr_username);
		$str_ds_hv .= "'";
	return $str_ds_hv;
} 

function get_forum_id($c_id)
{
	global $DB;
	$sql ="select active_id from huy_setting_lipe where c_id=$c_id and (style = 'forum' or lipe_type='V')  limit 0,1";
	$result = $DB->fetch_assoc($sql);
	return $result[0]['active_id'];
}

function count_hv_xem($c_id)
{
	global $DB,$ex_sql;
	$sql ="SELECT count(DISTINCT l.userid) sohv_xem
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
        inner join mdl_log l on l.userid = u.id
				WHERE  
       r.id=5 
      and 
       c.id=$c_id
       and 
       l.action='view'
       and l.course = $c_id
       $ex_sql
       ";
	   $result = $DB->fetch_assoc($sql);
	   return $result[0]['sohv_xem'];
	
}

function tinh_ty_le_chua_lam_btvn($c_id,$slhv,$btvn_so)
  { 
    global $DB;
	
	$sql = "select id from mdl_quiz where course = $c_id and `name` like '% về nhà %' and `name`LIKE '%$btnv_so%'";
	$result = $DB->fetch_assoc($sql);
	if($result[0]['id']=='')
	 {
	 $str = '<td align="right" style="padding-right:15px">-</td>
    <td align="right" style="padding-right:15px">-</td>';
	 return $str;
	 }
	$sql ="select count(DISTINCT userid) count,q.timeclose from mdl_quiz_grades 

INNER JOIN mdl_quiz q on q.id=mdl_quiz_grades.quiz

where quiz in (
select id from mdl_quiz where course = $c_id and `name` like '% về nhà %' and `name`LIKE '%$btvn_so%')";
     $result = $DB->fetch_assoc($sql);
	 $str = '<td align="right" style="padding-right:15px">'.round(($slhv-$result[0]['count'])/$slhv*100,2).'</td>
    <td align="right" style="padding-right:15px">'.date('d-m-Y',$result[0]['timeclose']).'</td>';
	 
    return $str;	 
  }
  
  function tinh_ty_le_chua_lam_btkn($c_id,$slhv,$btkn_so)
  { 
    global $DB;
	
	$sql = "select * from mdl_assignment where course = $c_id and name like '%$btkn_so%'";
	$result = $DB->fetch_assoc($sql);
	if($result[0]['id']=='')
	 {
	 $str = '<td align="right" style="padding-right:15px">-</td>
    <td align="right" style="padding-right:15px">-</td>';
	 return $str;
	 }
	$sql = "select slhv from lmsreport_sl_hv_course where courseid = $c_id"; 
     $result = $DB->fetch_assoc($sql); 
	 $sl_hv  = $result[0]['slhv'];
	$sql =" select count(DISTINCT userid) count,mdl_assignment.timedue from mdl_assignment_submissions
			INNER JOIN mdl_assignment on mdl_assignment.id = mdl_assignment_submissions.assignment
			 where assignment in (select id from mdl_assignment where course = $c_id and name like '%$btkn_so%' )";
			 //echo $sql;
     $result = $DB->fetch_assoc($sql);
	 $date_close = $result[0]['timedue']==0 ? '':date('d-m-Y',$result[0]['timedue']);
	 $str = '<td align="right" style="padding-right:15px">'.round(($slhv-min($slhv,$result[0]['count']))/$slhv*100,2).'</td>
    <td align="right" style="padding-right:15px">'.$date_close.'</td>';
	 
    return $str;	 
  }
  
  function check_chuyen_can($course_name,$c_id,$slhv)
  { 
    $tb_cc = get_tb($course_name);
	$tb = $tb_cc['dk_cc'];
    global $DB;
	$sql = "SELECT count(*) count from diemcc where cid = $c_id and diemcc < $tb";
	$result = $DB->fetch_assoc($sql);

	return round($result[0]['count']/$slhv*100,2);
  }
  
    function check_giua_ky($course_name,$c_id,$slhv)
  { 
    $tb_cc = get_tb($course_name);
	$tb = $tb_cc['dk_diem_giua_ky'];
    global $DB;
	$sql = "SELECT count(*) count from diemcc where cid = $c_id and diemkt < $tb";
	//if($c_id ==1763)
	//return $sql;
	$result = $DB->fetch_assoc($sql);

	return round($result[0]['count']/$slhv*100,2);
  }
    function check_di_thi($course_name,$c_id,$slhv)
  { 
    $tb = get_tb($course_name);
	$tb_kt = $tb['dk_diem_giua_ky'];
	$tb_cc = $tb['dk_cc'];
    global $DB;
	$sql = "SELECT count(*) count from diemcc where cid = $c_id and (diemkt < $tb_kt or diemcc < $tb_cc)";

	$result = $DB->fetch_assoc($sql);

	return $result[0]['count'];
  }


function get_tb($course_name)
{
	$mon = substr($course_name,0,6);
	global $DB;
	$sql ="select * from lmsreport_mon_trung_binh where ma_mon like '$mon%' limit 0,1 ";
	$result = $DB->fetch_assoc($sql);
	return $result[0];
}

//print_r($_POST);
if($_POST['excel']=='')
{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>BC_hoctap_ H2472_Dien dan_HV_2</title>

<script type="text/javascript" src="ui/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="ui/jquery.easyui.min.js"></script>
<link href="ui/themes/default/easyui.css" rel="stylesheet" type="text/css" />
<link href="ui/themes/icon.css" rel="stylesheet" type="text/css" />
<style>
#wrapper {
    width: 1000px;
    margin: 0 auto;
	font-family:Arial;
	
}


</style>

</head>

<body>

<div id="wrapper" >

<iframe width="1000px" scrolling="no" height="90px" frameborder="0" border="0" framespacing="0" src="/lmsreport/weekreport/head.html"></iframe>
        <hr>
		<div style="margin-top:20px"></div>
		<a style="float:right;margin-right:30px" href="javascript:void(0)" onClick="window.open('update.php','mywindow','width=400,height=200')">Update</a> 
		<a style="float:right;margin-right:30px" href="javascript:void(0)" onClick="window.open('update_trung_binh_mon.php','mywindow','width=600,height=400')">Update GPA</a> 
		<form name="form1" method="POST">
		<div  class="easyui-panel" title=" Filter data" style="width:600px;margin-left:0px" data-options="iconCls:'icon-search',collapsible:true">
		<p>From :  <input name="start" class="easyui-datebox" value="<?php  echo $_POST['start']; ?>"></input>   To  :  <input name="end" class="easyui-datebox" value="<?php echo $_POST['end'];?>"></input> &nbsp; &nbsp; &nbsp; <label ><input  type="checkbox" name="excel" value="excel"> Excel </label><input style="float:right;margin-right:10px;background:#fff;heigth:30px;border:solid 1px #810c15" type="submit" value=" View "></p>
        </div>
		</form>
		<div style="margin-top:20px"></div>
	<?php
    }
	else
	{
	header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=BC_hoctap_H2472_Dien_dan_HV.xls");
	 echo '<table width="100%" border="0" cellpadding="0">
		  <tr>
			<td>Ngày xuất</td>
			<td>'.date('H:i d-m-Y').'</td>
		  </tr>
		  <tr>
			<td width="20%">Người xuất</td>
			<td width="80%">'.$USER->username.'</td>
		  </tr>';
	if($date_crit!='')
		{
		  echo '	  
			  <tr>
				<td>Lọc theo</td>
				<td>'.$date_crit.'</td>
			  </tr>';
			
		}
	 echo '</table>';
	}
	
    ?>
<table border="1" style="border-collapse:collapse;font-size:10pt" id="data_g" width="1000" cellpadding="3" cellspacing="0">

  <tr>
    <th rowspan="2" width="27"><div align="center">No.</div></th>
    <th rowspan="2" width="127"><div align="center">Module Class</div></th>
    <th rowspan="2" width="105"><div align="center">Số lượng H.viên</div></th>
     <th rowspan="2" width="105"><div align="center">Week</div></th>
    <th colspan="2"><div align="center">Home Assignments 1</div></th>
	<th colspan="2"><div align="center">Home Assignments 2</div></th>
	<th colspan="2"><div align="center">BTKN / BTN 1</div></th>
    <th colspan="2"><div align="center">BTKN / BTN 2</div></th>
    <th rowspan="2"><div align="center">Fail by attendance (%)</div></th>
	<th rowspan="2"><div align="center">Fail by mid-term (%)</div></th>
	<th rowspan="2"><div align="center">Number of students not qualified to join final exam</div></th>	
	<th rowspan="2"><div align="center">Tỷ lệ </div></th>
	<th rowspan="2"><div align="center">Attendance check</div></th>
    <th rowspan="2"><div align="center">Pass</div></th>
  </tr>
  <tr>
      <th width="93"><div align="center">% incomplete</div></th>
     <th  width="93"><div align="center">Deadline</div></th>
	 <th  width="93"><div align="center">% incomplete</div></th>
     <th width="93"><div align="center">Deadline</div></th>
	 	 <th  width="93"><div align="center">% incomplete</div></th>
     <th  width="93"><div align="center">Deadline</div></th>
	 	 <th  width="93"><div align="center">% incomplete</div></th>
     <th  width="93"><div align="center">Deadline</div></th>
  
  </tr>

  <?php 
  $stt=1;
  
  foreach($arr_report as $report)
  {
  ?>
  <tr <?php echo $stt%2 ? '': 'style="background:#eee"'?>>
    <td align="center"><?php echo $stt ;?></td>
    <td><?php echo $report['shortname'] ;?></td>
    <td align="right" style="padding-right:15px"><?php echo $report['slhv'] ;?></td>
    <td align="right" style="padding-right:15px"><?php echo tuan_hien_tai ($report['cid']) ;?></td>
	<?php echo tinh_ty_le_chua_lam_btvn($report['cid'],$report['slhv'],1);?>
  <?php echo tinh_ty_le_chua_lam_btvn($report['cid'],$report['slhv'],2);?>
  <?php echo tinh_ty_le_chua_lam_btkn($report['cid'],$report['slhv'],1);?>
    <?php echo tinh_ty_le_chua_lam_btkn($report['cid'],$report['slhv'],2);?>
   <td align="right" style="padding-right:15px"><?php echo check_chuyen_can($report['shortname'],$report['cid'],$report['slhv']);?></td>
   <td align="right" style="padding-right:15px"><?php echo check_giua_ky($report['shortname'],$report['cid'],$report['slhv']);?></td>
   <td align="right" style="padding-right:15px"><?php echo check_di_thi($report['shortname'],$report['cid'],$report['slhv']);?></td>
   <td align="right" style="padding-right:15px"></td>
   <td align="right" style="padding-right:15px"></td>
   <td align="right" style="padding-right:15px"></td>
   
  </tr>
  <?php
  $stt++;
  
  }
  ?>
</table>
<?php if ($_POST['excel']=='')
{
?>
</div>
<div align="center">
Time:
<?php
$endtime = microtime(true);
$duration = $endtime - $starttime;
echo $duration.' Seconds';


?>
</div>

</body>
</html>
<?php

}

function tuan_hien_tai ($c_id)
{
global $DB;
$sql = "select enrolstartdate from mdl_course where id = $c_id";
$result = $DB->fetch_assoc($sql);
$enrolstartdate = $result[0]['enrolstartdate'];
$weekNumber =  date("W") - date("W",$enrolstartdate); 
return max(0,$weekNumber+1); 
}    


?>