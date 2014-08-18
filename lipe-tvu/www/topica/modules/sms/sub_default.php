<?
/**
*  Default Action
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
//Random
function genRandomString($length) {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $string = "";    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}
//====//

function countMobileError($list_user){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $dbconn, $core;
	$clsMdl_User = new Mdl_User();
	
	$arrUser = explode(",", $list_user);
	
	$number_error = 0;
	
	if (count($arrUser) > 0) {
			// loop through the array
			for ($i=0;$i<count($arrUser);$i++) {
				$userid = $arrUser[$i];
				
				$OneUser = $clsMdl_User->getOne($userid);
				$User_Mobile = $OneUser['topica_dienthoai'];
				if($User_Mobile!=''){
					$error = $core->checknumbermobile($User_Mobile);
				
					if($error==0){
						$number_error = $number_error +1;
					}
				}
				else {
					$number_error = $number_error +1;
				}
			}
	}
	//print_r($number_error);
	return $number_error;
	
	
}

function ListUserMobileError($list_user){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $dbconn, $core;
	$clsMdl_User = new Mdl_User();
	
	$arrUser = explode(",", $list_user);
	
	$list_user_mobile_error = '';
	
	if (count($arrUser) > 0) {
			// loop through the array
			for ($i=0;$i<count($arrUser);$i++) {
				$userid = $arrUser[$i];
				
				$OneUser = $clsMdl_User->getOne($userid);
				$User_Mobile = $OneUser['topica_dienthoai'];
				if($User_Mobile!=''){
					$error = $core->checknumbermobile($User_Mobile);
					
					if($error==0){
						$list_user_mobile_error = $list_user_mobile_error.$userid.',';
					}
				}else{
					$list_user_mobile_error = $list_user_mobile_error.$userid.',';
				}
			}
	}
	//print_r($number_error);
	if($list_user_mobile_error!='')
		$list_user_mobile_error =substr($list_user_mobile_error,0,-1);
	
	return $list_user_mobile_error;
	
	
}




function default_default(){


	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $dbconn;
	global $core, $clsModule, $clsButtonNav;
	global $_LANG_ID;
	$tableName = "mdl_user";
	$classTable = "Mdl_Course";
	$pkeyTable = "id";
	
	$clsUser=new User();
	$username= $_COOKIE['username'];
	
	$clsSettingCalendar = new Setting_Calendar();
	$clsSettingLipe = new Setting_Lipe();
	$clsSmsInfo = new SmsInfo();
	$clsSmsSend = new SmsSend();
	$clsMdl_User = new Mdl_User();
	$clsMdl_Course = new Mdl_Course();
	
	$user_login=$_COOKIE['username'];
	$OneUser = $clsMdl_User->getAll("username='".$user_login."' limit 0,1");
	$user_login_id = $OneUser[0]['id'];
	$user_login_mobile = $OneUser[0]['topica_dienthoai'];
	
	//get _GET, _POST
	$curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
	$btnSave = isset($_REQUEST["btnSave"])? $_REQUEST["btnSave"] : "";
	$rowsPerPage = 40;	
	
	$page = isset($_REQUEST['page'])? intval($_REQUEST['page']) : 0; 
	
	
	$c_id = isset($_REQUEST["c_id"])? $_REQUEST["c_id"] : "";
	
	$OneCourseDisplay = $clsMdl_Course->getOne($c_id);
	//print_r($OneCourseDisplay);
	$LopMon = $OneCourseDisplay['shortname'];
	
	//$arrQuiz= $clsSettingLipe->getAll("c_id = $c_id and style='exam' and (lipe_type='E' or lipe_type='I')");
	$clsQuiz = new Quiz();
	$arrQuiz = $clsQuiz->getAll("course=$c_id");
	
	
	//################### CHANGE BELOW CODE ###################
	
	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL("?$_SITE_ROOT&mod=$mod");
	
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("Dịch vụ SMS"));
	
	if(isset($_REQUEST['hi_feed']) && $_REQUEST['hi_feed'] == 'hi_feed'){
		$lop = isset($_REQUEST["lop"])? $_REQUEST["lop"] : "";
		$quiz = isset($_REQUEST["quiz"])? $_REQUEST["quiz"] : "";
		
		header("location: ?$_SITE_ROOT&mod=$mod&act=default&c_id=$c_id&lop=$lop&quiz=$quiz");
	}
	# GET DATE
	$timezone = "Asia/Ho_Chi_Minh";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	$date_now = date('Y-m-d H:i:s');
	
	
	$lop = isset($_REQUEST["lop"])? $_REQUEST["lop"] : "";
	$quiz = isset($_REQUEST["quiz"])? $_REQUEST["quiz"] : "";
	
	if($lop!='' and $quiz!=''){
		if($lop=="0"){
			$sqlUser="
				SELECT DISTINCT u.id,u.username,u.topica_lop,u.topica_dienthoai,u.topica_nhom,u.lastname,u.topica_msv,trim(u.firstname) firstname,u.topica_namsinh ngaysinh
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
			order by firstname asc  limit 0,500
			";
		}
		else{
			$sqlUser="
				SELECT DISTINCT u.id,u.username,u.topica_lop,u.topica_dienthoai,u.topica_nhom,u.lastname,u.topica_msv,trim(u.firstname) firstname,u.topica_namsinh ngaysinh
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
			order by firstname asc  limit 0,500
			";
		}
		$arrUser = $dbconn->GetAll($sqlUser);
	}
	
	if(isset($_REQUEST['hi_check']) && $_REQUEST['hi_check'] == 'hi_check') {
	    
		$chkexpert = $_REQUEST['chkexpert'];
		$content = $_REQUEST['TextField'];
		$CharsTyped = $_REQUEST['CharsTyped'];
		
		
		$content = $core->convertToNormal($content);
		$content = strip_tags($content);
		
		if (count($chkexpert) > 0) {
			// loop through the array
			for ($i=0;$i<count($chkexpert);$i++) {
 
			// do something - this can be a SQL query,
			// echoing data to the browser, or whatever
				//echo "<li>$foo[$i] \n";
				$list=$chkexpert[$i];
				$showlist=$showlist.$list.",";
 
			} // end "for" loop
 		
			$showlist=substr($showlist,0,-1);
			//print_r($showlist);die();
			//$date_now
			//print_r($showlist);die();
			$usercreat = $_COOKIE['username'];
			
			
			
			$count_send = count($chkexpert);
			
			$count_error_mobile = countMobileError($showlist);
			
			$ListUserMobileError = ListUserMobileError($showlist);
			//print_r($count_error_mobile);die();
			
			$sql_log="INSERT INTO sms_info (content,so_ky_tu,usercreat,count_send,count_error_mobile,topica_lop,course_id,quiz_id,list_user_send,list_user_error_mobie,date_creat) VALUES ('".$content."','".$CharsTyped."','".$usercreat."','".$count_send."','".$count_error_mobile."','".$lop."','".$c_id."','".$quiz."','".$showlist."','".$ListUserMobileError."','".$date_now."')";
			
			//print_r($sql_log);die();
			$dbconn->Execute($sql_log);
			$sms_info_id = $clsSmsInfo->getLastID();
			header("location: ?$_SITE_ROOT&mod=$mod&act=check&id=$sms_info_id");
		
		
		
		
		}else{
			/*//echo 'here'; 
			header('Content-Type: text/html; charset=utf-8');
			echo "<script language=\"javascript\">alert(\"Bạn chưa chọn học viên cần gửi SMS. \\n - Xin vui lòng chọn lại !\");</script>";	exit();*/
			$showalert = "Bạn chưa chọn học viên cần gửi SMS!";
		}
		 // endif
		
	}
	
	//print_r($lop);
	//####################### ENG CHANGE ######################
	if ($btnSave!=""){	
		$clsDataGrid->saveData();
		header("location: ?$_SITE_ROOT&mod=$mod");
	}
	
	$assign_list["clsDataGrid"] = $clsDataGrid;
	$assign_list["c_id"] = $c_id;
	$assign_list["clsSettingCalendar"] = $clsSettingCalendar;
	$assign_list["arrQuiz"] = $arrQuiz;
	$assign_list["lop"] = $lop;
	$assign_list["quiz"] = $quiz;
	$assign_list["arrUser"] = $arrUser;
	$assign_list["clsSmsSend"] = $clsSmsSend;
	$assign_list["user_login_id"] = $user_login_id;
	$assign_list["user_login_mobile"] = $user_login_mobile;
	$assign_list["showalert"] = $showalert;
	$assign_list["content"] = $content;
	$assign_list["LopMon"] = $LopMon;
}


