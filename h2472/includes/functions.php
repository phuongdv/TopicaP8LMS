<?php
function return_status_excel($status)
{
 switch ($status){
 	case("0"):
 		$result=$_SESSION['lang'] == 'vn' ? "Mở" : "Open";
 		break;
 	case("1"):
 		$result=$_SESSION['lang'] == 'vn' ? "Đã đóng" : "Closed";
 		break;
 	case("2"):
 		$result=$_SESSION['lang'] == 'vn' ? "Đã hoàn thành" : "Completed";
 		break;
 	case("3"):
 		$result=$_SESSION['lang'] == 'vn' ? "Chờ thực hiện" : "Awaiting";
 		break;
	case("4"):
 		$result=$_SESSION['lang'] == 'vn' ? "Đã đóng" : "Closed";
 		break;	
 }
return $result;	
}
function getAllCvht($id)
	{		
global $db,$template;
			$sql="SELECT distinct u.id userid, u.lastname ho,u.firstname ten
			FROM mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE
			r.id = 3 
			AND
			u.firstname not like '%test%'
			ORDER BY u.firstname ";
					$sql_subject_results = $db->sql_query($sql);
					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))
					{
						$template->assign_block_vars('CVHT',array(
						'id'		=> displayData_DB($sql_subject_result['userid']),
						'name'		=> displayData_DB($sql_subject_result['ho']).' '.displayData_DB($sql_subject_result['ten']),
                        'selected'		=> ($sql_subject_result['userid']==$id) ? ' selected' : '',
						));
					} 
}
function getAllPo($id)
	{		
global $db,$template;
			$sql="SELECT distinct u.id userid, u.lastname ho,u.firstname ten
			FROM mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE
			r.id = 13 
			AND
			u.firstname not like '%test%'
			ORDER BY u.firstname ";
					$sql_subject_results = $db->sql_query($sql);
					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))
					{
						$template->assign_block_vars('PO',array(
						'id'		=> displayData_DB($sql_subject_result['userid']),
						'name'		=> displayData_DB($sql_subject_result['ho']).' '.displayData_DB($sql_subject_result['ten']),
                        'selected'		=> ($sql_subject_result['userid']==$id) ? ' selected' : '',
						));
					} 
}
function getAllGv($id)
	{		
global $db,$template;
			$sql="SELECT distinct u.id userid, u.lastname ho,u.firstname ten
			FROM mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE
			r.id in (4,14)
			AND
			u.firstname not like '%test%'
			ORDER BY u.firstname ";
					$sql_subject_results = $db->sql_query($sql);
					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))
					{
						$template->assign_block_vars('GV',array(
						'id'		=> displayData_DB($sql_subject_result['userid']),
						'name'		=> displayData_DB($sql_subject_result['ho']).' '.displayData_DB($sql_subject_result['ten']),
                        'selected'		=> ($sql_subject_result['userid']==$id) ? ' selected' : '',
						));
					} 
}


function checkVietnamese($docs)
{



    //Bảng chữ cái có dấu (blcn: Copy muốn gãi cả tay)



    $pattern = '/á|à|ả|ã|ạ|â|ấ|ầ|ẩ|ẫ|ậ|ă|ắ|ằ|ẵ|ặ|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|í|ì|ỉ|ĩ|ị|ó|ò|ỏ|õ|ọ|ơ|ớ|ờ|ở|ỡ|ợ|ô|ố|ồ|ổ|ỗ|ộ|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|ý|ỳ|ỷ|ỹ|ỵ|đ/';



    // If trên 5 chữ thì check



    if (count(explode(" ", $docs)) >= 5) {



        //Nếu có chữ nào trùng trong bản thì đích thị là nó



        if (preg_match($pattern, $docs))



            return true;



        //Không thì chịu



        else



            return false;



    }



    // Dưới 5 chữ, bỏ kiểm, duyệt!



    else



        return false;



}























function get_email($u_id)

{

Global $db;



$sql="select email from mdl_user where id='".$u_id."' ";	



$result = $db->sql_query($sql) or die(mysql_error());



$user = $db->sql_fetchrow($result);



return $user['email'];		

	

	

}

//Danglx 13-01-2014: lay email ca nhan
function get_email_canhan($u_id)

{

Global $db;



$sql="select email_canhan from mdl_user where id='".$u_id."' ";	



$result = $db->sql_query($sql) or die(mysql_error());



$user = $db->sql_fetchrow($result);
return $user['email_canhan'];		


}

function send_mail($subject='testmail',$sendto,$content='this a testmail',$cc,$fromname='H2472 ',$from='h2472support@topica.edu.vn')

{

	include("class.phpmailer.php");

	$mail             = new PHPMailer();

	

	$mail->CharSet = 'utf-8';

    $mail->IsSMTP();

    $mail->SMTPAuth   = true;                  // enable SMTP authentication



	$mail->Host       = "ssl://smtp.gmail.com";      // sets GMAIL as the SMTP server

	$mail->Port       = 465;                   // set the SMTP port for the GMAIL server

	$mail->Username   = "h2472support@topica.edu.vn";  // GMAIL username

	$mail->Password   = "viet!@#$";            // GMAIL password

	if($cc!='')

	{

	$mail->AddCC($cc,'lexuandang');

	}

    $mailTo=$sendto;

//$mail->AddReplyTo("email@dohoavn.info","First Last");



$receiver="";

$mail->From       = $from; 

$mail->FromName   = $fromname;



$mail->Subject    = $subject;



//$mail->Body       = "Hi,<br>This is the HTML BODY<br>";                      //HTML Body

//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->WordWrap   = 50; // set word wrap



$mail->MsgHTML($content);



$mail->AddAddress($mailTo, $receiver);



//$mail->AddAttachment("img/t_c.gif");             // attachment



$mail->IsHTML(true); // send as HTML

$mail->Send();	



}





function get_picture($u_id)

{

global $db;
global $linkelearning;

$sql="select picture from mdl_user where id=".$u_id;

$picture_results = $db->sql_query($sql);

$picture=$db->sql_fetchrow($picture_results);

if ($picture['picture']!=0)

{

	return '<p><img src="'.$linkelearning.'/user/pix.php?file=/'.$u_id.'/f1.jpg" width="100" height="100" alt="" class="avatar" /></p>';

}

else 

{

	return '<p><img src="./assets/images/nopic.gif" alt="" class="avatar" /></p>';

}

}





function get_course($u_id)

{

global $db;

$sql="SELECT topica_lop

FROM mdl_user



where id=".$u_id."";

$sql_course_results = $db->sql_query($sql);

$course='';



					while($course_results = $db->sql_fetchrow($sql_course_results))



					{

						$course=$course.''.$course_results['topica_lop'];

					}

	

return $course;	

	

	

}





function getallmonhoc($monhoc)
{
	global $db,$template;
			$sql_course ="select id,name 
			from mdl_course_categories  
			where parent in (1,2,3) and id != '186' order by name
	                ";
					$sql_subject_results = $db->sql_query($sql_course);
					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))
					{
						$template->assign_block_vars('MONHOC',array(
						'name'		=> displayData_DB($sql_subject_result['name']),
                        'selected'		=> ($sql_subject_result['name']==$monhoc) ? ' selected' : '',
						));
					} 
}







function print_bug($string)



 {



    $file = "./log/data.txt";



    $fp = fopen($file, "w");



    fputs($fp, $string);



    fclose($fp);







 }







