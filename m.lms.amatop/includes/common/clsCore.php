<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class Core{
	var $_HTTP_HOST;
	var $_REMOTE_ADDR;//IP
	var $_REMOTE_PORT;
	var $_SERVER_NAME;
	var $_SERVER_PORT;
	var $_SERVER_SIGNATURE;
	var $_CONFIG 		= 	array();
	var $_USER			= 	array();
	var $_SESS			=	"";
	var $_PERMISS		=	array();
	var $_isAdmin		=	"";
	var $_isMaster		=	"";
	var $_copyright 	=	"W2WCMS 3.6.8  &copy;2009-2010. All Rights Reserved.";
	//init
	function Core(){
		global $mod, $_SITE_ROOT;
		//check file 'install.php'
		if (file_exists("install.php")){
			trigger_error("Please remove file 'install.php' or rename it!", E_USER_WARNING);
			exit();
		}
		//check module $mod
		if (!file_exists(DIR_MODULES."/$mod")){
			trigger_error("ModuleFile is not found!", E_USER_ERROR);
			exit();
		}
		//$clsIniManager = new VnIniManager(DIR_MODULES."/".$mod."/mod.ini");
		//$this->_CONFIG = $clsIniManager->parse_ini();
		$clsModule = new Module();
		$arrModule = $clsModule->getByCond("site='$_SITE_ROOT' AND name='$mod'");
		$this->_CONFIG = array();
		if (is_array($arrModule)){
			$this->_CONFIG = @unserialize($arrModule["config"]);
		}else{
			if (file_exists(DIR_MODULES."/$mod/mod.ini.php"))
				require_once(DIR_MODULES."/$mod/mod.ini.php");
			$this->_CONFIG = $_MOD_INI;
		}
		unset($clsModule);
		//check logged in
		$this->_HTTP_HOST 			= $_SERVER['HTTP_HOST'];
		$this->_REMOTE_ADDR 		= $_SERVER['REMOTE_ADDR'];
		$this->_REMOTE_PORT 		= $_SERVER['REMOTE_PORT'];
		$this->_SERVER_NAME 		= $_SERVER['SERVER_NAME'];
		$this->_SERVER_PORT 		= $_SERVER['SERVER_PORT'];
		$this->_SERVER_SIGNATURE 	= $_SERVER['SERVER_SIGNATURE'];
		//session management
		$this->_SESS = new Session();
		$this->_SESS->setup();
		//
		if ($this->_SESS->loggedin==1){
			$clsUser = new User();
			$this->_USER = $clsUser->getOne($this->_SESS->user_id);			
			$clsUserGroup = new UserGroup();
			$arrUserGroup = $clsUserGroup->getOne($this->_USER["user_group_id"]);
			$this->_PERMISS = @unserialize($arrUserGroup["access_permiss"]); 
			$this->_isAdmin = ($arrUserGroup["name"]=="administrator");
			//print_r($this->_PERMISS);die();
			unset($clsUser);
			unset($clsUserGroup);
		}else{
			$this->_USER = array();
		}
		
		//if (!$this->validLicense() && $_GET['act']!="license" && $mod!="_login"){			
			/*$html = getErrorWarningBox(
"<b>Warning: Your License Key is INVALID or EXPIRED!</b>", 
"<li>Please email to: <a href='mailto:support@vietitech.com'>support@vietitech.com</a></li>
 <li>Website: <a href='http://www.vietitech.com'>www.vietitech.com</a></li>
 <li>Phone: (+84) 4 2452929</li>
				"
				);
			
			die($html);
			exit();*/
	//	}		
		
		/*if ($this->_SESS->loggedin==1){
			$clsUser = new User();
			$this->_USER = $clsUser->getOne($this->_SESS->user_id);
			$clsUserGroup = new UserGroup();
			$arrUserGroup = $clsUserGroup->getOne($this->_USER["user_group_id"]);
			$this->_PERMISS = @unserialize($arrUserGroup["access_permiss"]);
			$this->_isAdmin = ($arrUserGroup["name"]=="administrator");
			//print_r($this->_PERMISS);
			unset($clsUser);
			unset($clsUserGroup);
		}else{
			$this->_USER = array();
		}*/
		//print_r($this->_SESS);
		if ($_SITE_ROOT=="w2cms" && !$this->_SESS->loggedin && $mod!="_login"){
			$returnExp = "return=".base64_encode($_SERVER['QUERY_STRING']);
			header("location: ?$_SITE_ROOT&mod=_login&$returnExp");
			die();
			exit();
		}	
		$clsStats = new Stats();
		$currentStats = $this->_SESS->getOne(1);
		$max_online_day = time();
		$max_online_number = $this->_SESS->countItem();
		if ($currentStats['max_online_number']<$max_online_number){
			$clsStats->updateOne(1, "max_online_number='$max_online_number', max_online_day='$max_online_day'");
		}		
	}
	function validLicense($license="license.dat"){
		if (!file_exists(DIR_COMMON."/clsLicense.php")){
			return 0;
		}
		require_once(DIR_COMMON."/clsLicense.php");
		$clsPADL = new padl();
		$clsPADL->init(false);
		$clsPADL->BEGIN1 = "DO NOT CHANGE THIS KEY";
		$clsPADL->END1 = "DO NOT CHANGE THIS KEY";
		$clsPADL->_PAD = "-";		
		$dat_str = (!$str) ? @file_get_contents(NVCMS_DIR."/".$license) : $str;
		
		$data = $clsPADL->_unwrap_license($dat_str);
		
		$yourdomain = strtolower(str_replace("www.", "", $_SERVER['HTTP_HOST']));
		if ($yourdomain!=="vietitech.com"){
			if ($data["DOMAIN"]!==$yourdomain) return 0;
		}
		if ($data["VERSION"]!=$this->_version) return 0;
		if ($data["COPYRIGHT"]!=$this->_copyright) return 0;
		
		return $data['END_DATE'];
	}
	function isPower(){
		//return ($this->_USER["is_super"]=='1');
		return ($this->_USER["user_id"]=='1');
	}
	
	function getWidthLang($key){
		$str = $this->getLang($key);
		return strlen($str)*15;
	}
	function getLang($key){
		global $_LANG;
		if (strpos($key, " ")!==false){
			$arr = str_word_count($key, 1);
			foreach ($arr as $k => $v){
				$val = trim($v, "'?,");
				$trans= (isset($_LANG[$val]))? $_LANG[$val] : $val;
				$key = str_replace($val, $trans, $key);
				
			}
			return $key;
		}else{
			$val = trim($key, "'?,");
			$trans= (isset($_LANG[$val]))? $_LANG[$val] : $val;
			$key = str_replace($val, $trans, $key);
			return $key;
		}
		return $key;
	}
	
	function hasPermiss($module){	
		if ($this->isPower()) return 1;
		return ($this->_PERMISS[$module]==1);
	}
	
	function get_Lang($key){
		global $_LANG_ID,$dbconn;
		$clsLang = new _Lang();
		$key_upper = strtoupper($key);
		$oneLang = $dbconn->getAll("select * from _lang where upper(keyword)='$key_upper'");
		if($oneLang[0]["value_1"]!=""){
			if($oneLang[0]["is_html"]=="0"){
				if($_LANG_ID =='vi' || $_LANG_ID =='vn'){
				return strip_tags(html_entity_decode($oneLang[0]["value_1"]));	
				}
				else if($_LANG_ID == 'en'){
					return strip_tags(html_entity_decode($oneLang[0]["value_2"]));	
				}
				else if($_LANG_ID == 'fr'){
					return strip_tags(html_entity_decode($oneLang[0]["value_3"]));	
				}
				else if($_LANG_ID == 'it'){
					return strip_tags(html_entity_decode($oneLang[0]["value_4"]));	
				}
				else
					return 'unknow';
			}else{
				if($_LANG_ID =='vi' || $_LANG_ID =='vn'){
				return html_entity_decode($oneLang[0]["value_1"]);	
				}
				else if($_LANG_ID == 'en'){
					return html_entity_decode($oneLang[0]["value_2"]);	
				}
				else if($_LANG_ID == 'fr'){
					return strip_tags(html_entity_decode($oneLang[0]["value_3"]));	
				}
				else if($_LANG_ID == 'it'){
					return strip_tags(html_entity_decode($oneLang[0]["value_4"]));	
				}
				else
					return 'unknow';
			}
			
		}else
			return html_entity_decode($key);
	}
	function getImageLang($key="", $dir="bg1"){
		if ($key=="en"){
			$key = "en_".$key;
		}
		return URL_IMAGES."/$dir/".$key;
	}
	function isMaster(){
		return $this->isMaster;
	}
	//check is Admin
	function isAdmin(){
		return $this->_isAdmin;	
	}	
	function checkPermission($module, $roles = "" , $pkey) {
		
		$accept_action = false;
		
		$act = isset($_GET["act"])? trim($_GET["act"]) : "default";
		if(empty($roles)) {
			if($act == 'default') $roles = 'L';
			elseif($act == 'add' && (!isset($_GET[$pkey]))) $roles = 'A';
			elseif($act == 'add' && (isset($_GET[$pkey]) && intval($_GET[$pkey])>0)) $roles = 'E';
			elseif($act == 'delete') $roles = 'D';
		}
		
		if(!empty($this->_PERMISS[$module][$roles])) { $accept_action = true;}
		
		return $accept_action;
	}			
	//check exists template file
	function template_exists($template){
		global $smarty;
		return $smarty->template_exists($template);
	}
	//set Panel left, right
	function setPanel($position="L", $status="ON"){
		switch ($position){
			case "L"	:	$this->_CONFIG["Global"]["LeftPanel"] = $status; break;
			case "R"	:	$this->_CONFIG["Global"]["RightPanel"] = $status; break;
			case "LT"	:	$this->_CONFIG["Global"]["LeftTopPanel"] = $status; break;
			case "RT"	:	$this->_CONFIG["Global"]["RightTopPanel"] = $status; break;
			default		:	return 1;
		}
		
	}
	//
	function hasPanel($position="L"){
		switch ($position){
			case "L"	:	return ($this->_CONFIG["Global"]["LeftPanel"]=="ON"); break;
			case "R"	:	return ($this->_CONFIG["Global"]["RightPanel"]=="ON"); break;	
			case "LT"	:	return ($this->_CONFIG["Global"]["LeftTopPanel"]=="ON"); break;
			case "RT"	:	return ($this->_CONFIG["Global"]["RightTopPanel"]=="ON"); break;	
			default		:	return 1;
		}
	}
	//
	function showPanel($position="L"){
		switch ($position){
			case "L"	:	$html = $this->showPanelL(); break;
			case "R"	:	$html = $this->showPanelR(); break;
			case "LT"	:	$html = $this->showPanelLT(); break;
			case "RT"	:	$html = $this->showPanelRT(); break;
			default		:	$html = $this->showPanelL(); break;
		}
		return $html;
	}
	//
	function showPanelL(){
		$arrBlock = $this->_CONFIG["LeftPanel"];
		$html = "";
		if (is_array($arrBlock)){
			foreach ($arrBlock as $key => $val)
			if ($val=="ON"){
				$html .= $this->getBlock($key);
			}
		}
		return $html;
	}
	//
	function showPanelR(){
		$arrBlock = $this->_CONFIG["RightPanel"];
		$html = "";
		if (is_array($arrBlock)){
			foreach ($arrBlock as $key => $val)
			if ($val=="ON"){
				$html .= $this->getBlock($key);
			}
		}
		return $html;
	}
	//
	function showPanelLT(){
		$arrBlock = $this->_CONFIG["LeftTopPanel"];
		$html = "";
		if (is_array($arrBlock)){
			foreach ($arrBlock as $key => $val)
			if ($val=="ON"){
				$html .= $this->getBlock($key);
			}
		}
		return $html;
	}
	//
	function showPanelRT(){
		$arrBlock = $this->_CONFIG["RightTopPanel"];
		$html = "";
		if (is_array($arrBlock)){
			foreach ($arrBlock as $key => $val)
			if ($val=="ON"){
				$html .= $this->getBlock($key);
			}
		}
		return $html;
	}
	function getBlock($block_name="default"){
		global $smarty, $assign_list, $_SITE_ROOT;
		$file_block_name = DIR_BLOCKS."/block_".$block_name.".php";
		$file_block_temp = "blocks/block_".$block_name.".html";
		$html = "";
		if (file_exists($file_block_name)){
			require_once($file_block_name);
			$html = $smarty->fetch($file_block_temp);
		}else{
			$clsBlock = new Block();
			$arrBlock = $clsBlock->getByCond("site='$_SITE_ROOT' AND name='$block_name'");
			$html = "";
			if ($arrBlock["status"]=="ON"){
				$content = $arrBlock["content"];
				$content = (html_entity_decode($content));
				//$content = br2nl($content);
				$html.= $content;
			}
			unset($clsBlock);
		}
		return $html;
	}
	//
	function getSrc($src=""){
		if (strpos($src, "http")===false && strpos($src, "https")===false){
			if (file_exists(DIR_IMAGES."/".$src)){
				$src = URL_IMAGES."/".$src;
			}else
			if (file_exists(DIR_UPLOADS."/".$src)){
				$src = URL_UPLOADS."/".$src;
			}
			else
			if (file_exists(NVCMS_DIR."/".$src)){
				$src = NVCMS_URL."/".$src;
			}
		}
		return $src;
	}
	//
	function getAllSite(){
		$arr = array();
		$dir = NVCMS_DIR."/www";
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".."&& $file != "" && is_dir($dir."/$file") && file_exists($dir."/".$file."/index.php")) {
					array_push($arr, $file);
				}
			}
			closedir($handle);
		}
		return $arr;
	}
	
	function decodeURL($str) {
		if(empty($str)) return "";
		else
			return base64_decode($str);
	}
	
	function encodeURL($str) {
		if(empty($str)) return "";
		else
			return base64_encode($str);
	}
	
	function convertToNormal($doc) {
		$str = $this->addslash(html_entity_decode($doc));
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		$str = preg_replace("/( )/", ' ', $str);
		$str = $this->stripslash($str);
		return $str;
	}
	
	function addslash($doc) {
		return addslashes($doc);
	}
	
	function stripslash($doc) {
		return stripslashes($doc);
	}
	
	
	function stripUnicode($str) {
		if(!$str) return false;
		$str = str_replace(array('%',"/","\\",'"','?','<','>',"#","^","`","'","=","!",":" ,",,","..","*","&","__","▄",',','/','-',"”","“","́","̣","̀","̉","̃",".","–","…","(",")"),array('','','','','','','','','',"","",'','','','','','','','','',' ',' ','','','','','','','','','','','','',''),html_entity_decode(trim($str))); 
		
		$unicode = array(
			'a'=>'ä|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|Ä|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ',
			'd'=>'Đ|đ',
			'e'=>'è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ',
			'i'=>'ì|í|î|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ',
			'o'=>'ö|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ö|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ớ',
			'u'=>'ü|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ü|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ',
			'y'=>'ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ'	
		);
		
		$count = 0;
		foreach($unicode as $nonUnicode=>$uni) 
			{
				$str = preg_replace("/($uni)/i", $nonUnicode, addslashes($str));
				$count++;
			}
		if($count>0)
			for($i=0; $i<$count; $i++)
				$str = stripslashes($str);
				
		$str = preg_replace("/&([a-z])[a-z]+;/i","$1",$str);
		$str = preg_replace("/\s+/","-",$str);
			
		return strtolower($str);
	}
	
	function replaceSpace($str) {
		if(!$str) return false;
		$str = str_replace(array('%',"/","\\",'"','?','<','>',"#","^","`","'","=","!",":" ,",,","..","*","&","__","▄",',','/','-',"”","“","́","̣","̀","̉","̃",".","–","…","(",")"),array('','','','','','','','','',"","",'','','','','','','','','',' ',' ','','','','','','','','','','','','',''),html_entity_decode(trim($str))); 
		
		$unicode = array(
			'a'=>'ä|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|Ä|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ',
			'd'=>'Đ|đ',
			'e'=>'è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ',
			'i'=>'ì|í|î|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ',
			'o'=>'ö|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ö|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ớ',
			'u'=>'ü|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ü|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ',
			'y'=>'ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ'	
		);
		
		$count = 0;
		foreach($unicode as $nonUnicode=>$uni) 
			{
				$str = preg_replace("/($uni)/i", $nonUnicode, addslashes($str));
				$count++;
			}
		if($count>0)
			for($i=0; $i<$count; $i++)
				$str = stripslashes($str);
				
		$str = preg_replace("/&([a-z])[a-z]+;/i","$1",$str);
		$str = preg_replace("/\s+/","-",$str);
			
		return strtolower($str);
	}
	#END
	function anti_injection($campo)
	{
		//remove words that contains syntax sql
		$campo = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$campo);
	
		//Remove empty spaces
		$campo = trim($campo);
	
		 //Removes tags html/php
		$campo = strip_tags($campo);
	
		//Add inverted bars to a string
		$campo = addslashes($campo);
		return $campo; //Returns the the var clean
	}
	
	function stripUnicode2($str=''){
		if(!$str) return false;
		$str = str_replace(array('%',"/","\\",'"','?','<','>',"#","^","`","'","=","!",":" ,",,","..","*","&","__","▄",',','/','-',') ',' ('),array('','','','','','','','','',"","",'','','','','','','','','',' ',' ','-','',''),html_entity_decode(trim($str))); 
		
		$unicode = array(
			'a'=>'ä|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|Ä|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ',
			'd'=>'Đ|đ',
			'e'=>'è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ',
			'i'=>'ì|í|î|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ',
			'o'=>'ö|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ö|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ',
			'u'=>'ü|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ü|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ',
			'y'=>'ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ'	
		);
		//header('Content-type: text/html; charset=utf-8');
		$count = 0;
		foreach($unicode as $nonUnicode=>$uni) 
			{
				$str = preg_replace("/($uni)/i", $nonUnicode, addslashes($str));
				$count++;
			}
		if($count>0)
			for($i=0; $i<$count; $i++)
				$str = stripslashes($str);
				
		$str = preg_replace("/&([a-z])[a-z]+;/i","$1",$str);
		$str = preg_replace("/\s+/","-",$str);
			
		return strtolower($str);
	}
	
	function genRandomString($length) {
		$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$string = "";    
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
		return $string;
	}
	
	function formatNumber($strPrice) {
		$strPrice = trim($strPrice);
		
		if(strpos($strPrice,".")>0) {
			return $strPrice;
		}
		
		$j = (strlen($strPrice)-(strlen($strPrice)%3))/3;				
		for($i=1;$i<=$j;$i++) {
			$strPrice=substr_replace($strPrice,'.',(strlen($strPrice)-$i*3-$i+1),0);
		}
		if($strPrice[0]=='.') {
			$strPrice=substr($strPrice,1);
		}
		return $strPrice;
	}
	
	//Resize Image
	function makeimageupload($sourcefile, $endfile, $path, $thumbwidth, $thumbheight)
	{
		// Takes the sourcefile (path/to/image.jpg) and makes a thumbnail from it
		// and places it at endfile (path/to/thumb.jpg).
		//$quality = 100;
		// Load image and get image size.
		//print_r($path.$sourcefile);
		if(preg_match('/[.](jpg)$/', $path.$sourcefile)) {
			$quality = 100;
			$img = imagecreatefromjpeg($path.$sourcefile);
		} else if (preg_match('/[.](gif)$/', $fileurl)) {
			$quality = 100;
			$img = imagecreatefromgif($path.$sourcefile);	
		} else if (preg_match('/[.](png)$/', $fileurl)) {
			$quality = 0;
			$img = imagecreatefrompng($path.$sourcefile);
		}
		$width = imagesx( $img );
		$height = imagesy( $img );
		
		if ($width > $height) {
			$newwidth = $thumbwidth;
			$divisor = $width / $thumbwidth;
			$newheight = floor( $height / $divisor);
		}
		else {
			$newheight = $thumbheight;
			$divisor = $height / $thumbheight;
			$newwidth = floor( $width / $divisor );
		}
		
		// Create a new temporary image.
		$tmpimg = imagecreatetruecolor( $newwidth, $newheight );
		
		// Copy and resize old image into new image.
		imagecopyresampled( $tmpimg, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
		
		// Save thumbnail into a file.
		$file = $endfile.$sourcefile ;
		//print_r($path.$file);die();
		if(preg_match('/[.](jpg)$/', $path.$sourcefile)) {
			imagejpeg( $tmpimg, $path.$file, $quality);
		} else if (preg_match('/[.](gif)$/', $fileurl)) {
			imagegif( $tmpimg, $path.$file, $quality);	
		} else if (preg_match('/[.](png)$/', $fileurl)) {
			imagepng( $tmpimg, $path.$file, $quality);
		}
		
		
		
		// release the memory
		imagedestroy($tmpimg);
		imagedestroy($img);
	
	}
	
	function checkImageExist($root,$image){
		//die();
		$fileUrl = $root.'/'.$image;
		//print_r($fileUrl);
		$AgetHeaders = @get_headers($fileUrl);
		if (preg_match("|200|", $AgetHeaders[0])) {
			// file exists
			return 1;
		} else {
		// file doesn't exists
			return 0;
		}
	}
	
	function getPractive($c_id,$calendar_id) {
		global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
		
		$sql = "select active_id from huy_setting_lipe where c_id='$c_id' and calendar_id='$calendar_id' and lipe_type='P'";
		
		$res = $dbconn->getAll($sql);
		if(is_array($res) && count($res)>0)
			return $res[0]['active_id'];
		else
			return 0;
	}
	
	function getExam($c_id,$calendar_id) {
		global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
		
		$sql = "select active_id from huy_setting_lipe where c_id='$c_id' and calendar_id='$calendar_id' and lipe_type='E'";
		
		$res = $dbconn->getAll($sql);
		if(is_array($res) && count($res)>0)
			return $res[0]['active_id'];
		else
			return 0;
	}
	
	function getCalendar($week,$c_id) {
		global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
		
		$sql = "select id,week_name,start_date,end_date from huy_setting_calendar where week_name like '%$week%' and c_id='$c_id'";
		
		$res = $dbconn->getAll($sql);
		//print_r($res);
		if(is_array($res) && count($res)>0)
			return $res;
		else
			return 0;
	}
	function getInfoWeek($table,$week){
		global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
		$sql = "select * from $table where `week`=$week";
		$res = $dbconn->getAll($sql);
		if(is_array($res) && count($res)>0)
			return $res;
		else
			return 0;
	}
	
}
//
class Session extends DbBasic{
	var $session_id		=	"";
	var $user_id		=	0;
	var $ip_address		=	"";
	var $running_time	=	"";
	var $loggedin		=	"";
	var $timeout		=	0;
	function Session(){
		$this->pkey = "session_id";
		$this->tbl 	= "session";
	}	
	//
	function setup(){
		global $SESSION_TIME_OUT, $_SITE_ROOT;
		$this->session_id 	= 	session_id();
		$this->ip_address 	= 	$_SERVER['REMOTE_ADDR'];
		$this->running_time	=	time();
		$this->loggedin		=	0;
		$this->user_id		=	0;
		if (vnSessionExist("LOGGEDIN")){
			$this->loggedin = vnSessionGetVar("LOGGEDIN");
		}
		$arrSession = $this->getOne($this->session_id);
		if (is_array($arrSession) && $arrSession["loggedin"]=1 && $arrSession["running_time"]+$SESSION_TIME_OUT-5<$this->running_time){
			$this->timeout = 1;
			$this->loggedin==0;
			vnSessionSetVar("LOGGEDIN", 0);
			vnSessionSetVar("NVC_USERNAME", "");
			vnSessionSetVar("NVC_PASSWORD", "");
			if (is_array($arrSession))
				$this->updateOne($this->session_id, "loggedin=0");
			echo "	<script language='javascript'>
					alert('Your session has expired!');
					window.location.href='?$_SITE_ROOT&mod=_login'
					</script>";
		}
		if ($this->loggedin==1){
			$user_name = vnSessionGetVar("NVC_USERNAME");
			$encrypt_password = vnSessionGetVar("NVC_PASSWORD");		
			$clsUser = new User();
			//$clsUser->setDebug();
			$arrUser = $clsUser->getByCond("user_name='$user_name' && user_pass='$encrypt_password'");
			//print_r($arrUser);
			
			if (!is_array($arrUser) || $arrUser["user_name"]!=$user_name){
				$this->loggedin==0;
				vnSessionSetVar("LOGGEDIN", 0);
				vnSessionSetVar("NVC_USERNAME", "");
				vnSessionSetVar("NVC_PASSWORD", "");
				if (is_array($arrSession))
					$this->updateOne($this->session_id, "loggedin=0");
			}else{
				$this->user_id = $arrUser["user_id"];
			}
			unset($clsUser);			
			if (!is_array($arrSession) || $arrSession["session_id"]!=$this->session_id){
				$fields = "session_id, user_id, ip_address,running_time, loggedin";
				$values = "'".$this->session_id."', '".$this->user_id."', '".$this->ip_address."', 
							'".$this->running_time."', '".$this->loggedin."'";
				$this->insertOne($fields, $values);
				if (class_exists("Stats")){
					$clsStats = new Stats();
					$set = "total_visitor = total_visitor +1";
					$clsStats->updateByCond("", $set);
					unset($clsStats);		
				}
			}else{
				$set = "user_id='".$this->user_id."', ip_address='".$this->ip_address."', 
							running_time='".$this->running_time."', loggedin='".$this->loggedin."'";
				$this->updateOne($this->session_id, $set);
			}
		}else{
			$arrSession = $this->getOne($this->session_id);
			if (!is_array($arrSession) || $arrSession["session_id"]!=$this->session_id){
				$fields = "session_id, user_id, ip_address,running_time, loggedin";
				$values = "'".$this->session_id."', '".$this->user_id."', '".$this->ip_address."', 
							'".$this->running_time."', '".$this->loggedin."'";
				$this->insertOne($fields, $values);
				
				if (class_exists("Stats")){
					$clsStats = new Stats();
					$set = "total_visitor = total_visitor +1";
					$clsStats->updateByCond("", $set);
					unset($clsStats);							
				}
			}else{
				$set = "user_id='".$this->user_id."', ip_address='".$this->ip_address."', 
							running_time='".$this->running_time."', loggedin='".$this->loggedin."'";
				$this->updateOne($this->session_id, $set);
			
			}			
		}		
		
		$this->killTimeOut();
	}
	//
	function doLogin($user_name="", $user_pass=""){
		vnSessionSetVar("LOGGEDIN", 1);
		vnSessionSetVar("NVC_USERNAME", $user_name);
		vnSessionSetVar("NVC_PASSWORD", User::encrypt($user_pass));
	}
	//
	function doLogout(){
		vnSessionDelVar("LOGGEDIN");
		vnSessionDelVar("NVC_USERNAME");
		vnSessionDelVar("NVC_PASSWORD");
	}
	//
	function killTimeOut(){
		global $SESSION_TIME_OUT;
		//$this->setDebug();
		$this->deleteByCond("running_time+$SESSION_TIME_OUT<".$this->running_time."");
	}
	//
	function isLoggedin(){
		return $this->loggedin;
	}
	//
	function checkUser($user_name="", $user_pass=""){
		if ($user_name!="" && $user_pass!=""){
			$clsUser = new User();
			$encrypt_password = User::encrypt($user_pass);
			$arrUser = $clsUser->getByCond("user_name='$user_name' && user_pass='$encrypt_password' && is_active='1'");
			unset($clsUser);
			return (is_array($arrUser) && $arrUser["user_name"]==$user_name);
		}
		return 1;
	}
	
}
?>