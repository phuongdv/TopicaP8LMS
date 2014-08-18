<?
//If run alone
if (!defined("NVCMS_DIR")){
	require_once("../../global.php");
	$_SITE_ROOT = "root";
	$_BASE_URL = "?".$_SITE_ROOT."&";
}
//Kernel of system
require_once("core.php");

//UserOnline And Visitor
$webcode = isset($_REQUEST["mod"])? strval($_REQUEST["mod"]) : "home";
$ip_address = $_SERVER['REMOTE_ADDR'];
$mday = time() + 120;	
if ($webcode!=""){
	$dbconn->Execute("	UPDATE webadv 
						SET total_click = total_click + 1 
						WHERE webcode='$webcode'");		
	$res = $dbconn->GetRow("SELECT * FROM statswebsite 
							WHERE webcode='$webcode' AND ip_address='$ip_address' AND mday='$mday'");
	if ($res["id"]!=""){
		$dbconn->Execute("	UPDATE statswebsite 
							SET clicks = clicks + 1 
							WHERE webcode='$webcode' AND ip_address='$ip_address' AND mday='$mday'");
	}else{
		$dbconn->Execute("	INSERT statswebsite(webcode, ip_address, mday, clicks)
							VALUES('$webcode', '$ip_address', '$mday', 1)");
	}
}
/*
 * =====================================================================
 * INITIATION SECTION  
 * =====================================================================
*/ 
$mod = $stdio->GET("mod" ,"home");

$core = new Core();
/*
 * =====================================================================
 * CONTROL SECTION  
 * =====================================================================
*/	
//include header
require_once("_header.php");

//include module $mod
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