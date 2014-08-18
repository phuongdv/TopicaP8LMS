<?php
require_once("../../config.php");
include('nusoap/nusoap.php');

global $CFG, $QTYPES;
global $USER;

// buil checkpermisson for api ---------------------------------------------
function checkpermission()
{
	if($_SERVER['PHP_AUTH_USER']=='viet' && $_SERVER['PHP_AUTH_PW']=='123456')
	return true;
	else 
	return false;
}
#--------------------------------------------------------------------------------------

# configue for wsdl
$namespace = "http://elearning.tvu.topica.vn/vietth/webservices/get_real_name.php";
$server = new soap_server();
$server->configureWSDL("Topica Get Real Name");
$server->wsdl->schemaTargetNamespace = $namespace;

$server->register(
					// method name:
					'get_real_name',
					array('username'=>'xsd:string'),
					array('return'=>'xsd:string'),
					// namespace:
					$namespace,
					// soapaction: (use default)
					false,
					// style: rpc or document
					'rpc',
					// use: encoded or literal
					'encoded',
					// description: documentation for the method
					'Topica course info');

//Our Simple method
	function get_real_name($username)
	{
	    
		global $CFG;
		$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
		$dbname = $CFG->dbname;
		mysql_select_db($dbname);
		$sql="select CONCAT_WS(' ',lastname,firstname) realname from mdl_user where username ='$username'";
		$data = mysql_query($sql);
	    $result=mysql_fetch_array( $data );
		return $result['realname'];	


}



// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
 
// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit(); 
?>