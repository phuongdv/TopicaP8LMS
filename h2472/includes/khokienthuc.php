<?php

 $template -> set_filenames(array(

	'khokienthuc'	=> $dir_template . 'khokienthuc.tpl')

);

$template -> assign_vars(array(

		'user'	=>	$pro_author

	));



//-----------------------------------------------------

 





//------------------------------------------------------

//---------------------------begin filter -------------------------------------

getallmonhoc($monhoc);

getAllCourse($subject);







/*if(!isset($subject)||$subject==0)

	{$sql_po_course_filter="";}

	else 

	{ $sql_po_course_filter="and  courseid='".$subject."'";}	*/	

if(!isset($monhoc)||$monhoc=='0')

	{$sql_po_course_filter="";}

	else 

	{ $sql_po_course_filter="and courseid in (select id from mdl_course where fullname like '%".$monhoc."%') ";}		

	
//danglx modified 27-03-2014
if(isset($_GET['do_p']))
$do_p = $_GET['do_p'];
$template->assign_vars(array(
'do_p'   => $do_p,
));

if(isset($do_p) && $do_p=="myanswer")
{

$template->assign_vars(array(
'selected_2'  => 'selected="selected"',
));
$sql_my_answer=" and assignid='".$profiles['id']."'";
}
else
{
$sql_my_answer="";
}	
	
$template->assign_vars(array(
'thr_id'   => $thr_id,
));

if(isset($thr_id) && $thr_id!=0 && $thr_id!='')
{
$sql_thr_id=" and id = '".$thr_id."'";
}
else		
{
$sql_thr_id=" ";
}

//end danglx
	

	

	

get_search_text($searchtext);

if(!isset($p)||$p==0)

		{

		 $sql_limit=' limit 0,10'; 

		}

		else

		{

			$p2=p+10;

			$sql_limit=' limit '.$p.','.$p2.''; 	

		}





//-------------------------------------------------------------------------------

$sql_count_answer="select * from tblthread where 1=1 $sql_thr_id $sql_my_answer $sql_po_course_filter $sql_searchtext";

	$count_answer = $db->sql_query($sql_count_answer);

	$total=mysql_numrows($count_answer);

$sql_count_answer="select * from tblthread where 1=1 $sql_thr_id $sql_my_answer $sql_po_course_filter $sql_searchtext and knowledgebase=1";

	$count_answer = $db->sql_query($sql_count_answer);

	$total_knowledge=mysql_numrows($count_answer);







$sql_base_get_answers="select * from tblthread where knowledgebase=1  $sql_thr_id $sql_my_answer $sql_po_course_filter $sql_searchtext order by id desc $sql_limit";

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

												'tr_class'	=> ($i % 2 == 0) ? 'background-color:#CCCCCC;' : 'bg_color2',

												'stt'		=> $i,

												'q_id'		=> $q_id,

												'id'		=> $answers[$i]['id'],

												'name'		=> $answers[$i]['answername'],

												'author'	=> get_username_from_id($answers[$i]['userid']),

												'forward'	=> (check_have_reply($q_id)) ? 'display:none' : '',

												'rate'		=> count_q_on_thread($answers[$i]['id']),

												'time'		=> date('d/m/y H:i',$answers[$i]['time']),

												'delay'		=> get_delay($q_id,$answers[$i]['time']),

												'answer'	=> get_name_from_id($answers[$i]['assignid']).'<br>'.get_role($answers[$i]['courseid'],$answers[$i]['assignid']),

												'status'	=> return_status($answers[$i]['status']),

												'userid'    => '',

												'cname'     => get_cname($answers[$i]['courseid']),

												'knowledge' => ($answers[$i]['knowledgebase']==1) ? ' <input type="checkbox" name="chk'.$answers[$i]['id'].'" id="chk'.$answers[$i]['id'].'" value="1" checked="checked" />':' <input type="checkbox" name="chk'.$answers[$i]['id'].'" id="chk'.$answers[$i]['id'].'" value="1" />',

											));

   }

   

	$num_page = generate_pagination('?do=view_kkt&subject='.$subject.'&searchtext='.$searchtext.'', $total_knowledge,10,$p);

	$template -> assign_vars(array(

				'linkpage'				=>	'<div class="pagination">'.$num_page.'</div>',

			));



 }



  	 $template->assign_vars(array(

			'total'		=> $total,

			'total_filter'		=> $total_knowledge,

			'noreply'   =>$total_all_question-$total_relpy,

			'close'     =>$total_close,

			'total_question' =>$total_all_question));	

 //set link
$template->assign_vars(array(
'linkportal'		=> $linkportal,
'linkforum'         => $linkforum, 
'linkelearning'     => $linkelearning,
));	



 

$template -> pparse('khokienthuc');	

?>