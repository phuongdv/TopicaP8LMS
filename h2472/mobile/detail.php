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
	  mysql_connect($DB_HOST, $DB_USER , $DB_PASS) ; 
      mysql_select_db($DB_NAME); 
	  
	  
	  
	  
	 	
	?>
	
	<div data-role="page" style="height:100%;">	
	<div data-role="header">
	<h1>Chi tiết câu hỏi H2472</h1>
	</div>	
	<div data-role="content"  style="min-height:100%;height:100%">	
	<?php
	$sql ="select * from tblanswer where thread = ".$_GET['id'];
	 $data = mysql_query($sql); 
 
 while($info = mysql_fetch_array( $data )) 
 { 
	echo '<h4>'.$info['answername'].'</h4>';
	echo '<h5>Hỏi:'.$info['answerdes'].'</h5>';
	echo '<h6>Hỏi lúc: '.date('H:i d-m-Y',$info['time']).'</h6>';
	
	$sql_reply = "select * from tblreply inner join mdl_user on mdl_user.id = tblreply.userid where answerid = ".$info['id'];
	$data_reply = mysql_query($sql_reply); 
	 while($info_reply = mysql_fetch_array( $data_reply )) 
		{
	      echo '<h5>Trả lời: '.$info_reply['replydes'].'</h5>';
	      echo '<h6>Trả lời lúc: '.date('H:i d-m-Y',$info_reply['time']).' bởi <strong>'.$info_reply['username'].'</strong></h6>';
	    }
 }

 
 
 
 
	?>
	
	
	<input  data-theme="b" type="button" onclick="parent.history.back();" name="send" value=" Quay lại ">	
	</div>
	<div data-role="footer" data-position="fixed" ><h5>(C) 2013 Topica </h5></div>
	</div>
	
	</body></html>
