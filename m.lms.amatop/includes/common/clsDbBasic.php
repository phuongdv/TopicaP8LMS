<?
/**
*  Database Handling version 2.0
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class DbBasic{
	var $pkey 		= 	"";
	var $tbl 		= 	"";	
	var $arrCond 		= 	array();
	var $arrOperator 	=	array();
	var $arrError 	= 	array();
	var $hasError 	= 	0;
	var $objName	=	"ObjTable";
	function DbBasic(){
		//nothing
	}
	//Set debug mode On/Off
	function SetDebug($debug=true){
		global $dbconn;
		$dbconn->debug = $debug;
	}
	//set condition $cond + $operator(AND, OR)
	function SetCond($cond, $operator=""){
		array_push($this->arrCond, $cond);
		array_push($this->arrOperator, $operator);
	}
	//get contition string
	function GetCond(){
		$condStr = "";
		if (is_array($this->arrCond)){
			foreach ($this->arrCond as $key => $val){
				$condStr.= " $val ".$this->arrOperator[$key];
			}
		}
		return $condStr;
	}
	//empty condition
	function EmptyCond(){
		$this->arrCond = array();
	}
	//Select One
	function SelectOne($_pkey=""){
		global $dbconn;		
		//get condition
		$cond = $this->getCond();
		if ($cond==""){
			$pkey = $this->pkey;
			$pkeyvalue = $_pkey;
			$cond = ($pkeyvalue!="")? "".$pkey."='".$pkeyvalue."'" : "";
		}
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "SELECT * FROM ".$this->tbl." $where";
		$dbconn->debug =true;
		$rs = $dbconn->Execute($sql); 
		$obj = new $this->objName;
		if ($rs){
			$arr = $rs->FetchRow();//get a row
			if (is_array($arr)){
				foreach ($arr as $key => $val){
					$obj->set($key, $val);
				}  		
			}
		}
		return $obj;		
	}
	//Select All
	function SelectAll($orderby="", $start=0, $limit=0){
		global $dbconn;
		//get condition
		$cond = $this->getCond();
		$where = ($cond!="")? " WHERE $cond" : "";
		$orderby = ($orderby!="")? "ORDER BY $orderby" : "";
		$limit = ($limit!="")? "LIMIT $start, $limit" : "";
		$sql = "SELECT * FROM ".$this->tbl." $where $orderby $limit";
		$rs = $dbconn->Execute($sql); 
		$arrObj = array();
		if ($rs){
			while ($arr = $rs->FetchRow()) { 
				$obj = new $this->objName; 
				foreach ($arr as $key => $val){
					$obj->set($key, $val);
				}  	
				array_push($arrObj, $obj);	
			} 
		}
		return $arrObj;				
	}
	//Insert obj
	function Insert($objTable){
		global $dbconn;
		$class_vars = get_class_vars(get_class($objTable));
		$fields = $values = array();
		foreach ($class_vars as $name => $value) {
			array_push($fields, $name);
			array_push($values, $objTable->$name);
		}
		$sql  = "INSERT INTO ".$this->tbl."($fields) VALUES($values)";
		if (!$dbconn->Execute($sql)){
			trigger_error("Cannot run SQL: `$sql`", E_USER_ERROR);
			return 0;
		}		
		return 1;
	}
	//Update obj
	function Update($objTable){
		global $dbconn;
		$class_vars = get_class_vars(get_class($objTable));
		$set = "";
		foreach ($class_vars as $name => $value) {
			$set = ($set=="")? "$name = '".$this->$name."'" : ", $name = '".$objTable->$name."'";
		}
		//get condition
		$cond = $obj->getCond();
		if ($cond==""){
			$pkey = $this->pkey;
			$pkeyvalue = $this->$pkey;
			$cond = ($pkeyvalue!="")? "".$pkey."='".$pkeyvalue."'" : "";
		}
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "UPDATE ".$this->tbl." SET $set $where";
		if (!$dbconn->Execute($sql)){
			trigger_error("Cannot run SQL: `$sql`", E_USER_ERROR);
			return 0;
		}
		return 1;				
	}
	//Delete obj
	function Delete(){
		global $dbconn;
		//get condition
		$cond = $this->getCond();
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "DELETE FROM ".$this->tbl." $where";
		if (!$dbconn->Execute($sql)){
			trigger_error("Cannot run SQL: `$sql", E_USER_ERROR);
			return 0;
		}
		return 1;		
	}
	//Count Item
	function Count($cond=""){
		global $dbconn;
		$sql = "SELECT COUNT(*) AS total FROM ".$this->tbl;
		//get condition
		$cond = $this->getCond();
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$res = $dbconn->GetRow($sql);
		if ($res['total']=="" || $res['total']==null)
			return 0;
		return $res['total'];
	}
	function Max($field, $cond=""){
		global $dbconn;
		$sql = "SELECT MAX($field) AS total FROM ".$this->tbl;
		//get condition
		$cond = $this->getCond();
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$res = $dbconn->GetRow($sql);
		if ($res['total']=="" || $res['total']==null)
			return 1;
		return ($res['total']+1);
	}
	function Sum($field, $cond=""){
		global $dbconn;
		$sql = "SELECT SUM($field) AS total FROM ".$this->tbl;
		//get condition
		$cond = $this->getCond();
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$res = $dbconn->GetRow($sql);
		if ($res['total']=="" || $res['total']==null)
			return 0;
		return $res['total'];
	}
	//Execute a sql
	function ExecSql($sql){
		global $dbconn;
		return $dbconn->Execute($sql);
	}
	//=======================================
	//Integrate with old version
	//=======================================
	function getAll($cond=""){
		global $dbconn;
		$where = "";
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "SELECT * FROM ".$this->tbl." $where";
		$res = $dbconn->GetAll($sql);
		if (count($res)>0){
			return $res;
		}else{
			return 0;
		}
	}
	function getOne($_pkey=""){
		global $dbconn;
		$sql = "SELECT * FROM ".$this->tbl." WHERE ".$this->pkey."='$_pkey'";
		$res = $dbconn->GetRow($sql);
		if (count($res)>0){
			return $res;
		}else{
			return 0;
		}
	}
	function getByCond($cond=""){
		global $dbconn;
		$where = "";
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "SELECT * FROM ".$this->tbl." $where";
		$res = $dbconn->GetRow($sql);
		if (count($res)>0){
			return $res;
		}else{
			return 0;
		}
	}
	//Insert
	function insertOne($fields="", $values=""){
		global $dbconn;
		if (count($fields)!=count($values))return 0;
		$sql  = "INSERT INTO ".$this->tbl."($fields) VALUES($values)";
		//echo $sql;
		if (!$dbconn->Execute($sql)) return 0;
		
		return 1;
	}
	//Update
	function updateOne($_pkey="", $set=""){
		global $dbconn;
		if ($set=="") return;
		$sql = "UPDATE ".$this->tbl." SET $set WHERE ".$this->pkey."='$_pkey'";
		$dbconn->Execute($sql);
		return 1;
	}
	//Update by condition
	function updateByCond($cond="", $set=""){
		global $dbconn;
		$where = "";
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "UPDATE ".$this->tbl." SET $set $where";
		$dbconn->Execute($sql);
		return 1;	
	}
	//Delete
	function deleteOne($_pkey=""){
		global $dbconn;
		$sql = "DELETE FROM ".$this->tbl." WHERE ".$this->pkey."='$_pkey'";
		$dbconn->Execute($sql);
		return 1;
	}
	function deleteByCond($cond=""){
		global $dbconn;
		$where = "";
		if ($cond!=""){
			$where .= " WHERE $cond";
		}
		$sql = "DELETE FROM ".$this->tbl." $where";
		$dbconn->Execute($sql);
		return 1;
	}
	function countItem($cond=""){
		global $dbconn;
		$sql = "SELECT COUNT(*) AS totalitem FROM ".$this->tbl;
		if ($cond!=""){
			$sql.= "  WHERE $cond";
		}
		$res = $dbconn->GetRow($sql);
		if ($res['totalitem']=="" || $res['totalitem']==null)
			return 0;
		return $res['totalitem'];
	}
	function maxItem($field, $cond=""){
		global $dbconn;
		$sql = "SELECT MAX($field) AS total FROM ".$this->tbl;
		if ($cond!=""){
			$sql.= " WHERE $cond";
		}
		$res = $dbconn->GetRow($sql);
		if ($res['total']=="" || $res['total']==null)
			return 1;
		return ($res['total']+1);
	}
	function sumItem($field, $cond=""){
		global $dbconn;
		$sql = "SELECT SUM($field) AS total FROM ".$this->tbl;
		if ($cond!=""){
			$sql.= " WHERE $cond";
		}
		$res = $dbconn->GetRow($sql);
		if ($res['total']=="" || $res['total']==null)
			return 0;
		return $res['total'];
	}
	function getByField($pkey, $field){
		$res = $this->getOne($pkey);
		return $res[$field];
	}	
		
}

/**
*  Table Handling
*  @author		: Tran Anh Tuan
*  @date		: 25/11/2006
*  @version		: 2.1.0
*/
class ObjTable{
	//init class
	function ObjTable(){
		//nothing
	}
	//set value to field
	function set($field, $value){
		$this->$field = $value;
	}
	//get value from a field
	function get($field){
		return $this->$field;
	}
}
?>