<?
/**
*  Created by   :
*  @author		: Vu Quoc Trung (trungvq@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class _Lang extends DbBasic{
	function _Lang(){
		global $_LANG_ID;
		$this->pkey = "lang_id";
		$this->tbl = "_lang";	
	}
	function haveSpace($str) {
	
	$str_find = " ";
	if(preg_match("/".$str_find."/",$str))
	{
		return true;		
	}
	return false;
	}
}
?>