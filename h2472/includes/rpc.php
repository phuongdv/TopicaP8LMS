<?php
ob_start();
header("Cache-Control: no-cache");
header("Pragma: nocache");	

// TODO : need to save comments
//print_r($_POST);
include('RatingManager.inc.php'); 
$ratingManager = RatingManager::getInstance();
echo $ratingManager->updateVote($_GET['num'], $_GET['id']);
?>