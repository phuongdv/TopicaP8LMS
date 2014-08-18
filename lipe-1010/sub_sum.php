<?php

date_default_timezone_set('Asia/Krasnoyarsk');
$date=time(); 
 
/* 
header("Pragma: public");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("Content-Type: application/force-download");

    header("Content-Type: application/octet-stream");

    header("Content-Type: application/download");;

    header("Content-Disposition: attachment;filename=li_pe_bang_diem-$date.xls");
*/	
$c_id=$_REQUEST['c_id'];
$mode=$_REQUEST['mode'];
require_once 'global.php';
require_once DIR_ADODB. '/adodb.inc.php';
require_once DIR_SMARTY. '/Smarty.class.php';
require_once DIR_COMMON . '/clsDbBasic.php';
require_once DIR_CLASSES . '/class_User.php';
require_once DIR_CLASSES . '/class_Setting_Calendar.php';
require_once DIR_CLASSES . '/class_Setting_Lipe.php';
require_once DIR_CLASSES . '/class_QuizGrades.php';
require_once DIR_CLASSES . '/class_Mdl_Course.php';
require_once DIR_CLASSES . '/class_Offline.php';
define("DIR_TEMPLATES_C", 	NVCMS_DIR."/www_c/topica");
define("DIR_TEMPLATES",		DIR_THEMES."/".SITE_THEME."/topica/lipe");
$clsUser = new User();
$clsSettingCalendar = new Setting_Calendar();
$clsSettingLipe = new Setting_Lipe();	
$clsQuizGrades = new QuizGrades();
$clsCourse = new Mdl_Course();
$clsOffline=new Offline();
$dbconn = &ADONewConnection(DB_TYPE);
if (isset($dbinfo) && is_array($dbinfo)){
	$dbconn->Connect($dbinfo['localhost'], $dbinfo['root'], $dbinfo['123'], $dbinfo['lipe2409']);
}else{
	$dbconn->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}
$lop=$_REQUEST['cls'];
$sft=$_REQUEST['sft'];
if($sft=='')
	{$sft_sql='';}
	else
	{$sft_sql=" AND u.topica_lop like '%".$sft."%'";}
	//echo $sft_sql;
if($lop=="")
	{
	$sqlUser = "SELECT DISTINCT u.*
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE r.id =5
AND
c.id=$c_id
$sft_sql
order by trim(firstname) asc  limit 0,500";
	
	}
	else
	{
		$sqlUser = "SELECT DISTINCT u.*
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE r.id =5
AND
c.id=$c_id
AND u.topica_lop='$lop'
$sft_sql
order by trim(firstname) asc  limit 0,500";
	}

$arrOneCourse = $clsCourse->GetOne($c_id);
$arrSettingCalendar = $clsSettingCalendar->GetAll(" c_id = $c_id order by id ASC");	
$arrSettingLipe = $clsSettingLipe->GetAll(" c_id = $c_id");

//$arrUser = $clsUser->GetAll($sqlUser);
	$arrUser = $dbconn->GetAll($sqlUser);
$sqlForumPosts = "select count(*)  from mdl_forum_posts where created BETWEEN $st and $en and discussion in (select id from mdl_forum_discussions where forum = $fo)";
	$arrForumPosts = $dbconn->GetAll($sqlForumPosts);
$smarty = new Smarty;
$smarty->compile_check = COMPILE_CHECK;
$smarty->template_dir = DIR_TEMPLATES;
$smarty->compile_dir = DIR_TEMPLATES_C;
$smarty->config_dir = DIR_INCLUDES."/conf";
$smarty->config_overwrite = true;

$assign_list["arrForumPosts"] = $arrForumPosts;
$smarty->assign('clsUser',$clsUser);
$smarty->assign('clsSettingCalendar',$clsSettingCalendar);
$smarty->assign('arrSettingCalendar',$arrSettingCalendar);
$smarty->assign('arrOneCourse',$arrOneCourse);
$smarty->assign('arrUser',$arrUser);
$smarty->assign('arrSettingLipe',$arrSettingLipe);
$smarty->assign('date',$date);
$smarty->assign('mode',$mode);
$smarty->assign('c_id',$c_id);
$smarty->assign('lop',$lop);
$smarty->assign('clsOffline',$clsOffline);
$smarty->display('act_sum_ex.html');

?>