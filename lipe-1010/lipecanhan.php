<?
//--- Start---//
//=================================================================================
//Definition constants
//=================================================================================
define("NVCMS_DIR", $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['SCRIPT_NAME']));
define("NVCMS_URL", "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));

#Common Directory
define("DIR_INCLUDES", 	NVCMS_DIR."/includes");
define("DIR_LANG", 		NVCMS_DIR."/lang");
define("DIR_LOGS", 		NVCMS_DIR."/logs");
define("DIR_THEMES", 	NVCMS_DIR."/themes");
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
define("URL_THEMES", 	NVCMS_URL."/themes");
define("URL_UPLOADS", 	NVCMS_URL."/uploads");

//=================================================================================
//Include needle file
//=================================================================================
//Database
require_once("config_db.php");
require_once 'global.php';
require_once DIR_ADODB. '/adodb.inc.php';
require_once DIR_SMARTY. '/Smarty.class.php';
require_once DIR_COMMON . '/clsDbBasic.php';
require_once DIR_CLASSES . '/class_User.php';//OK
require_once DIR_CLASSES . '/class_Setting_Calendar.php';//OK
require_once DIR_CLASSES . '/class_Setting_Lipe.php';//OK
require_once DIR_CLASSES . '/class_QuizGrades.php';//OK
require_once DIR_CLASSES . '/class_Mdl_Course.php';//OK
require_once DIR_CLASSES . '/class_Offline.php';//OK
require_once DIR_CLASSES . '/class_Lipecanhan.php';//OK
require_once DIR_CLASSES . '/class_ForumPosts.php';//OK
require_once DIR_CLASSES . '/class_CourseDisplay.php';//OK
define("DIR_TEMPLATES_C", 	NVCMS_DIR."/www_c/topica");
define("DIR_TEMPLATES",		DIR_THEMES."/".SITE_THEME."/topica/lipe");
$clsUser = new User();
$clsSettingCalendar = new Setting_Calendar();

$clsSettingLipe = new Setting_Lipe();	

$clsQuizGrades = new QuizGrades();
$clsCourse = new Mdl_Course();
$clsOffline=new Offline();

$clsLipecanhan= new Lipecanhan();

$clsForumPosts = new ForumPosts();
$clsCourseDisplay = new CourseDisplay();
//


$dbconn = &ADONewConnection(DB_TYPE);
if (isset($dbinfo) && is_array($dbinfo)){
	$dbconn->Connect($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['db']);
	
}else{
	$dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
}

//-- End --//

$userid = isset($_REQUEST["userid"])? $_REQUEST["userid"] : "";


$smarty = new Smarty;
$smarty->compile_check = COMPILE_CHECK;
$smarty->template_dir = DIR_TEMPLATES;
$smarty->compile_dir = DIR_TEMPLATES_C;
$smarty->config_dir = DIR_INCLUDES."/conf";
$smarty->config_overwrite = true;


$smarty->assign('userid',$userid);
$smarty->assign('clsUser',$clsUser);


$smarty->assign('clsLipecanhan',$clsLipecanhan);
$smarty->assign('clsSettingCalendar',$clsSettingCalendar);
$smarty->assign('clsSettingLipe',$clsSettingLipe);
$smarty->assign('clsOffline',$clsOffline);
//$smarty->assign('arrSettingLipe',$arrSettingLipe);

$smarty->display('lipecanhan.html');

?>