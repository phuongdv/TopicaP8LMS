<?
/*
# Rewrite by: Vu Quoc Trung (trungvq@vietitech.com)
# Date      : 12/12/2012   
# Project   : website company
*/

function default_default(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	
	$clsType = new Type();	
	$clsCategory = new Category();
	$clsNews = new News();
	require_once DIR_COMMON."/clsPage.php";
	
	$clsPage = new clsPage();
	$cpage = isset($_GET["page"])? intval($_GET["page"]) : 0;
	$OneCat = $clsCategory->getOne(220);
	
	$sql = "select A1.* from _news as A1 where A1.is_online=1 and A1.cat_id=220 order by A1.order_no ASC";
	
	$rs = $dbconn->Execute($sql);	 
	$total_records = $rs->RowCount();		
	$record_per_page = ($_CONFIG["SITE_NUM-WEBMOBILE"]!="" && intval($_CONFIG["SITE_NUM-WEBMOBILE"])!=0)? intval($_CONFIG["SITE_NUM-WEBMOBILE"]) : 9;
	$scroll = 5;
	$page_name = NVCMS_URL."/tin-tuc-du-lich/";
	
	$clsPage->set_page_data($page_name,$total_records,$record_per_page,$scroll,true,true,true);
	$arrListNews = $dbconn->GetAll($clsPage->get_limit_query($sql));
	$showPage=$clsPage->get_page_nav();	
	$total_page=$clsPage->total_page();
	if(count($arrHot) == 1){
		$countNews=1;
	}
	//$arrListFocus = $clsNews->getAll("is_online=1 and is_focus=1 order by order_no ASC limit 0, 1");
	
	#SEO CONFIG
	//seo title
		if($OneCat['seo_title']!='')
			$seo_title = $OneCat['seo_title'];
		else
			$seo_title = $OneCat['name_en'].' | di du lich da nang';
		$assign_list["seo_title"] = $seo_title;
	//seo description
		if($OneCat['seo_description']!='')
			$seo_description = $OneCat['seo_description'];
		else
			$seo_description = $OneCat['name_en'].', tin tuc du lich';
		$assign_list["seo_description"] = $seo_description;
	//seo keyword
		if($OneCat['seo_keyword']!='')
			$seo_keyword = $OneCat['seo_keyword'];
		else
			$seo_keyword = $OneCat['name_en'].', di du lich da nang, tin tuc du lich';
		$assign_list["seo_keyword"] = $seo_keyword;
	//seo image
		$seo_image = URL_UPLOADS.'/'.$arrListTour[0]['image_small'];
		$assign_list["seo_image"] = $seo_image;
	//seo published_time
		$seo_published_time = $arrListTour[0]['reg_date'];
		$assign_list["seo_published_time"] = $seo_published_time;
	//seo modified_time
		$seo_modified_time = $arrListTour[0]['upd_date'];
		$assign_list["seo_modified_time"] = $seo_modified_time;
	
	$assign_list["cpage"] = $cpage;
	$assign_list["record_per_page"] = $record_per_page;
	$assign_list["total_records"] = $total_records;
	$assign_list["total_page"] = $total_page;	
	$assign_list["showPage"] = $showPage;	
	$assign_list["arrListNews"] = $arrListNews;
	$assign_list["countNews"] = $countNews;
	
	$assign_list["arrListFocus"] = $arrListFocus;
}


function default_view(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	$clsCategory = new Category;
	$clsNews 	=    new News();
	$clsTag = new Tag();
	
	$news_title_alias = isset($_GET["title_alias"])? trim($_GET["title_alias"]) : "";
	$arrListOneNewsDetail = $clsNews->getByCond("title_en_alias='".$news_title_alias."'");
	
	
	$new_id=$clsNews->getNewsIDFromUrl($news_title_alias);
	
	$arrTag = $clsTag->getAll("is_online=1 and tag_id in (select tag_id from article_tag where news_id='".$new_id."')");
	
	$number_same_news = 10;
	$arrListSameNews = $clsNews->getAll("is_online=1 and news_id<>'".$new_id."' and cat_id=220 order by reg_date DESC limit 0, ".$number_same_news);
	
	
	$assign_list["arrListOneNewsDetail"] = $arrListOneNewsDetail;
	$assign_list["arrListSameNews"] = $arrListSameNews;
	$assign_list["arrTag"] = $arrTag;
	
	#SEO CONFIG
	//seo title
		if($arrListOneNewsDetail['seo_title']!='')
			$seo_title = $arrListOneNewsDetail['seo_title'];
		else
			$seo_title = $arrListOneNewsDetail['title_en'];
		$assign_list["seo_title"] = $seo_title;
	//seo description
		if($arrListOneNewsDetail['seo_description']!='')
			$seo_description = $arrListOneNewsDetail['seo_description'];
		else
			$seo_description = $arrListOneNewsDetail['title_en'];
		$assign_list["seo_description"] = $seo_description;
	//seo keyword
		if($arrListOneNewsDetail['seo_keyword']!='')
			$seo_keyword = $arrListOneNewsDetail['seo_keyword'];
		else
			$seo_keyword = $arrListOneNewsDetail['title_en'];
		$assign_list["seo_keyword"] = $seo_keyword;
	//seo image
		$seo_image = URL_UPLOADS.'/'.$arrListOneNewsDetail['image_small'];
		$assign_list["seo_image"] = $seo_image;
	//seo published_time
		$seo_published_time = $arrListOneNewsDetail['reg_date'];
		$assign_list["seo_published_time"] = $seo_published_time;
	//seo modified_time
		$seo_modified_time = $arrListOneNewsDetail['upd_date'];
		$assign_list["seo_modified_time"] = $seo_modified_time;
}

?>