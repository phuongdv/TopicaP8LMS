<?php

require_once("config.php");
set_time_limit(0); 
$start_date = intval($_GET["start"]);
$end_date = intval($_GET["end"]);
$con = mysql_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$str = "select uniqueid from mdl_quiz_attempts where timemodified < ".$end_date." and timemodified > ".$start_date;

mysql_select_db($CFG->dbname , $con);
$result = mysql_query($str);
$t=0;
$se = 0;
$sta =0;
while($row = mysql_fetch_array($result))
  {
  $attemp = $row['uniqueid'];
  
  //Insert Section
  $sql_tbl_sessions = "select * from mdl_question_sessions_2 where attemptid= ".$attemp;
  $result_tbl_sessions = mysql_query($sql_tbl_sessions);
  while($row_sessions = mysql_fetch_array($result_tbl_sessions))
  {
	  	$sql_insert_sessions="INSERT INTO mdl_question_sessions (id, attemptid, questionid, newest, newgraded, sumpenalty, manualcomment)
VALUES (".$row_sessions['id'].", ".$row_sessions['attemptid'].", ".$row_sessions['questionid'].", ".$row_sessions['newest'].", ".$row_sessions['newgraded'].", ".$row_sessions['sumpenalty'].", '".$row_sessions['manualcomment']."') ";
		
		mysql_query($sql_insert_sessions);
		//printf("Records insert sessions: %d\n <br>", mysql_affected_rows());
		$se = $se + mysql_affected_rows();
		
  		
  }
  
  //Insert States
  $sql_tbl_states = "select * from mdl_question_states_2 where attempt= ".$attemp;
  $result_tbl_states = mysql_query($sql_tbl_states);
  while($row_states  = mysql_fetch_array($result_tbl_states))
  {
	  	$sql_insert_states ="INSERT INTO mdl_question_states (id, attempt, question, originalquestion, seq_number, answer, timestamp, event, grade, raw_grade, penalty)
VALUES (".$row_states['id'].", ".$row_states['attempt'].", ".$row_states['question'].", ".$row_states['originalquestion'].", ".$row_states['seq_number'].", '".$row_states['answer']."', ".$row_states['timestamp'].", ".$row_states['event'].", ".$row_states['grade'].", ".$row_states['raw_grade'].", ".$row_states['penalty']." ) ";
		
		mysql_query($sql_insert_states);
		//printf("Records insert states: %d\n <br>", mysql_affected_rows());
		$sta = $sta + mysql_affected_rows();
		
  		
  }
  
  //Insert attempts
  	/*$sql_tbl_attempts="INSERT INTO mdl_quiz_attempts (id, uniqueid, quiz, userid, attempt, sumgrades, timestart, timefinish, timemodified, layout, preview, )
VALUES (".$row_states['id'].", ".$row_states['uniqueid'].", ".$row_states['quiz'].", ".$row_states['userid'].", ".$row_states['attempt'].", ".$row_states['sumgrades'].", ".$row_states['timestart'].", ".$row_states['timefinish'].", ".$row_states['timemodified'].", '".$row_states['layout']."', ".$row_states['preview'].")";
	mysql_query ($sql_tbl_attempts);
	$t++;*/
  

  }

/*echo '<br>total attem = '.$t;*/
echo '<br>total state = '.$sta;
echo '<br>total sess = '.$se;

mysql_close($con);
?> 