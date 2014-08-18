<?
#Configuration
$_CONFIG = array();//get from DB

global $assign_list,$mod;	

$settingCls = new Settings();
$settingList = $settingCls->SelectAll();
if (is_array($settingList))
foreach ($settingList as $key => $val){
	$_CONFIG[$val->skey] = $val->svalue;
}
$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
$query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
$url = !empty($query) ? "http://$host$self?$query" : "http://$host$self?";

if(strstr($url,'&lang')) $url = substr($url,0,-8);


$assign_list["_CONFIG"] = $_CONFIG;
$assign_list["NVCMS_DIR"] = NVCMS_DIR;
$assign_list["NVCMS_URL"] = NVCMS_URL;
$assign_list["DIR_IMAGES"] = DIR_IMAGES;
$assign_list["URL_IMAGES"] = URL_IMAGES;
$assign_list["URL_UPLOADS"] = URL_UPLOADS;
$assign_list["URL_CSS"] = URL_CSS;
$assign_list["URL_JS"] = URL_JS;


$assign_list["_SITE_ROOT"] = $_SITE_ROOT;
$assign_list["url"] = $url;
?>