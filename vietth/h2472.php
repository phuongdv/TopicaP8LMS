<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>H2472 system</title>
<style type="text/css">
html,body {
  margin: 0;
  padding: 0;
  font-family:Arial, Helvetica, sans-serif;
  font-size:12px;
  
}

#top-bar {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 999;
  width: 100%;
  height: 23px;
}

* html #top-bar {
  position: absolute;
}

#topbar-inner {
  height: 23px;
  background: #810c15;
}

* html #topbar-inner {
  margin-right: 17px;
}

* html body {
  padding-top: 23px;
}

* html,* html body {
  overflow-y: hidden;
  height: 100%;
  margin-top: -23px;
}

#mainouter {
  position: relative;
  z-index: 2;
  padding-top: 23px;
  padding-bottom: 40px;
  margin-left: 150px;
  background: #ccc;
  min-height: 100%;
}

* html #mainouter {
  height: 100%;
  overflow: auto;
  overflow-y: scroll;
  position: relative;
  z-index: 2;
  padding-top: 23px;
  padding-bottom: 40px;
}

#bottom {
  position: fixed;
  bottom: 0;
  left: 0;
  z-index: 999;
  width: 100%;
  height: 40px;
}

* html #bottom {
  position: absolute;
  bottom: -1px;
}

#bottom-inner {
  height: 40px;
  background: #aaa;
}

* html #bottom-inner {
  margin-right: 17px;
}

* html #left {
  position: absolute;
  height: 100%;
  width: 150px;
  left: 0;
  top: 23px;
  overflow: auto;
  z-index: 100;
  margin-bottom: -63px;
}

html>body #left {
  position: fixed;
  left: 0;
  top: 23px;
  bottom: 40px;
  padding: 0;
  width: 149px;
  border-right: 1px solid #000;
}
.toplink
{
padding-left:5px;padding-right:5px;color:#FFF; height:23px
}
</style>
</head>

<body>
<?php
require("securecookie.php");
$sessionid=md5(session_id()).'kgf';


$C = new SecureCookie('mysecretword','SID',false,'/','.topica.vn');
if($C->Get('uid')=='' ||  $C->Get('sessionid')!=$sessionid )
 {
  echo 'not login , begin go to sso';
  sleep(2);
  // save link 
  setcookie('session_id',$sessionid,0,'/','.topica.vn');
  setcookie('tpc_backlink',curPageURL(),0,'/','.topica.vn');
  echo '<script>window.location="sso.php";</script>';
  die();
 }
else
 {
 echo 'loged in with account <b>'.$C->Get('username').'</b>';
 }
 
 

?>



<?php
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>
<div id="top-bar"> 
  <div id="topbar-inner"><span style="float:left;font-weight:bold; height:23px;padding-top:5px"><span class="toplink"> Elearning</span> | <span class="toplink">H2472 </span>| <span class="toplink">ISO</span> | <span class="toplink"> Diễn đàn </span>| <span class="toplink"> Mail </span></span><span style="float:right; color:#fff"><?php echo $C->Get('name'); ?></span></div>
</div>


</body>
</html>
