<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</head>
<body>
<?php
require_once("../config.php");
$sessionid=$_GET['sessionid'];
if($_POST['login'] !='' && $_POST['username'] !='' && $_POST['password'])
{
 global $CFG;	
 $username=$_POST['username'];
 $password=$_POST['password'];
 $sessionid=$_COOKIE['session_id'];
 $conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
		$dbname = $CFG->dbname;
		mysql_select_db($dbname);
		$password=mysql_real_escape_string(md5($password));
		$username=mysql_real_escape_string($username);
		$sql="select u.id id,u.username username,u.firstname firstname,u.lastname lastname, min(r.id) rid from 
		    mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			  
			  where u.username='$username' and u.password='$password'";
		$data = mysql_query($sql);
		$user=array();
		if(mysql_num_rows($data)>0)
			{
			while ($result=mysql_fetch_array( $data ))
			{
				$user=$result;
			}
		  // save to cookie
		  require("securecookie.php");
          $C = new SecureCookie('mysecretword','SID',false,'/','.topica.vn');
		  $C->Set('uid',$user['id']);
		  $C->Set('username',$user['username']);
          $C->Set('name',$user['lastname'].' '.$user['firstname']);
		  $C->Set('role',$user['rid']);
		  $C->Set('sessionid',$sessionid);
		  // back to pre system
		  $preurl=$_COOKIE['tpc_backlink'];
		  if($preurl=='')
		   {
			die('NO where to go');
		   }
		  echo '<script>window.location="'.$preurl.'";</script>';
		  die();
			}
		 else 
		 {
		 	$error='Account not found or wrong password and username';
		 }	

}


?>
<div id="login" style="font-family:Arial, Helvetica, sans-serif;font-size:12px; margin-left:40%;margin-right:40%;margin-top:10%">
  <fieldset style="height:auto"><legend>Login panel</legend>
  <form id="login" method="post" action="">
  <table width="100%" border="0">
  <tr>
    <td>Username</td>
    <td><input name="username" value="<?php echo $username;?>" type="text" /></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type="password" id="password" name="password" type="text"  /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input name="login" type="submit" value="login" /></td>
    
  </tr>
</table>
</form>
<div align="center" style="color:red;font-weight:bold"><?php echo $error; ?></div>
  </fieldset>
  </div>
</body>
</html>
