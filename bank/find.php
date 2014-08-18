<form id="formC" name="formC" method="post">
    <table><tr><td><label>Chủ tài khoản (VD : Tuấn Anh ) </label></td>
    <td width="10"></td>
      <td ><input type="text" name="ten" id="ten" /></td>
      <td width="10" ></td>
      <td><label>Tài khoản (VD : anhtt )</label></td>
      <td width="10"></td>
      <td><input type="text" name="username" id="username" /></td>
    </tr></table>
	<input type="submit" value="OK"  />
</form>
<?php
require_once( '../config.php' );
$bang_du_lieu  = '';
if (isset($_POST['ten']) && $_POST['ten'] != '') {
$ten = $_POST['ten'];
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");

$qery = "select tk.ten_tk,tk.chu_tk,tk.so_tk,u.lastname,u.firstname,u.topica_lop from tp_tai_khoan as tk,mdl_user as u where u.username = tk.chu_tk and tk.ten_tk LIKE '%$ten%'";


//echo $qery;
$ad = $mysqli->query($qery);
	if (mysqli_num_rows($ad) > 0){
		echo '<table style="" border="1" width="800px"><tr><td width="15%">Username</td><td width="18%">Số tài khoản</td><td >Tên tài khoản</td><td width="20%">Chủ tài khoản</td></tr>';
		while($dd = $ad->fetch_assoc()) 
		{
			echo '<tr><td>'.$dd["chu_tk"].'</td><td>'.$dd["so_tk"].'</td><td>'.$dd["ten_tk"].'</td><td>'.$dd["chu_tk"].'</td></tr>';
		}
		echo  '</table>';
	}
$ad->close();
$mysqli->close();
}

if (isset($_POST['username']) && $_POST['username'] != '') {
$username = $_POST['username'];
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");

$qery = "select tk.ten_tk,tk.chu_tk,tk.so_tk,u.lastname,u.firstname,u.topica_lop from tp_tai_khoan as tk,mdl_user as u where u.username = tk.chu_tk and tk.chu_tk ='".$username."'";


//echo $qery;
$ad = $mysqli->query($qery);
	if (mysqli_num_rows($ad) > 0){
		echo '<table style="" border="1" width="800px"><tr><td width="15%">Username</td><td width="18%">Số tài khoản</td><td >Tên tài khoản</td><td width="20%">Chủ tài khoản</td></tr>';
		while($dd = $ad->fetch_assoc()) 
		{
			echo '<tr><td>'.$dd["chu_tk"].'</td><td>'.$dd["so_tk"].'</td><td>'.$dd["ten_tk"].'</td><td>'.$dd["chu_tk"].'</td></tr>';
		}
		echo  '</table>';
	}
$ad->close();
$mysqli->close();
}
?>