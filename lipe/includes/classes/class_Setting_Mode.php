<?php
class Setting_Mode extends DbBasic{
	
	function Setting_Mode(){
		$this->pkey = "id";
		$this->tbl = "lipe_course_mode";	
	}		
	
	function getModeReport($c_id) {
		global $dbconn;
		$sql2 = "select mode from $this->tbl where course = '$c_id' limit 0,1";
		$res = $dbconn->GetAll($sql2);
		if(is_array($res)) {
			$variable = $res[0]["mode"];
		}
		
		return $variable;
		
	}
	
	function getModeReportName($c_id) {
		global $dbconn;
		$sql2 = "select mode from $this->tbl where course = '$c_id' limit 0,1";
		$res = $dbconn->GetAll($sql2);
		if(is_array($res)) {
			$variable = $res[0]["mode"];
		}
		
		switch($variable)
		{
		case '1':
		return 'M_CoOffline';
		break;
		case '2':
		return 'M_KoOffline_CoDienDan';
		break;
		case '3':
		return 'M_KoOffline_KoDienDan';
		break;
		}
		
	}
	
	function getMode_canhan($c_id) {
		global $dbconn;
		$sql2 = "select mode from $this->tbl where course = '$c_id' limit 0,1";
		$res = $dbconn->GetAll($sql2);
		if(is_array($res)) {
			$variable = $res[0]["mode"];
		}
		return $variable;
	}
	function getMode($c_id) {
		global $dbconn;
		$sql2 = "select mode from $this->tbl where course = '$c_id' limit 0,1";
		$res = $dbconn->GetAll($sql2);
		if(is_array($res)) {
			$variable = $res[0]["mode"];
		}
		if($variable=='')
		{
		return 'Chưa set';
		}
		else 
		{
		switch($variable)
		{
		case '1':
		return 'M_CoOffline';
		break;
		case '2':
		return 'M_KoOffline_CoDienDan';
		break;
		case '3':
		return 'M_KoOffline_KoDienDan';
		break;
		}
		}
	}
	
	function setMode($c_id,$mode)
	{
		//$this->SetDebug(true);
		global $dbconn;
		$sql2 = "select mode from $this->tbl where course = '$c_id' limit 0,1";
		$res = $dbconn->GetAll($sql2);
		if(is_array($res)) {
			$variable = $res[0]["mode"];
		}
		if($variable=='')
		{
		 echo $this->insertOne("course,mode", "'".$c_id."','".$mode."'");
		 if($mode=='2') // co dien dan thi them tim
		 {
		 $sql="insert into mdl_block_instance (blockid,pageid,pagetype,position,weight,visible) values ('45','$c_id','course-view','l','1','1')";
		 $res = $dbconn->GetAll($sql);
		 }
		 
		}
		else 
		{
		echo $this->updateByCond(" course=".$c_id,"mode='".$mode."'"); 
		
		}
		
		
	}
	
	
}


?>