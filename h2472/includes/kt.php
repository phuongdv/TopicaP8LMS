<?php

setcookie("URLCookie", curPageURL(), time()+3600);

include('header.php');

 $template -> set_filenames(array(

	'kt'	=> $dir_template . 'kt.tpl')

);

$template -> assign_vars(array(

	'username'	=>	get_username_from_id($profiles['id']),

));


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

	getCourseForCVHT($profiles['id'],$subject);

	// --------------------lấy ra Giang vien , cvht  user có thể gán ----------------------------------------------*/

	getGVCVHTForCVHT($subject,$profiles['id'],$gv);

	//----------------------lay ra ds topic ---------------------------

	get_all_topic($topic);

	// Loc do tre

	get_delay_list($delay);

		//---------------------------------------------------------

	get_status_list($status);

	get_search_text($searchtext);

	get_attach($attach);

	

	$sql_po_course=" topicid=3 ";

	if(!isset($subject)||$subject==0)

	{$sql_po_course_filter="";}

	else 

	{$sql_po_course_filter=" and courseid = '".$subject."'";}

	

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

	

	

	$sql_base_get_answers="select * from tblthread where $sql_po_course $sql_my_answer $sql_po_course_filter $sql_po_assigner $sql_po_topic $sql_status $sql_po_delay $sql_searchtext $sql_attach order by id desc $sql_limit";

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

	

	

	

	

	

	

	

	

	

	echo $sql_base_get_answers;

	

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

		  

   	

   	

   $template -> assign_block_vars('L_ANWSER', array(

												'tr_class'	=> ($i % 2 == 0) ? 'bg_color1' : 'bg_color2',

												'stt'		=> $i,

												'id'		=> $answers[$i]['id'],

												'id2'		=> '',

												'name'		=> $answers[$i]['answername'],

												'author'	=> get_username_from_id($answers[$i]['userid']),

												'forward'	=> (check_have_reply($answers[$i]['id'])) ? 'display:none' : '',

												'rate'		=> count_q_on_thread($answers[$i]['id']),

												'time'		=> date('d/m/y H:i',$answers[$i]['time']),

												'delay'		=> get_delay($q_id,$answers[$i]['time']),

												'answer'	=> get_name_from_id($answers[$i]['assignid']).'<br>'.get_role($answers[$i]['courseid'],$answers[$i]['assignid']),

												'status'	=> return_status($answers[$i]['status']),

												'userid'    => '',

												'cname'     => get_cname($answers[$i]['courseid']),

											));

   

 

   }

   

	$num_page = generate_pagination('?subject='.$subject.'&gv='.$gv.'&topic='.$topic.'&delay='.$delay.'&status='.$status.'&searchtext='.$searchtext.'&attach='.$attach, $total,10, $p);

	$template -> assign_vars(array(

				'linkpage'				=>	'<div class="pagination">'.$num_page.'</div>',

			));

	

	

  	 $template->assign_vars(array(

			'total'		=> $total_all_answer,

			'total_filter'		=> $total,

			'noreply'   =>$total_relpy,

			'close'     =>$total_close));	

	

}	

	

$template -> pparse('kt');

?>

