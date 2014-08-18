<?php
class block_onlines extends block_base {
  function init() {
    $this->title   = get_string('lich.main_menu', 'block_login_logout');
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
    $query_string = "SELECT DISTINCT min(r.id) id
					 FROM mdl_user u
					 INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				     INNER JOIN mdl_context ct ON ct.id = ra.contextid
					 INNER JOIN mdl_course c ON c.id = ct.instanceid
					 INNER JOIN mdl_role r ON r.id = ra.roleid
					 INNER JOIN mdl_course_categories cc ON cc.id = c.category
					 WHERE u.id=".$USER->id." and c.id!=''";
     $ad = $mysqli->query($query_string);
     $dd = $ad->fetch_assoc();	  
				$role= $dd["id"];
				

	//if($role==1 || $role==13 || $role==11 || $role==211 || $role==2 || $role==347)
    //{	
	$this->content->text ='<a href="http://elearning.tvu.topica.vn/vclasscalendar/">'.get_string('lich.lichphatsongonline', 'block_login_logout').'</a>';
	//}
	
	$this->content->footer = '';
    return $this->content;
    
}
}   
?>