function default_check(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $dbconn, $core;
	global $core, $clsModule, $clsButtonNav;
	global $_LANG_ID;
	$tableName = "mdl_user";
	$classTable = "Mdl_Course";
	$pkeyTable = "id";
	
	$clsUser=new User();
	$username= $_COOKIE['username'];
	
	$clsSettingCalendar = new Setting_Calendar();
	$clsSettingLipe = new Setting_Lipe();
	$clsSmsInfo = new SmsInfo();
	$clsMdl_User = new Mdl_User();
	$clsSmsSend = new SmsSend();
	
	//get _GET, _POST
	$curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
	$btnSave = isset($_REQUEST["btnSave"])? $_REQUEST["btnSave"] : "";
	$rowsPerPage = 40;	
	
	$sms_info_id = isset($_REQUEST['id'])? intval($_REQUEST['id']) : 0; 
	
	$OneSmsInfo= $clsSmsInfo->getOne($sms_info_id);
	//print_r($OneSmsInfo);
	//$id = isset($_REQUEST["id"])? $_REQUEST["id"] : "";
	
	//$arrQuiz= $clsSettingLipe->getAll("c_id = $c_id and style='exam' and (lipe_type='E' or lipe_type='I')");
	//$clsQuiz = new Quiz();
	//$arrQuiz = $clsQuiz->getAll("course=$c_id");
	$ListUser = explode(",",$OneSmsInfo['list_user_send']);
	$ErrorUser = explode(",",$OneSmsInfo['list_user_error_mobie']); 
  
	
	$arrListUser = array_values(array_diff($ListUser,$ErrorUser));
	
	
	//################### CHANGE BELOW CODE ###################
	
	
	
	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL("?$_SITE_ROOT&mod=$mod");
	
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("Dịch vụ SMS"));
	
	
	# GET DATE
	$timezone = "Asia/Ho_Chi_Minh";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	$date_now = date('Y-m-d H:i:s');
	
	
	$lop = isset($_REQUEST["lop"])? $_REQUEST["lop"] : "";
	$quiz = isset($_REQUEST["quiz"])? $_REQUEST["quiz"] : "";
	
	$Is_Send=0;
	
	if(isset($_REQUEST['hi_check']) && $_REQUEST['hi_check'] == 'hi_check') {
		
		$random = genRandomString(8);
		//Ghi file
		//$dir =NVCMS_DIR."/sms/".$random."sms.txt";
		//print_r($dir);die();
		$fp=fopen(NVCMS_DIR."/sms/".$random."sms.txt",w)or exit("khong tim thay file can mo");
		
		
		$contentfile = $OneSmsInfo['content']."\n";
		
		
		if (count($arrListUser) > 0) {
			// loop through the array
			for ($i=0;$i<count($arrListUser);$i++) {
 				
			// do something - this can be a SQL query,
			// echoing data to the browser, or whatever
				//echo "<li>$foo[$i] \n";
				$soDT = $clsMdl_User->getNumberMobile($arrListUser[$i]);
				//echo 'here';die();
				//print_r($soDT);die();
				
				$checkDT = $core->checknumbermobile($soDT);
				//if()
				if($soDT!=''){
					if($checkDT==0) {
						$contentfile= $contentfile;
					}
					else {
						$contentfile= $contentfile.$soDT."\n";
					}
				}else{
					$contentfile= $contentfile;
				}
				//$list=$chkexpert[$i];
				//$showlist=$showlist.$list.",";
				//$dbconn->Execute($sql_log);
				if($soDT!=''){
				$sqlsmssend = "
							INSERT INTO sms_send (sms_info_id,user_id,topica_dienthoai, sms_status, reg_date)
							VALUES ($sms_info_id, '$arrListUser[$i]', '$soDT', 'send','$date_now') 
						";
				//print_r($sqlsmssend);die();
				$dbconn->Execute($sqlsmssend);
				
				$sms_send_id = $clsSmsSend->getLastID();
				$code = 'TVU'.$sms_send_id;
				
				insertCORE($soDT,$OneSmsInfo['content'],$code);
				}
				
 				
			} // end "for" loop
			
			//$sms_info_id
			$sql_update_status = "UPDATE sms_info SET send_status=1 WHERE sms_info_id='".$sms_info_id."'";
 			$dbconn->Execute($sql_update_status);
		} // endif
		
		/*$sqlsmssend = "
							INSERT INTO sms_send (sms_info_id, user_id,topica_dienthoai, reg_date)
							VALUES ($sms_info_id, $useridin, '$topica_dienthoaiin', $date) 
						";
						$smssend = $mysqli->query($sqlsmssend);*/
		
		/*if (mysqli_num_rows($ad) > 0){
		while($dd = $ad->fetch_assoc()) 
			{
				if($dd['topica_dienthoai']!='')
				$soDT = formatMobile($dd['topica_dienthoai']);
				$contentfile= $contentfile.$soDT."\r\n";
				
			}
		}*/
		//print_r($contentfile);die();
		
		fwrite($fp,$contentfile);
		
		fclose($fp);
		
		//end file
		
		
		
		$Is_Send=1;
		
	}
	
	//print_r($lop);
	//####################### ENG CHANGE ######################
	if ($btnSave!=""){	
		$clsDataGrid->saveData();
		header("location: ?$_SITE_ROOT&mod=$mod");
	}
	
	$assign_list["clsDataGrid"] = $clsDataGrid;
	$assign_list["c_id"] = $c_id;
	$assign_list["clsSettingCalendar"] = $clsSettingCalendar;
	$assign_list["arrQuiz"] = $arrQuiz;
	$assign_list["lop"] = $lop;
	$assign_list["quiz"] = $quiz;
	$assign_list["arrUser"] = $arrUser;
	$assign_list["OneSmsInfo"] = $OneSmsInfo;
	$assign_list["arrListUser"] = $arrListUser;
	$assign_list["clsMdl_User"] = $clsMdl_User;
	$assign_list["Is_Send"] = $Is_Send;
    $assign_list["count_send"] = count($arrListUser);
	if($OneSmsInfo['so_ky_tu']==0)
	{
	$assign_list["enable_send"] = "disabled=\"disabled\"";
	$assign_list["error"]       = "Vui lòng nhập nội dung tin nhắn<br>";
	}
		if(count($arrListUser)==0)
	{
	$assign_list["enable_send"] = "disabled=\"disabled\"";
	$assign_list["error"]       .= "Không tìm thấy số điện thoại nào";
	}
	
}