function curPageURL() {



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







function return_status($status)



{



 switch ($status){



 	case("0"):



 		$result="<img src='1xanh.png' height='18px' align='absmiddle' />&nbsp;&nbsp;Open";



 		break;



 	case("1"):



 		$result="<img src='1do.png' height='18px' align='absmiddle' />&nbsp;&nbsp;Closed";



 		break;



 	case("2"):



 		$result="<img src='1luc.png' height='18px' align='absmiddle' />&nbsp;&nbsp;Answered";



 		break;



 	case("3"):



 		$result="<img src='1vang.png' height='18px' align='absmiddle' />&nbsp;&nbsp;Awaiting reply";



 		break;



 }	



	



return $result;	



	



}



function check_ask_q($reply_id,$thread_id)



{



			Global $db;



		$sql="select id from tblanswer where thread='".$thread_id."' and id > (select answerid from tblreply where id ='".$reply_id."')";

		$result = $db->sql_query($sql) or die(mysql_error());



		$result = $db->sql_fetchrow($result);	



		$count=count($result);	



		



		if($count>1)



		{return false;



		}



		else



		{



		return true;	



		}	



	



	



}



function get_lastq($id)



{



Global $db;
$sql="select id from tblanswer where thread='".$id."' order by id desc";
$result = $db->sql_query($sql) or die(mysql_error());
$answerid = $db->sql_fetchrow($result);	
return  $answerid['id'];	
}



function get_delay_close($id,$time,$thread)
{
	Global $db;
 	$sql="select max(tblanswer.id) id from tblanswer,tblreply where tblanswer.thread=$thread and tblanswer.id=tblreply.answerid";
 	$result = $db->sql_query($sql);
 	$answerid = $db->sql_fetchrow($result);	
 	if($answerid['id']=='')
 	{
 	$result='24 hour'.$answerid['id'];
 	}



 	else



 	{



 	$str_delay=get_reply_time($answerid['id']);



	  $result=second_to_time($str_delay);		



 	}



 	







return $result;



}



function get_delay($id,$time)



{



 if(check_have_reply($id))



	 {		



	  $str_delay=get_reply_time($id);



	  $result=second_to_time($str_delay);	



	 }	



 else



 { 



 	$result=get_date_post($time);



 	



 }



return $result;



}



function check_root_q($id)



{



Global $db;



	$sql="select count(*) from tblanswer where id = $id  and parent=0";



	 $result = $db->sql_query($sql) or die(mysql_error());



	$count = $db->sql_fetchrow($result);



	if($count['count(*)']==0)



	   return false;



	else 



	   return true;			



	



	



}



function count_q_on_thread($id)



{



  Global $db;



  $sql="select count(*) count from tblanswer where thread='".$id."' limit 0,1";



  $result = $db->sql_query($sql) or die(mysql_error());



  $count = $db->sql_fetchrow($result);



  return $count['count'];



	



	



	



}



function count_child_question($id)



{



	Global $db;



	if(check_q_child($id))



	{



	 $sql="select count(*) from tblanswer where parent='".$id."' ";



	 $result = $db->sql_query($sql) or die(mysql_error());



	$count = $db->sql_fetchrow($result);



	$result= $count['count(*)']+1;			



	}



	else



	{ 



	$result= 1;



	}



	return $result;



	



}







function get_cname($c_id)



{



Global $db;



$sql="select fullname from mdl_course where id='".$c_id."' ";		



$result = $db->sql_query($sql) or die(mysql_error());



$course = $db->sql_fetchrow($result);



return $course['fullname'];			



}



function get_username_from_id($u_id)



{



Global $db;



$sql="select username from mdl_user where id='".$u_id."' ";	



$result = $db->sql_query($sql) or die(mysql_error());



$user = $db->sql_fetchrow($result);



return $user['username'];	



	



}



function get_name_from_id($u_id)



{



Global $db;



$sql="select firstname,lastname from mdl_user where id='".$u_id."' ";	



$result = $db->sql_query($sql) or die(mysql_error());



$user = $db->sql_fetchrow($result);



return $user['lastname'].' '.$user['firstname'];	



	



}







function get_attach($attach)



{



Global $template,$sql_attach;



switch ($attach){



 case("1"):



 	$sql_attach=" and attach != ''";



 	$select1='selected="selected"';



 	break;



 case("2"):



 	$sql_attach=" and attach = ''";



 	$select2='selected="selected"';



 	break;	



	



 



}



$template->assign_block_vars('FILEATTACH',array(



			'select1'		=> $select1,



			'select2'		=> $select2,



			));



}



function get_delay_list($delay)



{



Global $db,$template,$sql_po_delay;



switch ($delay){



 case("1"):



 	$sql_po_delay="and status != '1' and if(reply_time=0,time >".getTimeFromDelay(24).",reply_time-time < 60*60*24)";



 	$select1='selected="selected"';



 	break;



 case("2"):



 	$sql_po_delay="and status != '1' and if(reply_time=0,time > ".getTimeFromDelay(48)." and time < ".getTimeFromDelay(24).",reply_time-time between 60*60*24 and 60*60*48)";



 	$select2='selected="selected"';



 	break;



 case("3"):



 	$sql_po_delay="and status != '1' and if(reply_time=0,time > ".getTimeFromDelay(72)." and time < ".getTimeFromDelay(48).",reply_time-time between 60*60*58 and 60*60*72)";



 	$select3='selected="selected"';



 	break;



 case("4"):



 	$sql_po_delay="and status != '1' and if(reply_time=0,time < ".getTimeFromDelay(72).",reply_time-time > 60*60*72)";



 	$select4='selected="selected"';



 	break;		



	}	



	$template->assign_block_vars('DELAY',array(



			'selected1'		=> $select1,



			'selected2'		=> $select2,



			'selected3'		=> $select3,



			'selected4'		=> $select4,



			));



}



function get_search_text($searchtext)



{



	Global $template,$sql_searchtext;



	if($searchtext=='')



	{$sql_searchtext='';}



	else 



	{

	$sql_searchtext=" and (id like '%".$searchtext."%' or userid in (select id from mdl_user where username like '%".$searchtext."%') or assignid in (select id from mdl_user where username like '%".$searchtext."%') or answername like '%".$searchtext."%' or answerdes like '%".$searchtext."%' or id in (select thread from tblanswer where id in (select answerid from tblreply where replydes like '%".$searchtext."%')))";}



	$template -> assign_vars(array(



		'searchtext'		=> $searchtext,



	));







}



function get_status_list($status)



{



Global $db,$template,$sql_status;



switch ($status){



 case("1"):



 	$sql_status=" and status=0";



 	$select1='selected="selected"';



 	break;



 case("2"):



 	$sql_status=" and status=3";



 	$select2='selected="selected"';



 	break;



 case("3"):



 	$sql_status=" and status=2";



 	$select3='selected="selected"';



 	break;



 case("4"):



 	$sql_status=" and status = 1";



 	$select4='selected="selected"';



 	break;



 case("5"):



 	$sql_status=" and (status = 0 or status =3) ";



 	$select5='selected="selected"';



 	break;	



 case("6"):



 	$sql_status=" and (status = 2 or status =1) ";



 	$select6='selected="selected"';



 	break;			



	}	



	



	



	



	



	$template->assign_block_vars('STATUS',array(



			'select1'		=> $select1,



			'select2'		=> $select2,



			'select3'		=> $select3,



			'select4'		=> $select4,



			'select5'		=> $select5,



			'select6'		=> $select6,



			));	



	



	



}







function get_all_topic($selected)



{



global $db,$template;



$sql="select * from tbltopic where status=1 order by id asc";



$result=$db->sql_query($sql);



while($topic=$db->sql_fetchrow($result))



		{



			if ($selected==$topic['id'])



				{$str_selected='selected="selected"';}



			else



				{$str_selected='';}	



		$template->assign_block_vars('LSTTOPIC',array(



							



							'id'			=> $topic['id'],



							'name'			=> $topic['topicname'],



							'select'        => $str_selected,



							



						));	



			



		}	



	



	



	



	



}



function get_role($c_id,$u_id)



{

//return  $c_id.'<br>'.$u_id;

	global $db,$template;



	if($c_id!=0)



	{



$sql="select r.shortname from mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
  c.id='".$c_id."' and u.id='".$u_id."'";


/*$sql="SELECT r.shortname shortname



FROM mdl_user u



INNER JOIN mdl_role_assignments ra ON ra.userid = u.id



INNER JOIN mdl_context ct ON ct.id = ra.contextid



INNER JOIN mdl_course c ON c.id = ct.instanceid



INNER JOIN mdl_role r ON r.id = ra.roleid



INNER JOIN mdl_course_categories cc ON cc.id = c.category







where c.id='".$c_id."'



and u.id='".$u_id."'



order by r.sortorder asc limit 0,1



";*/	



	}



    elseif ($c_id==0)	



    {



    



 $sql="SELECT r.shortname shortname



							FROM mdl_user u



							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id



							INNER JOIN mdl_context ct ON ct.id = ra.contextid



							INNER JOIN mdl_course c ON c.id = ct.instanceid



							INNER JOIN mdl_role r ON r.id = ra.roleid



							INNER JOIN mdl_course_categories cc ON cc.id = c.category



                            where u.id='".$u_id."'



							order by r.sortorder asc limit 0,1";   



    }



$result=$db->sql_query($sql);



	    $rolename=$db->sql_fetchrow($result);



	  



	    



	    



	    return  $rolename['shortname'];



	



	



}



function second_to_time($second)



		{



			$count=$second;



		 	$count = (int)($count/(60)) ;







	        $count_h = (int)($count/60);



	        $count_m = $count - ($count_h*60);







	        if($count_h!=0)



		     $result .= $count_h.' giờ ';



	if($count_m!=0)



		$result .= $count_m." phút ";







	if($count_h==0&&$count_m==0)



		$result = "1 phút ";







	return $result;



			



			



		}



function get_reply_time($question_id)



		{



	    # lay ra thoi diem tra loi cua cau hoi co id=$question_id



	    # dung de tinh do tre cho cau hoi da co cau tra loi



	    global $db,$template;



	    $sql="select r.time-a.time as reply_delay from tblanswer a,tblreply r where r.answerid=a.id and a.id='".$question_id."'";



	    $result=$db->sql_query($sql);



	    $reply_time=$db->sql_fetchrow($result);



	    return  $reply_time['reply_delay'];



		}



function getCourseForGVCM($userid,$sname)



		{



			global $db,$template;
             $sql_course="SELECT distinct left(c.fullname,6) fullname



							FROM mdl_user u



							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id



							INNER JOIN mdl_context ct ON ct.id = ra.contextid



							INNER JOIN mdl_course c ON c.id = ct.instanceid



							INNER JOIN mdl_role r ON r.id = ra.roleid



							INNER JOIN mdl_course_categories cc ON cc.id = c.category



							



							where (r.id=4 or r.id=14) and u.id= '".$userid."'";







			



					$sql_subject_results = $db->sql_query($sql_course);



					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))



					{



						$template->assign_block_vars('SUBJECT',array(



							'id'			=> displayData_DB($sql_subject_result['fullname']),



							'name'		=> displayData_DB($sql_subject_result['fullname']),



							'gv'			=> $gv,



							'selected'		=> ($sql_subject_result['fullname']==$sname) ? ' selected' : '',



						));



					} 



			



		}







		



