<?php
session_start();
$_SESSION['test']=123456;
echo $_SESSION['test'];
echo '<a href="getsession.php"> click </a>';

?>