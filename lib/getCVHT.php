<?php
//create by vietth
class cvth
{
function getCVHT($c_id)
	{
	 $link = mysql_connect('localhost', 'crc', 'crc145');
		if (!$link) {
    die('Could not connect: ' . mysql_error());
					} 
	 $db_selected = mysql_select_db('crc_data2', $link);
		if (!$db_selected) {
    	die ('Can\'t use crc_data2 : ' . mysql_error());
							}
	 
	
	$sql="SELECT  u.*
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE r.id =3
AND
c.id=$c_id

order by firstname asc  limit 0,500";
   echo"C&#225;c c&#7889; v&#7845;n h&#7885;c t&#7853;p:";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)) {
    echo"<a href=\"mailto:$row[email]\">$row[lastname] $row[firstname]</a>";  
    echo",";
          }
	}
	
	
}
?>
