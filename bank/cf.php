<?php
//	$ten = $_GET['so'];
	require_once( 'config.php' );
	$bang_du_lieu  = '';
	$from = $_POST['from'];
	$to = $_POST['to'];
	$sl = $_POST['sl'];
	$nd = $_POST['nd'];
	$suc = 0;
//print_r($_POST);

function formatNumber($strPrice) {
		return number_format($strPrice,0,"",".");
	}

require_once('../config.php');
require_login();
	$USER->tu = $from;
	$USER->den = $to;
	$USER->sl = $sl;
	$USER->nd = $nd;
	$soluong= formatNumber($sl);
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");
$ad = $mysqli->query("SELECT ten_tk FROM tp_tai_khoan where so_tk = '$to' limit 1");
$ad1 = $mysqli->query("SELECT ten_tk FROM tp_tai_khoan where so_tk = '$from' limit 1");
//echo "SELECT chu_tk FROM tp_tai_khoan where so_tk = '$to' limit 1";
		if (mysqli_num_rows($ad) > 0){
		while($dd = $ad->fetch_assoc()) 
			{
				echo '<br><br>Tài khoản chuyển đến : '.$USER->den.' <br> Tên tài khoản : '.$dd["ten_tk"].' <br> Số tiền chuyển : '.$soluong ;
				
			if (mysqli_num_rows($ad1) > 0){
				while($dd1 = $ad1->fetch_assoc()) 
					{
					
						echo ' <br> <br> Tài khoản chuyển đi: '.$USER->tu.' <br>  Tên tài khoản : '.$dd1["ten_tk"].'<br><br><form id="formC" name="formC" method="post" action="re.php">
	<input type="submit" name="ok" value="Chấp nhận" />
</form>';
						
					}
				} else { echo 'Thông tin đầu vào bị sửa đổi'; }
				
			}
		} else { echo 'Tài khoản đến không tồn tại'; }
	
$mysqli->close();
?>

<?php
echo '<br> <br><br><br><a href="index.php">Quay lại tài khoản của bạn</a>';
print_footer($site);
?>