<?
/**
*  Default Action
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/

function default_default(){
	/**
*  Default Action
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
	header("location:?topica&mod=lipe");
	global $assign_list, $_CONFIG;
	
}
/**
*  Add a new Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_about(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "page";
	$classTable = "Page";
	$pkeyTable = "page_id";
	global $_LANG_ID;
	$tableName = ($_LANG_ID!="vn")? $tableName."_".$_LANG_ID : $tableName;	
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : 1;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks2.png", "Save", 1, "save");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin&mod=$mod");
	//################### CHANGE BELOW CODE ###################
	//init Form
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle("Page");
	$clsForm->setTextAreaType("advanced");
	$clsForm->addInputFile("about_image", "", "Image", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	$clsForm->addInputText("image_comment", "", "Image Comment", 255, 1, "style='width:400px'");
	$clsForm->addInputTextArea("about_intro", "", $core->getLang("Content"), 255, 30, 5, 1, "style='width:100%'");
	$clsForm->addInputTextArea("about_full", "", $core->getLang("ContentFull"), 255, 10, 5, 1,  "style='width:100%'");
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		if ($clsForm->validate()){
			if ($clsForm->saveData($mode)){
				header("location: ?$_SITE_ROOT&act=$act");
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
*  @version		: 1.0.0
*/
function default_imagenews(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "img_new";
	$classTable = "img_new";
	$pkeyTable = "img_id";
	global $_LANG_ID;
	$tableName = ($_LANG_ID!="vn")? $tableName."_".$_LANG_ID : $tableName;	
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : 1;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks2.png", "Save", 1, "save");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin&mod=$mod");
	//################### CHANGE BELOW CODE ###################
	//init Form
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle("Tin ảnh");
	$clsForm->setTextAreaType("advanced");
	$clsForm->addInputFile("image", "", "Image", "jpg, jpeg, gif,png", 1, "style='width:300px'");
	
	$clsForm->addInputTextArea("content_vn", "", $core->getLang("Content Viet Nam"), 255, 30, 5, 0, "style='width:100%'");
	
	$clsForm->addInputTextArea("content_en", "", $core->getLang("Content English"), 255, 30, 5, 0, "style='width:100%'");
	
	$clsForm->addInputText("link", "", "Link", 255, 0, "style='width:400px'");
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		if ($clsForm->validate()){
			if ($clsForm->saveData($mode)){
				header("location: ?$_SITE_ROOT&act=$act");
			}
		}
	}
	
	$assign_list["clsModule"] = $clsModule;
	$assign_list["clsForm"] = $clsForm;
	$assign_list[$pkeyTable] = $pvalTable;
}

