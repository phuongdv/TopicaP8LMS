<?php
session_start();
require_once( 'config.php' );
$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
$mysqli->select_db($dbmain);
$ten = $_POST['user'];
$pass = $_POST['pass'];
$ad = $mysqli->query("SELECT * FROM users where user='$ten' and pass = '$pass'");
if (mysqli_num_rows($ad) > 0){
	while($dd = $ad->fetch_assoc()) 
	{
		echo $dd["user"] . "<br/>";
		$_SESSION['type'] = $dd["type"];
		$_SESSION['user'] = $dd["user"];

	}
	$ad->close();
	$mysqli->close();
	header("Location: main.php");
	exit;
} else {
	$ad->close();
	$mysqli->close();
	header("Location: login.php"); 
	exit;
}


?>