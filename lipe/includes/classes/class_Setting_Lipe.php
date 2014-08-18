<?
class Setting_Lipe extends DbBasic{
	
	function Setting_Lipe(){
		$this->pkey = "id";
		$this->tbl = "huy_setting_lipe";	
	}		
	
	function getLipeAtiveID($c_id) {
		$arrListLipeInfo = $this->getOne($c_id);
		$active_id = is_array($arrListLipeInfo)? $arrListLipeInfo["active_id"] : 1;
		
		return $active_id;
	}
	
	function getLipeLipeID($c_id) {
		$arrListLipeInfo = $this->getOne($c_id);
		$lipe_type = is_array($arrListLipeInfo)? $arrListLipeInfo["lipe_type"] : 1;
		
		return $lipe_type;
	}
}
?>