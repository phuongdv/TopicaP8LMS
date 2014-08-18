<?
define("ERROR_NULL", 1);
define("ERROR_LENGTH", 2);
define("ERROR_FORMAT", 3);
/**
 *  Description	: Check a string is number
 *  @param 1 	: $st, $allowAZ, $allowPlus
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
 function isNumber($st, $allowAZ=false, $allowPlus=false){
	$strRegular = '0-9|\.';
	if ($allowAZ==true){
		$strRegular .= '|a-z|A-Z';	 		
	}
	if ($allowPlus==true){
		$strRegular .= '|\-';
	}
	if (ereg('^['.$strRegular.']+$', $st))
		return 1;
	return 0;
 }
/**
 *  Description	: Check a string is aphabet
 *  @param 1 	: $st, $allowAZ, $allowPlus
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
function isAphabet($ch){
	if (($ch>'a' && $ch<'z')||($ch>'A' && $ch<'Z')){
		return 1;
	}
	return 0;
}
/**
 *  Description	: Check a string is aphabet-number
 *  @param 1 	: $st, $allowAZ, $allowPlus
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
function isAlphabetNumber($st, $num=0, $errornum=1){
	if (ereg('^[a-z|A-Z|0-9]+$', $st)){			
		return 1;
	}else{
		return 0;
	}
}
/**
 *  Description	: Check empty
 *  @param 1 	: $str
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
 function isEmpty($str){
	if ($str=="" || $str==null){			
		return 1;
	}
	return 0;
 }
/**
 *  Description	: Check url
 *  @param 1 	: $url
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
function isUrl($url, $maxlen = 256){
	if (strlen($url) > $maxlen) {
		return 0;
	}
	if(ereg("(h{0,1}t{0,2}p{0,1}:{0,1}/{0,1}/{0,1})(w{0,3}\.{0,1})([aA-zZ]+)?\.{1}([aA-zZ]{2,3})(.*)", $url)){
		return 1;
	}
	return 0;
}
/**
 *  Description	: Check color
 *  @param 1 	: $col
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
function isColor($col){
	if (ereg("#[A-Fa-f0-9]{6}$",$col))
		return 1;
	elseif (ereg("^[A-Fa-f0-9]{6}",$col))
		return 0;
	else
		return 0;
}
/**
 *  Description	: Check email
 *  @param 1 	: $col
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
function isEmail($strEmail){
	$strRegular = "^[A-Za-z0-9_\.\-]+@[A-Za-z0-9_\.\-]+\.";
	$strRegular = $strRegular . "[A-Za-z0-9_\-][A-Za-z0-9_\-]+$";
	if (!ereg($strRegular, $strEmail)) {
		return 0;
	}    	
	return 1;   	
}
/**
 *  Description	: Check the email address is valid
 *  @param 1 	: $strEmail
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
 function checkValidEmail($strEmail, $length, &$errNo)
 {
	$errNo = null;
	if ($strEmail=="" || $strEmail==null){
		$errNo = 1;//error null
		return 0;
	}
	if (strlen($strEmail)>$length){
		$errNo = 2;//error length
		return 0;
	}
	// Use regular expression to check valid email address
	$strRegular = "^[A-Za-z0-9_\.\-]+@[A-Za-z0-9_\.\-]+\.";
	$strRegular = $strRegular . "[A-Za-z0-9_\-][A-Za-z0-9_\-]+$";
	if (!ereg($strRegular, $strEmail)) {
		$errNo = 3;//error format 
		return 0;
	}
	
	return 1;   	
 }
/**
 *  Description	: Check the Url is valid
 *  @param 1 	: $strEmail
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
 function checkValidUrl($strUrl, $length, &$errNo)
 {
	$errNo = null;
	if ($strUrl=="" || $strUrl==null){
		$errNo = 1;//error null
		return 0;
	}
	if (strlen($strUrl)>$length){
		$errNo = 2;//error length
		return 0;
	}
	// Use regular expression to check valid email address
	if(!ereg("(h{0,1}t{0,2}p{0,1}:{0,1}/{0,1}/{0,1})(w{0,3}\.{0,1})([aA-zZ]+)?\.{1}([aA-zZ]{2,3})(.*)", $strUrl)){
		$errNo = 3;//error format 
		return 0;
	}
	
	return 1;   	
 }
/**
 *  Description	: Check zipcode is valid
 *  @param 1 	: $str
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
 function checkValidZipCode($str, $length, &$errNo){
	$errNo = null;
	if ($str=="" || $str==null){
		$errNo = 1;//error null
		return 0;
	}
	if (strlen($str)>$length){
		$errNo = 2;//error length
		return 0;
	}
	if (!isNumber($str)){
		$errNo = 3;//error format
		return 0;	
	}
	return 1;
 }
/**
 *  Description	: Check telephone is valid
 *  @param 1 	: $str
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
 function checkValidTel($str, $length, &$errNo){
	$errNo = null;
	if ($str=="" || $str==null){
		$errNo = 1;//error null
		return 0;
	}
	if (strlen($str)>$length){
		$errNo = 2;//error length
		return 0;
	}
	if(!eregi("^[0-9]{2,3}[.-][0-9]{2,3}[.-][0-9]{4}$", $str ) ) { 
		$errNo = 3;//error format
		return 0;
	}
	return 1;
 }
/**
 *  Description	: Check telephone is valid
 *  @param 1 	: $str
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
 function checkValidMobile($str, $length, &$errNo){
	$errNo = null;
	if ($str=="" || $str==null){
		$errNo = 1;//error null
		return 0;
	}
	if (strlen($str)>$length){
		$errNo = 2; //error length
		return 0;
	}
	if (!isNumber($str)){
		$errNo = 3;
		return 0;//error format
	}
	return 1;
 }
/**
 *  Description	: Check datetime is valid
 *  @param 1 	: $strDatetime
 *  @return		: 1/0
 *  @date		: 2006/08/31
 *  @author		: Vu Quoc Trung
 */		
