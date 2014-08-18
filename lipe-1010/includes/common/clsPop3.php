<?
/**
*  Recevie Mail with detect attachments
*  @author		: Jointy <bestmischmaker@web.de>		
*  modifier		: Vu Quoc Trung  (vuquoctrung@gmail.com)
*  @date		: 25/11/2006
*  @version		: 1.0.0
*/
class Pop3 {
    var $socket = FALSE;
    var $socket_status = FALSE;
    var $socket_timeout = "10,500";

    var $error = "No Errors";
    var $state = "DISCONNECTED";
    var $apop_banner = "";
    var $apop_detect;

    var $log = false;
    var $log_file = "pop3.log";
    var $log_fp;

    var $file_fp;
    var $mysql_socket;


    // Constructor
    function Pop3($log = false, $log_file = "", $apop_detect = FALSE)
    {
        $this->log = $log;
        $this->log_file = $log_file;
        $this->apop_detect = $apop_detect;
    }
    /*
      Function _cleanup()
      Access: Private
    */
    function _cleanup()
    {
        $this->state = "DISCONNECTED";

        if(is_array($this->socket_status)) $this->socket_status = FALSE;

        if( is_resource($this->socket) )
        {
            socket_set_blocking( $this->socket , false );
            @fclose($this->socket);
            $this->socket = FALSE;
        }

        $close_log = "Connection Closed. \r\n";
        $close_log .= "/------------------------------------------------------------------- \r\n";
        $close_log .= "/--- Log File: ".$this->log_file." \r\n";
        $close_log .= "/--- Log Close: ".date('l, d M Y @ H:i:s')." \r\n";
        $close_log .= "/------------------------------------------------------------------- \r\n";

        if($this->log) $this->_logging($close_log);

        if(is_resource($this->mysql_socket))
        {
            @mysql_close($this->mysql_socket);
            $this->mysql_socket = FALSE;
        }
        if( is_resource($this->log_fp) )
        {
            @fclose($this->log_fp);
            $this->mysql_socket = FALSE;
        }
        unset($close_log);
    }

    /*
      Function _logging($string)
      Access: Private
    */
    function _logging($string)
    {
        if($this->log)
        {
        if(!$this->log_fp)
        {
            $this->log_fp = @fopen($this->log_file,"a+");
            if(!$this->log_fp)
            {
                $this->error = "POP3 _logging() - Error: Can't open log file in write mode (".$this->log_file.") !!! -- Connection Closed !!!";
                $this->_cleanup();
                return FALSE;
            }
            $open_log = "/------------------------------------------------------------------- \r\n";
            $open_log .= "/--- Log File: ".$this->log_file." \r\n";
            $open_log .= "/--- Log Open: ".date('l, d M Y @ H:i:s')." \r\n";
            $open_log .= "/------------------------------------------------------------------- \r\n";

            if(!@fwrite($this->log_fp,$open_log,strlen($open_log)))
            {
                $this->error = "POP3 _logging() - Error: Can't write string to file !!!";
                $this->_cleanup();
                return FALSE;
            }
            unset($open_log);
        }
        if(substr($string,0,1) != "-" && substr($string,0,1) != "+" && substr($string,-4) != "\r\n" && substr($string,-2) != "\n")
        {
            $string = $string."\r\n";
        }

        $string = date("H:i:s")." -- ".$string;
        if(!@fwrite($this->log_fp, $string, strlen($string)))
        {
            $this->error = "POP3 _logging() - Error: Can't write string to file !!! -- Connection Closed !!!";
            $this->_cleanup();
            return FALSE;
        }

        }
        return TRUE;
    }


