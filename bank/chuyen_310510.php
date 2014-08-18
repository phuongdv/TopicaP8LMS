<?php
	$ten = $_GET['so'];

	
require_once('../config.php');
require_login();
$chu_tk = $USER->username;

print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
	$bang_du_lieu  = '';
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");

$ad = $mysqli->query("SELECT * FROM tp_tai_khoan where so_tk = '".$ten."' and chu_tk = '".$chu_tk."'");

	if (mysqli_num_rows($ad) > 0){
		while($dd = $ad->fetch_assoc()) 
		{
			
			$bang_du_lieu .= '<tr><td>'. $dd["id"] .'</td><td>'.$dd["so_tk"].'</td><td>'.$dd["so_du_tk"].'</td><td><a href ="chuyen.php?so='. $dd["so_tk"] .'">Chuyển</a></td></tr>';
			
			$ten_tai_khoan .= $dd["ten_tk"];
			?>
<h3>Bạn đang muốn chuyển tiền từ tài khoản số <?php echo $ten; ?> / Tên tài khoản : <?php echo $ten_tai_khoan; ?></h3>
<form id="formC" name="formC" method="post" action="cf.php">
    <table><tr><td><label>Chuyển tới: </label></td>
      <td><input type="text" name="to" id="to" /></td>
    </tr>
  	 <tr><td><label>Số lượng: </label></td>
    	<td><input type="text" name="sl" id="sl" /></td>
    </tr>
    </table>
	<input type="hidden" value="<?php echo $ten; ?>"  name = "from" />
	<input type="submit" value="Chuyển"  />
</form>
			<?php
			echo '<br> <a href="index.php">Quay lại tài khoản của bạn</a>';
		}
	} else { echo 'Tài khoản không thuộc sở hữu của bạn'; 
	echo '<br> <a href="index.php">Quay lại tài khoản của bạn</a>';
	}
$bang_du_lieu .= '</table>';
$ad->close();
$mysqli->close();
//	echo $USER->tu;
//	echo $USER->tu;
	 print_footer($site); ?>