<?php

/* Creat dir lib_quiz_html to save file */
$dir_name="tinhth";
$dir_root_quiz="/lib_quiz_html/".$dir_name;
if(!is_dir($dir_root_quiz)){
	mkdir($dir_root_quiz,0777);
}
echo 'make success';
?>