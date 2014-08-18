<?php
require_once("../../config.php");
$idanswer=0;
$mark=0;
if(isset($_GET["idanswer"])){
	$idanswer=$_GET["idanswer"];
	$mark=$_GET["mark"];
}
$sql="UPDATE tbl_user_answer_quiz SET mark='$mark' WHERE id='$idanswer'";
//echo "$sql";
$result=mysql_query($sql);
?>
