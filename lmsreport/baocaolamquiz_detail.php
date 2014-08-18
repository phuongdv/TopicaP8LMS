<?php
require_once("../config.php");
require_login();
global $CFG, $QTYPES;
$cid	=	$_GET['c'];
$excellbtn  =   $_POST['excellbtn'];
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
	$ad = $mysqli->query('SET NAMES utf8');
if($excellbtn=='')
{
print_header(" Báo cáo hoạt động chi tiết",'<a href="index.php">'. "$stradministration</a>->Tai khoan");


?>
<form id="form1" name="form1" method="post" action="">
 <label>
        <input type="submit" name="excellbtn" value="    Xuất excel     " />
      </label>
</form>

<?php
}
else
{

header("Pragma: public");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("Content-Type: application/force-download");

    header("Content-Type: application/octet-stream");

    header("Content-Type: application/download");;

    header("Content-Disposition: attachment;filename=QUIZ_REPORT.xls");
}

?>
<table width="100%" border="1" style="font-size:80%" cellpadding="5">
  <tr>
    <td width="50">STT</td>
    <td width="50">Họ tên</td>
    <td width="50">Username</td>
    <td width="50">Luyện tập    trắc nghiệm 1</td>
    <td width="48">Luyện tập trắc    nghiệm 2</td>
    <td width="46">Luyện tập trắc    nghiệm 3</td>
    <td width="48">Luyện tập trắc    nghiệm 4</td>
    <td width="48">Luyện tập trắc    nghiệm 5</td>
    <td width="48">Luyện tập trắc    nghiệm 6</td>
    <td width="48">Bài tập về nhà số    1</td>
    <td width="48">Bài tập về nhà số    2</td>
    <td width="48">Bài tập về nhà số    3</td>
  </tr>

<?




	    
	 $query_string="
	 SELECT c.id cid,u.id uid,u.username,u.firstname,u.lastname
	 FROM
	mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE
	r.id = '5' 
AND c.id='$cid'
	order by u.username asc								
	 ";
	 //echo $query_string;
	 $ad = $mysqli->query($query_string);
	 
	 $t=0;
  while($dd = $ad->fetch_assoc()) 
			{
			$t=$t+1;
			?>
			<tr 
			<?php
			if($t%2==0)
			{
			 echo 'style="background:#eeeeee"';
			}
			?>
			
			>
    <td><?php echo $t ;?></td>
    <td><?php echo $dd['lastname'].' '.$dd['firstname'] ;?></td>
    <td><a target="_blank" href="http://elearning.tvu.topica.vn/course/user.php?id=<?php echo $dd['cid']; ?>&user=<?php echo $dd['uid']; ?>&mode=outline"><?php echo $dd['username']; ?></a></td>
    <td><?php echo demsobaitn($dd['cid'],$dd['uid'],1); ?></td>
    <td><?php echo demsobaitn($dd['cid'],$dd['uid'],2); ?></td>
    <td><?php echo demsobaitn($dd['cid'],$dd['uid'],3); ?></td>
    <td><?php echo demsobaitn($dd['cid'],$dd['uid'],4); ?></td>
    <td><?php echo demsobaitn($dd['cid'],$dd['uid'],5); ?></td>
    <td><?php echo demsobaitn($dd['cid'],$dd['uid'],6); ?></td>
    <td><?php echo demsobaivn($dd['cid'],$dd['uid'],1); ?></td>
    <td><?php echo demsobaivn($dd['cid'],$dd['uid'],2); ?></td>
    <td><?php echo demsobaivn($dd['cid'],$dd['uid'],3); ?></td>
  </tr>
			
			
			<?php
			
			
			}
			
  








function demsohocvien($cid)
{
global $mysqli;
$query_string = "SELECT Count(DISTINCT u.id) sohv
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
				WHERE  r.id='5'
				and
				c.id='$cid'
				";
$ad = $mysqli->query($query_string);
$dd = $ad->fetch_assoc();
return $dd['sohv'];


}

function demsobaitn($cid,$userid,$stt)
{
global $mysqli;
$query_string = "select count(qa.id) result from mdl_quiz_attempts qa,mdl_quiz q where  
qa.quiz=q.id
and
qa.quiz=(select id from mdl_quiz where course=$cid and name like '%luyện tập%' and name like '%$stt%' )
AND
 qa.userid = $userid
					
				";
$ad = $mysqli->query($query_string);
$dd = $ad->fetch_assoc();
return $dd['result'];	
	
}

function demsobaivn($cid,$userid,$stt)
{
global $mysqli;
$query_string = "select count(qa.id) result from mdl_quiz_attempts qa,mdl_quiz q where  
qa.quiz=q.id
and
qa.quiz=(select id from mdl_quiz where course=$cid and name like '%về nhà%' and name like '%$stt%' )
AND
 qa.userid = $userid
				";
$ad = $mysqli->query($query_string);
$dd = $ad->fetch_assoc();
return $dd['result'];	
	
}

function sohvlambai($cid)
{
	global $mysqli;
	$query_string="select count(DISTINCT qa.userid) result
from mdl_quiz_attempts qa,mdl_quiz q,mdl_course c
where 
qa.quiz=q.id
AND
q.course=c.id
and c.id='$cid'";
//echo $query_string;
$ad = $mysqli->query($query_string);
$dd = $ad->fetch_assoc();
return $dd['result'];
	
	
}







?>
</table>
<?php print_footer($site); ?>