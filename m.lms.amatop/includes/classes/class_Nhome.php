<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class Nhome extends dbBasic{

	function Nhome(){
		$this->pkey = "nhome_id";
		$this->tbl = "nhome";
	}
	
	function getNewsInHomePage($cat_id=0, $limit=10) {
		$arrListAllNews = $this->getAll("is_online=1 and cat_id='".$cat_id."' order by reg_date DESC");
		if(is_array($arrListAllNews)>0 && count($arrListAllNews)>0)
			return $arrListAllNews;
		else
			return "";
	}
	
	function getNewsInCategory($cat_id=0, $limit='') {
		$arrListAllNews = ($limit != '')? $this->getAll("is_online=1 and cat_id='".$cat_id."' order by order_no ASC limit 0,".$limit) : $this->getAll("is_online=1 and cat_id='".$cat_id."' order by order_no ASC");
		if(is_array($arrListAllNews)>0 && count($arrListAllNews)>0)
			return $arrListAllNews;
		else
			return "";
	}
	
	function addURLRelative($strtag='') {
		if(preg_match('/img/',$strtag)) {	
			$strtag = preg_replace('/img/isxmU', 'img style="padding:10px;"', $strtag); 
			if(preg_match('/uploads/',$strtag))
				$strtag = preg_replace('/uploads/', URL_UPLOADS, $strtag); 
		}
		
		return html_entity_decode($strtag);
	}
	
	function getNewIDFromNameAlias($str='') {
		$arrListOneNews = $this->getAll("is_online=1 and title_en_alias='".$str."' order by reg_date DESC");	
		if(is_array($arrListOneNews) && count($arrListOneNews)>0)
			return $arrListOneNews[0]["nhome_id"];
		else
			return 0;
	}
	
	function getCategoryAliasName($catid=0) {
		global $core;
		$name_alias = 'unknow';
		$arrListCategoryHome = array(0 => $core->get_Lang("RadTour"), 1 => $core->get_Lang("TrekkingTours"), 2 => $core->get_Lang("VipServices"), 3 => $core->get_Lang("HumanActivities"));
		foreach($arrListCategoryHome as $k => $v)
			if($k==$catid) $name_alias = strtolower($core->stripUnicode($v));
		
		return $name_alias;
	}
}
?>