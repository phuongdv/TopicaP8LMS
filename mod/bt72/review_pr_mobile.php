
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>
    <link rel="shortcut icon" href="http://elearning.hou.topica.vn/theme/topica/favicon.ico">


<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
<link rel="stylesheet" href="mobile_theme/topica.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
<link rel="stylesheet" href="css/checknet.css" media="all" />
<script src="js/checknet-1.3.min.js"></script>
<link rel="stylesheet" href="css/mobile.css" />
<script>


    
	
  
</script>
<style>
.baoloi{
display:none;
}
</style>

</head>


<body>


<?php
require_once("../../config.php");
require_once("libs_trung.php");
require_once("function.php");

$key = 'vietth';



$userid   = $_GET['u'];
$courseid = $_GET['c'];
$secret   = $_GET['s'];

$quiz_id  = $_GET['q'];



if($userid == '')
{
 $userid = $_COOKIE["m_userid"];
 
}
if($secret == '')
{
 $secret = $_COOKIE["m_secretkey"];

}


// authorization
if($secret != md5($userid.$key))
	{
    echo '
 <div data-role="dialog">
	
		<div data-role="header" data-theme="d">
			<h1>Có lỗi xảy ra</h1>

		</div>

		<div data-role="content" data-theme="c">
			<h1>Thông tin tài khoản không đúng?</h1>
			<p>Bạn chưa đăng nhập , hoặc tài khoản không được phép vào khu vực này</p>  
			<a href="#" data-role="button" data-rel="back" data-theme="b">Quay trở lại</a>    
		</div>
	</div>
   
   ';

	}
