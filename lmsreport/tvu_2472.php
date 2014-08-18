<?php
require_once("../config.php");
require_login();
global $CFG, $QTYPES;
$startdate	=	$_POST['startdate'];
$enddate	=	$_POST['enddate'];
$ok			=	$_POST['ok'];
$excell		=   $_POST['excell'];
$excellbtn  =   $_POST['excellbtn'];
$lopmon		=	$_POST['coursemoodle'];
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
<div align="center"><B>H100 - BÁO CÁO H2472 - HISTORY</B></div><BR>
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
    <td colspan="2">&nbsp;</td>
  <?php
  if(1==1)
  {
  ?>
    <td>Lớp môn</td>
    <td><select name="coursemoodle" id="coursemoodle" style="width:100px"><option value="" >Tất cả</option>
    <?php
   $ad = $mysqli->query('SET NAMES utf8');
   $query_string = "SELECT * from mdl_course c where c.fullname like '%".$monhoc."%'   order by c.fullname asc";
	// echo $query_string;
	 
    $ad = $mysqli->query($query_string);
  while($dd = $ad->fetch_assoc()) 
			{
			if($dd['id']==$lopmon)
			 {
			echo '<option value="'.$dd['id'].'" selected="selected">'.$dd['fullname'].'</option>';
			 }
			else
			 {
			 echo '<option value="'.$dd['id'].'">'.$dd['fullname'].'</option>';
			 }
			 
			}	

	  
	  ?>
										
									</select></td>
  </tr>
  <?php
  }
  else 
  {
   
  ?>
   <td>Lớp môn</td>
    <td><select name="coursemoodle" id="coursemoodle">
										
									</select></td>
  </tr>
  
  <? } ?>
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

    header("Content-Disposition: attachment;filename=LMS_H2472_HISTORY_REPORT.xls");
echo 'Từ ngày :'.$startdate.' Đến ngày: '.$enddate;
}

?>
<table width="" border="1" style="font-size:80%" cellpadding="0" cellspacing="0">
  <tr>
    <th width="18"> TT</th>
	<th width="18"> ID</th>
    <th width="100"> Tên chủ đề</th>
    <th width="113"> Lớp môn</th>
    <th width="150" align="center">Người đặt câu hỏi</th>
    <th width="70"> Thời gian đặt câu hỏi</th>
	<th width="150"> Assign from</th>
    <th width="150"> Assign to</th>
    <th width="70"> Assign time</th>
	<th width="100"> Độ trễ Assign</th>
	<th width="150" align="center">Người trả lời</th>
    <th width="70"> Thời gian trả lời</th>
    <th width="100" align="center">Độ trễ Reply</th>
    
  </tr>

<?





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
	
		
		
		if($lopmon!='')
		{
				
        $query_string = "SELECT *
						FROM tblthread 
						WHERE time>=UNIX_TIMESTAMP('$startdate') 
						AND time<=UNIX_TIMESTAMP('$enddate')  
						AND courseid='".$lopmon."' 
						";
		}
		else 
		{
			$query_string = "SELECT *
						FROM tblthread 
						WHERE time>=UNIX_TIMESTAMP('$startdate') 
						AND time<=UNIX_TIMESTAMP('$enddate') 
						";
			
		}
	    }
        
		 //echo $query_string;
	 
     $ad = $mysqli->query($query_string);
	
	 
	 $t=0;
  while($dd = $ad->fetch_assoc()) 
			{
			
			$t=$t+1;
			?>
			<tr 
			<?php
			if($t%2==0)
			{
			 echo 'style="background:#eeeeee"';
			}
			?>
			
			>
    <td><div align="center"><?php echo $t ;?></div></td>

    <td><div align="center"><?php echo $dd['id'] ;?></div></td>
    <td>&nbsp; <?php echo $dd['answername'] ;?></td>
    <td>&nbsp; <?php echo get_cname($dd['courseid']) ;?></td>
	<td width="150"><div align="center"><?php echo get_name_from_id($dd['userid']) ;?></div></td>
	<td><div align="center"><?php echo date('d/m/Y H:i:s',$dd['time']) ;?></div></td>
	<td colspan="4" valign="top"> 
		<table border="0" style="font-size:90%">
		<?php 
		//$query_string2 = "SELECT * FROM tblassign WHERE threadid=".$dd['id'];
		$query_string2 = "SELECT b.assignfrom assignfrom, b.assignto assignto, b.datime datime,a.time time
						  FROM tblanswer a,tblassign b WHERE a.id=b.answerid AND threadid=".$dd['id'];
		$ad2 = $mysqli->query($query_string2);
		while($dd2 = $ad2->fetch_assoc()) 
			{
		
		?>
			<tr>
				<td width="150"><?php echo get_name_from_id($dd2['assignfrom']).'<br>'.get_role($dd['courseid'],$dd2['assignfrom']) ; ?></td>
				<td width="150"><?php echo get_name_from_id($dd2['assignto']).'<br>'.get_role($dd['courseid'],$dd2['assignto']) ; ?></td>
				<td width="70"><?php echo $dd2['datime'] ; ?></td>
				<td width="100">
				<?php 
					//$remain = (secondsToTime(strtotime($dd2['datime'])- $dd['time'])) ;
					$remain = (secondsToTime(strtotime($dd2['datime'])- $dd2['time'])) ;
					//$remain = (secondsToTime($dd2['datime'])) ;
					echo $remain['h'].' giờ '.$remain['m'].' Phút';
					//echo $dd2['datime'] ; 
				?>
				</td>
			</tr>
		<?php
			}
		?>
		</table>
	</td>
	<td colspan="2" width="220">
			<table border="0" style="font-size:90%">
			<?php 
				$query_string3 = "SELECT id FROM tblanswer WHERE thread=".$dd['id'];
				$ad3 = $mysqli->query($query_string3);
				while($dd3 = $ad3->fetch_assoc()) 
				{
			?>
				<tr>
				
				<?php 
					//echo get_name_from_id(get_reply_id($dd3['id'])) ; 
					echo get_reply_id($dd3['id']) ; 
				?>
			
				</tr>
			<?php
				}
			?>
			</table>
	</td>
	<!--
	<td align="center">
	<?php //if ($dd['reply_time']>0 ) {echo date('d/m/Y H:i:s',$dd['reply_time']) ;}?>
	</td>
	-->
	<td><div align="center">
		<?php 
			if ($dd['reply_time']>0 ) 
			{
				$remain = (secondsToTime($dd['reply_time']- $dd['time'])) ;
				
			}
			else
			{
				$remain = (secondsToTime(time()-$dd['time'])) ;
			}
			//echo $remain['d'].' ngày '.$remain['h'].' h '.$remain['m'].' Phút';
			echo $remain['h'].' giờ '.$remain['m'].' Phút';
			
		?>
		</div>
	</td>
	

  </tr>
			
			
			<?php
			
			
			}
			//$ad = $mysqli->query('DROP VIEW baocao');			
  } 

