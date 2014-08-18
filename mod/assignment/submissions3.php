<?php
$con = mysql_connect("192.168.79.2","c5tvuel","viet123");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("c5tvuel", $con);
mysql_query("SET NAMES 'utf8'");
/*
$result = mysql_query("select mdl_user.username AS TenDangNhap, mdl_user.lastname AS Ho, mdl_user.firstname AS Ten,mdl_user.topica_lop AS LopQuanLy,mdl_assignment_submissions.grade AS Diem
from mdl_assignment_submissions,
     mdl_assignment,
     mdl_grade_items,
     mdl_user,
     mdl_course_modules
where
     mdl_assignment.id=mdl_assignment_submissions.assignment     AND
     mdl_assignment.id=mdl_grade_items.iteminstance     AND
     mdl_user.id=mdl_assignment_submissions.userid     AND 
     mdl_course_modules.instance=mdl_grade_items.iteminstance and
     mdl_course_modules.id = $id	 AND 
	 mdl_assignment_submissions.grade != '-1'
group by TenDangNhap
ORDER BY topica_lop
");
*/

# new sql

$result = mysql_query("select mu.username AS TenDangNhap, mu.lastname AS Ho, mu.firstname AS Ten,mu.topica_lop AS LopQuanLy,mgg.finalgrade AS Diem
from 
     mdl_grade_grades mgg,
     mdl_grade_items mgi,
     mdl_course_modules mcm,
     mdl_user  mu
     
where
     mgg.itemid=mgi.id AND
     mgi.iteminstance=mcm.instance
     and
     mcm.id = $id	 
     and mgi.itemmodule='assignment'
     and mu.id = mgg.userid
	 and mgg.finalgrade is not null
ORDER BY mu.topica_lop
");



echo '<div style="height: 20px;";></div>
<div align="center">
<table border="1" cellspacing="2" cellpadding="2" width="600px">
<tr>
<th width="150px"><font face="Arial, Helvetica, sans-serif">H&#7885; v&#224; t&#234;n</font></th>
<th width="250px"><font face="Arial, Helvetica, sans-serif">H&#7885; v&#224; t&#234;n</font></th>
<th width="150px"><font face="Arial, Helvetica, sans-serif">L&#7899;p qu&#7843;n l&#253;</font></th>
<th width="50px"><font face="Arial, Helvetica, sans-serif">&#272;i&#7875;m</font></th>
</tr>';

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['TenDangNhap'] . "</td>";
  echo "<td>" . $row['Ho'] . " " . $row['Ten'] . "</td>";
  echo "<td>" . $row['LopQuanLy'] . "</td>";
  echo "<td>" .round( $row['Diem']) . "</td>";
  echo "</tr>";
  }

echo "</table>";

mysql_close($con);
?> 