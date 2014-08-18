<?php
$con = mysql_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db($CFG->dbname , $con);
mysql_query("SET NAMES 'utf8'");
$result = mysql_query("SELECT 
mdl_quiz.name AS TenBai,
			(
      SELECT COUNT(mdl_quiz_attempts.attempt) 
      FROM mdl_quiz_attempts 
      WHERE mdl_quiz_attempts.quiz = mdl_quiz.id
      AND
      mdl_quiz_attempts.userid in 
					(
					SELECT  u.id 
					FROM mdl_user u
					INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
					INNER JOIN mdl_context ct ON ct.id = ra.contextid
					INNER JOIN mdl_course c ON c.id = ct.instanceid
					INNER JOIN mdl_role r ON r.id = ra.roleid
					INNER JOIN mdl_course_categories cc ON cc.id = c.category
					WHERE 
					r.id=5
					and c.id = $id
					)
      ) 
as SoLuotLamBai, 
     (
      select COUNT(DISTINCT(mdl_quiz_attempts.userid)) 
      FROM mdl_quiz_attempts 
      WHERE mdl_quiz_attempts.quiz = mdl_quiz.id
       AND
      mdl_quiz_attempts.userid in 
					(
					SELECT  u.id 
					FROM mdl_user u
					INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
					INNER JOIN mdl_context ct ON ct.id = ra.contextid
					INNER JOIN mdl_course c ON c.id = ct.instanceid
					INNER JOIN mdl_role r ON r.id = ra.roleid
					INNER JOIN mdl_course_categories cc ON cc.id = c.category
					WHERE 
					r.id=5
					and c.id = $id
					)
      ) 
as SoHocVienLamBai, 
(
      select COUNT(DISTINCT(mdl_quiz_attempts.userid)) 
      FROM mdl_quiz_attempts 
      WHERE mdl_quiz_attempts.quiz = mdl_quiz.id
       AND
      mdl_quiz_attempts.userid in 
					(
					SELECT  u.id 
					FROM mdl_user u
					INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
					INNER JOIN mdl_context ct ON ct.id = ra.contextid
					INNER JOIN mdl_course c ON c.id = ct.instanceid
					INNER JOIN mdl_role r ON r.id = ra.roleid
					INNER JOIN mdl_course_categories cc ON cc.id = c.category
					WHERE 
					r.id=5
					and c.id = $id
					)
      ) /
      (SELECT COUNT(DISTINCT u.username)

FROM mdl_user u

INNER JOIN mdl_role_assignments ra ON ra.userid = u.id

INNER JOIN mdl_context ct ON ct.id = ra.contextid

INNER JOIN mdl_course c ON c.id = ct.instanceid

INNER JOIN mdl_role r ON r.id = ra.roleid

INNER JOIN mdl_course_categories cc ON cc.id = c.category

 

WHERE

c.id=$id

and 

r.id=5)*100
as TyLe

FROM mdl_quiz
WHERE mdl_quiz.course = $id
");

echo '<div style="height: 20px;";></div>
<div align="center">
<table border="1" cellspacing="2" cellpadding="2" width="800px">
<tr>
<th width="350px><font face="Arial, Helvetica, sans-serif">T&#234;n b&#224;i</font></th>
<th width="200px><font face="Arial, Helvetica, sans-serif">S&#7889; l&#432;&#7907;t l&#224;m b&#224;i</font></th>
<th width="200px><font face="Arial, Helvetica, sans-serif">S&#7889; H&#7885;c vi&#234;n l&#224;m b&#224;i</font></th>
<th width="50px><font face="Arial, Helvetica, sans-serif">T&#7927; l&#7879;</font></th>
</tr>';

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['TenBai'] . "</td>";
  echo "<td>" . $row['SoLuotLamBai'] . "</td>";
  echo "<td>" . $row['SoHocVienLamBai'] . "</td>";
  echo "<td>" . $row['TyLe'] . "%</td>";
  echo "</tr>";
  }

echo "</table>";

mysql_close($con);
?> 