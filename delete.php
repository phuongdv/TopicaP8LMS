<?php
$con = mysql_connect("localhost","lms-vietth","c03cu@s01cu@di");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("c2test", $con);

mysql_query("DELETE FROM mdl_question_states WHERE timestamp < 1296518400");

mysql_close($con);

echo 'Have done!!!';
?> 