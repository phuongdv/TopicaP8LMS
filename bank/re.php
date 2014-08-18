<?php
//	$ten = intval($_GET['so']);
	require_once( 'config.php' );

require_once('../config.php');

function formatNumber($strPrice) {
		return number_format($strPrice,0,"",".");
	}
function GetTentk($so_tk) {
		$con = mysql_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
		mysql_select_db($CFG->dbname, $con);
		$result = mysql_query("select ten_tk from tp_tai_khoan where so_tk='".$so_tk."'");
		
		while($row = mysql_fetch_array($result)){
			$GetTen= $row['ten_tk'];
		}
		return $GetTen;
		mysql_close($con);
	}
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
			$soluong=formatNumber($sl);
			$from1=GetTentk($from);
			$to1=GetTentk($to);
			
			echo "Chuyển khoản thành công số lượng $soluong từ Số tài khoản $from (Chủ tài khoản :$from1) đến Số tài khoản $to (Chủ tài khoản : $to1)";
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