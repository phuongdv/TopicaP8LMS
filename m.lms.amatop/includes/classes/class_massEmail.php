<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class MassEmail extends dbBasic{
	function MassEmail(){
		global $_LANG_ID;
		$this->pkey = "id";
		$this->tbl = "_massemail";
		//$this->tbl = ($_LANG_ID!="vn")? $this->tbl."_".$_LANG_ID : $this->tbl;	
	}
	
	function replaceKey($str, $str_find, $str_find_replace) {
	
	if(preg_match("/".$str_find."/",$str))
	{
		$str_encode = str_replace($str_find,$str_find_replace,$str);		
	}
	
	return html_entity_decode($str_encode);
	
}
}
?>