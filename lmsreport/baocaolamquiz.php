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
		print_header("Quiz taking report - LMS250-quiz",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
		
		
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
				<td width="180">From date:(YYYY-MM-DD)</td>
				<td >
					<label>
						<input type="text" name="startdate" id="startdate"   value="<?php echo $startdate;?>" />
						<img src="images2/cal.gif" onclick="javascript:NewCssCal('startdate','yyyyMMdd')" style="cursor:pointer"/>
					</label>
				</td>
				<td width="180">To date :(YYYY-MM-DD)</td>
				<td >
					<label>
						<input type="text" name="enddate" id="enddate" width="10"   value="<?php echo $enddate;?>"  />
						<img src="images2/cal.gif" onclick="javascript:NewCssCal('enddate','yyyyMMdd')" style="cursor:pointer"/>
					</label>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>Subject :</td>
				<td><input type="text" name="monhoc" id="monhoc" value="<?php echo $monhoc;?>"/><label>
					
				</label></td>
			</tr>
			
			<tr>
				<td colspan="2"></td>
				<?php
					if(1==1)
					{
					?>
					<td></td>
					<td></td>
				</tr>
				<?php
				}
				else 
				{
					
				?>
				<td>Module Class</td>
				<td><select name="coursemoodle" id="coursemoodle">
					
				</select></td>
			</tr>
			
		<? } ?>
		<tr>
			<td colspan="4" align="center">
				<label>
					<input type="submit" name="ok" id="ok" value="      View     " />
					
				</label>
				<label>
					<input type="submit" name="excellbtn" value="    Export to Excel     " />
				</label>
			</div></td>
	</tr>
</table></form>
<span style="font-size:10px">
	Notes : <br>
	Click on the course name to view detailed class report
</span>
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
	
    header("Content-Disposition: attachment;filename=LMS250-quiz_REPORT.xls");
	echo 'Từ ngày :'.$startdate.' Đến ngày: '.$enddate;
}