    /*
      Function connect($server, $port, $timeout, $sock_timeout)
      Access: Public

      // Vars:
      - $server ( Server IP or DNS )
      - $port ( Server port default is "110" )
      - $timeout ( Connection timeout for connect to server )
      - $sock_timeout ( Socket timeout for all actions   (10 sec 500 msec) = (10,500))


      If all right you get true, when not you get false and on $this->error = msg !!!
    */
    function connect( $server, $port="110", $timeout = "25" , $sock_timeout = "10,500")
    {
        if($this->socket)
        {
            $this->error = "POP3 connect() - Error: Connection also avalible !!!";
            return FALSE;
        }

        if(!trim($server))
        {
            $this->error = "POP3 connect() - Error: Please give a server address.";
            return FALSE;
        }

        if($port < "1" && $port > "65535" || !trim($port))
        {
            $this->error = "POP3 connect() - Error: Port not set or out of range (1 - 65535)";
            return FALSE;
        }

        if($timeout < 0 && $timeout > 25 || !trim($timeout))
        {
            $this->error = "POP3 connect() - Error: Connection Timeout not set or out of range (0 - 25)";
            return FALSE;
        }
        $sock_timeout = explode(",",$sock_timeout);
        if( !trim($sock_timeout[0]) || ($sock_timeout[0] < 0 && $sock_timeout[0] > 25) ) // || !preg_match("^[0-9]",sock_timeout[1]) )
        {
            $this->error = "POP3 connect() - Error: Socket Timeout not set or out of range (0 - 25)";
            return FALSE;
        }
        /*
        if(!ereg("([0-9]{2}),([0-9]{3})",$sock_timeout))
        {
            $this->error = "POP3 connect() - Error: Socket Timeout in invalid Format (Right Format xx,xxx \"10,500\")";
            return FALSE;
        }
        */
        // Check State
        if(!$this->_checkstate("connect")) return FALSE;


        if( !$this->socket = @fsockopen($server, $port, $errno, $errstr, $timeout ))
        {
            $this->error = "POP3 connect() - Error: Can't connect to Server. Error: ".$errno." -- ".$errstr;
            return FALSE;
        }

        if(!$this->_logging("Connecting to \"".$server.":".$port."\" !!!")) return FALSE;

        // Set Socket Timeout
        // It is valid for all other functions !!
        socket_set_timeout($this->socket,$sock_timeout[0],$sock_timeout[1]);
        socket_set_blocking($this->socket,true);

        $response = $this->_getnextstring();

        if(!$this->_logging($response))
        {
            $this->_cleanup();
            return FALSE;
        }

        if(substr($response,0,1) != "+")
        {
            $this->_cleanup();
            $this->error = "POP3 connect() - Error: ".$response;
            return FALSE;
        }

        // Get the server banner for APOP
        $this->apop_banner = $this->_parse_banner($response);

        $this->state = "AUTHORIZATION";
        if(!$this->_logging("STATUS: AUTHORIZATION")) return FALSE;

        return TRUE;

    }

    /*
      Function _login($user, $pass)
      Access: Public
    */

    function login($user, $pass, $apop = "0"){
        if(!$this->socket){
            $this->error = "POP3 login() - Error: No connection avalible.";
            $this->_cleanup();
            return FALSE;
        }

        if( $this->_checkstate("login") ){

        if($this->apop_detect){
            if($this->apop_banner != ""){
                $apop = "1";
            }
        }

        if($apop == "0"){

            $response = "";
            $cmd = "USER $user";
            if(!$this->_logging($cmd)) return FALSE;
            if(!$this->_putline($cmd)) return FALSE;

            $response = $this->_getnextstring();

            if(!$this->_logging($response)) return FALSE;

            if(substr($response,0,1) == "-" ){
                $this->error = "POP3 login() - Error: ".$response;
                $this->_cleanup();
                return FALSE;
            }

            $response = "";
            $cmd = "PASS $pass";
            if(!$this->_logging("PASS ".md5($pass))) return FALSE;
            if(!$this->_putline($cmd)) return FALSE;
            $response = $this->_getnextstring();
            if(!$this->_logging($response)) return FALSE;
            if(substr($response,0,1) == "-" ){
                $this->error = "POP3 login() - Error: ".$response;
                $this->_cleanup();
                return FALSE;
            }
            $this->state = "TRANSACTION";
            if(!$this->_logging("STATUS: TRANSACTION")) return FALSE;
            return TRUE;

        }elseif($apop == "1"){
            // APOP Section

            // Check is Server Banner for APOP Command given !!!
            if(empty($this->apop_banner)){
                $this->error = "POP3 login() (APOP) - Error: No Server Banner -- aborted and close connection";
                $this->_cleanup();
                return FALSE;
            }
            echo $this->apop_banner;

            $response = "";

            // Send APOP Command !!!

            $cmd = "APOP ". $user ." ". md5($this->apop_banner.$pass);

            if(!$this->_logging($cmd)) return FALSE;
            if(!$this->_putline($cmd)) return FALSE;
            $response = $this->_getnextstring();

            if(!$this->_logging($response)) return FALSE;
            // Check the response !!!
            if(substr($response,0,1) != "+" ){
                $this->error = "POP3 login() (APOP) - Error: ".$response;
                $this->_cleanup();
                return FALSE;
            }
            $this->state = "TRANSACTION";
            if(!$this->_logging("STATUS: TRANSACTION")) return FALSE;
            return TRUE;

        }else{
            $this->error = "POP3 login() - Error: Please set apop var !!! (1 [true] or 0 [false]).";
            $this->_cleanup();
            return FALSE;
        }

        }

        return FALSE;
    }
 
