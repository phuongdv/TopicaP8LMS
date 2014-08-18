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
	
	$arrListSite = $core->getAllSite();
	$arrListBlock = $clsModule->getAllBlock($arrListSite);	
	$clsModule->reSyncBlock($arrListSite, $arrListBlock);
	//print_r($arrListBlock);
	$tableName = "block";
	$classTable = "Block";
	$pkeyTable = "blockid";
	//get _GET, _POST
	$curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	$rowsPerPage = 20;	
	//init Button
	$clsButtonNav->set("Save", "/icon/disks2.png", "Save", 1, "save");	
	$clsButtonNav->set("New", "/icon/add2.png", "?admin&mod=$mod&act=add",1);
	$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	$clsButtonNav->set("Delete", "/icon/delete2.png", "?admin&mod=$mod&act=delete", 1, "confirmDelete");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin");
	//################### CHANGE BELOW CODE ###################
	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL("?$_SITE_ROOT&mod=$mod");
	$clsDataGrid->setDbTable($tableName);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle("Block");
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="girdtable"');
	$clsDataGrid->addColumnLabel("name", "Block", "width='10%'");
	$clsDataGrid->addColumnLabel("site", "Site", "width='10%' align='center'");
	$clsDataGrid->addColumnLabel("display_name", "Display Name", "width='10%' align='center'");
	$clsDataGrid->addColumnText("order_no", "OrderNo", "width='6%'  align='center'");
	$clsDataGrid->addColumnSelect("type", "Type?", "width='5%' align='center'", array("System", "Custom"));
	$clsDataGrid->addColumnSelect("position", "Position?", "width='5%' align='center'", array("L"=>"Left", "R"=>"Right"));
	$clsDataGrid->addColumnSelect("status", "Status?", "width='5%' align='center'", array("OFF"=>"InActive", "ON"=>"Active"));
	$clsDataGrid->addColumnDate("upddate", "Update", "width='10%' align='center'");
	//####################### ENG CHANGE ######################
	if ($btnSave!=""){	
		$clsDataGrid->saveData();
		header("location: ?$_SITE_ROOT");
	}
	
	$assign_list["clsDataGrid"] = $clsDataGrid;
	
}
/**
*  Add a new Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_add(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "block";
	$classTable = "Block";
	$pkeyTable = "blockid";
	
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
	$clsCurrency = new Currency();
	$arrListCurrency = $clsCurrency->getAll();
	$arrOptionsCurrency = array();
	if (is_array($arrListCurrency))
	foreach ($arrListCurrency as $key => $val){
		$arrOptionsCurrency[$val["currency_id"]] = $val["name"];
	}
	//init Form
	$arrPositionOptions = array("L"=>"LEFT", "R"=>"RIGHT", "B"=>"BOTTOM", "T"=>"TOP");
	$arrYesNoOptions = array("NO", "YES");
	$clsForm = new Form();
	$clsForm->setTextAreaType("advanced");
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle("Block");
	if ($mode=="New"){
		$clsForm->addInputText("site", "", "Site Name", 255, 0, "style='width:200px'");
		$clsForm->addInputText("name", "", "Block Name", 255, 0, "style='width:200px'");	
		$clsForm->addInputHidden("type", 1);
	}
	$clsForm->addInputHidden("upddate", time());
	$clsForm->addInputText("display_name", "", "Display Name", 255, 0, "style='width:200px'");
	$clsForm->addInputSelect("position", "", "Position?", array("L"=>"Left", "R"=>"Right"), 0, "width='5%'");
	$clsForm->addInputText("order_no", "99", "Order No", 3, 1, "style='width:200px'");
	$clsForm->addInputSelect("status", "ON", "Status?", array("ON"=>"Active", "OFF"=>"InActive"), 0, "width='5%'");
	$clsForm->addInputTextArea("content", "", "Content HTML", 255, 1, 5, 1, "style='width:50%;height:200px'");
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
*  Show detail an Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "block";
	$classTable = "Block";
	$pkeyTable = "blockid";
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