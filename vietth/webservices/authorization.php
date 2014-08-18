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
$namespace = "http://elearning.hou.topica.vn/vietth/webservices/authorization.php";
$server = new soap_server();
$server->configureWSDL("Topica Authorization");
$server->wsdl->schemaTargetNamespace = $namespace;

$server->register(
					// method name:
					'Authorization',
					// parameter list:
					array('username'=>'xsd:string',
					 	  'password'=>'xsd:string'),
					// return value(s):
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
					'Topica authorization');

					$server->register(
					// method name:
					'check_role',
					// parameter list:
					array('username'=>'xsd:string'),
					// return value(s):
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
					'Topica check role');
 

 
//Our Simple method
	function Authorization($username,$password)
	{
			global $CFG;
		if(checkpermission()==true)
		{
		$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
		$dbname = $CFG->dbname;
		mysql_select_db($dbname);
		$password=mysql_real_escape_string(md5($password));
		$username=mysql_real_escape_string($username);
		$sql="select * from mdl_user where username='$username' and password='$password'";
		$data = mysql_query($sql);
		$user=array();
		if(mysql_num_rows($data)>0)
			{
			while ($result=mysql_fetch_array( $data ))
			{
				$user=$result;
			}
		 return $user;	
			}
		 else 
		 {
		 	return 'not found';
		 }	
		
		}
		else 
		return "Login fail";
	}

    function check_role($username)
    {  
    	global $CFG;
    	$username=mysql_real_escape_string($username); 
    	if(checkpermission()==true)
    	{
    		$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
			$dbname = $CFG->dbname;
			mysql_select_db($dbname);
    		$sql="SELECT min(r.shortname) role
			 FROM
				mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
			INNER JOIN mdl_context ct ON ct.id = ra.contextid
			INNER JOIN mdl_course c ON c.id = ct.instanceid
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE 
			u.username='$username'";
    		$data = mysql_query($sql);
    		$result=mysql_fetch_assoc($data);
			 return  $result['role'];
    	}
    }
    
    
    # function get h2472 issue ---------------------------------------
    function getH2772 ($userid)
    {
    	global $CFG;
    	$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
		$dbname = $CFG->dbname;
		mysql_select_db($dbname);
		
		
    	
    }




 
// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
 
// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit(); 
?>