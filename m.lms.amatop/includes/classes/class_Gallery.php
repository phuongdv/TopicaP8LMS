<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class Gallery extends dbBasic{
	function Gallery(){
		$this->pkey = "id";
		$this->tbl = "_gallery";
	}
	
	function getAllAttributeExistWithCurrentProduct($product_id) {
		$arrListAllAttributeWithCurrentProduct = $this->getAll("product_id='".$product_id."' and is_online=1 order by order_no ASC");
		if(is_array($arrListAllAttributeWithCurrentProduct) && count($arrListAllAttributeWithCurrentProduct)>0)
			return $arrListAllAttributeWithCurrentProduct;
		else
		 	return "";			
	}
	
	function getArrImageGallery($attribute_id, $product_id) {
		$arrListAllAttributeWithCurrentProduct = $this->getAll("is_online=1 and attribute_id='".$attribute_id."' and product_id='".$product_id."' order by order_no ASC");
		if(is_array($arrListAllAttributeWithCurrentProduct) && count($arrListAllAttributeWithCurrentProduct)>0)
			return $arrListAllAttributeWithCurrentProduct;
		else
		 	return "";			
	}
}
?>