<?
/**
*  Created by   : Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class Delivery extends dbBasic{

	function Delivery() {
		$this->pkey = "deliver_id";
		$this->tbl = "deliver";
	}
	
	function getDeliveryName($deliver_id){
		global $_LANG_ID;
		
		$res = $this->getOne($deliver_id);
		if(is_array($res) && count($res)>0) {
			$cname = ($_LANG_ID == 'vn')? $res["title"] : $res["title_en"];
			return $cname;
		}
		else
			return "";
	}	
}
?>