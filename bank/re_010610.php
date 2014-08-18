<?php
//	$ten = intval($_GET['so']);
	require_once( 'config.php' );

require_once('../config.php');
require_login();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
	$bang_du_lieu  = '';
	$from = $USER->tu;
	$to  = $USER->den;
	$sl = $USER->sl;
	$nd = $USER->nd;
	$suc = 0;
if (($_POST['ok'] == "Chấp nhận") && ($sl != 0) )
{
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
	$mysqli->query("SET NAMES 'utf8'");
	$mysqli->query("update tp_tai_khoan set so_du_tk = so_du_tk - $sl where so_tk = $from and so_du_tk > $sl and $sl > 0");
	$suc  = $mysqli->affected_rows;
	if ( $suc == 1 )
	{
		$suc = 0;
		$mysqli->query("update tp_tai_khoan set so_du_tk = so_du_tk + $sl where so_tk = $to");
		$suc  = $mysqli->affected_rows;
		if ($suc == 0){
			$mysqli->query("update tp_tai_khoan set so_du_tk = so_du_tk + $sl where so_tk = $from");
			echo 'Tài khoản đến không tồn tại';
		} else {
			$mysqli->query("insert into tp_giao_dich (thoi_gian,tu_tk,den_tk,`so_luong`,noi_dung) value ( now(),$from,$to,'".$sl."','".$nd."')");
			
			echo "Chuyển khoản thành công số lượng $sl từ tài khoản $from đến tài khoản $to";
		}
	} else {
		echo 'Số tiền quá lớn hoặc chuyển quá số lượng có thể';
	}
	$mysqli->close();
} else { echo 'Giao dịch đã hoàn thành hặc thông tin không đúng!!!';}
	$USER->tu = 0;
	$USER->den = 0;
	$USER->sl = 0;
echo '<br> <a href="index.php">Quay lại</a>';
print_footer($site);
?>