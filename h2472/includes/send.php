<?php

session_start();
//Make sure that the input come from a posted form. Otherwise quit immediately

//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Toronto');

include("class.phpmailer.php");
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
$time=time();




$mail             = new PHPMailer();
$ipAdd 		= $_SERVER["REMOTE_ADDR"];
$loinhan=$_POST['message'];
$acc		= $_REQUEST['acc'];
$time		= $_REQUEST['time'];
$nguoinhan=$_POST['answer'];
$cc=$_POST['mailcc'];
$delay=$_POST['delay'];
$link       = $_POST['link'].'&a_id='.base64_encode($nguoinhan);
$noidung		= $_REQUEST['noidung'];
$nguoinhan=$_POST['answer'];
$thread=$_POST['thread'];
$from=$_POST['from'];
$ten=$_POST['name'];
$body             = "<p>"
					. "<fieldset style='border:1px solid #afe14c;margin: 5px 0;padding: 20px 10px'>"
					."<legend style='font: 700 14px Arial, Helvetica, sans-serif;padding: 0 5px;margin: 0 10px;color: #73b304'>Information</legend>"
					. "+ Message: <b>".$loinhan."</b><br><br>"
					. "+ <b>Please notice :<span style=\"color:red;\">Do not reply this e-mail</span></b><br><br>"
					. "+ From: <b>".$from."</b><br><br>"
					. "+ Student Account: <b>".$acc."</b><br><br>"
					. "+ Question time: <b> ".$time."</b><br><br>"
					. "+ Delay: <b> ".$delay."</b><br><br>"
					. "+ Answer link: <b> ".$link."</b><br><br>"
					. "+ <b><span style=\"color:red;\">Please click this link to answer </span></b><br><br>"
					. "+ Question name<b> :".$ten."</b><br>"
					."</fieldset>"
					. "<fieldset style='border:1px solid #afe14c;margin: 5px 0;padding: 20px 10px'>"
					."<legend style='font: 700 14px Arial, Helvetica, sans-serif;padding: 0 5px;margin: 0 10px;color: #73b304'>Content</legend>"
					.$noidung
					."</fieldset>"
					."</p>";
$body             = eregi_replace("[\]",'',$body);
$receiver="vietth.ctv@topica.edu.vn";
$mail->CharSet = 'utf-8';
$mail->IsSMTP();
$mail->SMTPAuth   = true;                  // enable SMTP authentication
//$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "ssl://smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "h2472support@topica.edu.vn";  // GMAIL username
$mail->Password   = "viet!@#$";            // GMAIL password
//$mail->AddCC('vietth@topica.edu.vn','truonghuuviet');
if($cc!='')
{
$mail->AddCC($cc,'truonghuuviet');
}
$mailTo=$nguoinhan;
//$mail->AddReplyTo("email@dohoavn.info","First Last");
$receiver=$nguoinhan;
$mail->From       = $email; 
$mail->FromName   = $name;

$mail->Subject    = "H2472: tra loi chu de so ".$thread." id :".$time;

//$mail->Body       = "Hi,<br>This is the HTML BODY<br>";                      //HTML Body
//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->WordWrap   = 50; // set word wrap

$mail->MsgHTML($body);

$mail->AddAddress($mailTo, $receiver);

//$mail->AddAttachment("img/t_c.gif");             // attachment

$mail->IsHTML(true); // send as HTML
sleep(1);


	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	  die;
	} else {
		
		$checkemail_sql="select count(u.id) count,u.id uid from mdl_user u,tblassign_role ra where u.email='".$nguoinhan."' and u.id=ra.userid";  
				$mailcheck_results = $db->sql_query($checkemail_sql);
			    
					while($mailcheck = $db->sql_fetchrow($mailcheck_results))
					{
					  $mail=$mailcheck['count'];
					  $assignid=$mailcheck['uid'];
					}
					if($mail==0)
					{
			      $sql_answer_update = "UPDATE  tblthread set status='3',assignid='4099'   where id='".$thread."'";
					}
		    else    
		    {
		       $sql_answer_update = "UPDATE  tblthread set status='3',assignid='".$assignid."'   where id='".$thread."'";	
		    }	
	    $sql_answer_update = $db->sql_query($sql_answer_update);
        
	    echo("<script>alert('E-mail has been sent đi');window.parent.location=window.parent.location.href;window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close()', 2000);</script>");
	    die;
	}

?>
