<?php
session_start();
echo 'id: '.session_id();
echo ' : '.$_SESSION['test'];

?>