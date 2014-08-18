<?php
$template -> set_filenames(array(
	'topic-modify'	=> $dir_template . 'topic-modify.tpl')
);

if($profiles['code']=='HV') {
	$template -> assign_block_vars('NEWUSER_MSG', array(
		'newuser_msg'	=> '<script>window.location="./?act=topic";</script>'
	));
}

$bEdited = false;
$p_submit = '';
if(isset($_POST['submit']))
	$p_submit = $_POST['submit'];

if ( !empty($id) && is_numeric($id)) {
	$bEdited = true;
	$sql_topic_edit = "SELECT * FROM tbltopic WHERE id = '" . $id . "'";
	$sql_topic_edit = $db->sql_query($sql_topic_edit) or die(mysql_error());
	if ( mysql_num_rows($sql_topic_edit) == 1) {
		while ( $topic_rows = $db->sql_fetchrow($sql_topic_edit))
		{
			$template -> assign_vars(array(
				'topicname'			=> $topic_rows['topicname'],
				'statuson'			=> ($topic_rows['status'] == 1) ? ' selected' : '',
				'statusoff'			=> ($topic_rows['status'] == 0) ? ' selected' : '')
			);
		}
	} else {
		$bEdited = false;
	}
} else {
}

$bOK = true;
if($p_submit == 'Chấp nhận') {
	$p_topicname 	= $_POST['topicname'];
	$p_status 		= (int)$_POST['status'];

	// Adding
	if (!$bEdited ) {
		if(!isset($p_topicname) || $p_topicname=='') {
			$bOK = false;
			$strMsg = '<span class="error">Please complete information!</span>';
		} else {
			$bOK = true;
		}
		// Cap nhat vao database
		if ($bOK)
		{
			$sql_user_insert = "INSERT INTO tbltopic (topicname, status) 
								VALUES('" . $p_topicname . "', '" .$p_status. "')";
			$sql_user_insert = $db->sql_query($sql_user_insert) or die(mysql_error());

			// Thong bao insert thanh cong
			$template -> assign_block_vars('NEWUSER_MSG', array(
				'newuser_msg'	=> '<span class="complete">Add new topic successful.</span>')
			);
		}
	}
	// Modify
	else {

		if(!isset($p_topicname) || $p_topicname=='') {
			$bOK = false;
			$strMsg = '<span class="error">Please complete information!</span>';
		} else {
			$bOK = true;
		}
		// Cap nhat vao database
		if ($bOK)
		{
			$sql_user_update = "UPDATE tbltopic SET topicname = '" . $p_topicname . "', status = '" .$p_status. "' 
								WHERE id = '" . $id . "'";
			$sql_user_update = $db->sql_query($sql_user_update) or die(mysql_error());

			// Thong bao insert thanh cong
			$template -> assign_block_vars('NEWUSER_MSG', array(
				'newuser_msg'	=> '<span class="complete">Update topic successful.</span>')
			);
			// Hien thi cac gia tri vua duoc nhap
			$template -> assign_vars(array(
				'topicname'			=> $p_topicname,
				'statuson'			=> ($p_status == 1) ? ' selected' : '',
				'statusoff'			=> ($p_status == 0) ? ' selected' : '')
			);
		}

		// Thong bao loi
		if ( !$bOK )
		{
			$template -> assign_block_vars('NEWUSER_MSG', array(
				'newuser_msg'	=> $strMsg)
			);

			$template -> assign_vars(array(
					'topicname'			=> $p_topicname,
					'statuson'			=> ($p_status == 1) ? ' selected' : '',
					'statusoff'			=> ($p_status == 0) ? ' selected' : '')
			);		
		}

	}
}

$template -> pparse('topic-modify');
?>
