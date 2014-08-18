<?
class UserGroup extends DbBasic{
	function UserGroup(){
		$this->pkey = "user_group_id";
		$this->tbl = "`user_group`";
	}
	function getName($_user_group_id){
		$res = $this->getOne($_user_group_id);
		return $res["name"];
	}
}
?>