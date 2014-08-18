<?php
require_once("../../config.php");
global $CFG;
require_once($CFG->libdir.'/phpmailer51/class.phpmailer.php');
$id = required_param('id', PARAM_INT);
$c = required_param('c', PARAM_INT);
$a = optional_param('a',0, PARAM_INT);
$ac = required_param('ac', PARAM_INT);require_login();	
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);	
$mysqli->select_db($CFG->dbname);	$mysqli->query("SET NAMES 'utf8'");
	$query_string = "update tp_question_fb set complete=$ac where id=$id";	
	$mysqli->query($query_string);	
	$suc  = $mysqli->affected_rows;    
	if($ac==1)	 
	{	  
	$query_string="SELECT u.email email,tqf.*,UNIX_TIMESTAMP(time) as u_time FROM tp_question_fb tqf, mdl_user u where u.username=tqf.username and course = $c";
	$ad = $mysqli->query($query_string);	
	while($dd = $ad->fetch_assoc())        
	{		 
    $mail             = new PHPMailer();
	$body='Thân chào anh/chị '.$dd["username"].'<br></div><div class="im">Góp ý của anh/chị với nội dung sau:<br><br>

Học viên: '.$dd["username"].' - địa chỉ e-mail: <a href="mailto:'.$dd["email"].'" target="_blank">'.$dd["email"].'</a><br>
Phản hồi về lỗi trong câu hỏi trắc nghiệm Q'.$dd["question"].' Course: '.$dd["fullname"].'<br>
với nội dung:<br><b>
"'.$dd["content"].'"</b><br><br>


Thư được gửi tự động từ hệ thống moodle elearning <a href="http://elearning.hou.topica.vn/" target="_blank">elearning.hou.topica.vn</a><br><br></div>Đã được chúng tôi kiểm tra và xử lý. Anh/chị vui lòng theo dõi tiến trình xử lý góp ý này tại box "Góp ý - Báo lỗi câu hỏi trực tuyến" trên diễn đàn, tại đây: <a href="http://forum.hou.topica.vn/forumdisplay.php?f=1355" target="_blank">http://forum.hou.topica.vn/<wbr>forumdisplay.php?f=1355</a>.
Để tiện theo dõi, anh/chị nên sử dụng chức năng "Tìm kiếm trong chuyên mục", tìm theo tài khoản của mình, theo mã môn học hoặc theo mã course.<div class="im"><br><br>
Chúc anh/chị nhiều sức khỏe và học tập tốt.<br>

Vui lòng không trả lời email này.


';
	$mail->IsSMTP(); 				
	$mail->SMTPDebug  = 0;					
	$mail->SMTPAuth   = true;               
	$mail->SMTPSecure = "ssl";                
	$mail->Host       = "smtp.gmail.com";     
	$mail->Port       = 465;                   
	$mail->Username   = "quiziq@topica.edu.vn";  
	$mail->Password   = "topica@123";           	
	$mail->SetFrom('quiziq@topica.edu.vn', 'Quiz feedback');				
	$mail->AddReplyTo("quiziq@topica.edu.vn","Quiz feedback");				
	$mail->Subject    = "Topica: phan hoi ve loi cau hoi trac nghiem: Q".$dd["question"]." Course: ".$dd["fullname"]." cua hoc vien ".$dd["username"]." (cau hoi da duoc To Bo Mon xu ly xong)";						
	$mail->MsgHTML($body);				
	$address = $dd["email"];				
	$mail->AddAddress($address, $dd["username"]);								
	 if(!$mail->Send()) 
	{				  
	echo "Mailer Error: " . $mail->ErrorInfo;				
	} 
	

	}     
	}	
	$mysqli->close();
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'rp_view.php?c='.$c.'&all='.$a;	
	header("Location: http://$host$uri/$extra");
	exit;?>'