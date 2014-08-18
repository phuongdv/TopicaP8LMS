<?php
   if(time()> strtotime('2013-04-27 00:00:00') && time() < strtotime('2013-05-02 00:00:00'))
   {
    echo '<script>alert("Trong dịp nghỉ lễ 30/04 - 01/05/2013 hệ thống H2472 sẽ tạm dừng tiếp nhận câu hỏi mới từ 00:00 ngày 27-04-2013 đến 00:00 ngày 02-05-2013.");
	     history.back();
	     </script>';
   }
include('header.php');
$template -> set_filenames(array(
	'answers-creat'	=> $dir_template . 'answers-creat.tpl')
);
$template -> assign_vars(array(
	'user'	=>	$pro_author
));
$p_submit = '';
if(isset($_POST['submit']))
	$p_submit = $_POST['submit'];
$bEdited = false;
if (!empty($id) && is_numeric($id) && $do=="edit") {
	$bEdited = true;
	$sql_answer = "SELECT * FROM tblanswer WHERE id = " . $id ." LIMIT 1";
	$sql_answer = $db->sql_query($sql_answer) or die(mysql_error());
	while ( $answer_rows = $db->sql_fetchrow($sql_answer)) {
		$template -> assign_vars(array(
			'name'			=> $answer_rows['answername'],
			'des'			=> $answer_rows['answerdes'],
			'attact'		=> ($answer_rows['attach']!='') ? '<tr><td>Attachments: </td><td><a href="./uploads/'.$answer_rows['attach'].'" target="_blank">'.$answer_rows['attach'].'</a></td></tr>' : '',
		));
		$sql_topic = "SELECT * FROM tbltopic ORDER BY id DESC";
		$sql_topic = $db->sql_query($sql_topic) or die(mysql_error());
		while ($topic_rows = $db->sql_fetchrow($sql_topic))
		{
			$template -> assign_block_vars('TOPIC_CREATE', array(
				'id'		=> $topic_rows['id'],
				'name'		=> $topic_rows['topicname'],
				'selected'	=> ($topic_rows['id']==$answer_rows['topicid']) ? ' selected' : ''
			));
		}
		$sql_course = "SELECT c.id,c.fullname,c.shortname
					FROM
					mdl_course c
					INNER JOIN tblassign_role ra ON ra.userid = '".$profiles['id']."'
					WHERE 
					c.id = ra.courseid and c.visible <>0";
        $sql_course="
	 SELECT c.id,c.fullname,c.shortname
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE u.id = '".$profiles['id']."'
	 and c.visible <>0
	 
	 ";
		$sql_course = $db->sql_query($sql_course) or die(mysql_error());
		while ($course_rows = $db->sql_fetchrow($sql_course))
		{
			$template -> assign_block_vars('COURSE', array(
				'id'		=> $course_rows['id'],
				'name'		=> $course_rows['shortname'],
				'selected'	=> ($course_rows['id']==$course) ? ' selected' : ''
			));
		}
		$sql_group = "SELECT * FROM tblgroup WHERE parent = 0 AND ( id NOT IN (1,2,8) ) ORDER BY id ASC";
		$sql_group = $db->sql_query($sql_group) or die(mysql_error());
		while ($group_rows = $db->sql_fetchrow($sql_group))
		{
			$template -> assign_block_vars('GROUP', array(
				'id'		=> $group_rows['id'],
				'name'		=> $group_rows['name'],
				'checked'	=> ($group_rows['id']==$answer_rows['groupid']) ? ' checked="checked"' : ( ($answer_rows['groupid']==3&&($group_rows['id']==4||$group_rows['id']==5)) ? ' checked="checked"' : '' )
			));
		}
	}
} else {
	$sql_topic = "SELECT * FROM tbltopic ORDER BY id DESC";
	$sql_topic = $db->sql_query($sql_topic) or die(mysql_error());
	while ($topic_rows = $db->sql_fetchrow($sql_topic))
	{
		$template -> assign_block_vars('TOPIC_CREATE', array(
			'id'		=> $topic_rows['id'],
			'name'		=> $topic_rows['topicname']
		));
	}
	$sql_course = "SELECT c.id,c.fullname,c.shortname
					FROM
					mdl_course c
					INNER JOIN tblassign_role ra ON ra.userid = '".$profiles['id']."'
					WHERE 
					c.id = ra.courseid and c.visible <>0
					";
     $sql_course="
	 SELECT c.id,c.fullname,c.shortname
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE u.id = '".$profiles['id']."'
	 and c.visible <>0
	 
	 ";
	$sql_course_results = $db->sql_query($sql_course);
	while($sql_course_result = $db->sql_fetchrow($sql_course_results))
	{
		$template->assign_block_vars('COURSE',array(
			'id'			=> displayData_DB($sql_course_result['id']),
			'name'			=> displayData_DB($sql_course_result['shortname']),
			'selected'		=> ($sql_course_result['id']==$course) ? ' selected' : ''
		));
	}
	$sql_group = "SELECT * FROM tblgroup WHERE parent = 0 AND ( id NOT IN (1,2,8) ) ORDER BY id ASC";
	$sql_group = $db->sql_query($sql_group) or die(mysql_error());
	while ($group_rows = $db->sql_fetchrow($sql_group))
	{
		$template -> assign_block_vars('GROUP', array(
			'id'		=> $group_rows['id'],
			'name'		=> $group_rows['name'],
			'checked'	=> ($group_rows['id']==3) ? ' checked="checked"' : ''
		));
	}
}
$bOK = true;
if($p_submit == 'Chấp nhận') {
	
	
	$file1Name 		= $_FILES['attach']['name'];
	$file1Type 		= $_FILES['attach']['type'];
	$file1Temp 		= $_FILES['attach']['tmp_name'];
	//var_dump($file1Type);
	$p_name 		= $_POST['name'];
	if(checkVietnamese($p_name))
	{
		$t=1;
	}
	else 
	{
		$t=0;
	}
	$p_topic 		= $_POST['topic'];
	$p_course 		= $_POST['course'];
	$p_group 		= $_POST['group'];
	$p_editor 		= $_POST['editor_kama'];
	// Adding
	if (!$bEdited){
		if($bOK) {
			if( !isset($p_name) || $p_name=='' || $t==0 || !isset($p_topic) || $p_topic=='' || !isset($p_course) || $p_course=='' || !isset($p_group) || $p_group=='' || !isset($p_editor) || $p_editor=='' ) {
				$strMsg = "";
				$bOK = false;
				if(!isset($p_name) || $p_name=='')
					$strMsg .= "Vui lòng nhập tên câu hỏi!<br />";
				if($t==0)
					$strMsg .= "Vui lòng nhập tiếng việt có dấu và ít nhất 5 từ !<br />";
				if(!isset($p_topic) || $p_topic=='')
					$strMsg .= "Vui lòng nhập danh mục!<br />";
				if(!isset($p_course) || $p_course=='')
					$strMsg .= "Vui lòng nhập khóa học!<br />";
				if(!isset($p_group) || $p_group=='')
					$strMsg .= "Vui lòng chọn đối tượng gửi câu hỏi!<br />";
				if(!isset($p_editor) || $p_editor=='')
					$strMsg .= "Vui lòng nội dung câu hỏi!<br />";
               $template->assign_vars(array(
              'des'		=>$p_editor));
               $template->assign_vars(array(
              'name'		=>$p_name));
				/*$strMsg = '<script>window.location="./?act=answers&do=creat";</script>';*/
			} else {
				$bOK = true;
			}
		}
		// Cap nhat vao database
		if($bOK)
		{	
			if (!empty($file1Name))
			{
				if($file1Type=="image/jpeg"||$file1Type=="image/gif"||$file1Type=="image/png") {
					$result = @upload_files($file1Name, $file1Type, $file1Temp, $dir_upload);
				} //elseif($file1Type=="application/msword"||$file1Type=="text/plain"||$file1Type=="application/vnd.ms-excel"||$file1Type=="application/zip") {
					//$result = @upload_files_doc($file1Name, $file1Type, $file1Temp, $data_upload);
				elseif($file1Type=="application/msword"||$file1Type=="text/plain"||$file1Type=="application/vnd.ms-excel"||$file1Type=="application/zip"||$file1Type=="application/rar"||$file1Type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" ||$file1Type=="application/octet-stream" ||$file1Type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  	

||$file1Type=="application/vnd.ms-powerpoint" ||$file1Type=="application/vnd.openxmlformats-officedocument.presentationml.presentation" ||$file1Type=="application/pdf" ) {
					$result = @upload_files_doc($file1Name, $file1Type, $file1Temp, $data_upload);
				}
				if(!$result)
				{
					$bOK = false;
					$template -> assign_block_vars('NEWUSER_MSG', array(
						'newuser_msg'	=> 'Failed to upload')
					);
				}
				else
					$file1 = $file1Name . $file1Type;
			}
			$sql_answer_insert_thread = "INSERT INTO tblthread(answername, class_id, topicid, courseid, groupid, userid, answerdes, attach, time, setting, status, parent, voteup, votedown, count) 
								VALUES('".$p_name."', '".$class."', '".$p_topic."', '".$p_course."', '".$p_group."', '".$profiles['id']."', '".$p_editor."', '".$file1."', '".time()."', '0', '0', '0', '0', '0', '0')";
			
			
			
			$sql_answer_insert_thread = $db->sql_query($sql_answer_insert_thread) or die(mysql_error());
			
			$threadid=mysql_insert_id();
			
			
			$sql_answer_insert = "INSERT INTO tblanswer (answername, class_id, topicid, courseid, groupid, userid, answerdes, attach, time, setting, status, parent, voteup, votedown, count,thread) 
								VALUES('".$p_name."', '".$class."', '".$p_topic."', '".$p_course."', '".$p_group."', '".$profiles['id']."', '".$p_editor."', '".$file1."', '".time()."', '0', '0', '0', '0', '0', '0',$threadid)";
			
			
			
			$sql_answer_insert = $db->sql_query($sql_answer_insert) or die(mysql_error());
			// Thong bao insert thanh cong
			$template -> assign_block_vars('NEWUSER_MSG', array(
				'newuser_msg'	=> '<script>alert(\'Send message successful!\');window.location="./?";</script>')
			);
		} else {
			$template -> assign_block_vars('NEWUSER_MSG', array(
				'newuser_msg'	=> $strMsg
			));
		}
	} else {
		
	// Modify
		if($bOK) {
			if( !isset($p_name) || $p_name=='' || !isset($p_course) || $p_course=='' || !isset($p_group) || $p_group=='' || !isset($p_editor) || $p_editor=='' ) {
				$bOK = false;
				$strMsg = '<span class="error">Please complete form!</span>';
				
			
			} else {
				$bOK = true;
			}
		}
		// Cap nhat vao database
		if($bOK)
		{
			
			if (!empty($file1Name))
			{
				if($file1Type=="image/jpeg"||$file1Type=="image/gif"||$file1Type=="image/png") {
					$result = @upload_files($file1Name, $file1Type, $file1Temp, $dir_upload);
				} //elseif($file1Type=="application/msword"||$file1Type=="text/plain"||$file1Type=="application/vnd.ms-excel"||$file1Type=="application/zip") {
					//$result = @upload_files_doc($file1Name, $file1Type, $file1Temp, $data_upload);
				elseif($file1Type=="application/msword"||$file1Type=="text/plain"||$file1Type=="application/vnd.ms-excel"||$file1Type=="application/zip"||$file1Type=="application/rar"||$file1Type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" ||$file1Type=="application/octet-stream" ||$file1Type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  	

||$file1Type=="application/vnd.ms-powerpoint" ||$file1Type=="application/vnd.openxmlformats-officedocument.presentationml.presentation" ||$file1Type=="application/pdf" ) {
					$result = @upload_files_doc($file1Name, $file1Type, $file1Temp, $data_upload);
				}
				if(!$result)
				{
					$bOK = false;
					$template -> assign_block_vars('NEWUSER_MSG', array(
						'newuser_msg'	=> 'Failed to upload')
					);
				}
				else
					$file1 = $file1Name . $file1Type;
			}
	
			$sql_answer_insert = "UPDATE tblthread SET answername='".$p_name."', topicid='".$p_topic."', courseid='".$p_course."', groupid='".$p_group."', userid='".$profiles['id']."', answerdes='".$p_editor."', attach='".$file1."' WHERE id=(select thread from tblanswer where id=".$id.")";
			$sql_answer_insert = $db->sql_query($sql_answer_insert) or die(mysql_error());
			$sql_answer_insert = "UPDATE tblanswer SET answername='".$p_name."', topicid='".$p_topic."', courseid='".$p_course."', groupid='".$p_group."', userid='".$profiles['id']."', answerdes='".$p_editor."', attach='".$file1."' WHERE id=".$id;
			$sql_answer_insert = $db->sql_query($sql_answer_insert) or die(mysql_error());
			// Thong bao insert thanh cong
			$template -> assign_block_vars('NEWUSER_MSG', array(
				'newuser_msg'	=> "<p><strong>Done!</strong></p><br />
			<script>
			window.parent.location='?act=answers&do=detail&id=".$thread."';
			
		
			</script>",
			));
		}
	}
	// Thong bao loi
	if (!$bOK )
	{
	}
}
$template -> pparse('answers-creat');
?>