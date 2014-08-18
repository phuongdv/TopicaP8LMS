<?php
require_once("../../config.php");global $CFG;require_once($CFG->libdir.'/phpmailer51/class.phpmailer.php');
$attempt = required_param('attempt', PARAM_INT);
$question = required_param('question', PARAM_INT);
$course = required_param('course', PARAM_INT);
$username = required_param('username', PARAM_TEXT);
$fullname = required_param('name', PARAM_TEXT);
$qname = required_param('qname', PARAM_TEXT);
$email = required_param('email', PARAM_TEXT);
$content = $_POST['content'];
require_login();


// bo dau tieng viet


function botiengviet($str)
{
	$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
	"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
	,"ế","ệ","ể","ễ",
	"ì","í","ị","ỉ","ĩ",
	"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
	,"ờ","ớ","ợ","ở","ỡ",
	"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
	"ỳ","ý","ỵ","ỷ","ỹ",
	"đ",
	"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
	,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
	"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
	"Ì","Í","Ị","Ỉ","Ĩ",
	"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
	,"Ờ","Ớ","Ợ","Ở","Ỡ",
	"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
	"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
	"Đ");

	$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
	,"a","a","a","a","a","a",
	"e","e","e","e","e","e","e","e","e","e","e",
	"i","i","i","i","i",
	"o","o","o","o","o","o","o","o","o","o","o","o"
	,"o","o","o","o","o",
	"u","u","u","u","u","u","u","u","u","u","u",
	"y","y","y","y","y",
	"d",
	"A","A","A","A","A","A","A","A","A","A","A","A"
	,"A","A","A","A","A",
	"E","E","E","E","E","E","E","E","E","E","E",
	"I","I","I","I","I",
	"O","O","O","O","O","O","O","O","O","O","O","O"
	,"O","O","O","O","O",
	"U","U","U","U","U","U","U","U","U","U","U",
	"Y","Y","Y","Y","Y",
	"D");
	return str_replace($marTViet,$marKoDau,$str);
}


//

print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
//print_r($_POST);
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
	$mysqli->query("SET NAMES 'utf8'");
	$query_string = "insert into `tp_question_fb`(`attempt`,`question`,`course`,`username`,`fullname`,`content`,`time`) values ($attempt,$question,$course,'$username','$fullname','$content',now())";
//	echo $query_string;die;
	$mysqli->query($query_string);
	$suc  = $mysqli->affected_rows;
	
//  add to ccms
    # oprn connect ;
     mysql_connect("122.201.15.15:3306", "vietth", "viet5%");
     mysql_select_db("ccms");
    # sql

    $attempt=intval($attempt)-1;
    $link_quiz='http://elearning.hou.topica.vn/mod/quiz/review.php?attempt='.$attempt.'&err='.$question.'#err';
    $sql="INSERT INTO tblthread (answername, answerdes,time,status,monhoc,loaisp,version,nguoiyeucau,email,source,questionlink)
		  VALUES ('Chưa biết - báo lỗi câu hỏi trắc nghiệm ','$content','".time()."','Mới','Chưa biết','Câu hỏi trắc nghiệm','1.0','$username','$email','LMSTHO','$link_quiz')"; 
		  
    #query
    mysql_query("SET NAMES utf8"); 
    $data = mysql_query($sql); 
    print_r($data);
	
	die();
    
//	
	
// send mail to nguoi quan ly				
	$mail             = new PHPMailer();
	$body="Học viên: <strong>".$username."</strong> - địa chỉ e-mail: ".$email."<br>Phản hồi về lỗi trong câu hỏi trắc nghiệm <strong>Q".$qname."</strong> Course: <a href=\"http://elearning.hou.topica.vn/course/view.php?id=".$course."\">".$fullname."</a> <br> với nội dung:<br><strong>\"".$content."\"</strong><br><br><br> Thư được gửi tự động từ hệ thống moodle elearning elearning.hou.topica.vn";
	$mail->IsSMTP(); // telling the class to use SMTP				
	$mail->Host       = "mail.yourdomain.com"; // SMTP server				
	$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)											
	
	$mail->SMTPAuth   = true;                  // enable SMTP authentication				
	$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier				
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server				
	$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "quiziq@topica.edu.vn";  // GMAIL username				
	$mail->Password   = "topica@123";            // GMAIL password				
	$mail->SetFrom('name@yourdomain.com', 'Quiz feedback');				
	$mail->AddReplyTo("name@yourdomain.com","Quiz feedback");				
	$mail->Subject    = "Hoc vien: ".$username." - phan hoi ve loi cau hoi trac nghiem: Q".$qname." Course: ".$fullname;				
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test				
	$mail->MsgHTML($body);				
	$address = "quiziq@topica.edu.vn";				
	$mail->AddAddress($address, "");								
	if(!$mail->Send()) 
	{				  
	echo "Mailer Error: " . $mail->ErrorInfo;				
	} 
	else 
	{				  
	//echo "Message sent!";				
	}
	// send mail to hoc vien
	  $std_mail             = new PHPMailer();
	$body='
	
	Than chao anh / chi: '.$username.'<br></div><div class="im">Gop y cua anh chi voi noi dung sau:<br><br>

