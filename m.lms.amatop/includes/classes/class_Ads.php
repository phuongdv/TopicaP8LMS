<?
class Ads extends dbBasic{
	function Ads(){
		$this->pkey = "id";
		$this->tbl = "_ads";
	}
	
	function openJS() {
		$opJS = '<script type="text/javascript"> 
				 var fadeimages=new Array()
		        ';
		return $opJS;
	}
	
	function closeJS() {
		$clJS = '</script>';
		return $clJS;
	}
	
	function showOut($index,$image,$url,$title) {
						
		$inputStr = "fadeimages[".$index."]=['".URL_UPLOADS."/".$image."','".$url."','_new','".$this->htmlDecode($title)."'] ";
			
		return $inputStr;
	}	
	
	function getSrcFlashFile($str) {
		$src = '';
		if($str == "") $src = "";
		else {
			preg_match('/(.*?)src="(.*?)"(.*?)/',$str, $match);
			$src = (is_array($match))? $match[2] : "";
		}
		
		return $src;
	}
	
	function chkFileExtension($str) {
		if(eregi('swf',$str)) return "yes";
		else return "no";
	}
	
	function convertToRelativePath($str) {
				
		if(eregi('uploads',$str)) 
			$str = preg_replace('/uploads/', URL_UPLOADS, $str);
			
		return $str;
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