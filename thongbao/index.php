<?php
require_once("../config.php");
require_login();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
$check = '';
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");
?>
<script language="javascript" type="text/javascript">
<!--
function popitup(url) {
	newwindow=window.open(url,'name','height=300,width=200');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</script>

<?php
//echo '<form id="main" method="GET">Xem t&#7845;t c&#7843; <input type="checkbox" name="all" value="1" '.$check.'><input type="hidden" name="c" value="'.$course.'"><input type="submit" value="ok"></form>';
$query_string = "SELECT * FROM tp_thong_bao";
//echo $query_string;
$ad = $mysqli->query($query_string);
	if (mysqli_num_rows($ad) > 0){
		echo '<table border="1" cellspacing="0" cellpading ="2"><tr><th>L&#7899;p</th><th>Editer</th><th>Th&#7901;i gian</th><th>N&#7897;i dung</th></tr>';
		while($dd = $ad->fetch_assoc()) 
		{
			echo '<tr><td><a href="edit.php?c='.$dd["id"].'">'.$dd["lop"].'</a></td><td>'.$dd["po"].'</td><td>'.$dd["sua"].'<td><a href="edit.php?c='.$dd["id"].'" title="'.strip_tags($dd["content"]).'">'.substr(strip_tags($dd["content"]),0,20).'...</a> -
			  <a href="#" onClick="return popitup(\'view.php?id='.$dd["id"].'\')" >view</a></td></tr>';
		}
		echo '</table>';
	}
$ad->close();
$mysqli->close();
print_footer($site); 
?>