<?
#Configuration
$_CONFIG = array();//get from DB
/*
$settingCls = new Settings();
$settingList = $settingCls->SelectAll();
if (is_array($settingList))
foreach ($settingList as $key => $val){
	$_CONFIG[$val->skey] = $val->svalue;
}
*/
$assign_list["_CONFIG"] = $_CONFIG;
$assign_list["NVCMS_DIR"] = NVCMS_DIR;
$assign_list["NVCMS_URL"] = NVCMS_URL;
$assign_list["DIR_IMAGES"] = DIR_IMAGES;
$assign_list["URL_IMAGES"] = URL_IMAGES;
$assign_list["URL_UPLOADS"] = URL_UPLOADS;
$assign_list["URL_CSS"] = URL_CSS;
$assign_list["URL_JS"] = URL_JS;
$assign_list["_SITE_ROOT"] = $_SITE_ROOT;

#Button Navigation
$clsButtonNav = new  ButtonNav();



?>