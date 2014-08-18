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
	$tableName = "user";
	$classTable = "User";
	$pkeyTable = "id";

	//get _GET, _POST
	$curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	$rowsPerPage = 20;	

	//init Button
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");	
	$clsButtonNav->set("New", "/icon/add2.png", "?admin&mod=$mod&act=add",1);
	$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	$clsButtonNav->set("Delete", "/icon/delete2.png", "?admin&mod=$mod&act=delete", 1, "confirmDelete");

	//################### CHANGE BELOW CODE ###################
	$arrGenderOptions = array("Male", "Female");
	$arrYesNoOptions = array("NO", "YES");
	
	$clsUserGroup = new UserGroup();
	$arrListUserGroup = $clsUserGroup->getAll();
	$arrOptionsUserGroup = array();
	if (is_array($arrListUserGroup))
	foreach ($arrListUserGroup as $key => $val){
		$arrOptionsUserGroup[$val["user_group_id"]] = $val["display_name"];
	}
	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL("?$_SITE_ROOT&mod=$mod");
	$clsDataGrid->setDbTable($tableName);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("User"));
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="girdtable"');
	$clsDataGrid->addColumnLabel("user_name", "User Name", "width='10%'");
	$clsDataGrid->addColumnLabel("full_name", "Full Name", "width='15%'");
	$clsDataGrid->addColumnSelect("gender", "Gender", "width='5%' align='center'", $arrGenderOptions);
	$clsDataGrid->addColumnDate("birthday", "Brithday", "width='10%' align='center'");
	$clsDataGrid->addColumnEmail("email", "Email", "width='10%'");
	$clsDataGrid->addColumnSelect("user_group_id", "User Group", "width='5%' align='center'", $arrOptionsUserGroup);

	$clsDataGrid->addColumnDate("reg_date", "Reg Date", "width='10%' align='center'");
	$clsDataGrid->addColumnSelect("is_ban", "Banned?", "width='5%' align='center'", $arrYesNoOptions);
	$clsDataGrid->addColumnSelect("is_active", "Is Active?", "width='5%' align='center'", $arrYesNoOptions);
	//####################### ENG CHANGE ######################
	if ($btnSave!=""){	
		$clsDataGrid->saveData();
		header("location: ?$_SITE_ROOT&mod=$mod");
	}
	
	$assign_list["clsDataGrid"] = $clsDataGrid;
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
	if ($mode=="Edit"){
		$clsButtonNav->set("New", "/icon/add2.png", "?admin&mod=$mod&act=add",1);
		$clsButtonNav->set("Delete", "/icon/delete2.png", "?admin&mod=$mod&act=delete&$pkeyTable=$pvalTable");
	}
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin&mod=$mod");
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
	$clsForm->setTitle($core->getLang("User"));
	$clsForm->addInputText("user_name", "", "User Name", 32, 0, "style='width:200px'");
	$clsForm->addInputPassword("user_pass", "", "Password", 255, 0,  "style='width:200px'");
	$user_pass_hint = ($mode=="Edit")? "Leave if no change password" : "";
	$clsForm->addHint("user_pass", $user_pass_hint);
	$clsForm->addInputText("full_name", "", "Full Name", 255, 0, "style='width:200px'");
	$clsForm->addInputSelect("gender", 0, "Gender", $arrGenderOptions, 0, "style='font-size:10px'");
	$clsForm->addInputHidden("reg_date", time());
	$clsForm->addInputDate("birthday", "", "Birthday", "%m/%d/%Y", 1, 0);
	$clsForm->addInputEmail("email", "", "Email", 255, 0, "style='width:200px'");
	$clsForm->addInputSelect("user_group_id", "", "User Group Name", $arrOptionsUserGroup, 0, "style='font-size:10px'");
	$clsForm->addInputSelect("is_ban", 0, "Banned?", $arrYesNoOptions, 0, "style='font-size:10px'");
	$clsForm->addInputSelect("is_active", 1, "Is Active?", $arrYesNoOptions, 0, "style='font-size:10px'");
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