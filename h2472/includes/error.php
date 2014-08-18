<?php
$template -> set_filenames(array(
	'error'	=> $dir_template . 'error.tpl')
);
$template->assign_vars(array(
		'bug'   => $profiles['code'],
		));
$template -> pparse('error');
?>

