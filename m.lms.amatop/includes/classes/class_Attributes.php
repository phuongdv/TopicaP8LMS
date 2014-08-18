<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class Attributes extends dbBasic {

	function Attributes(){
		$this->pkey = "attribute_id";
		$this->tbl = "_attribute";
	}
	
	function getAttributesName($attribute_id) {
		$arrListOneAttribute = $this->getOne($attribute_id);
		if(is_array($arrListOneAttribute) && count($arrListOneAttribute)>0)
			return $arrListOneAttribute["attribute_name"];
		else
			return "";
	}
	
	function getAttributeFromAttributeGroup($attribute_group_id=0) {
		$arrListAttributeFromAttributeGroup = $this->getAll("attribute_group_id='".$attribute_group_id."' order by order_no ASC");
		if(is_array($arrListAttributeFromAttributeGroup) && count($arrListAttributeFromAttributeGroup)>0)
			return $arrListAttributeFromAttributeGroup;
		else
			return "";
	}
	
	function isColorAttributes($attribute_id) {
		global $dbconn;
		
		$ret = false;
		
		$arrListOneAttribute = $this->getOne($attribute_id);
		if(is_array($arrListOneAttribute) && count($arrListOneAttribute)>0) {
			$parent_attribute_id = $arrListOneAttribute["attribute_group_id"];
			$arrListOneColorGroupChecking = $dbconn->GetAll("select * from _attribute_group where is_color_group=1 and attribute_group_id='".$parent_attribute_id."' order by order_no ASC limit 0,1");
			if(is_array($arrListOneColorGroupChecking) && count($arrListOneColorGroupChecking)>0) $ret = true;			
		}
		
		return $ret;
	}
	
	function getAttributeColorFromArrayAttribute($arrListAttribute = array()) {
		$arrListColorAttributeID = array();
		if(is_array($arrListAttribute)) 
			foreach($arrListAttribute as $k => $v) {
				if($this->isColorAttributes($v["attribute_id"]) && !in_array($v["attribute_id"],$arrListColorAttributeID)) 
					array_push($arrListColorAttributeID, $v["attribute_id"]);
			}	
		
		if(is_array($arrListColorAttributeID) && count($arrListColorAttributeID)>0)
			return $arrListColorAttributeID;
		else
			return "";
	}
	
	function createAttributeGroupJS() {
		global $dbconn;
		
		$arrListAllAttributeGroup = $dbconn->GetAll("select * from _attribute_group order by order_no ASC");
		$html = '<script type="text/javascript">';
		if(is_array($arrListAllAttributeGroup) && count($arrListAllAttributeGroup)>0)
			foreach($arrListAllAttributeGroup as $k => $v)
				{
					$html .= 'var myOptions'.$v["attribute_group_id"].' = {';
					$html .= "\n";
					$html .= '0' . ' : "- - - - - -"';
					$arrListAttributeInGroup = $this->getAll("is_online=1 and attribute_group_id='".$v["attribute_group_id"]."' order by order_no ASC");
					if(is_array($arrListAttributeInGroup) && count($arrListAttributeInGroup)>0)
						foreach($arrListAttributeInGroup as $key => $val)
						{
							$html .= ',' . $val["attribute_id"] .' : "'.$val["attribute_name"].'"';
						}
					$html .= "\n";
					$html .= '};';
					$html .= "\n";
				}
		$html .= "\n";
		$html .= '</script>';		
		return $html;
	}
}
?>