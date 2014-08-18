<?php
class block_sms extends block_base {
  function init() {
    $this->title   = 'Quản lý gửi sms';
    $this->version = 2009111200;
  }

function get_content() {
	 global $USER, $SESSION, $CFG , $COURSE;
    if ($this->content !== NULL) {
      return $this->content;
    }
 
    $this->content         =  new stdClass;
     
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
        $query_string = "SELECT DISTINCT r.id
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
				WHERE c.id = 1145 and u.id=".$USER->id;
     $ad = $mysqli->query($query_string);
     $dd = $ad->fetch_assoc();
	    $course=$COURSE->id;	  
				$role= $dd["id"];
    if($course!='1')
    {	
    switch ($role) {
    case "4":
        $this->content->text   = '<div style="cursor:pointer" onClick="window.open(\'../smsmodle/teacher.php?c_id='.$course.'\',\'mywindow\',\'width=700,height=500,left=300,top=300,screenX=300,screenY=300\')" align="center">Gửi SMS</div>';
		break;
    case "14":
        $this->content->text   = '<div style="cursor:pointer" onClick="window.open(\'../smsmodle/teacher.php?c_id='.$course.'\',\'mywindow\',\'width=700,height=500,left=300,top=300,screenX=300,screenY=300\')" align="center">Gửi SMS</div>';
		break;
    case "3":
	
       $this->content->text   = '<div style="cursor:pointer" onClick="window.open(\'../smsmodle/cvht.php?c_id='.$course.'\',\'mywindow\',\'width=700,height=500,left=300,top=300,screenX=300,screenY=300\')" align="center">Gửi SMS</div>';
		break;
    default:
        $this->content->text   = "";
      }
	}
	else
	 {
	  switch ($role) {
    case "4":
        $this->content->text   = '<div style="cursor:pointer" onClick="window.open(\'smsmodle/teacher.php\',\'mywindow\',\'width=700,height=500,left=300,top=300,screenX=300,screenY=300\')" align="center">Gửi SMS</div>';
		break;
    case "14":
        $this->content->text   = '<div style="cursor:pointer" onClick="window.open(\'smsmodle/teacher.php\',\'mywindow\',\'width=700,height=500,left=300,top=300,screenX=300,screenY=300\')" align="center">Gửi SMS</div>';
		break;
    case "3":
	
        //$this->content->text   = "<div align=\"center\"><a href=\"smsmodle/cvht.php\" class=\"boxed\" rel=\"{handler:'iframe',size:{x:700,y:500},iframePreload:true}\"> Gửi SMS</a></div>";
        $this->content->text   = '<div style="cursor:pointer" onClick="window.open(\'smsmodle/cvht.php\',\'mywindow\',\'width=700,height=500,left=300,top=300,screenX=300,screenY=300\')" align="center">Gửi SMS</div>';
		break;
    default:
        $this->content->text   = "";
      }
	 
	 }
    
    
    
	
    $this->content->footer = '';
    return $this->content;
  }
}   
?>