function getCourseForGVHD($userid,$sname)



		{



			global $db,$template;
$sql_course="SELECT distinct left(c.fullname,6) fullname



							FROM mdl_user u



							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id



							INNER JOIN mdl_context ct ON ct.id = ra.contextid



							INNER JOIN mdl_course c ON c.id = ct.instanceid



							INNER JOIN mdl_role r ON r.id = ra.roleid



							INNER JOIN mdl_course_categories cc ON cc.id = c.category



							



							where (r.id=4 or r.id=14) and u.id= '".$userid."'";



			



					$sql_subject_results = $db->sql_query($sql_course);



					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))



					{



						$template->assign_block_vars('SUBJECT',array(



							'id'			=> displayData_DB($sql_subject_result['fullname']),



							'name'		=> displayData_DB($sql_subject_result['fullname']),



							'gv'			=> $gv,



							'selected'		=> ($sql_subject_result['fullname']==$sname) ? ' selected' : '',



						));



					} 



			



		}		



function getCourseForCVHT($userid,$subject)



		{



			global $db,$template;
$sql_course="SELECT c.id courseid,c.fullname



							FROM mdl_user u



							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id



							INNER JOIN mdl_context ct ON ct.id = ra.contextid



							INNER JOIN mdl_course c ON c.id = ct.instanceid



							INNER JOIN mdl_role r ON r.id = ra.roleid



							INNER JOIN mdl_course_categories cc ON cc.id = c.category



							



							where r.id=3 and u.id= '".$userid."'";		



			$sql_subject_results = $db->sql_query($sql_course);



					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))



					{



						$template->assign_block_vars('SUBJECT',array(



							'id'			=> displayData_DB($sql_subject_result['courseid']),



							'name'		=> displayData_DB($sql_subject_result['fullname']),



							'gv'			=> $gv,



							'selected'		=> ($sql_subject_result['courseid']==$subject) ? ' selected' : '',



						));



					} 



			



		}	



		



function getCourseForKTV($userid,$subject)



		{



			global $db,$template;



			$sql_course ="SELECT c.id courseid,c.fullname



							FROM mdl_user u



							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id



							INNER JOIN mdl_context ct ON ct.id = ra.contextid



							INNER JOIN mdl_course c ON c.id = ct.instanceid



							INNER JOIN mdl_role r ON r.id = ra.roleid



							INNER JOIN mdl_course_categories cc ON cc.id = c.category



							



							where r.id=15 and u.id= '".$userid."'";



					$sql_subject_results = $db->sql_query($sql_course);



					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))



					{



						$template->assign_block_vars('SUBJECT',array(



							'id'			=> displayData_DB($sql_subject_result['courseid']),



							'name'		=> displayData_DB($sql_subject_result['fullname']),



							'gv'			=> $gv,



							'selected'		=> ($sql_subject_result['courseid']==$subject) ? ' selected' : '',



						));



					} 



			



		}			



			



function getCourseForHV($userid,$subject)



		{



			global $db,$template;



			$sql_course ="SELECT c.id courseid,c.fullname
                         
							FROM mdl_user u
							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
							INNER JOIN mdl_context ct ON ct.id = ra.contextid
							INNER JOIN mdl_course c ON c.id = ct.instanceid
							INNER JOIN mdl_role r ON r.id = ra.roleid
							INNER JOIN mdl_course_categories cc ON cc.id = c.category
							
							WHERE
							 u.id = '".$userid."'
								and ra.roleid=5";



					$sql_subject_results = $db->sql_query($sql_course);



					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))



					{



						$template->assign_block_vars('SUBJECT',array(



							'id'			=> displayData_DB($sql_subject_result['courseid']),



							'name'		=> displayData_DB($sql_subject_result['fullname']),



							'gv'			=> $gv,



							'selected'		=> ($sql_subject_result['courseid']==$subject) ? ' selected' : '',



						));



					} 



			



		}				



		



