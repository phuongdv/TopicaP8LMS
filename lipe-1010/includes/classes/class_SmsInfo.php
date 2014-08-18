<?
class SmsInfo extends DbBasic{
	
	function SmsInfo(){
		$this->pkey = "sms_info_id";
		$this->tbl = "sms_info";	
	}
	
	function getLastID() {
		$arrLastRecordInserted = $this->getAll("1=1 order by sms_info_id DESC limit 0,1");	
		if(is_array($arrLastRecordInserted) && count($arrLastRecordInserted)>0)
			return $arrLastRecordInserted[0]["sms_info_id"];
		else
			return 1;
	}		
	
	
}
?>





