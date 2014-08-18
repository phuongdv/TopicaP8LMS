<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>	
<?php
require_once("../config.php");
$id = required_param('id', PARAM_INT);
require_login();
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");
$query_string = "SELECT * FROM tp_thong_bao where id = $id";
//echo $query_string;
$ad = $mysqli->query($query_string);
	if (mysqli_num_rows($ad) > 0){
		while($dd = $ad->fetch_assoc()) 
		{
			echo $dd["content"];
		}
	}
$ad->close();
$mysqli->close();
?>
	</body>			
</html>
