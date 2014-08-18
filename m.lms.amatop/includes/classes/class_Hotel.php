<?
class Hotel extends dbBasic{
	function Hotel(){
		$this->pkey = "hotel_id";
		$this->tbl = "hotels";
	}
	
	function getNameHotel($hotel_id) {
		global $_LANG_ID;
		
		$hotel_name = "";
		$arrListOneHotel = $this->getOne($hotel_id);
		if(is_array($arrListOneHotel) && count($arrListOneHotel)>0) {
			if($_LANG_ID=='en')
				$hotel_name = $arrListOneHotel["name"];
			elseif($_LANG_ID=='fr')
				$hotel_name = $arrListOneHotel["name"];
			else
				$hotel_name = $arrListOneHotel["name"];
		}
			
		return $hotel_name;
	}
	
	function getHotelFromCatIDAndStarID($cat_id=0,$star_id=0) {
		$arrListAllHotel = $this->getAll("cat_id='".$cat_id."' and star_id='".$star_id."' and is_online=1 order by order_no ASC");
		if(is_array($arrListAllHotel) && count($arrListAllHotel)>0)
			return $arrListAllHotel;
		else
			return "";
	}
	
	function addFullHttpLink($str = '') {
		if(!preg_match('/(http)/is',$str))
			$str = 'http://'.$str;
		return $str;
	}
}
?>