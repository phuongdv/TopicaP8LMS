<?php
require_once("../config.php");
require_login();
global $CFG, $QTYPES;
$startdate	=	$_POST['startdate'];
$enddate	=	$_POST['enddate'];
$role		=	$_POST['role'];
$monhoc		=	$_POST['monhoc'];
$ok			=	$_POST['ok'];
$excell		=   $_POST['excell'];
$excellbtn  =   $_POST['excellbtn'];
$lopmon		=	$_POST['coursemoodle'];
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
if($excellbtn=='')
{
print_header("LMS200",'<a href="index.php">'. "$stradministration</a>->Tai khoan");


?>
<script type="text/javascript">
		function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
	}
	
	
	
	function getCity(strURL) {		
		
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('coursemoodle').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
				
	}

			HTMLArea.init();

			HTMLArea.onload = initDocument;

		</script>
<script src="datetimepicker_css.js"></script>
<style type="text/css">

a:hover {background:#ffffff; text-decoration:none;} /*BG color is a must for IE6*/
a.tooltip span {display:none; padding:2px 3px; margin-left:8px; width:auto;}
a.tooltip:hover span{display:inline; position:absolute; border:1px solid #cccccc; background:#ffffff; color:#6c6c6c;}
</style>


<form id="form1" name="form1" method="post" action="">
<table width="100%" border="1" style="font-size:80%">
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
    <td>Xem theo:</td>
    <td><label>
      <select name="role" id="role">
        <option value="4" <?php if($role=='4') echo 'selected="selected"';  ?>>GV Chuyên môn</option>
        <option value="14"<?php if($role=='14') echo 'selected="selected"';  ?>>GV Hướng dẫn</option>
		<option value="13"<?php if($role=='13') echo 'selected="selected"';  ?>>PO môn</option>
				<option value="211" <?php if($role=='211') echo 'selected="selected"';  ?>>PO lớp môn</option>
		 <option value="3"<?php if($role=='3') echo 'selected="selected"';  ?>>CVHT</option>
        <option value="5"<?php if($role=='5') echo 'selected="selected"';  ?>>Học viên</option>
        
      </select>
    </label></td>
    <td>Môn :</td>
    <td><input type="text" name="monhoc" id="monhoc" value="<?php echo $monhoc;?>"/><label>
      
    </label></td>
  </tr>

   <tr>
    <td colspan="2"><label>Username
  <input type="text" name="fulluser" id="fulluser"  value="<?php echo $_POST['fulluser'] ;?>"/>
</label></td>
  <?php
  if(1==1)
  {
  ?>
    <td>Lớp môn</td>
    <td><select name="coursemoodle" id="coursemoodle" style="width:100px"><option value="" >Tất cả</option>
    <?php
   $ad = $mysqli->query('SET NAMES utf8');
    
	  $query_string = "SELECT * from mdl_course c where c.fullname like '%".$monhoc."%' and (  (c.enrolstartdate>=UNIX_TIMESTAMP('$startdate') and c.enrolstartdate <=UNIX_TIMESTAMP('$enddate')) or (c.enrolenddate>=UNIX_TIMESTAMP('$startdate') and c.enrolenddate <=UNIX_TIMESTAMP('$enddate'))  )  order by c.fullname asc";
	 echo $query_string;
	 
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

    header("Content-Disposition: attachment;filename=LMS200_REPORT.xls");
echo 'Từ ngày :'.$startdate.' Đến ngày: '.$enddate;
}

?>
<table width="100%" border="1" style="font-size:80%" cellpadding="5">
  <tr>
    <td width="18" rowspan="2">TT</td>
    <td width="557" rowspan="2">Lớp môn</td>
    <td width="76" rowspan="2">Bắt đầu </td>
	<td width="76" rowspan="2">Kết thúc </td>
    <td width="76" rowspan="2">Số HV</td>
    <td width="71" rowspan="2">User</td>
    <td width="113" rowspan="2">Loại user</td>
    <td colspan="4" align="center">H2472</td>
    <td width="26" align="center" colspan="5">Diễn đàn</td>
    <td width="134" rowspan="2" >Lần login cuối</td>
  </tr>
   <tr>
    <td width="50">Đã assign</td>
    <td width="45">Trả lời đúng hạn</td>
    <td width="48">Trả lời quá hạn</td>
	  <td width="48">Không trả lời</td>
	    
    <td width="45">CM</td>
	<td width="50">CS</td>
	<td width="45">TK</td>
    <td width="45">TLM</td>
	  <td width="48">Tổng số post</td>
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
		// role la thay giao 
    if($_POST['fulluser']!='')
	 {
	 $search=strip_tags($_POST['fulluser']);
	 $sql_user=" and u.username like '%".$search."%'";
	 
	 }
		
		
		if($lopmon!='')
		{
				
        $query_string = "
		
		
CREATE VIEW baocao AS 
		SELECT DISTINCT
	FROM_UNIXTIME(u.lastlogin)lastlogin,
	c.id cid,
	c.enrolstartdate cstart,
	c.enrolenddate cend,
	u.id uid,
	u.username,
	c.fullname,
	r. NAME rolename,
	(
		select count(tblanswer.id) 
			from tblanswer
WHERE 
                  
			tblanswer.assignid = uid
      and tblanswer.courseid=cid

	)h2472,
(
 select count(DISTINCT(tblreply.answerid))
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time <= 3600*72
			and 
      tblanswer.courseid=cid
      and 
      tblreply.userid=uid


)
so_cau_h2472_datraloi_dunghan,
(
 select count(DISTINCT(tblreply.answerid))
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time > 3600*72
			and 
      tblanswer.courseid=cid
      and 
      tblreply.userid=uid

)
so_cau_h2472_datraloi_quahan,(
		SELECT
			active_id
		FROM
			huy_setting_lipe
		WHERE
			c_id = cid
		AND style = 'forum'
	LIMIT 0,
	1
	)activeid
FROM
	mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE r.id='".$role."'
				and c.id='$lopmon'
				and (	(
						c.enrolstartdate <= UNIX_TIMESTAMP('$startdate')
					AND c.enrolenddate >= UNIX_TIMESTAMP('$startdate')
					)
					OR(
						c.enrolstartdate >= UNIX_TIMESTAMP('$startdate')
					AND c.enrolstartdate <= UNIX_TIMESTAMP('$endtdate')
					)   ) 
				$sql_user
				ORDER BY u.username asc
				";
		}
		else 
		{
			$query_string = "
			
CREATE VIEW baocao AS 
			SELECT DISTINCT
	FROM_UNIXTIME(u.lastlogin)lastlogin,
	c.id cid,
	c.enrolstartdate cstart,
	c.enrolenddate cend,
	u.id uid,
	u.username,
	c.fullname,
	r. NAME rolename,
	(
			select count(tblanswer.id) 
			from tblanswer
WHERE 
                 
			tblanswer.assignid = uid
      and tblanswer.courseid=cid
	 
	)h2472,
(
 select count(DISTINCT(tblreply.answerid))
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time <= 3600*72
			and 
      tblanswer.courseid=cid
      and 
      tblreply.userid=uid


)
so_cau_h2472_datraloi_dunghan,
(
 select count(DISTINCT(tblreply.answerid))
			from tblanswer,tblreply
			WHERE 
			tblreply.answerid=tblanswer.id
			and
			tblreply.time - tblanswer.time > 3600*72
			and 
      tblanswer.courseid=cid
      and 
      tblreply.userid=uid

)
so_cau_h2472_datraloi_quahan,(
		SELECT
			active_id
		FROM
			huy_setting_lipe
		WHERE
			c_id = cid
		AND style = 'forum'
	LIMIT 0,
	1
	)activeid
FROM
	mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE r.id='".$role."'
				AND c.fullname like '%".$monhoc."%'
					and (  
						(
							c.enrolstartdate <= UNIX_TIMESTAMP('$startdate')
						AND c.enrolenddate >= UNIX_TIMESTAMP('$startdate')
						)
						OR(
							c.enrolstartdate >= UNIX_TIMESTAMP('$startdate')
						AND c.enrolstartdate <= UNIX_TIMESTAMP('$endtdate')
						)  ) 
				$sql_user
				ORDER BY u.username asc
				";
			
		}
	    }
        
	 echo $query_string;
	 $ad = $mysqli->query('DROP VIEW baocao');		 
     $ad = $mysqli->query($query_string);
	 $query_string="select *,h2472-(so_cau_h2472_datraloi_dunghan+so_cau_h2472_datraloi_quahan) khong_tl from baocao";
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
    <td><?php echo $dd['fullname'] ;?></td>
    <td><?php echo ($dd['cstart']==0 ? 'Chưa đặt' : date('d-m-Y',$dd['cstart']));?></td>
	<td><?php echo ($dd['cend'] ==0 ? 'Chưa đặt' : date('d-m-Y',$dd['cend']));?></td>
		<td><div align="center"><?php echo demsohocvien($dd['cid']) ;?></div></td>
    <td><?php echo $dd['username'] ;?></td>
    <td><?php echo $dd['rolename'] ;?></td>
    <td><div align="center"><?php echo $dd['h2472'] ;?></div></td>
	<td><div align="center"><?php echo $dd['so_cau_h2472_datraloi_dunghan'] ;?></div></td>
	<td><div align="center"><?php echo $dd['so_cau_h2472_datraloi_quahan'] ;?></div></td>
	<td><div align="center"><?php if($dd['khong_tl']>0) echo $dd['khong_tl'] ; else echo '0';?></div></td>
	 <td width="50"><?php echo demsocm($dd['username'],$dd['activeid']) ;?></td>
	 <?php if($excellbtn=='' && showcs($dd['username'],$dd['activeid'])!=false){ ?>
	 <td width="50"><a href="http://forum.hou.topica.vn/forumdisplay.php?f=<?php echo $dd['activeid']; ?>" class="tooltip"><?php echo demsocs($dd['username'],$dd['activeid']) ;?><span><?php echo showcs($dd['username'],$dd['activeid']) ;?></span></a></td>
     <?php } else {?>
	 <td width="50"><?php echo demsocs($dd['username'],$dd['activeid']) ;?></td>
	 <?php } ?>
 <td width="50"><?php echo demsotk($dd['username'],$dd['activeid']) ;?></td>
	  
     <td width="50"><?php echo demsotl($dd['username'],$dd['activeid']) ;?></td>
    <td><div align="center"><?php echo demsopost($dd['username'],$dd['activeid']) ;?></div></td>
    <td><div align="center"><?php echo $dd['lastlogin'] ;?></div></td>
  </tr>
			
			
			<?php
			
			
			}
			$ad = $mysqli->query('DROP VIEW baocao');			
  } 


