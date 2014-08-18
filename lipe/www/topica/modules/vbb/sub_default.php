<?
/**
*  Default Action
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $dbconn;
	global $core, $clsModule, $clsButtonNav;
	
	$clsVbbUser = new VbbUser();
	$start = $_REQUEST['start'];
	$end = $_REQUEST['end'];
	

	//$arrTopUser = $clsVbbUser->getAll('username <> "admin" order by posts DESC limit 0, 50');
	$sql ="SELECT DISTINCT u.id,u.city,u.username,u.topica_lop,u.topica_nhom,u.lastname,u.firstname,trim(u.firstname) firstname, ra.posts
FROM mdl_user u
INNER JOIN vbb_user ra ON ra.username = u.username
WHERE u.topica_lop <> '' and u.lastname not like '%CVHT%' and u.firstname not like '%CVHT%' and u.topica_lop <> 'chua_xac_dinh' and ra.username <> 'admin' and ra.username <> 'bachnx' order by ra.posts DESC limit $start,$end";
	//print_r($sql);
	
	$arrUser = $dbconn->GetAll($sql);
	
	$assign_list["clsDataGrid"] = $clsDataGrid;
	$assign_list["arrUser"] = $arrUser;
	$assign_list["clsVbbUser"] = $clsVbbUser;
	$assign_list["start"] = $start;
	$assign_list["end"] = $end;
	

}
function default_export(){
	$date=time();   
	header("Pragma: public");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("Content-Type: application/force-download");

    header("Content-Type: application/octet-stream");

    header("Content-Type: application/download");;

    header("Content-Disposition: attachment;filename=hoc-vien-tich-cuc-$date.xls");
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $dbconn;
	global $core, $clsModule, $clsButtonNav;
	
	$clsVbbUser = new VbbUser();
	
	$start = $_REQUEST['start'];
	$end = $_REQUEST['end'];

	//$arrTopUser = $clsVbbUser->getAll('username <> "admin" order by posts DESC limit 0, 50');
	$sql ="SELECT DISTINCT u.id,u.city,u.username,u.topica_lop,u.topica_nhom,u.lastname,u.firstname,trim(u.firstname) firstname, ra.posts
FROM mdl_user u
INNER JOIN vbb_user ra ON ra.username = u.username
WHERE u.topica_lop <> '' and u.lastname not like '%CVHT%' and u.firstname not like '%CVHT%' and u.topica_lop <> 'chua_xac_dinh' and ra.username <> 'admin' and ra.username <> 'bachnx' order by ra.posts DESC limit $start,$end";
	
	$arrUser = $dbconn->GetAll($sql);
	
	$assign_list["clsDataGrid"] = $clsDataGrid;
	$assign_list["arrUser"] = $arrUser;
	$assign_list["clsVbbUser"] = $clsVbbUser;

}

?>