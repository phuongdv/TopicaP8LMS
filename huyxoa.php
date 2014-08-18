<?php
require_once("config.php");
set_time_limit(0); 
$timeb = intval($_GET["th"]);
$con = mysql_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$str = "select uniqueid from mdl_quiz_attempts where timemodified < ".$timeb;

mysql_select_db($CFG->dbname , $con);
$result = mysql_query($str);
$t=0;
$se = 0;
$sta =0;
while($row = mysql_fetch_array($result))
  {
  $attemp = $row['uniqueid'];
 
  $del_stat = "delete from mdl_question_states where attempt = ".$attemp;

  mysql_query ($del_stat);
printf("Records deleted state: %d\n <br>", mysql_affected_rows());
$sta = $sta + mysql_affected_rows();
 
$se = $se + mysql_affected_rows();

$t++;
  }

echo '<br>total attem = '.$t;
echo '<br>total state = '.$sta;
echo '<br>total sess = '.$se;

mysql_close($con);
?> 