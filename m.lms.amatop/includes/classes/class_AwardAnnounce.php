<?
/**
*  Created by   : Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class AwardAnnounce extends dbBasic{

	function AwardAnnounce() {
		$this->pkey = "award_announce_id";
		$this->tbl = "award_announce";
	}
	
	function getAllAwardAnnounceInWeek() {
		$last_time_ofweek = $this->getLastTimeOfCurrentWeek();
		$first_time_ofweek = $this->getFirstTimeOfCurrentWeek();
		$arrListAllAwardAnnounceInWeek = $this->getAll("is_online=1 and start_date>=".$first_time_ofweek." and end_date<=".$last_time_ofweek." order by award_announce_id ASC");
		
		if(is_array($arrListAllAwardAnnounceInWeek) && count($arrListAllAwardAnnounceInWeek)>0)
			return $arrListAllAwardAnnounceInWeek;
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