<?php
require_once('../config.php');
require_login();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Lấy tài khoản");
echo 'Xin chào bạn: '. $USER->lastname .' '.$USER->firstname .'<br>';
//print_r ($USER);
$today = getdate();
//print_r($today);
//echo '#'.$today['hours'];

if ( ( $today['hours'] < 22 ) and ( $today['hours'] > 20 )){
 //echo 'ok';
//print_r($CFG);
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");
$ad = $mysqli->query("select * from mdl_huy_game_secondlife where day = CURDATE() and userm='".$USER->username."'");
if ($mysqli->affected_rows > 0){
	while($dd = $ad->fetch_assoc()) 
	{
		echo "Tài khoản Second Life của bạn là: <b>".$dd["users"]."</b><br>Mật khẩu là: <b>".$dd["pass"]."</b><br>Có giá trị sử dụng trong ngày ".date('d-m-Y',strtotime($dd["day"]));
	}
} else {
	$ad1 = $mysqli->query("select * from mdl_huy_game_secondlife where day = CURDATE() and userm = '' limit 1");
	if ($mysqli->affected_rows > 0){
		$ida = '';
		while($dd = $ad1->fetch_assoc()) 
		{
			echo "Tài khoản Second Life của bạn là: <b>".$dd["users"]."</b><br>Mật khẩu là: <b>".$dd["pass"]."</b><br>Có giá trị sử dụng trong ngày ".date('d-m-Y',strtotime($dd["day"]));
			$ida = $dd["id"];
		}
		$ad1->close();
		$up_query = "update `mdl_huy_game_secondlife` set `userm`='$USER->username' where `id`='$ida'";
		//echo $up_query;
		$mysqli->query($up_query);
		//echo '#'.$mysqli->affected_rows;
	} else { echo 'Đã cấp hết tài khoản hoặc hôm nay không có sự kiện'; }
}
$ad->close();
$mysqli->close();
} else {echo 'Chỉ cấp tài khoản trong khoảng thời gian từ <b>20 giờ đến 22 giờ</b> ';}
print_footer($site);
?>