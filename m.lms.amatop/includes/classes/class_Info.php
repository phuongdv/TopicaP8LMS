<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
   @modifier    : Vu Quoc Trung (trungvq@vietitech.com)	
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class Info extends dbBasic{
	function Info(){
		$this->pkey = "info_id";
		$this->tbl = "_info";
	}
	function getByKeyword($key){
		$res = dbBasic::getByCond("keyword='".$key."'");
		return $res;
	}
	function getByKeyword2($key){
		$res = $this->getAll("keyword='".$key."'");					
		return $res;
	}
}
?>