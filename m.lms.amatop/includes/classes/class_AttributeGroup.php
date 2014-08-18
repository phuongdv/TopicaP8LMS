<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class AttributeGroup extends dbBasic {

	function AttributeGroup(){
		$this->pkey = "attribute_group_id";
		$this->tbl = "_attribute_group";
	}
	
	function getAttributeGroupName($attribute_group_id) {
		$arrListOneAttributeGroup = $this->getOne($attribute_group_id);
		if(is_array($arrListOneAttributeGroup) && count($arrListOneAttributeGroup)>0)
			return $arrListOneAttributeGroup["attribute_group_name"];
		else
			return "";
	}
	
	function getAttributeGroupFromCatID($cat_id) {
		$arrListOneAttributeGroup = $this->getAll("cat_id='".$cat_id."' order by order_no ASC");
		if(is_array($arrListOneAttributeGroup) && count($arrListOneAttributeGroup)>0)
			return $arrListOneAttributeGroup;
		else
			return "";
	}
	
	function getAttributeGroupNameFromAttributeID($attribute_id) {
		global $dbconn;
		
		$attribute_group_name = "";
		$arrListOneAttribute = $dbconn->GetAll("select * from _attribute where attribute_id='".$attribute_id."'");
		if(is_array($arrListOneAttribute) && count($arrListOneAttribute)>0) {
			$attribute_group_id = $arrListOneAttribute[0]["attribute_group_id"];
			$attribute_group_name = $this->getAttributeGroupName($attribute_group_id);
		}
		
		return $attribute_group_name;
	}	
	
	function getParentAttributeGroupColorID() {
		$arrListOneColorGroup = $this->getAll("cat_id=0 and is_color_group=1 order by order_no ASC limit 0,1");
		if(is_array($arrListOneColorGroup) && count($arrListOneColorGroup)>0) {
			return $arrListOneColorGroup[0]["attribute_group_id"];
		}
		
		return 0;
	}	
}
?>