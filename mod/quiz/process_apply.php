<?php
require_once("../../config.php");
$qid=0;
if(isset($_GET["qid"])){
	$qid=$_GET["qid"];
}
$sql="SELECT * FROM tbl_quiz_html WHERE quizid='$qid'";
//echo "$sql";
$result=mysql_query($sql);
if(@mysql_num_rows($result)>0){
	$rows=mysql_fetch_array($result);
	echo $rows["answers"];
}else{
	echo "0";
}

?>
