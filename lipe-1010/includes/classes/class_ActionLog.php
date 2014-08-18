<?php

class ActionLog extends DbBasic{
	
	function ActionLog(){
		$this->pkey = "id";
		$this->tbl = "lipe_action_log";	
	}		
		function insertValue($username, $action, $value){
		dbBasic::insertOne("username,action,value,time", "'".$username."','".$action."','".$value."',NOW()");
	}
	
}

?>