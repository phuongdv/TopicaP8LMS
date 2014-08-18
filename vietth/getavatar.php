<?php 


include('../config.php');
header("Content-type: image/png");
$username=$_REQUEST['username'];
$link= mysql_connect($CFG->dbhost, $CFG->dbuser ,$CFG->dbpass );
		 mysql_select_db($CFG->dbname);
		 mysql_query("SET NAMES utf8");
		 $sql="select id from mdl_user 
			where 
			username = '$username'";
			
        $result=mysql_query($sql);
		$row=mysql_fetch_assoc($result);
		
		$im     = file_get_contents("http://elearning.tvu.topica.vn/user/pix.php?file=/".$row['id']."/f1.jpg");
        echo $im;
?>
