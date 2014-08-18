<?php
require_once("../config.php");
$id = required_param('id', PARAM_INT);
$lop = required_param('lop', PARAM_TEXT);
$po = optional_param('po',0, PARAM_TEXT);
$content = $_POST['content'];
require_login();

	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
	$mysqli->query("SET NAMES 'utf8'");
	$query_string = "update tp_thong_bao set lop='$lop',  po='$po', content= '$content', sua = now() where id=$id";
	$mysqli->query($query_string);
	$suc  = $mysqli->affected_rows;
	echo 'ok';
	$mysqli->close();
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	header("Location: http://$host$uri/$extra");
	exit;

?>