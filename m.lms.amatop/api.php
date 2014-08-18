<?
//--- Start---//
session_start();
//=================================================================================
//Definition constants
//=================================================================================
define("NVCMS_DIR", $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['SCRIPT_NAME']));
define("NVCMS_URL", "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));

#Common Directory
define("DIR_INCLUDES", 	NVCMS_DIR."/includes");
define("DIR_THEMES", 	NVCMS_DIR."/templates");
define("DIR_TMP", 		NVCMS_DIR."/tmp");
define("DIR_UPLOADS",	NVCMS_DIR."/uploads");
define("DIR_CLASSES", 	DIR_INCLUDES."/classes");
define("DIR_COMMON", 	DIR_INCLUDES."/common");
define("DIR_SMARTY", 	DIR_INCLUDES."/smarty");
define("DIR_ADODB", 	DIR_INCLUDES."/adodb");
define("DIR_PEAR", 		DIR_INCLUDES."/PEAR");
define("DIR_LIB", 		DIR_INCLUDES."/lib");
define("DIR_CONF", 		DIR_INCLUDES."/conf");

#Common Url
define("URL_THEMES", 	NVCMS_URL."/templates");
define("URL_UPLOADS", 	NVCMS_URL."/uploads");

//=================================================================================
//Include needle file
//=================================================================================
//Database
require_once("config_db.php");
require_once DIR_COMMON . '/clsDbBasic.php';
require_once DIR_COMMON . '/clsCore.php';
require_once DIR_ADODB. '/adodb.inc.php';
require_once DIR_SMARTY. '/Smarty.class.php';
require_once DIR_CLASSES."/class_Member.php";



$dbconn = &ADONewConnection(DB_TYPE);
if (isset($dbinfo) && is_array($dbinfo)){
	$dbconn->Connect($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['db']);
	
}else{
	$dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}

#CONFIG
$salt = 'trungvq@topica';

#Function Anti Injection
function anti_injection($campo)
	{
		//remove words that contains syntax sql
		$campo = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$campo);
	
		//Remove empty spaces
		$campo = trim($campo);
	
		 //Removes tags html/php
		$campo = strip_tags($campo);
	
		//Add inverted bars to a string
		$campo = addslashes($campo);
		return $campo; //Returns the the var clean
	}

$clsMember = new Member();
$username = isset($_REQUEST["username"])? strval($_REQUEST["username"]) : "";
$password = isset($_REQUEST["password"])? strval($_REQUEST["password"]) : "";
$checksum = isset($_REQUEST["checksum"])? strval($_REQUEST["checksum"]) : "";

$params = 'username='.$username.'&password='.$password;
$sum = sha1("topica".$params.$salt);

//echo $checksum.'<br/>';
//echo $sum;
//die();

if($checksum==$sum){
	
	$username = anti_injection($username);
	
	//$test = $clsMember->getLastMemberID();
	//echo $test;
	//die();
	//echo $clsMember->checkLogin($username,$password);
	//die();
	if(!$clsMember->checkLogin($username,$password))
		{
			
			unset($clsMember);	
			header("Location: http://appmlearning.topica.edu.vn/index.php?error=1");
		
		}
	else{
		$u = $_SESSION['username'];
		//echo $_SESSION['username'];
	//die();
			if ($_SESSION['username']!='') {
				header('Location: index.html');
			}
		//echo $u;
		//die();
		//header("Location: http://m.tvu.topica.vn/index.html");
	}
	
}
else {
	header("Location: http://appmlearning.topica.edu.vn/index.php?error=1");
}







?>