<?php
require_once('../config.php');
require_login();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Lấy tài khoản");
echo 'Xin chào bạn: '. $USER->lastname .' '.$USER->firstname .'<br>';
//print_r ($USER);
$today = getdate();
//print_r($today);
//echo '#'.$today['hours'];

 //echo 'ok';
//print_r($CFG);
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");
$ad = $mysqli->query("select * from mdl_huy_game_secondlife where day = CURDATE()");
if ($mysqli->affected_rows > 0){
	echo '<table cellspacing="0" cellpading="0" border="1">
	<tr><td>ID</td><td>Ngày</td><td>usernameSecondLife</td><td>mkSecondLife</td><td>UserMoodleDuocCap</td></tr>';
	while($dd = $ad->fetch_assoc()) 
	{
		echo "<tr><td>TOPICA".$dd["id"]."</td><td>".date('d-m-Y',strtotime($dd["day"]))."</td><td>".$dd["users"]."</td><td>".$dd["pass"]."</td><td>".$dd["userm"]."</td></tr>";
	}
	echo '</table>';
}
$ad->close();
$mysqli->close();
print_footer($site);
?>