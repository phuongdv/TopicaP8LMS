<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body topmargin="0px"  leftmargin="0" rightmargin="0">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
    	<td height="50" bgcolor="#999999">
        	
        </td>
   	</tr>
    <tr>
    	<td style=" padding-left:100px">

<?php
require_once( 'config.php' );
$mysqli = new mysqli($dbhost,$dbuser,$dbpass);
$mysqli->select_db($dbmain);
$mysqli->query("set names 'utf8'");
$ad = $mysqli->query("SELECT * FROM mdl_course");
echo '<table border=\"1\" style=\"border:solid 1px #CCC;\" cellspasing="0" cellpadding="0" >';
echo '<tr><td>ID</td><td>Tên lớp</td></tr>';

	while($dd = $ad->fetch_assoc()) 
	{
		echo '<tr><td>'.$dd["id"].'</td><td>'.$dd["fullname"].' </td><td> <a href="settingc.php?cid='.$dd["id"].'">calendar</a> </td><td> <a href="settingl.php?cid='.$dd["id"].'">lipe</a></td><td> <a href="bao_cao.php?cid='.$dd["id"].'">report</a></td></tr>';

	}
echo '</table>';
$ad->close();
?>
		</td>
    </tr>
</table>
</body>
</html>