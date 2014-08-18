<?php
	$questid=0;
	$flag="1";
	if(isset($_GET["questid"])){
		$questid=$_GET["questid"];
		$flag=$_GET["flag"];
	}
	require_once("../../config.php");
	$sql="SELECT * FROM mdl_question_multichoice WHERE question='$questid'";
	//echo $sql;
	$result=mysql_query($sql);
	if(mysql_num_rows($result)>0){
		$rows=mysql_fetch_array($result);
		if($flag==1){
			echo $rows["correctfeedback"];
		}
		else{
			echo $rows["incorrectfeedback"];
		}
	}else{
		echo "";
	}
	
	

?>