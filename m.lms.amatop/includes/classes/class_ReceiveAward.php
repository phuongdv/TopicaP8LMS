<?
/**
*  Created by   : Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class ReceiveAward extends dbBasic{

	function ReceiveAward() {
		$this->pkey = "receive_award_id";
		$this->tbl = "receive_award";
	}
	
	function getReceiveAwardLastWeek() {
		$last_time_ofweek = $this->getLastTimeOfCurrentWeek() - 7 * 24 * 3600;
		$first_time_ofweek = $this->getFirstTimeOfCurrentWeek() - 7 * 24 * 3600;
		$arrListReceiveAwardInWeek = $this->getAll("is_online=1 and start_date>=".$first_time_ofweek." and end_date<=".$last_time_ofweek." order by receive_award_id ASC");
		
		if(is_array($arrListReceiveAwardInWeek) && count($arrListReceiveAwardInWeek)>0)
			return $arrListReceiveAwardInWeek;
		else
			return "";
	}
	
	function getOnePersonReceiveAward($ltow, $ftow) {
		$last_time_ofweek = $ltow;
		$first_time_ofweek = $ftow;
		$arrListReceiveAwardInWeek = $this->getAll("is_online=1 and start_date>=".$first_time_ofweek." and end_date<=".$last_time_ofweek." order by receive_award_id ASC");
		
		if(is_array($arrListReceiveAwardInWeek) && count($arrListReceiveAwardInWeek)>0)
			return $arrListReceiveAwardInWeek;
		else
			return "";
	}	
	
	function getLastTimeOfCurrentWeek() {
		$current_time = time();
		$current_day_inweek = date('N', $current_time);
		$last_day_inweek = (7 - $current_day_inweek) * 24 * 3600 + $current_time;
		
		$last_time_ofweek = $this->convertStrToTimeFromIntTime($last_day_inweek);
		
		return $last_time_ofweek;
	}
	
	function getFirstTimeOfCurrentWeek() {
		$current_time = time();
		$current_day_inweek = date('N', $current_time);
		$first_day_inweek = $current_time - ( $current_day_inweek - 1 ) * 24 * 3600;
		
		$first_time_ofweek = $this->convertStrToTimeFromIntTime($first_day_inweek);
		
		return $first_time_ofweek;
	}
	
	function convertStrToTimeFromIntTime($int_time = "") {
		$int_convert = ($int_time != "")? $int_time : time();
		$cday = date('d', $int_convert);
		$cmonth = date('m', $int_convert);
		$cyear = date('Y', $int_convert);
		
		$str_to_time = $cmonth . "/" . $cday . "/" . $cyear;
		
		return strtotime($str_to_time);
	}
}
?>