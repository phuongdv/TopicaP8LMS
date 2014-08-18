<?php

    require_once('../config.php');
    require_once($CFG->libdir.'/adminlib.php');
    require_once($CFG->dirroot.'/user/filters/lib.php');

function countcourse($userid)
{ 
    $conn = mysql_connect('localhost','crc','crc145');
    mysql_select_db('crc_data2');
	$coursecount_sql  = "SELECT count(DISTINCT c.id) count FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE u.id=$userid and r.id!=1";

	$coursecounts = mysql_query($coursecount_sql);
    $countcourse = mysql_fetch_array($coursecounts);
    $demsocourse=$countcourse['count']; 
    return $demsocourse;
    mysql_close($conn);
}

echo 'coursecount_sql';
echo 'coursecounts';
echo 'demsocourse;

?>