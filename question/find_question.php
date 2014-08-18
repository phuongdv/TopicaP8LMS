<?php
// create by vietth
$c_id=$_REQUEST['course'];
$ok=$_REQUEST['ok'];








require_once("../config.php");global $CFG;require_once($CFG->libdir.'/phpmailer51/class.phpmailer.php');
require_login();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");

?>
Course id : 
<form id="form1" name="form1" method="post" action="">
  <p>
    <label>
      <input type="text" name="course" id="course" />
    </label>
  </p>
  <p>
    <label>
      <input type="submit" name="ok" id="ok" value="  OK   " />
    </label>
  </p>
</form>
<?php
if($ok!='')
{
$current=time();
$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
$dbname = $CFG->dbname;
    mysql_select_db($dbname);
	mysql_query("SET NAMES 'utf8'");
	$query_string = "
   SELECT q.id q_id,q.name ten,q.questiontext noi_dung ,qa.answer tra_loi,qm.correctfeedback giai_thich 
FROM mdl_question q
inner join mdl_question_categories qc on qc.id = q.category
inner join mdl_context c on c.id = qc.contextid
inner join mdl_course cr on cr.id = c.instanceid
INNER join mdl_question_answers qa on qa.question=q.id 
INNER join mdl_question_multichoice qm on qm.question = q.id
where cr.id= ".$c_id." 
and c.contextlevel=50
and q.parent=0
GROUP BY q.`name`
ORDER BY q.name
	 ";
	
	$data = mysql_query($query_string);
	$t=1;
	?>
	<table width="865" border="1">
  <tr>
    <td width="65"><div align="center">Stt</div></td>
    <td width="103"><div align="center">Tên câu hỏi</div></td>
    <td width="307"><div align="center">Nội dung câu hỏi</div></td>
    <td width="362"><div align="center">Đáp án đúng</div></td>
  </tr>
	
	<?php
	
    
    while($info = mysql_fetch_array( $data )) 
     { 
	   echo '<tr><td style="padding:5px" >'.$t.'</td>';
	   echo '<td style="padding:5px">'.$info['ten'].'</td>';
	   echo '<td  style="padding:5px" >'.$info['noi_dung'].'</td>';
	   echo '<td style="padding:5px" >';
	     
		   $sql_getanswer="select answer,fraction from mdl_question_answers where question='".$info['q_id']."'";
		    $answer_data = mysql_query($sql_getanswer);
          		while($answer_info = mysql_fetch_array( $answer_data )) 
				{
				if($answer_info['fraction']==1)
				 {
				 echo '<strong>'.$answer_info['answer'].'</strong><br>';
				 }
				else
				 {
				 echo $answer_info['answer'].'<br>';
				 }
				}				
	   
	   
	   
       echo 	'<br><strong>Giải thích :</strong> <br><i>'.$info['giai_thich'].'<i></td></tr>';;	
    $t=$t+1;
 } 
?>
</table>
<?php

}
else
{
echo " Vui lòng nhập course id";
}
print_footer($site); 
?>