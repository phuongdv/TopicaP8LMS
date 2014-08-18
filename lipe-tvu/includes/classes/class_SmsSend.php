<?
class SmsSend extends DbBasic{
	
	function SmsSend(){
		$this->pkey = "sms_send_id";
		$this->tbl = "sms_send";	
	}		
	
	#
	function getLastID() {
		$arrLastRecordInserted = $this->getAll("1=1 order by sms_send_id DESC limit 0,1");	
		if(is_array($arrLastRecordInserted) && count($arrLastRecordInserted)>0)
			return $arrLastRecordInserted[0]["sms_send_id"];
		else
			return 1;
	}
	#
	
	function getHistory($user_id=""){
		$ret = "";
		$res = DbBasic::getAll("user_id= '$user_id' order by reg_date DESC limit 0,3");
		//$ret = $res[0]["topica_dienthoai"];
		if(is_array($res) && count($res)>0)
			return $res;
		else
			return "";
		//return $res;
	}
	function getName($id=""){
		$ret = "";
		$res = DbBasic::getAll("id= '$id'");
		$ret = $res[0]["lastname"].' '.$res[0]["firstname"];
		return $ret;
	}
	
}
?>