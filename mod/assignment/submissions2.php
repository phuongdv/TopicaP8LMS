<?php

require_once("../../config.php");

    require_once("lib.php");

    $id   = optional_param('id', 0, PARAM_INT);          // Course module ID
    $a    = optional_param('a', 0, PARAM_INT);           // Assignment ID

require_login($course, true, $cm);

    $navlinks = array();

    $navlinks[] = array('name' => $strreports, 'link' => null, 'type' => 'misc');

    $navigation = build_navigation($navlinks);

    print_header($course->fullname.': '.$strreports, $course->fullname.': '.$strreports, $navigation);

?>




<?php

echo '<div id="content"><div class="reportlink"><A HREF="javascript:history.back()">Quay lai</A> </div></div>';

include("submissions3.php");
echo '
<br>
<div align="center"><a href="excell.php?id='.$id.'" tartget="_blank">Xuất ra định dạnh excel</a></div>';
print_footer($site); 

?>