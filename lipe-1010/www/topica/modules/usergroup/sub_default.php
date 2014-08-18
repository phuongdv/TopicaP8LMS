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
	$tableName = "user_group";
	$classTable = "UserGroup";
	$pkeyTable = "user_group_id";

	//get _GET, _POST
	$curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	$rowsPerPage = 20;	

	//init Button
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");	
	$clsButtonNav->set("New", "/icon/add2.png", "?admin&mod=$mod&act=add",1);
	$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	//$clsButtonNav->set("Delete", "/icon/delete2.png", "?admin&mod=$mod&act=delete", 1, "confirmDelete");

	//################### CHANGE BELOW CODE ###################
	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL("?$_SITE_ROOT&mod=$mod");
	$clsDataGrid->setDbTable($tableName);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("UserGroups"));
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="girdtable"');
	$clsDataGrid->addColumnLabel("name", "GroupName", "width='20%'");
	$clsDataGrid->addColumnLabel("display_name", "DisplayName", "width='20%'");
	$clsDataGrid->addColumnLabel("des", "Description", "width='30%'");
	$clsDataGrid->addColumnSelect("access_admin_panel", "Allowaccess NVCPanel?", "width='50%' align='center'", array("NO", "YES"));
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
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "user_group";
	$classTable = "UserGroup";
	$pkeyTable = "user_group_id";
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : "";
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	$clsUserGroup = new $classTable();
	//$clsUserGroup->setDebug();
	//init Button
	$isAdmin=0;
	if ($mode=="Edit"){
		$arrUserGroup = $clsUserGroup->getOne($pvalTable);
		$isAdmin = ($arrUserGroup["name"]=="administrator" );
	}
	if (!$isAdmin || $arrUserGroup[$pkeyTable]==$core->_USER[$pkeyTable]){
		if ($mode=="Edit")
			$clsButtonNav->set("Save...", "/icon/disks2.png", "Save and Continue", 1, "save2");
		$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");
	}
	if ($mode=="Edit"){
		$clsButtonNav->set("New", "/icon/add2.png", "?admin&mod=$mod&act=add",1);
		if (!$isAdmin)
		$clsButtonNav->set("Delete", "/icon/delete2.png", "?admin&mod=$mod&act=delete&$pkeyTable=$pvalTable");
	}
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin&mod=$mod");
	//################### CHANGE BELOW CODE ###################
	//init Form
	$arrPositionOptions = array("L"=>"LEFT", "R"=>"RIGHT", "B"=>"BOTTOM", "T"=>"TOP");
	$arrYesNoOptions = array("NO", "YES");
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTextAreaType();
	$clsForm->setTitle($core->getLang("UserGroups"));
	$clsForm->addInputText("name", "", "GroupName", 255, 0, "style='width:200px'");
	$clsForm->addInputText("display_name", "", "DisplayName", 255, 0, "style='width:200px'");
	$clsForm->addInputTextArea("des", "", "Description", 255, 1, 5, 10, "style='width:50%'");	
	$clsForm->addInputSelect("access_admin_panel", 1, "Allowaccess NVCPanel?", $arrYesNoOptions, 0, "style='font-size:10px'");
	//set permission
	$arrAccessPermiss = array();
	$arrAdminModule = $clsModule->getAll("site='admin' ORDER BY name");	
	if (is_array($arrAdminModule))
	foreach ($arrAdminModule as $key => $val){
		$site_name = $val["site"]."_".$val["name"];
		$arrAdminModule[$key]["site_name"] = $site_name;
		$arrAccessPermiss[$site_name]["L"] = 0;
		$arrAccessPermiss[$site_name]["A"] = 0;
		$arrAccessPermiss[$site_name]["E"] = 0;
		$arrAccessPermiss[$site_name]["D"] = 0;
	}
	
	if ($mode=="Edit"){		
		if (is_array($arrUserGroup)){
			$arrCurPermiss = @unserialize($arrUserGroup["access_permiss"]);
		}
		if (is_array($arrCurPermiss))
		foreach ($arrCurPermiss as $key => $val){
			$arrAccessPermiss[$key]["L"] = $val["L"];
			$arrAccessPermiss[$key]["A"] = $val["A"];
			$arrAccessPermiss[$key]["E"] = $val["E"];
			$arrAccessPermiss[$key]["D"] = $val["D"];
		}
	}

	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){		
		foreach ($arrAdminModule as $key => $val){
			$site_name = $val["site"]."_".$val["name"];
			$arrAccessPermiss[$site_name]["L"] = $_POST[$site_name]["L"];
			$arrAccessPermiss[$site_name]["A"] = $_POST[$site_name]["A"];
			$arrAccessPermiss[$site_name]["E"] = $_POST[$site_name]["E"];
			$arrAccessPermiss[$site_name]["D"] = $_POST[$site_name]["D"];		
		}
		$access_permiss = @serialize($arrAccessPermiss);
		$clsForm->addInputHidden("access_permiss", $access_permiss);

		if ($clsForm->validate() && $clsForm->saveData($mode)){
			if ($btnSave=="Save"){
				header("location: ?$_SITE_ROOT&mod=$mod");
			}else
				header("location: ?$_SITE_ROOT&mod=$mod&act=$act&$pkeyTable=$pvalTable");
		}
	}
	unset($clsUserGroup);
	
	$assign_list["clsModule"] = $clsModule;
	$assign_list["clsForm"] = $clsForm;
	$assign_list[$pkeyTable] = $pvalTable;
	$assign_list["arrAdminModule"] = $arrAdminModule;
	$assign_list["arrAccessPermiss"] = $arrAccessPermiss;
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
function default_edit(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	
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
	$tableName = "user_group";
	$classTable = "UserGroup";
	$pkeyTable = "user_group_id";
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