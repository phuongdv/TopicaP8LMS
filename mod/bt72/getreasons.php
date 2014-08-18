<?php
	require_once("../../config.php");
    require_once("libs_trung.php");
    
    $question = $_POST['question'];
    $flag     = $_POST['flag'];
    $sql       = "select correctfeedback,incorrectfeedback from mdl_question_multichoice where question =$question"; 
    $result=mysql_query($sql);
 
    while ($rows=mysql_fetch_assoc($result)) {
    	  if($flag==1)
    	  echo $rows['correctfeedback'];
    	  else if($flag==0)
    	  echo $rows['incorrectfeedback'];
    	  }
     	  
    ?>