<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class ProductTags extends dbBasic{
	function ProductTags(){
		$this->pkey = "product_tag_id";
		$this->tbl = "product_tag";
	}
	
	function makeQueryProductExistCurrentTags($tag_id="") {
		$str_query = "";
		
		$arrProductExistCurrentTags = $this->getAll("tag_id='$tag_id' order by product_id DESC");
		if(is_array($arrProductExistCurrentTags) && count($arrProductExistCurrentTags)>0)
			foreach($arrProductExistCurrentTags as $k => $v)
				{
					$str_query .= ($str_query != "")? "or product_id<>'".$v["product_id"]."'" : "product_id<>'".$v["product_id"]."'";
				}
			
		return $str_query;
	}
	
	function makeProductQueryInCurrentTags($tag_id="") {
		$str_query = "";
		
		$arrProductExistCurrentTags = $this->getAll("tag_id='$tag_id' order by product_id DESC");
		if(is_array($arrProductExistCurrentTags) && count($arrProductExistCurrentTags)>0)
			foreach($arrProductExistCurrentTags as $k => $v)
				{
					$str_query .= ($str_query != "")? "or product_id='".$v["product_id"]."'" : "product_id='".$v["product_id"]."'";
				}
			
		return $str_query;
	}
	
	function checkProductIDSelectedExists($tag_id, $product_id) {
		$arrListCurrentCate = $this->getByCond("tag_id='".$tag_id."' and product_id='".$product_id."'");
		if(is_array($arrListCurrentCate) && count($arrListCurrentCate)>0)
			return true;
		else
			return false;
	}
	
	function deleteProductIDUpdate($arrProductID=array(), $tag_id) {
		$arrListCurrentProductID = $this->getAll("tag_id='".$tag_id."'");
		if(is_array($arrListCurrentProductID) && count($arrListCurrentProductID)>0)
			foreach($arrListCurrentProductID as $k => $v)
				{
					if(!in_array($v["product_id"],$arrProductID)) $this->deleteByCond("tag_id='".$tag_id."' and product_id='".$v["product_id"]."'");
				}
		return true;
	}
}
?>