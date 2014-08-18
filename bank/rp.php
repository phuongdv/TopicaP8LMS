<?php
require_once('../config.php');
require_login();
$ten = intval($_GET['so']);
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
echo '<h2 class="main"> <a style="color:#790000">Chào bạn: '. $USER->lastname .' '.$USER->firstname .'</a></h2><br>';
//session_start();
//require_once( 'config.php' );
$bang_du_lieu  = '';
$bang_du_lieu2  = '';
$chu_tk = $USER->username;
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");
$bang_du_lieu .= '<table width="100%"><tr><th width="150" style="border-bottom: 1px solid;border-right: 1px solid;border-top: 1px solid">Tài khoản đến</th><th width="80" style="border-bottom: 1px solid;border-right: 1px solid;border-top: 1px solid">Số lượng</th><th width="259" style="border-bottom: 1px solid;border-top: 1px solid">Thời gian</th><th style="border-bottom: 1px solid;border-top: 1px solid">&nbsp;</th></tr>';
$ad = $mysqli->query("select * from tp_giao_dich where tu_tk = $ten");
	if (mysqli_num_rows($ad) > 0){
		while($dd = $ad->fetch_assoc()) 
		{
			$bang_du_lieu .= '<tr><td align="center"  style="border-bottom: 1px solid;border-right: 1px solid">'.$dd["den_tk"].'</td><td align="right" style="border-bottom: 1px solid;border-right: 1px solid">'.$dd["so_luong"].'</td><td align="right" style="border-bottom: 1px solid">'. $dd["thoi_gian"] .'</td><td style="border-bottom: 1px solid">&nbsp;</td></tr>';
		}
	}
$bang_du_lieu .= '</table>';
$ad->close();

$bang_du_lieu2 .= '<table width="100%"><tr><th width="150" style="border-bottom: 1px solid;border-right: 1px solid;border-top: 1px solid">Từ tài khoản</th><th width="80" style="border-bottom: 1px solid;border-top: 1px solid;border-right: 1px solid">Số lượng</th><th width="259" style="border-bottom: 1px solid;border-top: 1px solid">Thời gian</th><th style="border-bottom: 1px solid;border-top: 1px solid">&nbsp;</th></tr>';
$ad2 = $mysqli->query("select * from tp_giao_dich where den_tk = $ten");
	if (mysqli_num_rows($ad2) > 0){
		while($dd2 = $ad2->fetch_assoc()) 
		{
			$bang_du_lieu2 .= '<tr><td align="center"  style="border-bottom: 1px solid;border-right: 1px solid">'.$dd2["tu_tk"].'</td><td align="right" style="border-bottom: 1px solid;border-right: 1px solid">'.$dd2["so_luong"].'</td><td align="right" style="border-bottom: 1px solid">'. $dd2["thoi_gian"] .'</td><td style="border-bottom: 1px solid">&nbsp;</td></tr>';
		}
	}
$bang_du_lieu2 .= '</table>';
$ad2->close();
$mysqli->close();
?>
<div class="clearfix">
	<div class="box coursebox courseboxcontent boxaligncenter boxwidthwide">
	<h2 style=" padding-bottom: 10px;"><a  style="color:#790000">Các giao dịch của tài khoản <?php echo $ten; ?> </a></h2>
	<div  style="border-top: 1px solid">
<?php
echo '<br>Các giao dịch đi<br>';
echo $bang_du_lieu;
echo '<br>Các giao dịch đến<br>';
echo $bang_du_lieu2;
?></div>
</div></div>
<?php
	echo '<br> <a href="index.php">Quay lại</a>';
print_footer($site);
?>