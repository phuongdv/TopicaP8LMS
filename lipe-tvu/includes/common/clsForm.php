<?
/*
Type of Input : Text, Select, Radio, Checkbox, File, TextAres
*/
define(NVCMS_ERROR_NULL, 	"<li>'#NAME#' is empty!</li>");
define(NVCMS_ERROR_LENGTH, 	"<li>'#NAME#' is too long, Max length is #MAX_LEN#!</li>");
define(NVCMS_ERROR_FORMAT, 	"<li>'#NAME#' is not correct format of #TYPE#!</li>");
define(NVCMS_ERROR_INSERT,	"<li>Can not insert to database!</li>");
define(NVCMS_ERROR_UPDATE,	"<li>Can not update to database!</li>");
class Form{
	var $formName 		= 	"theForm";
	var $title			=	"Title";
	var $fields			= 	array();
	var $inputs 		=	array();
	var $arr_hint		=	array();
	var $totalInputs 	= 	0;
	var $method 		= 	"";
	var $strJS			=	"";
	//
	var $isValid 		=	1;
	var $errorStr		=	"";
	//
	var $table			=	"";
	var $pkey 			= 	"";
	var $pval 			=	"";
	var $record			=	"";
	//
	var $isShowHD		=	0;//check for show Hidden Data
	var $isShowJSDate	=	0;
	var $isShowJSEditor	=	0;
	//
	var $showBgColor	=	1;
	//
	var $textAreaType	=	"simple";
	//
	function Form($_formName="", $_method=""){
		if ($_formName!="") $this->formName = $_formName;
		if ($_method!="") $this->method = $_method;
		$this->errorStr = "";
		$this->strJS = "
			<script language='javascript'>
			function save(){
				document.".$this->formName.".btnSave.value= \"Save\";
				document.".$this->formName.".submit();
			}
			</script>"."\n";
	}
	//function
	function setDbTable($_table, $_pkey="", $_pval=""){
		global $dbconn;
		$this->table = $_table;
		$this->pkey = $_pkey;
		$this->pval = $_pval;
		if ($_pval!=""){
			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->pkey."='".$this->pval."'";
			$this->record = $dbconn->GetRow($sql);
		}
	}	
	//function
	function getFieldValue($colname){
		return $this->record[$colname];
	}
	//function
	function setTitle($_title){
		$this->title = $_title;
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
	//function
	function getTitle(){
		return $this->title;
	}
	//function
	function setMethod($_method){
		$this->method = $_method;
	}
	//function
	function setShowErrorWithBgColor($_showBgColor){
		$this->showBgColor = $_showBgColor;
	}
	//function
	function setFormName($_formName){
		$this->formName = $_formName;
	}
	//function
	function setTextAreaType($_type=""){
		$this->textAreaType = $_type;
	}
	//function	
	function addStrJS($_strJS){
		$this->strJS.= $_strJS;
	}
	//function
	function addField($field){
		array_push($this->fields, $field);
	}
	
	function addHint($colname="", $hint=""){
		$this->arr_hint[$colname] = $hint;
	}
	//function
	function addFieldString($fieldStr=""){
		if (strpos($fieldStr, ",")!==false){
			$arr = explode(',', $fieldStr);
			if (is_array($arr))
			foreach ($arr as $key => $val){
				array_push($this->fields, trim($val));
			}
		}
	}
	//Text
	function addInputText($colname, $value="", $coltitle="", $len="", $allowNull=0, $attr=""){
		if (coltitle=="") $coltitle = $colname;
		if ($this->pkey!="" && $this->pval!="") $value = $this->record[$colname];
		$this->inputs[] = array("colname"=>$colname, "value"=>$value, "coltitle"=>$coltitle, "coltype"=>"text", 
								"len"=>$len, "allowNull"=>$allowNull, "attr"=>$attr, "errNo" => 0, "errStr"	=>	""
								);
		$this->totalInputs++;
	}
	//Password
	function addInputPassword($colname, $value="", $coltitle="", $len="", $allowNull=0, $attr=""){
		if (coltitle=="") $coltitle = $colname;
		if ($this->pkey!="" && $this->pval!="") $value = $this->record[$colname];
		$this->inputs[] = array("colname"=>$colname, "value"=>$value, "coltitle"=>$coltitle, "coltype"=>"password", 
								"len"=>$len, "allowNull"=>$allowNull, "attr"=>$attr, "errNo" => 0, "errStr"	=>	""
								);
		$this->totalInputs++;
	}
	//TextArea
	function addInputTextArea($colname, $value="", $coltitle="", $len="", $cols=10, $rows=5, $allowNull=0, $attr=""){
		if (coltitle=="") $coltitle = $colname;
		if ($this->pkey!="" && $this->pval!="") $value = $this->record[$colname];
		$this->inputs[] = array("colname"=>$colname, "value"=>$value, "coltitle"=>$coltitle, "coltype"=>"textarea", 
								"len"=>$len, "cols"=>$cols, "rows"=>$rows,
								"allowNull"=>$allowNull, "attr"=>$attr, "errNo" => 0, "errStr"	=>	""
								);
		$this->totalInputs++;
	}
	//Number
	function addInputNumber($colname, $value="", $coltitle="", $len="", $allowNull=0, $attr=""){
		if (coltitle=="") $coltitle = $colname;
		if ($this->pkey!="" && $this->pval!="") $value = $this->record[$colname];
		$this->inputs[] = array("colname"=>$colname, "value"=>$value, "coltitle"=>$coltitle, "coltype"=>"number", 
								"len"=>$len, "allowNull"=>$allowNull, "attr"=>$attr, "errNo" => 0, "errStr"	=>	""
								);
		$this->totalInputs++;
	}
	//Url
	function addInputUrl($colname, $value="", $coltitle="", $len="", $allowNull=0, $attr=""){
		if (coltitle=="") $coltitle = $colname;
		if ($this->pkey!="" && $this->pval!="") $value = $this->record[$colname];
		$this->inputs[] = array("colname"=>$colname, "value"=>$value, "coltitle"=>$coltitle, "coltype"=>"url", 
								"len"=>$len, "allowNull"=>$allowNull, "attr"=>$attr, "errNo" => 0, "errStr"	=>	""
								);
		$this->totalInputs++;
	}
	//Email
	function addInputEmail($colname, $value="", $coltitle="", $len="", $allowNull=0, $attr=""){
		if (coltitle=="") $coltitle = $colname;
		if ($this->pkey!="" && $this->pval!="") $value = $this->record[$colname];
		$this->inputs[] = array("colname"=>$colname, "value"=>$value, "coltitle"=>$coltitle, "coltype"=>"email", 
								"len"=>$len, "allowNull"=>$allowNull, "attr"=>$attr, "errNo" => 0, "errStr"	=>	""
								);
		$this->totalInputs++;
	}
	//Date
	function addInputDate($colname, $value="", $coltitle="", $format="%m/%d/%Y %H:%M", $showTime=1, $allowNull=0, $attr="style='width:110px'"){
		if (coltitle=="") $coltitle = $colname;
		if ($this->pkey!="" && $this->pval!="") $value = $this->record[$colname];
		
		
		$this->inputs[] = array("colname"=>$colname, "value"=>$value, "coltitle"=>$coltitle, "coltype"=>"date", 
								"format"=>$format, "showTime"=>$showTime, "allowNull"=>$allowNull, "attr"=>$attr);
		$this->totalInputs++;
	}
	//Hidden
	function addInputHidden($colname, $value=""){
		//if ($this->pkey!="" && $this->pval!="") $value = $this->record[$colname];
		$this->inputs[] = array("colname"=>$colname, "value"=>$value, "coltype"=>"hidden");
		$this->totalInputs++;	
	}
	//Select
	function addInputSelect($colname, $value="", $coltitle="", $arrOptions, $valueSameOption=0, $attr=""){
		if (coltitle=="") $coltitle = $colname;
		if ($this->pkey!="" && $this->pval!="") $value = $this->record[$colname];
		$this->inputs[] = array("colname"=>$colname, "value"=>$value, "coltitle"=>$coltitle, "coltype"=>"select", "attr"=>$attr, "arrOptions" => $arrOptions, "valueSameOption"=> $valueSameOption, "attr"=>$attr);
		$this->totalInputs++;	
	}
	//File
	function addInputFile($colname, $value="", $coltitle="", $filetypes="jpg,gif,jpeg,rar,zip,doc,xsl,exe,txt,ppt,pdf", $allowNull=0, $attr=""){
		if (coltitle=="") $coltitle = $colname;
		if ($this->pkey!="" && $this->pval!="") $value = $this->record[$colname];
		$this->inputs[] = array("colname"=>$colname, "value"=>$value, "coltitle"=>$coltitle, "coltype"=>"file", 
								"filetypes"=>$filetypes, "allowNull"=>$allowNull, "attr"=>$attr);
		$this->totalInputs++;
	}
	//function
	function addInputCustom($colname, $value){
		//if ($this->pkey!="" && $this->pval!="") $value = $this->record[$colname];
		$this->inputs[] = array("colname"=>$colname, "value"=>$value, "coltype"=>"custom");
		//print_r($this->inputs[$this->totalInputs]);
		$this->totalInputs++;
	}
	//function
	function getInput($colname){
		if (is_array($this->inputs))
		foreach ($this->inputs as $val)
		if ($val["colname"]==$colname){
			return $val;
		}	
		return 0;
	}
	//function
	function getAllError(){
		return $this->errorStr;
	}
	//function
	function getErrorNo($colname){
		$input = $this->getInput($colname);
		return $input["errNo"];
	}
	//function
	function showInputText($input){
		$name = $input["colname"];
		$value = $input["value"];
		$attr = $input["attr"];
		$len = $input["len"];
		$html = "<input type=\"text\" name=\"$name\" id=\"$name\" maxlength=\"$len\" value=\"$value\" $attr />\n";
		return $html;
	}
	//function
	function showInputPassword($input){
		$name = $input["colname"];
		$value = $input["value"];
		$attr = $input["attr"];
		$len = $input["len"];
		$html = "<input type=\"password\" name=\"$name\" id=\"$name\" maxlength=\"$len\" value=\"$value\" $attr />\n";
		return $html;
	}
	//function
	function showInputTextAreaFCK($input){
		$name = $input["colname"];
		$value = $input["value"];
		$attr = $input["attr"];
		$len = $input["len"];
		$html.= "<textarea rows=\"$this->rows\" cols=\"$this->cols\" name=\"$name\" id=\"$name\" $attr>$value</textarea>";
		if ($this->isShowJSEditor==0) $this->isShowJSEditor = 1;
		return $html;		
	}
	//function
	function showInputTextArea($input){
		return showInputTextAreaTinyMCPuk($input);
	}
	//function
	function showInputTextAreaTinyMCPuk($input){
		$html = "";
		if ($this->isShowJSEditor==0 && $this->textAreaType!=""){
			$html.= "<!-- TinyMCE -->\n";
			$html.= "<script language=\"javascript\" src=\"".NVCMS_URL."/includes/tinymcpuk/tiny_mce.js\"></script>\n";
			$html.= "<script language=\"javascript\">\n";
			$html.= 'tinyMCE.init({
		mode : "textareas",
		theme : "'.$this->textAreaType.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,paste,directionality,fullscreen,noneditable,contextmenu,simplebrowser",
		theme_advanced_buttons1_add_before : "",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect,flash,preview,forecolor,backcolor",
		theme_advanced_buttons2_add : "flash,fullscreen",
		theme_advanced_buttons2_add_before: "",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "hr[class|width|size|noshade]",
		file_browser_callback : "TinyMCE_simplebrowser_browse",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		plugin_simplebrowser_width : "600", 
		plugin_simplebrowser_height : "400", 
		plugin_simplebrowser_browselinkurl : "' .NVCMS_URL.'/includes/tinymcpuk/plugins/simplebrowser/browser.html?Connector=connectors/php/connector.php",
		plugin_simplebrowser_browseimageurl :"' .NVCMS_URL.'/includes/tinymcpuk/plugins/simplebrowser/browser.html?Type=Image&Connector=connectors/php/connector.php",
		plugin_simplebrowser_browseflashurl : "' .NVCMS_URL.'/includes/tinymcpuk/plugins/simplebrowser/browser.html?Type=Flash&Connector=connectors/php/connector.php",
		apply_source_formatting : true
	});'."\n";
			$html.= '
	function fileBrowserCallBack(field_name, url, type, win) {
		var connector = "'.NVCMS_URL.'/includes/tinymcpuk/filemanager/browser.html?Connector=connectors/php/connector.php";
		var enableAutoTypeSelection = true;
		var cType;
		tinymcpuk_field = field_name;
		tinymcpuk = win;
		switch (type) {
			case "image":
				cType = "Image";
				break;
			case "flash":
				cType = "Flash";
				break;
			case "file":
				cType = "File";
				break;
		}
		if (enableAutoTypeSelection && cType) {
			connector += "&Type=" + cType;
		}		
		window.open(connector, "tinymcpuk", "modal,width=600,height=400");
	}'."\n";
			$html.= "</script>\n";
			$html.= "<!-- /TinyMCE -->\n";
			$html.= "\n";
		}
		$name = $input["colname"];
		$value = $input["value"];
		$attr = $input["attr"];
		$len = $input["len"];
		$html.= "<textarea rows=\"".$input["rows"]."\" cols=\"".$input["cols"]."\" name=\"$name\" id=\"$name\" $attr>$value</textarea>";
		if ($this->isShowJSEditor==0) $this->isShowJSEditor = 1;
		return $html;	
	}
	//function
	function showInputNumber($input){
		$name = $input["colname"];
		$value = $input["value"];
		$attr = $input["attr"];
		$len = $input["len"];
		$html = "<input type=\"text\" name=\"$name\" id=\"$name\" maxlength=\"$len\" value=\"$value\" $attr />\n";
		return $html;
	}
	//function
	function showInputEmail($input){
		$name = $input["colname"];
		$value = $input["value"];
		$attr = $input["attr"];
		$len = $input["len"];
		$html = "<input type=\"text\" name=\"$name\" id=\"$name\" maxlength=\"$len\" value=\"$value\" $attr />\n";
		return $html;
	}
	//function
	function showInputUrl($input){
		$name = $input["colname"];
		$value = $input["value"];
		$attr = $input["attr"];
		$len = $input["len"];
		$html = "<input type=\"text\" name=\"$name\" id=\"$name\" maxlength=\"$len\" value=\"$value\" $attr />\n";
		return $html;
	}
	//function
	function showInputSelect($input){
		$arrOptions = $input["arrOptions"];
		$name = $input["colname"];	
		$value = $input["value"];	
		$attr = $input["attr"];
		$valueSameOption = $input["valueSameOption"];
		$html = "<select name=\"$name\" $attr >\n";
		if (is_array($arrOptions)){
			foreach ($arrOptions as $key => $val){
				$val1 = ($valueSameOption==1)? $val : $key;
				$selected = ($val1==$value)? "selected" : "";
				$html.= "<option value='$val1' $selected >$val</option>\n";
			}
		}
		$html.= "</select>\n";
		return $html;
	}
	//function
	function showInputHidden($input){
		$name = $input["colname"];
		$value = $input["value"];
		$html = "<input type=\"hidden\" name=\"$name\" id=\"$name\" value=\"$value\"/>\n";
		return $html;		
	}
	
	function showInputFile($input){
		require_once(NVCMS_DIR."/dialogs/dialog.inc.php");
		
		$sid = session_id();
		$name = $input["colname"];	
		$value = $input["value"];	
		$attr = $input["attr"];
		//------------------------------
		$maxFileSize = 1024*1024*2;//2MB
		$dialog=new DIALOG(DIR_UPLOADS); 
		$dialog->setBaseDir(NVCMS_URL."/dialogs"); // path/to/dialog folder
		$dialog->setFileType($input["filetypes"]);
		$dialog->setInputName($name);
		$dialog->setMaxFileSize($maxFileSize); 
		$strJS = "<script language='javascript'>\n";
		$strJS.= "function openFile_".$name."(value){\n";
		$strJS.= "	if (document.theForm.".$name."){\n";
		$strJS.= "		document.theForm.".$name.".value = value;\n";
		$strJS.= "	}else{\n";
		$strJS.= "		document.getElementById(".$name.").value = value;\n";
		$strJS.= "	}\n";
		$strJS.= "}\n";
		$strJS.= "</script>\n";
		$html = "";
		$html.= $strJS;
		$html.= "<input type='text' id='$name' name='$name' value='$value' $attr>";
		$html.= "&nbsp;".$dialog->showDialog("",$sid)."\n";
		$readonly = ($input["allowNull"]==1)? "" : "disabled";
		/*$html.= "<input type='checkbox' name='chb_$name' value='1' $readonly > 
		<font style='font-size:9px'>Check if remove this file</font>\n";*/
		unset($dialog);
		return $html;
	}
	//function
	function showInputDate($input){
		$name = $input["colname"];	
		$value = $input["value"];	
		$format = $input["format"];
		$showTime = $input["showTime"];
		$attr = $input["attr"];
		if (!class_exists("DatePicker")){
			require_once DIR_COMMON."/clsDatePicker.php";
		}
		$html = "";
		$clsDatePicker = new DatePicker($name, $value, $format, $showTime, $attr);
		if ($this->isShowJSDate==0){
			$html.= $clsDatePicker->showJSCSS();
		}
		$html.= $clsDatePicker->showInputDate();
		if ($this->isShowJSDate==0) $this->isShowJSDate = 1;
		return $html;
	}
	//function
	function showTitle($colname){
		$input = $this->getInput($colname);
		$html = $this->getLang($input["coltitle"]);
		if (isset($input["allowNull"]) && $input["allowNull"]==0){
			$html.= " * ";
		}
		return $html;
	}
	//function
	function showHint($colname){	
		if ($this->arr_hint[$colname]=="") return "";
		$html = "<img src='".URL_IMAGES."/admin/ico_help.png' border='0' title='".$this->arr_hint[$colname]."' align='middle' style='cursor:pointer'/>";
		return $html;
	}
	//function
	function showJS(){
		return $this->strJS;
	}
	//function
	function showInput($colname){
		$input = $this->getInput($colname);
		$html = $this->showHiddenData();
		switch ($input["coltype"]){
			case "text"		:	$html.= $this->showInputText($input); break;
			case "password"	:	$html.= $this->showInputPassword($input); break;
			case "textarea"	:	$html.= $this->showInputTextAreaTinyMCPuk($input); break;
			case "number"	:	$html.= $this->showInputNumber($input); break;
			case "email"	:	$html.= $this->showInputEmail($input); break;
			case "url"		:	$html.= $this->showInputUrl($input); break;
			case "select"	:	$html.= $this->showInputSelect($input); break;
			case "hidden"	:	$html.= $this->showInputHidden($input); break;
			case "date"		:	$html.= $this->showInputDate($input); break;
			case "file"		:	$html.= $this->showInputFile($input); break;
		}
		return $html;
	}
	//function
	function showAllError(){
		return $this->errorStr;
	}	
	//function
	function showError($colname){
		$input = $this->getInput($colname);
		return $input["errStr"];
	}	
	//function
	function showHiddenData(){
		if ($this->isShowHD==1) return "";
		$html = "";
		$html.= "<input type='hidden' name='btnSave' id='btnSave' value=''>"."\n";		
		if ($this->isShowHD==0) $this->isShowHD = 1;
		return $html;
	}
	//function
	function showForm(){
		$html = "";
		//show Hidden first
		foreach ($this->inputs as $key => $val)
		if ($val["coltype"]=="hidden"){
			$html.= $this->showInput($val["colname"])."\n";
		}
		//then show other
		foreach ($this->inputs as $key => $val)
		if ($val["coltype"]!="custom" && $val["coltype"]!="hidden"){
			$bcolor = ($this->inputs[$key]["errNo"]!=0 && $this->showBgColor==1)? "red" : "";
			if ($key<$this->totalInputs-1){
				$className1 = "gridrow";
				$className2 = "gridrow1";
			}else{
				$className1 = "gridrow2";
				$className2 = "gridrow3";			
			}
			$html.= "<tr>\n";
			$html.= "<td class='$className1' width='40%' nowrap>".$this->showTitle($val["colname"])."</td>\n";
			$html.= "<td class='$className2' nowrap bgcolor='$bgcolor'>".
					$this->showInput($val["colname"])."".$this->showHint($val["colname"]).
					"</td>\n";
			$html.= "</tr>\n";
		}else if ($val["coltype"]=="custom"){
			/*$html.= "<tr>
		<td colspan='2' class='gridheader1'>".$this->showTitle($val["colname"])."</td>
	</tr>";*/
			$html.= $val["value"];
		}
		return $html;
	}
	//function
	function validInputText(&$input){
		$errNo = 0;
		if (function_exists("checkValidText")){
			if (!checkValidText($input["value"], $input["len"], &$errNo)){
				if ($errNo == 1 && $input["allowNull"])
					return 1;
				$input["errNo"] = $errNo;
				return 0;
			}
			return 1;
		}else{
			if ($input["value"]==""){
				if ($input["allowNull"])	
					return 1;
				$input["errNo"] = 1;
				return 0;
			}
			return 1;
		}
	}
	//function
	function validInputNumber(&$input){
		$errNo = 0;
		$valid = 1;
		if (function_exists("isNumber")){
			if (!isNumber($input["value"])){
				if ($input["value"]=="" && $input["allowNull"])
					return 1;				
				$input["errNo"] = 3;
				return 0;
			}
			return 1;
		}else{
			if ($input["value"]==""){
				if ($input["allowNull"])
					return 1;
				$input["errNo"] = 1;
				return 0;
			}
			return 1;
		}		
	}
	//function
	function validInputEmail(&$input){
		$errNo = 0;
		if (function_exists("checkValidEmail")){
			if (!checkValidEmail($input["value"], $input["len"], &$errNo)){
				if ($errNo == 1 && $input["allowNull"]){
					return 1;
				}
				$input["errNo"] = $errNo;
				return 0;
			}
			return 1;
		}else{
			if ($input["value"]==""){
				if ($input["allowNull"])
					return 1;
				$input["errNo"] = 1;
				return 0;
			}
			return 1;
		}
	}
	//function
	function validInputUrl(&$input){
		$errNo = 0;
		if (function_exists("checkValidUrl")){
			if (!checkValidUrl($input["value"], $input["len"], &$errNo)){
				if ($errNo == 1 && $input["allowNull"]){
					return 1;
				}
				$input["errNo"] = $errNo;
				return 0;
			}
			return 1;
		}else{
			if ($input["value"]==""){
				if ($input["allowNull"])
					return 1;
				$input["errNo"] = 1;
				return 0;
			}
			return 1;
		}
	}
	//function
	function validInputDate(&$input){
		$errNo = 0;
		if ($input["value"]==""){
			if ($input["allowNull"])
				return 1;
			$input["errNo"] = 1;
			return 0;		
		}
		return 1;
	}
	//function
	function validInputFile(&$input){
		$errNo = 0;
		if ($input["value"]==""){
			if ($input["allowNull"])
				return 1;
			$input["errNo"] = 1;
			return 0;		
		}
		return 1;
	}
	//function
	function validate(){		
		if ($this->totalInputs==0) return 0;
		$this->isValid = 1;		
		foreach ($this->inputs as $key => $val){
			$postvalue = $_REQUEST[$val["colname"]];
			if ($val["coltype"]=="custom"){
				continue;
			}
			if ($val["coltype"]=="textarea"){
				$postvalue = br2nl($_REQUEST[$val["colname"]]);
			}
			if ($val["coltype"]=="date" && $postvalue!=""){
				$postvalue = strtotime($postvalue);
			}
			if ($val["allowNull"])
				$this->inputs[$key]["value"] = $val["value"] = $postvalue;
			elseif ($postvalue!="")
				$this->inputs[$key]["value"] = $val["value"] = $postvalue;
			switch ($val["coltype"]){
				case "text"		:	$this->isValid*= $this->validInputText($this->inputs[$key]); break;
				case "number"	:	$this->isValid*= $this->validInputNumber($this->inputs[$key]); break;
				case "email"	:	$this->isValid*= $this->validInputEmail($this->inputs[$key]); break;
				case "url"		:	$this->isValid*= $this->validInputUrl($this->inputs[$key]); break;
				case "date"		:	$this->isValid*= $this->validInputDate($this->inputs[$key]); break;
				case "file"		:	$this->isValid*= $this->validInputFile($this->inputs[$key]); break;

			}			
			if ($this->inputs[$key]["errNo"]==1){
				$errStr = NVCMS_ERROR_NULL;
				$this->inputs[$key]["errStr"] = str_replace("#NAME#", $val["coltitle"], $errStr);
			}else
			if ($this->inputs[$key]["errNo"]==2){
				$errStr = NVCMS_ERROR_LENGTH;
				$errStr = str_replace("#NAME#", $val["coltitle"], $errStr);
				$this->inputs[$key]["errStr"] = str_replace("#MAX_LEN#", $val["coltitle"], $errStr);
			}else
			if ($this->inputs[$key]["errNo"]==3){
				$errStr = NVCMS_ERROR_FORMAT;
				$errStr = str_replace("#NAME#", $val["coltitle"], $errStr);
				$this->inputs[$key]["errStr"] = str_replace("#TYPE#", $val["coltype"], $errStr);
			}
			if ($this->inputs[$key]["errStr"]!=""){
				$this->errorStr.= $this->inputs[$key]["errStr"]."<BR>";
			}
		}
		return $this->isValid;
	}
	//function
	function saveData($mode="New"){
		if ($mode==""){
			$mode = ($this->pkey!="" && $this->pval!="")? "Edit" : "New";
		}
		if ($mode=="New"){//Insert mode
			return $this->insertDb();
		}else{//Update mode
			return $this->updateDb($this->pval);
		}
	}
	//function
	function insertDb(){
		global $dbconn;
		$fields = "";
		$values = "";
		foreach ($this->inputs as $key => $val){
			if ($val["coltype"]=="custom"){
				continue;
			}
			if ($val["coltype"]=="password"){
				$val["value"] = User::encrypt($val["value"]);
			}	
			$fields.= ($fields=="")? $val["colname"] : ",".$val["colname"];
			$values.= ($values=="")? "'".$val["value"]."'" : ", '".$val["value"]."'";
		}
		$sql  = "INSERT INTO ".$this->table."($fields) VALUES($values)";
		//echo $sql;
		//die($sql);
		if (!$dbconn->Execute($sql)){ 
			$this->isValid = 0;
			$this->errorStr.= NVCMS_ERROR_INSERT."<BR>";
			return 0;
		}
		return 1;
	}
	//function
	function updateDb($_pkey=""){

		global $dbconn;
		$set = "";
		foreach ($this->inputs as $key => $val){			
			if ($val["coltype"]=="custom"){
				continue;
			}
			if ($val["coltype"]=="password" && $val["value"]!=$this->getFieldValue("user_pass")){				
				$val["value"] = User::encrypt($val["value"]);
				$set.= ($set=="")? $val["colname"]."='".$val["value"]."'" : ",".$val["colname"]."='".$val["value"]."'";
			}else{
				// off set time zone
				/* if($val["colname"]=="end_date")
				   {
				   	$val["value"]=$val["value"]+(60*60*7)+(60*60*24)-1;
				   }
				if($val["colname"]=="start_date")
				   {
				   	$val["value"]=$val["value"]+(60*60*7);
				   } */
				$set.= ($set=="")? $val["colname"]."='".$val["value"]."'" : ",".$val["colname"]."='".$val["value"]."'";			
 
			
			}
		}
		$where  = ($_pkey!="")? "WHERE ".$this->pkey."='$_pkey'" : "";		
		$sql = "UPDATE ".$this->table." SET $set $where ";
        
		
		if (!$dbconn->Execute($sql)){ 
			$this->isValid = 0;
			$this->errorStr.= NVCMS_ERROR_UPDATE."<BR>";
			return 0;
		}
		return 1;
	}
}
?>