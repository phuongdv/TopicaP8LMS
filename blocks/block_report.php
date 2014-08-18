<?php
class block_report extends block_base {
  function init() {
    $this->title   = 'Report admin';
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
					 WHERE u.id=".$USER->id;
     $ad = $mysqli->query($query_string);
     $dd = $ad->fetch_assoc();	  
				$role= $dd["id"];
				

	if($role==1 || $role==13 || $role==211)
    {	
	$this->content->text ='<a href="/lmsreport/LMS240-H2472">Báo cáo H2472</a><br>
	<a href="/lmsreport/index.php">Báo cáo công việc giảng viên theo Course</a><br>
	<a href="/lmsreport/coursereport/">Báo cáo tình hình course</a><br>
	<a href="/lmsreport/LMS250-quiz">B/C thực hiện nhiệm vụ học tập</a><br>
	<a href="http://ccms.topica.vn/report.php">Report CCMS</a>';
	$this->content->text .='<br><a href="/lmsreport/weekreport/">TVU-BC001</a>';
	$this->content->text .='<br><a href="/lmsreport/weekreport/bc002.php">TVU-BC002</a><br>';
	$this->content->text .='<a href="/lmsreport/weekreport/bcgvcm.php">TVU-BCGVCM</a><br>';
    $this->content->text .='<a href="/lmsreport/weekreport/bcgvdn.php">TVU-BCGVDN</a><br>';
	}
	if($role==4||$role==14)
	{
	// $this->content->text ='<a href="http://elearning.hou.topica.vn/lmsreport/LMS240-H2472">Báo cáo H2472</a><br><a href="http://elearning.hou.topica.vn/lmsreport/index.php">Báo cáo công việc giảng viên theo Course</a><br><a href="http://ccms.topica.vn/report.php">Report CCMS</a>';
	
	}
	
	
	$this->content->footer = '';
    return $this->content;
    
}
}   
?>