function demsopost($username,$activeid)
{

    
  $link= mysql_connect("210.245.87.137:3306","c5hieupd","hieu3#");
		mysql_select_db("c5forum");
		$sql="
		select count(vp.postid) 
		from vbb_post vp,vbb_thread vt 
		where  vp.username= '".$username."' 
		and vp.threadid=vt.threadid 
		and vt.forumid = $activeid ";
		$data = mysql_query($sql) ;
        $info = mysql_fetch_array( $data ); 
		$result_count =  $info["count(vp.postid)"];
      return $result_count;
	  	 mysql_close($link);
//return $sql;

}







function demsocs($username,$activeid)
{

    
  $link= mysql_connect("210.245.87.137:3306","c5hieupd","hieu3#");
		mysql_select_db("c5forum");
		$sql="
		select count(*) socs from vbb_thread  where iconid=3 and postusername='$username' and forumid='$activeid'";
		//echo $sql;
		$data = mysql_query($sql) ;
        $info = mysql_fetch_array( $data ); 
		$result_count =  $info["socs"];
		
	
      return $result_count;
	  mysql_close($link);
//return $sql;

}

function showcs($username,$activeid)
{

    
  $link= mysql_connect("210.245.87.137:3306","c5hieupd","hieu3#");
		mysql_select_db("c5forum");
		$sql="
		select title,FROM_UNIXTIME(dateline) time from vbb_thread  where iconid=3 and postusername='$username' and forumid='$activeid'";
		//echo $sql;
		$data = mysql_query($sql) ;
		$num_rows = mysql_num_rows($data);
		if($num_rows>0)
		{
			$str='';
			$i=1;
			while($info = mysql_fetch_array( $data )) 
			{
			$str=$str.'Case '.$i.':'.$info['title'].'<br>Ngày post:'.$info['time'].'<hr>'; 
			$i=$i+1;
            }
		 mysql_close($link);		
		 return $str;
         	 
		}
		else
		{
		mysql_close($link);
		return false;
		
        }
	  
//return $sql;

}