function getGVCVHTForCVHT($subject,$po,$gv)



		{



		   // $subject: id mon hoc



		   // $po:id po hien tai dang dang nhap



		   // $gv:id giang vien dang duoc chon (dung de set selected cho drop down)	



			



		global $db,$template;



			



		    $sql="



		    SELECT c.id courseid



			FROM mdl_user u



			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id



			INNER JOIN mdl_context ct ON ct.id = ra.contextid



			INNER JOIN mdl_course c ON c.id = ct.instanceid



			INNER JOIN mdl_role r ON r.id = ra.roleid



			INNER JOIN mdl_course_categories cc ON cc.id = c.category



			



			where u.id='".$po."'



			and r.id=3";



	       	$course_po = $db->sql_query($sql);



		  while($course_of_po = $db->sql_fetchrow($course_po))



		  {



		  	 $course_sql[]= $course_of_po['courseid'];



		  	



		  }



		   



		   $course_po_sql= '('.implode(',',$course_sql).')';



		



		



	       if($subject!=0)



	       {







	       //new bug check permission before



	       $sql_check_po="select
	       c.id 
           FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 r.id=3 and u.id='".$po."' and c.id = '".$subject."'";



	       $check_po = $db->sql_query($sql_check_po) or die(mysql_error());



            	if(mysql_numrows($check_po)>0)



            		{



	       $sql_gv=" SELECT distinct u.id, u.username, u.firstname, u.lastname 



	       			 FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE



	       			 c.id = '".$subject."' and r.id in (14,4,3)"; 	



            		}



            	else 



            		{



            			$sql_gv ="SELECT distinct u.id, u.username, u.firstname, u.lastname 



	       				FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 c.id in $course_po_sql and r.id in (14,4,3)";



            		}



            }



	       else 



	       {



	       	$sql_gv ="SELECT distinct u.id, u.username, u.firstname, u.lastname 



	       				FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE

	       				c.id in $course_po_sql and r.id in (14,4,3)";



	       }



	       $sql_gv_results = $db->sql_query($sql_gv);



					while($sql_gv_result = $db->sql_fetchrow($sql_gv_results))



					{



						$template->assign_block_vars('GVHD',array(



							



							'id'			=> displayData_DB($sql_gv_result['id']),



							'name'			=> displayData_DB($sql_gv_result['firstname'].' '.$sql_gv_result['lastname']),



							'subject'		=> $subject,



							'selected'		=> ($sql_gv_result['id']==$gv) ? ' selected' : '',



						));



					}



		}				



		



function getGVCVHTForGVHD($subject,$po,$gv)



		{



		   // $subject: id mon hoc



		   // $po:id po hien tai dang dang nhap



		   // $gv:id giang vien dang duoc chon (dung de set selected cho drop down)	



			



		  /* global $db,$template;



	       if($subject!=0)



	       {



	       //new bug check permission before



	       $sql_check_po="select c.id from FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 r.id=4 and u.id='".$po."' and c.id in (select id from mdl_course where fullname like '%".$subject."%') ";



	       $check_po = $db->sql_query($sql_check_po) or die(mysql_error());



            	if(mysql_numrows($check_po)>0)



            		{



	       $sql_gv=" SELECT distinct u.id, u.username, u.firstname, u.lastname 



	       			 FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE




	       			 c.id = '".$subject."' and r.id in (14,4,3)"; 	



            		}



            	else 



            		{



            			$sql_gv ="SELECT distinct u.id, u.username, u.firstname, u.lastname 



	       			FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE




	       			c.id in (SELECT courseid FROM  FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category


  WHERE u.id ='".$po."' and r.id=14 ) and r.id in (14,4,3)";



            		}



            }



	       else 



	       {



	       	$sql_gv ="SELECT distinct u.id, u.username, u.firstname, u.lastname 



	       				FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE



c.id in (SELECT c.id FROM  FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
u.id ='".$po."' and r.id=14 ) and r.id in (14,4,3)";
}



	       $sql_gv_results = $db->sql_query($sql_gv);



					while($sql_gv_result = $db->sql_fetchrow($sql_gv_results))



					{



						$template->assign_block_vars('GVHD',array(



							



							'id'			=> displayData_DB($sql_gv_result['id']),



							'name'			=> displayData_DB($sql_gv_result['firstname'].' '.$sql_gv_result['lastname']),



							'subject'		=> $subject,



							'selected'		=> ($sql_gv_result['id']==$gv) ? ' selected' : '',



						));



					}*/



		}		



		



		



function getGvhdForGVCM($subject,$po,$gv)



		{



		   // $subject: id mon hoc



		   // $po:id po hien tai dang dang nhap



		   // $gv:id giang vien dang duoc chon (dung de set selected cho drop down)	



			



		   global $db,$template;



		   $sql="SELECT c.id FROM  FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 u.id ='".$po."' and r.id=4";



		   $course_po = $db->sql_query($sql);



		  while($course_of_po = $db->sql_fetchrow($course_po))



		  {



		  	 $course_sql[]= $course_of_po['courseid'];



		  	



		  }



		   



		   $course_po_sql= '('.implode(',',$course_sql).')';



		   



		   



		   



	       if($subject!=0)



	       {



	       //new bug check permission before



	       $sql_check_po="select c.id from FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 r.id=4 and u.id='".$po."' and c.id in (select id from mdl_course where fullname like '%".$subject."%') ";



	       $check_po = $db->sql_query($sql_check_po) or die(mysql_error());



            	if(mysql_numrows($check_po)>0)



            		{



	       $sql_gv=" SELECT distinct u.id, u.username, u.firstname, u.lastname 



	       			 FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE




	       			 c.id = '".$subject."' and r.id =14"; 	



            		}



            	else 



            		{



            			$sql_gv ="SELECT distinct u.id, u.username, u.firstname, u.lastname 



	       				FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 c.id in $course_po_sql and r.id=14";



            		}



            }



	       else 



	       {



	       	$sql_gv ="SELECT distinct u.id, u.username, u.firstname, u.lastname 


FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 c.id in $course_po_sql and r.id=14";



	       }



	       $sql_gv_results = $db->sql_query($sql_gv);



					while($sql_gv_result = $db->sql_fetchrow($sql_gv_results))



					{



						$template->assign_block_vars('GVHD',array(



							



							'id'			=> displayData_DB($sql_gv_result['id']),



							'name'			=> displayData_DB($sql_gv_result['firstname'].' '.$sql_gv_result['lastname']),



							'subject'		=> $subject,



							'selected'		=> ($sql_gv_result['id']==$gv) ? ' selected' : '',



						));



					}



		}				



		



function getCourseByUser($userid,$subject)



		{



			global $db,$template;



			$sql_course ="SELECT c.*



					FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 u.id = '".$userid."'";



					$sql_subject_results = $db->sql_query($sql_course);



					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))



					{



						$template->assign_block_vars('SUBJECT',array(



							'id'			=> displayData_DB($sql_subject_result['courseid']),



							'name'		=> displayData_DB($sql_subject_result['fullname']),



							'gv'			=> $gv,



							'selected'		=> ($sql_subject_result['courseid']==$subject) ? ' selected' : '',



						));



					} 



			



		}



function getAllCourse($subject)



		{



			global $db,$template;



			$sql_course ="SELECT DISTINCT c.id,c.fullname

FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE
c.id !=1
and 
c.visible = 1 and c.id != 228 and c.fullname not like '%mẫu%'

					

					order by fullname asc



	                ";



					$sql_subject_results = $db->sql_query($sql_course);



					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))



					{



						$template->assign_block_vars('SUBJECT',array(



							'id'			=> displayData_DB($sql_subject_result['id']),



							'name'		=> displayData_DB($sql_subject_result['fullname']),



							'gv'			=> $gv,



							'selected'		=> ($sql_subject_result['id']==$subject) ? ' selected' : '',



						));



					} 



			



		}		



function getCourseByPO($userid,$subject)



		{



			global $db,$template;



			



		$sql_course="



			SELECT c.*



							FROM mdl_user u



							INNER JOIN mdl_role_assignments ra ON ra.userid = u.id



							INNER JOIN mdl_context ct ON ct.id = ra.contextid



							INNER JOIN mdl_course c ON c.id = ct.instanceid



							INNER JOIN mdl_role r ON r.id = ra.roleid



							INNER JOIN mdl_course_categories cc ON cc.id = c.category



							



							where r.id in (13,211) and u.id= '".$userid."'



			



			";



					$sql_subject_results = $db->sql_query($sql_course);



					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))



					{



						$template->assign_block_vars('SUBJECT',array(



							'id'			=> $sql_subject_result['id'],



							'name'		=> $sql_subject_result['fullname'],



							'gv'			=> $gv,



							'selected'		=> ($sql_subject_result['id']==$subject) ? ' selected' : '',



						));



					} 



			



		}



