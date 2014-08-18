<?php







setcookie("URLCookie", curPageURL(), time()+3600);



include('header.php');    





$template -> assign_vars(array(



	'username'	=>	get_username_from_id($profiles['id']),



));











 $template -> set_filenames(array(



	'gvcm'	=> $dir_template . 'gvcm.tpl')



);







	$template -> assign_vars(array(



		'user'	=>	$pro_author



	));







	if($do=="myanswer")



			{



		$template->assign_vars(array(



		'selected_2'  => 'selected="selected"',



		));



		$sql_my_answer=" and assignid='".$profiles['id']."'";



			}



		else



			{



		$template->assign_vars(array(



		'selected_1'   => 'selected="selected"',



		));



		$sql_my_answer="";



			}



		







		



		







	// -------------------- lấy ra khóa học của user đang đăng nhập  đưa vào selecte box----------------------------------------------*/



	getCourseForGVCM($profiles['id'],$sname);



	// --------------------lấy ra Giang vien , cvht  user có thể gán ----------------------------------------------*/



	getGvhdForGVCM($sname,$profiles['id'],$gv);



	//----------------------lay ra ds topic ---------------------------



	get_all_topic($topic);



	// Loc do tre



	get_delay_list($delay);



		//---------------------------------------------------------



	get_status_list($status);



	get_search_text($searchtext);



	get_attach($attach);



	



	$sql_po_course="courseid in (SELECT c.id courseid

FROM mdl_user u

INNER JOIN mdl_role_assignments ra ON ra.userid = u.id

INNER JOIN mdl_context ct ON ct.id = ra.contextid

INNER JOIN mdl_course c ON c.id = ct.instanceid

INNER JOIN mdl_role r ON r.id = ra.roleid

INNER JOIN mdl_course_categories cc ON cc.id = c.category



WHERE

u.id={$profiles['id']}

