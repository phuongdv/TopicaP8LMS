<?php
$date = date ('h_i_s_d_m_y',time());
require_once("../../config.php");

    require_once("lib.php");
header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
    header("Content-Disposition: attachment;filename=Assignment".$course."_".$date.".xls");


    $id   = optional_param('id', 0, PARAM_INT);          // Course module ID
    $a    = optional_param('a', 0, PARAM_INT);           // Assignment ID

require_login($course, true, $cm);

   

  //  print_header($course->fullname.': '.$strreports, $course->fullname.': '.$strreports, $navigation);

?>




<?php

include("submissions3.php");

//print_footer($site); 

?>