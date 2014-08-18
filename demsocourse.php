<?php
// create by vietth 17-01-2011 dung de add so course cua 1 ca nhan

$link = mysql_connect('localhost', 'crc', 'crc145');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//echo 'Connected successfully';
mysql_select_db('crc_data2', $link);
$sql="";
$result = mysql_query("SELECT u.* FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE r.id ='5'");

		
		while($row = mysql_fetch_array($result)){
			echo $row['id'].' '.$row['username'].' ';
			$u_id=$row['id'];
			$coursecount_sql  = "
			SELECT count(DISTINCT c.id) count FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE u.id=".$u_id."";
			$count = mysql_query($coursecount_sql);
			$ccount = mysql_fetch_array($count);
			$socourse=$ccount['count'];
            $update="update mdl_user set coursecount ='".$socourse."' where id='".$u_id."'";
			mysql_query($update);
			
		}




?>