/**
*  Sitemap
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/

function default_sitemap(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "page";
	$classTable = "Page";
	$pkeyTable = "page_id";
	global $_LANG_ID;
	$tableName = ($_LANG_ID!="vn")? $tableName."_".$_LANG_ID : $tableName;	
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : 1;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks2.png", "Save", 1, "save");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin&mod=$mod");
	//################### CHANGE BELOW CODE ###################
	//init Form
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle($core->getLang("SiteMap"));
	$clsForm->setTextAreaType("advanced");
	$clsForm->addInputTextArea("sitemap_vn", "", $core->getLang("SiteMap Viet Nam"), 255, 30, 5, 1, "style='width:100%'");
	$clsForm->addInputTextArea("sitemap_en", "", $core->getLang("SiteMap English"), 255, 30, 5, 1, "style='width:100%'");
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		if ($clsForm->validate()){
			if ($clsForm->saveData($mode)){
				header("location: ?$_SITE_ROOT&act=$act");
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

function default_metakeyword(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "settings";
	$classTable = "Settings";
	$pkeyTable = "skey";
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : "META_KEYWORD";
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks2.png", "Save", 1, "save");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin&mod=$mod");
	//################### CHANGE BELOW CODE ###################
	//init Form
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle($core->getLang("Meta-Keyword"));
	$clsForm->addInputTextArea("svalue", "", $core->getLang("Content"), 255, 30, 5, 1, "style='width:100%; height:200px'");
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		if ($clsForm->validate()){
			if ($clsForm->saveData($mode)){
				header("location: ?$_SITE_ROOT&act=$act");
			}
		}
	}
	
	$assign_list["clsModule"] = $clsModule;
	$assign_list["clsForm"] = $clsForm;
	$assign_list[$pkeyTable] = $pvalTable;
}

/**
*  Show Filter
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/

function default_filter(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "settings";
	$classTable = "Settings";
	$pkeyTable = "skey";
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : "FILTER_IP";
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks2.png", "Save", 1, "save");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin&mod=$mod");
	//################### CHANGE BELOW CODE ###################
	//init Form
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle($core->getLang("FilterIp"));
	$clsForm->addInputTextArea("svalue", "", $core->getLang("Content"), 255, 1,1, 1, "style='width:90%;height:100px'");
	$clsForm->addHint("svalue", "Each IP Address is separated by comma ,");
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		if ($clsForm->validate()){
			if ($clsForm->saveData($mode)){
				header("location: ?$_SITE_ROOT&act=$act");
			}
		}
	}
	
	$assign_list["clsModule"] = $clsModule;
	$assign_list["clsForm"] = $clsForm;
	$assign_list[$pkeyTable] = $pvalTable;
}


/**
*  Show detail Contact Info
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/

function default_contactinfo(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "page";
	$classTable = "Page";
	$pkeyTable = "page_id";
	global $_LANG_ID;
	$tableName = ($_LANG_ID!="vn")? $tableName."_".$_LANG_ID : $tableName;	
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : 1;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks2.png", "Save", 1, "save");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin&mod=$mod");
	//################### CHANGE BELOW CODE ###################
	//init Form
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTextAreaType("advanced");
	$clsForm->setTitle($core->getLang("Contact-Info"));
	$clsForm->addInputTextArea("contact", "", $core->getLang("Content"), 255, 30, 5, 1, "style='width:90%;height:100px'");
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		if ($clsForm->validate()){
			if ($clsForm->saveData($mode)){
				header("location: ?$_SITE_ROOT&act=$act");
			}
		}
	}
	
	$assign_list["clsModule"] = $clsModule;
	$assign_list["clsForm"] = $clsForm;
	$assign_list[$pkeyTable] = $pvalTable;
}

/**
*  Show detail Policy
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/

function default_policy(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "page";
	$classTable = "Page";
	$pkeyTable = "page_id";
	global $_LANG_ID;
	$tableName = ($_LANG_ID!="vn")? $tableName."_".$_LANG_ID : $tableName;	
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : 1;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks2.png", "Save", 1, "save");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin&mod=$mod");
	//################### CHANGE BELOW CODE ###################
	//init Form
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle($core->getLang("PrivacyPolicy"));
	$clsForm->setTextAreaType("advanced");
	$clsForm->addInputTextArea("policy", "", $core->getLang("Content"), 255, 30, 5, 1, "style='width:90%;height:100px'");
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		if ($clsForm->validate()){
			if ($clsForm->saveData($mode)){
				header("location: ?$_SITE_ROOT&act=$act");
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
function default_footer(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav;
	$tableName = "page";
	$classTable = "Page";
	$pkeyTable = "page_id";
	global $_LANG_ID;	
	
	require_once DIR_COMMON."/clsForm.php";
	//get _GET, _POST
	$pvalTable = isset($_REQUEST[$pkeyTable])? $_REQUEST[$pkeyTable] : 1;
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	//get Mode
	$mode = ($pvalTable!="")? "Edit" : "New";
	//init Button
	$clsButtonNav->set("Save", "/icon/disks2.png", "Save", 1, "save");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin&mod=$mod");
	//################### CHANGE BELOW CODE ###################
	//init Form
	$clsForm = new Form();
	$clsForm->setDbTable($tableName, $pkeyTable, $pvalTable);
	$clsForm->setTitle($core->getLang("EditFooter"));
	$clsForm->setTextAreaType("advanced");
	$clsForm->addInputTextArea("footer", "", $core->getLang("Content"), 255, 30, 5, 1, "style='width:100%'");
	
	//####################### ENG CHANGE ######################
	//do Action
	if ($btnSave!=""){
		if ($clsForm->validate()){
			if ($clsForm->saveData($mode)){
				header("location: ?$_SITE_ROOT&act=$act");
			}
		}
	}
	
	$assign_list["clsModule"] = $clsModule;
	$assign_list["clsForm"] = $clsForm;
	$assign_list[$pkeyTable] = $pvalTable;
}

?>