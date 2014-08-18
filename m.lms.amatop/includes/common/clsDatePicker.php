<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class DatePicker{
	var $name		=	"";
	var $format		=	"%m/%d/%Y %H:%M";
	var $value		=	"";
	var $attr		=	"style='width:110px'";
	var $showTime	=	1;//1: Yes, 0:No
	var $iconCal	=	"";
	
	function DatePicker($_name="", $_value="", $_format="", $_showTime="", $_attr=""){
		$this->name = $_name;
		$this->value = $_value;
		$this->format = $_format;
		$this->showTime = $_showTime;
		$this->attr = $_attr;
		$this->iconCal = URL_IMAGES."/icon/imgcal.gif";
	}
	
	function showJSCSS(){
		$html = "<SCRIPT src='".URL_JS."/calendar.js' type='text/javascript'></SCRIPT>";
		$html.= "<SCRIPT src='".URL_JS."/calendar-en.js' type='text/javascript'></SCRIPT>";
		$html.= "<SCRIPT src='".URL_JS."/calendar-setup.js' type='text/javascript'></SCRIPT>";
		$html.= "<link 	href='".URL_CSS."/calendar-system.css'	type='text/css' rel='stylesheet'/>";
		return $html;
	}
	
	function showInputDate(){
		$strShowTime = ($this->showTime)? "true" : "false";
		$id = "datepicker_".$this->name;
		$html = "<input type=\"text\" name=\"".$this->name."\" id=\"".$this->name."\" type=\"text\" value=\"".
					$this->value."\" ".$this->attr." />\n";
		$html.= "<a href='#' id='$id'>\n";
		$html.= "<img align=\"middle\" border=\"0\" src=\"".$this->iconCal."\" alt=\"Choose Date\" />\n";
		$html.= "</a>\n";
		$html.= "<script type=\"text/javascript\" language=\"JavaScript\">\n";
		$html.= "Calendar.setup({\n";
		$html.= "inputField     :    \"".$this->name."\",\n";
		$html.= "ifFormat       :    \"".$this->format."\",\n";		
		$html.= "showsTime      :    ".$strShowTime.",\n";
		$html.= "button         :    \"$id\",\n";
		$html.= "singleClick    :    false\n";
		$html.= "});\n";
		$html.= "</script>\n";
		$html.= "<script>\n";
		$format1 = str_replace("%", "", $this->format);
	//	echo $this->value;
		$value_format = ($this->value!="" && intval($this->value)>61200)? @date($format1, $this->value) : "";
		$html.= "document.getElementById(\"".$this->name."\").value = '".$value_format."';\n";
		$html.= "</script>\n";
		return $html;		
	}
}
?>