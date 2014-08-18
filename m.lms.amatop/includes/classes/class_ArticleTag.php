<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class ArticleTag extends dbBasic{
	function ArticleTag(){
		$this->tbl = 'article_tag';
		$this->pkey = 'article_id';
	}
	#
	function getLastID() {
		$arrLastRecordInserted = $this->getAll("1=1 order by article_id DESC limit 0,1");	
		if(is_array($arrLastRecordInserted) && count($arrLastRecordInserted)>0)
			return $arrLastRecordInserted[0]["article_id"];
		else
			return 1;
	}
	#

}
?>