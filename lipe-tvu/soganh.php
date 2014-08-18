<?php 
$date=time();   

header("Pragma: public");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("Content-Type: application/force-download");

    header("Content-Type: application/octet-stream");

    header("Content-Type: application/download");;

    header("Content-Disposition: attachment;filename=so-ganh-$date.xls");

//=================================================================================
//Definition constants
//=================================================================================

require_once("global.php");
require_once DIR_ADODB. '/adodb.inc.php';
require_once DIR_SMARTY. '/Smarty.class.php';	
require_once DIR_COMMON . '/clsDbBasic.php';
require_once DIR_CLASSES . '/class_Product.php';

define("DIR_TEMPLATES_C", 	NVCMS_DIR."/www_c/root");
define("DIR_TEMPLATES",		DIR_THEMES."/".SITE_THEME."/root");	
$dbconn = &ADONewConnection(DB_TYPE);

if (isset($dbinfo) && is_array($dbinfo)){
	$dbconn->Connect($dbinfo['host'], $dbinfo['user'], $dbinfo['pass'], $dbinfo['db']);
}else{
	$dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}
$smarty = new Smarty;
$smarty->compile_check = COMPILE_CHECK;
$smarty->template_dir = DIR_TEMPLATES;
$smarty->compile_dir = DIR_TEMPLATES_C;
$smarty->config_dir = DIR_INCLUDES."/conf";
$smarty->config_overwrite = true;

//Get DATA
$clsProduct = new Product();
$arrListProduct = $clsProduct->GetAll("soganh=1  and active=1 order by sell_price DESC");
//print_r($arrListProduct);die();


$smarty->assign('clsProduct',$clsProduct);
$smarty->assign('arrListProduct',$arrListProduct);
$smarty->display('soganh.html');

?>



