<?
class Member extends dbBasic{

	function Member(){
		$this->pkey = "id";
		$this->tbl = "mdl_user";
	}
	
	function getLastMemberID() {
		$arrLastRecordInserted = $this->getAll("1=1 order by id DESC limit 0,1");	
		if(is_array($arrLastRecordInserted) && count($arrLastRecordInserted)>0)
			return $arrLastRecordInserted[0]["id"];
		else
			return 1;
	}
	
	function getMemberFullName($member_id) {
		$arrLastRecordInserted = $this->getOne($member_id);	
		if(is_array($arrLastRecordInserted) && count($arrLastRecordInserted)>0)
			return $arrLastRecordInserted["full_name"];
		else
			return "";
	}
	
	function encrypt($salt, $password) {
		return md5($salt.md5($password.$salt));
	}
	
	function createSalt() {
		$salt = '';
		
		for ($i = 0; $i < 3; $i++)
			{
				$salt .= chr(rand(35, 126));
			}
			
        return $salt;
	}
	
	function createActiveCode($minlength, $maxlength, $useupper, $usespecial, $usenumbers) {
		$charset = "abcdefghijklmnpqrstuvwxyz";
		if ($useupper) $charset .= "ABCDEFGHIJKLMNPQRSTUVWXYZ";
		if ($usenumbers) $charset .= "23456789";
		if ($usespecial) $charset .= "~@#$%^*()_+-={}|]["; 
		if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength);
		else $length = mt_rand ($minlength, $maxlength);
		for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
		
		return $key;
	}
	
	function userLoggedIn($username,$password) {
		if(!$this->isLoggedIn()) {
			$arrOneUser = $this->getByCond("user_name='".$username."'");
			if(is_array($arrOneUser) && count($arrOneUser)>0)
				{
					$salt = $arrOneUser["salt"];				
					if($this->encrypt($salt, $password)==$arrOneUser["password"]) {
						$_SESSION["member_id"]=$arrOneUser["member_id"];
						return true;
					}
					else {
						return false;
					}
				}
			else {
				return false;
			}
		}
		else return true;
	}	
	
	function isLoggedIn() {
		if($_SESSION["username"]) return true;
		else
			return false;		
	}
	
	function userDoLogout() {
		unset($_SESSION["member_id"]);
		
		return true;
	}
	//(username = '" . mysql_real_escape_string($_POST['username']) . "')
	function checkMemberExist($username, $mobile) {
		$return = false;
		$arrOneUser = $this->getByCond("username='".mysql_real_escape_string($username)."' or mobile='".$mobile."'"  );
		if(is_array($arrOneUser) && count($arrOneUser)>0)
			$return = true;
		
		return $return;
	}
	
	function checkEmailMemberExist($email) {
		$return = false;
		$arrOneUser = $this->getByCond("email='".$email."'");
		if(is_array($arrOneUser) && count($arrOneUser)>0)
			$return = true;
		
		return $return;
	}
	
	function checkLogin($username,$password) {
		global $dbconn;
		$ret = false;
		//$md5_pwd = md5($pwd);
		$arrListUser = $this->getByCond("username='".mysql_real_escape_string($username)."' and password='".md5($password)."'");
		
		if($arrListUser["username"] != "") {
			$this->setOneSessionVar("username",$username);
			$this->setOneSessionVar("userid",$arrListUser["id"]);
			
			// add by vietth set cookies
			setcookie('m_username',$username,time()+3600,'','.topica.vn','');
			setcookie('m_userid',$arrListUser["id"],time()+3600,'','.topica.vn','');
			setcookie('m_secretkey',md5($arrListUser["id"].'vietth'),time()+3600,'','.topica.vn','');
			
			
			//Creat table view
			$table = 'hv_noti_'.$arrListUser["id"];
			
			// new by vietth 13-05-2013
			$sql_noti = "
			CREATE view $table as
			select q.id as quiz_id,q.name,c.shortname,c.id c_id,
			CASE grademethod WHEN '1' THEN (select count(*) from vietth_q169_attempts where userid=".$arrListUser["id"]." and quiz=quiz_id and sumgrade >= 5) 
                 WHEN '2' THEN (select count(*) from vietth_q169_attempts where userid=".$arrListUser["id"]." and quiz=quiz_id ) 
			 ELSE 'Europe' END AS sobai
			 from mdl_quiz q
			INNER JOIN mdl_course c on c.id = q.course 
			and
			q.course in (SELECT
				c.id
			FROM
				mdl_course c
			INNER JOIN mdl_context ct ON c.id = ct.instanceid
			INNER JOIN mdl_role_assignments ra ON ct.id = ra.contextid
			INNER JOIN mdl_user u ON ra.userid = u.id
			INNER JOIN mdl_role r ON r.id = ra.roleid
			INNER JOIN mdl_course_categories cc ON cc.id = c.category
			WHERE
				r.id = 5
			AND u.id = ".$arrListUser["id"]."
			AND c.fullname NOT LIKE '%h2472%'
			AND c.visible = 1)";
			
	
			
			
			
			/*
			$sql_noti ="
			CREATE view $table as
			SELECT
				mdl_quiz.id AS quizid,
				`name`,
				mdl_course.shortname,mdl_course.id as c_id,
				(
					SELECT
						count(*)
					FROM
						mdl_quiz_grades
					WHERE
						quiz = quizid
					AND userid = '".$arrListUser["id"]."'
					AND grade >= 5
				) sobai
			FROM
				mdl_quiz
			INNER JOIN mdl_course ON mdl_course.id = mdl_quiz.course
			WHERE
				course IN (
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
						u.id = '".$arrListUser["id"]."' and c.visible=1
				)
				
			ORDER BY
				NAME
			";
			*/
			//print_r($sql_noti);die();
			$dbconn->Execute($sql_noti);
			//End	
			$ret = true;	
		}
		
		return $ret;
	}
	function setOneSessionVar($name,$var) {
		$_SESSION[$name] = $var;
	}
	
	function sendMail($to, $name="", $new_pass="") {
		$is_send = 0;
		$subject = 'Thông báo từ http://www.chootovietnam.vn';
		$from = "info@chootovietnam.vn";	
		$message = '<table cellpadding="0" cellspacing="0" border="1" width="100%" style="border:1px solid #ccc">
						<tr>
							<td width="25%" height="80px" align="center">
								<font style="font-family:Arial; font-size:16px; color:#0000FF; font-weight:bold; font-style:bold;">chootovietnam.vn</font><br />
								<font style="font-family:Arial; font-size:12px; color:#ff0000; font-weight:normal; font-weight:bold;">chootovietnam.com.vn</font>
							</td>
							<td align="center" valign="middle"><font style="font-family:Tahoma; font-size:31px; color:#0000FF; font-weight:bold; font-style:italic">THƯ THÔNG BÁO</font></td>
						</tr>
					</table>'; 
		$message .= "<br><b><i>Xin chào:</i></b> ".$name; 
		$message .= "<br>Ban quản trị website chootovietnam.vn xin chân thành cảm ơn sự hợp tác tốt đẹp của quý công ty trong thời gian qua.";	
		$message .= "<br>Mật khẩu mới của bạn là: ".$new_pass;						
		$message .= "<br>=======================================================================
					<br>Phòng Thương Mại Điện tử - Chợ ô tô Việt Nam
					<br>ĐT: (84-4) 22452929/ 098 76 77 168
					<br>Fax: (84-4) 22452929
					<br>Email: info@chootovietnam.vn
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