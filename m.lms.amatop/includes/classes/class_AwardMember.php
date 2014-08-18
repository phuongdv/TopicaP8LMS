<?
class AwardMember extends dbBasic{

	function AwardMember(){
		$this->pkey = "member_award_id";
		$this->tbl = "member_award";
	}	
	
	function checkAwardMemberExist($email="") {
		$arrListAwardMemberExist = $this->getAll("email='".$email."'");
		if(is_array($arrListAwardMemberExist) && count($arrListAwardMemberExist)>0)
			return $arrListAwardMemberExist[0]["member_award_id"];
		else
			return 0;
	}	
}
?>