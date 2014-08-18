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

$sql ="select slc.courseid cid,shortname,slhv,
(select count(*) from tblthread where courseid = cid $ex_sql ) as sl2472,
(select count(*) from tblthread where courseid = cid $ex_sql )/slhv as tb,
ctb.*
from lmsreport_sl_hv_course slc
left join lmsreport_course_trung_binh ctb
on ctb.courseid = slc.courseid
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

<title>BC_Learning_ H2472_Forum_HV_2</title>

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
		<a style="float:right;margin-right:30px" href="javascript:void(0)" onClick="window.open('update.php','mywindow','width=400,height=200')">Cập nhật</a> 
		<a style="float:right;margin-right:30px" href="javascript:void(0)" onClick="window.open('update_trung_binh_mon.php','mywindow','width=600,height=400')">Cập nhật điểm trung bình môn</a> 
		<a  href="/" style="color:#810c15;font-weight:bold" >Quay về lớp học</a>
		<form name="form1" method="POST">
		<div  class="easyui-panel" title=" Lọc dữ liệu" style="width:600px;margin-left:0px" data-options="iconCls:'icon-search',collapsible:true">
		<p>Từ ngày :  <input name="start" class="easyui-datebox" value="<?php  echo $_POST['start']; ?>"></input>   Đến ngày  :  <input name="end" class="easyui-datebox" value="<?php echo $_POST['end'];?>"></input> &nbsp; &nbsp; &nbsp; <label ><input  type="checkbox" name="excel" value="excel"> Excel </label><input style="float:right;margin-right:10px;background:#fff;heigth:30px;border:solid 1px #810c15" type="submit" value=" Xem "></p>
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
  <col width="36" />
  <col width="119" />
  <col width="64" />
  <col width="50" />
  <col width="88" />
  <col width="54" />
  <col width="85" />
  <col width="42" />
  <col width="84" />
  <col width="67" />
  <col width="81" />
  <tr>
    <th rowspan="3" width="27"><div align="center">No.</div></th>
    <th rowspan="3" width="127"><div align="center">Module Class</div></th>
    <th rowspan="3" width="105"><div align="center">Số lượng H.viên</div></th>
     <th rowspan="3" width="105"><div align="center">Week</div></th>
    <th colspan="2"><div align="center">Access</div></th>
    <th colspan="3"><div align="center">Question H2472</div></th>
    <th colspan="4"><div align="center">Bài post Diễn đàn</div></th>
  </tr>
  <tr>
      <th rowspan="2" width="93"><div align="center">Số lượng</div></th>
     <th rowspan="2" width="93"><div align="center">Tỷ lệ</div></th>
    <th rowspan="2" width="93"><div align="center">Tổng câu hỏi</div></th>
   
    <th colspan="2"><div align="center">Tỷ lệ trung bình/ 1 HV</div></th>
    <th width="47" rowspan="2"><div align="center">Tổng</div></th>
    <th colspan="2"><div align="center">Tỷ lệ trung    bình/1 HV</div></th>
  </tr>
  <tr>
    <th width="69"><div align="center">Thực tế</div></th>
    <th width="103"><div align="center">Thường đạt</div></th>
    <th width="71"><div align="center">Thực tế</div></th>
    <th width="111"><div align="center">Thường đạt</div></th>
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
    <td align="right" style="padding-right:15px"><?php echo $soluotxem=count_hv_xem($report['cid']) ;?></td>
    <td align="right" style="padding-right:15px"><?php echo round(($soluotxem/$report['slhv'])*100,2 );?></td>
    <td align="right" style="padding-right:15px"><?php echo $report['sl2472']?></td>
    <td align="right" style="padding-right:15px"><?php echo round($report['tb'],2 );?></td>
    <td align="right" style="padding-right:15px"><?php  $tbh2472 =get_tb($report['shortname']);echo $tbh2472['tb_hv_h2472']?></td>
    <td align="right" style="padding-right:15px"><?php 
	//print_r(get_forum_id($report['cid']));
	$forum_post = count_post_forum($start,$end,get_forum_id($report['cid']),get_ds_hv($report['cid']));
	echo $forum_post; ?></td>
    <td align="right" style="padding-right:15px"><?php echo round($forum_post/$report['slhv'],2) ?></td>
    <td align="right" style="padding-right:15px"><?php $tbh2472 =get_tb($report['shortname']);echo $tbh2472['tb_hv_dd']?></td>
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