<?php
class block_tim extends block_base {
  function init() {
    $this->title   = 'TIM';
    $this->version = 2009111200;
  }

function get_content() {
	 global $USER, $SESSION, $CFG,$COURSE;
    if ($this->content !== NULL) {
      return $this->content;
    }
    $this->content         =  new stdClass;
	
    $mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
	$this->content->text   = '';
	
	if($COURSE->id!=1)
	{
		// check sys role
		
		$query_sr="SELECT r.id
                FROM mdl_user u
                    INNER join mdl_role_assignments ra on ra.userid=u.id
                    INNER join mdl_role r on r.id=ra.roleid 
                        WHERE 
                        ra.contextid = 1
                        and u.id='$USER->id'";
		$sr = $mysqli->query($query_sr);
        $sri = $sr->fetch_assoc();	  
		$sys_role= $sri["id"];				
		$query_string = "SELECT DISTINCT r.id
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
				INNER JOIN lipe_course_mode lcm ON  lcm.course = c.id
				WHERE c.id = '".$COURSE->id."' 
				      and lcm.mode in (2,1) 
				      and c.startdate >= UNIX_TIMESTAMP('2012-05-13 00:00:00')
				      and  u.id=".$USER->id;
     $ad = $mysqli->query($query_string);
     $dd = $ad->fetch_assoc();	  
				$role= $dd["id"];
				
	if($role!=5 and $role!=3 and ($role!='' or $sys_role==1 or $sys_role==2 or $sys_role==211 or $sys_role==347 or $sys_role==13 or $sys_role==3 or $sys_role==11)) 
    {	
		$this->content->text   = '<div align="center"><a style="font-size:15px" href ="http://elearning.tvu.topica.vn/tim/?c='.$COURSE->id.'">Teacher Interaction Management</a></div>';
		if($COURSE->id!=1)
		{
		//$this->content->text .='<iframe width=1 style="visibility:hidden;position:absolute" height=1 src="http://elearning.hou.topica.vn/tim/?c='.$COURSE->id.'"></iframe> ';
		}
    }
    
	}
	else 
	
	{
		$query_string = "select count(c.id) count
		FROM
			mdl_user u
		INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
		INNER JOIN mdl_context ct ON ct.id = ra.contextid
		INNER JOIN mdl_course c ON c.id = ct.instanceid
		INNER JOIN mdl_role r ON r.id = ra.roleid
		INNER JOIN mdl_course_categories cc ON cc.id = c.category
		WHERE r.id in (4)
		and u.id=$USER->id";
     $ad = $mysqli->query($query_string);
     $dd = $ad->fetch_assoc();	  
				$count= $dd["count"];
	if($count>0)
		{
			$sql="select count(vt.course) count from vietth_tam vt,mdl_course c where vt.startdate< now() 
			and vt.enddate > NOW() 
			and (vt.nhanxet is  null 
			or vt.dh_nv is  null   or vt.dh_tuantoi is  null or vt.emailsent != 1 )
AND
course in (
select c.id
FROM
	mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE r.id in (4)
AND  u.id=$USER->id
)
and c.id=vt.course";
			 $ad = $mysqli->query($sql);
     $dd = $ad->fetch_assoc();	  
				$count= $dd["count"];
				
				
	// fix bug tuan 1

	$sql="SELECT
			count(distinct vt.course)count
		FROM
			vietth_tam vt,
			mdl_course c
		WHERE
			vt.enddate > now()
			and 
			vt.stttuan='1'
		AND 
			vt.dh_nv IS not NULL
		
		AND course IN(
			SELECT
				c.id
			FROM
				mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
		INNER JOIN mdl_context ct ON ct.id = ra.contextid
		INNER JOIN mdl_course c ON c.id = ct.instanceid
		INNER JOIN mdl_role r ON r.id = ra.roleid
		INNER JOIN mdl_course_categories cc ON cc.id = c.category
		WHERE
			r.id IN(4)
		AND u.id = $USER->id
		)
		AND c.id = vt.course";
			 $ad = $mysqli->query($sql);
     $dd = $ad->fetch_assoc();	  
				$count2= $dd["count"];	
			$count=$count-$count2;	
				
			if($count==0)
			{
			$this->content->text   = '<div align="center"><p style="font-size:13px">Teacher Interaction Management</p>Thầy (Cô) <a style="font-weight:bold" href ="http://elearning.tvu.topica.vn/tim"> không có lớp môn </a> nào chưa viết nhận xét/định hướng</div>';			
			}
			else
			{
			$this->content->text   = '<div align="center"><p style="font-size:13px">Teacher Interaction Management</p>Thầy (Cô) có <a style="font-weight:bold" href ="http://elearning.tvu.topica.vn/tim">'.$count.'  lớp môn </a>chưa viết nhận xét/định hướng</div>';
			}
		}
		
		
		
	}
	
	// $mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	// $mysqli->select_db($CFG->dbname);
	// $sql="select count(vt.course) count from vietth_tam vt,mdl_course c where vt.startdate< now() and vt.enddate > NOW() and (vt.nhanxet is  null or (vt.dh_nv is  null and vt.stttuan='1')  or vt.dh_tuantoi is  null or vt.emailsent != 1 )
			// AND
			// course in (
			// select c.id
			// FROM
				// mdl_user u
			// INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			// INNER JOIN mdl_context ct ON ct.id = ra.contextid
			// INNER JOIN mdl_course c ON c.id = ct.instanceid
			// INNER JOIN mdl_role r ON r.id = ra.roleid
			// INNER JOIN mdl_course_categories cc ON cc.id = c.category
			// WHERE r.id in (4)
			// AND  u.id=$USER->id
			// )
			// and c.id=vt.course";
	// $ad = $mysqli->query($sql);
    // $dd = $ad->fetch_assoc();	  
	// $this->content->text   = '<div align="center"><p style="font-size:13px">Teacher Interaction Management</p>Thầy (Cô) có <a style="font-weight:bold" href ="/tim">'.$count.'  lớp môn </a>chưa viết nhận xét/định hướng</div>';
			
	$this->content->footer = '';
    return $this->content;
    
}
}   
?>