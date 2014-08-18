<?
//=================================================================================
//Definition constants
//=================================================================================
#Debugging
define("SMARTY_DEBUG", 	false);//debug or not
define("COMPILE_CHECK", true);//compile check
define("ADODB_DEBUG", 	false);//debug or not
define("HANDLE_ERROR", 	0);//0: no, 1: yes
define("STOP_APP_IF_ERROR", 1);//stop if error happen 0: no, 1: yes

#Private Directory
define("DIR_ROOT", 			NVCMS_DIR."/www/$_SITE_ROOT");
define("DIR_TEMPLATES_C", 	NVCMS_DIR."/www_c/$_SITE_ROOT");
define("DIR_BLOCKS", 		DIR_ROOT."/blocks");	
define("DIR_MODULES", 		DIR_ROOT."/modules");	
define("DIR_TEMPLATES",		DIR_THEMES."/".SITE_THEME."/$_SITE_ROOT");	
define("DIR_IMAGES",		DIR_THEMES."/".SITE_THEME."/images");
define("DIR_CSS",			DIR_THEMES."/".SITE_THEME."/css");
define("DIR_JS",			DIR_THEMES."/".SITE_THEME."/js");

#Private Url
define("URL_IMAGES",		URL_THEMES."/".SITE_THEME."/images");
define("URL_CSS",			URL_THEMES."/".SITE_THEME."/css");
define("URL_JS",			URL_THEMES."/".SITE_THEME."/js");

//=================================================================================
//Include needle file
//=================================================================================
//Core Requirement
require_once DIR_COMMON."/clsDbBasic.php";
require_once DIR_COMMON."/clsCore.php";
require_once DIR_COMMON."/clsPop3.php";
require_once DIR_COMMON."/clsSendMail.php";
require_once DIR_COMMON."/clsReceiveMail.php";
require_once DIR_COMMON."/clsRegistry.php";
require_once DIR_COMMON."/clsRegedit.php";
require_once DIR_COMMON."/clsMineDecode.php";
require_once DIR_COMMON."/clsBBCode.php";
require_once DIR_COMMON."/clsModule.php";
require_once DIR_COMMON."/clsIniManager.php";
require_once DIR_COMMON."/clsSecurityImage.php";
//End Core Requirement

//CustomClassRequirement
$customClsArray = array();
if (is_dir(DIR_CLASSES)){
	if ($dh = opendir(DIR_CLASSES)) {
		while (($file = readdir($dh)) !== false) {
			if (substr($file, -3)=='php')
			array_push($customClsArray, $file);
		}
		closedir($dh);
	}	
}
foreach ($customClsArray as $customCls){
	require_once(DIR_CLASSES."/".$customCls);
}
//End CustomClassRequirement

//Library Requirement
$customLibArray = array();
if (is_dir(DIR_LIB)){
	if ($dh = opendir(DIR_LIB)) {
		while (($file = readdir($dh)) !== false) {
			if (substr($file, -3)=='php')
			array_push($customLibArray, $file);
		}
		closedir($dh);
	}	
}
foreach ($customLibArray as $customLib){
	require_once(DIR_LIB."/".$customLib);
}	
//End Library Requirement

//DriverDatabase.TemplateRequirement
require_once(DIR_ADODB."/adodb.inc.php");
require_once(DIR_SMARTY."/Smarty.class.php");	
//End DriverDatabase.TemplateRequirement

//Initiation Driver
#Adodb
$dbconn = &ADONewConnection(DB_TYPE);
$dbconn->debug = ADODB_DEBUG;
if (isset($dbinfo) && is_array($dbinfo)){
	$dbconn->Connect($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['db']);
	
}else{
	$dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	//---
	
}

#Smarty
$smarty = new Smarty;
$smarty->compile_check = COMPILE_CHECK;
$smarty->debugging = SMARTY_DEBUG;
$smarty->template_dir = DIR_TEMPLATES;
$smarty->compile_dir = DIR_TEMPLATES_C;
$smarty->config_dir = DIR_INCLUDES."/conf";
$smarty->config_overwrite = true;
//End Initiation Driver

//Load Language
$_LANG_ID = isset($_REQUEST["lang"])? $_REQUEST["lang"] : "";
if ($_LANG_ID!=""){
	vnSessionSetVar("NVC_".$_SITE_ROOT."_LANG", $_LANG_ID);
}elseif (vnSessionExist("NVC_".$_SITE_ROOT."_LANG")){
	$_LANG_ID = vnSessionGetVar("NVC_".$_SITE_ROOT."_LANG");
}else{
	$_LANG_ID = LANG_DEFAULT;
}

if (LANG_LOAD==1 && file_exists(DIR_LANG."/".$_LANG_ID."/lang_".$_SITE_ROOT.".php")){
	require_once(DIR_LANG."/".$_LANG_ID."/lang_".$_SITE_ROOT.".php");
}
$smarty->assign("_LANG_ID", $_LANG_ID);
//End Load Language
?>