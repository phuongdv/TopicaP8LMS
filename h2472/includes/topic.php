<?php
$template -> set_filenames(array(
	'topic'	=> $dir_template . 'topic.tpl')
);

if($profiles['code']=='HV') {
	$template -> assign_vars(array(
		'disabled'		=> ' disabled="disabled"',
	));
}

if(isset($del) && $del!= 0)
{
	$sql_topic_delete = "DELETE FROM tbltopic WHERE id = '" . (int)$del . "'";
	$db->sql_query($sql_topic_delete) or die(mysql_error());
}

$template -> assign_vars(array(
	'featuredtitle'		=> ($profiles['code']!='HV') ? '<th>Function</th>' : '',
));


$sql_topic = "SELECT * FROM tbltopic ORDER BY id DESC ";
$sql_topic = $db->sql_query($sql_topic) or die(mysql_error());
while ($topic_rows = $db->sql_fetchrow($sql_topic))
{
	$arr_topic[] = $topic_rows;
}

if ( count($arr_topic) > 0 )
{
	for ($i=0; $i < count($arr_topic); $i++)
	{
		$template -> assign_block_vars('TOPIC', array(
			'id'		=> $arr_topic[$i]['id'],
			'name'		=> $arr_topic[$i]['topicname'],
			'status'	=> ($arr_topic[$i]['status'] == 1) ? '<img src="assets/images/publish.png" border="0" />' : '<img src="assets/images/unpublish.png" border="0" />',
			'featured'	=> ($profiles['code']!='HV') ? '<td><a href="./?act=topic&do=modify&id='.$arr_topic[$i]['id'].'">Sửa</a> | <a href="./?act=topic&del='.$arr_topic[$i]['id'].'">Xóa</a></td>' : ''
		));
	}
}

$template -> pparse('topic');
?>
