<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class ButtonNav{
	var $arrBut = array();
	var $arrImg = array();
	var $arrHref =  array();
	var $arrActive = array();
	var $arrJsFunc = array();
	var $last_render = "";
	function ButtonNav(){
		
	}
	
	function set($name, $src="", $href="", $active=1, $jsfunc=""){
		$this->arrBut[] = $name;
		if ($src!="")
			$this->arrImg[$name] = $src;
		if ($href!="")
			$this->arrHref[$name] = $href;
		if ($active!="")
			$this->arrActive[$name] = $active;
		if ($jsfunc!="")
			$this->arrJsFunc[$name] = $jsfunc;
	}
	
	function showButton($name, $src="", $href="#", $active=1){
		//set attribute

		$this->set($name, $src, $href, $active);

		$html = "<td ";
		if ($this->arrActive[$name]){
			$html.= "title='$name' class=\"buttonfunc\" onmouseover=\"this.className='buttonfunc_on';window.status='".$this->arrHref[$name]."'\" onmouseout=\"this.className='buttonfunc';window.status=''\"  ";
			if ($this->arrJsFunc[$name]!=""){
				$html.="onclick='".$this->arrJsFunc[$name]."()'";	
			}else{
				$html.="onclick=\"gotoUrl('".$this->arrHref[$name]."')\" ";			
	
			}
			
		}else{
			$html.= " class=\"buttonfunc\" ";
		}
		$html.=">";
		$html.="<table cellpadding=\"0\" cellspacing=\"0\" align=center>";
		$html.="<tr>";
		if ($active){
			$classimg = "";
			$classtxt = "class='activetxt'";
		}else{
			$classimg = "class='blurimg'";
			$classtxt = "class='blurtxt'";
		}	
		/*if (file_exists($this->arrImg[$name])){
			$src = $this->arrImg[$name];
		}else*/
		if (file_exists(DIR_IMAGES.$this->arrImg[$name])){
			$src = URL_IMAGES.$this->arrImg[$name];
		}
		//echo $src;
		$html.="<td $classimg ><img src=\"".$src."\"/></td>";
		$html.="<td $classtxt >&nbsp;<b>".$name."</b></td>";
		$html.="</tr>";
		$html.="</table>";
		$html.="</td>";
		return $html;
	}
	
	function showButton1($name, $active=1){
		return $this->showButton($name, "", "", $active);
	}
	
	function render(){
		$html = "";
		if (is_array($this->arrBut)){
			foreach ($this->arrBut as $key => $val){
				$html.= $this->showButton1($val, $this->arrActive[$val]);
			}
		}
		$this->last_render = $html;
		return $html;
	}
}
?>