Hoc vien: '.$username.' - dia chi email: <a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br>
Phan hoi ve loi trong cau hoi trac nghiem Q'.$question.' Course: '.$fullname.'<br>
voi noi dung:<br><b>
"'.botiengviet($content).'"</b><br><br>

Gop y cua anh/chi da duoc gui toi To Bo Mon de xu ly. Anh/chi vui long theo doi tien trinh xu ly gop y nay tai box "Gop y - Bao loi cau hoi trac nghiem truc tuyen" tren dien dan tai: http://forum.hou.topica.vn/forumdisplay.php?f=1355. De tien theo doi, anh/chị nen su dung chuc nang "Tim kiem trong chuyen muc", tim theo tai khoan cua minh hoac theo ma mon hoc. <br>Chuc anh/chi nhieu suc khoe va hoc tap tot.

Vui long khong tra loi email nay.<br>
<hr>

		
Thân chào anh/chị '.$username.'<br></div><div class="im">Góp ý của anh/chị với nội dung sau:<br><br>
Học viên: '.$username.' - địa chỉ e-mail: <a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br>
Phản hồi về lỗi trong câu hỏi trắc nghiệm Q'.$question.' Course: '.$fullname.'<br>
với nội dung:<br><b>
"'.$content.'"</b><br><br>

Góp ý của anh/chị đã được gửi tới Tổ Bộ Môn để xử lý. Anh/chị vui lòng theo dõi tiến trình xử lý góp ý này tại box "Góp ý - Báo lỗi câu hỏi trực tuyến" trên diễn đàn tại: <a href="http://forum.hou.topica.vn/forumdisplay.php?f=1355" target="_blank">http://forum.hou.topica.vn/<u></u>for<wbr>umdisplay.php?f=1355</a>. Để tiện theo dõi, anh/chị nên sử dụng chức năng "Tìm kiếm trong chuyên mục", tìm theo tài khoản của mình hoặc theo mã môn học.
Chúc anh/chị nhiều sức khỏe và học tập tốt.<br><br>

Vui lòng không trả lời email này.


';
	$std_mail->IsSMTP(); 				
	$std_mail->SMTPDebug  = 0;					
	$std_mail->SMTPAuth   = true;               
	$std_mail->SMTPSecure = "ssl";                
	$std_mail->Host       = "smtp.gmail.com";     
	$std_mail->Port       = 465;                   
	$std_mail->Username   = "quiziq@topica.edu.vn";  
	$std_mail->Password   = "topica@123";           	
	$std_mail->SetFrom('quiziq@topica.edu.vn', 'Quiz feedback');				
	$std_mail->AddReplyTo("quiziq@topica.edu.vn","Quiz feedback");				
	$std_mail->Subject    = "Topica: phan hoi ve loi cau hoi trac nghiem: Q".$question." Course: ".$fullname." cua hoc vien ".$username."";						
	$std_mail->MsgHTML($body);	
   // $std_mail->AddCC('vietth@topica.edu.vn','Truong Huu Viet');	
	$address = $email;				
	$std_mail->AddAddress($address, $username);								
	 if(!$std_mail->Send()) 
	{				  
	echo "Mailer Error: " . $std_mail->ErrorInfo;				
	} 
	
	
	
	// finnish mail			
	echo '<center>Ý kiến của bạn đã được tiếp nhận<br><A href="javascript: self.close ()">Đóng lại</A></center>';
	$mysqli->close();

print_footer($site); 
?>