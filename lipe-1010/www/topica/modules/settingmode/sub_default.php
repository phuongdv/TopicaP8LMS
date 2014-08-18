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
	$tableName = "lipe_course_mode";
	$classTable = "Setting_Mode";
	$pkeyTable = "id";
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : "";
	$btnSave = isset($_REQUEST["button"])? $_REQUEST["button"] : "";
	$c_id = isset($_REQUEST["c_id"])? $_REQUEST["c_id"] : "";
	$mode = isset($_REQUEST["mode"])? $_REQUEST["mode"] : "";
	
	$clsUser=new User();
	$username= $_COOKIE['username'];
	if ($clsUser->CheckRole($username,$c_id)=='0')
	 {
	 echo "<script>alert('Ban khong phai la PO cua Mon nay nen chi xem duoc !');</script>";
	 echo '<script>self.close ();</script>';	
	 die();
	 //header("location: ?$_SITE_ROOT&mod=lipe&act=report&c_id=$c_id");
	 }
	
	
	//get Mode
	//$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks.png", "Save", 1, "save");
	if ($mode=="Edit"){
		$clsButtonNav->set("New", "/icon/add2.png", "?topica&mod=$mod&act=add",1);
		$clsButtonNav->set("Delete", "/icon/delete2.png", "?topica&mod=$mod&act=delete&$pkeyTable=$pvalTable");
	}
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?topica&mod=$mod&c_id=$c_id");
	//################### CHANGE BELOW CODE ###################
	$clsCourse = new Mdl_Course();
	$arrOneCourse = $clsCourse->GetOne($c_id);
	$clsMode = new Setting_Mode();
	$current_mode= $clsMode->getMode($c_id);
	//init Form
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		
	 $clsMode->setMode($c_id,$mode);
	 $assign_list["msg"] = 'Đã lưu';
	 $username=$_COOKIE['username'];
				$actionlog=new ActionLog();
				$actionlog->insertValue($username,'Setting Mode '.$mode,'Course id: '.$c_id);
	echo '<script>window.opener.location.reload();self.close ();</script>';	
	}
	
	$assign_list["clsModule"] = $clsModule;
	$assign_list["clsForm"] = $clsForm;
	$assign_list[$pkeyTable] = $pvalTable;
	$assign_list["c_id"] = $c_id;
	$assign_list["arrOneCourse"] = $arrOneCourse;
	$assign_list["currentmode"] = $current_mode;
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
	$tableName = "huy_setting_calendar";
	$classTable = "Setting_Calendar";
	$pkeyTable = "id";
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : "";
	$btnSave = isset($_REQUEST["btnSave"])? $_REQUEST["btnSave"] : "";
	$c_id = isset($_REQUEST["c_id"])? $_REQUEST["c_id"] : "";
	
	
	$clsUser=new User();
	$username= $_COOKIE['username'];
	if ($clsUser->CheckRole($username,$c_id)=='0')
	 {
	 $redirect_url='?'.$_SITE_ROOT.'&mod=settingcalendar&c_id='.$c_id;
	 echo "<script>window.location = '".$redirect_url."';</script>";
	 die();
	 //header("location: ?$_SITE_ROOT&mod=lipe&act=report&c_id=$c_id");
	 
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
	$clsCourse = new Mdl_Course();
	$arrOneCourse = $clsCourse->GetOne($c_id);
	//init Form
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle($core->getLang("Edit Setting Calendar"));
	
	//$clsForm->addInputText("week_number", "", "Tuần thứ", 255, 1, "style='width:200px'");
	$clsForm->addInputText("week_name", "", "Tên tuần", 255, 1, "style='width:200px'");
	$clsForm->addInputDate("start_date", "", "Ngày bắt đầu", "%Y-%m-%d", 1, 0);
	$clsForm->addInputDate("end_date", "", "Ngày kết thúc", "%Y-%m-%d", 1, 0);
	$clsForm->addInputTextArea("comment", "", "Comment", 255, 10, 5, 1,  "style='width:50%'");
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
				$actionlog->insertValue($username,'Setting calendar / Add new calendar','Course id: '.$c_id);
				header("location: ?$_SITE_ROOT&mod=$mod&c_id=$c_id");
			}
		}
	}
	
	$assign_list["clsModule"] = $clsModule;
	$assign_list["clsForm"] = $clsForm;
	$assign_list[$pkeyTable] = $pvalTable;
	$assign_list["c_id"] = $c_id;
	$assign_list["arrOneCourse"] = $arrOneCourse;
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
	$classTable = "Setting_Calendar";
	$pkeyTable = "id";
	//################### CAN NOT MODIFY BELOW CODE ###################
	$clsTable = new $classTable();
	$pval = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : "";
	$c_id = isset($_REQUEST["c_id"])? $_REQUEST["c_id"] : "";
	
	if ($pval!=""){
		$clsTable->deleteOne($pval);
		header("location: ?$_SITE_ROOT&mod=$mod&c_id=$c_id");
	}
	$checkList = isset($_REQUEST["checkList"])? $_REQUEST["checkList"] : "";
	if (is_array($checkList)){
		foreach ($checkList as $key => $val){
			$clsTable->deleteOne($val);
		}
		$username=$_COOKIE['username'];
		$actionlog=new ActionLog();
		$actionlog->insertValue($username,'Setting calendar / Delete calendar','Course id: '.$c_id);
		header("location: ?$_SITE_ROOT&mod=$mod&c_id=$c_id");
				
	}
	unset($clsTable);
}
?>