    /*
      Function get_mail
      Access: Public
    */
    function get_mail( $msg_number, $qmailer = FALSE )
    {
        if(!$this->socket)
        {
            $this->error = "POP3 get_mail() - Error: No connection avalible.";

            return FALSE;
        }

        if(!$this->_checkstate("get_mail")) return FALSE;

        $response = "";
        $cmd = "RETR $msg_number";
        if(!$this->_logging($cmd)) return FALSE;
        if(!$this->_putline($cmd)) return FALSE;

        $response = $this->_getnextstring();

        if(!$this->_logging($response)) return FALSE;

        if ($qmailer == TRUE)
		{
			if(substr($response,0,1) != '.') 
			{
				$this->error = "POP3 get_mail() - Error: ".$response;
				return FALSE;
			}
		}
		else 
		{
			if(substr($response,0,3) != "+OK") 
			{
				$this->error = "POP3 get_mail() - Error: ".$response;
				return FALSE;
			}
		}
	
        // Get MAIL !!!
        $i = "0";
        $response = $this->_getnextstring();
        while(!eregi("^\.\r\n",$response))
        {
            if(substr($response,0,4) == "\r\n") break;
            $output[$i] = $response;
            $i++;
            $response = $this->_getnextstring();
        }
		$output[$i++] = " \r\n";        
		$response = $this->_getnextstring();
        while(!eregi("^\.\r\n",$response))
        {
            $output[$i] = $response;
            $i++;
            $response = $this->_getnextstring();
        }	
        $output[$i] = " \r\n";

        if(!$this->_logging("Complete.")) return FALSE;

        return $output;
    }


    /*
       Function _check_state()
       Access: Private

    */

    function _checkstate($string)
    {
        // Check for delete_mail func
        if($string == "delete_mail" || $string == "get_office_status" || $string == "get_mail" || $string == "get_top" || $string == "noop" || $string == "reset" || $string == "uidl" || $string == "stats")
        {
            $state = "TRANSACTION";
            if($this->state != $state){
                $this->error = "POP3 $string() - Error: state must be in \"$state\" mode !!! Your state: \"$this->state\" !!!";
                return FALSE;
            }
            return TRUE;
        }

        // Check for connect func
        if($string == "connect")
        {
            $state = "DISCONNECTED";
            $state_1 = "UPDATE";
            if($this->state == $state or $this->state == $state_1){
                return TRUE;
            }
            $this->error= "POP3 $string() - Error: state must be in \"$state\" or \"$state_1\" mode !!! Your state: \"$this->state\" !!!";
            return FALSE;

        }

        // Check for login func
        if($string == "login")
        {
            $state = "AUTHORIZATION";
            if($this->state != $state){
                $this->error = "POP3 $string() - Error: state must be in \"$state\" mode !!! Your state: \"$this->state\" !!!";
                return FALSE;
            }
            return TRUE;
        }
        $this->error = "POP3 _checkstate() - Error: Not allowed string given !!!";
        return FALSE;
    }

    /*
      Function delete_mail($msg_number)
      Access: Public


    */

    function delete_mail($msg_number = "0")
    {
         if(!$this->socket){
            $this->error = "POP3 delete_mail() - Error: No connection avalible.";
            return FALSE;
        }
        if(!$this->_checkstate("delete_mail")) return FALSE;

        if($msg_number == "0"){
            $this->error = "POP3 delete_mail() - Error: Please give a valid Messagenumber (Number can't be \"0\").";
            return FALSE;
        }
        // Delete Mail
        $response = "";
        $cmd = "DELE $msg_number";
        if(!$this->_logging($cmd)) return FALSE;
        if(!$this->_putline($cmd)) return FALSE;
        $response = $this->_getnextstring();
        if(!$this->_logging($response)) return FALSE;
        if(substr($response,0,1) != "+"){
           $this->error = "POP3 delete_mail() - Error: ".$response;
           return FALSE;
        }

        return TRUE;
    }


