<?
class Pollcnt extends dbBasic{
	var $pollcntid;
	var $pollid;
	var $content;
	var $hit;
	
	function Pollcnt(){
		$this->pkey = "pollcnt_id";
		$this->tbl = "pollcnt";
	}
	function insertContent($pollid, $content){
		$fields = "content,  pollid";
		$values = "'$content', '$pollid'";	
		$this->insertOne($fields, $values);
	}
}
?>