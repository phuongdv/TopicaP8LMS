<?
//header("location: /lipe/info");
$arrListSite = array("topica");

$_SITE_ROOT = "root";
if (is_array($arrListSite)){
	foreach ($arrListSite as $site){
		if (isset($_REQUEST[$site])){
			$_SITE_ROOT = $site;
			break;
		}
	}
}

require_once("global.php");

if (in_array($_SITE_ROOT, $arrListSite)){
	if (file_exists(NVCMS_DIR."/www/$_SITE_ROOT/index.php")){
		require_once(NVCMS_DIR."/www/$_SITE_ROOT/index.php");
	}else{
		header("location: ?root");
	}
}else{
	require_once(NVCMS_DIR."/www/$_SITE_ROOT/index.php");
}




?>