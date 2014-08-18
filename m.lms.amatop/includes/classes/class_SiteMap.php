<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class SiteMap extends dbBasic{
	function SiteMap(){
		global $_LANG_ID;
		$this->pkey = "id";
		$this->tbl = "_sitemap";	
	}
	# get child of category in left_menu
	function getChildCats($parent_id=''){
		$res = DbBasic::getAll("parent_id = '$parent_id'");
		return $res;
	}
	# 
	function getParentId($id=''){
		$res = DbBasic::getAll("id= '$id'");
		return $res[0]['parent_id'];
	}
	#
}
?>