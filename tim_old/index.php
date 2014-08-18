
<?php
$cid=$_GET['c'];
require_once("../config.php");
include('nusoap/nusoap.php');
 
$url='http://forum.tvu.topica.vn/vietth/ws/tim.php?wsdl';
$client = new nusoap_client($url, 'wsdl');
$client->setCredentials("viet","123456","basic");
$err = $client->getError();
    if ($err) {
        // Display the error
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    }


# add check mode function
 
$sql_check_mode="select lcm.mode mode ,c.startdate startdate
from lipe_course_mode lcm 
INNER join mdl_course c 
on c.id = lcm.course 
where lcm.course=$cid";

global $CFG, $QTYPES;

$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
$dbname = $CFG->dbname;
mysql_select_db($dbname);

$mode_data= mysql_query($sql_check_mode);
while($info = mysql_fetch_array( $mode_data )) 
     { 
     $mode=$info['mode'];
	 $startdate=$info['startdate'];
     }     
if((($mode!=2 && $mode!=1 ) or intval($startdate) < 1336842000) and $cid!='')
   {
    echo '<script>alert(\'T.I.M chỉ áp dụng cho course có diễn đàn sau ngày 13-5-2012 - nếu bạn là PO xin vui lòng set mode 2 hoặc mode 1  trong LIPE và set startdate cho course học  !\');</script>';	
      	echo '<script>history.back();</script>';	
die();	
   }




