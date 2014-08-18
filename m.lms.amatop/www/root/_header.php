<?
	
	/*
		# Rewrite by: Vu Quoc Trung (trungvq@vietitech.com)
		# Date      : 12/12/2012   
		# Project   : website company
	*/
	
	$_CONFIG = array();//get from DB
	
	$settingCls = new Settings();
	$settingList = $settingCls->SelectAll();
	$settingList1 = $settingCls->GetAll();
	if (is_array($settingList))
	foreach ($settingList as $key => $val){
		if($_LANG_ID=='vn') {
			$_CONFIG[$val->skey] = $val->svalue_en;
		}
		elseif($_LANG_ID=='fr')
		$_CONFIG[$val->skey] = $val->svalue_fr;
		else
		$_CONFIG[$val->skey] = $val->svalue_it;
	}
	#use for status of website - on/off under construction
	
	
	$host = $_SERVER['HTTP_HOST'];
	$self = $_SERVER['PHP_SELF'];
	$query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
	$url = !empty($query) ? "http://$host$self?$query" : "http://$host$self?";
	$en_query = $query.'&amp;lang=en'; 
	$fr_query = $query.'&amp;lang=fr';
	$it_query = $query.'&amp;lang=it';
	if(strstr($url,'&lang')) $url = substr($url,0,-8); //die($url);
	
	if(preg_match("/msie/i",$_SERVER['HTTP_USER_AGENT']))
	$use_browser = "InternetExplorer";
	elseif(preg_match("/Firefox/i",$_SERVER['HTTP_USER_AGENT']))
	$use_browser = "Firefox";
	elseif(preg_match("/Chrome/i",$_SERVER['HTTP_USER_AGENT']))
	$use_browser = "Chrome";	
	else
	$use_browser = "Other";
	
	//canonical
	/*function getCurrentPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
		}
		
		$url_canonical=getCurrentPageURL();
	$assign_list["url_canonical"] = $url_canonical;*/
	
	#LOGIN
	// Inialize session
	//session_start();
	
	$act = $_REQUEST['act'];
	

	//print_r($act);
	
	// Check, if username session is NOT set then this page will jump to login page
	// vietth add cookie check
	
	if($act!='login')
	{
	
		
		if (!isset($_SESSION['username'])) {
			if($_COOKIE['m_secretkey']!='' & $_COOKIE['m_secretkey']==crypt($_COOKIE['m_username'].$_COOKIE['m_userid'],'vietth'))
			{
				$_SESSION['username']=$_COOKIE['m_username'];
				$_SESSION['userid']  =$_COOKIE['m_userid'];
				$_SESSION["user_name"]==$_COOKIE['m_username'];
			}
			else
			{
				header('Location: login.html');
			}
		}
	}
	
	
	$btndoLogin = $_REQUEST['doLogin'];
	$is_logged = 0;
	$cus_username = '';
	if(isset($_SESSION["user_name"])) 
	
	{
		$is_logged = 1;
		$cus_username = $_SESSION["user_name"];
	}
	
	//User Do Login
	
	
	if($btndoLogin == "signin") {
		
		$clsMember = new Member();
		$username = isset($_REQUEST["username"])? strval($_REQUEST["username"]) : "";
		$password = isset($_REQUEST["password"])? strval($_REQUEST["password"]) : "";
		
		
		$username = $core->anti_injection($username);
		//echo $clsMember->checkLogin($username,$password);
		if(!$clsMember->checkLogin($username,$password))
		{
			unset($clsMember);	
			echo'<script>alert("Sai tên đăng nhập hoặc mật khẩu !")</script>';
			echo'<script>window.location="login.html")</script>';
			
		}
	}
	$assign_list["is_logged"] = $is_logged;
	//$assign_list["user_username"] = $user_username;
	$assign_list["cus_username"] = $cus_username;
	
	
	
	#assign	
	$assign_list["_CONFIG"] = $_CONFIG;
	$assign_list["NVCMS_DIR"] = NVCMS_DIR;
	$assign_list["NVCMS_URL"] = NVCMS_URL;
	$assign_list["DIR_IMAGES"] = DIR_IMAGES;
	$assign_list["URL_IMAGES"] = URL_IMAGES;
	$assign_list["URL_UPLOADS"] = URL_UPLOADS;
	$assign_list["URL_UPLOADS_ROOT"] = URL_UPLOADS_ROOT;
	$assign_list["URL_CSS"] = URL_CSS;
	$assign_list["URL_JS"] = URL_JS;
	$assign_list["URL_BUILD"] = URL_BUILD;
	$assign_list["DIR_UPLOADS"] = DIR_UPLOADS;
	$assign_list["_SITE_ROOT"] = $_SITE_ROOT;
	$assign_list["URL_PLAYER"] = URL_PLAYER;
	$assign_list["url"] = $url;
	$assign_list["base_url"] = $url;
	$assign_list["use_browser"] = $use_browser;//global use browser var
	
	$assign_list["host"] = $host;
	$assign_list["self"] = $self;
	$assign_list["query"] = $query;
	$assign_list["en_query"] = $en_query;
	$assign_list["fr_query"] = $fr_query;
	$assign_list["it_query"] = $it_query;
	
	//$username = '';
	//$username = $_SESSION['username'];
	//if($is_logged==1)
	$userid =  $_SESSION['userid'];
	//else
	//$userid = '';
	//print_r($userid);
	//
	#LIST COURSE
	
	
	if($userid!=''){
		$sql="Select c.* from 
		mdl_course c
		inner join mdl_context ct on c.id=ct.instanceid
		inner join mdl_role_assignments ra on ct.id=ra.contextid
		inner join mdl_user u on ra.userid=u.id
		inner join mdl_role r on r.id=ra.roleid
		inner join mdl_course_categories cc on cc.id = c.category
		where 
		r.id=5
		and
		u.id = $userid and c.fullname not like '%h2472%' and c.visible=1";
		//print_r($sql);
	
		$listCourse = $dbconn->GetAll($sql);
		$assign_list["listCourse"] = $listCourse;
		//print_r($sql);
		
	}
	
	
	//List support
	
	$clsNickSupport = new NickSupport();
	
	$arrListAllSupport = $clsNickSupport->getAll("is_online=1 order by order_no ASC limit 0, 4");
	$assign_list["arrListAllSupport"] = $arrListAllSupport;
		
	
	
	##
	#
	##
	/*$table = 'hv_noti_'.$userid;
		$sql_noti ="
		CREATE view $table as
		SELECT
		mdl_quiz.id AS quizid,
		`name`,
		mdl_course.shortname,
		(
		SELECT
		count(*)
		FROM
		mdl_quiz_grades
	WHERE
	quiz = quizid
	AND userid = 12608
	AND grade >= 5
	) sobai
	FROM
	mdl_quiz
	INNER JOIN mdl_course ON mdl_course.id = mdl_quiz.course
	WHERE
	course IN (
	SELECT
	c.id
	FROM
	mdl_user u
	INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
	INNER JOIN mdl_context ct ON ct.id = ra.contextid
	INNER JOIN mdl_course c ON c.id = ct.instanceid
	INNER JOIN mdl_role r ON r.id = ra.roleid
	INNER JOIN mdl_course_categories cc ON cc.id = c.category
	WHERE
	u.id = $userid
	)
	
	ORDER BY
	NAME
	";
	$dbconn->Execute($sql_noti);*/
	
	/*
	*	Mobile device detection
	*/
	if( !function_exists('mobile_user_agent_switch') ){
	function mobile_user_agent_switch(){
	$device = '';
	
	if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
	$device = "ipad";
	} else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
	$device = "iphone";
	} else if( stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ) {
	$device = "blackberry";
	} else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
	$device = "android";
	}
	
	if( $device ) {
	return $device; 
	} return false; {
	return false;
	}
	}
	}
	
	$deviceview = mobile_user_agent_switch();
	$assign_list["deviceview"] = $deviceview;
	
	
	//send comment
	$clsComment = new Comment();
	function sendComment(){
	
	global $dbconn;
	$txtname = isset($_REQUEST['txtname']) ? trim($_REQUEST['txtname']):'';
	$txtemail = isset($_REQUEST['txtemail']) ? trim($_REQUEST['txtemail']):'';
	$txtarea = isset($_REQUEST['txtarea']) ? nl2br($_REQUEST['txtarea']):'';
	$txtsubmit = isset($_REQUEST['txtsubmit']) ? trim($_REQUEST['txtsubmit']):'';
	if($txtsubmit!=''){
	$fields = "name_user, email_user, content";
	$values = "'".$txtname."', '".$txtemail."', '".$txtarea."'";
	$sql  = "INSERT INTO comment ($fields) VALUES($values)";
	if($dbconn->Execute($sql)){
	header('Content-Type: text/html; charset=utf-8');
	echo "<script language=\"javascript\">alert(\"Bình luận của bạn đã được gửi đi. Chúng tôi sẽ phản hồi trong thời gian sớm nhất.\");</script>";
	}
	
	}
	}
	
	sendComment();
	?>	