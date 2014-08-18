<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class CpsDetail extends dbBasic{

	function CpsDetail(){
		$this->pkey = "cps_detail_id";
		$this->tbl = "cps_detail";
	}
	
	function getFirstCategoryID($product_id) {
		$in_categoryid = 0;
		$arrListCurrentCate = $this->getAll("product_id='".$product_id."'");
		if(is_array($arrListCurrentCate) && count($arrListCurrentCate)>0)
			{
				$in_categoryid = $arrListCurrentCate[0]["cat_id"];
			}
		
		return $in_categoryid;
	}
		
	function countProductInCurCategory($cat_id) {
		$arrListCurrentCate = $this->getAll("cat_id='".$cat_id."'");
		if(is_array($arrListCurrentCate) && count($arrListCurrentCate)>0)
			{				
				return count($arrListCurrentCate);
			}
		else return 0;	
	}
	
	function makeArrayListCatSelected($product_id) {
		$arrListReturnCate = array();
		$arrListCurrentCate = $this->getAll("product_id='".$product_id."'");
		if(is_array($arrListCurrentCate) && count($arrListCurrentCate)>0)
			{
				foreach($arrListCurrentCate as $k => $v)
					$arrListReturnCate[$k] = $v["cat_id"];
				
				return $arrListReturnCate;
			}
		else return "";	
	}
	
	function checkCatSelectedExists($product_id, $cat_id) {
		$arrListCurrentCate = $this->getByCond("product_id='".$product_id."' and cat_id='".$cat_id."'");
		if(is_array($arrListCurrentCate) && count($arrListCurrentCate)>0)
			return $arrListCurrentCate["cps_detail_id"];
		else
			return 0;
	}
	
	function deleteCateUpdate($arrPostCateId=array(), $product_id) {
		$arrListCurrentCate = $this->getAll("product_id='".$product_id."'");
		if(is_array($arrListCurrentCate) && count($arrListCurrentCate)>0)
			foreach($arrListCurrentCate as $k => $v)
				{
					if(!in_array($v["cat_id"],$arrPostCateId)) $this->deleteByCond("product_id='".$product_id."' and cat_id='".$v["cat_id"]."'");
				}
		return true;
	}
}
?>