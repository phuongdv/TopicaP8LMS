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
	
					$btnLogin = $_REQUEST['btnLogin'];
				    $username = $_REQUEST["txtUsername"];
					$password = md5($_REQUEST["txtPassword"]);
					$isValid = 1;
					echo $btnLogin;
					if($btnLogin!='')
					 {
                     echo $username;
					 echo $password;
		$isValid = ($username!="" && $password!="");
						if ($isValid){
							if ($core->_SESS->checkUser($username, $password)){
								$isValid = 1;

								$core->_SESS->doLogin($username, $password);
                                setcookie("username", $username);
                                $log->logThis($username.' Da dang nhap');
								
								redirect();
								//echo $_SITE_ROOT;	
							
								///exit();
							}else{
								$isValid = 0;
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