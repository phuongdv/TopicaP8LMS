<?php
require_once("../config.php");
require_login();
global $CFG, $QTYPES;
$startdate	=	$_POST['startdate'];
$enddate	=	$_POST['enddate'];
$ok			=	$_POST['ok'];
$excell		=   $_POST['excell'];
$excellbtn  =   $_POST['excellbtn'];

$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
if($excellbtn=='')
{
//print_header("LMS-H2472-LIFT",'<a href="index.php">'. "$stradministration</a>->Tai khoan");


?>
<script src="datetimepicker_css.js"></script>
<style type="text/css">

a:hover {background:#ffffff; text-decoration:none;} /*BG color is a must for IE6*/
a.tooltip span {display:none; padding:2px 3px; margin-left:8px; width:auto;}
a.tooltip:hover span{display:inline; position:absolute; border:1px solid #cccccc; background:#ffffff; color:#6c6c6c;}
</style>
<BR>
<div align="center"><B>H200 - BÁO CÁO H2472 - HISTORY ASSIGN</B></div><BR>
<form id="form1" name="form1" method="post" action="">
<table width="70%" border="0" style="font-size:80%" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="180">Từ ngày:(YYYY-MM-DD)</td>
    <td >
      <label>
        <input type="text" name="startdate" id="startdate"   value="<?php echo $startdate;?>" />
		 <img src="images2/cal.gif" onclick="javascript:NewCssCal('startdate','yyyyMMdd')" style="cursor:pointer"/>
      </label>
    </td>
    <td width="180">Đến ngày :(YYYY-MM-DD)</td>
    <td >
      <label>
        <input type="text" name="enddate" id="enddate" width="10"   value="<?php echo $enddate;?>"  />
		<img src="images2/cal.gif" onclick="javascript:NewCssCal('enddate','yyyyMMdd')" style="cursor:pointer"/>
      </label>
  </td>
  </tr>
  
  <tr>
    <td colspan="4" align="center">
	  <label>
	    <input type="submit" name="ok" id="ok" value="      Xem     " />
        
      </label>
      <label>
        <input type="submit" name="excellbtn" value="    Xuất excell     " />
      </label>
    </div></td>
  </tr>
</table></form>

<?php
}
else
{

header("Pragma: public");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("Content-Type: application/force-download");

    header("Content-Type: application/octet-stream");

    header("Content-Type: application/download");;

    header("Content-Disposition: attachment;filename=LMS_H2472_HISTORY_REPORT_ASSIGN.xls");
echo 'BÁO CÁO H2472 ASSIGN SAI QUI TRÌNH<BR>';
echo 'Từ ngày :'.$startdate.' Đến ngày: '.$enddate;
}


if($ok!='' || $excellbtn!='')
{
  if($startdate=='' || $enddate=='' )
   {
   echo '<script>alert(\'Ngày bắt đầu , ngày kết thúc  không được bỏ trống\')</script>';
   
   }
  else 
	{
        $startdate=$startdate.' 00:00:00';
		$enddate=$enddate.' 23:59:59';
		$ad = $mysqli->query('SET NAMES utf8');
	
		
				
        $query_string = "SELECT b.assignfrom assignfrom, b.datime time_assign,a.time time_ch, b.delay ,r.time-a.time delay_reply, 
							(SELECT r.id FROM mdl_user u 
							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id 
							INNER JOIN mdl_context ct ON ct.id = ra.contextid 
							INNER JOIN mdl_course c ON c.id = ct.instanceid 
							INNER JOIN mdl_role r ON r.id = ra.roleid 
							INNER JOIN mdl_course_categories cc ON cc.id = c.category 
							where u.id=b.assignfrom AND c.id=a.courseid order by r.sortorder asc limit 0,1) user_role
							FROM tblanswer a,tblassign b, tblreply r
							WHERE a.id=b.answerid AND a.id=r.answerid
							AND a.time>=UNIX_TIMESTAMP('$startdate') 
							AND a.time<=UNIX_TIMESTAMP('$enddate')
						";
		
	}
        
	//echo $query_string;
	 
     $ad = $mysqli->query($query_string);
	
	 $num_h2472 = $ad->num_rows;
	// echo $num_h2472;
	$dem_qua_han=0;
	$dem_nghi=0;
	$dem_lam=0;
	$dem_po_qua_han=0;
	$dem_is_qua_han=0;
	$dem_po_trong_han=0;
	$dem_is_trong_han=0;
	$dem_is_to_po=0;
	$dem_po_to_gv=0;
	$dem_is_to_po_qh=0;
	$dem_po_to_gv_qh=0;
	echo '<br>';
		/*	
		echo date("N",1405007632).'<br>';	
		echo date("H",1405007632).'<br>';
		echo date("i",1405007632).'<br>';
		echo date("s",1405007632).'<br>';
		*/
  while($dd = $ad->fetch_assoc()) 
	{
		//lấy ngày trong tuần và gio dat cau hoi
		$thu = date("N",$dd['time_ch']);
		$gio = date("H",$dd['time_ch']);
		//dem cau tra loi qua han 72h
		if ($dd['delay_reply']>259200)
		{
			$dem_qua_han++;
			//dem cau qua han trong ngay nghi.
			//Các câu hỏi sinh viên hỏi rơi vào từ 17:00 ngày thứ 6 đến 17: 00 ngày chủ nhật bị trả lời quá hạn
			if (($thu==5 && $gio >=17) || ($thu==6) || ($thu==7 && $gio <17))
			{
				$dem_nghi++;
			}
			else
			{
				//dem tong cau assign cua PO toi GV
				if ($dd['user_role']==211)
				{
					$dem_po_to_gv_qh++;
				}
				//dem cau assign sai qui trinh cua PO >30h
				if ($dd['user_role']==211 && $dd['delay'] > 108000)
				{
					$dem_po_qua_han++;
				}
				//dem tong cau assign cua IS toi PO
				if ($dd['user_role']==1 || $dd['user_role']=='' )
				{
					$dem_is_to_po_qh++;
				}
				//dem cau assign sai qui trinh cua IS >18h
				if (($dd['user_role']==1 || $dd['user_role']=='')  && $dd['delay'] > 64800 )
				{
					$dem_is_qua_han++;
				}
				$dem_lam++;
			
			}
				
		}
		else //dem cau tra loi trong han
		{
			if (($thu==5 && $gio >=17) || ($thu==6) || ($thu==7 && $gio <17))
			{
				
			}
			else
			{
				/*
				//dem tong cau assign cua IS toi PO
				if ($dd['user_role']==1 || $dd['user_role']=='' )
				{
					$dem_is_to_po++;
				}
				//dem tong cau assign cua PO toi GV
				if ($dd['user_role']==211)
				{
					$dem_po_to_gv++;
				}
				*/
				//dem cau assign sai qui trinh cua PO >30h
				if ($dd['user_role']==211 && $dd['delay'] > 108000)
				{
					$dem_po_trong_han++;
				}
				
				//dem cau assign sai qui trinh cua IS >18h
				if (($dd['user_role']==1 || $dd['user_role']=='')  && $dd['delay'] > 64800 )
				{
					$dem_is_trong_han++;
				}
			}
			
			
		}
		
		//dem tong cau assign cua IS toi PO
				if ($dd['user_role']==1 || $dd['user_role']=='' )
				{
					$dem_is_to_po++;
				}
		//dem tong cau assign cua PO toi GV
				if ($dd['user_role']==211)
				{
					$dem_po_to_gv++;
				}
		
		
	}
	
	$tong_is_sai_qt=$dem_is_qua_han+$dem_is_trong_han;
	$tong_po_sai_qt=$dem_po_qua_han+$dem_po_trong_han;
			
			?>
			
	<table width="" border="1" style="font-size:80%" cellpadding="5" cellspacing="0" align="center">
  <tr>
    <th rowspan="2"> T-Front</th>
	<th rowspan="2"> Tổng số câu hỏi</th>
    <th rowspan="2"> Tổng số câu quá hạn trên tổng</th>
    <th rowspan="2"> % câu hỏi quá hạn</th>
    <th colspan="2"> Câu hỏi assign không đúng qui trình dẫn đến trả lời quá hạn
(Với những câu sinh viên đặt từ 17:00 ngày chủ nhật đến 17:00 ngày thứ 6)</th>
	<th colspan="2"> Câu hỏi assign không đúng qui trình 
(Với những câu sinh viên đặt từ 17:00 ngày chủ nhật đến 17:00 ngày thứ 6)</th>
    <th rowspan="2">Các câu hỏi sinh viên hỏi rơi vào từ 17:00 ngày thứ 6 đến 17: 00 ngày chủ nhật bị trả lời quá hạn</th>
  </tr>
  <tr>
	<th > IS -> POVH >18h</th>
    <th > POVH -> GV >30h</th>
	<th > IS -> POVH >18h</th>
    <th > POVH -> GV >30h</th>
  </tr>

  <tr>
    <td><div align="center">TVU</div></td>
	<td><div align="center"><?php echo $num_h2472;?></div></td>
    <td><div align="center"><?php echo $dem_qua_han;?></div></td>
	<td align="center">&nbsp; <?php echo round($dem_qua_han*100/$num_h2472,2).' %' ;?></td>
    <td align="center">&nbsp; 
		<?php 
			//echo $dem_is_qua_han.' / '.$dem_is_to_po_qh ;
			echo $dem_is_qua_han.' / '.$tong_is_sai_qt ;
		?>
	</td>
    <td align="center">&nbsp; 
		<?php  
			//echo $dem_po_qua_han.' / '.$dem_po_to_gv_qh ;
			echo $dem_po_qua_han.' / '.$tong_po_sai_qt ;
		?>
	</td>
	<td align="center">&nbsp; 
		<?php 
			echo $tong_is_sai_qt.' / '.$dem_is_to_po ;
		?>
	</td>
    <td align="center">&nbsp; 
		<?php  
			echo $tong_po_sai_qt.' / '.$dem_po_to_gv ;
		?>
	</td>
    <td align="center">&nbsp; 
		<?php  
			echo $dem_nghi ;
		?>
	</td>
  </tr>
			
			
			<?php
			
			}
			
  


?>


</table>
