<?php
include('../config.php');
include('includes/config.inc.php');

global $db;

$threadid=$_GET['thrid'];

include($dir_inc.'functions.php');

$sql1="delete from tblreply where answerid=(select id from tblanswer where thread='".$threadid."')";
$result=$db->sql_query($sql1);
$sql2="delete from tblanswer where thread='".$threadid."'";
$result2=$db->sql_query($sql2);
$sql3="delete from tblthread where id='".$threadid."'";
$result3=$db->sql_query($sql3);
echo $sql1.'<br>'.$sql2.'<br>'.$sql3;



?>