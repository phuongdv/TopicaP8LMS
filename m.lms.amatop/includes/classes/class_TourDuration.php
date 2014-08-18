<?
class TourDuration extends dbBasic{
	function TourDuration(){
		$this->pkey = "duration_id";
		$this->tbl = "tour_duration";
	}
	
	function getNameTourDuration($duration_id) {
		global $_LANG_ID;
		
		$tour_duration_name = "";
		$arrListOneTourDuration = $this->getOne($duration_id);
		if(is_array($arrListOneTourDuration) && count($arrListOneTourDuration)>0) {
			if($_LANG_ID=='en')
				$tour_duration_name = $arrListOneTourDuration["name_en"];
			elseif($_LANG_ID=='fr')
				$tour_duration_name = $arrListOneTourDuration["name_fr"];
			else
				$tour_duration_name = $arrListOneTourDuration["name_it"];
		}
			
		return $tour_duration_name;
	}
	
}
?>