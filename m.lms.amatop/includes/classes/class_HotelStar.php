<?
class HotelStar extends dbBasic{
	function HotelStar(){
		$this->pkey = "star_id";
		$this->tbl = "hotel_star";
	}
	
	function getNameHotelStar($star_id) {
		global $_LANG_ID;
		
		$star_name = "";
		$arrListOneHotelStar = $this->getOne($star_id);
		if(is_array($arrListOneHotelStar) && count($arrListOneHotelStar)>0) {
			if($_LANG_ID=='en')
				$star_name = $arrListOneHotelStar["name_en"];
			elseif($_LANG_ID=='fr')
				$star_name = $arrListOneHotelStar["name_fr"];
			else
				$star_name = $arrListOneHotelStar["name_it"];
		}
			
		return $star_name;
	}
	
}
?>