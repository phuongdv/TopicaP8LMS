<?php
require_once("../config.php");
require_once("mail/class.phpmailer.php");
global $CFG,$USER, $QTYPES;
$week_id=$_REQUEST['w'];
$cid=$_REQUEST['c'];



$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
$dbname = $CFG->dbname;
mysql_select_db($dbname);

$sql = "SELECT r.id rid
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
$data = mysql_query($sql);
	while($info = mysql_fetch_array( $data )) 
     {
     	$roleid=$info['rid'];
     }	  
     
if($roleid!=4){
	   // echo '<script>alert(\'Rất tiếc, bạn không phải GVCM của lớp môn này !\');</script>';	
      	//echo '<script>window.location=\'index.php\'</script>';	
      	die('Rất tiếc, bạn không phải GVCM của lớp môn này !');
      	} 
$query_string = "Select c.fullname coursename,vt.*,r.id roleid,u.firstname,u.lastname,u.username,u.email,gvi.email_canhan,gvi.email_backup
FROM
	mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
INNER JOIN vietth_tam vt on vt.course=c.id
INNER join vietth_lien_he_gv gvi on gvi.taikhoanlms = u.username
WHERE r.id in (4,14)
and vt.id = $week_id";
	$data = mysql_query($query_string);
	while($info = mysql_fetch_array( $data )) 
     { 
     $coursename=$info['coursename'];
     $start=$info['startdate'];
	 $end=$info['enddate'];
	 $nhanxet=$info['nhanxet'];
	 $dinhhuong=$info['dh_tuantoi'];
	 $stttuan=$info['stttuan'];
	 $cardgv=$info['cardgv'];
	 $dh_nv=$info['dh_nv'];
	 
	 if($info['roleid']==4)
	  {
	  $gvcm=$info['lastname'].' '.$info['firstname'];
	  $gvcm_email=$info['email'];
	  
	  }
	 if($info['roleid']==14)
	  {
	  $gvhd=$info['lastname'].' '.$info['firstname'];
	  $gvhd_email=$info['email'];
	  $gvhd_email_cc1 = $info['email_canhan'];
	  $gvhd_email_cc2 = $info['email_backup'];
	// $gvhd_email='vietth@topica.edu.vn';
	  }
     }     

 if($stttuan>1)
 {
 $mail_content='Chào thầy/cô: <strong>'.$gvhd.'</strong><br />
Hiện tại thầy/cô đang là giảng viên hướng dẫn của course học:<strong> '.$coursename.'</strong><br />
1. Nhận xét về công việc của thầy/cô trong tuần qua ('.$start.'--'.$end.'):<br />
<div style="text-align:justify;padding-left:20px;padding-right:5px">
'.$nhanxet.'<br />
</div>
2. Định hướng công việc tuần tới<br />
<div style="text-align:justify;padding-left:20px;padding-right:5px">
'.$dinhhuong.'<br />
</div>
Chúc thầy/cô một tuần làm việc hiệu quả!<br />
<br />
GV chuyên môn:  '.$gvcm;	
 }
 elseif($stttuan==1)
 {
 	 $mail_content='Chào thầy/cô: <strong>'.$gvhd.'</strong><br />
Hiện tại thầy/cô đang là giảng viên hướng dẫn của course học:<strong> '.$coursename.'</strong><br />
1. Card giảng viên : <a href="http://elearning.tvu.topica.vn/tim/upload/'.$cardgv.'"> Xem file </a><br>
2. Định hướng và nhiệm vụ của course học:<br />
<div style="text-align:justify;padding-left:20px;padding-right:5px">
'.$dh_nv.'<br />
</div>
Chúc thầy/cô một tuần làm việc hiệu quả!<br />
<br />
GV chuyên môn:  '.$gvcm;	
 } 
$mail_content=$mail_content.'<br><em>Lưu ý : đây là mail tự động, vui lòng không reply mail này, chân thành cảm ơn.</em>';
send_mail('[TOPICA-TVU-TIM] Nhan xet va dinh huong cong viec GVHD',$gvhd_email,$mail_content,$gvhd_email_cc1,$gvhd_email_cc2,$gvcm,$gvcm_email,$gvhd);
$query_string = "update vietth_tam set emailsent = '1' where  id=$week_id";		
$data = mysql_query($query_string);	
echo 'Gửi mail thành công';	
echo '<script>window.opener.location.reload();self.close ();</script>';		 
function send_mail($subject='testmail',$sendto,$content='this a testmail',$cc1='',$cc2='',$fromname='Phong IS',$from='vietth',$receiver='')
{

	$mail             = new PHPMailer();
	$mail->CharSet = 'utf-8';
    $mail->IsSMTP();
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Host       = "ssl://smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "sender@topica.edu.vn";  // GMAIL username
	$mail->Password   = "topica2012";            // GMAIL password
	
	if($cc1!='')
	{
	$mail->AddCC($cc1,$receiver);
	}
	if($cc2!='')
	{
	$mail->AddCC($cc2,$receiver);
	}
	$mail->AddBCC('vietth@topica.edu.vn','Truong Huu Viet');
	//$mail->AddBCC('trungnt@topica.edu.vn','Nguyen Thanh Trung');
	// $mail->AddBCC('thaonp2@topica.edu.vn','Nguyen Phuong Thao');
    $mailTo=$sendto;
    $mail->AddReplyTo($gvcm_email,$fromname);
    $mail->From       = 'sender@topica.edu.vn'; 
    $mail->FromName   = 'TOPICA TVU - TIM';
    $mail->Subject    = $subject;
//$mail->Body       = "Hi,<br>This is the HTML BODY<br>";                      //HTML Body
//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    $mail->WordWrap   = 50; // set word wrap
    $mail->MsgHTML($content);
    $mail->AddAddress($mailTo,$receiver);
//$mail->AddAttachment("img/t_c.gif");             // attachment
    $mail->IsHTML(true); // send as HTML
    $mail->Send();
}
?>