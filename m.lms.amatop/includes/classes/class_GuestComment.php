<? 
class GuestComment extends DbBasic {
	
	function GuestComment() {
		$this->pkey = "guest_comment_id";
		$this->tbl = "guest_comment";
	}
	
	function checkContentExist($product_id=0, $email='', $name='', $title='', $content='') {
		$arrListOneRecordExists = $this->getAll("product_id='".$product_id."' and fullname='".$name."' and email='".$email."' and title='".$title."' and content='".$content."'");
		
		if(is_array($arrListOneRecordExists) && count($arrListOneRecordExists)>0) return true;
		else
			return false;
	}
	
	function htmlDecode($var){
		if (is_array($var)){
			foreach ($var as $k => $v){
				$var[$k] = $this->htmlDecode($v);
			}
		}else{
			$var = html_entity_decode($var);
		}
		return $var;
	}	
}
?>