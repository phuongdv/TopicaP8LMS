<?php
$template -> set_filenames(array(
	'meg'	=> $dir_template . 'meg.tpl')
);

if($id==1)
	$meg = "Create question successful!";

$template -> assign_vars(array(
	'meg'	=> $meg
));

$template -> pparse('meg');
?>
