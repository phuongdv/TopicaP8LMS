<?
	
	//If run alone
	if (!defined("NVCMS_DIR")){
		require_once("../../global.php");
		$_SITE_ROOT = "root";
		$_BASE_URL = "?".$_SITE_ROOT."&";
	}
	//Kernel of system
	
	require_once("core.php");
	
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
	//phuongdv lay gia tri mod tren duong dan theo htacess
	$mod = $_REQUEST['mod'];
	
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
	
	/*$time_now = time()+86400;
		$date_show = gmdate('D, d M Y H:i:s', $time_now).' GMT';
		$size=ob_get_length();
		header("Content-Length: $size");
	ob_end_flush();*/
