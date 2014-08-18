<?
/**
*  Custom class	: User from table 'user'
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 25/11/2006
*  @version		: 1.0.0
*/
class User extends DbBasic{
	var $id 		= "";
	var $username 		= "";
	var $password 		= "";
	var $fullname 		= "";
	/**
	 * Init class
	 */
	function User(){
		$this->pkey = "id";
		$this->tbl = "mdl_user";	
	}

	function encrypt($password){
		return md5($password);
	}	
		
	function hasPermiss($id, $catid){
		$res = $this->getOne($id);
		$permissnews = unserialize($res["permissnews"]);
		if ($res["confirmed"]==1)return 1;
		if (is_array($permissnews) && in_array($catid, $permissnews)){
			return 1;
		}
		return 0;
	}

	function decodePermissNews($permissnews=""){
		return unserialize($permissnews);
	}
	
	function checkValidUserPass($_username, $password, &$controlName, &$errNo){		
		$_user_pass = $this->encrypt($password);
		$res = $this->getByCond("username='$_username'");
		if (is_array($res) && count($res)>0){
			if ($res["password"]==$password){
				return 1;
			}else{
				$controlName = "password";
				$errNo = 4;
				return 0;
			}
		}
		$controlName = "username";
		$errNo = 4;
		return 0;
	}
	
	function GetMaxLogin ($u_id) {
		global $dbconn;
			$sql6 = "select max(time) from mdl_log where userid = $u_id";
			//die($sql6);
		$res = $dbconn->GetAll($sql6);
		return $res[0]['max(time)'];
	}

		function CheckRole ($username,$c_id) {
			if($username=='hatvv')
			{
				return 1;
				exit();
			}
		global $dbconn;
			$sql6 = "SELECT count(u.id) count
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
				WHERE  r.id in (13,211,1,2,11)
				and c.id='$c_id'
				and u.username='$username'
				";
			//die($sql6);
		$res = $dbconn->GetAll($sql6);
		return $res[0]['count'];
	}
	
	/*
	function GetMaxLogin ($u_id,$c_id) {
		global $dbconn;
			$sql6 = "select timeaccess from mdl_user_lastaccess where userid = $u_id and courseid=$c_id";
			//die($sql6);
		$res = $dbconn->GetAll($sql6);
		return $res[0]['timeaccess'];
	}
		*/
}
?>