<?php
require_once( 'config.php' );

	$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
	$mysqli->select_db($dbmain);
//	print_r($_POST);die;
//	$mysqli->query("delete FROM huy_setting_calendar where id = ".$id);
	$mysqli->query("update `huy_setting_lipe` set `style`='".trim($_POST['c_id'])."',`active_id`='".trim($_POST['c_id'])."',`lipe_type`='".trim($_POST['lipe_type'])."',`week_number`='".trim($_POST['week_number'])."',`comment`='".trim($_POST['comment'])."' where `id`='".trim($_POST['id'])."';");
//	$mysqli->query("insert into `huy_setting_calendar`(`id`,`c_id`,`week_number`,`week_name`,`start_date`,`end_date`,`comment`)
//	values ( NULL,'".trim($_POST['c_id'])."','".trim($_POST['week_number'])."','".trim($_POST['week_name'])."','".trim($_POST['start_date'])."','".trim($_POST['end_date'])."','".$_POST['comment']."');");
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