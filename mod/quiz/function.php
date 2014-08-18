<?php
include "conection.php";
function getExam($id){
	$result = mysql_query("SELECT * FROM `tbl_question` where id=$id");
	while($row = mysql_fetch_array($result)){
	  echo $row['content'];
   } 
}
function getNumberQuestion($id){
	$result = mysql_query("SELECT * FROM `tbl_question` where id=$id");
	while($row = mysql_fetch_array($result)){
	  return $row['number_ques'];
   }
}
function getTime($id){
	$result = mysql_query("SELECT * FROM `tbl_question` where id=$id");
	while($row = mysql_fetch_array($result)){
	  return $row['time'];
   }
}
function getCode($id){
	$result = mysql_query("SELECT * FROM `tbl_question` where id=$id");
	while($row = mysql_fetch_array($result)){
	  return $row['code'];
   }
}
function getAllExamByUser($ucode){
	$result = mysql_query("SELECT * FROM `tbl_question`");
	while($row = mysql_fetch_array($result)){
		$id  = $row['id'];
		$code = $row['code'];
	  	echo '<li><a href="trung.php?id='.$id.'&ucode='.$ucode.'">'.$code.'</a></li>';
   }
}
?>