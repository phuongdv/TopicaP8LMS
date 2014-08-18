<?

//If run alone
if (!defined("NVCMS_DIR")){
	require_once("../../global.php");
	$_SITE_ROOT = "admin";
	$_BASE_URL = "?".$_SITE_ROOT."&";
}




//Kernel of system
require_once("core.php");

/*
 * =====================================================================
 * INITIATION SECTION  
 * =====================================================================
*/ 
$mod = $stdio->GET("mod" ,"default");

$core = new Core();

//echo md5(md5("admin"));
/*
 * =====================================================================
 * CONTROL SECTION  
 * =====================================================================
*/	
//include header
require_once("_header.php");

//include module $mod
//echo $mod;
echo 'Xin chào ';
echo $_COOKIE['username'];

require_once(DIR_MODULES."/$mod/index.php");

//include footer
require_once("_footer.php");

//Display template
$assign_list["mod"] = $mod;
$assign_list["core"] = $core;
$smarty->assign($assign_list);
if ($smarty->template_exists("$mod.html")){
	$smarty->display("$mod.html");
}else{
	$smarty->display("index.html");
}
?>