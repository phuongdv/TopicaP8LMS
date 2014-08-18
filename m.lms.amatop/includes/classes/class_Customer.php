<?
class Customer extends dbBasic{
	function Customer(){
		$this->pkey = "customer_id";
		$this->tbl = "customer";
	}
	
	function getNameCompanyCustomer($customer_id) {
		$company_name = "";
		$arrListOneCustomer = $this->getOne($customer_id);
		if(is_array($arrListOneCustomer) && count($arrListOneCustomer)>0)
			$company_name = $arrListOneCustomer["company"];
			
		return $company_name;
	}
	
	function getCustomerID($adver_id) {
		$customer_id = 0;
		$arrListOneCustomer = $this->getByCond("customer_id in (select customer_id from advertisment where adver_id='".$adver_id."')");
		if(is_array($arrListOneCustomer) && count($arrListOneCustomer)>0)
			$customer_id = $arrListOneCustomer["customer_id"];
			
		return $customer_id;
	}
}
?>