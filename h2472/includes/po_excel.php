<?php
// get data
$sql=$_GET['sql'];
$sql=str_replace('\\','',$sql);
header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
    header("Content-Disposition: attachment;filename=H2472_REPORT.xls"); 
$template -> set_filenames(array(
'po_excel'	=> $dir_template . 'po_excell.tpl')
);
$result_answer = $db->sql_query($sql) or die(mysql_error());
   while ( $answer_rows = $db->sql_fetchrow($sql_answer)) 
   {
   	$answers[]=$answer_rows;
   }
for($i=0;$i<count($answers);$i++)
   {
   $q_id=get_lastq($answers[$i]['id']);	  
$template -> assign_block_vars('L_ANWSER', array(
'tr_class'	=> ($i % 2 == 0) ? 'bg_color1' : 'bg_color2',
'stt'		=> $i,
'id'		=> $answers[$i]['id'],
'q_id'		=> $q_id,
'name'		=> $answers[$i]['answername'],
'author'	=> get_username_from_id($answers[$i]['userid']),
'forward'	=> (check_have_reply($answers[$i]['id'])) ? 'display:none' : '',
'rate'		=> count_q_on_thread($answers[$i]['id']),
'time'		=> date('d/m/y H:i',$answers[$i]['time']),
'delay'		=> ($answers[$i]['status'] != 1)? get_delay($q_id,$answers[$i]['time']):get_delay_close($q_id,$answers[$i]['time'],$answers[$i]['id']),
'answer'	=> get_name_from_id($answers[$i]['assignid']).'<br>'.get_role($subject,$answers[$i]['assignid']),
'status'	=> return_status_excel($answers[$i]['status']),
'userid'    => '',
'cname'     => get_cname($answers[$i]['courseid']),));

   }
	$template -> pparse('po_excel');

?>