    /*
      Function get_office_status
      Access: Public

      Output an array

      Array
     (
        [count_mails] => 3
        [octets] => 2496
        [1] => Array
              (
                  [size] => 832
                  [uid] => 617999468
              )

        [2] => Array
              (
                  [size] => 882
                  [uid] => 617999616
              )

        [3] => Array
              (
                  [size] => 1726
                  [uid] => 617999782
              )

        [error] => No Errors
     )

    */

    function get_office_status(){

        if(!$this->socket){
            $this->error = "POP3 get_office_status() - Error: No connection avalible.";
            $this->_cleanup();
            return FALSE;
        }

        if(!$this->_checkstate("get_office_status")){
            $this->_cleanup();
            return FALSE;
        }

        // Put the "STAT" Command !!!
        $response = "";
        $cmd = "STAT";
        if(!$this->_logging($cmd)) return FALSE;
        if(!$this->_putline($cmd)) return FALSE;

        $response = $this->_getnextstring();

        if(!$this->_logging($response)) return FALSE;

        if(substr($response,0,3) != "+OK"){
            $this->error = "POP3 get_office_status() - Error: ".$response;
            if(!$this->_logging($this->error)) return FALSE;
            $this->_cleanup();
            return FALSE;
        }
        // Remove "\r\n" !!!
        $response = trim($response);

        ////////////////////////////////////////////////////////////////////////
        // Some Server send the STAT string is finished by "." (+OK 3 52422.)
        // - "Yahoo Server"
        $lastdigit = substr($response,-1);
        if(!ereg("(0-9)",$lastdigit)){
            $response = substr($response,0,strlen($response)-1);
        }
        unset($lastdigit);
        ////////////////////////////////////////////////////////////////////////

        $array = explode(" ",$response);
        $output["count_mails"] = $array[1];
        $output["octets"] = $array[2];

        unset($array);
        $response = "";

        if($output["count_mails"] != "0"){

            // List Command
            $cmd = "LIST";
            if(!$this->_logging($cmd)) return FALSE;
            if(!$this->_putline($cmd)) return FALSE;
            $response ="";
            $response = $this->_getnextstring();

            if(!$this->_logging($response)) return FALSE;

            if(substr($response,0,3) != "+OK"){
                $this->error = "POP3 get_office_status() - Error: ".$response;
                $this->_cleanup();
                return FALSE;
            }
            // Get Message Number and Size !!!
            $response = "";
            for($i=0;$i<$output["count_mails"];$i++){
                $nr=$i+1;
                $response = trim($this->_getnextstring());
                if(!$this->_logging($response)) return FALSE;
                $array = explode(" ",$response);
                $output[$nr]["size"] = $array[1];
                $response = "";
                unset($array);
                unset($nr);
            }
            // $response = $this->_getnextstring();
            // echo "<b>".$response."</b>";

            // Check is server send "."
            if(trim($this->_getnextstring()) != "."){
                $this->error = "POP3 get_office_status() - Error: Server does not send "." at the end !!!";
                $this->_cleanup();
                return FALSE;
            }
            if(!$this->_logging(".")) return FALSE;

            // UIDL Command
            $cmd = "UIDL";
            if(!$this->_logging($cmd)) return FALSE;
            if(!$this->_putline($cmd)) return FALSE;
            $response = "";
            $response = $this->_getnextstring();
            if(!$this->_logging($response)) return FALSE;
            if(substr($response,0,3) != "+OK"){
                $this->error = "POP3 get_office_status() - Error: ".$response;
                $this->_cleanup();
                return FALSE;
            }
            // Get UID's
            $response = "";
            for($i=0;$i<$output["count_mails"];$i++){
                $nr=$i+1;
                $response = trim($this->_getnextstring());
                if(!$this->_logging($response)) return FALSE;
                $array = explode(" ", $response);
                $output[$nr]["uid"] = $array[1];
                $response = "";
                unset($array);
                unset($nr);
            }

            // Check is server send "."
            if(trim($this->_getnextstring()) != "."){
                $this->error = "POP3 get_office_status() - Error: Server does not send "." at the end !!!";
                $this->_cleanup();
                return FALSE;
            }
            if(!$this->_logging(".")) return FALSE;
        }

        return $output;

    }

