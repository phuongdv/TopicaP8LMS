<?php
class block_2472_login extends block_base {
  function init() {
    $this->title   = 'h2472 login';
    $this->version = 2009111200;
  }

function get_content() {
	 global $USER, $SESSION, $CFG,$COURSE;
    if ($this->content !== NULL) {
      return $this->content;
    }
 
    $this->content         =  new stdClass;
	
	
	

    
    
    
    
    $this->content->text   = '.';
	
    $this->content->footer = '';
    return $this->content;
  }
}   
?>