<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class User extends DbBasic{
	var $user_id 		= "";
	var $user_name 		= "";
	var $user_pass 		= "";
	var $user_group_id 	= "";
	var $fullname 		= "";
	/**
	 * Init class
	 */
	function User(){
		$this->pkey = "user_id";
		$this->tbl = "user";	
	}

	function encrypt($password){
		return md5(md5($password));
	}	
		
	function hasPermiss($user_id, $catid){
		$res = $this->getOne($user_id);
		$permissnews = unserialize($res["permissnews"]);
		if ($res["groupid"]==4)return 1;
		if (is_array($permissnews) && in_array($catid, $permissnews)){
			return 1;
		}
		return 0;
	}

	function decodePermissNews($permissnews=""){
		return unserialize($permissnews);
	}

	function checkValidUserPass($_user_name, $_user_pass, &$controlName, &$errNo){		
		$_user_pass = $this->encrypt($_user_pass);
		$res = $this->getByCond("user_name='$_user_name'");
		if (is_array($res) && count($res)>0){
			if ($res["user_pass"]==$_user_pass){
				return 1;
			}else{
				$controlName = "user_pass";
				$errNo = 4;
				return 0;
			}
		}
		$controlName = "user_name";
		$errNo = 4;
		return 0;
	}
		
}
?>