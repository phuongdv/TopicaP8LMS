<?
class DesignWeb extends dbBasic{

	function DesignWeb(){
		$this->pkey = "id";
		$this->tbl = "design_web";
	}
	function getNewsIDFromUrl($str) {
		$res = DbBasic::getByCond("name_alias = '".$str."'");
		if(is_array($res) && count($res)>0)
			return $res["id"];
		else
			return 0;
	}
}
?>