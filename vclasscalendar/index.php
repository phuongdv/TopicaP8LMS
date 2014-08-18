<?php
require_once("../config.php");
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
 '<h2 class="main"> <a style="color:#790000">C '. $USER->lastname .' '.$USER->firstname .'</a></h2><br>';
?>
<iframe src="https://www.google.com/calendar/embed?src=skmhrefmg82sn6v9g6s829s5qc%40group.calendar.google.com&ctz=Asia/Saigon" style=" border:solid 1px #777 " width="1000" height="600" frameborder="0" scrolling="no"></iframe>
<?php
print_footer($site); 
?>