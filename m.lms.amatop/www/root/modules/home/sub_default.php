<?
function checkRun($url) {
		 $AgetHeaders = @get_headers($url);
		 $status='';
		if (preg_match("|200|", $AgetHeaders[0])) {
			 $status=1;
		// file exists
		} else {
			$status=0;
		// file doesn't exists
		}
		return $status;
	}
/*
# Rewrite by: Vu Quoc Trung (trungvq@vietitech.com)
# Date      : 12/12/2012   
# Project   : website company
*/
function default_default(){

	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	
	//$clsCategory = new Category();
	//$clsTour = new Tour();
	//$clsNews = new News();	
	//$clsInfo = new Info();
	//$clsVideo = new Video();
	
	//new in nhome 
	//$arrListTourHome = $clsTour->getAll("is_online=1 and is_home=1 order by upd_date DESC limit 0,9");
	//$arrListDiemDuLichHome = $clsNews->getAll("is_online=1 and cat_id=221 order by upd_date DESC limit 0,3");
	//$arrListTinDuLichHome = $clsNews->getAll("is_online=1 and cat_id=220 order by upd_date DESC limit 0,3");
	//$infoDanang = $clsInfo->getOne(8);
	//$arrListDesignHome = $clsNhome->getAll("is_online=1 and cat_id=1 order by order_no ASC limit 0,1");
	//$arrListWebFreeHome = $clsNhome->getAll("is_online=1 and cat_id=2 order by order_no ASC limit 0,1");
	//$assign_list["arrListTourHome"] = $arrListTourHome;
//	$assign_list["arrListDiemDuLichHome"] = $arrListDiemDuLichHome;
	//$assign_list["arrListTinDuLichHome"] = $arrListTinDuLichHome;
	//$assign_list["infoDanang"] = $infoDanang;
}

/*
# Rewrite by: Vu Quoc Trung (trungvq@vietitech.com)
# Date      : 12/12/2012   
# Project   : website company
*/
function default_btvn(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	
	$clsMdlCourse = new MdlCourse();
	
	$userid =  $_SESSION['userid'];
	
	$assign_list["clsMdlCourse"] = $clsMdlCourse;
	$assign_list["userid"] = $userid;
	$assign_list["secret"]  =$userid.'vietth'; 
	setcookie("back_url",'http://m.tvu.topica.vn/btvn.html', time()+10*3600, '','.topica.vn','');
	
}

/*
# Rewrite by: Vu Quoc Trung (trungvq@vietitech.com)
# Date      : 12/12/2012   
# Project   : website company
*/
function default_lttn(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	
	$clsMdlCourse = new MdlCourse();
	
	$userid =  $_SESSION['userid'];
	
	$assign_list["clsMdlCourse"] = $clsMdlCourse;
	$assign_list["userid"] = $userid;
	$assign_list["secret"]  =$userid.'vietth'; 
	setcookie("back_url",'http://m.tvu.topica.vn/lttn.html', time()+10*3600,'','.topica.vn','');
}

function default_lipe(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	
	$clsSettingCalendar = new Setting_Calendar();
    $clsOffline= new Offline();
    $clsmode=new Setting_Mode();
   // $mode=$clsmode->getModeReport($c_id);
    
	$userid =  $_SESSION['userid'];
	$username =  $_SESSION['username'];
	
	$assign_list["userid"] = $userid;
	$assign_list["username"] = $username;
	$assign_list["clsSettingCalendar"] = $clsSettingCalendar;
	$assign_list["clsOffline"] = $clsOffline;
	$assign_list["clsmode"] = $clsmode;
}

function default_viewpdf(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	
	$clsMdlCourse = new MdlCourse();
	$link = $_REQUEST['url'];
	
	$link = str_replace("http:/", "", $link);
	
	$link = 'http://'.$link;
	
	$c_id = isset($_REQUEST["id"])? $_REQUEST["id"] : "";
	$OneCourse = $clsMdlCourse->getOne($c_id);
	$NameCourse = $OneCourse['fullname'];
	
	$userid =  $_SESSION['userid'];
	$username =  $_SESSION['username'];
	
	$assign_list["userid"] = $userid;
	$assign_list["username"] = $username;
	$assign_list["NameCourse"] = $NameCourse;
	$assign_list["link"] = $link;
	$assign_list["c_id"] = $c_id;
	
}

