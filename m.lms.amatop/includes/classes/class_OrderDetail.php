<?
class OrderDetail extends dbBasic{

	function OrderDetail() {
		$this->pkey = "order_detail_id";
		$this->tbl = "orders_detail";
	}
	
	function checkProductExistInOrder($sid,$product_id) {
		global $dbconn;
		
		$arrListOneOrder = $dbconn->GetAll("select * from orders where session_value='".$sid."' order by order_id DESC limit 0, 1");
		if(is_array($arrListOneOrder) && count($arrListOneOrder)>0) {
			$order_id = $arrListOneOrder[0]["order_id"];
			$arrOneOrderCheck = $this->getByCond("order_id='".$order_id."' and product_id='".$product_id."'");
				if(is_array($arrOneOrderCheck) && count($arrOneOrderCheck)>0)
					return $arrOneOrderCheck;
		}
		else return "";	
		
	}
	
	function getListOrderDetail($order_id) {
		$arrOneOrderCheck = $this->getAll("order_id='".$order_id."'");
			if(is_array($arrOneOrderCheck) && count($arrOneOrderCheck)>0)
				return $arrOneOrderCheck;
			else
				return "";
	}
}
?>