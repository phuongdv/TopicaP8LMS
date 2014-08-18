<?
$template -> set_filenames(array(
	'thread_edit'	=> $dir_template . 'thread_edit.tpl')
);
$sql_get_thread="select * from tblthread where id=$id";
$get_thread = $db->sql_query($sql_get_thread) or die(mysql_error());


		while ($thread = $db->sql_fetchrow($get_thread))
		{
			$template->assign_vars(array(
				'name'		=> $thread['answername'],
				'topicid'	=> $thread['topicid'],
				'course'	=> $thread['courseid'],
				'knb_selected1' => ($thread['knowledgebase']==1)? 'selected="selected"' :'',
				'knb_selected2' => ($thread['knowledgebase']==0)? 'selected="selected"' :'',
				'hdn_selected1' => ($thread['hidden']==1)? 'selected="selected"' :'',
				'hdn_selected2' => ($thread['hidden']==0)? 'selected="selected"' :'',
			));
			get_all_topic($thread['topicid']);
			getAllCourse($thread['courseid']);
		}
if (isset($_POST['submit']))
{
	if($profiles['code']=='admin' ||$profiles['code']=='po2'  )
	{
	// update thread
	$sql_update_thread="update tblthread set answername='".$_POST['name']."',topicid='".$_POST['lstTopic']."',courseid='".$_POST['course']."',knowledgebase='".$_POST['knb']."',hidden='".$_POST['hidden']."' where id='$id'";	
    $sql_thread_save= $db->sql_query($sql_update_thread);
    // update answer
	$sql_update_answer="update tblanswer set answername='".$_POST['name']."',topicid='".$_POST['lstTopic']."',courseid='".$_POST['course']."' where thread='$id'";	
	$sql_answer_save = $db->sql_query($sql_update_answer);
		
		
		
		
	echo"<script>
	     
			window.parent.location=window.parent.location.href;
			
			window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close()', 2000);
			</script>";
	}
	else 
	{
		echo "Bạn không có quyền";
	}
	}








$template -> pparse('thread_edit');
?>