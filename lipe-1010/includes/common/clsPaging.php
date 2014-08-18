<?
//nothing
class Paging{
	var $baseURL			=	"";
	var $formName 			=	"";	
	var $curPage			=	0;
	var $hasPaging			=	true;
	var $totalRows			=	0;
	var $totalPage 			=	0;
	var $rowsPerPage		=	10;
	var $showPageNums		=	5;
	var $showPrevLink		=	true;
	var $showNextLink		=	true;
	var $showFirstLink 		=	true;
	var $showLastLink		=	true;
	var $showGotoBox		=	true;
	
	function Paging($_curPage="", $_rowsPerPage=10){
		if (isset($_POST["gotoPage"]) && $_POST["gotoPage"]!=""){
			$this->curPage = $_POST["gotoPage"];
		}else{
			if ($_curPage==NULL){
				$_curPage = isset($_REQUEST["page"])? $_REQUEST["page"] : 0;
			}
			$this->curPage = $_curPage;
		}
		$this->rowsPerPage = $_rowsPerPage;
	}
	
	function setBaseURL($_baseURL=""){
		$this->baseURL = $_baseURL;
	}
	
	function setFormName($_formName="theForm"){
		$this->formName = $_formName;
	}
	
	function setCurPage($_curPage=0){
		$this->curPage = $_curPage;
	}
	
	function setHasPaging($_hasPaging=true){
		$this->hasPaging = $_hasPaging;
	}
	
	function setTotalRows($_totalRows=0){
		$this->totalRows = $_totalRows;
	}
	
	function setRowsPerPage($_rowsPerPage=10){
		$this->rowsPerPage = $_rowsPerPage;
	}
	
	function setShowPageNums($_showPageNums=0){
		$this->showPageNums = $_showPageNums;
	}
	
	function setShowPrevLink($_showPrevLink=true){
		$this->showPrevLink = $_showPrevLink;
	}
	
	function setShowNextLink($_showNextLink=true){
		$this->showNextLink = $_showNextLink;
	}
	
	function setShowFirstLink($_showFirstLink=true){
		$this->showFirstLink = $_showFirstLink;
	}
	
	function setShowLastLink($_showLastLink=true){
		$this->showLastLink = $_showLastLink;
	}

	function setShowGotoBox($_showGotoBox=true){
		$this->showGotoBox = $_showGotoBox;
	}
	function getLang($key){
		global $_LANG;
		if (strpos($key, " ")!==false){
			$arr = str_word_count($key, 1);
			foreach ($arr as $k => $v){
				$val = trim($v, "'?,");
				$trans= (isset($_LANG[$val]))? $_LANG[$val] : $val;
				$key = str_replace($val, $trans, $key);
				
			}
			return $key;
		}else{
			$val = trim($key, "'?,");
			$trans= (isset($_LANG[$val]))? $_LANG[$val] : $val;
			$key = str_replace($val, $trans, $key);
			return $key;
		}
		return $key;
	}
	function showPaging($theForm=""){
		if ($theForm=="") $theForm = $this->formName;
		$this->totalPage = ceil($this->totalRows/$this->rowsPerPage);
		//echo $this->curPage;
		$gotoPageOptions = "";
		for ($i=0; $i<$this->totalPage; $i++){
			$selected = ($this->curPage==$i)? "selected" : "";
			$gotoPageOptions.="<option value='$i' $selected >".($i+1)."</option>";
		}
		$butNext = ($this->curPage < $this->totalPage-1)? "<a href='$this->baseURL&page=".($this->curPage+1)."' title='".($this->curPage+2)."'>".$this->getLang("Next")."</a>" : $this->getLang("Next");
		$butPrev = ($this->curPage > 0)? "<a href='$this->baseURL&page=".($this->curPage-1)."' title='".($this->curPage)."'>".$this->getLang("Prev")."</a>" : $this->getLang("Prev");
		$listPage = "";
		$first = intval($this->curPage/$this->showPageNums)*$this->showPageNums;
		for ($i=0; $i<$this->showPageNums; $i++)
		if ($first+$i<$this->totalPage){
			$p = $first+$i;
			$t = ($this->curPage == $p)? "<b>".($p+1)."</b>" : ($p+1);
			$listPage .= ($this->curPage!=$p)? "<a href='".$this->baseURL."&page=$p' title='".($p+1)."'>$t</a>&nbsp" : "$t&nbsp;";		
		}
		if ($listPage=="") $listPage = "0";
		$butNNext = ($first+$this->showPageNums<$this->totalPage-1)? "<a href='$this->baseURL&page=".($first+$this->showPageNums)."'  title='".($first+$this->showPageNums+1)."'>...</a>" : "";
		$butPPrev = ($first-$this->showPageNums>=0)? "<a href='$this->baseURL&page=".($first-$this->showPageNums)."' title='".($first-$this->showPageNums+1)."'>...</a>" : "";
		
		
		if ($this->className!="")
			$html ="<table class='".$this->className."'>";
		else
			$html ="<table cellpadding='0' cellspacing='0' width='100%' border='0' style='font-size:12px'>";
		$html.="<tr>";
		$html.=	"<td width='30%' align='left' nowrap>".$this->getLang("Total").":".$this->totalRows." ".$this->getLang("row")."(s), ".$this->totalPage." ".$this->getLang("page")."(s)</td>";
		$html.= "<td width='40%' align='center' nowrap>  $butPrev | $butPPrev $listPage $butNNext | $butNext </td>";
		if ($this->showGotoBox){
			$html.= "<td width='30%' align='right' nowrap>".$this->getLang("Goto page").":";
			$html.= "<select name='gotoPage' style='font-size:11px' onChange='document.$theForm.submit()'>$gotoPageOptions</select></td>";
		}else{
			$html.= "<td width='30%' align='right' nowrap></td>";
		}
		$html.="</tr>";
		$html.="</table>";
		return $html;
	}
}
?>