function get_name_from_id($u_id)

{
global $mysqli;
$query_string = "select firstname,lastname from mdl_user where id='".$u_id."' ";	
$ad = $mysqli->query($query_string);
$dd = $ad->fetch_assoc();
return $dd['lastname'].' '.$dd['firstname'];	
}


function get_cname($c_id)

{
global $mysqli;
$query_string = "select fullname from mdl_course where id='".$c_id."' ";	
$ad = $mysqli->query($query_string);
$course = $ad->fetch_assoc();
return $course['fullname'];			

}


function get_reply_id($ans_id)

{
global $mysqli;
$query_string = "SELECT userid,time FROM tblreply WHERE answerid='".$ans_id."' and time <>0 and time <>'' ";	
$ad = $mysqli->query($query_string);
$user_reply = $ad->fetch_assoc();
if ($user_reply['time']!='')
{
return '<td width="150">'.get_name_from_id($user_reply['userid']).'<br>'.get_role($dd['courseid'],$user_reply['userid']).'</td><td width="70">'.date('d/m/Y H:i:s',$user_reply['time']).'</td>';			
}
else
return '';
}

function secondsToTime($seconds)
{
	
    // extract hours
    $hours = floor($seconds / (60 * 60));
    
	// day 
	//$day   =  floor($hours / 24);
	//$divisor_hour = $hours % 24;
    // extract minutes
    $divisor_for_minutes = $seconds % (60 * 60);
    $minutes = floor($divisor_for_minutes / 60);
 
    // extract the remaining seconds
    $divisor_for_seconds = $divisor_for_minutes % 60;
    $seconds = ceil($divisor_for_seconds);
 
    // return the final array
    $obj = array(
        "h" => (int) $hours,
        "m" => (int) $minutes,
        "s" => (int) $seconds,
    );
	/*
	 $obj = array(
	    "d" => (int) $day,
        "h" => (int) $divisor_hour,
        "m" => (int) $minutes,
        "s" => (int) $seconds,
    );
	*/
    return $obj;
}


function get_role($c_id,$u_id)



{

//return  $c_id.'<br>'.$u_id;
global $mysqli;
	if($c_id!=0)
	{

$sql="select r.shortname from mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
  c.id='".$c_id."' and u.id='".$u_id."'";
	}
    elseif ($c_id==0)	
    {
 $sql="SELECT r.shortname shortname
							FROM mdl_user u
							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
							INNER JOIN mdl_context ct ON ct.id = ra.contextid
							INNER JOIN mdl_course c ON c.id = ct.instanceid
							INNER JOIN mdl_role r ON r.id = ra.roleid
							INNER JOIN mdl_course_categories cc ON cc.id = c.category
                            where u.id='".$u_id."'
							order by r.sortorder asc limit 0,1";   
    }

		$ad = $mysqli->query($sql);
		$rolename = $ad->fetch_assoc();
		return $rolename['shortname'];		
}







?>


</table>

<?php
 //print_footer($site); ?>