/**
*  Add a new Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
   @modifier    : Nguyen Tuan Minh			
*  @date		: 2007/04/01
   @date-modify : 2007/06/07	
*  @version		: 1.0.0
*/
function default_add(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod,$log,$C;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "huy_setting_lipe";
	$classTable = "Setting_Lipe";
	$pkeyTable = "id";
	$clsUser=new User();
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : "";
	$btnSave = isset($_REQUEST["btnSave"])? $_REQUEST["btnSave"] : "";
	$c_id = isset($_REQUEST["c_id"])? $_REQUEST["c_id"] : "";
	// check permission
	$username= $_COOKIE['username'];
	if ($clsUser->CheckRole($username,$c_id)=='0')
	 {
	 $redirect_url='?'.$_SITE_ROOT.'&mod=settinglipe&c_id='.$c_id;
	 echo "<script>window.location='".$redirect_url."'</script>";
     die();
	 }
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");
	if ($mode=="Edit"){
		$clsButtonNav->set("New", "/icon/add2.png", "?topica&mod=$mod&act=add",1);
		$clsButtonNav->set("Delete", "/icon/delete2.png", "?topica&mod=$mod&act=delete&$pkeyTable=$pvalTable");
	}
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?topica&mod=$mod&c_id=$c_id");
	//################### CHANGE BELOW CODE ###################
	$arrLipeTipe = array ("I"=>"Số bài viết","P"=>"Bài luyện","E"=>"Bài Kiểm tra","V"=>"Diễn đàn VBB");
	
	$clsForumDiscussions = new ForumDiscussions();
	$clsQuizGrades = new QuizGrades();
	$clsQuiz = new Quiz();
	
	//$arrQuizGrades = $clsQuizGrades->getAll();
	$arrForumDiscussions = $clsForumDiscussions->getAll("course='$c_id'");
	//$arrQuiz = $clsQuiz->getAll("course=$c_id and name not like '%luyen tap%'");
	$arrQuiz = $clsQuiz->getAll("course=$c_id");
	//print_r($arrQuiz);die();
	
	//print_r($arrForumDiscussions);die();
	$arrOptionForumDiscussions = array();
	if (is_array($arrForumDiscussions))
	foreach ($arrForumDiscussions as $key => $val){
		$arrOptionForumDiscussions[$val["id"]] = $val["name"];
	}
	
	$clsSetting_Calendar = new Setting_Calendar();
	$arrWeeknumber = $clsSetting_Calendar->getAll("c_id='$c_id'");
	//print_r($arrForumDiscussions);die();
	$arrOptionWeeknumber = array();
	if (is_array($arrWeeknumber))
	foreach ($arrWeeknumber as $key => $val){
		$arrOptionWeeknumber[$val["id"]] = $val["week_name"];
	}
	
	
	$arrStyle = array("forum"=>"Forum","exam"=>"Exam","assignment"=>"Assignment"); 
	//print_r($arrOptionForumDiscussions);die();
	//init Form
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle($core->getLang("Edit Setting Lipe"));
	
	$clsForm->addInputSelect("style", "", "Style",$arrStyle, 0, "style='width:200px'");
	$clsForm->addInputText("active_id", "", "active_id",255, 1, "style='width:200px'");
	$clsForm->addInputSelect("lipe_type", "", "lipe_type",$arrLipeTipe,0, "style='font-size:12px'");
	$clsForm->addInputSelect("calendar_id", "", "Tuần", $arrOptionWeeknumber, 0, "style='width:200px'");
	$clsForm->addInputTextArea("comment", "", "Ghi chú", 255, 10, 5, 1,  "style='width:50%'");
	if ($mode=="New"){
	$clsForm->addInputHidden("c_id","$c_id");
	}
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		if ($clsForm->validate()){
			if ($clsForm->saveData($mode)){
                	$username=$_COOKIE['username'];
					$actionlog=new ActionLog();
					$actionlog->insertValue($username,'Setting lipe / Add new lipe','Course id: '.$c_id);
					header("location: ?$_SITE_ROOT&mod=$mod&c_id=$c_id");
			}
		}
	}
	
	$assign_list["clsModule"] = $clsModule;
	$assign_list["clsForm"] = $clsForm;
	$assign_list[$pkeyTable] = $pvalTable;
	$assign_list["c_id"] = $c_id;
	$assign_list["arrForumDiscussions"] = $arrForumDiscussions;
	$assign_list["arrQuiz"] = $arrQuiz;
	

}

