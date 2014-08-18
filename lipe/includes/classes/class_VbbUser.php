<?
class VbbUser extends dbBasic{
	function VbbUser(){
		global $_LANG_ID;
		$this->pkey = "userid";
		$this->tbl = "vbb_user";		
	}
	
	function countPostGiaoLuu($topica_lop,$username) {
		global $dbconn;
		
		$sql = "select count(postid) from vbb_post where threadid in (select threadid from vbb_thread where forumid in (select forumid from vbb_forum where title like '%$topica_lop%')) and username = '".$username."'";
		//print_r($sql); die();
		
		
		$res = $dbconn->GetAll($sql);
		
		$result_count = is_array($res)? $res[0]["count(postid)"] : 0;
		
		return $result_count;
		
		
	}
	function countPostHoiTruong($username) {
		global $dbconn;
		
		$sql = "select count(postid) from vbb_post where threadid in (select threadid from vbb_thread where forumid in (4,9)) and username = '".$username."'";
		//print_r($sql); die();
		
		
		$res = $dbconn->GetAll($sql);
		
		$result_count = is_array($res)? $res[0]["count(postid)"] : 0;
		
		return $result_count;
		
		
	}
	function countPostHTKyThuat($username) {
		global $dbconn;
		
		$sql = "select count(postid) from vbb_post where threadid in (select threadid from vbb_thread where forumid in (278,279)) and username = '".$username."'";
		//print_r($sql); die();
		
		
		$res = $dbconn->GetAll($sql);
		
		$result_count = is_array($res)? $res[0]["count(postid)"] : 0;
		
		return $result_count;
		
		
	}
	function countPostNgoaiKhoa($username) {
		global $dbconn;
		
		$sql = "select count(postid) from vbb_post where threadid in (select threadid from vbb_thread where forumid in (259,260,261,262,418,419,420,421)) and username = '".$username."'";
		//print_r($sql); die();
		
		
		$res = $dbconn->GetAll($sql);
		
		$result_count = is_array($res)? $res[0]["count(postid)"] : 0;
		
		return $result_count;
		
		
	}
	
}
?>