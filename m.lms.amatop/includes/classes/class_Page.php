<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class Page extends DbBasic{
	function Page(){
		global $_LANG_ID;
		$this->pkey = "page_id";
		$this->tbl = "page";	
		//$this->tbl = ($_LANG_ID!="vn")? $this->tbl."_".$_LANG_ID : $this->tbl;	
	}
}