function default_viewvideo(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	
	$clsMdlCourse = new MdlCourse();
	//$link = $_REQUEST['url'];
	
	
	$c_id = isset($_REQUEST["id"])? $_REQUEST["id"] : "";
	$weekid = isset($_REQUEST["week"])? $_REQUEST["week"] : "";
	$OneCourse = $clsMdlCourse->getOne($c_id);
	$NameCourse = $OneCourse['fullname'];
	preg_match("/^(.*?)\./",$NameCourse,$arr);
	$NameCourseS=$arr[1];
	$table_name='course_'.strtolower($NameCourseS);
	
	$sql_video = "select * from $table_name where `id` = '$weekid'";
	//print_r($sql_video);
	$arrListVideo = $dbconn->getAll($sql_video);
	$link = 'http://m.eldata.topica.vn/'.$NameCourseS;
	
	$userid =  $_SESSION['userid'];
	$username =  $_SESSION['username'];
	
	$assign_list["userid"] = $userid;
	$assign_list["username"] = $username;
	$assign_list["NameCourse"] = $NameCourse;
	$assign_list["arrListVideo"] = $arrListVideo;
	$assign_list["c_id"] = $c_id;
	$assign_list["link"] = $link;
	//echo 'here';
}
function default_viewmp3(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	
	$clsMdlCourse = new MdlCourse();
	$link = $_REQUEST['url'];
	
	$link = str_replace("http:/", "", $link);
	
	$link = 'http://'.$link;
	//print_r($link);
	$c_id = isset($_REQUEST["id"])? $_REQUEST["id"] : "";
	$OneCourse = $clsMdlCourse->getOne($c_id);
	$NameCourse = $OneCourse['fullname'];
	
	$userid =  $_SESSION['userid'];
	$username =  $_SESSION['username'];
	
	$assign_list["userid"] = $userid;
	$assign_list["username"] = $username;
	$assign_list["NameCourse"] = $NameCourse;
	$assign_list["link"] = $link;
	$assign_list["c_id"] = $c_id;
}