else
    {
     $expire=time()+60*60*24;
	 
	 // get course fullname 
	 $sql        = "select fullname from mdl_course where id = $courseid";
	 $result     =  mysql_query($sql);
	 $courseinfo =  mysql_fetch_assoc($result);
	 
     setcookie("uid", $userid, $expire);
	 setcookie("course",$courseid, $expire);
	 setcookie("coursename",$courseinfo['fullname'], $expire);
	 setcookie("secret",$secret, $expire);

	//

		$uid= $userid;
		$course = $courseid;
		$qid=$quiz_id;
		if($qid){
			
		$sql_quiz_extra_info 	=	"SELECT q.id qid,q.*,c.fullname ,q.password,
		(select count(*) from vietth_q169_attempts where quiz = qid and userid = $uid and deleted!=1) dalam
		FROM mdl_quiz q
		INNER join mdl_course c on c.id = q.course
		 where q.id = $qid ";
		$result_quiz_info		=	mysql_query($sql_quiz_extra_info);
		if(mysql_num_rows($result_quiz_info)==0){
				echo "Mã đề không đúng, đề nghị kiểm tra và thử lại!";
				die();
		}
		$quiz_info				=  mysql_fetch_assoc($result_quiz_info);

			switch ($quiz_info['grademethod'])
			 {
			  case 1 :
				 $grademethod = 'Lần cao nhất';
				 break;
			  case  2 :	
				 $grademethod = 'Điểm trung bình';
				 break;
			  case  3 :	
			   $grademethod = 'Làm bài lần đầu';
				 break;
			  case  4 :	
			   $grademethod = 'Làm bài lần cuối';
				 break;
			 }
			}
 
	?>





  
    <!-- END OF HEADER -->
<div data-role="page" style="height:100%;">
<div data-role="header">
<h2 style="overflow:visible">MLA - <?php echo $quiz_info['fullname']; ?></h2>
</div>

<div data-role="content"  style="min-height:100%;height:100%">
<div data-role="collapsible">
<h6><?php echo $quiz_info['name']; ?> - <?php echo $quiz_info['fullname']; ?></h6>

<h5>Mô tả bài tập </h5>
<h6>
	<?php echo $quiz_info['intro']; ?>

	<p> Số lần được phép làm bài: <?php echo $quiz_info['attempts']==0 ? 'Không giới hạn' : $quiz_info['attempts'] ; ?></p>
	<p> Cách tính điểm :  <?php echo $grademethod; ?> </p>
	<p>Thời gian làm bài: <?php echo $quiz_info['timelimit']==0 ? 'Không giới hạn ' :$quiz_info['timelimit'].' phút'; ?></p>
</h6>
</div>

<div data-role="collapsible">
<?php 
echo "<h3>Thông tin các lần làm trước đây</h3>";
if($quiz_info['dalam']>0)

{

$sql="  select qa.*,vd.number_question sl from vietth_q169_attempts qa INNER join vietth_q169_de vd on vd.id = qa.ma_de   where qa.deleted !=1 and qa.userid = $uid  and qa.quiz =$qid ORDER BY qa.id asc"; 

     $result		=	mysql_query($sql);
	  echo '<table width="100%" cellspacing="1" border="1" cellpadding="5" style="border-collapse:collapse" >
             <tbody>
 <tr>      <th width="22%" > <h5>Lần làm bài </h5></th>	
  <th width="47%" ><h5>Được hoàn thành</h5></th>	
   <th width="16%" ><h5>Số câu đúng</h5></th>
  <th width="16%"><h5>Điểm / 10</h5></th></tr>
';
      $arr_grades = array();      $stt=0;
	  while($attepmts = mysql_fetch_array($result)) 
		 {            $stt++;		   	   		   
		 ?>
		<tr >
<td  style=" text-align:center;"><a href="quiz_attempt_review_mobile.php?attemptid=<?php echo $attepmts['id'];?>"><h5><?php echo $stt;?></h5></a></td>
<td style=" text-align:left;" ><h5><?php echo $attepmts['finishtime']=='' ? 'Không nộp bài' : date('H:i d/m/Y',strtotime($attepmts['finishtime'])) ;?></h5></td>
<td  style=" text-align:center;"><h5><?php echo $attepmts['corrects'];?>/<?php echo $attepmts['sl'] ?></h5></td>
<td  style=" text-align:center;"><h5><?php echo $attepmts['sumgrade'];$arr_grades[]=$attepmts['sumgrade']?></h5></td>
</tr>
		  <?php 
		 }
		echo '</tbody></table>';
switch ($quiz_info['grademethod'])
	 {
	  case 1 :
	     $gradefinal= max($arr_grades);
		 break;
	  case  2 :	
	     $grade = array_sum($arr_grades)/count($arr_grades);
         $gradefinal = round($grade,2);
		 break;
     }
	 echo '</div>';
	 echo '<h2 style="text-align:center"> '.$grademethod.' : <font style="color:#810c15">'.$gradefinal.' </font>điểm</h2>';
}

else
{
 echo '</div>';
	 echo '<h2 style="text-align:center">Chưa có lần làm bài nào.</h2>';
}

?>





<?php
$key=$_POST['key'];
if($quiz_info['password']!= $key)
{
if($key!='')
{
echo '<p style="color:red"> Khóa truy cập không đúng </p>';
}
echo'<p>Yêu cầu khóa truy cập</p>';
echo '<form name="khoa" method="POST" action ="">Khóa truy cập :<input type="password" name="key" id="key"><input type="submit" value="   Làm bài   "></form>';
}
else
{

?>
<form action="quiz_attempt_pr_mobile.php" method="get">

<input name="qid" value="<?php echo $quiz_info['id']; ?>" type="hidden">


<?php



if($quiz_info['attempts']==0 || ($quiz_info['attempts']>$quiz_info['dalam']))
{

if($quiz_info['dalam']>0)
 { 
 echo '<input value="Tiếp tục làm bài"  type="submit">';
 echo '<a  href="'.$_COOKIE['back_url'].'" data-role="button"   data-ajax="false">Quay lại</a>';
 }
 else
 {
 ?>
<input value="Bắt đầu làm bài" data-theme="b" onclick="return confirm('Bạn có muốn tiếp tục?');" type="submit">
<a  href="<?php echo $_COOKIE['back_url'];?>" data-role="button" data-ajax="false">Quay lại</a>

<?php
  }
}
else 
{
	echo 'Bạn đã hết lượt làm bài !';
	?>
	<a  href="<?php echo $_COOKIE['back_url'];?>" data-role="button" data-ajax="false">Quay lại</a>
<?php
}
?>

</form>

<?php
}

?>
<div style="clear:both"></div>
</div>

	<div data-role="footer" data-position="fixed" ><h5>Copyright © 2013 Topica. All Rights Reserved.</h5></div>
</div>

<?php
}
?>

</body></html>