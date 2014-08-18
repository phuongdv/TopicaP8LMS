<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class Settings extends dbBasic{
	var $settingid;
	var $skey;
	var $svalue;
	var $stitle;
	var $ftype;
	var $orderNo;
	var $disp;
	function Settings(){
		$this->pkey = "setting_id";
		$this->tbl = "_settings";
	}
	function getValue($skey){
		$res = dbBasic::getByCond("skey='".$skey."'");
		return $res["svalue"];
	}
	function delValue($skey){
		return dbBasic::deleteByCond("skey='".$skey."'");
	}
	function insertValue($skey, $svalue){
		dbBasic::insertOne("skey, svalue", "'".$skey."','".$svalue."'");
	}
	function setValue($skey, $svalue=""){
		global $dbconn;
		dbBasic::updateByCond("skey='".$skey."'", "svalue='".$svalue."'");
	}
}
?>