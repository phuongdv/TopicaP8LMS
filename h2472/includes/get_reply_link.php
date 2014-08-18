<?php
$template -> set_filenames(array(
	'get_reply_link'	=> $dir_template . 'get_reply_link.tpl')
);
$sql="select * from tblanswer where id=".base64_decode($qid);
	$sql_subject_results = $db->sql_query($sql);
					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))
					{
						$thread=$sql_subject_result['thread'];
						$template->assign_block_vars('QUESTION',array(
							
							'name'		=> $sql_subject_result['answername'],
							'id'		=> $sql_subject_result['id'],
							'thread'		=> $sql_subject_result['thread'],
							'des'		=> $sql_subject_result['answerdes'],
							'username'    => get_username_from_id($sql_subject_result['userid']),
							'author'    => get_name_from_id($sql_subject_result['userid']),
							'delay'     => get_delay( $sql_subject_result['id'], $sql_subject_result['time']),
							'time'      =>  date('d/m/Y H:i:s ',$sql_subject_result['time']),
							'link'      =>  $url.'/?act=fastreply&qid='.base64_encode($sql_subject_result['id']),
							'from'      => get_name_from_id(base64_decode($from)),
							'course'    =>get_course($sql_subject_result['userid']),
							
						));
					} 
	
if (isset($_POST['submit']))	
{
	
	
	/*$p_editor=$_POST['editor_kama'];
	
	$sql_answer_insert = "INSERT INTO tblreply (userid, answerid, replydes, attach, time) 

								VALUES('4099', '".base64_decode($qid)."', '".$p_editor."', '".$file1."', '".time()."')";
   

			$sql_answer_insert = $db->sql_query($sql_answer_insert);

			$sql_answer_update = "UPDATE  tblthread set status=2,reply_time='".time()."',assignid='4099'  where id='".$thread."'";

            $sql_answer_update = $db->sql_query($sql_answer_update);	
	  
			if(isset($p))

				echo '<script>window.location="./?act=answers&do=detail&id='.$id.'&p='.$p.'";</script>';

			else

				echo '<script>window.location="./?act=answers&do=detail&id='.$id.'";</script>'; 
	*/
	
	
}	








$template -> pparse('get_reply_link');
?>
