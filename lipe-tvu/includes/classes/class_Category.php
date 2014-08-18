<?
class Category extends dbBasic{
	function Category(){
		global $_LANG_ID;
		$this->pkey = "cat_id";
		$this->tbl = "category";		
	}
	
	function getChildCats($parent_id=''){
		$res = DbBasic::getAll("parent_id = '$parent_id'");
		return $res;
	}
	
	function getParentId($cat_id=''){
		$res = DbBasic::getAll("cat_id= '$cat_id'");
		return $res[0]['parent_id'];
	}

	function getCatName($cat_id=""){
		global $_LANG_ID;
		
		$ret = "";
		
		$res = DbBasic::getAll("cat_id= '$cat_id'");
		
		if($_LANG_ID == "en")
			$ret = $res[0]["name_en"];
		else
			$ret = $res[0]["name_vn"];
			
		return $ret;
	}
	
	function checkHasChild($parent_id=''){
		$ret = 0;
		$res = DbBasic::getAll("parent_id = '$parent_id'");
		if(is_array($res) && count($res)>0)
			$ret = 1;
			
		return $ret;
	}
	
	function getChildMenu($parent_id='') {
		$res = DbBasic::getAll("parent_id = '$parent_id'");
		if(is_array($res) && count($res)>0)
			return $res;
		else
			return "";
	}
}
?>