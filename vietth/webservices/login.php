<?

require_once("../../config.php");
global $CFG, $QTYPES;
global $USER;

$callback=$_POST['callback'];
$username=$_POST['username'];
$password=$POST['pasword'];

$username='vietth';
$password='viet123';


Authorization($username,$password);

function Authorization($username,$password)
{
global $CFG;
$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
$dbname = $CFG->dbname;
mysql_select_db($dbname);
$password=mysql_real_escape_string(md5($password));
$username=mysql_real_escape_string($username);
$sql="select * from mdl_user where username='$username' and password='$password'";
$data = mysql_query($sql);
$user=array();
	while ($result=mysql_fetch_assoc( $data ))
	{
		$user[]=$result;
	}
	header('Content-type: application/json');
   echo  $callback.'({data: '.json_encode($user).'})';
}
?>