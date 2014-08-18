<?
ini_set('display_errors',0);
session_start();
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
/*if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
  ob_start("ob_gzhandler");
}
else {
 ob_start();
}*/
//=================================================================================
//Definition constants if use on localhost
//=================================================================================
define("NVCMS_DIR", $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['SCRIPT_NAME']));
//define("NVCMS_URL", "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
define("NVCMS_URL_SEOERR", "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
define("NVCMS_URL", substr(NVCMS_URL_SEOERR,0,-1));

#Common Directory
define("DIR_INCLUDES", 	NVCMS_DIR."/includes");
define("DIR_LANG", 		NVCMS_DIR."/lang");
define("DIR_LOGS", 		NVCMS_DIR."/logs");
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
define("URL_INCLUDES", 	NVCMS_URL."/includes");
define("URL_PLAYER", 	URL_INCLUDES."/flvplayer");
 
 //link uploads new
define("URL_UPLOADS_ROOT", 	"http://".$_SERVER['HTTP_HOST']);
#LogFile
define("LOG_SYSTEM_FILE", 	DIR_LOGS."/system.log");
define("LOG_MAIL_FILE", 	DIR_LOGS."/mail.log");
define("LOG_FORUM_FILE", 	DIR_LOGS."/forum.log");

#defautl Site Info
define("SITE_THEME", "vietitech");
define("LANG_DEFAULT", "vn");
define("LANG_LOAD", 1);//0:No, 1:File, 2:DB

#Cookie
$COOKIE_NAME = "W2CMS";
$COOKIE_TIME_OUT = 5*24*3600;//5 days
$COOKIE_PREFIX = "CMS_";
$COOKIE_USER = $COOKIE_PREFIX."UID";
$COOKIE_PASS = $COOKIE_PREFIX."PKEY";

#Session
$SESSION_NAME = "W2CMS";
$SESSION_PATH = "/tmp";
$SESSION_COOKIE = 1; //1: user cookie, 0: no cookie
$SESSION_TIME_OUT = 24*60*60;	
//=================================================================================
//Include needle file
//=================================================================================
//Database
require_once("config_db.php");

//Error Handling
//require_once DIR_COMMON."/clsLogging.php";
//require_once DIR_COMMON."/vnErrorHandler.php";
//End Error Handling

//Session Start
require_once DIR_COMMON."/vnSession.php";
#Setup session
if (!vnSessionSetup()) {
	trigger_error('Session setup failed', E_USER_ERROR);
	exit();
}
#Initialize session
//$sess_id = md5($_SITE_ROOT);
if (!vnSessionInit()) {
	trigger_error('Session initiation failed', E_USER_ERROR);
	exit();
}
//End Session Start

//Cookie Start
require_once DIR_COMMON."/clsCookie.php";
#Setup cookie
$clsCookie = new VnCookie($COOKIE_NAME, $COOKIE_TIME_OUT);
$clsCookie->extractAll();
//End Cookie Start

#Stdio
require_once DIR_COMMON."/clsStdio.php";

$stdio = new Stdio();
$_GET = $stdio->parse_incoming(true);
$_POST = $stdio->parse_incoming(false);

$assign_list = array();
?>