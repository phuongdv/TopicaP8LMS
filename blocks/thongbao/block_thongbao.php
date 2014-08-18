<?php
class block_thongbao extends block_base {
  function init() {
    $this->title   = get_string('tbao.mainmennu', 'block_login_logout');
    $this->version = 2009111200;
  }

function get_content() {
	 global $USER, $SESSION, $CFG;
    if ($this->content !== NULL) {
      return $this->content;
    }
 
    $this->content         =  new stdClass;
    $this->content->text   = ' ';
	if (isset($USER->topica_lop)) {
		if($USER->topica_lop !=''){
			$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
			$mysqli->select_db($CFG->dbname);
			$mysqli->query("SET NAMES 'utf8'");
			$query_string = "SELECT * FROM tp_thong_bao where lop = '$USER->topica_lop'";
		//	echo $query_string;die;
			$ad = $mysqli->query($query_string);
				if (mysqli_num_rows($ad) > 0){
					while($dd = $ad->fetch_assoc()) 
					{
						$ct = '';
						$ct = $dd["content"];
					 if ($ct != '' && $ct != NULL) {
					 $this->content->text .= $ct;
					 } else { $this->content->text .= get_string('tbao.chuacothongbaonaochoban', 'block_login_logout');}
					}
				} else { $this->content->text .= get_string('tbao.chuacothongbaonaochoban', 'block_login_logout');}
			$ad->close();
			$mysqli->close();
		}else{
			$this->content->text .= get_string('tbao.chuacothongbaonaochoban', 'block_login_logout');
		}
	} else { $this->content->text .= get_string('tbao.dangnhapdexemthongbao', 'block_login_logout'); }
    $this->content->footer = '';
    return $this->content;
  }
}   
?>