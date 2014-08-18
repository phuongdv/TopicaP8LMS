<?

require_once('../config.php');
//check login
require_login();

$userid= $USER->id;

//check roleid
function checkRoleID($userid){
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	
	$mysqli->select_db($CFG->dbname);

	$mysqli->query("SET NAMES 'utf8'");
	
	$sqlRole="SELECT DISTINCT r.id roleid
		FROM mdl_user u
		INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
		INNER JOIN mdl_context ct ON ct.id = ra.contextid
		INNER JOIN mdl_course c ON c.id = ct.instanceid
		INNER JOIN mdl_role r ON r.id = ra.roleid
		INNER JOIN mdl_course_categories cc ON cc.id = c.category
		
		WHERE u.id =$userid
		limit 0,1";

	$OneRole = $mysqli->query($sqlRole);
	
	if (mysqli_num_rows($OneRole) > 0){
			while($vv = $OneRole->fetch_assoc()) 
				{
					$roleid=$vv['roleid'];	
										
				}
		return $roleid;			
	}
	else {
		return 0;	
	}
	//
	$OneCourse->close();
	$mysqli->close();
	
	
	
}
$roleid=checkRoleID($userid);
if($roleid!=5)  header("Location: http://dev.lms.amatop.ph/");

/* gets the data from a URL */
function get_data($url)
{
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
//echo 'http://elearning.tvu.topica.vn/lipe/lipecanhan.php?userid='.$userid;
$returned_content = file_get_contents('http://dev.lms.amatop.ph/lipe/lipecanhan.php?userid='.$userid);
echo $returned_content;
?>