function default_course(){

	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	
	$clsSettingCalendar = new Setting_Calendar();
	$clsMdlCourse = new MdlCourse();
	
	$userid =  $_SESSION['userid'];
	$username =  $_SESSION['username'];
	
	$assign_list["secret"]  =$userid.'vietth';
	/*$xml = simplexml_load_file("http://115.146.127.234/mdata/FIN102/information.xml") 
       or die("Error: Cannot create object");
	   
	foreach($xml->children() as $Week){
		foreach($Week->children() as $Courseware => $data){
		  echo $data->Lession;
		  echo $data->Title;
		  echo $data->PDF;
		  echo "<br />";
		}
	}*/
	
	$c_id = isset($_REQUEST["id"])? $_REQUEST["id"] : "";
	
	setcookie("back_url",'http://m.tvu.topica.vn/course-'.$c_id.'.html', time()+10*3600,'','.topica.vn','');
	
	$OneCourse = $clsMdlCourse->getOne($c_id);
	$NameCourse = $OneCourse['fullname'];
	
	//print_r($c_id);die();
	//preg_match('/thuonghieu\=([0-9]+)/i',$url,$arr)
	preg_match("/^(.*?)\./",$NameCourse,$arr);
	$NameCourseS=$arr[1];
	//print_r();die();
	
	## function ARRAY ##
	function xml2array($xml){
    $opened = array();
    $opened[1] = 0;
    $xml_parser = xml_parser_create();
    xml_parse_into_struct($xml_parser, $xml, $xmlarray);
    $array = array_shift($xmlarray);
    unset($array["level"]);
    unset($array["type"]);
    $arrsize = sizeof($xmlarray);
    for($j=0;$j<$arrsize;$j++){
        $val = $xmlarray[$j];
        switch($val["type"]){
            case "open":
                $opened[$val["level"]]=0;
            case "complete":
                $index = "";
                for($i = 1; $i < ($val["level"]); $i++)
                    $index .= "[" . $opened[$i] . "]";
                $path = explode('][', substr($index, 1, -1));
                $value = &$array;
                foreach($path as $segment)
                    $value = &$value[$segment];
                $value = $val;
                unset($value["level"]);
                unset($value["type"]);
                if($val["type"] == "complete")
                    $opened[$val["level"]-1]++;
            break;
            case "close":
                $opened[$val["level"]-1]++;
                unset($opened[$val["level"]]);
            break;
        }
    }
    return $array;
} 
	### END ##
	
	##GET XML TONG ##
	$url = 'http://m.eldata.topica.vn/TVU.xml';
	$doc =new DOMDocument();
	$doc->load($url);
	$channels=$doc->getElementsByTagName("Course"); // lay noi dung cua Week
	$url_course_show='';
	foreach( $channels as $channel )
  	{
  		$url_course = $channel->getElementsByTagName( $NameCourseS );
  		$url_course_show = $url_course->item(0)->nodeValue;
  		//echo $url_course_show;
  	}
	
	##END##
	if($url_course_show!=''){
		
		//$s = '';
		//echo($url_course_show);
		//
		//echo($homepage);
		##GET XML COURSE##
		//$xmlstr = file_REQUEST_contents($url_course_show);
		//$xml = new DOMDocument();
		//$xml->loadXML($s);
		//$xmlArray = xml2array($xml);
		//print_r($xmlArray);die();
		//$homepage = file_REQUEST_contents($url_course_show);
		
		
	}
	else{
		echo 'Môn học này hiện tại chưa cập nhật phiên bản mobile';	
	}
	//print_r($url_course_show);
	
	$url_course_show = trim($url_course_show);
	$checkHocLieu = checkRun($url_course_show);
	
	//print_r($checkHocLieu);die();
	
	if($checkHocLieu==1){
		$table_name='course_'.strtolower($NameCourseS);
		##check table exist
		
		// SQL query
		$sql_2 = "SHOW TABLES LIKE '$table_name'";
		
		$result = $dbconn->getAll($sql_2);
		
		if(is_array($result) && count($result)>0)
			$count_table=1;
		else
			$count_table=0;
		
		##
		if($count_table==0){
			## Creat Table
			$creat_sql ="CREATE TABLE IF NOT EXISTS ".$table_name." (
						`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
						`c_id`  int(10) NOT NULL ,
						`week`  int(2) NOT NULL ,
						`lession`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`pdf`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`video_1`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`video_2`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`video_3`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`video_4`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`video_5`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`video_6`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`video_7`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`video_8`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`video_9`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`video_10`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`PDFTK_1`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`PDFTK_2`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`PDFTK_3`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`PDFTK_4`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						`mp3`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
						PRIMARY KEY (`id`)
						)
						;
					";
			$dbconn->Execute($creat_sql);
		
		
			$docCourse =new DOMDocument();
			$docCourse->load($url_course_show);
			$channels=$docCourse->getElementsByTagName("Weeks"); // lay noi dung cua Week
	
			foreach($channels as $channel)
			{
				$week=0;
				$Items =$channel->getElementsByTagName("Week"); // lay noi dung cua tag item
				foreach($Items as $Item)
				{
					
					$week=$week+1;
					
					$Lessions =$Item->getElementsByTagName("Courseware");
					$numOfLessions = $Lessions->length;
					//echo 'show';print_r($numOfLessions);die();
					
					if($numOfLessions==1){ 
						foreach($Lessions as $Lession)
						{
								$LessionShow=$Lession->getElementsByTagName("Lession");
								$newLessionShow = $LessionShow->item(0)->nodeValue ;
								$Title=$Lession->getElementsByTagName("Title");
								$newTitle = $Title->item(0)->nodeValue ;
								$PDF=$Lession->getElementsByTagName("PDF");
								$newPDF = $PDF->item(0)->nodeValue ;
								
								$MP3=$Lession->getElementsByTagName("MP3");
								$newMP3 = $MP3->item(0)->nodeValue ;
								//echo 'here';
								if($newLessionShow!='')
									$lession_insert = $newLessionShow." : ".$newTitle;
								else
									$lession_insert = $newTitle;
								/*if($newLession<>'')
									$lession_insert = $newLession.' : '.$newTitle;
								else
									$lession_insert = '';*/
								$video_1=$Lession->getElementsByTagName("video_1");
								$newVideo_1 = $video_1->item(0)->nodeValue ;
								$video_2=$Lession->getElementsByTagName("video_2");
								$newVideo_2 = $video_2->item(0)->nodeValue ;
								$video_3=$Lession->getElementsByTagName("video_3");
								$newVideo_3 = $video_3->item(0)->nodeValue ;
								$video_4=$Lession->getElementsByTagName("video_4");
								$newVideo_4 = $video_4->item(0)->nodeValue ;
								$video_5=$Lession->getElementsByTagName("video_5");
								$newVideo_5 = $video_5->item(0)->nodeValue ;
								$video_6=$Lession->getElementsByTagName("video_6");
								$newVideo_6 = $video_6->item(0)->nodeValue ;
								$video_7=$Lession->getElementsByTagName("video_7");
								$newVideo_7 = $video_7->item(0)->nodeValue ;
								$video_8=$Lession->getElementsByTagName("video_8");
								$newVideo_8 = $video_8->item(0)->nodeValue ;
								$video_9=$Lession->getElementsByTagName("video_9");
								$newVideo_9 = $video_9->item(0)->nodeValue ;
								$video_10=$Lession->getElementsByTagName("video_10");
								$newVideo_10 = $video_10->item(0)->nodeValue ;
								
								$PDFTK_1=$Lession->getElementsByTagName("PDFTK_1");
								$newPDFTK_1 = $PDFTK_1->item(0)->nodeValue ;
								$PDFTK_2=$Lession->getElementsByTagName("PDFTK_2");
								$newPDFTK_2 = $PDFTK_2->item(0)->nodeValue ;
								$PDFTK_3=$Lession->getElementsByTagName("PDFTK_3");
								$newPDFTK_3 = $PDFTK_3->item(0)->nodeValue ;
								$PDFTK_4=$Lession->getElementsByTagName("PDFTK_4");
								$newPDFTK_4 = $PDFTK_4->item(0)->nodeValue ;
								
								
								$sql_insert = "INSERT INTO $table_name (c_id, week, lession, pdf, mp3, video_1, video_2, video_3, video_4, video_5, video_6, video_7, video_8, video_9, video_10,PDFTK_1,PDFTK_2,PDFTK_3,PDFTK_4)
	VALUES ('".$c_id."','".$week."', '".$lession_insert."', '".$newPDF."','".$newMP3."','".$newVideo_1."','".$newVideo_2."','".$newVideo_3."','".$newVideo_4."','".$newVideo_5."','".$newVideo_6."','".$newVideo_7."','".$newVideo_8."','".$newVideo_9."','".$newVideo_10."','".$newPDFTK_1."','".$newPDFTK_2."','".$newPDFTK_3."','".$newPDFTK_4."') ";
								//print_r($sql_insert);//die();
						
								$dbconn->Execute($sql_insert);
							
							
								
							
						}
					}
					if($numOfLessions==2){
						$num=0;
						foreach($Lessions as $Lession)
						{
							/*$num=$num+1;
							$i=$num-1;*/
								$LessionShow=$Lession->getElementsByTagName("Lession");
								$newLessionShow = $LessionShow->item(0)->nodeValue ;
								$Title=$Lession->getElementsByTagName("Title");
								$newTitle = $Title->item(0)->nodeValue ;
								$PDF=$Lession->getElementsByTagName("PDF");
								$newPDF = $PDF->item(0)->nodeValue ;
								$Slide=$Lession->getElementsByTagName("Slide");
								$newSlide = $Slide->item(0)->nodeValue ;
								$MP3=$Lession->getElementsByTagName("MP3");
								$newMP3 = $MP3->item(0)->nodeValue ;
								
								$lession_insert = $newLessionShow." : ".$newTitle;
								
								$video_1=$Lession->getElementsByTagName("video_1");
								$newVideo_1 = $video_1->item(0)->nodeValue ;
								$video_2=$Lession->getElementsByTagName("video_2");
								$newVideo_2 = $video_2->item(0)->nodeValue ;
								$video_3=$Lession->getElementsByTagName("video_3");
								$newVideo_3 = $video_3->item(0)->nodeValue ;
								$video_4=$Lession->getElementsByTagName("video_4");
								$newVideo_4 = $video_4->item(0)->nodeValue ;
								$video_5=$Lession->getElementsByTagName("video_5");
								$newVideo_5 = $video_5->item(0)->nodeValue ;
								$video_6=$Lession->getElementsByTagName("video_6");
								$newVideo_6 = $video_6->item(0)->nodeValue ;
								$video_7=$Lession->getElementsByTagName("video_7");
								$newVideo_7 = $video_7->item(0)->nodeValue ;
								$video_8=$Lession->getElementsByTagName("video_8");
								$newVideo_8 = $video_8->item(0)->nodeValue ;
								$video_9=$Lession->getElementsByTagName("video_9");
								$newVideo_9 = $video_9->item(0)->nodeValue ;
								$video_10=$Lession->getElementsByTagName("video_10");
								$newVideo_10 = $video_10->item(0)->nodeValue ;
								
								$PDFTK_1=$Lession->getElementsByTagName("PDFTK_1");
								$newPDFTK_1 = $PDFTK_1->item(0)->nodeValue ;
								$PDFTK_2=$Lession->getElementsByTagName("PDFTK_2");
								$newPDFTK_2 = $PDFTK_2->item(0)->nodeValue ;
								$PDFTK_3=$Lession->getElementsByTagName("PDFTK_3");
								$newPDFTK_3 = $PDFTK_3->item(0)->nodeValue ;
								$PDFTK_4=$Lession->getElementsByTagName("PDFTK_4");
								$newPDFTK_4 = $PDFTK_4->item(0)->nodeValue ;
								
								$sql_insert = "INSERT INTO $table_name (c_id, week, lession, pdf, mp3, video_1, video_2, video_3, video_4, video_5, video_6, video_7, video_8, video_9, video_10,PDFTK_1,PDFTK_2,PDFTK_3,PDFTK_4)
	VALUES ('".$c_id."','".$week."', '".$lession_insert."', '".$newPDF."','".$newMP3."','".$newVideo_1."','".$newVideo_2."','".$newVideo_3."','".$newVideo_4."','".$newVideo_5."','".$newVideo_6."','".$newVideo_7."','".$newVideo_8."','".$newVideo_9."','".$newVideo_10."','".$newPDFTK_1."','".$newPDFTK_2."','".$newPDFTK_3."','".$newPDFTK_4."') ";
								
								$dbconn->Execute($sql_insert);
						
						
								/*$Title_1=$Lession->getElementsByTagName("Title");
								$newTitle_1 = $Title_1->item(1)->nodeValue ;
								$PDF_1=$Lession->getElementsByTagName("PDF");
								$newPDF_1 = $PDF_1->item(1)->nodeValue ;
								$Slide_1=$Lession->getElementsByTagName("Slide");
								$newSlide_1 = $Slide_1->item(1)->nodeValue ;
								$MP3_1=$Lession->getElementsByTagName("MP3");
								$newMP3_1 = $MP3_1->item(1)->nodeValue ;
								
								
								$sql_insert_1 = "INSERT INTO $table_name (c_id, week, lession, pdf, slide, mp3)
	VALUES ('".$c_id."','".$week."', '".$newTitle_1."', '".$newPDF_1."','".$newSlide_1."','".$newMP3_1."') ";
								$dbconn->Execute($sql_insert_1);*/
						}
					}
					
				}    
			
			}
		}
		## End check exit table
		
		$date = time();
		
		$sql_calendar = "select * from huy_setting_calendar where start_date < '$date' and end_date >= '$date' and c_id='".$c_id."' and week_name not like '%tong%'";
		
		$arrCalendar = $dbconn->getAll($sql_calendar);
		if(is_array($arrCalendar) && count($arrCalendar)>0)
			$arrCalendarTop = $arrCalendar;
		else {
			$arrCalendarTop = $dbconn->getAll("select * from huy_setting_calendar where c_id='".$c_id."' and (week_name like '%8%' and end_date < '$date') or (week_name like '%1%' and start_date > '$date')");
		}
			
			//$sql = "select * from huy_setting_calendar where (week_name like '%8%' and end_date < '$date') or (week_name like '%1%' and start_date > '$date') and c_id='".$c_id."'";
		//print_r($arrCalendarTop);
		//
		$tuan = preg_replace('/[^0-9]/','',$arrCalendarTop[0]['week_name']);
		//print_r($tuan);die();
		$sql_TuanHienTai = "select * from $table_name where `week` = '$tuan'";
		$TuanHienTai = $dbconn->getAll($sql_TuanHienTai);
		
		//print_r($sql_TuanHienTai);
		
		$sql_listTuan = "select DISTINCT(`week`) from $table_name where `week` <> '$tuan' ";
		$listTuan = $dbconn->getAll($sql_listTuan);
		//print_r($sql_listTuan);
		//$arrListInCourse
	}
	$clsQuiz = new Quiz();
	$enddate = date('Y-m-d',$OneCourse['enrolenddate']);

	//print_r($show);
	$assign_list["userid"] = $userid;
	$assign_list["username"] = $username;
	$assign_list["clsSettingCalendar"] = $clsSettingCalendar;
	//$assign_list["show"] = $show;
	$assign_list["checkHocLieu"] = $checkHocLieu;
	$assign_list["TuanHienTai"] = $TuanHienTai;
	$assign_list["listTuan"] = $listTuan;
	$assign_list["NameCourse"] = $NameCourse;
	$assign_list["arrCalendarTop"] = $arrCalendarTop;
	$assign_list["c_id"] = $c_id;
	$assign_list["clsQuiz"] = $clsQuiz;
	$assign_list["NameCourseS"] = $NameCourseS;
	$assign_list["C_start"]     = date('Y-m-d',$OneCourse['enrolstartdate']);
	//$assign_list["C_end"]       = date('Y-m-d',$OneCourse['enrolenddate']);
	$assign_list["C_end"]       = date('Y-m-d',strtotime($enddate." +1 week" ));
	
	$assign_list["table_name"] = $table_name;
	
}
/*
# Write by: Truong Huu Viet (contact.vietth@gmail.com)
# Date      : 13/05/2013   
# Project   : website company
*/
	function default_h2472(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	$clsMdlCourse = new MdlCourse();
	$clsH2472     = new H2472();
	
	$c_id = isset($_REQUEST["id"])? $_REQUEST["id"] : "";
	$u_id = $_SESSION['userid'];
	$OneCourse = $clsMdlCourse->getOne($c_id);
	

	$assign_list["NameCourse"] 	= $OneCourse['fullname'];
    $assign_list["ArrH2472"]   	= $clsH2472->get_by_userid($u_id,$c_id);	 
    $assign_list["uid"]   		= $u_id;
    $assign_list["cid"]   		= $c_id;
    $assign_list["secret"]  	= $u_id.'vietth';
	$assign_list["clsH2472"] 	= $clsH2472;

  }

/*
# Rewrite by: Vu Quoc Trung (trungvq@vietitech.com)
# Date      : 12/12/2012   
# Project   : website company
*/

function default_lang(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID;
	
	$gquery = isset($_REQUEST["query"])? $_REQUEST["query"] : ""; 
	$query_decode = (!empty($gquery))? $core->decodeURL($gquery) : ""; 
	$return_qry = substr($query_decode,0,-12); 
	if(!empty($return_qry)) header("Location: ".NVCMS_URL."/index.php?".$return_qry);
	else
		header("Location: ".NVCMS_URL."/index.html");
}



?>