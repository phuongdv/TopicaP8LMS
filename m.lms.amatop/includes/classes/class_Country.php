<?
class Country extends dbBasic{
	function Country(){
		$this->pkey = "country_id";
		$this->tbl = "country";
	}
	function getCountryName($country_id = ""){
		if($country_id == 0){
			return "Chua rõ";
		}
		$res = dbBasic::getOne($country_id);
		return $res["name"];
	}
}
?>