and

 (r.id=4 or r.id=14))";



	if($sname=='')



	{$sql_po_course_filter="";}



	else 



	{$sql_po_course_filter=" and courseid in (select id from mdl_course where fullname like '%".$sname."%')";}

        

	



	if(!isset($gv)||$gv==0)



	{$sql_po_assigner="";}



	else 



	{ $sql_po_assigner=" and assignid='".$gv."'";}



	



	if(!isset($topic)||$topic==0)



	{$sql_po_topic="";}



	else 



	{ $sql_po_topic=" and topicid='".$topic."'";}



	



	//-------------------- status sql



	



	if(!isset($p)||$p==0)



		{



		 $sql_limit=' limit 0,10'; 



		}



		else



		{



			$p2=p+10;



			$sql_limit=' limit '.$p.','.$p2.''; 	



		}



	



	//echo $sql_limit;



	



	//-------------------



	// for test



	/*echo $sql_po_course;



	die();*/



	//----------------- dem tat ca cac cau hoi cua po ---------------



	$sql_count_total_answer="select * from tblthread where $sql_po_course";



	$count_total_answer = $db->sql_query($sql_count_total_answer) or die(mysql_error());



	$total_all_answer=mysql_numrows($count_total_answer);



	//----------------- ----------------------------------------------



	$sql_count_total_answer="select count(*) from tblanswer where $sql_po_course";



	$count_total_answer = $db->sql_query($sql_count_total_answer) or die(mysql_error());



	$result = $db->sql_fetchrow($count_total_answer);



	$total_all_question=$result['count(*)'];



	



	
       
	$sql_base_get_answers="select * from tblthread where $sql_po_course $sql_my_answer $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach order by id desc $sql_limit";

         	//echo  $sql_base_get_answers;

	//----------------- dem tat ca cac cau hoi cua po sau  khi loc---------------



	$sql_count_answer="select * from tblthread where $sql_po_course $sql_my_answer $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach";



	$count_answer = $db->sql_query($sql_count_answer) or die(mysql_error());



	$total=mysql_numrows($count_answer);



	//---------------------------------------------------------------



	//----------------- dem so cau hoi chua duoc tra loi ---------------



	$sql_count_reply_answer="select * from tblthread where $sql_po_course  and (status = 3 or status=0)";



	$count_reply_answer = $db->sql_query($sql_count_reply_answer) or die(mysql_error());



	$total_relpy=mysql_numrows($count_reply_answer);



	//---------------------------------------------------------------



	//----------------- dem so cau hoi da dong ---------------



	$sql_count_close_answer="select * from tblthread where $sql_po_course  and status = 1";



	$count_close_answer = $db->sql_query($sql_count_close_answer) or die(mysql_error());



	$total_close=mysql_numrows($count_close_answer);



	



	



	



	//----------------- --------------------------------------



	$sql_count_total_answer="select count(*) from tblanswer where thread in (select id from tblthread where $sql_po_course $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach)";



	//echo $sql_count_total_answer;



	$count_total_answer = $db->sql_query($sql_count_total_answer) or die(mysql_error());



	$result = $db->sql_fetchrow($count_total_answer);



	$total_filter_question=$result['count(*)'];



	



	



	//----------------- dem so chu de chua tra loi ---------------



	$sql_count_reply_answer="select * from tblthread where $sql_po_course $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach $sql_my_answer  and (status = 0 or status = 3)";



	$count_reply_answer = $db->sql_query($sql_count_reply_answer) or die(mysql_error());



	$thr_norep=mysql_numrows($count_reply_answer);



	//---------------------------------------------------------------



	



	$sql_count_total_answer="select count(*) from tblanswer where thread in (select id from tblthread where $sql_po_course $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach $sql_my_answer)";



	//echo $sql_count_total_answer;



	$count_total_answer = $db->sql_query($sql_count_total_answer) or die(mysql_error());



	$result = $db->sql_fetchrow($count_total_answer);



	$total_filter_question=$result['count(*)'];



	//----------------- --------------------------------------



	



	



	



	//---------------------------- dem so cau hoi da tra loi ----------------------



	$sql_qus_reply="select count(*) from tblreply where answerid in(select id from tblanswer where thread in (select id from tblthread where $sql_po_course $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach $sql_my_answer))";



    //echo $sql_qus_reply;



	$count_qus_reply = $db->sql_query($sql_qus_reply) or die(mysql_error());



	$result = $db->sql_fetchrow($count_qus_reply);



	$qs_rpl=$result['count(*)'];



	



    //---------------------- dem so chu de can tra loi



    



   $sql="select count(*) from tblthread where assignid='".$profiles['id']."' and status=3 limit 0,1 ";



   $question = $db->sql_query($sql) or die(mysql_error());



	$result = $db->sql_fetchrow($question);



	$phai_traloi=$result['count(*)'];



	



	



	



	



	



	$result_answer = $db->sql_query($sql_base_get_answers) or die(mysql_error());



 if(mysql_numrows($result_answer)>0)



 {	



			   $template->assign_vars(array(



						'empty'		=> 'none',));



			   $i=0;



			   



   while ( $answer_rows = $db->sql_fetchrow($sql_answer)) 



   {



   	$answers[]=$answer_rows;



   }



   //echo count($answers);



   



   for($i=0;$i<count($answers);$i++)



   {



	$q_id=get_lastq($answers[$i]['id']);	  



   	



   	



   $template -> assign_block_vars('L_ANWSER', array(



												'tr_class'	=> ($i % 2 == 0) ? 'bg_color1' : 'bg_color2',



												'stt'		=> $i,



												'id'		=> $answers[$i]['id'],



												'id2'		=> '',



												'name'		=> $answers[$i]['answername'],



												'author'	=> get_username_from_id($answers[$i]['userid']),



												'forward'	=> ($answers[$i]['status']!=0 && $answers[$i]['status']!=3) ? 'display:none' : '',



												'rate'		=> count_q_on_thread($answers[$i]['id']),



												'time'		=> date('d/m/y H:i',$answers[$i]['time']),



												'delay'		=> get_delay($q_id,$answers[$i]['time']),



												'answer'	=> get_name_from_id($answers[$i]['assignid']).'<br>'.get_role($answers[$i]['courseid'],$answers[$i]['assignid']),



												'assign'    => ($answers[$i]['assignid']==$profiles['id'])? 'Assign':'',



												'status'	=> return_status($answers[$i]['status']),



												'userid'    => '',



												'cname'     => get_cname($answers[$i]['courseid']),



											));



   



 



   }



   



	$num_page = generate_pagination('?sname='.$sname.'&gv='.$gv.'&topic='.$topic.'&delay='.$delay.'&status='.$status.'&searchtext='.$searchtext.'&attach='.$attach, $total,10, $p);



	$template -> assign_vars(array(



				'linkpage'				=>	'<div class="pagination">'.$num_page.'</div>',



			));



	



	



  	 $template->assign_vars(array(



			'total'		=> $total_all_answer,



			'total_filter'		=> $total,



			'noreply'   =>$total_all_question-$total_relpy,



			'filter_question'     =>$total_filter_question,



			'thr_norep'      =>$thr_norep,



			'thr_repl'       =>$total-$thr_norep,



			'qs_repl'        =>$qs_rpl,



			'qs_norep'       =>$total_filter_question-$qs_rpl,



			'havereply'      =>$phai_traloi,



			'total_question' =>$total_all_question));	



	



}	



	










//set link
$template->assign_vars(array(
'linkportal'		=> $linkportal,
'linkforum'         => $linkforum, 
'linkelearning'     => $linkelearning,
));	




$template -> pparse('gvcm');







?>



