<?
class EmailSubcribe extends dbBasic{
	
	function EmailSubcribe(){
		$this->pkey = "mail_id";
		$this->tbl = "email_subcribe";
	}
	
	function checkEmailSubcribeExists($email) {
		$existed = 0;
		
		$arrOneCheck = $this->getByCond("email='".$email."'");
		if(is_array($arrOneCheck) && count($arrOneCheck)>0)
			$existed = 1;
			
		return $existed;
	}		
	
	function sendMail($to, $content) {
		$is_send = 0;
		$subject = 'Welcome Babyvina.com News Letter';
		$from = "info@babyvina.com";	
		$message = '';		
		$message .= $content;
		$message .= "<br>=======================================================================
					<br>Welcome Co., Ltd.
					<br>Office Address: D6, Song Da 10 Area, Phung Hung Street, Ha Dong, Ha Noi.
					<br>Tel:(+84) 33.547.800
					<br>Ym: mainguyen2020
					<br>Hotline 24/7: 094.238.1333 
					";			
		$headers = 	"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=utf-8\r\n".
					"From:  <".$from.">\r\n".
					"To:  <".$to.">\r\n".
					"Subject: ".$subject."\r\n";
		if($to != "")
			$is_send = (@mail($to, $subject, $message, $headers))? 1 : 0;
		
		return $is_send;
	}

}
?>