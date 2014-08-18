<?php
require_once("../../config.php");
require_once("libs_trung.php");

	if(isset($_GET["qid"])){
		$qid=$_GET["qid"];
	}
// xem tat ca cac de cua quiz nay
$sql = "select * from vietth_q169_de where quizid = $qid";
$result=mysql_query($sql);
while($arr_de=mysql_fetch_assoc($result)){
	// update process
	//print_r($arr_de);
	
	 echo '<div align="center"><h3>Update đáp án đề  '.$arr_de['id'].'</h3></div><br><br>';
	$questids=$arr_de["quest_ids"];
	$de_id   =$arr_de["id"];
	$questids_array=explode(",",$questids);
	$file_quiz = $arr_de['url_file'];
	//print_r($questids_array);
	
	// 1.sua dap an
	$stranswer=''; // dap an moi
	for($i=0;$i<count($questids_array);$i++)
		{
			if($questids_array[$i]!='')
			{
			
			$sql_answer="SELECT * FROM mdl_question_answers WHERE mdl_question_answers.question=".$questids_array[$i];
                          			$result_answer=mysql_query($sql_answer);
									while($rows_answer=mysql_fetch_array($result_answer)){
										if($rows_answer["fraction"]==1){
											$stranswer.=$rows_answer["id"].",";
										}
									}
			
			}
		}
	echo 'Đáp án cũ:'.$arr_de['answers'].'<br>';
	echo 'Đáp án mới:'.$stranswer.'<br>';
	$sql_save = "Update  vietth_q169_de set answers = '$stranswer'  WHERE id =".$arr_de['id'];   
    mysql_query($sql_save);
    echo  '<div align="center"><h4>Status: Updated </h3></div><br><br>';  
	// end sua dap an
	
	
	
	
	// update noi dung cau hoi
	echo '<div align="center"><h3>Update nội dung câu hỏi đề̀  '.$arr_de['id'].'</h3></div><br><br>';
   // wwwcopy("/vietth/bt72/update_file_html.php?id=$de_id",$file_quiz);
	wwwcopy("http://elearning.tvu.topica.vn/mod/bt72/update_file_html.php?id=$de_id",$file_quiz);
			// end update content

	
	    echo  '<div align="center"><h4>Status: Updated file'.$file_quiz.' </h3></div><br><br>';  
	// end update noi dung cau hoi

}
?>