<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class Currency extends dbBasic{
	function Currency(){
		global $_LANG_ID;
		$this->pkey = "currency_id";
		$this->tbl = "_currency";
	}
	function getName($currency_id){
		$one = $this->getOne($currency_id);
		$name = $one["name"];
		return $name;
	}
	function getSign($currency_id=0){
		if($currency_id == 0){
			return "VND";
		}
		$res = dbBasic::getOne($currency_id);
		return $res["sign"];
	}
	
	function getPrice($currency_id=0){
		if($currency_id == 0){
			return 1;
		}
		$res = dbBasic::getOne($currency_id);
		return $res["price"];
	}
	
	function getUSDPrice(){
		$res = $this->getByCond("LOWER(name)='usd'");
		if(is_array($res) && count($res)>0)
			return $res["price"];
		else
			return "";
	}
	
	function roundNumber($num) {
		return round($num, 2);
	}
	
	function formatCurrencyPrice($str_format) {
		if($str_format != "")	
			return number_format($str_format,0,-2,',');
		else return "";	
	}
	
	function isCurrentUSDPrice($currency_id) {
		$is_usd = 0;
		$res = $this->getByCond("LOWER(CONVERT(name USING utf8))='usd'");
		if(is_array($res) && count($res)>0) {
			if($res["currency_id"]==$currency_id) $is_usd = 1;
		}
	
		return $is_usd;
	}
	
	function getCurrentUSDConvertToVNDPrice() {
		$current_price = 1;
		$res = $this->getByCond("LOWER(CONVERT(name USING utf8))='usd'");
		if(is_array($res) && count($res)>0) {
			$current_price = $res["price"];
		}
		
		return $current_price;
	}
	
	function getUSDSign() {
		$current_price = "";
		$res = $this->getByCond("LOWER(CONVERT(name USING utf8))='usd'");
		if(is_array($res) && count($res)>0) {
			$current_price = $res["name"];
		}
		
		return $current_price;
	}
	
	function getVNDSign() {
		$current_price = "";
		$res = $this->getByCond("price=1");
		if(is_array($res) && count($res)>0) {
			$current_price = $res["sign"];
		}
		
		return $current_price;
	}
}
?>