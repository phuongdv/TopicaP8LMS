<?
/**
*  Add a new Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
   	
*  @date		: 2007/04/01
   @date-modify : 2008/01/16	
*  @version		: 1.0.0
*/
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "category";
	$classTable = "Category";
	$pkeyTable = "cat_id";
	global $_LANG_ID;

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
	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL("?$_SITE_ROOT&mod=$mod");
	$clsDataGrid->setDbTable($tableName, "parent_id!=0 and 1=1 order by cat_id ASC");
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("Category"));
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="girdtable"');
	$clsDataGrid->addColumnLabel("name", "Name", "width='15%'");	
	
	$arrOptionsCategory = array();
	$arrOptionsCategory[0] = '----- Danh mục cha -----';
	makeListCat(0, "", 0, $arrOptionsCategory);
	
	//$clsDataGrid->addColumnLabel("cat_link", "Link", "width='25%'");
	
	$clsDataGrid->addColumnText("order_no", "OrderNo", "width='4%'  align='center'");
	//$clsDataGrid->addColumnSelect("cat_type", "CatType", "width='10%' align='center'", $arrOptionsTypeCategory);
	$clsDataGrid->addColumnSelect("parent_id", "ParentCategory", "width='10%' align='center'", $arrOptionsCategory);		
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
   	
*  @date		: 2007/04/01
   @date-modify : 2008/01/16	
*  @version		: 1.0.0
*/
function default_add(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "category";
	$classTable = "Category";
	$pkeyTable = "cat_id";
	global $_LANG_ID;	
	
	require_once DIR_COMMON."/clsForm.php";	
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
	
	$arrOptionsCategory[0] = '----- Danh mục cha -----';
	makeListCat(0, $pvalTable, 0, $arrOptionsCategory);
	//init Form
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle($core->getLang("Category"));
	$clsForm->addInputText("name", "", "Name", 255, 0, "style='width:200px'");	
	//$clsForm->addInputText("name_en", "", "NameEn", 255, 0, "style='width:200px'");	
	$clsForm->addInputText("cat_link", "", "Link", 255, 1, "style='width:297px'");
	$clsForm->addInputText("cat_keyword", "", "Keyword", 255, 1, "style='width:297px'");
	
	$clsForm->addInputTextArea("des", "", "Description", 255, 10, 5, 1,  "style='width:50%'");
	$clsForm->addInputText("order_no", "99", "OrderNo", 3, 0, "style='width:200px'");		
	
	$clsForm->addInputSelect("parent_id", 1, "ParentCategory", $arrOptionsCategory, 0, "style='font-size:10px'");
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
*  Add a new Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
   	
*  @date		: 2007/04/01
   @date-modify : 2008/01/16	
*  @version		: 1.0.0
*/
function default_delete(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$classTable = "Category";
	$pkeyTable = "cat_id";
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

/**
*  Show Category of Product
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function makeListCat($catid=0, $selectedid="", $level=0, &$arrHtml){
	global $dbconn, $_LANG_ID;
	$arrListCat = $dbconn->GetAll("SELECT * FROM category WHERE parent_id='$catid'");	
	if (is_array($arrListCat)){
		foreach ($arrListCat as $k => $v){
			$selected = ($v["cat_id"]==$selectedid)? "selected" : "";
			$value = $v["cat_id"];
			$name = $v["name"];
			$option = str_repeat("----", $level).$name;
			$arrHtml[$value] = $option;
			makeListCat($v["cat_id"], $selectedid, $level+1, &$arrHtml);
		}
		return "";
	}else{
		return "";
	}
}

?>