function getGvcmCvhtForPO ($subject,$po,$gv)



		{



		   // $subject: id mon hoc



		   // $po:id po hien tai dang dang nhap



		   // $gv:id giang vien dang duoc chon (dung de set selected cho drop down)	



			



		   global $db,$template;



		    // get course of po



		



		   $sql="



		   SELECT c.id courseid



			FROM mdl_user u



			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id



			INNER JOIN mdl_context ct ON ct.id = ra.contextid



			INNER JOIN mdl_course c ON c.id = ct.instanceid



			INNER JOIN mdl_role r ON r.id = ra.roleid



			INNER JOIN mdl_course_categories cc ON cc.id = c.category



			



			where u.id='".$po."'



			and r.id=13";



		    $course_po = $db->sql_query($sql);



		  while($course_of_po = $db->sql_fetchrow($course_po))



		  {



		  	 $course_sql[]= $course_of_po['courseid'];



		  	



		  }



		   



		   $course_po_sql= '('.implode(',',$course_sql).')';







	       if($subject!=0)



	       {



	       //new bug check permission before



	       $sql_check_po="select c.id  FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 r.id=13 and u.id='".$po."' and c.id='".$subject."' ";



	       $check_po = $db->sql_query($sql_check_po) or die(mysql_error());



            	if(mysql_numrows($check_po)>0)



            		{



	       $sql_gv=" SELECT distinct u.id, u.username, u.firstname, u.lastname 



	       			 FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 c.id = '".$subject."' and r.id in (14,4,3,15)"; 	



            		}



            	else 



            		{



            			$sql_gv ="SELECT distinct u.id, u.username, u.firstname, u.lastname 



	       				FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 c.id in $course_po_sql and r.id in (14,4,3,15)";



            		}



            }



	       else 



	       {



	       	$sql_gv ="SELECT distinct u.id, u.username, u.firstname, u.lastname 



	       				FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 rc.id in $course_po_sql and r.id in (14,4,3,15)";



	       	//echo $sql_gv;



	       }



	     



	      $sql_gv_results = $db->sql_query($sql_gv);



					while($sql_gv_result = $db->sql_fetchrow($sql_gv_results))



					{



						$template->assign_block_vars('GVHD',array(



							



							'id'			=> displayData_DB($sql_gv_result['id']),



							'name'			=> displayData_DB($sql_gv_result['firstname'].' '.$sql_gv_result['lastname']).' - '.get_role($subject,$sql_gv_result['id']),



							'subject'		=> $subject,



							'selected'		=> ($sql_gv_result['id']==$gv) ? ' selected' : '',



						));



					}



		}		



function getQuestions4Po($subject,$po,$gv,$mode,$delay,$status)



{



 # $subject : id cua khoa hoc,neu rong thi hien tat



 # $po : poid



 # $gv : id gv



 # $mode : chu de  or cau hoi



 # $delay : loc theo do tre



 # $status:loc theo trang thai



         if($subject!=0)



 	     $sql_subject="and courseid='".$subject."";



         else 



         $sql_subject="";



         



 



 



 



	



}



function getQuestions4GVHD($sname='',$gvhd_id,$s='',$e='')



{



# Get question to gvhd



# $sname: ten rut gon cua khoa hoc



# $delay: do tre



# $status : trang thai



# $gvhd_id :id giang vien huong dan



# $s : limit start



# $e :limit end



		if($sname='')



		{



		$sql="SELECT *



		FROM



		tblanswer



		where courseid in (select courseid FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 where u.id='".$gvhd_id."'  and r.id=4)";
}



	



	



	



	



	



	



	



}	



		



function getTimeFromDelay($delay)



			{



             $offsettime=60*60*$delay;



             $now=time();



             return $now-$offsettime;	



	



	



			}



function check_q_child($id)



    {



	    $result=false;



	    $sql="Select count(*) from tblanswer where parent='".$id."'";



		$sql =  mysql_query($sql) or die(mysql_error());



	    $r_count=mysql_fetch_array($sql);



		if($r_count[0]!= 0)



		 {



		 $result=true;



		 }



		 return $result;



	



	}	



function check_have_reply($id)



	{



		



	$sql = "SELECT count(*) FROM tblreply WHERE answerid = '".$id."'";



	$sql = mysql_query($sql) or die(mysql_error());



	while($value = mysql_fetch_array($sql)) {



		if($value[0] == 0)



			$result = 0;



		else



		    $result=1;



	}



		return $result;



		



	}







function check_q_parent($id){



	{



		$sql = "SELECT count(*) FROM tblanswer WHERE id = '".$id."' and parent='0'";



		$sql = mysql_query($sql) or die(mysql_error());



		while($value = mysql_fetch_array($sql)) {



		if($value[0] == 0)



			$result = false;



		else



		    $result=true;



		}



		return $result;



		}







}











function check_answer_status ($id) {



	$result = "";



	$select = "SELECT * FROM tblanswer WHERE id = '".$id."'";



	$select = mysql_query($select) or die(mysql_error());



	while($sql = mysql_fetch_array($select))



	{	



		if($sql['status']=='1') 



		{



			$result = "<img src='1do.png' height='18px' align='absmiddle' />&nbsp;&nbsp;Closed";



		}



		elseif ($sql['assignid']=='0') // chua assign



		{



			if(check_have_reply($id))



			 	{



			 	$result = "<img src='1luc.png' height='18px' align='absmiddle' />&nbsp;&nbsp;Answered";	



			 	}



			 	else 



			 	{



			 	 



			 	$result="<img src='1xanh.png' height='18px' align='absmiddle' />&nbsp;&nbsp;Recently opened";	  



			 	  }



			



				



		}



		else 



		{



                if(check_have_reply($id))



			 	{



			 	$result = "<img src='1luc.png' height='18px' align='absmiddle' />&nbsp;&nbsp;Answered";	



			 	}



			 	else 



			 	{



			 	 



			 	$result = "<img src='1vang.png' height='18px' align='absmiddle' />&nbsp;&nbsp;Awaiting reply";	  



			 	  }



			 	



			 /*	



				$reply = "SELECT COUNT(id) FROM tblreply WHERE answerid = '".$id."'";



				$reply = mysql_query($reply) or die(mysql_error());



				while($count = mysql_fetch_array($reply)) {



					if($count[0] == 0) {



						$result = "<img src='mas.png' height='25px' align='absmiddle' />&nbsp;&nbsp;Đang chờ trả lời";



					} else {



						if(check_latest_replay($id)==$sql['userid'])



							$result = "<img src='mas.png' height='25px' align='absmiddle' />&nbsp;&nbsp;Đang chờ trả lời";



						else



							$result = "<img src='lucs.png' height='25px' align='absmiddle' />&nbsp;&nbsp;Đã trả lời";



					}



				}*/



			



		}







	}







	return $result;



}







function get_answer_rate($id,$author) {



	$debug='';



	if(check_q_child($id))



		{



		 // dem so cau hoi



		   $sql_question="SELECT COUNT(id) FROM tblanswer where parent='".$id."'";



		  	$sql_question = mysql_query($sql_question) or die(mysql_error());



			while($count = mysql_fetch_array($sql_question)) {



			$question = $count[0];



			}



			$question=$question+1;// + parent



			



		



			$sql_reply = "SELECT COUNT(id) FROM tblreply WHERE answerid in (select id from tblanswer where parent='".$id."') or answerid=$id";



			



			$debug=$sql_reply;



			$sql_reply = mysql_query($sql_reply) or die(mysql_error());



			while($count = mysql_fetch_array($sql_reply)) {



			$reply = $count[0];



				}



	



			



			



		}



	else {



		$sql_reply = "SELECT COUNT(id) FROM tblreply WHERE answerid ='".$id."' AND userid != '".$author."'";



			//$reply=$sql_reply;



			//$debug=$sql_reply;



			$sql_reply = mysql_query($sql_reply) or die(mysql_error());



			while($count = mysql_fetch_array($sql_reply)) {



			$reply = $count[0];



			$question=1; 



				}



		



		



	}		



	$sql_answer = "SELECT COUNT(id) FROM tblreply WHERE answerid = '".$id."' AND userid = '".$author."'";



	$sql_answer = mysql_query($sql_answer) or die(mysql_error());



	while($count = mysql_fetch_array($sql_answer)) {



		$answer = $count[0];



	}



	return $reply."/".($question);



   //return $question;



}







