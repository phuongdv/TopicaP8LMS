<?php
$template -> set_filenames(array(
	'answers'	=> $dir_template . 'answers.tpl')
);

$template -> assign_vars(array(
	'user'	=>	$pro_author
));

$sql_answer = "SELECT ans.*, us.username as username FROM tblanswer as ans, mdl_user as us WHERE ans.userid = us.id ORDER BY ans.id DESC";
$sql_answer = $db->sql_query($sql_answer) or die(mysql_error());
while ($answer_rows = $db->sql_fetchrow($sql_answer))
{
	$template -> assign_block_vars('L_ANWSER', array(
		'id'		=> $answer_rows['id'],
		'name'		=> $answer_rows['answername'],
		'author'	=> $answer_rows['username'],
		'time'		=> date('d/m/Y',$answer_rows['time']),
		'delay'		=> get_date_post($answer_rows['time']),
		'answer'	=> get_latest_answers($answer_rows['id'],$answer_rows['userid']),
		'status'	=> check_answer_status($answer_rows['id'])
	));
}

$template -> pparse('answers');
?>
