<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class Quiz extends dbBasic{
	function Quiz(){
		global $_LANG_ID;
		$this->pkey = "id";
		$this->tbl = "mdl_quiz";	
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