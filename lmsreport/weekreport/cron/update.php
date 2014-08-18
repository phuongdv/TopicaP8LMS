<?php
require('../global.php');
$sql = 'delete  from lmsreport_sl_hv_course';
$DB->query($sql);
$sql = 'insert into  lmsreport_sl_hv_course(courseid,shortname,slhv)
SELECT id courseid,shortname,
 (SELECT count(u.id)
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
				WHERE  r.id=5 and c.id=courseid) slhv
 from mdl_course where id <>1';
 $DB->query;
 echo 'done';
?>