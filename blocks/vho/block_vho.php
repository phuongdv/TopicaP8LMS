<?php
class block_vho extends block_base {
  function init() {
    $this->title   = get_string('vho.dichvuvanhanhvho', 'block_login_logout');
    $this->version = 2009111200;
  }

function get_content() {
 global $USER, $SESSION, $CFG,$COURSE;
    if ($this->content != NULL) {
      return $this->content;
    }

    
    
    
 $this->content         =  new stdClass;
 if($USER->topica_staff=='1')
    {
// chi xu ly voi nhan vien topica
 $this->content->text   = '<table width="200" border="0">
   <tr>
    <td>
    <a href="http://vho.lms.amatop.ph" target="_blank"><img src="http://elearning.tvu.topica.vn/vho.jpg"></a>
</td>
  </tr>
  
</table>';
      }
$this->content->footer = '';
    return $this->content;
    
}
}   
?>