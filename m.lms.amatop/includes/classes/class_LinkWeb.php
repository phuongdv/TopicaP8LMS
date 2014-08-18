<?
class LinkWeb extends dbBasic{

	function LinkWeb(){
		$this->pkey = "linkweb_id";
		$this->tbl = "linkweb";
	}
	
	function getLinkWebName($linkweb_id = ""){
		if($linkweb_id == 0){
			return "Chua rõ";
		}
		$res = dbBasic::getOne($linkweb_id);
		return $res["name"];
	}
	
}
?>