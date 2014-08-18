<?
/**
*  News Table Class
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2007/04/01
   @date-modify : 2009/01/06	
*  @version		: 2.1.0
*/
class Marketing extends dbBasic{

	function Marketing(){
		$this->pkey = "marketing_id";
		$this->tbl = "_marketing";
	}
	
	function getNameTour($news_id) {
		global $_LANG_ID;
		
		$tour_name = "";
		$arrListOneTour = $this->getOne($news_id);
		if(is_array($arrListOneTour) && count($arrListOneTour)>0) {
			if($_LANG_ID=='en')
				$tour_name = $arrListOneTour["title_en"];
			elseif($_LANG_ID=='fr')
				$tour_name = $arrListOneTour["title_fr"];
			else
				$tour_name = $arrListOneTour["title_it"];
		}
			
		return $tour_name;
	}
	
	function removeTags($str) {
		$begin_char_1 ='&#60;';
		$begin_char_2 ='&lt;';
		$begin_char_1 ='&gt;';
		
		$str2 = $str;
		$num = strlen($str);
		$ok = 0;
		for ($i = 0; $i < $num; $i++) {
			if($str[$i]=='&' && $str[$i+1]=='l' && $str[$i+2]=='t' && $str[$i+3]==';'){
				$ok = 1;
			}
			if($str[$i]=='&' && $str[$i+1]=='#' && $str[$i+2]=='6' && $str[$i+3]=='0' && $str[$i+4]==';'){
				$ok = 1;
			}
			if($str[$i]=='&' && $str[$i+1]=='g' && $str[$i+2]=='t' && $str[$i+3]==';'){
				$ok = 0;
			}
			if($ok == 1){
				$str2[$i]='.';
			}
			else{
				$str2[$i]=$str[$i];
			}
		}
		
		$num2 = strlen($str2);
		for ($i = 0; $i < $num2; $i++) {
			
			if($str[$i]=='&' && $str[$i+1]=='g' && $str[$i+2]=='t' && $str[$i+3]==';'){
				$str2[$i]='.';
				$str2[$i+1]='.';
				$str2[$i+2]='.';
				$str2[$i+3]='.';
				$i=$i+4;
			}
		}
		return $str2;
	}
	//Lay tin moi nhat trong Cat
	function getNewsCatID($catid){
		$res = $this->getAll("cat_id='$catid' order by reg_date desc limit 0,1");					
		return $res;
	}
	//Lay 2 tin cung loai
	function getNewsCatIDOther($catid,$id){
		$res = $this->getAll("cat_id='$catid'and news_id <> '$id' and is_new=1 and is_online=1 order by news_id desc limit 0,2");					
		return $res;
	}
	
	function getNewsInHomePage($cat_id=0, $limit=10) {
		$arrListAllNews = $this->getAll("is_online=1 and cat_id='".$cat_id."' order by reg_date DESC");
		if(is_array($arrListAllNews)>0 && count($arrListAllNews)>0)
			return $arrListAllNews;
		else
			return "";
	}
	
	function getNewsInCategory($cat_id=0, $limit='') {
		$arrListAllNews = ($limit != '')? $this->getAll("is_online=1 and is_focus=0 and is_hot=0 and cat_id='".$cat_id."' order by order_no ASC limit 0,".$limit) : $this->getAll("is_online=1 and is_focus=0 and is_hot=0 and cat_id='".$cat_id."' order by order_no ASC");
		if(is_array($arrListAllNews)>0 && count($arrListAllNews)>0)
			return $arrListAllNews;
		else
			return "";
	}
	
	function totalNewsMemberPosted($member_id) {
		$total_posted = 0;
		
		$total_posted = $this->countItem("member_id='".$member_id."'");
		
		return $total_posted;
	}
	
	function addURLRelative($strtag='') {
		if(preg_match('/img/',$strtag)) {	
			$strtag = preg_replace('/img/isxmU', 'img style="padding:10px;"', $strtag); 
			if(preg_match('/uploads/',$strtag))
				$strtag = preg_replace('/uploads/', URL_UPLOADS, $strtag); 
		}
		if(!empty($strtag))
			$strtag = str_replace(array("▄","�","��"),array("","",""),html_entity_decode(trim($strtag)));
		return html_entity_decode($strtag);
	}
	
	function getNewIDFromNameAlias($str='') {
		$arrListOneNews = $this->getAll("is_online=1 and title_en_alias='".$str."' order by reg_date DESC");	
		if(is_array($arrListOneNews) && count($arrListOneNews)>0)
			return $arrListOneNews[0]["news_id"];
		else
			return 0;
	}
	function getNewsIDFromUrl($str) {
		$res = DbBasic::getByCond("title_en_alias = '".$str."'");
		if(is_array($res) && count($res)>0)
			return $res["news_id"];
		else
			return 0;
	}
}
?>