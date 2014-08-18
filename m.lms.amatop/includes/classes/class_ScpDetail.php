<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class ScpDetail extends dbBasic{

	function ScpDetail() {
		$this->pkey = "scp_detail_id";
		$this->tbl = "scp_detail";
	}
		
	function makeArrayListSupportSelected($product_id) {
		$arrListReturnCate = array();
		$arrListCurrentCate = $this->getAll("product_id='".$product_id."'");
		if(is_array($arrListCurrentCate) && count($arrListCurrentCate)>0)
			{
				foreach($arrListCurrentCate as $k => $v)
					$arrListReturnCate[$k] = $v["nick_support_id"];
				
				return $arrListReturnCate;
			}
		else return "";	
	}
	
	function checkSupportSelectedExists($product_id, $nick_support_id) {
		$arrListCurrentCate = $this->getByCond("product_id='".$product_id."' and nick_support_id='".$nick_support_id."'");
		if(is_array($arrListCurrentCate) && count($arrListCurrentCate)>0)
			return $arrListCurrentCate["scp_detail_id"];
		else
			return 0;
	}
	
	function deleteSupportUpdate($arrPostCateId=array(), $product_id) {
		$arrListCurrentCate = $this->getAll("product_id='".$product_id."'");
		if(is_array($arrListCurrentCate) && count($arrListCurrentCate)>0)
			foreach($arrListCurrentCate as $k => $v)
				{
					if(!in_array($v["nick_support_id"],$arrPostCateId)) $this->deleteByCond("product_id='".$product_id."' and nick_support_id='".$v["nick_support_id"]."'");
				}
		return true;
	}
}
?>