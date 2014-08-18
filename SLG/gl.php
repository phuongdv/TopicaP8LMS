<?php
require_once('../config.php');
require_login();
$name =	$USER->username;
$str="<username>".$name."</username><date>".gmdate(date("d-m-y",time()))."</date><key>150609102</key>";
   $s=sha1($str);
   $get_str = 'Location:http://login.topica.edu.vn/account.aspx?partnerId=101&param='.$s.'&name='.$name.'&return=topica.vn/elearning';
   //echo $get_str;
header($get_str);
?>