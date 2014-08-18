<?
class MdlCourse extends dbBasic{
	function MdlCourse(){
		$this->pkey = "id";
		$this->tbl = "mdl_course";
	}
	
	function getArrBTVN($c_id){
		global $dbconn;
		
		$sql_btvn = "SELECT
						q. NAME,
						q.id,
						q.timeclose
					FROM
						huy_setting_lipe hsl
					INNER JOIN mdl_quiz q ON q.id = hsl.active_id
					WHERE
						hsl.c_id = ".$c_id."
					AND hsl.lipe_type = 'E'
					ORDER BY
						id ASC
					";
		$res=$dbconn->getAll($sql_btvn);
		
		if(is_array($res) && count($res)>0)
			return $res;
		else
			return "";
		
	}
	
	function getArrLTTN($c_id){
		global $dbconn;
		
		$sql_btvn = "SELECT
						q. NAME,
						q.id,
						q.timeclose
					FROM
						huy_setting_lipe hsl
					INNER JOIN mdl_quiz q ON q.id = hsl.active_id
					WHERE
						hsl.c_id = ".$c_id."
					AND hsl.lipe_type = 'P'
					ORDER BY
						id ASC
					";
		$res=$dbconn->getAll($sql_btvn);
		
		if(is_array($res) && count($res)>0)
			return $res;
		else
			return "b";
		
	}
	
}

?>