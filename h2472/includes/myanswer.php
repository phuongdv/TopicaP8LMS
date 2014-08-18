<?php
$template -> set_filenames(array(
	'myanswer'	=> $dir_template . 'myanswer.tpl')
);

$template -> assign_vars(array(
	'user'	=>	$pro_author
));

if($profiles['code']=="HV") {
	$sql_answer_count = "SELECT * FROM tblanswer WHERE userid = ".$profiles['id'];
	$sql_answer_count = $db->sql_query($sql_answer_count) or die(mysql_error());
	$sql_answer_count = $db->sql_numrows($sql_answer_count);

	$sql_answer_finish = "SELECT * FROM tblanswer WHERE status = 1 AND userid = ".$profiles['id'];
	$sql_answer_finish = $db->sql_query($sql_answer_finish) or die(mysql_error());
	$sql_answer_finish = $db->sql_numrows($sql_answer_finish);

	$template -> assign_vars(array(
		'totalanswer'				=>	$sql_answer_count,
		'finishanswer'				=>	$sql_answer_finish,
		'delayanswer'				=>	$sql_answer_count - $sql_answer_finish,
	));
}


if($profiles['code']=="HV")
	$sql_answer_count = "SELECT COUNT(*) FROM tblanswer WHERE userid = " . $profiles['id'];
elseif($profiles['code']=="GVCM"||$profiles['code']=="GVHD"||$profiles['code']=="CVHT"||$profiles['code']=="KT")
	$sql_answer_count = "SELECT COUNT(*) FROM tblanswer WHERE assignid = " . $profiles['id'];
else
	$sql_answer_count = "SELECT COUNT(*) FROM tblanswer";

$sql_answer_count = $db->sql_query($sql_answer_count) or die(mysql_error());
$r_count = $db->sql_fetchfield(0);
if($r_count != 0) {

	$page = 1;
	$final = '';
	$show_page = '';
	$p = !empty($_GET['p']) ? (int)$_GET['p'] : 0;
	$p = (!is_numeric($p) || ($p > $r_count ) || ($p < 0 )) ? 0 : $p;
	$nPageSize = 20;

	if($profiles['code']=="HV")
		$sql_answer = "SELECT ans.*, us.username as username FROM tblanswer as ans, mdl_user as us WHERE ans.userid = " . $profiles['id']." AND ans.userid = us.id ORDER BY ans.id DESC LIMIT " . $p . ", " . $nPageSize . "";
	elseif($profiles['code']=="GVCM"||$profiles['code']=="GVHD"||$profiles['code']=="CVHT"||$profiles['code']=="KT")
		$sql_answer = "SELECT ans.*, us.username as username FROM tblanswer as ans, mdl_user as us WHERE ans.assignid = " . $profiles['id']." AND ans.userid = us.id ORDER BY ans.id DESC LIMIT " . $p . ", " . $nPageSize . "";
	else
		$sql_answer = "SELECT ans.*, us.username as username FROM tblanswer as ans, mdl_user as us WHERE ans.userid = us.id ORDER BY ans.id DESC LIMIT " . $p . ", " . $nPageSize . "";

	$sql_answer = $db->sql_query($sql_answer) or die(mysql_error());
	while ( $answer_rows = $db->sql_fetchrow($sql_answer)) {
		$final[] = $answer_rows;
	}
	if($r_count !=0 ) {
		for ($i = 0; $i < count($final); $i++) {
			if($final[$i]['id'] != '') {
				$template -> assign_block_vars('L_ANWSER', array(
					'tr_class'	=> ($i % 2 == 0) ? 'bg_color1' : 'bg_color2',
					'stt'		=> ($i+1),
					'id'		=> $final[$i]['id'],
					'rate'		=> get_answer_rate($final[$i]['id'],$final[$i]['userid']),
					'name'		=> $final[$i]['answername'],
					'author'	=> $final[$i]['username'],
					'time'		=> date('d/m/Y',$final[$i]['time']),
					'delay'		=> return_answer_delay($final[$i]['id'],$final[$i]['userid'],$final[$i]['time']),
					'status'	=> check_answer_status($final[$i]['id'])
				));
			}
		}

		$num_page = generate_pagination('?', $r_count, $nPageSize, $p);
		$template -> assign_vars(array(
			'linkpage'				=>	'<div class="pagination">'.$num_page.'</div>',
		));

	}
}

$template -> pparse('myanswer');
?>
