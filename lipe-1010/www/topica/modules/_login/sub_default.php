<?
/**
*  Default Action
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav,$log;
	//check logged in
	if ($core->_SESS->isLoggedin()){
		header("location: ?$_SITE_ROOT");
		exit();
	}
	//------------------------------------------------------------------------------
	function redirect()
	{
		header("location:?$_SITE_ROOT");
		//header("location:");
	};
	require 'vietth/securecookie.php';
   $C = new SecureCookie('6rCgffX5mX','Iq6cJ0116W',time()+3600*24,'/','topica.vn');
    $username=$C->Get('username');
	$password=$C->Get('password');
	echo $username;
		//$txtUsername = $username;
		$isValid = ($username!="" && $password!="");
						if ($isValid){
							if ($core->_SESS->checkUser($username, $password)){
								$isValid = 1;
                                $core->_SESS->doLogin($username, $password);
								setcookie ("username", "", time() - 3600);
                                setcookie("username", $username);
                                $log->logThis($username.' Da dang nhap');
                              // echo vnSessionGetVar("LOGGEDIN");
                               						   
								//$actionlog=new ActionLog();
								//$actionlog->insertValue($username,'Login','');
                              redirect();
								//echo $_SITE_ROOT;	
								///exit();
							}else{
								$isValid = 0;
							}
						}
	else 
	{
					$btnLogin = isset($_POST["btnLogin"])? $_POST["btnLogin"] : "";
				    $txtUsername = isset($_POST["txtUsername"])? $_POST["txtUsername"] : "";
					$txtPassword = isset($_POST["txtPassword"])? $_POST["txtPassword"] : "";
					$isValid = 1;
					if ($btnLogin!="")
					{
						$isValid = ($txtUsername!="" && $txtPassword!="");
						if ($isValid){
							if ($core->_SESS->checkUser($txtUsername, $txtPassword)){
								$isValid = 1;
								$core->_SESS->doLogin($txtUsername, $txtPassword);
								header("location: ?$_SITE_ROOT&lang=vn");
								exit();
							}else{
								$isValid = 0;
							}
						}
					}
	}
	//------------------------------------------------------------------------------
	$assign_list["btnLogin"] = $btnLogin;
	$assign_list["txtUsername"] = $txtUsername;
	$assign_list["isValid"] = $isValid;
}
function default_logout(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	if ($core->_SESS->isLoggedin()){
		$core->_SESS->doLogout();		
	}
	header("location: ?$_SITE_ROOT&mod=_login");
}
?>