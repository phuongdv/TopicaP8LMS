<?
class Warranty extends dbBasic{
	
	function Warranty(){
		$this->pkey = "warranty_id";
		$this->tbl = "warranty";
	}
		
	function getWarrantyName($warranty_id){
		global $_LANG_ID;
		
		$res = $this->getOne($warranty_id);
		if(is_array($res) && count($res)>0) {
			$cname = ($_LANG_ID == 'vn')? $res["name"] : $res["name_en"];
			return $cname;
		}
		else
			return "";
	}	
}
?>