<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class NickSupport extends dbBasic{

	function NickSupport(){
		$this->pkey = "nick_support_id";
		$this->tbl = "nick_support";
	}
	
	function getNickSupportName($nick_support_id) {
		$arrOneNickSupportName = $this->getOne($nick_support_id);
		if(is_array($arrOneNickSupportName) && count($arrOneNickSupportName)>0)
			{
				return $arrOneNickSupportName["name"];
			}
		else
			return "";
	}
	
	function getNickSupportValue($nick_support_id) {
		$arrOneNickSupportName = $this->getOne($nick_support_id);
		if(is_array($arrOneNickSupportName) && count($arrOneNickSupportName)>0)
			{
				return $arrOneNickSupportName["value"];
			}
		else
			return "";
	}
}
?>