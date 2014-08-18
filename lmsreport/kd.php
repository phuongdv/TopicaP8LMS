<?php if($_POST['excel']=='')
   {
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report sau KD</title>
<style>
body{
font-family:arial;
font-size:10pt;
}
table
{
border-collapse:collapse;
}
</style>

</head>

<body>
<?php } ?>
<?php
require_once("../config.php");
require_login();
global $CFG, $QTYPES;
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
	$ad = $mysqli->query('SET NAMES utf8');
$ngaykd = $_POST['ngaykd'];
$lop    = $_POST['tenlop'];
if($ngaykd!='' && $lop !='')
{
$lop = str_replace(',','\',\'',$lop);
$lop = "('".$lop."')";

	function countlogin($uid,$date)
	 {
	  global $mysqli;
			  $sql = "SELECT
				count(*)count
			FROM
				mdl_log
			WHERE
				userid = '$uid'
			AND action = 'login'
			AND time > UNIX_TIMESTAMP('$date 00:00:00')
			AND time <(
				UNIX_TIMESTAMP('$date 00:00:00')+ 3600 * 24 * 8
			)";
			
           $ad = $mysqli->query($sql);
		   $dd = $ad->fetch_assoc();
			return $dd['count'];
	 }
	 
	 function countbttn($uid,$date)
	 {
	  global $mysqli;
			  $sql = "
			  select count(*) count from mdl_quiz_grades where userid  = $uid AND timemodified > UNIX_TIMESTAMP('$date 00:00:00')
AND timemodified <(
	UNIX_TIMESTAMP('$date 00:00:00')+ 3600 * 24 * 8
)
			  ";
			
           $ad = $mysqli->query($sql);
		   $dd = $ad->fetch_assoc();
			return $dd['count'];
	 }


}	



?>
<?php if($_POST['excel']=='')
   {
 ?>
<div align="center">
<form id="form1" name="form1" method="post" action="">
  <p>Ngày khởi động 
    <label>
      <input type="text" name="ngaykd" id="ngaykd" value="<?php echo $_POST['ngaykd'] ?>" />
    </label> 
  (
yyyy-mm-dd)</p>
  <p>Lớp (nhập tên lớp VD: 124222.OTV1A,124222.OTV1B) (nhiều lớp thì cách nhau bằng dấu phẩy)</p>
  <p>
    <label>
      <textarea name="tenlop" id="tenlop" cols="45" rows="5"><?php echo $_POST['tenlop']?></textarea>
    </label>
  </p>
  <p>
    <label>
      <input type="submit" name="xem" id="xem" value="       Xem       " /><input type="submit" name="excel" id="excel" value="      Xuất excel       " />
    </label>
	
  </p>
  <p>&nbsp;</p>
</form>
<?php }
else
{
header("Pragma: public");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("Content-Type: application/force-download");

    header("Content-Type: application/octet-stream");

    header("Content-Type: application/download");;

    header("Content-Disposition: attachment;filename=bao_cao_khoi_dong.xls");
}
 ?>
<table width="800" border="1" cellpadding="5">
  <tr>
    <th width="48" align="center">STT</td>
    <th width="94">Họ </td>
    <th width="155">Tên</td>
    <th width="53">Tài khoản</td>
    <th width="53" align="center">Login</td>
    <th width="57">Làm bài LTTN</td>
  </tr>
  <?php
  if($lop!='')
  {
  $sql ="select id,lastname,firstname,username from mdl_user where topica_lop in $lop";
  $ad = $mysqli->query($sql);
   $t=1;
   $tong_login=0;
   $tong_baitap=0;
	  while($dd = $ad->fetch_assoc())
	  {
      $login = countlogin($dd['id'],$ngaykd);
	  $bt    = countbttn($dd['id'],$ngaykd);
	  echo'
	  <tr>
	    <td align="center">'.$t.'</td>
		<td>'.$dd['lastname'].'</td>	
		<td>'.$dd['firstname'].'</td>
		<td>'.$dd['username'].'</td>
		<td align="center">'.$login.'</td>
		<td align="center">'.$bt.'</td>
	  </tr>';
	  $t++;
	  $tong_login = $tong_login + $login;
	  $tong_baitap = $tong_baitap + $bt;
	  
	  }
  }
  ?>
  
<tr>
	    <td align="center">T&#7893;ng</td>
		<td></td>	
		<td></td>
		<td></td>
		<td align="center"><b><?php echo $tong_login; ?></b></td>
		<td align="center"><b><?php echo $tong_baitap; ?></b></td>
	  </tr>  
  
</table>
<?php if($_POST['excel']=='')
   {
 ?>
</div>
<p>&nbsp;</p>
</body>
</html>
<?php } ?>