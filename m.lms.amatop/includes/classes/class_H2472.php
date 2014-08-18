<?
class H2472 extends dbBasic{
	function H2472(){
		$this->pkey = "id";
		$this->tbl = "tblthread";
	}
	
	function get_by_userid($u_id,$c_id){
		global $dbconn;
		
		$sql_h2472 = "select *,unix_timestamp()-time delay from tblthread where userid = $u_id and courseid=$c_id ";
		//echo $sql_h2472;
		$res=$dbconn->getAll($sql_h2472);
		
		if(is_array($res) && count($res)>0)
			return $res;
		else
			return "";
		
	}
	
	function secondsToTime($seconds)
{
	
    // extract hours
    $hours = floor($seconds / (60 * 60));
    
	// day 
	$day   =  floor($hours / 24);
	$divisor_hour = $hours % 24;
    // extract minutes
    $divisor_for_minutes = $seconds % (60 * 60);
    $minutes = floor($divisor_for_minutes / 60);
 
    // extract the remaining seconds
    $divisor_for_seconds = $divisor_for_minutes % 60;
    $seconds = ceil($divisor_for_seconds);
 
    // return the final array
    $obj = array(
	    "d" => (int) $day,
        "h" => (int) $divisor_hour,
        "m" => (int) $minutes,
        "s" => (int) $seconds,
    );
	$result = '';
	if($obj['d']>0)
	$result .=$obj['d'].'d';
	
	if($obj['h']>0)
	$result .=$obj['h'].'h';
	
	if($obj['m']>0)
	$result .=$obj['m'].'m';
	
    return $result;
}
	
}

?>