<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class Category extends dbBasic{
	function Category(){
		global $_LANG_ID;
		$this->pkey = "cat_id";
		$this->tbl = "_category";	
	}
	
	function getCategoryIDFromCategoryType($type_id) {
		$res = DbBasic::getAll("type_id = '".$type_id."' order by order_no ASC limit 0, 1");
		if(is_array($res) && count($res)>0)
			return $res[0]["cat_id"];
		else
			return 0;
	}
	
	function getCategoryIDFromKeyword($str) {
		$res = DbBasic::getByCond("cat_keyword = '".$str."'");
		if(is_array($res) && count($res)>0)
			return $res["cat_id"];
		else
			return 0;
	}
	
	function checkHasSubCategory($parent_id='') {
		$res = DbBasic::getAll("parent_id = '$parent_id' order by order_no ASC");	
		
		if(is_array($res) && count($res)>0)
			return $res;
		else
			return "";
	}
	
	function getChildProductCategory($cat_id='') {
		$arrListChildProductCategory = $this->getAll("is_online=1 and parent_id='".$cat_id."' order by order_no ASC");	
		if(is_array($arrListChildProductCategory) && count($arrListChildProductCategory)>0)
			return $arrListChildProductCategory;
		else
			return "";
	}
	
	function getChildCats($parent_id=''){
		$res = DbBasic::getAll("parent_id = '$parent_id'");
		return $res;
	}
	
	function getParentId($cat_id=''){
		$res = $this->GetOne($cat_id);
		return $res['parent_id'];
	}
	function getTypeId($cat_id=''){
		$res = $this->GetOne($cat_id);
		return $res['type_id'];
	}
	
	function getCategoryKeyword($cat_id=''){
		
		$res = DbBasic::getAll("cat_id= '$cat_id'");
		
		$cat_keyword = (is_array($arrListChildProductCategory) && count($arrListChildProductCategory)>0)? $res[0]['cat_keyword'] : "";
		
		return $cat_keyword;
	}
	
	function getName($cat_id=''){
		global $_LANG_ID;
		
		$name = '';		
		$res = DbBasic::getAll("cat_id= '$cat_id'");
		
		if($_LANG_ID=='en')
			$name = $res[0]["name_en"];
		elseif($_LANG_ID=='fr')
			$name = $res[0]["name_fr"];
		else
			$name = $res[0]["name_it"];
				
		return $name;
	}
	
	
	function getDes($cat_id=''){
		global $_LANG_ID;
		$res = DbBasic::getAll("cat_id= '$cat_id'");
		return ($_LANG_ID=="vn")? $res[0]['des_vn'] : $res[0]['des_en'];
	}
	
	function getNameAlias($cat_id){
		$OneCat = $this->GetOne($cat_id);
		if(is_array($OneCat) && count($OneCat)>0) {
			return $OneCat['name_en_alias'];	
		}
		return 0;
	}
	
	function getCatId($name=""){
		$res = $this->getAll("name='$name'");
		return $res;
	}
	
	function getProductTypeID() {
		global $dbconn;
		
		$arrListTypeProduct = $dbconn->GetAll("select * from _type where type_key='product'");
		if (is_array($arrListTypeProduct) && count($arrListTypeProduct)>0)
			return $arrListTypeProduct[0]["type_id"];
		else
			return 0;
	}
	
	function makeProductQueryString($catid=0, $level=0, &$sqlstr){
		global $dbconn;
		
		$sqlstr .= ($level==0)? "A2.cat_id='".$catid."'" : "";
		$arrListCat = $this->getAll("parent_id='$catid' and type_id='".$this->getProductTypeID()."'");
		if (is_array($arrListCat) && count($arrListCat)>0){
			foreach ($arrListCat as $k => $v){
				$sqlstr .= ($sqlstr=="")? " A2.cat_id='".$v["cat_id"]."'" : " or A2.cat_id='".$v["cat_id"]."'";			
				$this->makeProductQueryString($v["cat_id"], $level+1, &$sqlstr);
			}
			return "";
		}else{
			return "";
		}
	}
	
	function makeNoSuffixProductQueryString($catid=0, $level=0, &$sqlstr){
		global $dbconn;
		
		$sqlstr .= ($level==0)? "cat_id='".$catid."'" : "";
		$arrListCat = $this->getAll("parent_id='$catid' and type_id='".$this->getProductTypeID()."'");
		if (is_array($arrListCat) && count($arrListCat)>0){
			foreach ($arrListCat as $k => $v){
				$sqlstr .= ($sqlstr=="")? " cat_id='".$v["cat_id"]."'" : " or cat_id='".$v["cat_id"]."'";			
				$this->makeProductQueryString($v["cat_id"], $level+1, &$sqlstr);
			}
			return "";
		}else{
			return "";
		}
	}
	
	function getSortCategoryNav($catid) {
		global $dbconn;
		$clsType = new Type();	
		$type_news_id = $clsType->getTypeIDOfCategory("news");
	
		$arrListParentPrimaryDisplay = array();
		$i = 0;
		//$dbconn->debug = true;
		$arrListParentPrimaryDisplay[$i] = $this->getOne($catid);
		
		while(($parent_id = $arrListParentPrimaryDisplay[$i]["parent_id"]) && ($parent_id != 0)) {
			$i++;
			$arrListParentPrimaryDisplay[$i] = $this->getByCond("cat_id='$parent_id' and type_id='".$type_news_id."'");
		}
		
		for($k=$i; $k>=0; $k--) 
			$arrListParentPrimaryResort[$i-$k] = $arrListParentPrimaryDisplay[$k];
		
		if(is_array($arrListParentPrimaryResort) && count($arrListParentPrimaryResort)>0)
			return $arrListParentPrimaryResort; 
		else
			return "";
	}
	
	function getOrderNoParentID($catid) {
		$order_no = 0;
		
		$arrListParentPrimaryResort = $this->getSortCategoryNav($catid);
		if($arrListParentPrimaryResort != "") {
			$arrListOneCategory = $this->getOne($arrListParentPrimaryResort[0]['cat_id']);
			if(is_array($arrListOneCategory) && count($arrListOneCategory)>0)	
				$order_no = $arrListOneCategory['order_no']; 
		}
		
		return $order_no;
	}
	
	function getAliasCategoryName($cat_id=''){
		global $_LANG_ID;
		$res = DbBasic::getAll("cat_id= '$cat_id'");
		
		$name = $res[0]['url'];
		return $name;
	}
	
	function getCategoryIDFromNameAlias($str='') {
		$arrListOneCategory = $this->getAll("is_online=1 and url='".$str."' order by order_no ASC");	
		if(is_array($arrListOneCategory) && count($arrListOneCategory)>0)
			return $arrListOneCategory[0]["cat_id"];
		else
			return "";
	}
	
	function getServiceTypeID() {
		global $dbconn;
		
		$arrListTypeProduct = $dbconn->GetAll("select * from _type where type_key='service'");
		if (is_array($arrListTypeProduct) && count($arrListTypeProduct)>0)
			return $arrListTypeProduct[0]["type_id"];
		else
			return 0;
	}
	
	function makeServiceQueryString($catid=0, $level=0, &$sqlstr){
		global $dbconn;
		
		if($catid != 0)
			$sqlstr .= ($level==0)? "A1.cat_id='".$catid."'" : "";
			
		$arrListCat = $this->getAll("parent_id='".$catid."' and type_id='".$this->getServiceTypeID()."'");
		if (is_array($arrListCat) && count($arrListCat)>0){
			foreach ($arrListCat as $k => $v){
				$sqlstr .= ($sqlstr=="")? " A1.cat_id='".$v["cat_id"]."'" : " or A1.cat_id='".$v["cat_id"]."'";			
				$this->makeServiceQueryString($v["cat_id"], $level+1, &$sqlstr);
			}
			return "";
		}else{
			return "";
		}
	}
	
	function getThreeImageHotelCategory($catid=0) {
		global $dbconn;
		$this->makeMixedQueryString($catid, 0, $sqlcond);
		$sql = "select A1.image, A1.link from hotels as A1 where A1.is_online=1 and A1.image<>''";
		$sql .= ($sqlcond == '')? "" : " and (".$sqlcond.")";
		$sql .= " order by A1.order_no ASC limit 0,3";
		$arrListImage = $dbconn->getAll($sql);
		if (is_array($arrListImage) && count($arrListImage)>0)
			return $arrListImage;
		else
			return "";
	}
		
	function makeMixedQueryString($catid=0, $level=0, &$sqlstr){
		global $dbconn;
		
		if($catid != 0)
			$sqlstr .= ($level==0)? "A1.cat_id='".$catid."'" : "";
			
		$arrListCat = $this->getAll("parent_id='".$catid."'");
		if (is_array($arrListCat) && count($arrListCat)>0){
			foreach ($arrListCat as $k => $v){
				$sqlstr .= ($sqlstr=="")? " A1.cat_id='".$v["cat_id"]."'" : " or A1.cat_id='".$v["cat_id"]."'";			
				$this->makeMixedQueryString($v["cat_id"], $level+1, &$sqlstr);
			}
			return "";
		}else{
			return "";
		}
	}
	
	function makeAdverQueryString($catid=0, $level=0, &$sqlstr){
		global $dbconn;
		
		if($catid != 0)
			$sqlstr .= ($level==0)? "cat_id='".$catid."'" : "";
			
		$arrListCat = $this->getAll("parent_id='".$catid."'");
		if (is_array($arrListCat) && count($arrListCat)>0){
			foreach ($arrListCat as $k => $v){
				$sqlstr .= ($sqlstr=="")? " cat_id='".$v["cat_id"]."'" : " or cat_id='".$v["cat_id"]."'";			
				$this->makeAdverQueryString($v["cat_id"], $level+1, &$sqlstr);
			}
			return "";
		}else{
			return "";
		}
	}
	function getCategoryNameFromNameAlias($str='') {
		$arrListOneCategory = $this->getAll("is_online=1 and name_en_alias='".$str."' order by order_no ASC");	
		if(is_array($arrListOneCategory) && count($arrListOneCategory)>0)
			return $arrListOneCategory[0]["name_en"];
		else
			return "";
	}
	
	function getCatIDCategoryNameAlias($str=''){
		global $_LANG_ID;
		$res = DbBasic::getAll("name_en_alias= '$str'");
		
		$cat_id = $res[0]['cat_id'];
		return $cat_id;
	}
}
?>