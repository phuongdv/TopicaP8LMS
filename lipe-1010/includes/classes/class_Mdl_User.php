<?
class Mdl_User extends DbBasic{
	
	function Mdl_User(){
		$this->pkey = "id";
		$this->tbl = "mdl_user";	
	}		
	
	function getNumberMobile($id=""){
		$ret = "";
		$res = DbBasic::getAll("id= '$id'");
		$ret = $res[0]["topica_dienthoai"];
		return $ret;
	}
	function getName($id=""){
		$ret = "";
		$res = DbBasic::getAll("id= '$id'");
		$ret = $res[0]["lastname"].' '.$res[0]["firstname"];
		return $ret;
	}
	
}
?>