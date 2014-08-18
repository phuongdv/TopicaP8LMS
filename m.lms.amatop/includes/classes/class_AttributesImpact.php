<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class AttributesImpact extends dbBasic {

	function AttributesImpact(){
		$this->pkey = "attribute_impact_id";
		$this->tbl = "_attribute_impact";
	}
	
	function checkAttributesImpactSelectedExists($attribute_id, $product_id) {
		$arrListAttributesImpact = $this->getByCond("attribute_id='".$attribute_id."' and product_id='".$product_id."'");
		if(is_array($arrListAttributesImpact) && count($arrListAttributesImpact)>0)
			return true;
		else
			return false;
	}
	
	function getListAttributesImpactOfProduct($product_id) {
		$arrListAttributesImpact = $this->getAll("product_id='".$product_id."'");
		if(is_array($arrListAttributesImpact) && count($arrListAttributesImpact)>0)
			return $arrListAttributesImpact;
		else
			return "";
	}
	
	function makeSQLProductFromAttributeID($attribute_id) {
		$sql_qry = "";
		$arrListAttributesImpact = $this->getAll("attribute_id='".$attribute_id."'");
		if(is_array($arrListAttributesImpact) && count($arrListAttributesImpact)>0)
			foreach($arrListAttributesImpact as $k => $v)
			{
				$sql_qry .= (!empty($sql_qry))? " or A2.product_id='".$v["product_id"]."'" : " A2.product_id='".$v["product_id"]."'";
			}
		return $sql_qry;
	}
	
	function countProductInCurrentAttributes($attribute_id) {
		$arrListProductAttributesImpact = $this->getAll("attribute_id='".$attribute_id."'");
		if(is_array($arrListProductAttributesImpact) && count($arrListProductAttributesImpact)>0)
			return count($arrListProductAttributesImpact);
		else
			return 0;
	}
	
	function deleteAttributesImpactUpdate($arrAttributeID=array(), $product_id) {
		$arrListAttributesImpact = $this->getAll("product_id='".$product_id."'");
		if(is_array($arrListAttributesImpact) && count($arrListAttributesImpact)>0)
			foreach($arrListAttributesImpact as $k => $v)
				{
					if(!in_array($v["attribute_id"],$arrAttributeID)) $this->deleteByCond("attribute_id='".$attribute_id."' and product_id='".$product_id."'");
				}
		return true;
	}
}
?>