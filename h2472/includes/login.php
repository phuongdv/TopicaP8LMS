<?php
$template -> set_filenames(array(
	'login'	=> $dir_template . 'login.tpl')
);

$submit				= "";
$username 			= "";
$password 			= "";

if(isset($_POST['submit']))
	$p_submit 			= $_POST['submit'];
if(isset($_POST['username']))
	$p_username 		= $_POST['username'];
if(isset($_POST['password']))
	$p_password 			= md5($_POST['password']);

if($p_submit == "Đăng nhập") {

	$sql = "SELECT * FROM mdl_user
				WHERE username = '" . $p_username . "'
				AND password  = '" . $p_password . "'
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

				$_SESSION['h2472'] = $fontend;
                             
                        header('location: ./');
			}
		}
	}
	else
	{
		$template -> assign_vars(array(
			'login_msg'	=> 'Account or password is not match!')
		);
	}

}


$template -> pparse('login');
?>
