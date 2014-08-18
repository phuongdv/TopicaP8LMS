<?php
	$_SESSION['lang'] = 'en';
	//danglx: mục đóng h2472
	//if(time() > 1390237200+172800-3600*7  and time()< 1391990400-3600*7)
	$close_h2472 = strtotime('2014-04-29 17:00:00');
	$open_h2472 = strtotime('2014-05-05 00:00:00');
	$off_h2472 = 14400;//4 gio
	if(time() > ($close_h2472+$off_h2472)  and time()< $open_h2472)
	{
		echo '<script>alert("Nghỉ lễ 30/4 và 01/05. Hệ thống H2472 đóng cửa từ 17h00 29/04/2014 đến 0h00 05/05/2014");window.location="http://dev.lms.amatop.ph/index.php/vi/sinh-vien/thong-bao-sinh-vien"</script>';
		die();
	}
	// file can thiet
		//include lang/vi.php by giangdv
	include('../config.php');
	include('includes/config.inc.php');
	include($dir_inc.'template.php');
	include($dir_inc.'function.php');
	include($dir_inc.'Log.class.php');
	include($dir_inc.'functions.php');
	require '../vietth/securecookie.php';
	// ------------------------------------------------------------------------------------------------------
	ob_start();
	session_start();
	
	$template = new Template();
	// bat dau lay du lieu tu tren link
	$from='';
	if(isset($_GET['from']))
	$from =$_GET['from'];
	if(isset($_GET['sname']))
	$sname =$_GET['sname'];
	$thr_id='';
	if(isset($_GET['thr_id']))
	$thr_id =$_GET['thr_id'];
	$monhoc='';
	if(isset($_GET['monhoc']))
	$monhoc =$_GET['monhoc'];
	if(isset($_GET['status']))
	$status =$_GET['status'];
	$searchtext='';
	if(isset($_GET['searchtext']))
	$searchtext =$_GET['searchtext'];
	$attach='';
	if(isset($_GET['attach']))
	$attach =$_GET['attach'];
	$p='';
	if(isset($_GET['p']))
	$p =$_GET['p'];
	$norefresh='';
	if(isset($_GET['r']))
	$norefresh =$_GET['r'];
	$thread='';
	if(isset($_GET['thread']))
	$thread =$_GET['thread'];
	$page='';
	if(isset($_GET['page']))
	$page =$_GET['page'];
	$delay='';
	if(isset($_GET['delay']))
	$delay =$_GET['delay'];
	$topic='';
	if(isset($_GET['topic']))
	$topic =$_GET['topic'];
	$sname='';
	if(isset($_GET['sname']))
	$sname =$_GET['sname'];
	$name = '';
	if(isset($_GET['name']))
	$name = $_GET['name'];
	$ss = '';
	if(isset($_GET['ss']))
	$ss = $_GET['ss'];
	$act = '';
	if(isset($_GET['act']))
	$act = $_GET['act'];
	if(isset($_GET['qid']))
	$qid = $_GET['qid'];
	$do = '';
	if(isset($_GET['do']))
	$do = $_GET['do'];
	//------------------------------------------------------------------------------------------------------
	if($act=='export')
	{
		include($dir_inc.'po_excel.php');	
		exit;	
	}
	if($act=='fastreply')
	{
		include($dir_inc.'fast_reply.php');	
		exit;	
	}
	
	if($act=='getlink')
	{
		include($dir_inc.'get_reply_link.php');		
		exit;
	}
	
	if($act=='send')
	{
		include($dir_inc.'send.php');		
	}
	
	$a_id = '';
	if(isset($_GET['aid']))
	$a_id = (int)$_GET['aid'];
	$id = '';
	if(isset($_GET['id']))
	$id = (int)$_GET['id'];
	$qid = '';
	$del = 0;
	if(isset($_GET['del']))
	$del = (int)$_GET['del'];
	$mess = 0;
	if(isset($_GET['mess']))
	$mess = (int)$_GET['mess'];
	$class = 0;
	if(isset($_GET['class']))
	$class = (int)$_GET['class'];
	$course = 0;
	if(isset($_GET['course']))
	$course = (int)$_GET['course'];
	$gv = 0;
	if(isset($_GET['gv']))
	$gv = (int)$_GET['gv'];
	$aid = 0;
	if(isset($_GET['aid']))
	$aid = (int)$_GET['aid'];
	$auser = 0;
	if(isset($_GET['userid']))
	$auser = (int)$_GET['userid'];
	$subject = 0;
	if(isset($_GET['subject']))
	$subject = (int)$_GET['subject'];
	if ( $act == 'logout') {
		
		
		if(!isset($_COOKIE["user"]))
		{
			echo '<script type="text/javascript">
			<!--
			window.location = "http://dev.lms.amatop.ph"
			//-->
			</script>';
		}
		else{
			echo '<script type="text/javascript">
			<!--
			window.location = "'.$_COOKIE["user"].'"
			//-->
			</script>';
			
		}
		
		$_SESSION['fe'] ="";
		exit();
	}
	
	$C = new SecureCookie('6rCgffX5mX','Iq6cJ0116W',time()+3600,'/','.topica.vn');
	
	$moodle_login=$C->Get('login');
	
	
	if (isset($_SESSION['h2472']['fontend']) && $_SESSION['h2472']['fontend'] == 'topica' ) {
		$profiles = $_SESSION['h2472'];
		$sql_user = "SELECT * FROM mdl_user WHERE id = '".$profiles['id']."'";
		$sql_user = $db->sql_query($sql_user) or die(mysql_error());
		while($user_rows = $db->sql_fetchrow($sql_user)) {
			$pro_puctrue	= 0;
			$pro_author		= $user_rows['lastname'].' '.$user_rows['firstname'];
			$pro_group		= "<font style=\"text-transform:uppercase\">".$profiles['code']."</font>";
		}
		
	}
	if ( (!isset($_SESSION['h2472']['fontend']) || $_SESSION['h2472']['fontend'] != 'topica')) 
	{  
		// get cookie
		$C = new SecureCookie('6rCgffX5mX','Iq6cJ0116W',time()+3600*24,'/','.topica.vn');       
		$username=$C->Get('username');
		$password=$C->Get('password');	 
		
		// ---------------------------------------
		$sql = "SELECT * FROM mdl_user WHERE username = '".$username."'
		AND password  = '".$password."'
		AND confirmed = 1";
		
		$result = $db->sql_query($sql);
		$fontend = "";
		if($db->sql_numrows($result)){
            while($db->sql_fetchrow($result)){
				if(!isset($subject) || $subject=='' || $subject == 0 || $subject == 238){
					$sql_values="SELECT r.id id,r.shortname shortname
					FROM mdl_user u
					INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
					INNER JOIN mdl_context ct ON ct.id = ra.contextid
					INNER JOIN mdl_course c ON c.id = ct.instanceid
					INNER JOIN mdl_role r ON r.id = ra.roleid
					INNER JOIN mdl_course_categories cc ON cc.id = c.category
					where u.id='".$db->row[$result]['id']."'
					
					order by r.sortorder asc limit 0,1";
				}
				else{
					$sql_values="SELECT r.id id,r.shortname shortname
					FROM mdl_user u
					INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
					INNER JOIN mdl_context ct ON ct.id = ra.contextid
					INNER JOIN mdl_course c ON c.id = ct.instanceid
					INNER JOIN mdl_role r ON r.id = ra.roleid
					INNER JOIN mdl_course_categories cc ON cc.id = c.category
					where u.id='".$db->row[$result]['id']."'
					and c.id='".$subject."'
					order by r.sortorder asc limit 0,1";
				}			
				
				$sql_values = $db->sql_query($sql_values);
				
				if($db->sql_numrows($sql_values)){
					while($values_row = $db->sql_fetchrow($sql_values)){
						//danglx them quyen cho tro giang nganh 02-01-2014
						if ($values_row['shortname']=='tro_giang_nganh')
						{
							$fontend['code'] ='po2';
						}
						else
						{
							$fontend['code'] =$values_row['shortname'];
						}
						//$fontend['code'] =$values_row['shortname'];
						
						$fontend['id'] = $db->row[$result]['id'];
						$fontend['username'] = $db->row[$result]['username'];
						$fontend['fontend'] = 'topica';
						$_SESSION['h2472'] = $fontend;
					}
				}
				else {
					header('location: ./?subject=1333');
				}        
			}
			
			echo '<script type="text/javascript">
			window.location = "http://dev.lms.amatop.ph/h2472/?subject='.$subject.'";
			</script>';
			
		}
		else {
			header('location: http://dev.lms.amatop.ph');
		}
	}
	else {
	
		if($moodle_login==1)
		{
			if($do=="assign") {
				include($dir_inc.'assign.php');
			} 
			elseif($do=="knowledge") {
				include($dir_inc.'header.php');
				include($dir_inc.'knowledge.php');
			} 
			elseif($do=="edit_thread") {
				include($dir_inc.'thread_edit.php');
			} 
			elseif($do=="alert_unassign")
			include($dir_inc.'alert_unassign.php'); 
			elseif($do=="view_kkt") {
				include($dir_inc.'header.php');
				include($dir_inc.'khokienthuc.php');
			} 
			else {
				if(!isset($act)||$act=='') {
					switch ($profiles['code']) {
						case 'admin':
						include($dir_inc.'admin.php');
						break;
						case 'po2':
						include($dir_inc.'po.php');
						break;
						case 'po1':
						include($dir_inc.'po.php');
						break;
						case 'tro_giang_nganh':
						include($dir_inc.'trogiang.php');
						break;
						case 'gvcm':
						include($dir_inc.'gvcm.php');
						break;
						case 'gvhd':
						include($dir_inc.'gvhd.php');
						break;
						case 'pm':
						include($dir_inc.'pm.php');
						break;
						case 'cvht':
						include($dir_inc.'cvht.php');
						break;
						case 'cbqlht':
						include($dir_inc.'cvht.php');
						break;
						case 'povh_lop_mon':
						include($dir_inc.'polm.php');
						break;
						case 'ktv':
						include($dir_inc.'kt.php');
						break;
						case 'hoc_vien':
						//danglx: mục đóng h2472
						if(time() > $close_h2472  and time()< $open_h2472)
						{
							echo '<script>alert("Nghỉ lễ 30/4 và 01/05. Hệ thống H2472 đóng cửa từ 17h00 29/04/2014 den 0h00 05/05/2014");window.location="http://dev.lms.amatop.ph/index.php/vi/sinh-vien/thong-bao-sinh-vien"</script>';
							die();
						}
						include($dir_inc.'hv.php');
						break;
						case 'tngv':
						include($dir_inc.'tngv.php');
						break;
						case 'gvcn':
						include($dir_inc.'gvcn.php');
						break;
						case 'ldtt_neu':
						include($dir_inc.'ldtt_neu.php');
						break;
						default:
						header('location: ./?subject=238');
						break;
					}
				}elseif($act=="topic") {
					if($do=="modify")
					include($dir_inc.'topic-modify.php');
					else
					include($dir_inc.'topic.php');
				} elseif($act=="answers") {
					if($do=="creat")
					{
						//danglx: mục đóng h2472
						if(time() > $close_h2472  and time()< $open_h2472)
						{
							echo '<script>alert("Nghỉ lễ 30/4 và 01/05. Hệ thống H2472 đóng cửa từ 17h00 29/04/2014 den 0h00 05/05/2014");window.location="http://dev.lms.amatop.ph/index.php/vi/sinh-vien/thong-bao-sinh-vien"</script>';
							die();
						}
						include($dir_inc.'answers-creat.php');
					}
					elseif($do=="detail")
					include($dir_inc.'answers-detail.php');
					elseif($do=="edit")
					include($dir_inc.'answers-creat.php');
					elseif($do=="close")
					include($dir_inc.'answers-detail.php');
					elseif($do=="open")
					include($dir_inc.'answers-detail.php');
					elseif($do=="unassign")
					include($dir_inc.'answers-detail.php');
					elseif($do=="set_kkt")
					include($dir_inc.'answers-detail.php');
					elseif($do=="unset_kkt")
					include($dir_inc.'answers-detail.php');
					elseif($do=="thanks")
					include($dir_inc.'answers-detail.php');
					elseif($do=="report")
					include($dir_inc.'report.php');
					else
					include($dir_inc.'answers.php');
				} elseif($act=="rp") {
					include($dir_inc.'rp.php');
				} 
				elseif($act=="meg") {
					include($dir_inc.'meg.php');
				}
				include($dir_inc.'footer.php');
			}
		?>
		<!--
			Phan them popup
		-->
		<link rel="stylesheet" href="css/danglx.css">	
		<!-- <script type="text/javascript" src="jquery-1.4.4.min.js"></script> -->
		<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="js/jquery.popup.js"></script>	
		
		
		
		<script type="text/javascript" >
			jQuery.noConflict();      /* dòng chống conflict jquery */
			jQuery(window).load(function() {
				if(document.cookie.indexOf("adf") == -1) /*  Bỏ dòng này thì nó hiện thông báo liên tục mỗi khi mở web lên rất là phiền  */
				{
					document.cookie = "popunder1=adf";
					jQuery('#myModal').danglx(jQuery('#myModal').data());
				}
			});
			function myModal(){
				div = document.getElementById("myModal");div.style.display= "none";
				div = document.getElementById("modal-bg");div.style.display= "none";
			}
			setTimeout(myModal, 10000);
			
		</script>
		
		
		<div id="myModal" class="danglx-modal">
			<div id="popup-header" align="center">
				<span class="style1"><font size="5"><b></b></font></span>
			</div>
			<span class="style2">
				<div id="popup-content">
					<br>Welcome
					<b></b> to H2472 area.<br>
					This is Question and Answer system <b>1 - 1</b>: A student with a lecturer or a student with a student  counsellor or a student with an administrator. 
					H2472 is a system receiving and confirming questions from students within 24 hours and answering questions within 72 hours.
				</div>
			</span>
			<a class="close-danglx-modal">X</a>
		</div>	
		
		<?php
		}
		else
		{
			echo "You must login Elearing to enter system H2472";
			//header('location:http://dev.lms.amatop.ph');
		}
	}
?>