function return_answer_status ($id) {



	$reply = "SELECT COUNT(id) FROM tblreply WHERE answerid = '".$id."'";



	$reply = mysql_query($reply) or die(mysql_error());



	while($count = mysql_fetch_array($reply)) {



		if($count[0] == 0)



			$result = 0;



		else



			$result = 1;



	}



	return $result;



}







function return_answer_close ($id) {



	



	$sql = "SELECT status FROM tblanswer WHERE id = '".$id."'";



	$sql = mysql_query($sql) or die(mysql_error());



	while($value = mysql_fetch_array($sql)) {



		if($value[0] == 0)



		{



			$result = 0;



		}



			else



			$result = 1;



	}



	return $result;



}







/*function return_answer_delay ($id,$author,$time) {



	$reply = "SELECT COUNT(id) FROM tblreply WHERE answerid = '".$id."'";



	$reply = mysql_query($reply) or die(mysql_error());



	while($count = mysql_fetch_array($reply)) {



		if($count[0] == 0) {



			$result = get_date_post($time);



		} else {



			$replays = "SELECT * FROM tblreply WHERE answerid = '".$id."' ORDER BY id DESC LIMIT 1";



			$replays = mysql_query($replays) or die(mysql_error());



			while($replay = mysql_fetch_array($replays)) {



				if($replay['answerid']==$author) {



					$result = get_date_post($replay['time']);



				} else {



					$result = "";



				}



			}



		}



	}







	return $result;



}*/







function return_answer_delay ($id,$author,$time) {



	$reply = "SELECT COUNT(id) FROM tblreply WHERE answerid = '".$id."'";



	$reply = mysql_query($reply) or die(mysql_error());



	while($count = mysql_fetch_array($reply)) {



		if($count[0] == 0) {



			$result = get_date_post($time);



			/*$result = '<script type="text/javascript">showElapsedTime("delay'.$id.'",'.date('Y',$time).','.(date('n',$time)-1).','.date('d',$time).','.date('h',$time).','.date('i',$time).','.date('s',$time).','.date('Y').','.(date('n')-1).','.date('d').','.date('h').','.date('i').','.date('s').');</script>';*/



		} else {



			$replays = "SELECT * FROM tblreply WHERE answerid = '".$id."' ORDER BY id DESC LIMIT 1";



			$replays = mysql_query($replays) or die(mysql_error());



			while($replay = mysql_fetch_array($replays)) {



				if($replay['userid']==$author) {



					$result = get_date_post($replay['time']);



				} else {



					$result = "";



				}



			}



		}



	}







	return $result;



}







function get_group($id) {



	//$groups = "SELECT g.name as name FROM tblgroup as g, tbleuser_group as ug, mdl_user as u WHERE u.id = ug.user_id AND ug.group_id = g.id AND u.id = '".$id."'";



	$groups = "select viename 



from tblrole



where  id in (select r.id FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 u.id = '".$id."' ) limit 0,1";



	



	$groups = mysql_query($groups) or die(mysql_error());



	while($group = mysql_fetch_array($groups)) {



		$group_name	= $group['viename'];



	}



	return $group_name;











}











function get_answer($id)



{



$latests = "SELECT u.firstname as firstname, u.lastname as lastname FROM mdl_user as u, tblanswer as a WHERE u.id=a.assignid AND a.id = '".$id."' ORDER BY a.id DESC LIMIT 1";



			$latests = mysql_query($latests) or die(mysql_error());



			while($latest = mysql_fetch_array($latests)) {



				$latsest_id	= $latest['firstname'].' '.$latest['lastname'];



			}	



return $latsest_id;	



	



	



}







function get_latest_answers($id,$author) {



	$reply = "SELECT COUNT(id) FROM tblreply WHERE answerid = '".$id."'";



	$reply = mysql_query($reply) or die(mysql_error());



	while($count = mysql_fetch_array($reply)) {



		if($count[0] == 0) {



			$latests = "SELECT u.firstname as firstname, u.lastname as lastname FROM mdl_user as u, tblanswer as a WHERE u.id=a.assignid AND a.id = '".$id."' ORDER BY a.id DESC LIMIT 1";



			$latests = mysql_query($latests) or die(mysql_error());



			while($latest = mysql_fetch_array($latests)) {



				$latsest_id	= $latest['firstname'].' '.$latest['lastname'];



			}



		} else {



			$latests = "SELECT u.firstname as firstname, u.lastname as lastname FROM mdl_user as u, tblreply as r WHERE u.id=r.userid AND r.answerid = '".$id."' AND r.userid != '".$author."' ORDER BY r.id DESC LIMIT 1";



			$latests = mysql_query($latests) or die(mysql_error());



			while($latest = mysql_fetch_array($latests)) {



				$lastest_id	= $latest['firstname'].' '.$latest['lastname'];



			}



		}



	}







	return $lastest_id;



}







function check_latest_replay($id) {



	$latests = "SELECT userid FROM tblreply WHERE answerid = '".$id."' ORDER BY id DESC LIMIT 1";



	$latests = mysql_query($latests) or die(mysql_error());



	while($latest = mysql_fetch_array($latests)) {



		$latsest_id	= $latest[0];



	}



	return $latsest_id;



}







function get_list_course($id){



	$sql = "SELECT c.id FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE
 WHERE u.id = '".$id."'";



	$query = mysql_query($sql) or die(mysql_error());



	$result = "0,";



	while($list = mysql_fetch_array($query)) {



		$result .= $list['courseid'].",";



	}



	$result = substr($result, 0, -1);



	return $result;



}







function get_list_course2($id){



	$sql = "SELECT course_id FROM tblsubject_course WHERE subject_id IN (".$id.")";



	$query = mysql_query($sql) or die(mysql_error());



	$result = "0,";



	while($list = mysql_fetch_array($query)) {



		$result .= $list['course_id'].",";



	}



	$result = substr($result, 0, -1);



	return $result;



}







function get_list_course_gvhd ($id){







	$sql_plan = "SELECT plan_id FROM tbleuser_plan WHERE user_id = '".$id."'";



	$sql_plan = mysql_query($sql_plan) or die(mysql_error());



	$plan = mysql_fetch_array($sql_plan);







	$sql_subject = "SELECT subject_id FROM tblsubject_plan WHERE plan_id = '".$plan['plan_id']."'";



	$query = mysql_query($sql_subject) or die(mysql_error());



	$subject = "0,";



	while($list = mysql_fetch_array($query)) {



		$subject .= $list['subject_id'].",";



	}



	$subject = substr($subject, 0, -1);











	$sql = "SELECT course_id FROM tblsubject_course WHERE subject_id IN (".$subject.")";



	$query = mysql_query($sql) or die(mysql_error());



	$result = "0,";



	while($list = mysql_fetch_array($query)) {



		$result .= $list['course_id'].",";



	}



	$result = substr($result, 0, -1);



	return $result;



}







function get_list_class_gvhd ($id){







	$sql = "SELECT class_id FROM tbleuser_class WHERE user_id = '".$id."'";



	$sql = mysql_query($sql) or die(mysql_error());



	while($list = mysql_fetch_array($sql)) {



		$result .= $list['class_id'].",";



	}



	$result = substr($result, 0, -1);



	return $result;



}







function get_list_subject($id) {



	$sql_plan = "SELECT plan_id FROM tbleuser_plan WHERE user_id = '".$id."'";



	$sql_plan = mysql_query($sql_plan) or die(mysql_error());



	$plan = mysql_fetch_array($sql_plan);







	$sql = "SELECT subject_id FROM tblsubject_plan WHERE plan_id = '".$plan['plan_id']."'";



	$query = mysql_query($sql) or die(mysql_error());



	$result = "0,";



	while($list = mysql_fetch_array($query)) {



		$result .= $list['subject_id'].",";



	}



	$result = substr($result, 0, -1);



	return $result;



}







