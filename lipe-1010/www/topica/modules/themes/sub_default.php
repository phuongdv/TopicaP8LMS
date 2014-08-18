<?
function makeListCat($catid=0, $selectedid="", $level=0, &$arrHtml){
	global $dbconn;
	$arrListCat = $dbconn->GetAll("SELECT * FROM category WHERE parent_id='$catid'");
	if (is_array($arrListCat)){
		foreach ($arrListCat as $k => $v){
			$selected = ($v["cat_id"]==$selectedid)? "selected" : "";
			$value = $v["cat_id"];
			$option = str_repeat("----", $level).$v["name"];
			$arrHtml[$value] = $option;
			makeListCat($v["cat_id"], $selectedid, $level+1, &$arrHtml);
		}
		return "";
	}else{
		return "";
	}
}
/**
*  Default Action
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "news";
	$classTable = "News";
	$pkeyTable = "news_id";
	global $_LANG_ID;
	
	$clsCountry = new Country();
	$clsCat = new Category();
	
	//$tableName = ($_LANG_ID!="vn")? $tableName."_".$_LANG_ID : $tableName;	

	//get _GET, _POST
	$curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	$rowsPerPage = 20;	

	//init Button
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");	
	$clsButtonNav->set("New", "/icon/add2.png", "?admin&mod=$mod&act=add",1);
	$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	$clsButtonNav->set("Delete", "/icon/delete2.png", "?admin&mod=$mod&act=delete", 1, "confirmDelete");
    $arrOneCatNews = $clsCat->getByCond("order_no=5"); 
	$cat_id = $arrOneCatNews["cat_id"]; 
	//################### CHANGE BELOW CODE ###################
	
	$arrListCountry = $clsCountry->getAll("1=1 order by country_id ASC");
	if(is_array($arrListCountry)) {
		foreach($arrListCountry as $key => $val) {
			$arrListOptCountry[$val["country_id"]] = $val["name"];			
		}		
	}
	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL("?$_SITE_ROOT&mod=$mod");
	$clsDataGrid->setDbTable($tableName,"cat_id='".$cat_id."' order by reg_date DESC");
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("Themes"));
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="girdtable"');
	$clsDataGrid->addColumnLabel("title", "Title", "width='30%'");
	$clsDataGrid->addColumnDate("reg_date", "Update Day", "width='5%' align='center'");
	$clsDataGrid->addColumnSelect("is_new", "New", "width='5%' align='center'", array("NO", "YES"));
	$clsDataGrid->addColumnSelect("is_hot", "Hot", "width='5%' align='center'", array("NO", "YES"));
	$clsDataGrid->addColumnSelect("country_id", "Country", "width='15%' align='center'", $arrListOptCountry);
	$clsDataGrid->addColumnSelect("is_online", "Online", "width='5%' align='center'", array("NO", "YES"));
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
	$tableName = "news";
	$classTable = "News";
	$pkeyTable = "news_id";
	global $_LANG_ID;
	
	$clsCountry = new Country();
	$clsCat = new Category();
	//$tableName = ($_LANG_ID!="vn")? $tableName."_".$_LANG_ID : $tableName;	
	
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
	$arrOneCatNews = $clsCat->getByCond("order_no=5"); 
	$cat_id = $arrOneCatNews["cat_id"]; 

	$arrListCountry = $clsCountry->getAll("1=1 order by country_id ASC");
	if(is_array($arrListCountry)) {
		foreach($arrListCountry as $key => $val) {
			$arrListOptCountry[$val["country_id"]] = $val["name"];			
		}		
	}
	//init Form
	$arrPositionOptions = array("L"=>"LEFT", "R"=>"RIGHT", "B"=>"BOTTOM", "T"=>"TOP");
	$arrYesNoOptions = array("NO", "YES");
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);	
	$clsForm->setTitle($core->getLang("Themes"));
	$clsForm->setTextAreaType("advanced");
	$clsForm->addInputText("title", "", "Title", 255, 0, "style='width:400px'");
	$clsForm->addInputFile("image", "", "Image", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputText("image_comment", "", "Image Comment", 255, 1, "style='width:400px'");
	$clsForm->addInputTextArea("intro", "", "Introduce", 255, 10, 5, 1,  "style='width:50%'");
	$clsForm->addInputTextArea("content", "", "Content", 255, 10, 5, 0,  "style='width:100%'");
	$clsForm->addInputSelect("country_id", "", "Country", $arrListOptCountry, 0, "style='font-size:10px; width:150px;'");	
	$clsForm->addInputText("author", "", "Author", 255, 1, "style='width:200px'");
	$clsForm->addInputText("source", "", "Source", 255, 1, "style='width:200px'");
	if ($mode=="New"){
		$clsForm->addInputHidden("reg_date", time());
		$clsForm->addInputHidden("cat_id", $cat_id);
	}else{
		$clsForm->addInputHidden("upd_date", time());
		$clsForm->addInputHidden("upd_num", $clsForm->getFieldValue("upd_num")+1);
	}
	$clsForm->addInputSelect("is_online", 1, "IsOnline?", $arrYesNoOptions, 0, "style='font-size:10px'");
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
	$tableName = "news";
	$classTable = "News";
	$pkeyTable = "news_id";
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
