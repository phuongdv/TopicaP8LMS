<?
/**
*  Default Action
*  @author		: T (vuquoctrung@gmail.com)
*  @date		: 2007/04/01
*  @version		: 1.0.0
*/
function default_add(){
global $assign_list, $_CONFIG,  $_SITE_ROOT, $mod, $dbconn;
$clsOffline=new Offline();
$c_id = isset($_REQUEST["c_id"])? $_REQUEST["c_id"] : 99;
$cls = $_REQUEST["cls"];
if($cls=="")
	{
$sqlUser="
	SELECT DISTINCT u.id,u.username,u.topica_lop,u.topica_nhom,u.lastname,trim(u.firstname) firstname
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE r.id =5
AND
c.id=$c_id
order by firstname asc  limit 0,500
";
}
else
{
$sqlUser="
	SELECT DISTINCT u.id,u.username,u.topica_lop,u.topica_nhom,u.lastname,trim(u.firstname) firstname
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE r.id =5
AND
c.id=$c_id
AND 
u.topica_lop='$cls'
order by firstname asc  limit 0,500
";
}
$arrUser = $dbconn->GetAll($sqlUser);
$assign_list["arrUser"] = $arrUser;
$assign_list["c_id"] = $c_id;
$assign_list["clsOffline"] = $clsOffline;
$assign_list["lop"] = $cls;
}





















function default_insert()
{
$c_id = isset($_REQUEST["c_id"])? $_REQUEST["c_id"] : 0;
echo $_POST[$userId];
global $dbconn;
$sqlCountUser="
SELECT Count(u.id) count
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE r.id =5
AND
c.id=$c_id
order by firstname asc  limit 0,500
";
$arrCountUser = $dbconn->GetAll($sqlCountUser);

for($i=0;$i<$arrCountUser[0]['count'];$i++)
{
$lstOff="lstOff".$i;
$lstBt="lstBt".$i;
$userId="userId".$i;
$sqlCheck="Select count(*) count from offline where u_id='$_REQUEST[$userId]' and c_id='$c_id'";
$arrCheck = $dbconn->GetAll($sqlCheck);
if($arrCheck[0][count]!=0)
{
 $sql="Update offline Set number='$_REQUEST[$lstOff]',btvn='$_REQUEST[$lstBt]' where u_id='$_REQUEST[$userId]' and c_id='".$c_id."'";	
 
 if($dbconn->Execute($sql) === false) {
		print 'error inserting: '.$dbconn->ErrorMsg().'<BR>';
		
		}
}
else{
        $sql="Insert into offline values('','$_REQUEST[$lstOff]','$c_id','$_REQUEST[$userId]','$_REQUEST[$lstBt]')";
		if($dbconn->Execute($sql) === false) {
		print 'error inserting: '.$dbconn->ErrorMsg().'<BR>';
		}
	}
}
echo "<script>
alert('Thông tin đã được lưu')
</script>";
header("location: ?topica&mod=offline&act=add&c_id=$c_id");

}
?>