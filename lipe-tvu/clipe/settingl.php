<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<h1>Setting lipe</h1>
<?php
	echo '<br><a href="main.php">DS lớp</a> <br>';

	if ( isset($_REQUEST['cid']) && $_REQUEST['cid'] != ''){
	$c_id = $_REQUEST['cid'];
	echo 'Lớp số '.$c_id;
	require_once( 'config.php' );
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
	$mysqli->select_db($dbmain);
//	$mysqli->query("set names 'utf8'");
	$ad = $mysqli->query("SELECT * FROM huy_setting_lipe where c_id = ".$c_id);
	echo '<table border="1" cellspacing="0" cellpadding="0">';
	echo '<tr><td>ID</td><td>style</td><td>active_id</td><td>lipe_type</td><td>week_number</td><td>comment</td></tr>';
	while($dd = $ad->fetch_assoc()) 
	{
		echo '<tr><td>'.$dd["id"].'</td><td>'.$dd["style"].'</td><td>'.$dd["active_id"].'</td><td>'.$dd["lipe_type"].'</td><td>'.$dd["week_number"].'</td><td>'.$dd["comment"].'</td>
		<td><a href="settingl_e_f.php?id='.$dd["id"].'&cid='.$c_id.'">edit</a> | <a href="settingl_d.php?id='.$dd["id"].'&cid='.$c_id.'">delete</a> </td></tr>';

	}
	echo '</table>';
	echo '<br><a href="settingl_i_f.php?cid='.$c_id.'">New</a>';
	$ad->close();
	$mysqli->close();
	}


?>
	
</body>
</html>