function get_list_subject2($id) {



	//$sql_plan = "SELECT plan_id FROM tbleuser_plan WHERE user_id = '".$id."'";



	//$sql_plan = mysql_query($sql_plan) or die(mysql_error());



	//$plan = mysql_fetch_array($sql_plan);







	$sql = "SELECT subject_id FROM tbleuser_subject WHERE user_id IN (".$id.")";



	$query = mysql_query($sql) or die(mysql_error());



	$result = "0,";



	while($list = mysql_fetch_array($query)) {



		$result .= $list['subject_id'].",";



	}



	$result = substr($result, 0, -1);



	return $result;



}







function get_date_post($time) {



	$result = "";



	$now = time();



	//$deley = $time+(3*24*60*60);



	$count = $now - $time;



	$count = (int)($count/(60)) ;







	$count_h = (int)($count/60);



	$count_m = $count - ($count_h*60);







	if($count_h!=0)



		$result .= $count_h.' hour(s) ';



	if($count_m!=0)



		$result .= $count_m." minute(s) ";







	if($count_h==0&&$count_m==0)



		$result = "1 minute ";







	return $result;



}







function get_array_sub_id($id, $cat_table = "tblcat_info")



{



	$select = "SELECT * FROM ".$cat_table." WHERE parent_id = ".$id;



	



	$select = mysql_query($select) or die(mysql_error());



	$menu = '';



	while($sql = mysql_fetch_array($select))



	{



		$menu .= $sql['id'].", ";



		$menu .= get_array_sub_id($sql['id'], $cat_table);



	}



	return $menu;	



}



////////////



function get_root_id($id,$cat_table = "tblcat_info")



{



	$select = "SELECT * FROM ".$cat_table." WHERE id = ".$id;



	$select = mysql_query($select) or die(mysql_error());



	$menu = 0;



	while($sql = mysql_fetch_array($select))



	{



		$menu = $id;



		if($sql['parent_id'] != '' && $sql['parent_id'] != 0)



			$menu = (int)$sql['parent_id'];



		



		$temp = (int)get_root_id($sql['parent_id'], $cat_table);



		if($temp != '' && $temp != 0)



			$menu = (int)get_root_id($sql['parent_id'], $cat_table);



	}



	return $menu;	



}







function check_select($number, $nember_array) {



	foreach ($nember_array as $authority_id )



	{



		if($authority_id == $number)return true;



	}



	return false;



}











// Kiem tra form them moi administrator



function checkNewUser(&$bOK, &$strMsg)



{



	global $strUsername;



	if ( !empty($strUsername) )



	{



		$bOK = true;



	}



	else



	{



		$bOK = false;



		$strMsg = 'Account cannot be empty.';



	}



}







// Upload cac loai file len server



function upload_files_doc(&$file_name, &$file_type, $file_tmp, $dir_upload)



{
	$date = getdate();	
	$time_update = $date[0];
	$file_name = $time_update;

	//$file_type = substr($file_type, -strpos($file_type, '/'));
	
/**
* @auther: Danglx
* name: dinh dang file attach
* date : 21-02-2014
*/

	switch ($file_type) {
		case 'text/plain':
			$file_type = '.txt';
		break;
		case 'application/msword':
			$file_type = '.doc';
		break;
		case 'application/vnd.ms-excel':
			$file_type = '.xls';
		break;
		case 'application/zip':
			$file_type = '.zip';
		break;		
		case 'application/rar':
			$file_type = '.rar';
		break;
		case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
			$file_type = '.docx';
		break;
		case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
			$file_type = '.xlsx';
		break;
		case 'application/vnd.ms-powerpoint':
			$file_type = '.ppt';
		break;
		case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
			$file_type = '.pptx';
		break;
		case 'application/pdf':
			$file_type = '.pdf';
		break;
		case 'application/octet-stream':
			$file_type = '.rar';
		break;

	}



	



	if ( !is_dir($dir_upload) )



	{



		//echo 'Can not found the folder: <b>'.$dir_upload.'</b>';		



		return false;



	}



	



	if ( $file_name == '' or !$file_name or $file_name == 'none')



	{



		//echo 'Can not found the file';



		//exit;



		return false;



	}



	



	// Copy file can upload len 1 thu muc tren SERVER



	chmod($dir_upload, 0777);



	if ( !@move_uploaded_file($file_tmp, $dir_upload . '/' . $file_name . $file_type) )



	{



		//echo 'Upload failed';



		//exit;



		return false;



	}



	else



		@chmod($dir_upload . '/' . $file_name . $file_type , 0777);



	chmod($dir_upload, 0755);



	return true;



}







// UpLoad file anh len Server



function upload_files(&$file_name, &$file_type, $file_tmp, $dir_upload)



{



	$time_update = time();



	$len = strlen($file_name);



	$file_name = substr($file_name, 0, $len-4);



	$file_name .= $time_update;



	//$file_type = substr($file_type, -strpos($file_type, '/'));



	switch ($file_type) {



		case 'image/jpeg':



			$file_type = '.jpg';



		break;



		



		case 'image/gif':



			$file_type = '.gif';



		break;



		



		case 'image/png':



			$file_type = '.png';



		break;



		



		case 'image/x-MS-bmp':



			$file_type = '.bmp';



		break;		



	}



	



	if ( !is_dir($dir_upload) )



	{



		return false;



	}



	



	if ( $file_name == '' or !$file_name or $file_name == 'none')



	{



		return false;



	}



	



	// Copy file can upload len 1 thu muc tren SERVER



	//chmod($dir_upload, 0777);



	if ( !@move_uploaded_file($file_tmp, $dir_upload .  $file_name . $file_type) )



	{



		return false;



	}



	else



	{



		//@chmod($dir_upload . '/' . $file_name . $file_type , 0777);



		return true;



	}



	//chmod($dir_upload, 0755);



}











// Xoa file anh tren server



function delete_files($file_name, $dir_upload) {



	if ( file_exists( $dir_upload . '/' . $file_name) ) {



		unlink( $dir_upload . '/' . $file_name);



	}



	return;



}







// Kiem tra cau truc email nhap vao



function is_email($EmailAddr)



