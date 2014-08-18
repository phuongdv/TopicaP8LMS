<?php
setcookie("URLCookie", curPageURL(), time()+3600);

include('header.php');

 $template -> set_filenames(array(

	'pm'	=> $dir_template . 'pm.tpl')

);



	$template -> assign_vars(array(

		'user'	=>	$pro_author

	));

$template -> assign_vars(array(

	'user'	=>	 get_name_from_id($profiles['id']),

));


	

	if($do=="myanswer")

			{

		$template->assign_vars(array(

		'selected_2'  => 'selected="selected"',

		));

		$sql_my_answer=" and userid='".$profiles['id']."'";

			}

		else

			{

		$template->assign_vars(array(

		'selected_1'   => 'selected="selected"',

		));

		$sql_my_answer="";

			}
			
$template->assign_vars(array(
'thr_id'   => $thr_id,
));
$sql_my_answer="";
if(isset($thr_id) && $thr_id!=0 && $thr_id!='')
{
$sql_thr_id=" and id = '".$thr_id."'";
}
else		
{
$sql_thr_id=" ";
}		
getAllCourse($subject);

		



		

		



	// -------------------- lấy ra khóa học của user đang đăng nhập  đưa vào selecte box----------------------------------------------*/

	getCourseForHV($profiles['id'],$subject);

	// --------------------lấy ra Giang vien , cvht  user có thể gán ----------------------------------------------*/

	//getGVCVHTForCVHT($subject,$profiles['id'],$gv);

	//----------------------lay ra ds topic ---------------------------

	get_all_topic($topic);

	// Loc do tre

	get_delay_list($delay);

		//---------------------------------------------------------

	get_status_list($status);

	get_search_text($searchtext);

	get_attach($attach);

	

	$sql_po_course="courseid in (select courseid from tblassign_role where userid={$profiles['id']} and roleid=5)";

	if(!isset($subject)||$subject==0)

	{$sql_po_course_filter="";}

	else 

	{$sql_po_course_filter=" and  courseid ='".$subject."'";}

	

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

		 $sql_limit=' limit 0,20'; 

		}

		else

		{

			$p2=p+20;

			$sql_limit=' limit '.$p.','.$p2.''; 	

		}

	

	
	//----------------- dem tat ca cac chu de---------------

	$sql_count_total_answer="select * from tblthread";

	$count_total_answer = $db->sql_query($sql_count_total_answer) or die(mysql_error());

	$total_all_answer=mysql_numrows($count_total_answer);
    
	//----------------- dem tat ca cac cau hoi cua po sau  khi loc---------------

	$sql_count_answer="select * from tblthread where 1=1 $sql_thr_id $sql_my_answer $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach";

	$count_answer = $db->sql_query($sql_count_answer) or die(mysql_error());

	$total=mysql_numrows($count_answer);
    //----------------- dem so chu de chua tra loi ---------------

	$sql_count_reply_answer="select * from tblthread where 1=1 $sql_thr_id $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach $sql_my_answer  and (status = 0 or status = 3)";

	$count_reply_answer = $db->sql_query($sql_count_reply_answer) or die(mysql_error());

	$thr_norep=mysql_numrows($count_reply_answer);

	//--------------------Đếm tổng số câu hỏi-----------------
    $sql_count_total_answer="select count(*) from tblanswer ";

	$count_total_answer = $db->sql_query($sql_count_total_answer) or die(mysql_error());

	$result = $db->sql_fetchrow($count_total_answer);

	$total_all_question=$result['count(*)'];
	//--------------------- đếm tổng số câu hỏi sau lọc
    $sql_count_total_answer="select count(*) from tblanswer where thread in (select id from tblthread where 1=1 $sql_thr_id $sql_thr_id $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach)";

	//echo $sql_count_total_answer;

	$count_total_answer = $db->sql_query($sql_count_total_answer) or die(mysql_error());

	$result = $db->sql_fetchrow($count_total_answer);

	$total_filter_question=$result['count(*)'];
	//---------------------------- dem so cau hoi da tra loi ----------------------

	$sql_qus_reply="select count(*) from tblreply where answerid in(select id from tblanswer where thread in (select id from tblthread where 1=1 $sql_thr_id $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach $sql_my_answer))";

    //echo $sql_qus_reply;

	$count_qus_reply = $db->sql_query($sql_qus_reply) or die(mysql_error());

	$result = $db->sql_fetchrow($count_qus_reply);

	$qs_rpl=$result['count(*)'];

	$sql_base_get_answers="select * 
							from tblthread where 1=1 $sql_thr_id $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach order by id desc $sql_limit";

	

	

	

	

	

	

	

	

	

	//echo $sql_base_get_answers;

	

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

												'q_id'		=> $q_id,

												'name'		=> $answers[$i]['answername'],

												'author'	=> get_username_from_id($answers[$i]['userid']),

												'forward'	=> (check_have_reply($answers[$i]['id'])) ? 'display:none' : '',

												'rate'		=> count_q_on_thread($answers[$i]['id']),

												'time'		=> date('d/m/y H:i',$answers[$i]['time']),

												'delay'		=> get_delay($q_id,$answers[$i]['time']),

												'answer'	=> get_name_from_id($answers[$i]['assignid']).'<br>'.get_role($answers[$i]['courseid'],$answers[$i]['assignid']),

												'status'	=> return_status($answers[$i]['status']),

												'userid'    => '',
												'thanks'    => $answers[$i]['thanks_number'],

												'cname'     => get_cname($answers[$i]['courseid']),

											));

   

 

   }

   

	$num_page = generate_pagination('?subject='.$subject.'&gv='.$gv.'&topic='.$topic.'&delay='.$delay.'&status='.$status.'&searchtext='.$searchtext.'&attach='.$attach.'&do='.$do, $total,20, $p);

	$template -> assign_vars(array(

				'linkpage'				=>	'<div class="pagination">'.$num_page.'</div>',

			));
//set link
$template->assign_vars(array(
'linkportal'		=> $linkportal,
'linkforum'         => $linkforum, 
'linkelearning'     => $linkelearning,
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

	

$template -> pparse('pm');

?>

