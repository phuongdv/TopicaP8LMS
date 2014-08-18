<?php
include('includes/config.inc.php');
include($dir_inc.'template.php');
include($dir_inc.'function.php');
include($dir_inc.'functions.php');
$template = new Template();
if(isset($_GET['id']))
   $g_username= $_GET['id'];
if(isset($_GET['session']))
   $g_password= md5($_GET['session']);   
   
if($g_username!='' && $g_password!='')
{
$sql = "SELECT * FROM mdl_user
				WHERE username = '" . $g_username . "'
				AND password  = '" . $g_password . "'
				AND confirmed = 1";
	$result = $db->sql_query($sql);
    
	$fontend = "";

	if($db->sql_numrows($result))
	{
		while($db->sql_fetchrow($result))
		{
			$sql_values = "SELECT tblrole.shortname FROM tblrole JOIN tblassign_role ON tblrole.id = tblassign_role.roleid WHERE tblassign_role.userid = '".$db->row[$result]['id']."'";
			$sql_values = $db->sql_query($sql_values) or die(mysql_error());
			while($values_row = $db->sql_fetchrow($sql_values))
			{
				$fontend['code'] = $values_row['shortname'];
				$fontend['id'] = $db->row[$result]['id'];
				$fontend['username'] = $db->row[$result]['username'];
				$fontend['fontend'] = 'topica';

				$_SESSION['fe'] = $fontend;
				
		}
		}
		header('location: ./');
	}
	else
	{
		$template -> assign_vars(array(
			'login_msg'	=> 'Account or password is not match !')
		);
	}
}

?>
