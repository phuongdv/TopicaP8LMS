<?php
include('../../config.php');
include('../nusoap/nusoap.php');
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

$namespace = "http://elearning.tvu.topica.vn/h2472/webservices/delaythread.php";
$server = new soap_server();
$server->configureWSDL("H2472 delay thread info");
$server->wsdl->schemaTargetNamespace = $namespace;

$server->register(
					// method name:
					'delay_threads',
					array('day'=>'xsd:string'),
					array('return'=>'xsd:Array'),
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
	function delay_threads($day)
	{
			global $CFG;
		$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
		$dbname = $CFG->dbname;
		mysql_select_db($dbname);
		$sql="SELECT
	t.id,
	t.answername,
  c.fullname,
  u.username,
	SEC_TO_TIME(UNIX_TIMESTAMP() - t.time) delay
FROM
	tblthread t,mdl_course c,mdl_user u
WHERE
c.id = t.courseid
AND
u.id = t.assignid
and
	(t. STATUS = 0 OR t. STATUS = 3)
and
UNIX_TIMESTAMP() - t.time >= 3600 * 48 
ORDER BY
	t.id DESC
			";
		$data = mysql_query($sql);
		$course=array();
		if(mysql_num_rows($data)>0)
			{
			while ($result=mysql_fetch_assoc( $data ))
			{
				$course[]=$result;
			}
		
			} 
			 return $course;	
             //return 'xxx';

}

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
 
// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit();  
?>