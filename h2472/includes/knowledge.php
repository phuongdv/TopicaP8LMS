<?php
 $template -> set_filenames(array(
	'knowledge'	=> $dir_template . 'knowledge.tpl')
);
$template -> assign_vars(array(
		'user'	=>	$pro_author
	));
if($profiles['code']!='po2')
{
echo "You have no permission to access this page";
die();	
}	
//-----------------------------------------------------





//------------------------------------------------------
//---------------------------begin filter -------------------------------------

getCourseByPO($profiles['id'],$subject);
if(!isset($subject)||$subject==0)
	{$sql_po_course_filter="";}
	else 
	{ $sql_po_course_filter=" and courseid='".$subject."'";}			
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
$sql_count_answer="select * from tblthread where courseid in (select courseid from tblassign_role where userid={$profiles['id']} and roleid=13) $sql_po_course_filter $sql_searchtext";
	$count_answer = $db->sql_query($sql_count_answer);
	$total=mysql_numrows($count_answer);
$sql_count_answer="select * from tblthread where courseid in (select courseid from tblassign_role where userid={$profiles['id']} and roleid=13) $sql_po_course_filter $sql_searchtext and knowledgebase=1";
	$count_answer = $db->sql_query($sql_count_answer);
	$total_knowledge=mysql_numrows($count_answer);



$sql_base_get_answers="select * from tblthread where courseid in (select courseid from tblassign_role where userid={$profiles['id']} and roleid=13) $sql_po_course_filter $sql_searchtext order by id desc $sql_limit";


$sql_save=$sql_base_get_answers;
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
   
	$num_page = generate_pagination('?do=knowledge&subject='.$subject.'&searchtext='.$searchtext.'', $total,10,$p);
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

			
			
			
			
			
			if($_POST['button']==' Save ')
 {
 	
 	
 	$result_answer = $db->sql_query($sql_save) or die(mysql_error());
 if(mysql_numrows($result_answer)>0)
 {	
			   
   while ( $answer_rows = $db->sql_fetchrow($sql_answer)) 
   {
   	$answers[]=$answer_rows;
   }
   
   for($i=0;$i<count($answers);$i++)
   {
   	$chk='chk'.$answers[$i]['id'];
   	if($_POST[$chk]=='')
   	{$_POST[$chk]=0;}
    
   	$sql_save="update tblthread set knowledgebase='$_POST[$chk]' where id='".$answers[$i]['id']."'";
   	$result_answer = $db->sql_query($sql_save);
   }
 	
 	if(!isset($_COOKIE['URLCookie']))
 	{
       $url='./?do=knowledge';	
 	}
 	else 
 	{
 		$url=$_COOKIE['URLCookie'];		
 	}
    $template->assign_vars(array(
						'refresh'		=> '<script>window.location="'.$url.'";</script>',));
			   
 	
 	
 	
 
 	
 }
 } 

 
$template -> pparse('knowledge');	
?>