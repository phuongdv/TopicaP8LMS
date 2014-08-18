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
<title>Create Bank account</title>
</head>
<body>
<?php
// create by vietth on 13 december 2010
require_once('../config.php');
$con = mysql_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
			mysql_select_db($CFG->dbname, $con);
// get post data 
  $username=$_POST['username'];
  $tentaikhoan=$_POST['tentaikhoan'];
  if($_POST['submit']!='')
  {
		  if($username=='' || $tentaikhoan=='')
		  {
		 echo "<script>alert('Tên đăng nhập và tên tài khoản không được bỏ trống !')</script>";		  	
		  }
		  else 
		  {
             $result = mysql_query("select count(*) count from tp_tai_khoan where chu_tk='".$username."'");
		    while($row = mysql_fetch_array($result))
			    {
				$num= $row['count'];
			    }
		   if($num >=1)
		   		{
		   		echo "<script>alert('Tài khoản đã tồn tại !')</script>";
		   		}    
           else {
           	    $result = mysql_query("insert into tp_tai_khoan (so_du_tk,chu_tk,ten_tk) values('1000000','$username','$tentaikhoan')");
           	    $id= mysql_insert_id();
           	    $result = mysql_query("update tp_tai_khoan set so_tk='1100000$id' where id='$id'");
           	    echo "<script>alert('Tài khoản $username Đã được khởi tạo !')</script>";
                
           }
		  
		  
		  
		   }
		  
		  
  }
  
  $html='<form id="form1" name="form1" method="post" action="">
  <table width="520" border="1">
  <tr>
    <td width="261">Tên đăng nhập (VD: anv1234)</td>
    <td width="243"><input type="text" name="username" id="username" value="'.$username.'" /></td>
  </tr>
  <tr>
    <td>Tên tài khoản (VD : Nguyễn Văn A)</td>
    <td><input type="text" name="tentaikhoan" id="tentaikhoan" value="'.$tentaikhoan.'"   /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <input type="submit" name="submit" id="submit" value="Submit" />
    </label></td>
  </tr>  
</table></form>';
echo $html;

?>

</body>
</html>