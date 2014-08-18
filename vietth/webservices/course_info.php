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
$namespace = "http://elearning.tvu.topica.vn/vietth/webservices/course_info.php";
$server = new soap_server();
$server->configureWSDL("Topica Course info");
$server->wsdl->schemaTargetNamespace = $namespace;

$server->register(
					// method name:
					'course_exp',
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
	function course_exp($day=3)
	{
			global $CFG;
		$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
		$dbname = $CFG->dbname;
		mysql_select_db($dbname);
		$sql="SELECT
	u.username povhlm,
	u.email,
	c.id cid,
	c.fullname,
	FROM_UNIXTIME(c.enrolenddate, '%m-%d-%Y')enddate,
	(
		SELECT
			count(*)
		FROM
			mdl_user u
		INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
	INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE
	c.id = cid
AND r.id = 5
	)so_hv,
	(
		SELECT
			GROUP_CONCAT(u.username SEPARATOR ',')
		FROM
			mdl_user u
		INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
	INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE
	r.id = '4'
AND c.id = cid
GROUP BY
	'ALL'
	)GVCM,
	(
		SELECT
			GROUP_CONCAT(u.username SEPARATOR ',')
		FROM
			mdl_user u
		INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
	INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE
	r.id = '14'
AND c.id = cid
GROUP BY
	'ALL'
	)GVHD
FROM
	mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE
	r.id = 211
AND c.enrolenddate > UNIX_TIMESTAMP()
AND c.enrolenddate != 0
AND
DATEDIFF(FROM_UNIXTIME(c.enrolenddate) , now()) = 3
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


}



// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
 
// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit(); 
?>