<?php
    require_once("../config.php");
    function check_role($username)
    {  
    	global $CFG;
    	$username=mysql_real_escape_string($username); 
    	
    		$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
			$dbname = $CFG->dbname;
			mysql_select_db($dbname);
    		$sql="SELECT distinct r.shortname role
			 FROM
				mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE 
			u.username='$username' order by r.id asc";
    		$data = mysql_query($sql);
    		$role='';
    		while($result=mysql_fetch_assoc($data))
    		{
			 $role.=$result['role'].',';
    		} 
    		return $role;
   }
    
?>