    /*
      Function save2file($message,$filename)
      Access: Public

      return written bytes or "false"
    */
    function save2file($message, $filename){
        $this->file_fp = fopen($filename,"w+");
        if(!$this->file_fp){
            $this->error = "POP3 save2file() - Error: Can't open file in write mode. (".$filename.")";
            if(!$this->_logging($this->error)) return FALSE;
            //$this->_cleanup();
            return FALSE;
        }
        if(!$this->_logging("LOG FILE: File ".$filename." created.")){
            //$this->_cleanup();
            return FALSE;
        }
        $count_bytes = "0";

        for($i=0;$i<count($message);$i++){
            $line = $message[$i];
            $str_len = strlen($line);
            $count_bytes = $count_bytes + $str_len;
            if(!fputs($this->file_fp,$line,$str_len)){
                $this->error = "POP3 save2file() - Error: Can't write string to file (".$filename.") !!!";
                if(!$this->_logging($this->error)) return FALSE;
                //$this->_cleanup();
                return FALSE;
            }
            unset($line);
        }
        if(!$this->_logging("LOG FILE: File ".$filename." (".$count_bytes." Bytes) written.")){
            //$this->_cleanup();
            return FALSE;
        }

        return $count_bytes;
    }
	
    /*
      Access: Public
    */
    function noop(){
        if(!$this->socket){
            $this->error = "POP3 noop() - Error: No connection avalible.";
            if(!$this->_logging($this->error)) return FALSE;
            return FALSE;
        }
        if(!$this->_checkstate("noop")) return FALSE;

        $cmd = "NOOP";

        if(!$this->_logging($cmd)) return FALSE;
        if(!$this->_putline($cmd)) return FALSE;

        $response = "";
        $response = $this->_getnextstring();
        if(!$this->_logging($response)) return FALSE;
        if(substr($response,0,1) != "+"){
            $this->error = "POP3 noop() - Error: ".$response;
            return FALSE;
        }

        return TRUE;
    }

    /*
      Function reset()
      Access: Public
    */
    function reset(){
        if(!$this->socket){
            $this->error = "POP3 reset() - Error: No connection avalible.";
            if(!$this->_logging($this->error)) return FALSE;

            return FALSE;
        }

        if(!$this->_checkstate("reset")) return FALSE;

        $cmd = "RSET";

        if(!$this->_logging($cmd)) return FALSE;
        if(!$this->_putline($cmd)) return FALSE;
        $response = "";
        $response = $this->_getnextstring();
        if(!$this->_logging($response)) return FALSE;
        if(substr($response,0,1) != "+"){
            $this->error = "POP3 reset() - Error: ".$response;
            return FALSE;
        }
        return TRUE;
    }
    /*
      Function stats
      Access: Private
      Get only count of mails and size of maildrop !!!
    */

    function _stats(){
        if(!$this->socket){
            $this->error = "POP3 _stats() - Error: No connection avalible.";
            return FALSE;
        }
        if(!$this->_checkstate("stats")) return FALSE;
        $cmd = "STAT";
        if(!$this->_logging($cmd)) return FALSE;
        if(!$this->_putline($cmd)) return FALSE;

        $response = $this->_getnextstring();
        if(substr($response,0,1) != "+"){
            $this->error = "POP3 _stats() - Error: ".$response;
            return FALSE;
        }
        $response = trim($response);

        $array = explode(" ",$response);

        $output["count_mails"] = $array[1];
        $output["octets"] = $array[2];
        return $output;
    }



