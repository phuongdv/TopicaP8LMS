<?php
require_once('../config.php');
require_login();
$USER->tu = 0;
$USER->den = 0;
$USER->sl = 0;
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
echo '<h2 class="main"> <a style="color:#790000">Chào bạn: '. $USER->lastname .' '.$USER->firstname .'</a></h2><br>';
//session_start();
//require_once( 'config.php' );
$bang_du_lieu  = '';
$chu_tk = $USER->username;
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");
$bang_du_lieu .= '<table width="100%"><tr><th width="150" style="border-bottom: 1px solid;border-right: 1px solid">Số tài khoản</th><th width="300" style="border-bottom: 1px solid;border-right: 1px solid">Chủ tài khoản</th><th width="80" style="border-bottom: 1px solid;">Số dư</th><th width="250" style="border-bottom: 1px solid;border-right: 1px solid"></th><th style="border-bottom: 1px solid">&nbsp;</th></tr>';
$ad = $mysqli->query("SELECT * FROM tp_tai_khoan where chu_tk = '$chu_tk'");
	if (mysqli_num_rows($ad) > 0){
		while($dd = $ad->fetch_assoc()) 
		{
			$bang_du_lieu .= '<tr><td align="center"  style="border-bottom: 1px solid;border-right: 1px solid"><a href ="rp.php?so='. $dd["so_tk"] .'">'. $dd["so_tk"] .'</a></td><td align="left" style="border-bottom: 1px solid;border-right: 1px solid">'.$dd["ten_tk"].'</td><td align="right" style="border-bottom: 1px solid">'.$dd["so_du_tk"].'</td><td style="border-bottom: 1px solid"><b style="font-size: 10px"> </b></td><td style="border-bottom: 1px solid;border-left: 1px solid;"><a href ="chuyen.php?so='. $dd["so_tk"] .'">Chuyển khoản</a></td></tr>';
		}
	}
$bang_du_lieu .= '</table>';
$ad->close();
$mysqli->close();
?>
<div class="clearfix">
	<div class="box coursebox courseboxcontent boxaligncenter boxwidthwide">
	<h2 style=" padding-bottom: 10px;"><a  style="color:#790000">Các tài khoản của bạn</a></h2>
	<div  style="border-top: 1px solid">
<?php echo $bang_du_lieu; ?></div>
</div></div>
<?php
/*print_footer($site);*/
?>



<?php
require_once('../config.php');
require_login();
/*$ten = intval($_GET['so']);*/

//session_start();
//require_once( 'config.php' );
$bang_du_lieu  = '';
$bang_du_lieu2  = '';
$chu_tk = $USER->username;
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");

$sotaikhoan = $mysqli->query("SELECT * FROM tp_tai_khoan where chu_tk = '$chu_tk'");
	if (mysqli_num_rows($sotaikhoan) > 0){
		while($dd = $sotaikhoan->fetch_assoc()) 
		{
			echo "<div class=\'clearfix\'>
	<div class=\'box coursebox courseboxcontent boxaligncenter boxwidthwide\'>
	<h2 style=\' padding-bottom: 10px;\'><a  style=\'color:#790000\'>Các giao dịch của tài khoản '".$dd["ten_tk"]."' </a></h2>
	<div  style=\'border-top: 1px solid\'>";
			echo '<br>Các giao dịch đi<br>';
			echo '<table width="100%"><tr><th width="150" style="border-bottom: 1px solid;border-right: 1px solid;border-top: 1px solid">Tài khoản đến</th><th width="120" style="border-bottom: 1px solid;border-right: 1px solid;border-top: 1px solid">Số lượng</th><th width="320" style="border-bottom: 1px solid;border-right: 1px solid;border-top: 1px solid">Nội dung</th><th width="259" style="border-bottom: 1px solid;border-top: 1px solid">Thời gian</th><th style="border-bottom: 1px solid;border-top: 1px solid">&nbsp;</th></tr>';
			$ad = $mysqli->query("select * from tp_giao_dich where tu_tk = '".$dd["so_tk"]."'");
				if (mysqli_num_rows($ad) > 0){
					while($query1 = $ad->fetch_assoc()) 
					{
						
						echo '<tr><td align="center"  style="border-bottom: 1px solid;border-right: 1px solid">'.$query1["den_tk"].'</td><td align="right" style="border-bottom: 1px solid;border-right: 1px solid">'.$query1["so_luong"].'</td><td align="left" style="border-bottom: 1px solid;border-right: 1px solid">'.$query1["noi_dung"].'</td><td align="right" style="border-bottom: 1px solid">'.$query1["thoi_gian"].'</td><td style="border-bottom: 1px solid">&nbsp;</td></tr>';
					}
				}
			echo '</table>';
			
			
			
			$ad->close();
			
			echo '<br>Các giao dịch đến<br>';
			echo '<table width="100%"><tr><th width="150" style="border-bottom: 1px solid;border-right: 1px solid;border-top: 1px solid">Từ tài khoản</th><th width="120" style="border-bottom: 1px solid;border-top: 1px solid;border-right: 1px solid">Số lượng</th><th width="320" style="border-bottom: 1px solid;border-right: 1px solid;border-top: 1px solid">Nội dung</th><th width="259" style="border-bottom: 1px solid;border-top: 1px solid">Thời gian</th><th style="border-bottom: 1px solid;border-top: 1px solid">&nbsp;</th></tr>';
			$ad2 = $mysqli->query("select * from tp_giao_dich where den_tk = '".$dd["so_tk"]."'");
				if (mysqli_num_rows($ad2) > 0){
					while($query2 = $ad2->fetch_assoc()) 
					{
						echo '<tr><td align="center"  style="border-bottom: 1px solid;border-right: 1px solid">'.$query2["tu_tk"].'</td><td align="right" style="border-bottom: 1px solid;border-right: 1px solid">'.$query2["so_luong"].'</td><td align="left" style="border-bottom: 1px solid;border-right: 1px solid">'.$query2["noi_dung"].'</td><td align="right" style="border-bottom: 1px solid">'. $query2["thoi_gian"] .'</td><td style="border-bottom: 1px solid">&nbsp;</td></tr>';
					}
				}
			echo '</table>';
			
			echo "</div>
</div></div>";
			
			$ad2->close();
			
		}
	}

$sotaikhoan->close();
$mysqli->close();



?>

