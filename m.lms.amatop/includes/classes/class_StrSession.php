<?
class StringSessionID extends dbBasic{
	
	function StringSessionID(){
		$this->pkey = "session_key_id";
		$this->tbl = "session_key";
	}	
	
	function checkStringSessionIDExist($session_id) {
		$arrOneCheck = $this->getByCond("sid='".$session_id."'");
		if(is_array($arrOneCheck) && count($arrOneCheck)>0)
			return $arrOneCheck["session_key_id"];
		else
			return 0;
	}
	
	function getSessionID($session_key_id) {
		$arrOneCheck = $this->getOne($session_key_id);
		if(is_array($arrOneCheck) && count($arrOneCheck)>0)
			return $arrOneCheck["sid"];
		else
			return "";
	}
}
?>