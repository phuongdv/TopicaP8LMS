<?
	global $assign_list, $dbconn, $_CONFIG, $mod;
	
	$clsMember = new Member();
	$username = $_SESSION['username'];
	$userid =  $_SESSION['userid'];
	
	$OneMember = $clsMember->getOne($userid);
	$table = 'hv_noti_'.$userid;
	$sql_lttn = "select COUNT(*) as total from $table where name like '%trắc%' and sobai=0";
	$sql_btvn = "select COUNT(*) as total from $table where name like '%nhà%' and sobai=0";
	
	$arr_lttn=$dbconn->GetRow($sql_lttn);
	$arr_btvn =$dbconn->GetRow($sql_btvn);
	$number_lttn = $arr_lttn['total'];
	$number_btvn = $arr_btvn['total'];
	//print_r($number_lttn);die();
	$smarty->assign("userid",$userid);
	$smarty->assign("OneMember",$OneMember);
	$smarty->assign("number_lttn",$number_lttn);
	$smarty->assign("number_btvn",$number_btvn);
?>