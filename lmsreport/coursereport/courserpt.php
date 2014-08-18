<?php
	require_once("../../config.php");
	require_login();
	global $CFG, $QTYPES;
	$startdate	=	$_POST['sdate'];
	$enddate	=	$_POST['edate'];
	$ok			=	$_POST['ok'];
	$excel	=   $_POST['excel'];
	$conn = mysql_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	mysql_select_db($CFG->dbname);
	
	// begin 
	$sql="SELECT 
			c.id cid,c.fullname,lcm.mode mode,FROM_UNIXTIME(enrolstartdate,'%d-%m-%Y') ngay_bat_dau,FROM_UNIXTIME(enrolenddate,'%d-%m-%Y') ngay_ket_thuc,
			(
			select GROUP_CONCAT(u.username)
			FROM
				mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE r.id='13'
			AND  c.id=cid
			GROUP BY 'All'
			) POVH,
			(
			select GROUP_CONCAT(u.username)
			FROM
				mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE r.id='211'
			AND  c.id=cid
			GROUP BY 'All'
			) POVHLM,
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
			(
			select GROUP_CONCAT(u.username)
			FROM
				mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE r.id='3'
			AND  c.id=cid
			group by 'all'
			) CVHT,
			(
			select count(distinct u.id)
			FROM
				mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE r.id='5'
			AND  c.id=cid
			) SLHV,
			(
			select DISTINCT FROM_UNIXTIME(start_date,'%d-%m-%Y') 
			from huy_setting_calendar 
			where c_id=cid 
			and week_name='Tuần 1'
			) LIPE_START,
			(
			select DISTINCT FROM_UNIXTIME(end_date,'%d-%m-%Y') 
			from huy_setting_calendar 
			where c_id=cid 
			and week_name='Tổng'
			) LIPE_END,
			(
			select count(*) from huy_setting_lipe where c_id=cid and style='forum'
			)
			SO_FORUM_DA_SET,
			(
			select count(*) from huy_setting_lipe where c_id=cid and lipe_type='E'
			)
			SO_EXAM_DA_SET,
			(
			select count(*) from huy_setting_lipe where c_id=cid and lipe_type='P'
			)
			SO_PRACTICE_DA_SET
			
			FROM
			mdl_course c,lipe_course_mode lcm
			WHERE
			c.id=lcm.course
			and
			c.enrolstartdate BETWEEN UNIX_TIMESTAMP('$startdate 00:00:00') AND UNIX_TIMESTAMP('$enddate 23:59:59') order by c.enrolstartdate desc";
	   // debug
	        //echo $sql;
//====================== end sql ===========================================================================	
	
	if($ok!='' || $excel!='') // ok press
	{
		$ad = mysql_query($sql);
		$stt=1;
		$str='';
		$ex_data=array();

         while($dd = mysql_fetch_assoc($ad)) 
			{
			 $ex_data[]=$dd;	
			 if($stt%2)
			 {
			 $str.="<tr style=\"background:#ccc;\"><td>$stt</td>";	
			 }
			 else
			 {
			  $str.="<tr><td>$stt</td>";	
			 }
			 $str.="      <td>".$dd['cid']."</td>
					      <td>".$dd['fullname']."</td>
						   <td>".$dd['mode']."</td>
					      <td>".$dd['ngay_bat_dau']."</td>
						  <td>".$dd['ngay_ket_thuc']."</td>
					      <td>".$dd['POVH']."</td>
					      <td>".$dd['POVHLM']."</td>
					      <td>".$dd['GVCM']."</td>
					      <td>".$dd['GVHD']."</td>
					      <td>".$dd['CVHT']."</td>
						  <td>".$dd['SLHV']."</td>
					      <td>".$dd['LIPE_START']."</td>
					      <td>".$dd['LIPE_END']."</td>
					      <td>".$dd['SO_FORUM_DA_SET']."</td>
					      <td>".$dd['SO_EXAM_DA_SET']."</td>
					      <td>".$dd['SO_PRACTICE_DA_SET']."</td></tr>";
		    $stt=$stt+1;
			}	
			
			//print_r($ex_data);
			
		
	}
	
	if($excel!='')
	{
		$columtitle=array();
		$columtitle[0]=array(	
								'Id lớp môn',
								'Tên lớp môn',
								'Lipe Mode',
								'Ngày bắt đầu',
								'Ngày kết thúc',
								'POVH',
								'POVHLM',
								'GVCM',
								'GVHD',
								'CVHT',
								'Số lượng học viên',
								'LIPE start',
								'LIPE end',
								'Forum',
								'Exam',
								'Practice');
		include('excel.php');
		die();
		
	}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Course report</title>
<script src="datetimepicker_css.js"></script>
</head>

<body>
<div style="font-family:Arial, Helvetica, sans-serif;font-size:10px;color:#000">
  <form id="form1" name="form1" method="post" action="">

  <p>Xem các khóa học bắt đầu từ:
    <label>
      <input type="text" name="sdate" id="sdate" value="<?php echo $startdate; ?>" />
    </label>
     <img src="images2/cal.gif" onclick="javascript:NewCssCal('sdate','yyyyMMdd')" style="cursor:pointer"/>
      &nbsp; &nbsp; đến ngày :
          <label>
      <input type="text" name="edate" id="edate" value="<? echo $enddate; ?>" />
    </label>
    <img src="images2/cal.gif" onclick="javascript:NewCssCal('edate','yyyyMMdd')" style="cursor:pointer"/>
         <label>
      <input type="submit" name="ok" id="ok" value="  Xem  " />
    </label>
             <label>
      <input type="submit" name="excel" id="excel" value="  Xuất Excel  " />
    </label>
  </p>

  </form>
  
 
  <table width="100%" border="0" cellspacing="2" cellpadding="5">
    <tr style="font-weight:bold">
      <td height="60"><div align="center">Stt</div></td>
      <td><div align="center">Id lớp môn</td>
      <td><div align="center">Tên lớp môn</td>
	  <td><div align="center">Lipe mode</td>
      <td><div align="center">Ngày bắt đầu</div></td>
	  <td><div align="center">Ngày kết thúc</td>
      <td><div align="center">POVH</div></td>
      <td><div align="center">POVHLM</div></td>
      <td><div align="center">GVCM</div></td>
      <td><div align="center">GVHD</div></td>
      <td><div align="center">CVHT</div></td>
	  <td><div align="center">Số lượng học viên</td>
      <td><div align="center">LIPE start</div></td>
      <td><div align="center">LIPE end</div></td>
      <td><div align="center">Forum</div></td>
      <td><div align="center">
        <p>Exam</p>
      </div></td>
      <td><div align="center">Practice</div></td>
    </tr>
   <?php echo $str;?>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>
