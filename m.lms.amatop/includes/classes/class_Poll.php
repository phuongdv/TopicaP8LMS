<?
class Poll extends dbBasic{
	var $pollid;
	var $question;
	var $start_date;
	var $end_date;
	var $order_no;
	var $is_online;
	function Poll(){
		$this->pkey = "poll_id";
		$this->tbl 	= "poll";
	}
	
	function isEqual($arr_permiss=array(),$modname="", $pre=""){
		$status = 0;
		if ($pre!="") $modname = $pre.$modname;
		if(is_array($arr_permiss)){
			foreach($arr_permiss as $key => $val){
				if($val == $modname){
					$status = 1;
					break;
				}
			}
		}		
		return $status;
	}
	
	function canView($arr_temp,$name){
		$arr = @unserialize($arr_temp);
		if (@in_array($name, $arr)) return 1;
		return 0;
	}
	
	function htmlDecode($var){
		if (is_array($var)){
			foreach ($var as $k => $v){
				$var[$k] = $this->htmlDecode($v);
			}
		}else{
			$var = html_entity_decode($var);
		}
		return $var;
	}	
}
?>