function demsocm($username,$activeid)
{

    
  $link= mysql_connect("210.245.87.137:3306","c5hieupd","hieu3#");
		mysql_select_db("c5forum");
		$sql="
		select count(*) socs from vbb_thread  where iconid=7 and postusername='$username' and forumid='$activeid'";
		$data = mysql_query($sql) ;
        $info = mysql_fetch_array( $data ); 
		$result_count =  $info["socs"];
		
	
     // return $result_count;
	  if($result_count==0)
	   {
	   return 'Không';
	   }
	  else
       {
	   return 'Có';
	   }	  
	  
	  mysql_close($link);
//return $sql;

}
function demsotk($username,$activeid)
{

    
  $link= mysql_connect("210.245.87.137:3306","c5hieupd","hieu3#");
		mysql_select_db("c5forum");
		$sql="
		select count(*) socs from vbb_thread  where iconid=1 and postusername='$username' and forumid='$activeid'";
		$data = mysql_query($sql) ;
        $info = mysql_fetch_array( $data ); 
		$result_count =  $info["socs"];
		
	
      return $result_count;
	
	  mysql_close($link);
//return $sql;

}

function demsotl($username,$activeid)
{

    
  $link= mysql_connect("210.245.87.137:3306","c5hieupd","hieu3#");
		mysql_select_db("c5forum");
		$sql="
		select count(*) socs from vbb_thread  where iconid=14 and postusername='$username' and forumid='$activeid'";
		$data = mysql_query($sql) ;
        $info = mysql_fetch_array( $data ); 
		$result_count =  $info["socs"];
		
	
      return $result_count;
	
	  mysql_close($link);
//return $sql;

}

function demsolanlogin($uid,$start,$end)
{
global $mysqli;
$query_string = "select count(*) count from mdl_log where time > UNIX_TIMESTAMP('$start') and time < UNIX_TIMESTAMP('$end') and action='login' and userid = '$uid'";
$ad = $mysqli->query($query_string);
$dd = $ad->fetch_assoc();
return $dd['count'];


}	

function demsohocvien($cid)
{
global $mysqli;
$query_string = "SELECT Count(DISTINCT u.id) sohv
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
				WHERE  r.id='5'
				and
				c.id='$cid'
				";
$ad = $mysqli->query($query_string);
$dd = $ad->fetch_assoc();
return $dd['sohv'];


}	
?>
</table>
<?php print_footer($site); ?>