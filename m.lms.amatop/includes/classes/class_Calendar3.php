<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
$monthTextArr = array(	"", "January", "February", "March", "April", 
						"May", "June" ,	"July" ,"August" ,
						"September", "October", "November", "December"
				);
$monthDaysArr = array("31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31");
$wdayArr = array("S", "M", "T", "W", "T", "F", "S");

//class Calendar
class Calendar3{
	var $curYear = 2005;
	var $curMonth = 1;
	var $curDay = 1;
	var $monthDays = array();
	var $today=array();
	function Calendar3($_curYear="", $_curMonth="", $_curDay=""){
		global $monthDaysArr;
		$this->monthDays = $monthDaysArr;
		$this->init();
		if ($_curYear!="") $this->curYear = $_curYear;
		if ($_curMonth!="") $this->curMonth = $_curMonth;
		if ($_curDay!="") $this->curDay = $_curDay;
		if ($this->isLeapYear()){
			$this->monthDays[1] = 29;
		}
		//check validate
		if ($this->curYear<1970){
			die("<b>Error: Year must be > 1970 !</b>");
			exit();
		}
		if ($this->curMonth>12 || $this->curMonth<1){
			die("<b>Error: Month must be >=1, <= 12 !</b>");
			exit();		
		}
		if ($this->curDay>$this->monthDays[$this->curMonth-1] || $this->curDay<1){
			die("<b>Error: Day must be >=1, <= ".$this->monthDays[$this->curMonth-1]." !</b>");
			exit();					
		}
	}
	function init(){
		$this->today = getdate();
		$this->curYear = $this->today['year'];
		$this->curMonth = $this->today['mon'];
		$this->curDay = $this->today['mday'];
	}
	function getNextYear(){
		$this->nextYear=($this->curYear+1);
		return $this->nextYear;
	}
	function getPrevYear(){
		$this->prevYear=($this->curYear-1);
		return $this->prevYear;
	}
	function getwDay(){
		$timest = mktime(0, 0, 0, $this->curMonth, $this->curDay, $this->curYear);
		$thisday = getdate($timest);
		return $thisday['wday'];	
	}
	//check leap Year ?
	//return true(false)
	function isLeapYear($thisyear=""){
		if ($thisyear=="") $thisyear = $this->curYear;
		return ((($thisyear % 4 == 0) && !($thisyear % 100 == 0))	||($thisyear % 400 == 0));
	}
	function html_month_list($width="", $align='left', $additional=""){
		global $monthTextArr;
		$html = "";
		for ($i=0; $i<12; $i++){
			$m = $i+1;
			$text = ($m!=$this->curMonth)? $monthTextArr[$i] : "<b>".$monthTextArr[$i]."</b>";
			$text = "<a href='?month=$m&year=".$this->curYear."&day=".$this->curDay."' title='Month: $m'>".$text."</a>";
			$html .= "<td width='$width' height='20' align='$align' $additional>$text</td>";
		}
		return $html;
	}
	function html_day_month_list($day=""){
		global $monthDaysArr, $wdayArr, $monthTextArr;
		$mday = $this->curDay;
		$wday = $this->getwDay();
		$spaces = $mday;
		while ($spaces>7) $spaces -= 7;
		$spaces = $wday - $spaces + 1;
		if ($spaces<0) $spaces += 7;
		$html = "<table cellspadding='0' cellspacing='5' width='100%' border=1 bordercolor=#345487>";
		$html .= "<tr>";
		$html .= "<td colspan='7' align=center><b>".$monthTextArr[$this->curMonth].",".$this->curYear."</b></td>";
		$html .= "</tr>";
		$html .= "<tr>";
		for ($i=0; $i<7; $i++)
		if ($i==0 || $i==6)
			$html .= "<th align='center' width='14%'><font color=red>".$wdayArr[$i]."</font></th>";
		else
			$html .= "<th align='center' width='14%'>".$wdayArr[$i]."</th>";
		$html .= "</tr>";
		$html .= "<tr>";
		for ($i=0; $i<$spaces; $i++){
			$html .= "<td></td>";
		}
		$count = 1;
		while ($count<=$this->monthDays[$this->curMonth-1]){
			for ($i=$spaces; $i<7; $i++){
				$html .= ($count==$day)? "<td align='center' bgcolor='#cccccc'>" : "<td align='center'>";
				if ($count<=$this->monthDays[$this->curMonth-1]){
					$text = ($count==$day)? "<font color='blue'><b>$count</b></font>" : "";
					if ($text=="")
						$text = ($count==$this->today['mday'])? "<font color='FF0000'><b>$count</b></font>" : $count;
					//$html .= addLink($text, "?act=view&day=".$count."&month=".$this->curMonth."&year=".$this->curYear, "title='Day:".$mday." Month:".$this->curMonth." Year:".$this->curYear."'");
					$html.= addLink($text, "#", "title='Day:".$mday." Month:".$this->curMonth." Year:".$this->curYear."'");
				}
				$html .= "</td>";
				$count++;
			}
			$html .= "</tr>";
			$html .= "<tr>";
			$spaces = 0;
		}
		$html .= "</table>";
		return $html;
	}
	function getDateSt(){
		return $this->curYear."/".$this->curMonth."/".$this->curDay;
	}
}
//function addLink: add a hyperlink 
function addLink($day="1", $href="", $additional=""){
	return "<a href='$href' $additional>$day</a>";
}

?>