    /*
      Function uidl($msg_number = "0")
      Access: Public
    */
    function uidl($msg_number = "0"){
        if(!$this->socket){
            $this->error = "POP3 uidl() - Error: No connection avalible.";
            return FALSE;
        }

        if(!$this->_checkstate("uidl")) return FALSE;

        if($msg_number == "0"){
            $cmd = "UIDL";

            // Get count of mails
            $mails = $this->_stats();
            if(!$mails) return FALSE;

            if(!$this->_logging($cmd)) return FALSE;
            if(!$this->_putline($cmd)) return FALSE;

            $response = "";
            $response = $this->_getnextstring();
            if(!$this->_logging($response)) return FALSE;
            if(substr($response,0,1) != "+"){
               $this->error = "POP3 uidl() - Error: ".$response;
               return FALSE;
            }
            $response = "";
            for($i = 1; $i <= $mails["count_mails"];$i++){
                $response = $this->_getnextstring();
                if(!$this->_logging($response)) return FALSE;
                $response = trim($response);
                $array = explode(" ",$response);
                $output[$i] = $array[1];
            }
            return $output;
        }else{
            $cmd = "UIDL $msg_number";

            if(!$this->_logging($cmd)) return FALSE;
            if(!$this->_putline($cmd)) return FALSE;

            $response = "";
            $response = $this->_getnextstring();
            if(!$this->_logging($response)) return FALSE;
            if(substr($response,0,1) != "+"){
               $this->error = "POP3 uidl() - Error: ".$response;
               return FALSE;
            }

            $response = trim($response);

            $array = explode(" ",$response);

            $output[$array[1]] = $array[2];


            return $output;
        }

    }

    /*
      Function close()
      Access: Public
      Close POP3 Connection
    */
    function close(){

        $response = "";
        $cmd = "QUIT";
        if(!$this->_logging($cmd)) return FALSE;
        if(!$this->_putline($cmd)) return FALSE;

        if($this->state == "AUTHORIZATION"){
            $this->state = "DISCONNECTED";
        }elseif($this->state == "TRANSACTION"){
            $this->state = "UPDATE";
        }

        $response = $this->_getnextstring();

        if(!$this->_logging($response)) return FALSE;
        if(substr($response,0,1) != "+"){
            $this->error = "POP3 close() - Error: ".$response;
            return FALSE;
        }
        $this->socket = FALSE;

        $this->_cleanup();

        return TRUE;
    }
    /*
      Function _getnextstring()
      Access: Private
    */
    function _getnextstring( $buffer_size = 512 )
    {
        $buffer = "";
        $buffer = fgets( $this->socket , $buffer_size );

        $this->socket_status = socket_get_status( $this->socket );

        if( $this->socket_status["timed_out"] )
        {
            $this->_cleanup();
            return "POP3 _getnextstring() - Socket_Timeout_reached.";
        }
        $this->socket_status = FALSE;

        return $buffer;
    }

    /*
      Function _putline()
      Access: Private
    */
    function _putline($string)
    {
        $line = "";
        $line = $string."\r\n";
        if(!fwrite($this->socket , $line , strlen($line)))
        {
            $this->error = "POP3 _putline() - Error while send \" $string \". -- Connection closed.";
            $this->_cleanup();
            return FALSE;
        }
        return TRUE;
    }

    /*
      Function _parse_banner( $server_text )
      Access: Private
    */
    function _parse_banner ( &$server_text )
    {
		$outside = true;
		$banner = "";
		$length = strlen($server_text);
		for($count = 0; $count < $length; $count++)
		{
			$digit = substr($server_text,$count,1);
			if($digit != "")
			{
				if( (!$outside) and ($digit != '<') and ($digit != '>') )
	
				{
					$banner .= $digit;
					continue;
				}
				if ($digit == '<')
				{
					$outside = false;
				}
				elseif ($digit == '>')
				{
					$outside = true;
				}
			}
		}
		$banner = trim($banner);
        if(strlen($banner) != 0 )
        {
            return "<". $banner .">";
        }
        return;
	}

