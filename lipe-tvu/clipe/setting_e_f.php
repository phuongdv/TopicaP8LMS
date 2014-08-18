<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<?php
	if ( isset($_REQUEST['cid']) && $_REQUEST['cid'] != ''){
	$c_id = $_REQUEST['cid']; }
	$id = $_REQUEST['id'];
	require_once( 'config.php' );
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
	$mysqli->select_db($dbmain);
	$ad = $mysqli->query("SELECT * FROM huy_setting_calendar where id = ".$id);
	while($dd = $ad->fetch_assoc()) 
	{
		$week_number=$dd["week_number"];
		$week_name=$dd["week_name"];
		$start_date=$dd["start_date"];
		$end_date=$dd["end_date"];
		$comment=$dd["comment"];
	}
	$ad->close();
	$mysqli->close();
?>
<form name="main" action="settingc_e_q.php" method="POST" >
<input type="hidden" name = "c_id" value="<?php echo $c_id; ?> ">
<table>
<tr>
<td><LABEL FOR=week_number>week_number</LABEL></td>
<td><input type="text" name = "week_number" value="<?php echo $week_number; ?>"></td>
</tr>
<tr>
<td><LABEL FOR=Week_name>week_name</LABEL></td>
<td><input type="text" name = "week_name" value="<?php echo $week_name; ?>"></td>
</tr>
<tr>
<td><LABEL FOR=Start_date>start_date</LABEL></td>
<td><input type="text" name = "start_date" value="<?php echo $start_date; ?>"></td>
</tr>
<tr>
<td><LABEL FOR=End_date>end_date</LABEL></td>
<td><input type="text" name = "end_date" value="<?php echo $end_date; ?>"></td>
</tr>
<tr>
<td><LABEL FOR=week_number>comment</LABEL></td>
<td><TEXTAREA NAME="comment" ROWS=8 COLS=50><?php echo $comment; ?></TEXTAREA></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="reset" value = "reset"><input type="submit" value ="submit"></td>
</tr>
</table>
</form>
	
</body>
</html>