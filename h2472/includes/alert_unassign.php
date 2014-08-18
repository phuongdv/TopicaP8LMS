<?
$template -> set_filenames(array(
	'alert_unassign'	=> $dir_template . 'alert_unassign.tpl')
);
/*
echo $id.'<br/>';
echo $thr_id.'<br/>';
echo $profiles['id'].'<br/>';
echo $profiles['code'].'<br/>';
*/
if (isset($_POST['submit']))
{
	
	if($profiles['code']!='hoc_vien')
	{
		$sql_answer_close = "UPDATE tblthread SET assignid=0,status=0 WHERE id=".$thr_id;
		$sql_answer_close = $db->sql_query($sql_answer_close) or die(mysql_error());
		$sql_answer_update = "UPDATE tblanswer SET unassign = '".$profiles['id']."',assignid=0 WHERE id=".$id;
		$sql_answer_update = $db->sql_query($sql_answer_update) or die(mysql_error());
		/*
		$template -> assign_vars(array(
		'newuser_msg'	=>"<script>
	        alert('Câu hỏi chuyển lại cho hệ thống');
			window.parent.location='?act=answers&do=detail&id=$thr_id';
			</script>",
			));
		*/
	echo"<script>
	     
			window.parent.location=window.parent.location.href;
			
			window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close()', 2000);
			</script>";
	}
	
}


$template -> pparse('alert_unassign');
?>