    /*
      Funktion save2mysql($message,$mysql_socket,$dir_table = "inbox",$msg_table = "messages",$read = "0")
      Access: Public

    */
    function save2mysql($message,$socket,$dir_table = "inbox",$msg_table = "messages",$read = "0"){

        $this->mysql_socket = $socket;

        // Create Table for Mail Header Data
        $query = 'CREATE TABLE IF NOT EXISTS `'.$dir_table.'` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                 `msg_id` TEXT NOT NULL, `from` TEXT NOT NULL, `to` TEXT NOT NULL, `subject` TEXT NOT NULL,
                 `date` TEXT NOT NULL, `cc` TEXT, `bcc` TEXT, `content_type` TEXT, `content_encode` TEXT,
                 `mime_version` TEXT, `x_mailer` TEXT, `x_priority` INT( 1 ) DEFAULT \'3\', `reply_to` TEXT, `sender` TEXT,
                 `mail_followup_to` TEXT, `mail_reply_to` TEXT, `return_receipt_to` TEXT, `disposition_notification_to` TEXT,
                 `received` TEXT NOT NULL, `create` TIMESTAMP(14) NOT NULL, `read` TINYINT(1) DEFAULT \'0\' NOT NULL,
                 PRIMARY KEY ( `id` )) TYPE = MYISAM';
        if(!mysql_query($query,$this->mysql_socket)){
            $this->error = "POP3 save2mysql() - MySQL Error: ". mysql_errno() ." -- ". mysql_error();

            //$this->_cleanup();
            return FALSE;
        }

