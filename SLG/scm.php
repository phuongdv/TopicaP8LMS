<?php
require_once('../config.php');
require_login();
$name =	$user->username;
echo $name;
exit;
   $get_str = 'Location:http://210.245.9.197/scm/ViewProfiles.aspx?id='.$name.'';
   //echo $get_str;
header($get_str);
?>