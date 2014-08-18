<?php
	//session_start();
	require_once("../../config.php");
	require_once("class.aesctr.php");
	$code="";
	$diem=0;
	if(isset($_POST['txt_code'])==true){
		$code=$_POST['txt_code'];
	}
	$arr_code=explode("*",$code);
	$id=0;
	$user="";
	if(isset($arr_code[1]))
		$id=$arr_code[1];
	$Plaintext="";
	if(isset($arr_code[2]))
		$Plaintext=$arr_code[2];
	if(isset($arr_code[0]))
		$user=$arr_code[0];
	$sql="SELECT tbl_quiz_html.answers,tbl_user_answer_quiz.key,tbl_user_answer_quiz.user_id,tbl_user_answer_quiz.quiz_id FROM tbl_user_answer_quiz 
INNER JOIN tbl_quiz_html ON tbl_quiz_html.id=tbl_user_answer_quiz.static_id WHERE tbl_quiz_html.id='$id'";
	//echo $sql;
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	$key=$rows["key"];
	$uid=$rows["user_id"];
	$obj_AesCtr=new AesCtr();
	$Plaintext=$obj_AesCtr->decrypt($Plaintext,$key,256);
	$true_answer=explode(",",$rows["answers"]);
	$user_answer=explode(",",$Plaintext);
	$mark=0;
	$count=count($true_answer)-1;
	for($i=0;$i<$count;$i++){
		if($true_answer[$i]==$user_answer[$i]){
			$mark++;
		}
	}
?>
<fieldset><legend>Hệ thống chấm điểm offline</legend>
<div id="title">
	<h1>Chẩm Điểm Off-Line</h1>
	<h3>Mã Sinh viên : <span id="ucode"><?php echo $user;?></span></h3>
	<strong>Kết quả:<?php echo $mark."/".$count;?></strong><br/>
<?php
	$mark=($mark*10/$count);
	// update mark
	$sql_update="UPDATE tbl_user_answer_quiz SET mark='$mark' WHERE id='$id'";
	mysql_query($sql_update);
?>
<strong>Điểm:<?php echo round($mark,2);?></strong>
</div>
</fieldset>
