<?
/**
*  Default Action
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "mdl_course";
	$classTable = "Mdl_Course";
	$pkeyTable = "id";
	global $_LANG_ID;
	$clsClassTable = new $classTable;
	$clsCourse = new Mdl_Course();

	//get _GET, _POST
	$curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	$rowsPerPage = 40;	
	
	$page = isset($_REQUEST['page'])? intval($_REQUEST['page']) : 0; 
		
	$arrCourse = $clsCourse->GetAll();
	/*mysql_query("SET character_set_results=utf8", $con);
	mb_language('uni');
	mb_internal_encoding('UTF-8');
	mysql_query("set names 'utf8'",$con);*/
	//print_r($arrCourse);die();
	
	//init Button
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");	
	$clsButtonNav->set("New", "/icon/add2.png", "?admin&mod=$mod&act=add",1);
	$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	$clsButtonNav->set("Delete", "/icon/delete2.png", "?admin&mod=$mod&act=delete", 1, "confirmDelete");

	//################### CHANGE BELOW CODE ###################
	$arrGenderOptions = array("Male", "Female");
	$arrYesNoOptions = array("NO", "YES");
	

	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL("?$_SITE_ROOT&mod=$mod");
	$clsDataGrid->setDbTable($tableName,$cond);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("Danh sách lớp"));
	
	//####################### ENG CHANGE ######################
	if ($btnSave!=""){	
		$clsDataGrid->saveData();
		header("location: ?$_SITE_ROOT&mod=$mod");
	}
	
	$assign_list["clsDataGrid"] = $clsDataGrid;
	$assign_list["arrCourse"] = $arrCourse;
	$assign_list["clsCourse"] = $clsCourse;

}
/**
*  Default Action
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_report(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $dbconn;
	global $core, $clsModule, $clsButtonNav;
	require_once DIR_COMMON."/clsPage.php";
	$tableName = "mdl_course";
	$classTable = "Mdl_Course";
	$pkeyTable = "id";
	global $_LANG_ID;
	$clsClassTable = new $classTable;
	$clsCourse = new Mdl_Course();
	$clsUser = new User();
	$clsForumPosts = new ForumPosts();
	$clsQuizGrades = new QuizGrades();
	$clsSettingCalendar = new Setting_Calendar();
	$clsSettingLipe = new Setting_Lipe();		
	$clsCourseDisplay = new CourseDisplay();

	//get _GET, _POST
	$curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	$rowsPerPage = 40;	
	$lop=$_REQUEST['cls'];
	$page = isset($_REQUEST['page'])? intval($_REQUEST['page']) : 0; 
	$c_id = isset($_REQUEST["c_id"])? $_REQUEST["c_id"] : "";
	$arrCourse = $clsCourse->GetAll();
	if($lop=="")
	{
	/*
	$sqlUser = "select * from mdl_user where id in (select distinct userid from mdl_course_display where course = $c_id) and id not in (select userid from mdl_role_assignments where roleid in (1,2,3,4,8) ) order by firstname asc  limit 0,500";
	*/
		$sqlUser="
	SELECT DISTINCT u.id,u.username,u.topica_lop,u.topica_nhom,u.lastname,trim(u.firstname) firstname
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE r.id =5
AND
c.id=$c_id
order by firstname asc  limit 0,500
";
	}
	else
	{
		/*
		$sqlUser = "select * from mdl_user where id in (select distinct userid from mdl_course_display where course = $c_id) and topica_lop='$lop' and id not in (select userid from mdl_role_assignments where roleid in (1,2,3,4,8) ) order by firstname asc  limit 0,500";
		*/
		$sqlUser="
	SELECT DISTINCT u.id,u.username,u.topica_lop,u.topica_nhom,u.lastname,trim(u.firstname) firstname
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
	//echo "lay ra user id".$sqlUser;
	//$arrUser = $clsUser->GetAll($sqlUser);
	$arrUser = $dbconn->GetAll($sqlUser);
	//mysql_query("SET character_set_results=utf8", $dbconn);
	//mb_language('uni');
	//mb_internal_encoding('UTF-8');
	//mysql_query("set names 'utf8'",$dbconn);
	/*mysql_query("SET character_set_results=utf8", $con);
	mb_language('uni');
	mb_internal_encoding('UTF-8');
	mysql_query("set names 'utf8'",$con);*/
	$arrCourseFI = $clsCourse->GetAll("fullname LIKE '%41%' order by fullname asc"); 
	$arrCourseBA = $clsCourse->GetAll("fullname LIKE '%42%' order by fullname asc");
	$arrCourseIT = $clsCourse->GetAll("fullname LIKE '%11%' order by fullname asc");
	$arrCourseOther=$clsCourse->GetAll("fullname not LIKE '%11%' and fullname not LIKE '%42%' and fullname not LIKE '%41%' order by fullname asc");
	//$arrCourse=$clsCourse->GetAll(" 1!=0 order by fullname asc");
	$arrOneCourse = $clsCourse->GetOne($c_id);
	//print_r($arrOneCourse);die();
	$arrSettingCalendar = $clsSettingCalendar->GetAll(" c_id = $c_id ");
	
	$sqlForumPosts = "select count(*)  from mdl_forum_posts where created BETWEEN $st and $en and discussion in (select id from mdl_forum_discussions where forum = $fo)";
	$arrForumPosts = $dbconn->GetAll($sqlForumPosts);
	//echo $sqlForumPosts;
	//print_r($arrForumPosts);die();
	//init Button
	
	
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");	
	$clsButtonNav->set("New", "/icon/add2.png", "?admin&mod=$mod&act=add",1);
	$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	$clsButtonNav->set("Delete", "/icon/delete2.png", "?admin&mod=$mod&act=delete", 1, "confirmDelete");

	//################### CHANGE BELOW CODE ###################
	$arrGenderOptions = array("Male", "Female");
	$arrYesNoOptions = array("NO", "YES");
	

	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL("?$_SITE_ROOT&mod=$mod");
	$clsDataGrid->setDbTable($tableName,$cond);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("Danh sách lớp"));
	
	//####################### ENG CHANGE ######################
	if ($btnSave!=""){	
		$clsDataGrid->saveData();
		header("location: ?$_SITE_ROOT&mod=$mod");
	}
	
	$assign_list["clsDataGrid"] = $clsDataGrid;
	$assign_list["arrCourse"] = $arrCourse;
	$assign_list["arrUser"] = $arrUser;
	$assign_list["c_id"] = $c_id;
	$assign_list["clsSettingCalendar"] = $clsSettingCalendar;
	$assign_list["clsSettingLipe"] = $clsSettingLipe;
	$assign_list["clsCourseDisplay"] = $clsCourseDisplay;
	$assign_list["clsUser"] = $clsUser;
	$assign_list["arrSettingCalendar"] = $arrSettingCalendar;
	$assign_list["arrForumPosts"] = $arrForumPosts;
	$assign_list["arrOneCourse"] = $arrOneCourse;
	$assign_list["arrCourseFI"] = $arrCourseFI;
	$assign_list["arrCourseBA"] = $arrCourseBA;
	$assign_list["arrCourseIT"] = $arrCourseIT;
	$assign_list["arrCourseOther"] = $arrCourseOther;
	$assign_list["arrCourse"] = $arrCourse;
	$assign_list["lop"] = $lop;
    //$smarty->assign('lop',$lop);
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
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "mdl_user";
	$classTable = "User";
	$pkeyTable = "id";
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : "";
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");
	if ($mode=="Edit"){
		$clsButtonNav->set("New", "/icon/add2.png", "?admin&mod=$mod&act=add",1);
		$clsButtonNav->set("Delete", "/icon/delete2.png", "?admin&mod=$mod&act=delete&$pkeyTable=$pvalTable");
	}
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?topica&mod=$mod");
	//################### CHANGE BELOW CODE ###################
	$clsUserGroup = new UserGroup();
	$arrListUserGroup = $clsUserGroup->getAll();
	$arrOptionsUserGroup = array();
	if (is_array($arrListUserGroup))
	foreach ($arrListUserGroup as $key => $val){
		$arrOptionsUserGroup[$val["user_group_id"]] = $val["display_name"];
	}
	//init Form
	$arrPositionOptions = array("L"=>"LEFT", "R"=>"RIGHT", "B"=>"BOTTOM", "T"=>"TOP");
	$arrYesNoOptions = array("NO", "YES");
	$arrGenderOptions = array("Male", "Female");
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle($core->getLang("Sửa thông tin sinh viên"));
	//$clsForm->addInputText("username", "", "User Name", 32, 0, "style='width:200px'");
	//$clsForm->addInputPassword("user_pass", "", "Password", 255, 0,  "style='width:200px'");
	//$user_pass_hint = ($mode=="Edit")? "Leave if no change password" : "";
	//$clsForm->addHint("user_pass", $user_pass_hint);
	$clsForm->addInputText("firstname", "", "H�?", 255, 1, "style='width:200px'");
	$clsForm->addInputText("lastname", "", "Tên", 255, 1, "style='width:200px'");
	$clsForm->addInputText("username", "", "Username", 255, 1, "style='width:200px'");
	$clsForm->addInputText("topica_lop", "", "Lớp", 255, 1, "style='width:200px'");
	$clsForm->addInputText("topica_nganh", "", "Ngành", 255, 1, "style='width:200px'");
	$clsForm->addInputText("topica_nhom", "", "Nhóm", 255, 1, "style='width:200px'");
	$clsForm->addInputText("topica_coquan", "", "Cơ quan", 255, 1, "style='width:200px'");
	$clsForm->addInputText("topica_chucdanh", "", "Chức danh", 255, 1, "style='width:200px'");
	$clsForm->addInputText("topica_chucvutronglop", "", "Chức vụ trong lớp", 255, 1, "style='width:200px'");
	$clsForm->addInputText("topica_chucvutrongnhom", "", "Chức vụ trong nhóm", 255, 1, "style='width:200px'");
	$clsForm->addInputText("topica_trinhdo", "", "Trình độ", 255, 1, "style='width:200px'");
	$clsForm->addInputText("topica_doituongtuyensinh", "", "�?ối tượng tuyển sinh", 255, 1, "style='width:200px'");
	
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		if ($clsForm->validate()){
			if ($clsForm->saveData($mode)){
				header("location: ?$_SITE_ROOT&mod=$mod");
			}
		}
	}
	
	$assign_list["clsModule"] = $clsModule;
	$assign_list["clsForm"] = $clsForm;
	$assign_list[$pkeyTable] = $pvalTable;
}

