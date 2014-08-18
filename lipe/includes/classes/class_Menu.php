<?
class Menu extends dbBasic{
	function Menu(){
		global $_LANG_ID;
		$this->pkey = "cat_id";
		$this->tbl = "category";
		//$this->tbl = ($_LANG_ID!="vn")? $this->tbl."_".$_LANG_ID : $this->tbl;	
	}
	# get child of category in left_menu
	function getChildCats($parent_id=''){
		$res = DbBasic::getAll("parent_id = '$parent_id'");
		return $res;
	}
	# 
	function getParentId($cat_id=''){
		$res = DbBasic::getAll("cat_id= '$cat_id'");
		return $res[0]['parent_id'];
	}
	#
	function getCatId($name=""){
		$res = $this->getAll("name='$name'");
		return $res;
	}
}
?>