function checkValidDateTime($strDatetime)//month, day, year
{
	if ($strDatetime[2]<1900 || $strDatetime[2]>date('Y')){
		return 0;	
	}
	if(!checkdate($strDatetime[0], $strDatetime[1], $strDatetime[2]))
	{
		return 0;
	}
	if (mktime(0, 0, 0, $strDatetime[0], $strDatetime[1], $strDatetime[2])>time()){
		return 0;
	}
	return 1;	//if nothing wrong		
}	
/**
 *  Description	: Check input Text is valid
 *  @param 1 	: $strName
 *  @return		: 1/0
 *  @date		: 2006/08/31
 *  @author		: Vu Quoc Trung
 */		
function checkValidText($strName, $length, &$errNo){
	$errNo = null;
	if ($strName=="" || $strName==null){
		$errNo = 1;//error null
		return 0;
	}
	if (strlen($strName)>$length){
		$errNo = 2;//error length
		return 0;	
	}		
	return 1;
}
/**
 *  Description	: Check $_FILE, type IMGAGE
 *  @param 1 	: $strName
 *  @return		: 1/0
 *  @date		: 2006/08/31
 *  @author		: Vu Quoc Trung
 */		
function checkValidImageFile($imgfile, $max_file_size="", $allowExt="", &$errNo){
	if ($max_file_size==""){
		$max_file_size = 10485760;
	}
	if ($allowExt==""){
		$allowExt=".jpeg, .jpg, .gif";
	}
	$file_tmp = $imgfile['tmp_name'];
	$file_name = $imgfile["name"];
	$extension = strtolower(strrchr($file_name,"."));
	//check extension
	if (strpos($allowExt, $extension)===false){
		$errNo = 1;//extension is not allow
		return 0;
	}
	//check size
	$size = filesize($file_tmp);
	if ($size>$max_file_size){
		$errNo = 2;//size is not allow
		return 0;
	}
	//else
	return 1;
}
/**
 *  Description	: set focus to ControlName
 *  @param 1 	: $col
 *  @return		: 1/0
 *  @date		: 2006/11/10
 *  @author		: Vu Quoc Trung
 */
function setFocus($controlName)
{
	global $setFocusControl;
	if ($controlName=="") return;		
	$setFocusControl= 
			"<script language='javascript'>
				var obj = document.getElementById('$controlName');
				if (obj==null){
					obj = document.theForm.$controlName;
				}
				obj.focus(); 								
			</script>";
}
 

?>