$usehtmleditor = can_use_richtext_editor();
print_header("TIM ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
?>

<!-- Add jQuery library -->
	<script type="text/javascript" src="lightbox/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="lightbox/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="lightbox/jquery.fancybox.js?v=2.1.4"></script>
	<link rel="stylesheet" type="text/css" href="lightbox/jquery.fancybox.css?v=2.1.4" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="lightbox/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="lightbox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="lightbox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="lightbox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="lightbox/helpers/jquery.fancybox-media.js?v=1.0.5"></script>
<script>
$(document).ready(function() {
$('.fancybox').fancybox(
{'type':'iframe',
      helpers : {
        overlay : {
            locked : false
        }
    },
  padding : 0,
  height: '80%',
  width:830,
				   fitToView : false,
				   autoSize : false,
				   'scrolling' : 'no',
   afterClose: function() {
      parent.location.reload(true); 
    }
});
});

</script>
<?php

echo "<script src=\"vietth.js\"></script>";
require_login();
global $USER;

   

// ===================================  GET role =================================
if($cid!='')
{
$sql = "SELECT min(r.id) rid
 FROM
	mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE c.id=$cid
and
u.id=$USER->id
";
}
else 
{
$sql = "SELECT min(r.id) rid
 FROM
	mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
WHERE 
u.id=$USER->id
";
}

$data = mysql_query($sql);
	while($info = mysql_fetch_array( $data )) 
     {
     	$roleid=$info['rid'];
     }	   
	 

if($roleid=='4' or $roleid=='1')
{
  
	include('gvcm.php');
	
}
     
if($cid=='')
{
	print_footer($site); 
	die();
}
//==============================================================================

//================= kiem tra xem course nay da co du lieu trong bang tim chua ==

$sql="select count(*) count from vietth_tam where course='$cid'";
$data = mysql_query($sql);
	while($info = mysql_fetch_array( $data )) 
     {
     	$count=intval($info['count']);
     }	   
//===============================================================================


//====================== lay thong tin course ===================================
$query_string = "
select
	c.fullname fullname,
	FROM_UNIXTIME(c.startdate+24*3600,'%Y-%m-%d') start,
	FROM_UNIXTIME(c.startdate + (70*3600*24),'%Y-%m-%d') end,
	sl.active_id activeid 
from 
	mdl_course c,
	huy_setting_lipe sl 
where
	 c.id=$cid and 
	 c.id=sl.c_id and
	 sl.style='forum'";
	$data = mysql_query($query_string);
	while($info = mysql_fetch_array( $data )) 
     { 
     $coursename=$info['fullname'];
     $start=$info['start'];
     $forumid=$info['activeid'];
     $end  =$info['end'];
     }     
//===============================================================================
    
//================== neu chua co thi insert vao =================================
if($count < 8 && $cid!=0 && $cid!=1)
{  
	 // xoa cai cu neu co
	 	$sql="delete from vietth_tam where course=$cid";
	$insert = mysql_query($sql);
     // tinh toan ra ngay trong cac tuan
        $i=1;   
		$fDate = strtotime($start);
		//echo $fDate;
		$lDate = strtotime($end);
		$st = tinh_so_tuan ($fDate,$lDate);
		$me = $fDate;
		$wi = $st * 64 + 3;
		$we=0;
		$one_day = 60*60*24-30;
		$me = $fDate;
		$preSunday=strtotime('last Monday',$me);
		$str2 = date( "Y-m-d",$preSunday);
		if (date("N",$me) != 7){
		$me = strtotime('next Sunday',$me);
		$str3 = date( "Y-m-d",$me);
		} else {$str3 = date( "Y-m-d",$fDate);}
		
	// bat dau insert
	    // tuan dau tien hoi dac biet

	$sql="insert 
	into vietth_tam 
	(stttuan,course,startdate,enddate,timestamp) values ('$i','$cid','$str2','$str3',now())";
	
	$insert = mysql_query($sql);
	//echo $str2;// ngay dat dau tuan 1
	//echo $str3;// ngay ket thuc tuan 1


	    
		while ($me < $lDate && $TT<=7)
		{
		$TT=$i+1;
		$str1 = 'Tuần '.$TT;
		$me = strtotime('next Monday',$me);
		$dt = $me;
		$str2 = date( "Y-m-d",$me);
		$me = strtotime('next Sunday',$me);
		$ct = $me+$one_day;
			if($me < $lDate)
			{
				$str3 = date( "Y-m-d",$me);
			} else {
				$we = 1;
				$str3 = date( "Y-m-d",$lDate);
			}
		   
         	$sql="insert into vietth_tam (stttuan,course,startdate,enddate,timestamp) values ('$TT','$cid','$str2','$str3',now())";
         	$insert = mysql_query($sql);
			
			$i++;
			
		}	
     

	
}
//==================================================================================================
// neu da co du lieu trong bang tam roi
// lay ra ten course
//==================================================================================================
   $sql="select enddate ngaycuoi from vietth_tam where course=$cid order by stttuan desc limit 0,1";
   
   $data = mysql_query($sql);
	
	while($info = mysql_fetch_array( $data ))
	{
		$end=$info['ngaycuoi'];
	}
    echo '<div class="breadcrumb"><h2 class="accesshide ">Bạn đang ở đây</h2> <ul>
<li class="first"><a href="http://elearning.tvu.topica.vn/">TOPICA</a></li><li class="first"> <span class="accesshide ">/&nbsp;</span><span class="arrow sep">►</span><a href="http://elearning.tvu.topica.vn/course/view.php?id='.$cid.'">'.$coursename.'</a> </li><li class="first"> <span class="accesshide ">/&nbsp;</span><span class="arrow sep">►</span>TIM</li></ul></div>';

    echo '<div align="center" style="padding-top:50px"><a href="#today"><img title="Tiến trình học tập - Click vào đề đến tuần hiện tại" src="../lich/calendar.php?f='.$start.'&l='.$end.'"></a><br></div>';

    
    // ================== Lay thong tin  giang vien ===================================================
    $query_string = "Select c.fullname coursename,vt.*,r.id roleid,u.firstname,u.lastname,u.username,u.email
FROM
	mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
INNER JOIN vietth_tam vt on vt.course=c.id
WHERE r.id in (4,14)
and c.id = $cid";
	$data = mysql_query($query_string);
	while($info = mysql_fetch_array( $data )) 
     { 
     
	 
	 if($info['roleid']==4)
	  {
	  $gvcm=$info['username'];
	  }
	 if($info['roleid']==14)
	  {
	  $gvhd=$info['username'];
	 // $gvhd_email=$info['email'];
	
	  }
     }
    // ================================================================================================
    
    
    echo 'GVCM: '.$gvcm;
    echo '<br>GVHD: '.$gvhd.'<br><br>';
 
// lay ra thong tin cua cac tuan 
// tim tuan cuoi
   $sql="select MAX(stttuan) tuancuoi from vietth_tam where course=$cid";
   $data = mysql_query($sql);
	
   // in bang
   
   ?>
   <div id="float" style=" -moz-background-inline-policy: continuous;
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #E7E7E7;
    font-weight: bold;
    height: 240px;
    position: fixed;
    right: 0;
    text-align: center;
    top: 125px;
    width: 24px;"><a href="http://elearning.tvu.topica.vn/course/view.php?id=<?php echo $cid;?> target="_blank"><img src="http://forum.tvu.topica.vn/images/topica/buttons/quay%20lai%20lop%20hoc.jpg"></a><a><br></a><a href="http://forum.tvu.topica.vn/forum.php?f=<?php echo $forumid;?>" target="_blank"><img src="diendan.jpg"></a><a></a></div>
   <table width="100%" border="0">
   <?php
   if($roleid==211)
    {
   	echo'<div align="center"><a name="today"  href="javascript:void(0)"
onclick="window.open(\'edit_startdate.php?c='.$cid.'\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')">Nhấn vào đây để sửa ngày bắt đầu</a></div>';
    } 	
   
	while($info = mysql_fetch_array( $data ))
	{
		$tuancuoi=$info['tuancuoi'];
	}
   
   $query_string = "select * from vietth_tam where course=$cid order by stttuan asc";
   $data = mysql_query($query_string);

	while($info = mysql_fetch_array( $data )) 
     { 
      
      if($info['stttuan']=='1')
      {
      	echo  '
      	<tr valign="top"  style="border:solid 1px #cccccc">
    	<td width="3%" height="254" bgcolor="#CCCCCC">&nbsp;</td>
    	<td  width="65%"><p><font size="3"><span style="font-weight: bold;">';
      	if(checktoday($info['startdate'],$info['enddate'])){
    	echo '<a name="today"></a>';
    	}
      	echo 'Tuần '.$info['stttuan'].' ('.$info['startdate'].' - '.$info['enddate'].')</span></font>:</p>
   		<p style="color:#810c15;font-weight:bold">Card giảng viên:
   		'; 
      	//if($roleid==4 && checktoday($info['startdate'],$info['enddate'])){
		if(($roleid==4 ||  $roleid==13 || $roleid==211)&& checkfirstday($info['enddate'])){
			echo'<a name="today" class="fancybox"  href="edit.php?w='.$info['id'].'&f=3"><img src="edit.png" title ="Nhấn vào đây để sửa"></a>';
      	
		/*
      	echo'<a name="today"  href="javascript:void(0)"
onclick="window.open(\'edit.php?w='.$info['id'].'&f=3\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')"><img src="edit.png" title ="Nhấn vào đây để sửa"></a>';
*/      
	  } 
		
   		 echo '
   		 </p>';
   		 if($info['cardgv']!='')
   		 {
   		 echo'
   		File :<a href="upload/'.$info['cardgv'].'" target="_blank">PSP492 Card giảng viên</a>';
   		 }
   		 echo'
        <p style="color:#810c15;font-weight:bold">Nhiệm vụ toàn khóa học và định hướng công việc tuần 2: 
        '; 
      	if($roleid==4 && checkfirstday($info['enddate'])){
      		echo'<a name="today" class="fancybox"  href="edit.php?w='.$info['id'].'&f=6"><img src="edit.png" title ="Nhấn vào đây để sửa"></a>';
  /*			
      	echo'<a  href="javascript:void(0)"
onclick="window.open(\'edit.php?w='.$info['id'].'&f=6\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')"><img src="edit.png" title ="Nhấn vào đây để sửa"></a>';
*/
      	} 
   		 echo '  
    <br></p>
        <div id="dh_nv_out" style="text-align:justify;padding-left:20px; padding-right:10px;font-size:9pt">
        '.$info['dh_nv'].'
        </div>';
		echo '<p style="color:#810c15;font-weight:bold">GVHD phản hồi:'; 
		if($roleid == 14)
		{
			echo'<a name="today" class="fancybox"  href="feedback.php?w='.$info['id'].'&f=8"><img src="edit.png" title ="Nhấn vào đây để sửa"></a>';
        /*
		echo'<a  href="javascript:void(0)"
onclick="window.open(\'feedback.php?w='.$info['id'].'&f=8\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')"><img src="edit.png" title ="Nhấn vào đây để sửa"></a></p>';
*/
		}
		 echo '  
        <div id="dh_nv_out" style="text-align:justify;padding-left:20px;padding-right:10px;font-size:9pt">
        '.$info['phanhoigvhd'].'
        </div>';
		
		
      	echo '
        </div>
        </td>
        <td  width="30%">
        '.demsopost($forumid,$info['startdate'],$info['enddate'],$gvhd);
		if($info['emailsent']!=1 && $roleid==4 && checkfirstday($info['enddate']))
		{
		echo'<a name="today" class="fancybox"  href="sendmail.php?w='.$info['id'].'&c='.$cid.'"><img src="mail.png">Gửi email tới GVHD</a>';
		/*
		echo '<div style="margin-bottom:0px"><br><br><hr><br><a style="font-weight:bold;color:#810c15" href="javascript:void(0)"
onclick="window.open(\'sendmail.php?w='.$info['id'].'&c='.$cid.'\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')" href=""><img src="mail.png">Gửi email tới GVHD</a></div>';
   */
		}
		else if($info['emailsent']==1 && $roleid==4)
		{
		echo '<div style="margin-bottom:0px"><br><br><hr><br>Đã gửi E-mail cho GVHD </div>';
		}

		echo'
        </td>
        
        </td>
  		<td width="2%" bgcolor="#CCCCCC">'.checktoday($info['startdate'],$info['enddate']).'</td>
             </tr>
              <tr>
    <td colspan="3"><hr /></td>
 			 </tr>
             
             ';

        
       // print_textarea($usehtmleditor, 15, 40, 400, 300, 'content',$info['dh_nv']);
       // if ($usehtmleditor) {
        //use_html_editor();
    	//}

      	
      }
      else if($info['stttuan']==$tuancuoi)
      {
      
      	 echo '<tr valign="top"   style="border:solid 1px #cccccc">
    <td width="3%" height="254" bgcolor="#CCCCCC">&nbsp;</td>
    <td width="65%" ><p><font size="3"><span style="font-weight: bold;">';
    if(checktoday($info['startdate'],$info['enddate'])){
    	echo '<a name="today"></a>';
    }  	 
   echo'Tuần '.$info['stttuan'].' ('.$info['startdate'].' - '.$info['enddate'].')</span></font>:
    <p style="color:#810c15;font-weight:bold">Nhận xét công việc trong tuần của GVHD:'; 
      	if($roleid==4 && checktoday($info['startdate'],$info['enddate'])){
		
		echo'<a name="today" class="fancybox"  href="edit.php?w='.$info['id'].'&f=7"><img src="edit.png" title ="Nhấn vào đây để sửa"></a>';
		/*
      	echo'<a name="today" href="javascript:void(0)"
onclick="window.open(\'edit.php?w='.$info['id'].'&f=7\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')"><img src="edit.png" title ="Nhấn vào đây để sửa"></a></p>';
        */
      	}
  
     
  		
   		 echo '</p>
     <div style="text-align:justify;padding-left:20px;padding-right:5px">
    '.$info['tongket'].'
    </div>';
	
	echo '<p style="color:#810c15;font-weight:bold">GVHD phản hồi:'; 
		if($roleid == 14)
		{
		
		echo'<a  href="javascript:void(0)"
onclick="window.open(\'feedback.php?w='.$info['id'].'&f=8\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')"><img src="edit.png" title ="Nhấn vào đây để sửa"></a></p>';
		}
		 echo '  
        <div id="dh_nv_out" style="text-align:justify;padding-left:20px;padding-right:10px;font-size:9pt">
        '.$info['phanhoigvhd'].'
        </div>';
	
	echo '  	
    </td>
      <td  width="30%">
        '.demsopost($forumid,$info['startdate'],$info['enddate'],$gvhd);
		if($info['emailsent']!=1 && $roleid==4 && checktoday($info['startdate'],$info['enddate']))
		{
		echo'<a name="today" class="fancybox"  href="sendmail.php?w='.$info['id'].'&c='.$cid.'"><img src="mail.png">Gửi email tới GVHD</a>';
		/*
		echo '<div style="margin-bottom:0px"><br><br><hr><br><a style="font-weight:bold;color:#810c15" href="javascript:void(0)"
onclick="window.open(\'sendmail.php?w='.$info['id'].'&c='.$cid.'\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')" href=""><img src="mail.png">Gửi email tới GVHD</a></div>';
        */
		}
		else if($info['emailsent']==1 && $roleid==4)
		{
		echo '<div style="margin-bottom:0px"><br><br><hr><br>Đã gửi E-mail cho GVHD </div>';
		}
		
		
		
		
		echo'
        </td>
    <td width="2%" bgcolor="#CCCCCC">'.checktoday($info['startdate'],$info['enddate']).'</td>
             </tr>
             <tr>
    <td colspan="3" bgcolor="#FF5E5E" align="center" style="color:#fff">KẾT THÚC LỚP HỌC ONLINE</td>
  </tr>
             
             ';
      	
      	
      	
      }
      else 
      {
      	
      		echo ' <tr valign="top"   style="border:solid 1px #cccccc">
    <td width="3%" height="254" bgcolor="#CCCCCC">&nbsp;</td>
    <td width="65%"  ><p><font size="3"><span style="font-weight: bold;">';
    if(checktoday($info['startdate'],$info['enddate'])){
    	echo '<a name="today"></a>';
    }
    
    echo 'Tuần '.$info['stttuan'].' ('.$info['startdate'].' - '.$info['enddate'].')</span></font>:</p>
    <p style="color:#810c15;font-weight:bold">Nhận xét công việc trong tuần của GVHD :'; 
      	if($roleid==4 && checktoday($info['startdate'],$info['enddate'])){
		
			echo'<a name="today" class="fancybox"  href="edit.php?w='.$info['id'].'&f=5"><img src="edit.png" title ="Nhấn vào đây để sửa"></a>';

		/*
      	echo'<a href="javascript:void(0)"
onclick="window.open(\'\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')"><img src="edit.png" title ="Nhấn vào đây để sửa"></a>';
      */
      	} 
   		 echo '</p>
     <div style="text-align:justify;padding-left:20px;padding-right:5px">
    '.$info['nhanxet'].'
    </div>
        <p style="color:#810c15;font-weight:bold">Định hướng công việc tuần tới: '; 
      	if($roleid==4 && checktoday($info['startdate'],$info['enddate'])){
		
		echo'<a name="today" class="fancybox"  href="edit.php?w='.$info['id'].'&f=4"><img src="edit.png" title ="Nhấn vào đây để sửa"></a>';
		/*
      	echo'<a href="javascript:void(0)"
onclick="window.open(\'edit.php?w='.$info['id'].'&f=4\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')" ><img src="edit.png" title ="Nhấn vào đây để sửa"></a>';
     */
      	} 
   		 echo '</p>
         <div style="text-align:justify;padding-left:20px;padding-right:5px">
        '.$info['dh_tuantoi'].'
        </div>';
        echo '<p style="color:#810c15;font-weight:bold">GVHD phản hồi:'; 
		if($roleid == 14)
		{
		
		echo'<a  href="javascript:void(0)"
onclick="window.open(\'feedback.php?w='.$info['id'].'&f=8\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')"><img src="edit.png" title ="Nhấn vào đây để sửa"></a></p>';
		}
		 echo '  
        <div id="dh_nv_out" style="text-align:justify;padding-left:20px;padding-right:10px;font-size:9pt">
        '.$info['phanhoigvhd'].'
        </div>';
    echo '</td>
    <td  width="30%">
        '.demsopost($forumid,$info['startdate'],$info['enddate'],$gvhd);
		if($info['emailsent']!=1 && $roleid==4 && checktoday($info['startdate'],$info['enddate']))
		{
		echo'<a name="today" class="fancybox"  href="sendmail.php?w='.$info['id'].'&c='.$cid.'"><img src="mail.png">Gửi email tới GVHD</a>';
		/*
		echo '<div style="margin-bottom:0px"><br><br><hr><br><a style="font-weight:bold;color:#810c15" href="javascript:void(0)"
onclick="window.open(\'sendmail.php?w='.$info['id'].'&c='.$cid.'\',
\'welcome\',\'width=800,height=400,menubar=yes,status=yes\')" href=""><img src="mail.png">Gửi email tới GVHD</a></div>';
*/
		}
		else if($info['emailsent']==1 && $roleid==4)
		{
		echo '<div style="margin-bottom:0px"><br><br><hr><br>Đã gửi E-mail cho GVHD </div>';
		}
		
		
		
		
		echo'
        </td>
    <td width="2%" bgcolor="#CCCCCC"></td>
             </tr>
              <tr>
    <td colspan="3"><hr /></td>
  </tr>
             
             ';
      	
      	
      }
       
     }     
    
    ?>
    
    </table>
    
    <?php
    
    
    




function tinh_so_tuan ($fDate,$lDate)
{
$td = 8 - date("N",$fDate);
$tc = date("N",$lDate) - 0;
$one_day = 60*60*24;
$h = ($lDate - $fDate + $one_day ) / $one_day;
$giua = $h - $td - $tc;
$st = $giua/7 + 2;
return $st;
}    
      

// thong ke forum

function demsopost($activeid,$start,$end,$user='')
{
    global $client;
                        $method = 'tim_dem_so_post';
                        $params = array('activeid' =>$activeid,'start'=>$start,'end'=>$end,'user'=>$user);                        
                        $result = $client->call($method,$params);
                         $err = $client->getError();
    if ($err) {
        // Display the error
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    }
                        return $result;
                        
 }


function checkfirstday($start)
{
	$todays_date 	=	 date("Y-m-d");
	$today 			=	 strtotime($todays_date);
	$startdate		=	 strtotime($start);
	
	if($today <= $startdate)
	{
		return true;
	}
	else 
	{
	//	return false;
	// turn on all
	return true;
	}
}



function checktoday($start,$end)
{
	$todays_date 	=	 date("Y-m-d");
	$today 			=	 strtotime($todays_date);
	$enddate		=	 strtotime($end);
	$startdate		=	 strtotime($start);
	if($today>=$startdate && $today <= $enddate)
	{
		return true;
	}
	else 
	{
	//	return false;
	// turn on all
	return false;
	}
}


?>

<a class="fancybox" href="http://elearning.tvu.topica.vn/" title="Lorem ipsum dolor sit amet">Inline</a></li>

<?php
print_footer($site); 
?>