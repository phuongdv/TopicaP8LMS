<?php
require_once( 'config.php' );
if ( isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
	$id=$_REQUEST['id'];
	$cid = $_REQUEST['cid'];
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
	$mysqli->select_db($dbmain);
	$mysqli->query("delete FROM huy_setting_lipe where id = ".$id);
	if ( $mysqli->affected_rows > 0 ){
	$mysqli->close();
	header("Location: settingl.php?cid=$cid");
	exit;
	} else {
	$mysqli->close();
	echo 'error';
	}
}
?>