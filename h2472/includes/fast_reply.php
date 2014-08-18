<?php

include('header.php');

$template -> set_filenames(array(

	'fast_reply'	=> $dir_template . 'fast_reply.tpl')

);













$sql="select * from tblanswer where id=".base64_decode($qid);

	$sql_subject_results = $db->sql_query($sql);

					while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))

					{

						if(check_have_reply($sql_subject_result['id']))

						{

						    

							

							

								

						 $sql_reply="select * from tblreply where answerid=".$sql_subject_result['id'];

					$sql_reply_results = $db->sql_query($sql_reply);

					$reply= $db->sql_fetchrow($sql_reply_results);

					    if($do=='edit')

						    {

						    if(isset($_POST['submit']))	

						    {   

						    	$answer=base64_decode($_GET['a_id']);

						    	$p_editor=$_POST['editor_kama'].'<em>Edited by :</em><strong>'.$answer.'</strong>';

						    	$sql_edit_reply="update tblreply set replydes='".$p_editor."' where id=".$reply['id'];

                                echo $sql_edit_reply;

                                die;

						    }

						$template->assign_block_vars('QUESTION',array(

							

							'name'		=> $sql_subject_result['answername'],

							'id'		=> $sql_subject_result['id'],

							'thread'		=> $sql_subject_result['thread'],

							'des'		=> $sql_subject_result['answerdes'],

							'author'    => get_name_from_id($sql_subject_result['userid']),

							'delay'     => get_delay( $sql_subject_result['id'], $sql_subject_result['time']),
							'attach'    => ($sql_subject_result['attach']!= '') ? '<div class="repley-attach">Attachments: <a href="./uploads/'.$sql_subject_result['attach'].'" target="_blank">'.$sql_subject_result['attach'].'</a></div>' : ''

							

						));

						    	$template -> assign_vars(array('editor'	=>	'inherit',));

						    	$template -> assign_vars(array('noidung'	=> $reply['replydes'],));

						        $template -> assign_vars(array(

                        'action'	=>	'<input type="submit" name="update" id="update" value=" Accept " onclick="ste.submit();" />',));

						    }	

					     else{

					   

					

						$template->assign_block_vars('QUESTION',array(

							

							'name'		=> $sql_subject_result['answername'],

							'id'		=> $sql_subject_result['id'],

							'thread'		=> $sql_subject_result['thread'],

							'des'		=> $sql_subject_result['answerdes'],

							'author'    => get_name_from_id($sql_subject_result['userid']),

							'delay'     => get_delay( $sql_subject_result['id'], $sql_subject_result['time']),
'attach'    => ($sql_subject_result['attach']!= '') ? '<div class="repley-attach">Attachments: <a href="./uploads/'.$sql_subject_result['attach'].'" target="_blank">'.$sql_subject_result['attach'].'</a></div>' : ''

							

						));

						$template -> assign_vars(array('editor'	=>	'none',));

						  

						

						$reply_str='<td colspan="2"><p><strong>Answer:</strong>[<a href="'.$url.'/?act=fastreply&do=edit&qid='.$qid.'&a_id='.$_GET['a_id'].'"> Edit </a>]'. $reply['replydes'].'</p>

                              </td>

                            <td></td>

                            </tr>';

						$template -> assign_vars(array('reply'	=>	$reply_str,));

						

					     }

						}

						

						

						

						

						

						

						else



						{

						$thread=$sql_subject_result['thread'];

						$template->assign_block_vars('QUESTION',array(

							

							'name'		=> $sql_subject_result['answername'],

							'id'		=> $sql_subject_result['id'],

							'thread'		=> $sql_subject_result['thread'],

							'des'		=> $sql_subject_result['answerdes'],

							'author'    => get_username_from_id($sql_subject_result['userid']),

							'delay'     => get_delay( $sql_subject_result['id'], $sql_subject_result['time']),

							'attach'    => ($sql_subject_result['attach']!= '') ? '<div class="repley-attach">Attachments: <a href="./uploads/'.$sql_subject_result['attach'].'" target="_blank">'.$sql_subject_result['attach'].'</a></div>' : ''


							

						));

						$template -> assign_vars(array('editor'	=>	'inherit'));

						$template -> assign_vars(array(

                        'action'	=>	'<input type="submit" name="submit" value=" Chấp nhận " onclick="ste.submit();" />',));

						}

					} 



if (isset($_POST['update']))	

{

	$answer=base64_decode($_GET['a_id']);

	if($_POST['editor_kama']=='' || !isset($_POST['editor_kama']))

	{

	echo "<script>alert('No answer yet  !');</script>";	

	

	}

	else 

	{

	$p_editor=$_POST['editor_kama'];

	

	$sql_answer_insert = "UPDATE  tblreply SET replydes='".$p_editor."',attach='".$file1."' where answerid='".base64_decode($qid)."'";

   

   



			$sql_answer_insert = $db->sql_query($sql_answer_insert);



			//$sql_answer_update = "UPDATE  tblthread set status='2',reply_time='".time()."',assignid='4099'  where id='".$thread."'";



           // $sql_answer_update = $db->sql_query($sql_answer_update);	

	  

			if(isset($p))

			{

				echo "<script>alert('Answer had been sent,thankyou for answer this question !');window.close()</script>";

			}

			else



				echo '<script>window.location="./?act=answers&do=detail&id='.$id.'";</script>'; 

	}

	

	

	echo 'updated';

	die;

}

					

					

					

					

if (isset($_POST['submit']))	

{

	

	

	

	

	

	$answer=base64_decode($_GET['a_id']);

	

	// get file

	

	$file1Name 		= $_FILES['attach']['name'];

	$file1Type 		= $_FILES['attach']['type'];

	$file1Temp 		= $_FILES['attach']['tmp_name'];

	

	



	if($_POST['editor_kama']=='' || !isset($_POST['editor_kama']))

	{

	echo "<script>alert('No answer yet  !');</script>";	

	

	}

	else 

	{

	$p_editor=$_POST['editor_kama'].'<em>Answered by :</em><strong>'.$answer.'</strong>';

	

	$sql_answer_insert = "INSERT INTO tblreply (userid, answerid, replydes, attach, time) 



								VALUES('4099', '".base64_decode($qid)."', '".$p_editor."', '".$file1."', '".time()."')";

   



			$sql_answer_insert = $db->sql_query($sql_answer_insert);



			$sql_answer_update = "UPDATE  tblthread set status='2',reply_time='".time()."',assignid='4099'  where id='".$thread."'";



            $sql_answer_update = $db->sql_query($sql_answer_update);	

	  

			if(isset($p))



				echo "<script>alert('Answer had been sent,thankyou for answer this question !');window.close()</script>";



			else



				echo '<script>window.location="./?act=answers&do=detail&id='.$id.'";</script>'; 

	}

	

	

}	

















$template -> pparse('fast_reply');

?>

