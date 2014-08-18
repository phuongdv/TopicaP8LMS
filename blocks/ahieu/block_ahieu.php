<?php

$userlogin=get_moodle_cookie();
$userlogin_bs64=base64_encode($userlogin);
$name =	$user->username;
$user_b64= base64_encode($name);


class block_ahieu extends block_base {
  function init() {
    $this->title   = 'Document Management System';
    $this->version = 2009111200;
  }

function get_content() {
	 global $USER, $SESSION, $CFG,$COURSE;
    if ($this->content !== NULL) {
      return $this->content;
    }

    //  start login:
    

     
    $this->content         =  new stdClass;
   
  
   
    if($USER->topica_staff=='1')
    {
    /*$this->content->text   = '
	<form name="myform2" action="dms.topica.vn/dms.php">
<input type="hidden" name="u" id="u" value="'.$USER->username.'" />

<a href="javascript: dms() "><img src="dms.jpg"></a>
</form>
<script type="text/javascript">
function dms()
{
  document.myform2.submit();
}
</script> ';*/
    $this->content->text   = '

<a href="https://sites.google.com/a/topica.edu.vn/dms/?pli=1" target="_blank"><img src="dms.jpg"></a>
';
    }
    else
    {
   //$this->content->text   = '.';
    }
    
    $this->content->footer = '';
    return $this->content;
    
}
}   
?>