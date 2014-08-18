<?php
class block_isso extends block_base {
  function init() {
    $this->title   = 'Hỗ trợ kỹ thuật trực tuyến';
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
    <a href="http://iso.topica.vn" target="_blank"><img src="http://elearning.hou.topica.vn/isso.jpg"></a>
</td>
  </tr>
  
</table>';
      }
$this->content->footer = '';
    return $this->content;
    
}
}   
?>