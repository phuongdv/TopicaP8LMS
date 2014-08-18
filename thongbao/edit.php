<?php
require_once("../config.php");
$course = required_param('c', PARAM_TEXT);
require_login();
    global $CFG, $QTYPES;
    $usehtmleditor = can_use_richtext_editor();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
$check = '';
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");

echo '<form id="main" method="POST" action="up.php">';
$query_string = "SELECT * FROM tp_thong_bao where id = $course";
//echo $query_string;
$ad = $mysqli->query($query_string);
	if (mysqli_num_rows($ad) > 0){
		echo '<table border="1" cellspacing="0" cellpading ="2"><tr><th>L&#7899;p</th><th>Th&#7901;i gian</th><th>N&#7897;i dung</th></tr>';
		while($dd = $ad->fetch_assoc()) 
		{
			echo '<tr><td><input name="lop" value="'.$dd["lop"].'"><input type="hidden" name="po" value="'.$USER->username.'"><input type="hidden" name="id" value="'.$dd["id"].'"></td>
			<td>'.$dd["sua"].'</td>
			<td>';
			 print_textarea($usehtmleditor, 15, 40, 400, 300, 'content',$dd["content"]);
        if ($usehtmleditor) {
        use_html_editor();
        }
		echo '</td></tr>';
		}
		echo '</table><input type="submit" value="submit"></form>';
	}
$ad->close();
$mysqli->close();
print_footer($site); 
?>