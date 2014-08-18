<?php
require_once( 'config.php' );

	$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
	$mysqli->select_db($dbmain);
//	print_r($_POST);die;
//	$mysqli->query("delete FROM huy_setting_calendar where id = ".$id);
//insert into `huy_setting_lipe`(`id`,`c_id`,`style`,`active_id`,`lipe_type`,`week_number`,`comment`) values ( NULL,'2','3','12','32','12',NULL);

	$mysqli->query("insert into `huy_setting_lipe`(`id`,`c_id`,`style`,`active_id`,`lipe_type`,`week_number`,`comment`)
	values ( NULL,'".trim($_POST['c_id'])."','".trim($_POST['style'])."','".trim($_POST['active_id'])."','".trim($_POST['lipe_type'])."','".trim($_POST['week_number'])."','".$_POST['comment']."');");
	$cid= $_POST['c_id'];
	if ( $mysqli->affected_rows > 0 ){
	$mysqli->close();
	header("Location: settingl.php?cid=$cid");
	exit;
	} else {
	$mysqli->close();
	echo 'error';
	}
?>