<?php
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');
*/
include('../../config.php');
include('classes/dbclass.php');
include('nusoap/nusoap.php');
include('nusoap/class.wsdlcache.php');
include('lib/count_post_vbb.php');

$DB	= new DB($CFG->dbname  , $CFG->dbhost ,$CFG->dbuser ,$CFG->dbpass);
$DB-> query("SET NAMES 'utf8'");

// api 
?>