<?php 
class Lipecanhan extends DbBasic
{
function getUserinfo($u_id)
	{
	global $dbconn;
	$sql="select * from mdl_user where id='$u_id'";
	$res = $dbconn->GetAll($sql);
     return $res;
	
	}
//      lay c_id cua khoa hoc theo user id
function getCourse($u_id)
	{
    global $dbconn;
	$sql="Select c.* from 
	mdl_course c
	inner join mdl_context ct on c.id=ct.instanceid
	inner join mdl_role_assignments ra on ct.id=ra.contextid
	inner join mdl_user u on ra.userid=u.id
	inner join mdl_role r on r.id=ra.roleid
	inner join mdl_course_categories cc on cc.id = c.category
	where 
	r.id=5
	and
	u.id = $u_id and c.fullname not like '%h2472%' AND enrolstartdate <".strtotime('2014-04-27 00:00:00')." order by c.id DESC";
	$res = $dbconn->GetAll($sql);
     return $res;
	}
function getLogin($c_id,$u_id)
     {
	 global $dbconn;
	 $sql="select count(*) count from mdl_log
	 where
	 module='course' and userid=$u_id
	 and course=$c_id";
	 $res = $dbconn->GetAll($sql);
     return $res;
	 }
function getExamgrades($c_id)
	{
	  global $dbconn;
	 $sql="select q.id from mdl_quiz q where course=$c_id and name like '%Bài tập về nhà%'";
	 $res = $dbconn->GetAll($sql);
	 //$res=$sql;
     return $res;
	}
function getGrades($q_id,$u_id)
	{
	 global $dbconn;
	 $sql="select sumgrades from mdl_quiz_attempts where quiz=$q_id and userid=$u_id";
	 $res = $dbconn->GetAll($sql);
     return $res;
	}

}

?>