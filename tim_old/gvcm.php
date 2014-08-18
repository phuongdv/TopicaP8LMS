  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){
<?php
if($cid!='')
{
?>
$(".flip").click(function(){
    $(".panel").slideToggle("slow");
  });
});
<?php
}
else 
{
?>

$(".panel").show("slow");
});

<?php
}
?>
</script>
 
<style type="text/css"> 
div.panel
{
margin:0px;
padding:5px;
text-align:left;
border:solid 1px #810c15;
}
div.panel
{
height:auto;
display:none;
}
</style>

<div class="panel">
<?php
$sql="SELECT
			c.id,c.fullname
		FROM
			vietth_tam vt,
			mdl_course c
		WHERE
    vt.startdate< now() and vt.enddate > NOW()
    and
		(vt.nhanxet IS NULL
		OR vt.dh_nv IS NULL
		OR vt.dh_tuantoi IS NULL
		OR vt.emailsent != 1
		)
		AND course IN(
			SELECT
				c.id
			FROM
				mdl_user u
			INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
		INNER JOIN mdl_context ct ON ct.id = ra.contextid
		INNER JOIN mdl_course c ON c.id = ct.instanceid
		INNER JOIN mdl_role r ON r.id = ra.roleid
		INNER JOIN mdl_course_categories cc ON cc.id = c.category
		WHERE
			r.id IN(4)
		AND u.id = $USER->id
		)


		AND c.id = vt.course";

$data = mysql_query($sql);
$t=0;
if(mysql_num_rows($data)>0)
	{
	while($info = mysql_fetch_array( $data )) 
     {
	 if(!check_tuan1($info['id']))
	    {
     	$t=$t+1;  
     	echo '<p><a href="?c='.$info['id'].'">'.$t.'.'.$info['fullname'].'</a></p>';
		}
     }	 

	}
else 
	{
	    echo 'Thầy cô không có lớp môn nào cần viết nhận xét và định hướng.Để xem lại nhận xét,định hướng, thầy (cô) vui lòng vào course học và chọn TIM';
	}	
function check_tuan1($cid)
{
  $sql = "select dh_nv from vietth_tam where course = $cid and startdate< now() and enddate > NOW() ";
  $data = mysql_query($sql);
  $info = mysql_fetch_array( $data );
  if($info['dh_nv']=='')
  return false;
  else
  return true;
}	

	
?>
</div>
 
<p style="text-align:center;cursor:pointer;" class="flip">Danh sách lớp môn chưa viết nhận xét/định hướng</p>



 



