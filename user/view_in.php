<?php
require_once("../config.php");
require_login();
$filename = $USER->username.'.xml';
//$filename = 'anhtv09a1.xml';
$url = 'http://210.245.87.137/SCMSUploadImages/xmldata/'.$filename;
//$url = $filename;
echo '<iframe src ="'.$url.'" width="100%" height="600">
  <p>Your browser does not support iframes.</p>
</iframe>';
?>