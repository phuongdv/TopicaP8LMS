<?
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
	var $_copyright 	=	"Topica Elearning System  &copy;2009 All Rights Reserved.";
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
			echo(DIR_MODULES."/$mod");
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
		if ($this->_SESS->loggedin==1){
			$clsUser = new User();
			$this->_USER = $clsUser->getOne($this->_SESS->id);
			$clsUserGroup = new UserGroup();
			$arrUserGroup = $clsUserGroup->getOne($this->_USER["user_group_id"]);
			$this->_PERMISS = @unserialize($arrUserGroup["access_permiss"]);
			$this->_isAdmin = ($arrUserGroup["name"]=="administrator");
			//print_r($this->_PERMISS);
			unset($clsUser);
			unset($clsUserGroup);
		}else{
			$this->_USER = array();
		}
		//print_r($this->_SESS);
		if ($_SITE_ROOT=="topica" && !$this->_SESS->loggedin && $mod!="_login"){
			header("location: ?$_SITE_ROOT&mod=_login");
			exit();
		}		
		
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
	
	//
	function stripUnicode($str=''){
		if(!$str) return false;
		$str = str_replace(array(' ','%',"/","\\",'"','?','<','>',"#","^","`","'","=","!",":" ,",,","..","*","__","▄"),array('-','' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'-','' ,'-','' ,'' ,'' , '', ''),html_entity_decode($str)); 
		
		$unicode = array(
			'a'=>'ä|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|Ä|À|�?|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ',
			'd'=>'�?|đ',
			'e'=>'è|é|ẹ|ẻ|ẽ|ê|�?|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ',
			'i'=>'ì|í|î|ị|ỉ|ĩ|Ì|�?|Ị|Ỉ|Ĩ',
			'o'=>'ö|ò|ó|�?|�?|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|�?|ớ|ợ|ở|ỡ|Ö|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|�?|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ',
			'u'=>'ü|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ü|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ',
			'y'=>'ỳ|ý|ỵ|ỷ|ỹ|Ỳ|�?|Ỵ|Ỷ|Ỹ'
		);
		
		$count = 0;		
		foreach($unicode as $nonUnicode=>$uni) 
			{
				$str = preg_replace("/($uni)/i",$nonUnicode,addslashes($str));
				$count++;
			}
		if($count>0)
			for($i=0; $i<$count; $i++)
				$str = stripslashes($str);
				
		$str = preg_replace("/&([a-z])[a-z]+;/i","$1",$str);
			
		return strtolower($str);
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
		//Them
	///////////////////////////////////////////////
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
	
	/*function replaceSpace($str) {
		$str_end = $this->convertToNormal($str);
		
		$str_find = "-";
		$str_find_replace="";
		if(preg_match("/".$str_find."/",$str_end))
		{
			$str_end = str_replace($str_find,$str_find_replace,$str_end);
		}
		$str_find = "  ";
		$str_find_replace=" ";
		if(preg_match("/".$str_find."/",$str_end))
		{
			$str_end = str_replace($str_find,$str_find_replace,$str_end);
		}
		$str_find = "\"";
		$str_find_replace="";
		if(preg_match("/".$str_find."/",$str_end))
		{
			$str_end = str_replace($str_find,$str_find_replace,$str_end);
		}
		$str_find = '[\W]';
		$str_find_replace="-";
		if(preg_match("/".$str_find."/",$str_end))
		{
			$str_end = str_replace($str_find,$str_find_replace,$str_end);
		}
		$str_find = ".";
		$str_find_replace="";
		if(preg_match("/".$str_find."/",$str_end))
		{
			$str_end = str_replace($str_find,$str_find_replace,$str_end);
		}
		$str_find = ":";
		$str_find_replace="";
		if(preg_match("/".$str_find."/",$str_end))
		{
			$str_end = str_replace($str_find,$str_find_replace,$str_end);
		}
		
		$str_find = "'";
		$str_find_replace="";
		if(preg_match("/".$str_find."/",$str_end))
		{
			$str_end = str_replace($str_find,$str_find_replace,$str_end);
		}
		
		$str_find = "-";
		$str_find_replace="";
		if(preg_match("/".$str_find."/",$str_end))
		{
			$str_end = str_replace($str_find,$str_find_replace,$str_end);
		}
		$str_find = "=";
		$str_find_replace="";
		if(preg_match("/".$str_find."/",$str_end))
		{
			$str_end = str_replace($str_find,$str_find_replace,$str_end);
		}
		$str_find = ",";
		$str_find_replace="";
		if(preg_match("/".$str_find."/",$str_end))
		{
			$str_end = str_replace($str_find,$str_find_replace,$str_end);
		}
		//
		$str_find = " ";
		$str_find_replace="-";
		if(preg_match("/".$str_find."/",$str_end))
		{
			$str_end = str_replace($str_find,$str_find_replace,$str_end);
		}
		
		$str_find = "?";
		$str_find_replace="";
		$str_end = str_replace($str_find,$str_find_replace,$str_end);
		
		
		
		return $str_end;
	}*/
	
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
	
	
	function replaceString($str, $str_find) {
		
		$str_encode = mb_strtolower($str,'utf-8');
		$str_find_encode = mb_strtolower($str_find,'utf-8'); 
		$str_find_replace = "<font color='white' style='background-color:blue; font-size:12px'>".$str_find."</font>";
		$str_find_replace_encode = mb_strtolower($str_find_replace,'utf-8');
		
		if(preg_match("/".$str_find_encode."/",$str_encode))
		{
			$str_encode = str_replace($str_find_encode,$str_find_replace_encode,$str_encode);		
		}
		
		return html_entity_decode(ucfirst($str_encode));
		
	}
	
	function getRandomChar(){
		$charset = "abcdefghijklmnopqrstuvwxyz"; 
		$length = strlen($charset)-1;
		$random_int = mt_rand(0, $length);
		return strtoupper($charset[$random_int]);
	}
	function getOneChar($num){
		$charset = "abcdefghijklmnopqrstuvwxyz"; 
		$str = $num.'';
		$t = $str[0];
		return strtoupper($charset[$t]);
	}
	
	function genRandomString($length) {
		$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$string = "";    
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
		return $string;
	}
	function getZendUrl($str,$num){
		$temp =  md5($str);
		$s = $num.'';
		$len = strlen($s);
		$ret = '';
		for ($i = 0; $i <= 6-$len; $i++) {
			$ret .= $temp[$i];
		}
		$f =  $this->getOneChar($num);
		return strtoupper($f.$ret);

	}
	
	//========================================
	//Function check so
	//========================================
	function checknumbermobile($mobile){
		$mobile = trim($mobile);
		$countStrSDT = strlen($mobile);
		if($countStrSDT>10){
			if($mobile != (string)(int)$mobile){
				return 0;
			}
			else
			{	
				$strSDT=substr($mobile,1,1);
				if($strSDT==1){		
					return 1;
				}
				else{
					return 0;
				}
			}
		}
		elseif($countStrSDT==10){
			if($mobile != (string)(int)$mobile){
				return 0;
			}
			else{
				$strSDT=substr($mobile,1,1);
				if($strSDT==9){
					return 1;
				}
				else {
					return 0;
				}
			}
		}
		else {			
			return 0;
		}
		
	}
	
	
	//End
}
//
class Session extends DbBasic{
	var $session_id		=	"";
	var $id		=	0;
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
		$this->id		=	0;
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
			$username = vnSessionGetVar("NVC_USERNAME");
			$encrypt_password = vnSessionGetVar("NVC_PASSWORD");		
			$clsUser = new User();
			//$clsUser->setDebug();
			$arrUser = $clsUser->getByCond("username='$username' && password='$encrypt_password'");
			//print_r($arrUser);
			
