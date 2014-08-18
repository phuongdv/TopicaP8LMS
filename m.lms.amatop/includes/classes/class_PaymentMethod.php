<?
/**
*  Created by   : Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class PaymentMethod extends dbBasic{

	function PaymentMethod() {
		$this->pkey = "payment_method_id";
		$this->tbl = "payment_method";
	}
	
}
?>