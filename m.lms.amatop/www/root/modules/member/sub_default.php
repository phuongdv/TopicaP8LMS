<?
/**
*  Defautl action
*  @author		: Technical Group (technical@vnnseo.com)
   @modifier    : Vu Quoc Trung (vuquoctrung@gmail.com)		
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
function default_register(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	#INIT
	#PROCESS
	$clsMember = new Member();
	
	$assign_list["clsTrain"] = $clsTrain;
	$assign_list["CacBuocDatVe"] = $CacBuocDatVe;
	$assign_list["oneTrain"] = $oneTrain;
	$assign_list["oneCat"] = $oneCat;
	$assign_list["clsCategory"] = $clsCategory;
	$assign_list["clsCurrency"] = $clsCurrency;
	
	
		require_once 'includes/common/clsSecurityImage.php';
		$clsSecurity = new generateImages(20,90,6);	
		$SID = session_id();
		
		
		//print_r($arrReview);die();
		$is_Send = 0;
		$btnAccept = isset($_POST["accept"])? $_POST["accept"] : "";
		if($btnAccept == "accept") {
			$user_name = isset($_POST["user_name"])? $_POST["user_name"] : "";
			$user_pwd = isset($_POST["user_pwd"])? $_POST["user_pwd"] : "";
			$fullname = isset($_POST["fullname"])? $_POST["fullname"] : "";
			$email = isset($_POST["email"])? $_POST["email"] : "";
			$address= isset($_POST["address"])? $_POST["address"] : "";
			$phone = isset($_POST["phone"])? $_POST["phone"] : "";
			$mobile= isset($_POST["mobile"])? $_POST["mobile"] : "";
					
			$strSecurity = isset($_POST["strSecurity"])? $_POST["strSecurity"] : "";
			
			$password = md5($user_pwd);
			# TIME ZONE
			$timezone = "Asia/Ho_Chi_Minh";
			if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
			$time_now = date('Y-m-d H:i:s');
			
			#CHECK SQL INJECTION
			//$user_name = $core->anti_injection($user_name);
			//$user_pwd	= $core->anti_injection($user_pwd);
			//$fullname	= $core->anti_injection($fullname);
			
			#CHECK SECURITY
			if($clsSecurity->verifyString($strSecurity)) {		
				$fields = "username,password,fullname,email,diachi,dienthoai,didong,reg_date";
				$values =   "'".$user_name."','".
							$password."','".
							$fullname."','".
							$email."','".
							$address."','".
							$phone."','".
							$mobile."','".
							$time_now."'";
				//$date = time();
							
				
				$success = false;
				//$sql = "INSERT INTO review (fullname,email,comment,news_id,reg_date) VALUES ('$fullname','$email','$comment',$news_id,$date)";
				
				if($clsMember->insertOne($fields, $values))
					$success = true;
				if($success)
					$is_Send = 1;
				else
					header("Location: index.html");
			}
			else {
				echo '<script>alert("Mã số xác nhận không hợp lệ !");</script>';
			}
				
		}
		
	
		$assign_list["clsSecurity"] = $clsSecurity;
		$assign_list["SID"] = $SID;
		$assign_list["user_name"] = $user_name;
		$assign_list["user_pwd"] = $user_pwd;
		$assign_list["fullname"] = $fullname;
		$assign_list["email"] = $email;
		$assign_list["address"] = $address;
		$assign_list["phone"] = $phone;
		$assign_list["mobile"] = $mobile;
		$assign_list["is_Send"] = $is_Send;
		//$assign_list["is_Send"] = $is_Send;
	// End Review
	
	
	
}


function default_login(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	
	//$clsMember = new Member();
	//if(!$clsMember->isLoggedIn()) header("Location: index.html");
	//print_r('here');die();
	//echo $_SESSION['username'];
	//die();
	if ($_SESSION['username']!='') {
		header('Location: index.html');
	}
	
}


function default_logout(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod;
    $userid =  $_SESSION['userid'];
	$table = "hv_noti_".$userid;
	$sql_drop = "drop view $table";
	$dbconn->Execute($sql_drop);
	
	unset($_SESSION["username"]);
	unset($_SESSION["userid"]);
	unset($GLOBALS["username"]);
	unset($GLOBALS["userid"]);
	
	setcookie('m_secretkey','',time()-3600,'','topica.vn','');
	
	
	header("Location: login.html");
}



?>