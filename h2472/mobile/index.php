<?php
$close_h2472 = strtotime('2014-04-29 17:00:00');
$open_h2472 = strtotime('2014-05-05 00:00:00');

if(time() > ($close_h2472)  and time()< $open_h2472)
{
echo '<script>alert("Nghỉ lễ 30/4 và 01/05. Hệ thống H2472 đóng cửa từ 17h00 29/04/2014 đến 00h00 05/05/2014");window.location="http://tvu.topica.edu.vn/index.php/vi/sinh-vien/thong-bao-sinh-vien"</script>';
die();
}
    $userid   = $_GET['u'];
	$courseid = $_GET['c'];
	$secret   = $_GET['s'];

    if($userid!='')
    {
    setcookie("u_h2472",$userid,time()+3600,'/','.topica.vn');
    }
    else
    {
    $userid = $_COOKIE['u_h2472'];
    }
    
    if($courseid!='')
    {
	setcookie("c_h2472",$courseid,time()+3600,'/','.topica.vn');
	}
	else
    {
    $courseid = $_COOKIE['c_h2472'];
    }
	 if($secret!='')
    {
	setcookie("s_h2472",$secret,time()+3600,'/','.topica.vn');
	}
    else
    {
     $secret = $_COOKIE['s_h2472'];
    }
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title></title>  
<link rel="shortcut icon" href="http://elearning.hou.topica.vn/theme/topica/favicon.ico">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
	<link rel="stylesheet" href="mobile_theme/topica.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	<link rel="stylesheet" href="css/checknet.css" media="all" />
	<script src="js/checknet-1.3.min.js">
	</script><link rel="stylesheet" href="css/mobile.css" /><script>
	$(document).bind("pageinit", function() 
	{    
	$.fn.checknet();	
	checknet.config.checkInterval = 500;  
	checknet.config.warnMsg = "Mất kết nối tới máy chủ !";	
	});    	 
	</script>
	</head>
	<body>
	
	
	<?php
	
        require_once("../includes/config.inc.php");
		$key = 'vietth';
		

		
		
		if($secret != md5($userid.$key) && $_POST['send']=='')
			{
			echo '
		 <div data-role="dialog">
			
				<div data-role="header" data-theme="d">
					<h1>Có lỗi xảy ra</h1>

				</div>

				<div data-role="content" data-theme="c">
					<h1>Thông tin tài khoản không đúng?</h1>
					<p>Bạn chưa đăng nhập , hoặc tài khoản không được phép vào khu vực này</p>  
					<a href="#" data-role="button" data-rel="back" data-theme="b">Quay trở lại</a>    
				</div>
			</div>
		   </body>
		   </html>
		   ';
		  
		}
	else
	{
	
	 	
	?>
	
	<div data-role="page" style="height:100%;">	
	<div data-role="header">
	<h1>Đặt câu hỏi H2472</h1>
	</div>	
	<div data-role="content"  style="min-height:100%;height:100%">	
	<?php        if($_POST['send']!='' && ($_POST['ten_cau_hoi']=='' || $_POST['noi_dung_cau_hoi']==''))		
	{	
	echo '<script> alert("Vui lòng nhập đầy đủ thông tin")</script>';	
	}	
	if($_POST['send']!='' && $_POST['ten_cau_hoi']!='' && $_POST['noi_dung_cau_hoi']!='')
	{	
      $noi_dung = $_POST['noi_dung_cau_hoi'].'<p style="text-align:right">Câu hỏi này được gửi qua thiết bị di động</p>';
	  mysql_connect($DB_HOST, $DB_USER , $DB_PASS) ; 
      mysql_select_db($DB_NAME); 
	 $sql_answer_insert_thread = "INSERT INTO tblthread(answername, class_id, topicid, courseid, groupid, userid, answerdes, attach, time, setting, status, parent, voteup, votedown, count) 
								VALUES('".$_POST['ten_cau_hoi']."', '0', '".$_POST['loai_cau_hoi']."', '".$_POST["courseid"]."', '3', '".$_POST['userid']."', '".$noi_dung."', '', '".time()."', '0', '0', '0', '0', '0', '0')";
     //echo     $sql_answer_insert_thread;
	
	$sql_answer_insert_thread = mysql_query($sql_answer_insert_thread);
			
			$threadid=mysql_insert_id();
			
			
			$sql_answer_insert = "INSERT INTO tblanswer (answername, class_id, topicid, courseid, groupid, userid, answerdes, attach, time, setting, status, parent, voteup, votedown, count,thread) 
								VALUES('".$_POST['ten_cau_hoi']."', '0', '".$_POST['loai_cau_hoi']."', '".$_POST["courseid"]."', '3', '".$_POST['userid']."','".$noi_dung."', '', '".time()."', '0', '0', '0', '0', '0', '0',$threadid)";
			$sql_answer_insert = mysql_query($sql_answer_insert);
	
	        echo '<script>alert(\'Câu hỏi đã được gửi đi\');</script>';
			echo '<script>window.location = "http://m.tvu.topica.vn/h2472-'.$_POST["courseid"].'.html"</script>';
	}
	else	
	{			?>
	<form action="" method="post"> 	
	<label >		Tên câu hỏi :    
    <input type="text" name="ten_cau_hoi" value="<?php echo $_POST['ten_cau_hoi']?>" /> 
	</label>
	<label>		
	Loại câu hỏi :	
	<select  name="loai_cau_hoi" >	
	<option value="16">Hỏi cán bộ QLHT</option>
	<option value="7">Kiến thức môn học</option>
	<option value="3">Thắc mắc kỹ thuật</option>
	</select>		
	</label>		
	<label>Nội dung câu hỏi		
	<textarea name="noi_dung_cau_hoi" style="height:200px"><?php echo $_POST['noi_dung_cau_hoi']?></textarea>	
	</label>		
	<input type="hidden" value="<?php echo $userid ?>" name = "userid">
	<input type="hidden" value="<?php echo $courseid ?>" name = "courseid">
	<input  data-theme="b" type="submit" name="send" value=" Gửi đi ">
	</form>
    <input  data-theme="b" type="button" onclick="parent.history.back();" name="send" value=" Quay lại ">	
	<?php		}		?>

	</div>
	<div data-role="footer" data-position="fixed" ><h5>(C) 2013 Topica </h5></div>
	</div>
	
	</body></html>
	
	<?php
	
	}
	
	?>