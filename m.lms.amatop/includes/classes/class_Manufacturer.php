<?
class Manufacturer extends dbBasic{

	function Manufacturer(){
		$this->pkey = "manufacturer_id";
		$this->tbl = "manufacturer";
	}
	
	function getManufacturerName($manufacturer_id = ""){
		if($manufacturer_id == 0){
			return "Chua rõ";
		}
		$res = dbBasic::getOne($manufacturer_id);
		return $res["name"];
	}
}
?>