<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<?php
	if ( isset($_REQUEST['cid']) && $_REQUEST['cid'] != ''){
	$c_id = $_REQUEST['cid']; }
?>
<form name="main" action="settingl_i_q.php" method="POST" >
<input type="hidden" name = "c_id" value="<?php echo $c_id; ?> ">
<table>
<tr>
<td><LABEL FOR=style>style</LABEL></td>
<td><input type="text" name = "style"></td>
</tr>
<tr>
<td><LABEL FOR=active_id>active_id</LABEL></td>
<td><input type="text" name = "active_id"></td>
</tr>
<tr>
<td><LABEL FOR=lipe_type>lipe_type</LABEL></td>
<td><select name="lipe_type"><option value="I">I</option><option value="P">P</option><option value="E">E</option></select></td>
</tr>
<tr>
<tr>
<td><LABEL FOR=week_number>week_number</LABEL></td>
<td><input type="text" name = "week_number"></td>
</tr>
<tr>	
<td><LABEL FOR=comment>comment</LABEL></td>
<td><TEXTAREA NAME="comment" ROWS=8 COLS=50></TEXTAREA></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="reset" value = "reset"><input type="submit" value ="submit"></td>
</tr>
</table>
</form>
	
</body>
</html>