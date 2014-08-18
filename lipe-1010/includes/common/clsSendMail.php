<?
/**
*  Send Mail with multi attachments
*  modifier		: Vu Quoc Trung  (vuquoctrung@gmail.com)
*  @date		: 25/11/2006
*  @version		: 1.0.0
*/
class VnSendMail{
	var	$sender_name = "";
	var $sender_addr = "";
	var $recipient_name = "" ;
	var $recipient_addr = "";
	var $reply_to = "";
	var $cc = "";
	var $bcc = "";
	var $subject = "";
	var $message = "";
	var $extra_headers = '';
	var $attachments = array();
	var $hasattach = 0;//0:no, 1:yes
	var $priority = 3;//1:hight, 3:normal, 5:low
	var $ishtml = 0;//0=text, 1=html
	var $xmailer = "VNNC Mailer 1.0.0";
	var $encoding = 'utf-8';//windows-1252, windows-1251, iso8859-5, iso8859-1
	var $debug = 1;//0:no show, 1: show
	var $boundary;
	var $headers = "";
	var $body = "";
	var $messageId = "";
	/**
	 * Init class
	 */
	function VnSendMail($_encoding="utf-8"){
		if ($_encoding!=""){
			$this->encoding = $_encoding;
		}
	}	
	/**
	 * Set encoding
	 */
	function setEncoding($_encoding){
		$this->encoding = $_encoding;
	}
	/**
	 * Set from address
	 */
	function setFrom($email="", $name=""){
		if ($this->validEmail($email)){
			$this->sender_addr = $email;
			$this->sender_name = $name;
		}else{
			$this->setError("Email From:$email is not correctly formatted",  "WARNING");
		}
	}	
	/**
	 * Set to address
	 */
	function setTo($email="", $name=""){
		if ($this->validEmail($email)){
			$this->recipient_addr = $email;
			$this->recipient_name = $name;
		}else{
			$this->setError("Email To:$email is not correctly formatted",  "WARNING");
		}
	}
	/**
	 * Set reply-to address
	 */
	function setReplyTo($email){
		if ($this->validEmail($email)){
			$this->reply_to = $email;
		}else{
			$this->reply_to = $this->sender_addr;
			//$this->setError("Email Reply-To:$email is not correctly formatted",  "WARNING");
		}
	}
	/**
	 * Set content-type
	 */	
	function setEmailType($type="text"){
		switch (strtolower($type)) {
			case "text":
				$this->ishtml = 0;
				break;
			case "html":
				$this->ishtml = 1;
				array_push($this->action_msgs,"Message body set to html");
				break;
			default:
				$this->ishtml = 0;
				break;
		}
	}
	/**
	 * Set CC
	 */	
	function setCC($_cc=""){
		$this->cc = $_cc;
	}
	/**
	 * Set BCC
	 */	
	function setBCC($_bcc=""){
		$this->bcc = $_bcc;
	}
	/**
	 * Set priority
	 */	
	function setPriority($_priority="normal"){
		switch (strtolower($_priority)){
			case "hight"	: 	$this->priority = 1; break;
			case "normal"	:	$this->priority = 3; break;
			case "low"		:	$this->priority = 5; break;
			default 		:	$this->priority = 3; break;
		}
		if (in_array($_priority, array(1,3,5))){
			$this->priority = $_priority;
		}
	}
	/**
	 * Set extra_headers
	 */	
	function setExtraHeader($_extra_headers=""){
		$this->extra_headers = $_extra_headers;
	}
	/**
	 * Set xmailer
	 */	
	function setXmailer($_xmailer=""){
		$this->xmailer = $_xmailer;
	}
	/**
	 * Set subject
	 */	
	function setSubject($_subject) {
		$this->subject = $_subject;
	}
	/**
	 * Set message
	 */	
	function setMessage($_message) {
		$this->message = $_message;
	}
	/**
	 * Set error
	 */	
	function setError($msg, $type="WARNING"){
		if ($this->debug){
			switch ($type){
				case  "WARNING"	:	trigger_error($msg, E_USER_WARNING); break;
				case  "ERROR"	:	trigger_error($msg, E_USER_ERROR); break;
			}
		}
	}
	/**
	 * Set debug
	 */	
	function setDebug($_debug){
		$this->debug = $_debug;
	}
	/**
	 * Set message
	 */	
	function validEmail($str)
	{
		if (ereg("^[A-Za-z0-9_\.\-]+@[A-Za-z0-9_\.\-]+\.[A-Za-z0-9_\-][A-Za-z0-9_\-]+$", $str, $result))
			return true;		
		return false;
	}
	/**
	 * Get content of file
	 */	
	function get_file($filename){ 
		if ($fp = fopen($filename, 'rb')) { 
			$ret = fread($fp, filesize($filename)); 
			fclose($fp); 
			return $ret; 
		} else {
			return 0;
		}
	}
	/**
	 * Add attachment file
	 */	
	function addAttachment($aname, $location, $mimetype="application/octetstream"){
		if (function_exists('mime_content_type')){
			$vmime = mime_content_type($location);
		}
		if (file_exists($location)){
			if (is_readable($location)){
				$toarray = $aname;
				$toarray .= ",";
				$toarray .= $location;
				$toarray .= ",";
				$toarray .= $mimetype;
				array_push($this->attachments, $toarray);
				$this->hasattach++;
			}else{
				$this->setError("Attachment: ".$location." could not be read", "WARNING");
			}
		}else{
			$this->setError("No file name specified for attachment",  "WARNING");
		}
	}
	function buildMessageId(){
		$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$messageId = md5(time().$this->sender_addr.$this->recipient_addr.$hostname);
		$this->messageId = $messageId."@".$hostname;
		return $messageId;	
	}
	/**
	 * Build Header
	 */
	function buildHeader($savefile=false){
		if ($this->messageId==""){
			$this->buildMessageId;
		}
		$this->boundary = '=_NextPart_'.md5(uniqid(rand()).microtime());
		$boundary = $this->boundary;
		$headers = "";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Message-ID: <".$this->messageId.">\r\n";
		$headers .= "Date: ". date("r",time())."\r\n";
		$headers .= "From: ".$this->sender_name."<".$this->sender_addr.">\r\n";
		$headers .= "To: ".$this->recipient_name."<".$this->recipient_addr.">\r\n";
		if ($savefile){
			$headers .= "Subject: ".$this->subject."\r\n";		
		}
		if ($this->cc!=""){
			$headers .= "CC: ".$this->cc."\r\n";
		}
		if ($this->bcc!=""){
			$headers .= "BCC: ".$this->bcc."\r\n";
		}
		if ($this->reply_to!=""){
			$headers .= "Reply-To: " . $this->reply_to . "\r\n";
		}
		if ($this->hasattach>0){
			$headers .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n";
			$headers .= "Content-Transfer-Encoding: 8bit\r\n";
		}else{
			
			if ($this->ishtml == 0) {			
				$headers .= "Content-Type: text/plain; charset=\"".$this->encoding."\"\r\n";
			}
			if ($this->ishtml == 1) {
				$headers .= "Content-Type: text/html; charset=\"".$this->encoding."\"\r\n";
			}
			$headers .= "Content-Transfer-Encoding: 8bit\r\n";
		}		
		$headers .= 'X-Priority: ' . $this->priority . "\r\n";
		if ($this->xmailer!=""){
			$headers .= "X-Mailer: ".$this->xmailer."\r\n";
		}
		if ($this->extra_headers!=""){
			$headers .= $this->extra_headers;
		}
		$this->headers = $headers;
		return $headers;
	}	
	/**
	 * Build Body
	 */
	function buildBody(){
		$boundary = $this->boundary;
		$meat = "";
		if ($this->hasattach>0){
			$meat .= "This is a multi-part message in MIME format.\r\n\r\n";
			$meat .= "--$boundary\r\n";
			if ($this->ishtml == 0) {			
				$meat .= "Content-Type: text/plain; charset=\"".$this->encoding."\"\r\n";
			}
			if ($this->ishtml == 1) {
				$meat .= "Content-Type: text/html; charset=\"".$this->encoding."\"\r\n";
			}
			$meat .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
		}else{
			//$meat .= "\r\n";	
		}
		$meat .= $this->message;
		$meat .= "\r\n\r\n";
		if ($this->hasattach>0){
			$meat .= "\r\n--";
			$meat .= $boundary;
		}
		$meat .= ($this->hasattach > 0) ? "\r\n" : "\r\n";//--\r\n
		if ($this->hasattach > 0) {
			set_magic_quotes_runtime(0);
			for ($j=0;$j<count($this->attachments);$j++) {
				$last_attachment = count($this->attachments) - 1;
				list($filename, $location, $mimetype) = split(',',$this->attachments[$j]);
				$meat .= "Content-Type: ";
				$meat .= $mimetype;
				$meat .= "; name=\"";
				$meat .= $filename;
				$meat .= "\"\r\n";
				$meat .= "Content-Transfer-Encoding: base64\r\n";
				$meat .= "Content-Disposition: attachment";
				$meat .= "; filename=\"";
				$meat .= $filename;
				$meat .= "\"\r\n\r\n";
				$meat .= rtrim(chunk_split(base64_encode($this->get_file($location))));
				if ($j == $last_attachment) {
					$meat .= "\r\n--";
					$meat .= $boundary;
					$meat .= "--";
				} else {
					$meat .= "\r\n--";
					$meat .= $boundary;
					$meat .= "\r\n";
				}
			}			
		}
		$this->body = $meat;
		return $meat;
	}
	/**
	 * Parse CC, BCC
	 */
	function parseCc($_cc, $delimiter='', $checkemail=true){
		//if null, auto check delimiter
		if ($delimiter=='' || strpos($_cc, $delimiter)===false){
			if (strpos($_cc,',')!==false){
				$delimiter = ',';
			}elseif (strpos($_cc,';')!==false){
				$delimiter = ';';
			}
		}
		if ($delimiter==='') 
			return array($_cc);
		if ($delimiter==''){
			$arrCc = array($cc);
		}else{
			$arrCc = explode($delimiter, $cc);
		}		
		$ret = array();
		array_walk($arrCc, 'trim');
		foreach ($arrCc as $k => $eml){
			if ($checkemail){
				if (isEmail($eml)){
					$ret[] = $eml;
				}
			}else{
				$ret[] = $eml;			
			}
		}
		return $ret;
	} 
	/**
	 * Send Mail
	 */
	function send(){
		$this->buildHeader();
		$this->buildBody();
		set_magic_quotes_runtime(get_magic_quotes_gpc());
		$sent = mail($this->recipient_addr, $this->subject, $this->body, $this->headers);
		if ($sent==0){
			$this->setError("Cannot send email to ".$this->recipient_addr,  "ERROR");
		}
		return $sent;
	}
	/**
	 * Write file
	 */
	function writeFile($mailFile){
		if ($fp = fopen($mailFile, "w")){
			fwrite($fp, uft8html2utf8($this->buildHeader(true))."\r\n");
			fwrite($fp, uft8html2utf8($this->buildBody()));
			fclose($fp);
			return 1;
		}
		return 0;
	}
}
?>