{



	if ( ! preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is', $EmailAddr))



		return false;



	else return true;



}







/////////



function transform_date($date_)



{



	$day = substr($date_, 0,2);



	$mon = substr($date_, 3,2);



	$year = substr($date_, 6,4);



	$date_change = $year."-".$mon."-".$day;



	return $date_change;



}







function transform_date_back($date_)



{



	$year = substr($date_, 0,4);



	$mon = substr($date_, 5,2);



	$day = substr($date_, 8,2);



	$hour = substr($date_, 11,2);



	$minutes = substr($date_, 14,2);



	$gi = substr($date_, 17,2);



	$date_change = $day."-".$mon."-".$year." ".$hour.":".$minutes;



	return $date_change;



}







function transform_date_back_only($date_)



{



	$year = substr($date_, 0,4);



	$mon = substr($date_, 5,2);



	$day = substr($date_, 8,2);



	



	$date_change = $day."-".$mon."-".$year;



	return $date_change;



}







//stripslashes



//addslashes



//htmlspecialchars



//htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);



//html_entity_decode







function convertHTML($strInput) //Convert to html special code



{



	//$strInput = htmlspecialchars($strInput, ENT_QUOTES);



	$strInput = str_replace('"', '&quot;', $strInput);



	$strInput = str_replace("'", "&#039;", $strInput);



	return $strInput;



}







function unconvertHTML($strInput)//Convert html special code to standart form



{



	//$strInput = html_entity_decode($strInput);



	$strInput = str_replace('&quot;', '"', $strInput);



	$strInput = str_replace("&#039;", "'", $strInput);



	return $strInput;



}







function insertData($strInput) {



	$strInput = addslashes(unconvertHTML($strInput));



	return $strInput;



}







function displayData_DB($strInput){



	$strInput = stripslashes($strInput);



	$strInput = str_replace(chr(10), '<br>', $strInput);



	return $strInput;



}







function displayData_DB_Content($strInput)



{



	$strInput = stripslashes($strInput);



//	$strInput = str_replace(chr(10), '<br>', $strInput);



	return $strInput;



}







function displayData_Textbox($strInput)



{



	$strInput = convertHTML(stripslashes($strInput));



	return $strInput;



}







function convertcharstoupper($str)



{



	return mb_convert_case($str, MB_CASE_UPPER, "UTF-8");



}







function cat_travel_law($id)



{



	$select = "SELECT * FROM tblcat_law WHERE parent_id = ".$id;



	$select = mysql_query($select) or die(mysql_error());



	$menu = "";



	while($sql = mysql_fetch_array($select))



	{



		$menu .= "'".$sql['id']."', ";



		$menu .= cat_travel_law($sql['id']);



	}



	return $menu;	



}







function private_unset()



{



	unset($_SESSION['sr_name']);



	unset($_SESSION['sr_start']);



	unset($_SESSION['sr_end']);



	unset($_SESSION['sr_type']);



	unset($_SESSION['sr_code']);



	unset($_SESSION['sr_area']);



	unset($_SESSION['sr_prime_key']);



	unset($_SESSION['sr_dept']);



	unset($_SESSION['sr_signer']);



	unset($_SESSION['sr_order']);



	unset($_SESSION['sr_numofpage']);



}











function check_injection($text, $level = 1)



{



	//Exam



	$text = strtolower($text);



	if(substr_count($text, 'insert into') > 0) $insert_exists = true;



	if(substr_count($text, 'update tbl') > 0) $update_exists = true;



	if(substr_count($text, 'update `tbl`') > 0) $update_exists = true;



	if(substr_count($text, 'delete from') > 0) $delete_exists = true;



	



	if(substr_count($text, 'drop database') > 0) return false;



	if(substr_count($text, 'drop table') > 0) return false;



	



	if(substr_count($text, 'insert into') > 1) return false;



	if(substr_count($text, 'update tbl') > 1) return false;



	if(substr_count($text, 'update `tbl`') > 1) return false;



	if(substr_count($text, 'delete from') > 1) return false;







	if($level == 1)



	{



		if($insert_exists)



		{



			return false;



		}



		elseif(delete_exists)



		{



			return false;



		}



		elseif($update_exists)



		{



			return false;



		}







	}



	else



	{



		if($insert_exists && $update_exists)



		{



			return false;



		}



		elseif($insert_exists && $delete_exists)



		{



			return false;



		}



		elseif($update_exists && $delete_exists)



		{



			return false;



		}	



		



	}



	return true;



}



function compareDate ($i_sFirstDate)



{



//Break the Date strings into seperate components







$arrFirstDate = explode ("-", $i_sFirstDate);







//$today = date("Y-n-d");



$today = "2007-03-01";



$arrToDay = explode ("-", $today);







$intFirstDay = (int)$arrFirstDate[2];



$intFirstMonth = (int)$arrFirstDate[1];



$intFirstYear = (int)$arrFirstDate[0];







$intSecondDay = (int)$arrToDay[2];



$intSecondMonth = (int)$arrToDay[1];



$intSecondYear = (int)$arrToDay[0];







 



// Calculate the diference of the two dates and return the number of days.











//$intDate1Jul = gregoriantojd($intFirstMonth, $intFirstDay, $intFirstYear);



//$intDate2Jul = gregoriantojd($intSecondMonth, $intSecondDay, $intSecondYear);



if($intFirstYear > $intSecondYear)



{



	return 1;



}



elseif($intFirstYear == $intSecondYear && $intFirstMonth > $intSecondMonth)



{



	 return 1;



}



elseif($intFirstYear == $intSecondYear && $intFirstMonth == $intSecondMonth && $intFirstDay > $intSecondDay)



{



	 return 1;



}



else



{



 return -1;



}















//return $intDate1Jul - $intDate2Jul;







}//end Compare Date



function merstrrever($str, $str1)



{



	return $str1.$str;



}







function get_array_link($id, $cat_table = "tblcat_info", $act = "info")



{



//Return Value: Return string of url



	if(!isset($id)) $id = 0;



	$select = "SELECT * FROM ".$cat_table." WHERE id = ".$id;



	$select = mysql_query($select) or die(mysql_error());



	//echo $id."-";



	$menu = '';



	while($sql = mysql_fetch_array($select))



	{



		$select1 = "SELECT * FROM ".$cat_table." WHERE id = ".$sql['parent_id'];



		$select1 = mysql_query($select1) or die(mysql_error());



		while($sql1 = mysql_fetch_array($select1))



		{



			$menu = "<a href='./?act=".$act."&post_id=".$sql1['id']."' class = 'Function'>".displayData_DB($sql1['name_vn'])."</a> > ";



			$menu = merstrrever($menu,get_array_link($sql1['id'], $cat_table, $act));



		}



	}



	return $menu;	



}







function get_array_product($id, $cat_table , $act, $lang)



{



	if(!isset($id)) $id = 0;



	$select = "SELECT * FROM ".$cat_table." WHERE id = ".$id;



	$select = mysql_query($select) or die(mysql_error());



	//echo $id."-";



	$menu = '';



	while($sql = mysql_fetch_array($select))



	{



		$select1 = "SELECT * FROM ".$cat_table." WHERE id = ".$sql['parent_id'];



		$select1 = mysql_query($select1) or die(mysql_error());



		while($sql1 = mysql_fetch_array($select1))



		{



			$menu = displayData_DB($sql1['name_'.$lang])." &nbsp;<img src=\"./images/dot_dangduyet.jpg\" border=\"0\">&nbsp;";



			$menu = merstrrever($menu,get_array_product($sql1['id'], $cat_table, $act, $lang));



		}



	}



	return $menu;	



}







function display_tree($id, $cat_table, &$template, $parent_id, $block = "GROUP", $type="")



{



//Return Value: Return No value.



	$select = "SELECT * FROM ".$cat_table." WHERE parent_id = ".$id.$type." AND name_vn <> '' ORDER BY priority_order DESC, id DESC";



	$select = mysql_query($select) or die(mysql_error());



	$menu = '';



	$prex = "";



	while($sql = mysql_fetch_array($select))



	{



		while($sql['level'])



		{



			if($sql['level'] > 1)



				$prex .= "&nbsp;&nbsp;&nbsp;";



			else



				$prex .= "|__";



			$sql['level'] --;	



		}



		$template->assign_block_vars($block, array(



			'id'  => $sql['id'],



			'name' 	=> $prex.displayData_Textbox($sql['name_vn']),



			'_selected' => ($sql['id'] == $parent_id)?'selected':''	



		));



		display_tree($sql['id'], $cat_table, $template, $parent_id, $block, $type);



		$prex = "";



	}



	



}



function display_tree_en($id, $cat_table, &$template, $parent_id, $block = "GROUP", $type="")



{



//Return Value: Return No value.



	$select = "SELECT * FROM ".$cat_table." WHERE parent_id = ".$id.$type." AND name_en <> '' ORDER BY priority_order DESC, id DESC";



	$select = mysql_query($select) or die(mysql_error());



	$menu = '';



	$prex = "";



	while($sql = mysql_fetch_array($select))



	{



		while($sql['level'])



		{



			if($sql['level'] > 1)



				$prex .= "&nbsp;&nbsp;&nbsp;";



			else



				$prex .= "|__";



			$sql['level'] --;	



		}



		$template->assign_block_vars($block, array(



			'id'  => $sql['id'],



			'name' 	=> $prex.displayData_Textbox($sql['name_en']),



			'_selected' => ($sql['id'] == $parent_id)?'selected':''	



		));



		display_tree($sql['id'], $cat_table, $template, $parent_id, $block, $type);



		$prex = "";



	}



	



}







?>