        // Create table for messages !!!
        $query = 'CREATE TABLE IF NOT EXISTS `'.$msg_table.'` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                 `unique_id` VARCHAR( 255 ) NOT NULL , `linenumber` INT UNSIGNED NOT NULL , `linetext` TEXT,
                 PRIMARY KEY ( `id` ) ) TYPE = MYISAM ';

        if(!mysql_query($query,$this->mysql_socket)){
            $this->error = "POP3 save2mysql() - MySQL Error: ". mysql_errno() ." -- ". mysql_error();
            //$this->_cleanup();
            return FALSE;
        }

        $i = 0;
        while(substr($message[$i],0,9) != "</HEADER>"){

            $message[$i] = str_replace("'","\"",$message[$i]);

            while(substr($message[$i],0,1) == " "){
                $header_keys = array_keys($header);
                $header[$header_keys[count($header_keys)-1]] .= $message[$i];
                unset($array_keys);
                $i++;
            }

            if(eregi("Message-ID",$message[$i])){
                $header["message_id"] = trim($message[$i]);
            }
            if(eregi("Subject",$message[$i])){
                $header["subject"] = trim($message[$i]);
            }
            $to = substr($message[$i],0,2);
            if(eregi("TO",$to)){
                $header["to"] = trim($message[$i]);
            }

            if(eregi("CC",$to)){
                $header["cc"] = trim($message[$i]);
            }
            unset($to);
            if(eregi("BCC",$message[$i])){
                $header["bcc"] = trim($message[$i]);
            }
            if(eregi("FROM",$message[$i])){
                $header["from"] = trim($message[$i]);
            }
            if(eregi("DATE",$message[$i])){
                $header["date"] = trim($message[$i]);
            }
            if(eregi("Content-Type",$message[$i])){
                $header["content_type"] = trim($message[$i]);
            }
            if(eregi("Content-Transfer-Encoding",$message[$i])){
                $header["content_encode"] = trim($message[$i]);
            }
            if(eregi("MIME-Version",$message[$i])){
                $header["mime_version"] = trim($message[$i]);
            }
            if(eregi("Reply-To",substr($message[$i],0,8))){
                $header["reply_to"] = trim($message[$i]);
            }
            if(eregi("X-Mailer",$message[$i])){
                $header["x_mailer"] = trim($message[$i]);
            }
            if(eregi("X-Priority",$message[$i])){
                $header["x_priority"] = substr(trim($message[$i]),-1);
            }
            if(eregi("Sender",$message[$i])){
                $header["sender"] = trim($message[$i]);
            }
            if(eregi("Mail-Followup-To",$message[$i])){
                $header["mail_followup_to"] = trim($message[$i]);
            }
            if(eregi("Mail-Reply-To",$message[$i])){
                $header["mail_reply_to"] = trim($message[$i]);
            }
            if(eregi("Return-Receipt-To",$message[$i])){
                $header["return_receipt_to"] = trim($message[$i]);
            }
            if(eregi("Disposition-Notifaction-To",$message[$i])){
                $header["disposition_notifaction_to"] = trim($message[$i]);
            }
            if(eregi("Received",$message[$i])){
                if(isset($header["received"])){
                    $header["received"] .= " <next> ";
                    $header["received"] .= trim($message[$i]);
                }else{
                    $header["received"] = trim($message[$i]);
                }

            }
            $i++;
        }
        // Vars that must be set with a value !!!
        if(!isset($header["message_id"])) $header["message_id"] = "--";
        if(!isset($header["from"])) $header["from"] = "--";
        if(!isset($header["to"])) $header["to"] = "--";
        if(!isset($header["subject"])) $header["subject"] = "--";
        if(!isset($header["date"])) $header["date"] = "--";
        if(!isset($header["received"])) $header["received"] = "--";

        $unique_id = md5($header["message_id"]);

        ////////////////////////////////////////////////////////////////////////
        // Check is mail exists !!!
        $query ='SELECT `unique_id` FROM `'.$msg_table.'` WHERE `unique_id` = \''.$unique_id.'\' LIMIT 0, 1';

        if(!$result = mysql_query($query,$this->mysql_socket)){
            $this->error = "POP3 save2mysql() - MySQL Error: ". mysql_errno() ." -- ". mysql_error();
           //$this->_cleanup();
            return FALSE;
        }

        if($rows = mysql_fetch_array($result,MYSQL_ASSOC)){
            $this->error = "POP3 save2mysql() - Error: Mail already exists";
            //$this->_cleanup();
            return FALSE;
        }
        mysql_free_result($result);

        ////////////////////////////////////////////////////////////////////////


        $query = 'INSERT INTO `'.$dir_table.'` ( `id` ,`msg_id` , `from` , `to` , `subject` , `date` ,
                 `cc` , `bcc` , `content_type` , `content_encode` , `mime_version` , `x_mailer` , `x_priority` ,
                 `reply_to` , `sender` , `mail_followup_to` , `mail_reply_to` , `return_receipt_to` ,
                 `disposition_notification_to` , `received` , `create` , `read` ) VALUES ( \'\',\''.$header["message_id"].'\',
                 \''.$header["from"].'\',\''.$header["to"].'\',\''.$header["subject"].'\',\''.$header["date"].'\',\''.$header["cc"].'\',
                 \''.$header["bcc"].'\',\''.$header["content_type"].'\',\''.$header["content_encode"].'\',\''.$header["mime_version"].'\',
                 \''.$header["x_mailer"].'\',\''.$header["x_priority"].'\',\''.$header["reply_to"].'\',
                 \''.$header["sender"].'\',\''.$header["mail_followup_to"].'\',\''.$header["mail_reply_to"].'\',\''.$header["return_receipt_to"].'\',
                 \''.$header["dispostion_notification_to"].'\',\''.$header["received"].'\',NOW(),\''.$read.'\')';

        if(!$this->_logging("LOG MySQL: Write header ('".$header["message_id"]."') to table ('".$dir_table."') !!")){
            $this->_cleanup();
            return FALSE;
        }
        if(!mysql_query($query,$this->mysql_socket)){
            $this->error = "POP3 save2mysql() - MySQL Error: ". mysql_errno() ." -- ". mysql_error();
            $this->_cleanup();
            return FALSE;
        }

        if(!$this->_logging("LOG MySQL: Write header ('".$header["message_id"]."') complete !!")){
            $this->_cleanup();
            return FALSE;
        }
        $count_lines = count($message);

        $count_bytes = "0";
        if(!$this->_logging("LOG MySQL: Write complete mail (uid '".$unique_id."') to table ('".$msg_table."') !!")){
            $this->_cleanup();
            return FALSE;
        }
        for($i = 0;$i < $count_lines;$i++){
            $count_bytes = $count_bytes + strlen($message[$i]);
            $message[$i] = str_replace("'","\"",$message[$i]);
            $query = 'INSERT INTO `'.$msg_table.'` ( `id` , `unique_id` , `linenumber` , `linetext` ) VALUES ( \'\', \''.$unique_id.'\', \''.$i.'\', \''.$message[$i].'\' )';
            if(!mysql_query($query,$this->mysql_socket)){
                $this->error = "POP3 save2mysql() - MySQL Error: ". mysql_errno() ." -- ". mysql_error();
                $this->_cleanup();
                return FALSE;
            }
        }

        if(!$this->_logging("LOG MySQL: Write complete mail (uid '".$unique_id."') complete. ( ".$count_bytes." Bytes written) !!")){
            $this->_cleanup();
            return FALSE;
        }
        $this->mysql_socket = FALSE;
        return $count_bytes;
    }
}

?>