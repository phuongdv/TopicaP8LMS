<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
if (!defined("DIR_MODULES")){
	trigger_error("Cannot find constant 'DIR_MODULES'", E_USER_ERROR);	
	die();
}
/**
*  Class Module Driver
*  @author		: Tran Anh Tuan
*  @date		: 2007/04/01
*  @version		: 2.1.0
*/
class Module extends DbBasic{
	var $mod = "";//name of module
	var $path = DIR_MODULES;//path to module file
	var $arrSub = array();//array submod of module
	var $arrAct = array();//array action of submod
	var $errNo = 0;//error code
	var $requireLogin = 0;//0 is no need log in
	//function
	function Module($_mod="", $_path=""){	
		$this->pkey = "moduleid";
		$this->tbl = "module";
		if ($_mod!="")
			$this->mod = $_mod;
		if ($_path!="")
			$this->path = $_path;
		if (!is_dir($this->path."/".$this->mod)){
			//ModuleFolder is not exists
			trigger_error("Module Folder is not exists!", E_USER_ERROR);
			exit();
		}
	}
	//function
	function addSub($sub){
		array_push($this->arrSub, $sub);
		$this->arrAct[$sub] = array();
	}
	//function
	function addAct($sub, $act){
		array_push($this->arrAct[$sub], $act);
	}
	//function
	function existsSub($sub){
		return in_array($sub, $this->arrSub);
	}
	//function
	function existsAct($sub, $act){
		return in_array($act, $this->arrAct[$sub]);
	}
	//function
	function run($sub="default", $act="default"){
		$this->addSub($sub);
		$this->addAct($sub, $act);
		if ($this->existsSub($sub) && $this->existsAct($sub, $act)){
			$file_mod_sub = $this->path."/".$this->mod."/sub_".$sub.".php";			
			if (file_exists($file_mod_sub)){
				require_once($file_mod_sub);
				$funcdef = $sub."_default";
				$func = $sub."_".$act;
				if (function_exists($func)){
					$func();//call function sub_act()
				}else
				if (function_exists($funcdef)){
					$funcdef();//call function sub_default()
				}else{
					//function sub_act() is not installed
					trigger_error("SubModule is not found!", E_USER_ERROR);
					exit();					
				}
			}else{
				//SubModule file is not exists	
				trigger_error("ModuleFile is not found!", E_USER_ERROR);
				exit();					
			}
		}else{
			//not exists act of sub or act is not registered to sub
			trigger_error("This Module did not install!", E_USER_ERROR);
			exit();					
		}
	}
	//function
	function getAllModule($site="root"){
		if ($site=="") return array();
		//List of module in DB
		if (is_array($site)){
			$arr = array();
			foreach ($site as $k => $v){
				$arr1 = $this->getAllModule($v);
				$arr[$v] = $arr1[$v];
			}
			return $arr;
		}else{
			$arr1 = array();
			$dir = NVCMS_DIR."/www/".$site."/modules";
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." && is_dir($dir."/$file") && file_exists($dir."/".$file."/index.php")) {
						//if ($file[0]!="_"){
							array_push($arr1, $file);							
						//}
					}
				}
				closedir($handle);
			}		
			$arr[$site] = $arr1;
			return $arr;
		}
	}
	//function
	function getAllBlock($site="root"){
		if ($site=="") return array();
		//List of module in DB
		if (is_array($site)){
			$arr = array();
			foreach ($site as $k => $v){
				$arr1 = $this->getAllBlock($v);
				$arr[$v] = $arr1[$v];
			}
			return $arr;
		}else{
			$arr1 = array();
			$dir = NVCMS_DIR."/www/".$site."/blocks";
			if (!is_dir($dir)){
				return $arr1;
			}
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." && is_file($dir."/$file")) {
						if (strpos($file, "block")!==false){
							$arrB = array();
							$arrB["name"] = substr($file, 6, -4);
							if (strpos($file, "right")!==false){
								$arrB["position"] = "R";
							}else{
								$arrB["position"] = "L";
							}							
							$arrB["status"] = "OFF";
							$arrB["content"] = "";
							array_push($arr1, $arrB);
						}
					}
				}
				closedir($handle);
			}	
			$arr[$site] = $arr1;
			return $arr;
		}	
	}	
	//function
	function getAllBlockDB($site="root"){
		if ($site=="") return array();
		//List of module in DB
		if (is_array($site)){
			$arr = array();
			foreach ($site as $k => $v){
				$arr1 = $this->getAllBlock($v);
				$arr[$v] = $arr1[$v];
			}
			return $arr;
		}else{
			$arr1 = array();
			$clsBlock = new Block();
			$arrListBlock = $clsBlock->getAll("site='$site' AND status='ON' ORDER BY order_no ASC");
			if (is_array($arrListBlock)){
				foreach ($arrListBlock as $key => $val){
					$arrB = array();
					$arrB["name"] = $val["name"];
					$arrB["display_name"] = $val["display_name"];
					$arrB["position"] = $val["position"];
					$arrB["status"] = "OFF";
					array_push($arr1, $arrB);
				}
				$arr[$site] = $arr1;		
			}	
			return $arr;
		}	
	}
	//function
	function getAllModuleNameFromDB(){
		global $dbconn;
		$res = $dbconn->GetAll("SELECT site, name, fsize FROM module");
		if (is_array($res)){
			$arr = array();
			foreach ($res as $k => $v){
				if (!is_array($arr[$v["site"]])){
					$arr[$v["site"]] = array();
				}
				$arr[$v["site"]][$v["name"]]['name'] = $v["name"];
				$arr[$v["site"]][$v["name"]]['fsize'] = $v["fsize"];
			}
		}
		//print_r($arr);
		return $arr;
	}
	//function
	function getAllModuleFromDB(){
		global $dbconn;
		$res = $dbconn->GetAll("SELECT * FROM module");
		if (is_array($res)){
			$arr = array();
			foreach ($res as $k => $v){
				if (!is_array($arr[$v["site"]])){
					$arr[$v["site"]] = array();
				}
				$arr[$v["site"]][$v["name"]] = $v;
			}
		}
		//print_r($arr);
		return $arr;	
	}
	//function
	function reSyncModule($arrListSite="", $arrListModule=""){
		global $dbconn;
		$arrListModuleNameDB = $this->getAllModuleNameFromDB();
		//print_r($arrListModuleNameDB);
		if (is_array($arrListSite) && is_array($arrListModule))
		foreach ($arrListSite as $k => $site){
			foreach ($arrListModule[$site] as $k1 => $mod){
				$fname = NVCMS_DIR."/www/$site/modules/$mod/mod.ini.php";
				if ($arrListModuleNameDB[$site][$mod]['name']!=""){//Not in db
					$fsize = @filesize($fname);
					$arrModule = $this->getByCond("site='$site' AND name='$mod'");
					$oldconfig = @unserialize($arrModule["config"]);
					if ($arrListModuleNameDB[$site][$mod]['fsize']!=$fsize){
						$config = array();
						if (file_exists($fname)){
							require_once($fname);
							if (isset($_MOD_INI)){
								$config = $_MOD_INI;
								unset($_MOD_INI);
							}														
							$display_name = ($config["Info"]["Display_Name"]!="")? $config["Info"]["Display_Name"] : ucfirst($mod);
							$des = ($config["Info"]["Description"]!="")? $config["Info"]["Description"] : "";
							$status = ($config["Info"]["Status"]!="")? $config["Info"]["Status"] : "Active";
							$anonymous = ($config["Info"]["Anonymous"]!="")? $config["Info"]["Anonymous"] : "YES";
							if ($site=="admin") $anonymous = "NO";
							$upddate = ($config["Info"]["Update"]!="")? strtotime($config["Info"]["Update"]) : time();
							foreach ($config["Info"] as $key => $val)
							if ($val!=""){
								$oldconfig["Info"][$key] = $val;
							}			
							$oldconfig = @serialize($oldconfig);				
							//insert DB
							$set = "display_name='$display_name', des = '$des', status='$status', anonymous='$anonymous', 
									fsize='$fsize', upddate='$upddate', config='$oldconfig'";						
							$sql = "UPDATE module set $set WHERE site='$site' AND name='$mod'";
							$dbconn->Execute($sql);
						}
					}
				}else{
					$config = array();
					if (file_exists($fname)){
						require_once($fname);
						if (isset($_MOD_INI)){
							$config = $_MOD_INI;
							unset($_MOD_INI);
						}														
					}
					$display_name = ($config["Info"]["Display_Name"]!="")? $config["Info"]["Display_Name"] : ucfirst($mod);
					$des = ($config["Info"]["Description"]!="")? $config["Info"]["Description"] : "";
					$status = ($config["Info"]["Status"]!="")? $config["Info"]["Status"] : "Active";
					$anonymous = ($config["Info"]["Anonymous"]!="")? $config["Info"]["Anonymous"] : "YES";
					if ($site=="admin") $anonymous = "NO";
					$upddate = ($config["Info"]["Update"]!="")? strtotime($config["Info"]["Update"]) : time();
					$configvalue = (is_array($config))? @serialize($config) : "";
					//save INI					
										
					$fsize = @filesize($fname);		
					//insert DB
					$fields = "site, `name`, display_name, des, status, anonymous, fsize, upddate, config";
					$values = "'$site', '$mod', '$display_name', '$des', '$status', '$anonymous', '$fsize', '$upddate', '$configvalue'";
					$sql = "INSERT INTO module($fields) VALUES($values)";
					$dbconn->Execute($sql);
					
				}			
			}
		}
	}
	//function
	function reSyncBlock($arrListSite="", $arrListBlock=""){
		$clsBlock = new Block();
		if (is_array($arrListSite))
		foreach ($arrListSite as $k => $site)
		if (is_array($arrListBlock[$site])){
			foreach ($arrListBlock[$site] as $k1 => $block){
				$name = $block["name"];
				$arrBlock = $clsBlock->getByCond("site='$site' && name='$name'");
				$type = 0;
				$display_name = ucfirst($name);
				$position = $block["position"];
				$order_no = $k1;
				$status = $block["status"];
				$content = $block["content"];
				$upddate = time();
				if (!is_array($arrBlock) && $arrBlock["name"]!=$name){
					$fields = "site, name, type, display_name, position, order_no, content, status, upddate";
					$values = "'$site', '$name', '$type', '$display_name', '$position', '$order_no', '$content', '$status', '$upddate'";
					$clsBlock->insertOne($fields, $values);
				}
			}
		}	
	}
	//function
	function makeOptions($status="ON", $arr="ON,OFF"){
		$arrOptions = explode(',', $arr);
		$hmtl = "";
		foreach ($arrOptions as $val){
			$selected = ($val==$status)? "selected" : "";
			$html.= "<option value='$val' $selected >$val</options>";
		}
		return $html;
	}
}
//class Block
class Block extends DbBasic{
	var $blockid = "";
	var $site = "";
	var $name = "";
	function Block(){
		$this->pkey = "blockid";
		$this->tbl = "block";
	}
}
?>