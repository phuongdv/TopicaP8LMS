<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<h1>Setting calendar</h1>
<?php
	echo '<br><a href="main.php">DS lớp</a> <br>';

	if ( isset($_REQUEST['cid']) && $_REQUEST['cid'] != ''){
	$c_id = $_REQUEST['cid'];
	echo 'Lớp số '.$c_id;
	require_once( 'config.php' );
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
	$mysqli->select_db($dbmain);
//	$mysqli->query("set names 'utf8'");
	$ad = $mysqli->query("SELECT * FROM huy_setting_calendar where c_id = ".$c_id);
	echo '<table border="1" cellspacing="0" cellpadding="0">';
	echo '<tr><td>ID</td><td>week_number</td><td>week_name</td><td>start_date</td><td>end_date</td><td>comment</td><td>action</td></tr>';
	while($dd = $ad->fetch_assoc()) 
	{
		echo '<tr><td>'.$dd["id"].'</td><td>'.$dd["week_number"].'</td><td>'.$dd["week_name"].'</td><td>'.$dd["start_date"].'</td><td>'.$dd["end_date"].'</td><td>'.$dd["comment"].'</td>
		<td><a href="settingc_e_f.php?id='.$dd["id"].'&cid='.$c_id.'">edit</a> | <a href="settingc_d.php?id='.$dd["id"].'&cid='.$c_id.'">delete</a> </td></tr>';

	}
	echo '</table>';
	echo '<br><a href="settingc_i_f.php?cid='.$c_id.'">New</a>';
	$ad->close();
	$mysqli->close();
	}


?>
	
</body>
</html>