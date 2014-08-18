<?php
class block_2472 extends block_base {
  function init() {
    $this->title   = 'Giải đáp thắc mắc 2472';
    $this->version = 2009111200;
  }

function get_content() {
	 global $USER, $SESSION, $CFG,$COURSE;
    if ($this->content !== NULL) {
      return $this->content;
    }

    //  start login:
    



    
     
    $this->content         =  new stdClass;
    
    $this->content->footer = '';
    return $this->content;
    
}
}   
?>