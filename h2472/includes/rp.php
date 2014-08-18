<?php
include('header.php');
$template -> set_filenames(array(
	'rp'	=> $dir_template . 'rp.tpl')
);

$template -> assign_vars(array(
	'user'	=>	$pro_author
));

$p_submit = '';
if(isset($_POST['submit']))
	$p_submit = $_POST['submit'];
$per = true;

if($mess=='1')
	$msg = '<div class="mess">Failed to upload!</div>';
elseif($mess=='2')
	$msg = '<div class="mess">Please complete form!</div>';

$template -> assign_vars(array(
	'newuser_msg'	=>	$msg
));

$sql_reply = "SELECT * FROM tblreply WHERE id = '".$id."' LIMIT 1";
$sql_reply = $db->sql_query($sql_reply) or die(mysql_error());
while ( $repley_rows = $db->sql_fetchrow($sql_reply)) {
	if($repley_rows['userid']==$profiles['id']) {

		$template -> assign_vars(array(
			'content'	=>	$repley_rows['replydes']
		));

		if($profiles['code']=='HV' && ($repley_rows['userid'] != $profiles['id']))
			$per = false;

		$bOK = true;
		if($p_submit == 'Chấp nhận' && $per) {

			$file1Name 		= $_FILES['attach']['name'];
			$file1Type 		= $_FILES['attach']['type'];
			$file1Temp 		= $_FILES['attach']['tmp_name'];

			$p_editor 		= $_POST['editor_kama'];

			if($bOK) {
				if( !isset($p_editor) || $p_editor=='' ) {
					$bOK = false;
					echo '<script>window.location="./?act=rp&id='.$id.'&mess=2";</script>';
				} else {
					$bOK = true;
				}
				if($bOK)
				{
					if (!empty($file1Name))
					{
						if($file1Type=="image/jpeg"||$file1Type=="image/gif"||$file1Type=="image/png") {
							$result = @upload_files($file1Name, $file1Type, $file1Temp, $dir_upload);
						} elseif($file1Type=="application/msword"||$file1Type=="text/plain"||$file1Type=="application/vnd.ms-excel"||$file1Type=="application/zip") {
							$result = @upload_files_doc($file1Name, $file1Type, $file1Temp, $data_upload);
						}
						if(!$result)
						{
							$bOK = false;
							echo '<script>window.location="./?act=rp&id='.$id.'&mess=1";</script>';
						}
						else
							$file1 = $file1Name . $file1Type;
					}
					$sql_reply_update = "UPDATE tblreply SET replydes = '".$p_editor."', attach = '".$file1."' 
										WHERE id = '".$id."'";
					$sql_reply_update = $db->sql_query($sql_reply_update) or die(mysql_error());
					// Thong bao insert thanh cong
					echo '<script>window.location="?act=answers&do=detail&id='.$thr_id.'";</script>';
				}
			}
		}


	} else {
		echo '<script>window.location="./?";</script>';
	}
}

/***********************************REPLY***********************************************/

$template -> pparse('rp');
?>