?>
<table width="100%" border="1" style="font-size:80%" cellpadding="5">
	<tr>
		<td width="50">No.</td>
		<td width="50">Class Management</td>
		<td width="50">Total Learner</td>
        <td width="50"> Number of students taking the quiz</td>
		<td width="50">LTTN1</td>
		<td width="50">Number of students taking LTTN1</td>
		<td width="48">LTTN2</td>
		<td width="50">Number of students taking LTTN2</td>
		<td width="46">LTTN3</td>
		<td width="50">Number of students taking LTTN3</td>
		<td width="48">LTTN4</td>
		<td width="50">Number of students taking LTTN4</td>
		<td width="48">LTTN5</td>
		<td width="50">Number of students taking LTTN5</td>
		<td width="48">LTTN6</td>
		<td width="50">Number of students taking LTTN6</td>
		<td width="48">BTVN1</td>
		<td width="50">Number of students taking BTVN1</td>
		<td width="48">BTVN2</td>
		<td width="50">Number of students taking BTVN2</td>
		<td width="48">BTVN3</td>
		<td width="50">Number of students taking BTVN3</td>
	</tr>
	
	<?
		
		
		
		
		
		if($ok!='' || $excellbtn!='')
		{
			if($startdate=='' || $enddate=='' )
			{
				echo '<script>alert(\'Start date , end date  is not empty\')</script>';
				
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
					$sql_user=" and u.username = '".$search."'";
					
				}
				
			}
			
			if($monhoc!='')
			
			{
				$sql_monhoc=" AND c.fullname like '$monhoc%'";	
			}
			$query_string="
			SELECT
			distinct
			c.id cid,
			c.fullname
			FROM
			mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE
			r.id = '5' ".$sql_monhoc." 
			AND(  
			(
			c.enrolstartdate <= UNIX_TIMESTAMP('$startdate')
			AND c.enrolenddate >= UNIX_TIMESTAMP('$startdate')
			)
			OR(
			c.enrolstartdate >= UNIX_TIMESTAMP('$startdate')
			AND c.enrolstartdate <= UNIX_TIMESTAMP('$enddate')
			)  ) 
			order by c.enrolenddate-UNIX_TIMESTAMP() asc										
			";
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
				<td><?php echo $t ;?></td>
				<td><a href= "baocaolamquiz_detail.php?c=<?php echo $dd['cid'] ;?>" target="_blank"><?php echo $dd['fullname'] ;?></a></td>
				<td><?php echo demsohocvien($dd['cid']); ?></td>
				<td><?php echo sohvlambai($dd['cid']); ?></td>
				<td><?php echo demsobaitn($dd['cid'],1); ?></td>
				<td><?php echo sohvlambailt($dd['cid'],1); ?></td>
				<td><?php echo demsobaitn($dd['cid'],2); ?></td>
				<td><?php echo sohvlambailt($dd['cid'],2); ?></td>
				<td><?php echo demsobaitn($dd['cid'],3); ?></td>
				<td><?php echo sohvlambailt($dd['cid'],3); ?></td>
				<td><?php echo demsobaitn($dd['cid'],4); ?></td>
				<td><?php echo sohvlambailt($dd['cid'],4); ?></td>
				<td><?php echo demsobaitn($dd['cid'],5); ?></td>
				<td><?php echo sohvlambailt($dd['cid'],5); ?></td>
				<td><?php echo demsobaitn($dd['cid'],6); ?></td>
				<td><?php echo sohvlambailt($dd['cid'],6); ?></td>
				<td><?php echo demsobaivn($dd['cid'],1); ?></td>
				<td><?php echo sohvlambaivn($dd['cid'],1); ?></td>
				<td><?php echo demsobaivn($dd['cid'],2); ?></td>
				<td><?php echo sohvlambaivn($dd['cid'],2); ?></td>
				<td><?php echo demsobaivn($dd['cid'],3); ?></td>
				<td><?php echo sohvlambaivn($dd['cid'],3); ?></td>
			</tr>
			
			
			<?php
				
				
			}
			
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
		
		function demsobaitn($cid,$stt)
		{
			global $mysqli;
			$query_string = "select count(qa.id) result from mdl_quiz_attempts qa,mdl_quiz q where  
			qa.quiz=q.id
			and
			qa.quiz=(select id from mdl_quiz where course=$cid and name like '%luyện tập%' and name like '%$stt%' )
			AND
			qa.userid in 
			(
			SELECT  u.id 
			FROM mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE 
			r.id=5
			and c.id = $cid
			)
			";
			$ad = $mysqli->query($query_string);
			$dd = $ad->fetch_assoc();
			return $dd['result'];	
			
		}
		
		function demsobaivn($cid,$stt)
		{
			global $mysqli;
			$query_string = "select count(qa.id) result from mdl_quiz_attempts qa,mdl_quiz q where  
			qa.quiz=q.id
			and
			qa.quiz=(select id from mdl_quiz where course=$cid and name like '%về nhà%' and name like '%$stt%' )
			AND
			qa.userid in 
			(
			SELECT  u.id 
			FROM mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE 
			r.id=5
			and c.id = $cid
			)
			";
			$ad = $mysqli->query($query_string);
			$dd = $ad->fetch_assoc();
			return $dd['result'];	
			
		}
		
		function sohvlambai($cid)
		{
			global $mysqli;
			$query_string="select count(DISTINCT qa.userid) result
			from mdl_quiz_attempts qa,mdl_quiz q,mdl_course c
			where 
			qa.quiz=q.id
			AND
			q.course=c.id
			and c.id='$cid'
			and
			qa.userid in (SELECT u.id
			FROM
			mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE
			
			c.id='$cid'
			and 
			r.id=5)
			";
			//echo $query_string;
			$ad = $mysqli->query($query_string);
			$dd = $ad->fetch_assoc();
			return $dd['result'];
			
			
		}
		
		function sohvlambailt($cid,$stt)
		{
			global $mysqli;
			$query_string="select count(DISTINCT qa.userid) result
			from mdl_quiz_attempts qa,mdl_quiz q,mdl_course c
			where 
			qa.quiz=q.id
			AND
			qa.quiz=(select id from mdl_quiz where course=$cid and name like '%luyện tập%' and name like '%$stt%' )
			AND
			q.course=c.id
			and c.id='$cid'
			and
			qa.userid in (SELECT u.id
			FROM
			mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE
			
			c.id='$cid'
			and 
			r.id=5)
			
			
			";
			//echo $query_string;
			$ad = $mysqli->query($query_string);
			$dd = $ad->fetch_assoc();
			return $dd['result'];
			
			
		}
		
		function sohvlambaivn($cid,$stt)
		{
			global $mysqli;
			$query_string="select count(DISTINCT qa.userid) result
			from mdl_quiz_attempts qa,mdl_quiz q,mdl_course c
			where 
			qa.quiz=q.id
			AND
			qa.quiz=(select id from mdl_quiz where course=$cid and name like '%về nhà%' and name like '%$stt%' )
			AND
			q.course=c.id
			and c.id='$cid'
			and
			qa.userid in (SELECT u.id
			FROM
			mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE
			
			c.id='$cid'
			and 
			r.id=5)
			
			";
			//echo $query_string;
			$ad = $mysqli->query($query_string);
			$dd = $ad->fetch_assoc();
			return $dd['result'];
			
			
		}
		
		
		
		
		
	?>
</table>
<?php print_footer($site); ?>