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
	$ad = $mysqli->query("SELECT * FROM huy_setting_lipe where id = ".$id);
	while($dd = $ad->fetch_assoc()) 
	{
		$style=$dd["style"];
		$active_id=$dd["active_id"];
		$lipe_type=$dd["lipe_type"];
		$week_number=$dd["week_number"];
		$comment=$dd["comment"];
	}
	$ad->close();
	$mysqli->close();
?>
<form name="main" action="settingl_e_q.php" method="POST" >
	<input type="hidden" name = "id" value="<?php echo $id; ?> ">
<input type="hidden" name = "c_id" value="<?php echo $c_id; ?> ">
<table>
<tr>
<td><LABEL FOR=week_number>style</LABEL></td>
<td><input type="text" name = "style" value="<?php echo $style; ?>"></td>
</tr>
<tr>
<td><LABEL FOR=Week_name>active_id</LABEL></td>
<td><input type="text" name = "active_id" value="<?php echo $active_id; ?>"></td>
</tr>
<tr>
<td><LABEL FOR=Start_date>lipe_type</LABEL></td>
<td>
	<select name="lipe_type"><option value="I" <?php if($lipe_type=='I'){echo 'selected';} ?>>I</option><option value="P" <?php if($lipe_type=='p'){echo 'selected';} ?>>P</option><option value="E" <?php if($lipe_type=='E'){echo 'selected';} ?>>E</option>
	</td>
</tr>
<tr>
<td><LABEL FOR=End_date>week_number</LABEL></td>
<td><input type="text" name = "week_number" value="<?php echo $week_number; ?>"></td>
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