			if (!is_array($arrUser) || $arrUser["username"]!=$username){
				$this->loggedin==0;
				vnSessionSetVar("LOGGEDIN", 0);
				vnSessionSetVar("NVC_USERNAME", "");
				vnSessionSetVar("NVC_PASSWORD", "");
				if (is_array($arrSession))
					$this->updateOne($this->session_id, "loggedin=0");
			}else{
				$this->id = $arrUser["id"];
			}
			unset($clsUser);			
			if (!is_array($arrSession) || $arrSession["session_id"]!=$this->session_id){
				$fields = "session_id, id, ip_address,running_time, loggedin";
				$values = "'".$this->session_id."', '".$this->id."', '".$this->ip_address."', 
							'".$this->running_time."', '".$this->loggedin."'";
				$this->insertOne($fields, $values);
				/*if (class_exists("Stats")){
					$clsStats = new Stats();
					$set = "total_visitor = total_visitor +1";
					$clsStats->updateByCond("", $set);
					unset($clsStats);		
				}*/
			}else{
				$set = "id='".$this->id."', ip_address='".$this->ip_address."', 
							running_time='".$this->running_time."', loggedin='".$this->loggedin."'";
				$this->updateOne($this->session_id, $set);
			}
		}else{
			$arrSession = $this->getOne($this->session_id);
			if (!is_array($arrSession) || $arrSession["session_id"]!=$this->session_id){
				$fields = "session_id, id, ip_address,running_time, loggedin";
				$values = "'".$this->session_id."', '".$this->id."', '".$this->ip_address."', 
							'".$this->running_time."', '".$this->loggedin."'";
				$this->insertOne($fields, $values);
				
				/*if (class_exists("Stats")){
					$clsStats = new Stats();
					$set = "total_visitor = total_visitor +1";
					$clsStats->updateByCond("", $set);
					unset($clsStats);						
				}*/	
			}else{
				$set = "id='".$this->id."', ip_address='".$this->ip_address."', 
							running_time='".$this->running_time."', loggedin='".$this->loggedin."'";
				$this->updateOne($this->session_id, $set);
			
			}			
		}		
		$this->killTimeOut();
	}
	//
	function doLogin($username="", $password=""){
		vnSessionSetVar("LOGGEDIN", 1);
		vnSessionSetVar("NVC_USERNAME", $username);
		vnSessionSetVar("NVC_PASSWORD", $password);
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
		$this->deleteByCond("running_time+$SESSION_TIME_OUT<".$this->running_time."");
	}
	//
	function isLoggedin(){
		return $this->loggedin;
	}
	//
	function checkUser($username="", $password=""){
		if ($username!="" && $password!=""){
			$clsUser = new User();
			//$encrypt_password = User::encrypt($password);
			$arrUser = $clsUser->getByCond("username='$username' && password='$password'");
			unset($clsUser);
			return (is_array($arrUser) && $arrUser["username"]==$username);
		}
		return 1;
	}
}
?>