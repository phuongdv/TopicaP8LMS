<?
class Province extends dbBasic{

	function Province(){
		$this->pkey = "province_id";
		$this->tbl = "province";
	}
	
	function getArrayOtherProvince($province_id) {
		$cat_name = "";
		$arrOneProvinceSelect = $this->getByCond("province_id='".$province_id."' and code<>'04' and code<>'08'");
		if(is_array($arrOneProvinceSelect) && count($arrOneProvinceSelect)>0) {
			return $arrOneProvinceSelect;
		}
		else
		return $cat_name;
	}
	
	function getProvinceName($province_id) {
		$cat_name = "Tỉnh, TP Khác";
		$arrOneProvinceSelect = $this->getByCond("province_id='".$province_id."'");
		if(is_array($arrOneProvinceSelect) && count($arrOneProvinceSelect)>0) {
			$cat_name = $arrOneProvinceSelect["name"];
		}
		
		return $cat_name;
	}
	
	function getProvinceByPhoneCode($code="") {		
		if($code != "") {
			$arrOneProvinceSelect = $this->getByCond("code='".$code."'");
				if(is_array($arrOneProvinceSelect) && count($arrOneProvinceSelect)>0) 
					return $arrOneProvinceSelect;
				else return 0;
		}
		else return 0;
	}
	
	function createAttributeProvinceGroupJS() {
		
		$arrListAllAttributeProvinceGroup = $this->getAll("parent_id=0 order by order_no ASC");
		$html = '<script type="text/javascript">';
		if(is_array($arrListAllAttributeProvinceGroup) && count($arrListAllAttributeProvinceGroup)>0)
			foreach($arrListAllAttributeProvinceGroup as $k => $v)
				{
					$html .= 'var myOptions'.$v["province_id"].' = {';
					$html .= "\n";
					$html .= '0' . ' : "- - - - - -"';
					$arrListAttributeInGroup = $this->getAll("parent_id='".$v["province_id"]."' order by order_no ASC");
					if(is_array($arrListAttributeInGroup) && count($arrListAttributeInGroup)>0)
						foreach($arrListAttributeInGroup as $key => $val)
						{
							$html .= ',' . $val["province_id"] .' : "'.$val["name"].'"';
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