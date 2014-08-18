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
	
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";

	$clsButtonNav->set("Save...", "/icon/disks2.png", "Save and Continue", 1, "save");
	//$clsButtonNav->set("New", "/icon/add2.png", "?admin&mod=$mod&act=new");
	$clsButtonNav->set("Edit", "/icon/edit2.png", "Edit", 1, "confirmEdit");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin");
	//$clsButtonNav->set("Delete", "/icon/delete2.png", "?admin&mod=$mod&act=del");
	
	$arrListSite = $core->getAllSite();
	$arrListModule = $clsModule->getAllModule($arrListSite);	
	//Synchorize File mod.ini with Database
	$clsModule->reSyncModule($arrListSite, $arrListModule);
	
	$arrListModuleDB = $clsModule->getAllModuleFromDB();
	
	$curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : "";
	$clsPaging = new Paging($curPage, 10);
	$clsPaging->setTotalRows(120);
	$clsPaging->setBaseUrl("?$_SITE_ROOT&mod=$mod");
	
	if ($btnSave!=""){
		$statusList = $_POST["statusList"];
		$anonymousList = $_POST["anonymousList"];
		if (is_array($statusList)){
			foreach ($statusList as $key => $val){
				$arr = explode("_", $key);
				$site = $arr[0];
				$name = $arr[1];
				$set = "status='$val', anonymous='".$anonymousList[$key]."'";
				$clsModule->updateByCond("site='$site' AND name='$name'", $set);
				header("location: ?$_SITE_ROOT");
			}
		}
	}
	
	$assign_list["arrListSite"] = $arrListSite;
	$assign_list["arrListModule"] = $arrListModule;
	$assign_list["arrListModuleDB"] = $arrListModuleDB;
	$assign_list["clsPaging"] = $clsPaging;
	$assign_list["clsModule"] = $clsModule;
}
/**
*  Add a new Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_add(){
	global $assign_list;
	
}

/**
*  List all Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_editini(){
	global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $act;
	global $core, $clsModule, $clsButtonNav, $dbconn;

	$site_name = isset($_REQUEST["site_name"])? $_REQUEST["site_name"] : "";
	$btnSave = isset($_POST["btnSave"])? $_POST["btnSave"] : "";
	$arr = explode('_', $site_name);
	$site = $arr[0];
	$name = $arr[1];

	$clsButtonNav->set("Save...", "/icon/disks2.png", "Save and Continue", 1, "save2");
	$clsButtonNav->set("Save", "/icon/disks.png", "Save the Change", 1, "save");
	$clsButtonNav->set("Cancel", "/icon/undo.png", "?admin&mod=$mod");
	$arrModule = $clsModule->getByCond("site='$site' AND name='$name'");
	
	//Info
	$display_name = $arrModule["display_name"];
	$des = $arrModule["des"];
	$status = $arrModule["status"];
	$anonymous = $arrModule["anonymous"];
	$upddate = $arrModule["upddate"];
	$config = @unserialize($arrModule["config"]);
	if (!is_array($config)) $config = array();
	if ($site!="admin"){
		//Global
		$leftpanel = ($config["Global"]["LeftPanel"]!="")? $config["Global"]["LeftPanel"] : "ON";
		$rightpanel = ($config["Global"]["RightPanel"]!="")? $config["Global"]["RightPanel"] : "ON";
		//LeftPanel
		$arrLeftBlock = $config["LeftPanel"];
		$arrRightBlock = $config["RightPanel"];
		//print_r($arrRightBlock);
			
		$arrListBlock = $clsModule->getAllBlockDB($site);
		$arrListBlock = $arrListBlock[$site];
		if (is_array($arrListBlock))
		foreach ($arrListBlock as $key => $val){
			$n = $val["name"];
			if ($arrLeftBlock[$n]!=""){
				$arrListBlock[$key]["status"] = $arrLeftBlock[$n];
				$arrListBlock[$key]["position"] = "L";
			}else
			if ($arrRightBlock[$n]!=""){
				$arrListBlock[$key]["status"] = $arrRightBlock[$n];
				$arrListBlock[$key]["position"] = "R";
			}
		}
	}
	//print_r($arrListBlock);
	if ($btnSave!=""){
		$display_name = $_POST["display_name"];
		$des = $_POST["des"];
		$status  = $_POST["status"];
		$anonymous = $_POST["anonymous"];
		$upddate = time();
		
		if ($site!="admin"){
			$leftpanel = $_POST["leftpanel"];
			$rightpanel = $_POST["rightpanel"];			
			$positionList = $_POST["positionList"];
			$orderList = $_POST["orderList"];
			$statusList = $_POST["statusList"];
			$arrListLeft = array();
			$arrListRight = array();
			if (is_array($statusList)){
				foreach ($statusList as $key => $val){
					if ($positionList[$key]=="L"){
						$arrListLeft[] = $key;
					}else{
						$arrListRight[] = $key;
					}
				}
			}	
			//print_r($config);
			$config["Info"]["Display_Name"] = $display_name;
			$config["Info"]["Description"] = $des;
			$config["Info"]["Status"] = $status;
			$config["Info"]["Anonymous"] = $anonymous;
			$config["Info"]["Update"] = $_POST["upddate"];
			
			$config["Global"]["LeftPanel"] = $leftpanel;
			$config["Global"]["RightPanel"] = $rightpanel;
			
			if (is_array($arrListLeft)){
				$config["LeftPanel"] = array();
				foreach ($arrListLeft as $key => $val){
					$config["LeftPanel"][$val] = $statusList[$val];
				}
			}
			if (is_array($arrListRight)){
				$config["RightPanel"] = array();
				foreach ($arrListRight as $key => $val){
					$config["RightPanel"][$val] = $statusList[$val];
				}
			}
			//print_r($config);
			$config = @serialize($config);
		}
		$set = "display_name='$display_name', des='$des', status='$status', 
				anonymous='$anonymous', upddate='$upddate', config='$config'";						
		$sql = "UPDATE module set $set WHERE site='$site' AND name='$name'";
		$dbconn->Execute($sql);
		
		if ($btnSave=="Save")
			header("location: ?$_SITE_ROOT&mod=$mod");
		else
			header("location: ?$_SITE_ROOT&mod=$mod&act=editini&site_name=$site_name");
	}
	
	$assign_list["site"] = $site;
	$assign_list["name"] = $name;
	$assign_list["display_name"] = $display_name;
	$assign_list["des"] = $des;
	$assign_list["status"] = $status;
	$assign_list["anonymous"] = $anonymous;
	$assign_list["config_info"] = $config["Info"];
	$assign_list["upddate"] = $upddate;
	$assign_list["leftpanel"] = $leftpanel;
	$assign_list["rightpanel"] = $rightpanel;
	$assign_list["clsModule"] = $clsModule;
	$assign_list["arrListBlock"] = $arrListBlock;
}

/**
*  Show detail an Item
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_detail(){
	global $assign_list;
}
?>