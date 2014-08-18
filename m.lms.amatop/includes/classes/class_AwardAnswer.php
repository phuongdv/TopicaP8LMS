<?
/**
*  Created by   : Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class AwardAnswer extends dbBasic{

	function AwardAnswer() {
		$this->pkey = "award_answer_id";
		$this->tbl = "award_answer";
	}
	
	function getAllAwardAnswer($award_ask_id) {
		$arrListAwardAnswer = $this->getAll("award_ask_id='".$award_ask_id."' order by order_no ASC");
		
		if(is_array($arrListAwardAnswer) && count($arrListAwardAnswer)>0)
			return $arrListAwardAnswer;
		else
			return "";
	}
}
?>