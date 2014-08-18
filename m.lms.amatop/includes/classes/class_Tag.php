<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)	
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class Tag extends dbBasic{

	function Tag(){
		$this->pkey = "tag_id";
		$this->tbl = "_tag";
	}
	
	function getTagsName($tag_id) {
		$arrListOneTagsName = $this->getOne($tag_id);
		if(is_array($arrListOneTagsName) && count($arrListOneTagsName)>0)
			return $arrListOneTagsName["name"];
		else
			return "";
	}
	#
	function getLastID() {
		$arrLastRecordInserted = $this->getAll("1=1 order by tag_id DESC limit 0,1");	
		if(is_array($arrLastRecordInserted) && count($arrLastRecordInserted)>0)
			return $arrLastRecordInserted[0]["tag_id"];
		else
			return 1;
	}
	#
	
	function getLastTagID() {
		$tag_id = 1;
		$arrTagsExists = $this->getAll("1=1 order by tag_id DESC limit 0, 1");
		if(is_array($arrTagsExists) && count($arrTagsExists)>0)
			{
				$tag_id = $arrTagsExists[0]["tag_id"];
			}
		
		return $tag_id;
	}
	function getNewsIDFromUrl($str) {
		$res = DbBasic::getByCond("name_alias = '".$str."'");
		if(is_array($res) && count($res)>0)
			return $res["tag_id"];
		else
			return 0;
	}
}
?>