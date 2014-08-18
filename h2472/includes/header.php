<?php
$template -> set_filenames(array(
	'header'	=> $dir_template . 'header.tpl')
);

$template -> assign_block_vars('USER', array(
	'picture'		=>	($pro_puctrue!=0) ? '<p><img src="./avatars/'.$pro_puctrue.'" width="100" height="100" alt="" class="avatar" /></p>' : '<p><img src="./assets/images/nopic.gif" alt="" class="avatar" /></p>',
	'author'		=>	$pro_author,
	'group'			=>	$pro_group
));
$template -> assign_block_vars('LINK', array(
	'linkportal'	=>	$linkportal,
));

if($profiles['code']=="PO") {
	$template -> assign_block_vars('MOD', array());
}

$sql_topic = "SELECT * FROM tbltopic where status=1";
$sql_topic = $db->sql_query($sql_topic) or die(mysql_error());
while($topic_rows = $db->sql_fetchrow($sql_topic)) {
	$template -> assign_block_vars('TOPIC', array(
		'id'		=>	$topic_rows['id'],
		'name'		=>	$topic_rows['topicname'],
	));
}


$template -> pparse('header');
?>
