<?
class Comment extends dbBasic{

	function Comment(){
		$this->pkey = "id";
		$this->tbl = "comment";
	}
}
?>