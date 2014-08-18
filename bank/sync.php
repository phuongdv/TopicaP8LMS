<?php
$auth = 1;
$name='topica';
$pass='topicabanking';
if($auth == 1) {
if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER']!==$name || $_SERVER['PHP_AUTH_PW']!==$pass)
{
header('WWW-Authenticate: Basic realm="nothing"');
header('HTTP/1.0 401 Unauthorized');
exit("<script>alert('BAN KHONG THE TRUY CAP TRANG NAY')</script>");
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SYNC Bank account</title>
</head>
<body>
<?php
// create by vietth on 13 december 2010
require_once('../config.php');
echo '<form id="form1" name="form1" method="post" action="">
  <label>
  <input type="submit" name="button" id="button" value="  Dong bo " />
  </label>
</form>';
if($_POST['button']!='')
{
$con = mysql_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
			mysql_select_db($CFG->dbname, $con);
// get post data 
              $t=0;
             $result = mysql_query("select * from mdl_user where username not in (select chu_tk from tp_tai_khoan)");
		    while($row = mysql_fetch_array($result))
			    {
				
				
				$username=$row['username'];
				$tentaikhoan=$row['lastname'].' '.$row['firstname'];
				$tentaikhoan_clr=str_replace('\'',' ',$tentaikhoan);
				 $insert = mysql_query("insert into tp_tai_khoan (so_du_tk,chu_tk,ten_tk) values('1000000','$username','$tentaikhoan_clr')");
           	    $id= mysql_insert_id();
           	    $update = mysql_query("update tp_tai_khoan set so_tk='1100000$id' where id='$id'");
				$t=$t+1;
				echo 'Tai khoan cua '.$username.' da duoc tao <br>';
				
          }
		 echo $t.' Tai khoan da duoc tao ';
}		  
  


?>

</body>
</html>