/**
*  List all Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_list(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
}
/**
*  Edit Item
*  @author		: Nguyen Tuan Minh (ntuanminh2106@gmail.com)
*  @date		: 2007/06/07
*  @version		: 1.0.0
*/
function default_profile(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "user";
	$classTable = "User";
	$pkeyTable = "id";
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : "";
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin");
	//################### CHANGE BELOW CODE ###################
	$clsUserGroup = new UserGroup();
	//$clsUserGroup->setDebug();
	$arrListUserGroup = $clsUserGroup->getAll();
	$arrOptionsUserGroup = array();
	if (is_array($arrListUserGroup))
	foreach ($arrListUserGroup as $key => $val){
		$arrOptionsUserGroup[$val["user_group_id"]] = $val["name"];
	}
	//init Form
	$arrPositionOptions = array("L"=>"LEFT", "R"=>"RIGHT", "B"=>"BOTTOM", "T"=>"TOP");
	$arrYesNoOptions = array("NO", "YES");
	$arrGenderOptions = array("Male", "Female");
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle("Profile");
	$clsForm->addInputText("user_name", "", "<b>User Name</b>", 32, 0, "readonly style='width:200px'");
	$clsForm->addInputPassword("user_pass", "", "Password", 255, 0,  "style='width:200px'");
	$user_pass_hint = ($mode=="Edit")? "Leave if no change password" : "";
	$clsForm->addHint("user_pass", $user_pass_hint);
	$clsForm->addInputText("full_name", "", "Full Name", 255, 0, "style='width:200px'");
	$clsForm->addInputSelect("gender", 0, "Gender", $arrGenderOptions, 0, "style='font-size:10px'");
	$clsForm->addInputHidden("reg_date", time());
	$clsForm->addInputDate("birthday", "", "Birthday", "%m/%d/%Y", 1, 0);
	$clsForm->addInputSelect("disp_birthday", 0, "Allow display Birthday", $arrYesNoOptions, 0, "style='font-size:10px'");
	$clsForm->addInputEmail("email", "", "Email", 255, 0, "style='width:200px'");
	$clsForm->addInputSelect("disp_email", 0, "Allow display Email", $arrYesNoOptions, 0, "style='font-size:10px'");
	$clsForm->addInputUrl("homepage", "", "Home Page", 255, 1, "style='width:200px'");
	$clsForm->addInputTextArea("signature", "", "Signature", 255, 10, 5, 1,  "style='width:400px'");
	$clsForm->addInputText("phone", "", "Phone", 20, 1, "style='width:200px'");
	$clsForm->addInputText("mobile", "", "Mobile", 20, 1, "style='width:200px'");
	$clsForm->addInputText("YM", "", "YM Nick", 20, 1, "style='width:200px'");
	$clsForm->addInputText("Skype", "", "Skype Nick", 20, 1, "style='width:200px'");
	$clsForm->addInputText("address", "", "Address", 255, 1, "style='width:400px'");
	
	//$clsForm->addInputSelect("user_group_id", "", "User Group Name", $arrOptionsUserGroup, 0, "style='font-size:10px'");
	//$clsForm->addInputSelect("is_ban", 0, "Banned?", $arrYesNoOptions, 0, "style='font-size:10px'");
	//$clsForm->addInputSelect("is_active", 1, "Is Active?", $arrYesNoOptions, 0, "style='font-size:10px'");
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		if ($clsForm->validate()){
			if ($clsForm->saveData($mode)){
				header("location: ?$_SITE_ROOT");
			}
		}
	}
	
	$assign_list["clsModule"] = $clsModule;
	$assign_list["clsForm"] = $clsForm;
	$assign_list[$pkeyTable] = $pvalTable;
	
}

/**
*  Show detail an Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$classTable = "User";
	$pkeyTable = "id";
	//################### CAN NOT MODIFY BELOW CODE ###################
	$clsTable = new $classTable();
	$pval = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : "";
	if ($pval!=""){
		$clsTable->deleteOne($pval);
		header("location: ?$_SITE_ROOT&mod=$mod");
	}
	$checkList = isset($_POST["checkList"])? $_POST["checkList"] : "";
	if (is_array($checkList)){
		foreach ($checkList as $key => $val){
			$clsTable->deleteOne($val);
		}
		header("location: ?$_SITE_ROOT&mod=$mod");
	}
	unset($clsTable);
}
?>