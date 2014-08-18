<?php 
include('../config.php');
$username=$_REQUEST['username'];
$link= mysql_connect($CFG->dbhost, $CFG->dbuser ,$CFG->dbpass );
		 mysql_select_db($CFG->dbname);
		 mysql_query("SET NAMES utf8");
		 $sql="select CONCAT(lastname,' ',firstname) as fullname, topica_lop  from mdl_user  
			where 
			username = '$username'";
			
        $result=mysql_query($sql);
		$row=mysql_fetch_assoc($result);
		mysql_close($link);
		$fullname     = $row['fullname'];
		$lop     = $row['topica_lop'];
        echo $fullname.' - Lop: '.$lop;
?>
