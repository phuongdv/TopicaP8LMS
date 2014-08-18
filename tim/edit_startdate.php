<?php
$c=$_GET['c']; // lay loai can sua


require_once("../config.php");
global $CFG, $QTYPES,$USER;
$usehtmleditor = can_use_richtext_editor();

$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
$dbname = $CFG->dbname;
mysql_select_db($dbname);


// check role
// checkrole

$sql = "SELECT min(r.id) rid,c.id cid
 FROM
	mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
INNER JOIN vietth_tam vt on vt.course=c.id
WHERE 
c.id=$c
and
u.id=$USER->id
";

$data = mysql_query($sql);
	while($info = mysql_fetch_array( $data )) 
     {
     	$roleid=$info['rid'];
     	$cid=$info['cid'];
     }	  
     
if($roleid!=1 &&  $roleid!=13  && $roleid!=211 ){
	    echo '<script>alert(\'Rất tiếc, Thầy \ cô không phải PO hoặc quản trị viên của lớp môn này !\');window.opener.location.reload();self.close ();</script>';	
      	die('Rất tiếc, Thầy \ cô không phải GVCM của lớp môn này !');
      	} 
      	 

if($_POST['submit']!='')
{	
$course_start=$_POST['date'];
$start=strtotime($course_start);
// new start and end for week 1

for ($i=1;$i<=8;$i++)
{
 $offset=7*($i-1);
 
 $w_end   =date( "Y-m-d",strtotime('+ '.$offset.' day',$start));
 $w_start = date( "Y-m-d",strtotime('-6 day',strtotime($w_end)));
 $sql="update vietth_tam set startdate='$w_start',enddate='$w_end' where course='$c' and stttuan='$i'";
 $data = mysql_query($sql);

}
echo '<script>window.opener.location.reload();self.close ();</script>';	
}
?>




 <form action="" method="POST" enctype="multipart/form-data">
Nhập ngày bắt đầu của course (YYYY-MM-DD) VD: 2012-05-15:
<input type="text" name="date" id="date">
<input type="submit" name="submit" value=" Hoàn tất  "> <input type="button" onclick="self.close ();" value=" Đóng ">

<?php
//print_footer($site); 
?>