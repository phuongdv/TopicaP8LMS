<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class Type extends dbBasic{

	function Type(){
		global $_LANG_ID;
		$this->pkey = "type_id";
		$this->tbl = "_type";
	}
	
	function getTypeIDOfCategory($tkeyword="") {
		$arrListOneType = $this->getByCond("type_key='".$tkeyword."'");
		if(is_array($arrListOneType) && count($arrListOneType)>0)
			return $arrListOneType["type_id"];
		else
			return 0;
	}
}
?>