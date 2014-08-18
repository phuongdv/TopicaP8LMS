<?
class Order extends dbBasic{
	function Order() {
		$this->pkey = "order_id";
		$this->tbl = "orders";
	}
	
	function checkSessionExistInOrder($sid) {
		$arrOneOrderCheck = $this->getByCond("session_value='".$sid."' and member_id=0");
			if(is_array($arrOneOrderCheck) && count($arrOneOrderCheck)>0)
				return $arrOneOrderCheck;
			else
				return "";
	}
	
	function getLastestOrderID() {
		$arrOneOrderCheck = $this->getAll("1=1 order by order_id DESC limit 0, 1");
			if(is_array($arrOneOrderCheck) && count($arrOneOrderCheck)>0)
				return $arrOneOrderCheck[0]["order_id"];
		else
			return 1;
	}
	
	function getTotalPriceFromOrder($order_id) {
		$arrOneOrderCheck = $this->getOne($order_id);
			if(is_array($arrOneOrderCheck) && count($arrOneOrderCheck)>0)
				return $arrOneOrderCheck["total_money"];
		else
			return 0;
	}		
}
?>