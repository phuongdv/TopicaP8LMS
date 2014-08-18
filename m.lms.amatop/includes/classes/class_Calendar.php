<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class Calendar extends dbBasic{
	function Calendar(){
		global $_LANG_ID;
		$this->pkey = "id";
		$this->tbl = "huy_setting_calendar";	
	}
	
	
	function getName($id=''){
		global $_LANG_ID;
		$name = '';		
		$res = DbBasic::getAll("id= '$id'");
		$name = $res[0]["name"];
				
		return $name;
	}
	
	
	
}
?>