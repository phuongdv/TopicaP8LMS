<?
/**
*  Default Action
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/

function makeListCat($c_id=0, $selectedid="", $level=0, &$arrHtml){
	global $dbconn;
	$arrListCat = $dbconn->GetAll("SELECT * FROM mdl_forum_discussions WHERE course='$c_id'");
	if (is_array($arrListCat)){
		foreach ($arrListCat as $k => $v){
			$selected = ($v["forum"]==$selectedid)? "selected" : "";
			$value = $v["forum"];
			$option = str_repeat("----", $level).$v["name"];
			$arrHtml[$value] = $option;
			makeListCat($typeid, $v["forum"], $selectedid, $level+1, &$arrHtml);
		}
		return "";
	}else{
		return "";
	}
}

function default_default(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "huy_setting_lipe";
	$classTable = "Setting_Lipe";
	$pkeyTable = "id";
	global $_LANG_ID;
	$clsClassTable = new $classTable;
	$clsSettingLipe = new Setting_Lipe();
	$clsUser=new User();
	$username= $_COOKIE['username'];
	//get _GET, _POST
	$curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
	$btnSave = isset($_REQUEST["btnSave"])? $_REQUEST["btnSave"] : "";
	$rowsPerPage = 40;	
	
	$page = isset($_REQUEST['page'])? intval($_REQUEST['page']) : 0; 
	
	
	$c_id = isset($_REQUEST["c_id"])? $_REQUEST["c_id"] : "";
	$disableedit=0;
	if ($clsUser->CheckRole($username,$c_id)=='0' && $btnSave=="")
	 {
	 $disableedit=1;
	 $redirect_url='?'.$_SITE_ROOT.'&mod=lipe&act=report&c_id='.$c_id;
	 echo "<script>alert('Ban khong phai la PO cua Mon nay nen chi xem duoc !');</script>";

	 
	 }
	
	
	//init Button if disable edit is false
	if($disableedit==0)
	{
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");	
	$clsButtonNav->set("New", "/icon/add2.png", "?topica&mod=$mod&act=add&c_id=$c_id",1);
	$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	$clsButtonNav->set("Delete", "/icon/delete2.png", "?topica&mod=$mod&act=delete&c_id=$c_id", 1, "confirmDelete");
    }
	//################### CHANGE BELOW CODE ###################
	$clsSetting_Calendar = new Setting_Calendar();
	$arrWeeknumber = $clsSetting_Calendar->getAll("c_id='$c_id'");
	//print_r($arrForumDiscussions);die();
	$arrOptionWeeknumber = array();
	if (is_array($arrWeeknumber))
	foreach ($arrWeeknumber as $key => $val){
		$arrOptionWeeknumber[$val["id"]] = $val["week_name"];
	}
	//init Grid
	$clsDataGrid = new DataGrid($curPage, $rowsPerPage);
	$clsDataGrid->setBaseURL("?$_SITE_ROOT&mod=$mod&c_id=".$c_id);
	$clsDataGrid->setDbTable($tableName,"c_id='$c_id'");
	$clsDataGrid->setPkey($pkeyTable);
	$clsDataGrid->setFormName("theForm");
	$clsDataGrid->setTitle($core->getLang("Setting Lipe"));
	$clsDataGrid->setTableAttrib('cellpadding="0" cellspacing="0" width="100%" border="0" class="girdtable"');
	//$clsDataGrid->addColumnLabel("id", "ID", "width='10%'");
	$clsDataGrid->addColumnLabel("style", "Style", "width='10%'");
	$clsDataGrid->addColumnLabel("active_id", "active_id", "width='10%'");
	$clsDataGrid->addColumnLabel("lipe_type", "lipe_type", "width='10%'");
	//$clsDataGrid->addColumnLabel("week_number", "Tuần thứ", "width='10%'");
	$clsDataGrid->addColumnSelect("calendar_id", "Tuần", "width='10%' align='center' style='font-size:12px'", $arrOptionWeeknumber);
	$clsDataGrid->addColumnLabel("comment", "Ghi chú", "width='50%'");
	
	
	//####################### ENG CHANGE ######################
	if ($btnSave!=""){	
		$clsDataGrid->saveData();
		header("location: ?$_SITE_ROOT&mod=$mod&c_id=".$c_id);
	}
	
	$assign_list["clsDataGrid"] = $clsDataGrid;
	$assign_list["c_id"] = $c_id;
	
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
?>