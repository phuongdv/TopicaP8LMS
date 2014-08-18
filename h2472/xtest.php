<?phprequire '../vietth/securecookie.php';ob_start();session_start();$C = new SecureCookie('6rCgffX5mX','Iq6cJ0116W',time()+3600,'/','.topica.vn');    $time=time();    $time_static=substr($time,0,-2);    $text=$C->Get('login');echo $text;

?>