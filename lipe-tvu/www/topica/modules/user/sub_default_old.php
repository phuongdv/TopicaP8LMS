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
	$classTable = "User";
	$clsClassTable = new $classTable;
	$tableName = "mdl_user";
	$pkeyTable = "id";
	global $_LANG_ID;

	//get _GET, _POST
	$curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	$rowsPerPage = 20;	
	
	//$category_id = isset($_POST["cat_id"])? $_POST["cat_id"] : 0; 
	$username = isset($_POST["username"])? trim($_POST["username"]) : "";	
	
	/*if(($category_id !=0) || ($tour_name != "")) header("Location: ?$_SITE_ROOT&mod=$mod&category_id=".$category_id."&keyword=".$tour_name);*/
	
	/*$category_id = isset($_REQUEST["category_id"])? $_REQUEST["category_id"] : 0; */
	$username = isset($_REQUEST["keyword"])? trim($_REQUEST["keyword"]) : "";
	$page = isset($_REQUEST['page'])? intval($_REQUEST['page']) : 0; 
		
	$cond = "";
	if($username != "") {
		$keyword = mb_strtolower($username,'utf-8');
		$cond .= (($cond=="")? " (LOWER(CONVERT(username USING utf8)) like '%".$keyword."%' or LOWER(CONVERT(highlights USING utf8)) like '%".$keyword."%')" : " and (LOWER(CONVERT(username USING utf8)) like '%".$keyword."%' or LOWER(CONVERT(highlights USING utf8)) like '%".$keyword."%')");
	}
	
	/*if($category_id != 0) {
		$cond .= (($cond=="")? " typeoftour='".$category_id."' or typeoftour in (select cat_id from category where parent_id='".$category_id."')" : " and (typeoftour='".$category_id."' or typeoftour in (select cat_id from category where parent_id='".$category_id."'))");
	}	*/
		
	$cond .= (($cond=="")? "1=1 order by order_no ASC" : " order by order_no ASC");
	
	//init Button
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");	
	$clsButtonNav->set("New", "/icon/add2.png", "?admin&mod=$mod&act=add",1);
	$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	$clsButtonNav->set("Delete", "/icon/delete2.png", "?admin&mod=$mod&act=delete", 1, "confirmDelete");

	//################### CHANGE BELOW CODE ###################
/*	$clsCategory = new Category();
	$arrListCategory = $clsCategory->getAll();*/
	//print_r();die();
	//print_r($arrListCategory);die();
	/*$arrOptionsCategory[0] = '--- Không thuộc menu nào ---';
	makeListCat(0, "", 0 , $arrOptionsCategory);*/
		
	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL("?$_SITE_ROOT&mod=$mod&category_id=".$category_id."&keyword=".$username);
	$clsDataGrid->setDbTable($tableName, $cond);
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("Danh sách học viên"));
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="girdtable"');
	$clsDataGrid->addColumnLabel("firstname", "Họ", "width='20%'");
	$clsDataGrid->addColumnLabel("lastname", "Tên", "width='20%'");
	$clsDataGrid->addColumnLabel("username", "Username", "width='20%'");
	$clsDataGrid->addColumnLabel("topica_lop", "Lớp", "width='20%'");
	$clsDataGrid->addColumnLabel("topica_nganh", "Ngành", "width='20%'");
	$clsDataGrid->addColumnLabel("topica_nhom", "Nhóm", "width='20%'");
	$clsDataGrid->addColumnLabel("topica_coquan", "Cơ quan", "width='20%'");
	$clsDataGrid->addColumnLabel("topica_chucdanh", "Chức danh", "width='20%'");
	$clsDataGrid->addColumnLabel("topica_chucvutronglop", "Chức vụ", "width='20%'");
	$clsDataGrid->addColumnLabel("topica_chucvutrongnhom", "Chức vụ trong nhóm", "width='20%'");
	
	//####################### ENG CHANGE ######################
	if ($btnSave!=""){	
		$clsDataGrid->saveData();
		header("location: ?$_SITE_ROOT&mod=$mod");
	}
	
	$assign_list["clsDataGrid"] = $clsDataGrid;
	$assign_list["username"] = $username;
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
	$classTable = "tours";
	$clsClassTable = new $classTable;
	$tableName = "tours";
	$pkeyTable = "tours_id";
	global $_LANG_ID;
	
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
	$arrOptionsCategory[0] = '--- Không thuộc menu nào ---';
	makeListCat(0, "", 0, $arrOptionsCategory);

	//init Form
	$arrPositionOptions = array("L"=>"LEFT", "R"=>"RIGHT", "B"=>"BOTTOM", "T"=>"TOP");
	$arrYesNoOptions = array("NO", "YES");
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle($core->getLang("Tours-List"));
	$clsForm->setTextAreaType("advanced");
	$clsForm->addInputText("tour_name", "", "Tour Name", 255, 0, "style='width:400px'");
	$clsForm->addInputSelect("typeoftour", "", "Type Of Tour", $arrOptionsCategory, 0, "style='font-size:10px'");
	$clsForm->addInputText("long_day", "", "Long Day", 255, 1, "style='width:400px'");
	$clsForm->addInputText("order_no", "99", "OrderNo", 3, 0, "style='width:110px'");
	$clsForm->addInputTextArea("highlights", "", "HighLights", 255, 10, 5, 0,  "style='width:50%'");
	$clsForm->addInputTextArea("details", "", "Details", 255, 10, 5, 0,  "style='width:100%'");
	$clsForm->addInputTextArea("services", "", "Dịch vụ đi kèm", 255, 10, 5, 0,  "style='width:100%'");
	$clsForm->addInputText("goingto", "", "Going To", 255, 1, "style='width:200px'");
	$clsForm->addInputText("price", "", "Price", 255, 1, "style='width:200px'");
	$clsForm->addInputHidden("reg_date", time());
	$clsForm->addInputFile("image", "", "Ảnh chính", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im1", "", "Ảnh trong bài viết 1", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im2", "", "Ảnh trong bài viết 2", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im3", "", "Ảnh trong bài viết 3", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im4", "", "Ảnh trong bài viết 4", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im5", "", "Ảnh trong bài viết 5", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im6", "", "Ảnh trong bài viết 6", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im7", "", "Ảnh trong bài viết 7", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im8", "", "Ảnh trong bài viết 8", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im9", "", "Ảnh trong bài viết 9", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im10", "", "Ảnh trong bài viết 10", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im11", "", "Ảnh trong bài viết 11", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im12", "", "Ảnh trong bài viết 12", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im13", "", "Ảnh trong bài viết 13", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputFile("im14", "", "Ảnh trong bài viết 14", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputSelect("is_online", 1, "IsOnline", $arrYesNoOptions, 0, "style='font-size:10px'");
	$clsForm->addInputSelect("is_hot", 1, "IsHot", $arrYesNoOptions, 0, "style='font-size:10px'");
	$clsForm->addInputSelect("is_saleoff", 1, "IsSaleOff", $arrYesNoOptions, 0, "style='font-size:10px'");
	$clsForm->addInputSelect("is_special", 1, "IsSpecial", $arrYesNoOptions, 0, "style='font-size:10px'");
	$clsForm->addInputSelect("is_best", 1, "IsBest", $arrYesNoOptions, 0, "style='font-size:10px'");
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
	$classTable = "Tours";
	$clsClassTable = new $classTable;
	$tableName = $clsClassTable->tbl;
	$pkeyTable = $clsClassTable->pkey;
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
