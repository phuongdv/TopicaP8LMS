<?php
$starttime = microtime(true);
include('global.php');
require_login();
$ex_sql='';
$date_crit='';
if($_POST['start']!='' && $_POST['end']!='' )
{
$ex_sql .= " and time >= ".strtotime($_POST['start']);
$c_date_sql .=" and (
                     (c.enrolenddate < ".strtotime($_POST['start'])."  and  c.enrolenddate > ".strtotime($_POST['end'])." ) or 
					 (c.enrolstartdate > ".strtotime($_POST['start'])."  and  c.enrolenddate < ".strtotime($_POST['end'])." ) or 
					 (c.enrolstartdate < ".strtotime($_POST['start'])."  and  c.enrolenddate > ".strtotime($_POST['start'])." ) or
					 (c.enrolstartdate < ".strtotime($_POST['end'])."  and  c.enrolenddate > ".strtotime($_POST['end'])." )
					)";
$start=strtotime($_POST['start']);
$date_crit .= 'Từ '.date('d-m-Y',$start);
$end=strtotime($_POST['end']);
$date_crit .= ' Đến '.date('d-m-Y',$end);
}
/* if($_POST['end']!='')
{
$ex_sql .= " and time <= ".strtotime($_POST['end']);
$c_date_sql .=" and c.enrolenddate > ".strtotime($_POST['end']);
$end=strtotime($_POST['end']);
$date_crit .= ' Đến '.date('d-m-Y',$end);
} */

if($_POST['end']=='' && $_POST['start']=='')
{
$c_date_sql = ' and c.enrolenddate > unix_timestamp() ';
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

$sql ="SELECT DISTINCT(u.id) uid,u.lastname,u.firstname,c.shortname,c.enrolstartdate,c.enrolenddate,c.id cid,u.username username
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
				WHERE  r.id = 14 
				
				and c.enrolstartdate <> 0
				and c.enrolenddate <> 0
				$c_date_sql
				
				and c.id not in(1,1333,1711,98)
				order by c.id desc
";
$arr_report = $DB->fetch_assoc($sql);


function count_h2472_gv($u_id,$c_id,$start_time=0,$end_time=0)
 {
  global $DB;
    $sql_time='';
  if($start_time != 0)
   $sql_time = " and tblthread.time > $start_time";
  if($end_time !=0)
   $sql_time .=" and tblthread.time < $end_time";
  $sql ="select count(*) count from tblthread where assignid = $u_id and courseid=$c_id $sql_time";
  $result = $DB->fetch_assoc($sql);
  return $result[0]['count'];
 }
 
 
 
 
 function count_h2472_qua_han($u_id,$c_id,$start_time=0,$end_time=0)
  {
  global $DB;
  $sql_time='';
  if($start_time != 0)
   $sql_time = " and tblanswer.time > $start_time ";
  if($end_time !=0)
   $sql_time .=" and tblanswer.time < $end_time ";
     
   $sql ="SELECT count(tblreply.userid) count
 FROM tblanswer 

INNER JOIN tblreply on tblanswer.id = tblreply.answerid 

WHERE 
 (tblreply.time - tblanswer.time)>(3600 * 72) 

 AND tblanswer.courseid = $u_id 
AND tblanswer.assignid = $c_id
AND tblreply.userid=$c_id
  $sql_time
			";
			
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
		<a  href="/" style="color:#810c15;font-weight:bold" >Return to classroom</a>
		<form name="form1" method="POST">
		<div  class="easyui-panel" title=" Filter data" style="width:600px;margin-left:0px" data-options="iconCls:'icon-search',collapsible:true">
		<p>To :  <input name="start" class="easyui-datebox" value="<?php  echo $_POST['start']; ?>"></input>   From  :  <input name="end" class="easyui-datebox" value="<?php echo $_POST['end'];?>"></input> &nbsp; &nbsp; &nbsp; <label ><input  type="checkbox" name="excel" value="excel"> Excel </label><input style="float:right;margin-right:10px;background:#fff;heigth:30px;border:solid 1px #810c15" type="submit" value=" View "></p>
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
	<th rowspan="2" width="227"><div align="center">Guest lecturer from corporates</div></th>
    <th rowspan="2" width="127"><div align="center">Module Class</div></th>
    <th rowspan="2" width="105"><div align="center">Start date</div></th>
	    <th rowspan="2" width="105"><div align="center">End date</div></th>
     <th rowspan="2" width="105"><div align="center">Week</div></th>
    <th colspan="2"><div align="center">Trả lời H2472</div></th>
    <th colspan="2"><div align="center">Forum</div></th>
  </tr>
  <tr>
      <th  width="93"><div align="center">Number of questions have</div></th>
     <th " width="93"><div align="center">Number of questions have passed the limit</div></th>
    <th  width="93"><div align="center">Number of post(s) in forum</div></th>
   
    <th ><div align="center">Yêu cầu tối thiểu tuần</div></th>
  </tr>
 
  <?php 
  $stt=1;
  foreach($arr_report as $report)
  {
  ?>
  <tr <?php echo $stt%2 ? '': 'style="background:#eee"'?>>
    <td align="center"><?php echo $stt ;?></td>
	    <td><?php echo $report['lastname'].' '.$report['firstname'] ;?></a></td>
    <td><?php echo $report['shortname'] ;?></a></td>
    <td align="right" style="padding-right:15px"><?php echo date('d-m-Y',$report['enrolstartdate']);?></td>
    <td align="right" style="padding-right:15px"><?php echo date('d-m-Y',$report['enrolenddate']);?></td>
	    <td align="right" style="padding-right:15px"><?php echo tuan_hien_tai ($report['cid'],$start) ;?></td>
    <td align="right" style="padding-right:15px"><?php echo count_h2472_gv($report['uid'],$report['cid'],$start,$end);?></td>
    <td align="right" style="padding-right:15px"><?php echo count_h2472_qua_han($report['uid'],$report['cid'],$start,$end);?></td>
    <td align="right" style="padding-right:15px"><?php 
	//print_r(get_forum_id($report['cid']));
	$forum_post = count_post_forum($start,$end,get_forum_id($report['cid']),"'".$report['username']."'");
	echo $forum_post ; 
	?>
	</td>
    <td align="right" style="padding-right:15px">
	<?php /* Cần sửa sau (ThangDM's Note) */
	$tb=get_tb($$report['shortname']);
	echo $tb['yc_so_post_tuan_gvdn'];
	
	?>
	</td>
    
   
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
echo round($duration,2).' Seconds';


?>
</div>

</body>
</html>
<?php

}
function tuan_hien_tai ($c_id,$start_date=0)
{
global $DB;
if($start_date ==0)
$currentdate = date("W");
else
$currentdate = date("W",$start_date);
$sql = "select enrolstartdate from mdl_course where id = $c_id";
$result = $DB->fetch_assoc($sql);
$enrolstartdate = $result[0]['enrolstartdate'];
$weekNumber =  $currentdate - date("W",$enrolstartdate); 
if($weekNumber+1>0 and $weekNumber < 10)
return  $weekNumber+1;
else
return '-';
}    


?>