/**
*  Show detail an Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod,$log;
	global $core, $clsModule, $clsButtonNav;
	$classTable = "Setting_Lipe";
	$pkeyTable = "id";
	//################### CAN NOT MODIFY BELOW CODE ###################
	$clsTable = new $classTable();
	$pval = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : "";
	$c_id = isset($_REQUEST["c_id"])? $_REQUEST["c_id"] : "";
	if ($pval!=""){
		$clsTable->deleteOne($pval);
        $log->logThis('DELETE Settting Lipe  '.$c_id);
		header("location: ?$_SITE_ROOT&mod=$mod&c_id=$c_id");
	}
	$checkList = isset($_REQUEST["checkList"])? $_REQUEST["checkList"] : "";
	if (is_array($checkList)){
		foreach ($checkList as $key => $val){
			$clsTable->deleteOne($val);
		}
		        $username=$_COOKIE['username'];
				$actionlog=new ActionLog();
				$actionlog->insertValue($username,'Setting Lipe / Delete a lipe ','Course id: '.$c_id);
		header("location: ?$_SITE_ROOT&mod=$mod&c_id=$c_id");
	}
	unset($clsTable);
}

function insertCORE($sdt, $info,$code){
	
	$con = mysql_connect("115.146.127.229","adsvnnseo_sms","Ifu7Dajc");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	mysql_select_db("adsvnnseo_sms", $con);
	
	 $sql = "INSERT INTO ozekimessageout (receiver,msg,status,code) ".
         "VALUES ('$sdt','$info','send','$code')";
	
	mysql_query("INSERT INTO ozekimessageout (receiver,msg,status,code)
	VALUES ('".$sdt."', '".$info."', 'send', '".$code."')");
// some code

	mysql_close($con);
	
	return 1;

}

?>