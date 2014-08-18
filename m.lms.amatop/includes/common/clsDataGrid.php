<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
/*
	Support some of data: LABEL(TEXT), SELECT, DATE, CHECKBOX
*/
class DataGrid extends Paging{
	var $columns 			=	array();
	var $totalCols			=	0;	
	var $tableAttrib		=	"";
	var $headerClass		=	"gridheader";
	var $headerClass1		=	"gridheader1";
	var $gridrowClass		=	"gridrow";
	var $gridrowClass1		=	"gridrow1";
	var $gridrowClass2		=	"gridrow2";
	var $gridrowClass3		=	"gridrow3";
	//
	var $orderby 	= "";
	var $table 		= 	"";
	var $cond 		= 	"";
	var $query 		= 	"";
	var $queryc 	= 	"";
	var $pkey 		= 	"";
	var $dataGrid 	= 	"";
	var $title		=	"Title";
	//function
	function DataGrid($_curPage="", $_rowsPerPage=10){
		Paging::Paging($_curPage, $_rowsPerPage);
	}
	//function
	function setDbTable($_table, $_cond=""){
		$this->table = $_table;
		$this->cond = $_cond;
	}
	//function
	function setDbQuery($_query, $_queryc){
		$this->query = $_query;
		$this->queryc = $_queryc;
	}	
	//function
	function setTitle($_title){
		$this->title = $_title;
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
	function get_Lang($key){
		global $_LANG_ID,$dbconn;
		$clsLang = new _Lang();
		$key_upper = strtoupper($key);
		$oneLang = $dbconn->getAll("select * from _lang where upper(keyword)='$key_upper'");
		if($oneLang[0]["value_1"]!=""){
			if($oneLang[0]["is_html"]=="0"){
				if($_LANG_ID =='vn'){
				return strip_tags(html_entity_decode($oneLang[0]["value_1"]));	
				}
				else if($_LANG_ID == 'en'){
					return strip_tags(html_entity_decode($oneLang[0]["value_2"]));	
				}
				else
					return 'unknow';
			}else{
				if($_LANG_ID =='vn'){
				return html_entity_decode($oneLang[0]["value_1"]);	
				}
				else if($_LANG_ID == 'en'){
					return html_entity_decode($oneLang[0]["value_2"]);	
				}
				else
					return 'unknow';
			}
			
		}else
			return html_entity_decode($key);
	}
	//function
	function getTitle(){
		return $this->title;
	}
	//function
	function setPkey($_pkey){
		$this->pkey = $_pkey;
	}
	//function
	function setOrderBy($_orderby=""){
		$this->orderby = $_orderby;
	}
	//function
	function addColumnHidden($colname){
		$this->columns[] = array("colname"=>$colname, "coltype"=>"hidden", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function	
	function addColumnLabel($colname,$coltitle="", $attrib="align='left'"){
		if (coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"label", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnText($colname,$coltitle="", $attrib="align='left'"){
		if (coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"text", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnOrderLabel($colname,$coltitle="", $attrib="align='left'"){
		if (coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"orderlabel", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnEmail($colname,$coltitle="", $attrib="align='left'"){
		if (coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"email", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnUrl($colname, $coltitle="", $attrib="align='left'", $tagA="<a href='%1%'>%1%</a>"){
		if (coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"url", "attrib"=>$attrib, "tagA"=>$tagA);
		$this->totalCols++;
	}
	//function
	function addColumnImage($colname,$coltitle="", $imgattr="border:0", $attrib="align='left'"){
		if (coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"image", "imgattr"=>$imgattr, "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnCheckBox($colname,$coltitle="", $attrib="align='left'", $arrContants=""){
		if (coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"checkbox", "attrib"=>$attrib, "arrContants"=>$arrContants);
		$this->totalCols++;
	}
	//function
	function addColumnSelect($colname,$coltitle="", $attrib="align='left'", $arrOptions="", $valueSameOption=0){
		if (coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"select", "attrib"=>$attrib, "arrOptions"=>$arrOptions, "valueSameOption"=> $valueSameOption);
		$this->totalCols++;
	}
	//function
	function addColumnDate($colname,$coltitle="", $attrib="align='left'", $date_format="m/d/Y"){
		if (coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"date", "attrib"=>$attrib, "date_format"=>$date_format);
		$this->totalCols++;
	}
	//function
	function showColumnLabel($c, $value){
		if (strlen($value)>200) $value = substr($value, 0, 200)."...";
		return html_entity_decode($value);
	}
	//function
	function showColumnEmail($c, $value){
		return "<a href='mailto:$value'>".$value."</a>";
	}
	/*//function
	function showColumnUrl($c, $value){
		return "<a href='$value' target='_blank'>".$value."</a>";
	}*/
	function showColumnUrl($c, $value){
		//$value.= "&return=".base64_encode($_SERVER['QUERY_STRING']);
		$tagA = str_replace("%1%", $value, $c["tagA"]);
		return $tagA;
	}
	//function
	function showColumnOrderLabel($c, $value) {
		return html_entity_decode($value);
	}
	//function
	function showColumnImage($c, $value){
		if(eregi('swf',$value))	
			return '<embed width="130px" allowscriptaccess="always" wmode="opaque" quality="high" bgcolor="#ffffff" name="cplayer" id="cplayer" src="'.URL_UPLOADS.'/'.$value.'" type="application/x-shockwave-flash"/>';
		else	
			return "<img src='".URL_UPLOADS."/$value' ".$c["imgattr"]." title='".$value."'>";
	}
	//function
	function showColumnText($c, $value, $pval){
		$name = $c["colname"];
		$html = "<input type=\"text\" name=\"".$name."List[".$pval."]\" id=\"$name\" value=\"$value\" style='width:100%'>\n";
		return $html;
	}
	//function
	function showColumnCheckBox($c, $value, $pval){
		return $value;
	}
	//function
	function showColumnSelect($c, $value, $pval=""){
		$html = "<select name='".$c["colname"]."List[".$pval."]' style='font-size:10px'>";
		if (is_array($c["arrOptions"])){
			foreach ($c["arrOptions"] as $key => $val){
				$val1 = ($valueSameOption==1)? $val : $key;
				$selected = ($val1==$value)? "selected" : "";
				$html.= "<option value='$val1' $selected >$val</option>\n";
			}
		}
		$html.= "</select>";
		return $html;
	}
	//function
	function showColumnDate($c, $value, $pval){
		return date($c["date_format"], $value);
	}
	//function
	function showColumn($c, $value, $pval=""){
		$html = "";
		switch ($c["coltype"]){
			case "label"	: $html.= $this->showColumnLabel($c, $value); break;
			case "text"		: $html.= $this->showColumnText($c, $value, $pval); break;
			case "checkbox"	: $html.= $this->showColumnCheckBox($c, $value, $pval); break;
			case "select"	: $html.= $this->showColumnSelect($c, $value, $pval); break;
			case "date"		: $html.= $this->showColumnDate($c, $value, $pval); break;
			case "email"	: $html.= $this->showColumnEmail($c, $value, $pval); break;
			case "url"		: $html.= $this->showColumnUrl($c, $value, $pval); break;
			case "image"	: $html.= $this->showColumnImage($c, $value, $pval); break;
			case "orderlabel"	: $html.= $this->showColumnOrderLabel($c, $value, $pval); break;
		}
		return $html;
	}
	//function
	function setTableAttrib($_attrib=""){
		$this->tableAttrib = $_attrib;
	}
	//function
	function setHeaderClass($_headerClass, $_headerClass1){
		$this->headerClass = $_headerClass;
		$this->headerClass1 = $_headerClass1;
	}
	//function
	function showJS(){
		$html="
<script language='javascript'>
function CheckAll() {
	 var fmobj = document.".$this->formName.";
	 for (var i=0;i<fmobj.elements.length;i++) {
		 var e = fmobj.elements[i];
		 if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
			 e.checked = fmobj.allbox.checked;
		 }
	 }
	 return true;
}
function save(){
	document.".$this->formName.".btnSave.value= \"Save\";
	document.".$this->formName.".submit();
}
function confirmDelete() {
	var total = 0;
	var fmobj = document.".$this->formName.";
	for (var i=0;i<fmobj.elements.length;i++) {
	 var e = fmobj.elements[i];
	 if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
		 if (e.checked) total++;
	 }
	}
	if (total==0){ 
		alert('".$this->get_Lang("YouMustChooseAtLeastOne")."');
		return false;
	}
	if (confirm('".$this->get_Lang("Doyouwanttodelete[OK]:Yes[Cancel]:No?")."')) {
		document.".$this->formName.".action = \"".$this->baseURL."&act=delete\";
		document.".$this->formName.".btnDelete.value= \"Delete\";
		document.".$this->formName.".submit();
		return true;
	}
	return false;
}
function confirmEdit() {
	var total = 0;
	var fmobj = document.".$this->formName.";
	var pvalue = 0;
	for (var i=0;i<fmobj.elements.length;i++) {
	 var e = fmobj.elements[i];
	 if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
		 if (e.checked){ 
		 	total++;
			pvalue = e.value;
		 }
	 }
	}
	if (total==0 ){ 
		alert('".$this->get_Lang("YouMustChooseAtLeastOne")."');
		return false;
	}
	if (total>1 ){ 
		alert('".$this->get_Lang("YouMustChooseAtLeastOne")."!');
		return false;
	}
	window.location = \"".$this->baseURL."&act=add&".$this->pkey."=\"+pvalue;
	return true;
}
</script>"."\n";
		return $html;
	}
	//function
	function showDataGrid($formName="", $startPage=0){
		global $mod;
		if ($theForm=="") $theForm = $this->formName;
		$intStart = ($this->curPage-$startPage)*$this->rowsPerPage;
		$orderby = strtolower($this->orderby);		
		if (isset($_GET["sortby"])){
			$sortby = $_GET["sortby"];
			$stype = isset($_GET["stype"])? $_GET["stype"] : "ASC";
			$orderby = $this->orderby = strtolower($sortby." ".$stype);
		}
		if ($orderby==""){
			$orderby = $this->columns[0]["colname"];
		}
		//link to DataSource
		$clsDataSource = new DataSource();
		$clsDataSource->setDbTable($this->table, $this->cond);
		if ($this->pkey!=""){
			$clsDataSource->addField($this->pkey);
		}
		if (is_array($this->columns))
		foreach ($this->columns as $key => $val){
			$clsDataSource->addField($val["colname"]);
		}
		$this->totalRows = $clsDataSource->getTotalRows();
		$this->dataGrid = $clsDataSource->getDataGrid($this->orderby, $intStart, $this->rowsPerPage);		
		//output HTML
		$html = $this->showJS();
		$html.= "<input type='hidden' name='btnSave' id='btnSave' value=''>"."\n";		
		$html.= "<input type='hidden' name='btnDelete' id='btnDelete' value=''>"."\n";
		$html.= '<table '.$this->tableAttrib.'>'."\n";
		$html.= '<tr>'."\n";
		if (is_array($this->columns)){
			$checkboxname = 'checkList';
			$html.= '<td width="1%" class="'.$this->headerClass.'"><input type="checkbox" name="allbox" value="0" onClick="return CheckAll()"/></td>'."\n";
			foreach ($this->columns as $k => $v){
				$hclass = ($k<$this->totalCols-1)? $this->headerClass : $this->headerClass1;
				$html.= '<td '.$v['attrib'].' class="'.$hclass.'" >';
				$html.= "<a href='".$this->baseURL."&page=".$this->curPage."&sortby=".$v["colname"].
						"' style='color:black' title='".$this->get_Lang("Sort_by")." \"".$v['coltitle']."\"'>".$this->getLang($v['coltitle']).
						"</a>";
				if (strpos($orderby, $v["colname"])!==false){
					$sortby = $v["colname"];
					$stype = (strpos($orderby, "desc")===false)? "DESC" : "ASC";
					$stype_text = ($stype=="ASC")? "Ascending" : "Descending";
					$ordertype = (strpos($orderby, "desc")===false)? "up" : "down";
					$html.= "<a href='".$this->baseURL."&page=".$this->curPage.
							"&sortby=$sortby&stype=$stype' title='".$stype_text."'>".
							" <img src='".URL_IMAGES."/icon/sort_{$ordertype}.gif' border='0'>".
							"</a>";
				}
				$html.= "</td>"."\n";
			}
		}
		$html.= '</tr>'."\n";
		if (is_array($this->dataGrid))
		foreach ($this->dataGrid as $key => $val){
			$rclass = ($key<$this->rowsPerPage-1 && $key<$this->totalRows-1)? $this->gridrowClass : $this->gridrowClass2;
			$html.= '<tr>'."\n";
			$html.= '<td width="1%" class="'.$rclass.'"><input type="checkbox" name="'.$checkboxname.'[]" value="'.$val->{$this->pkey}.'" /></td>'."\n";
			$current_row_down = $this->totalRows - $this->curPage*$this->rowsPerPage - $key;
			foreach ($this->columns as $k => $v)
			if ($v['coltype']!="hidden"){
				if ($k<$this->totalCols-1){
					$rclass = ($key<$this->rowsPerPage-1 && $key<$this->totalRows-1)? $this->gridrowClass : $this->gridrowClass2;	
				}else{
					$rclass = ($key<$this->rowsPerPage-1 && $key<$this->totalRows-1)? $this->gridrowClass1 : $this->gridrowClass3;	
				}				
				if ($k==0){			
					$href = $this->baseURL.'&act=add&'.$this->pkey.'='.$val->{$this->pkey};
					$html.= ($v['coltype']!='orderlabel')? (($mod=='_product')? '<td '.$v['attrib'].' class="'.$rclass.'" ><a class="item_name" href="'.$href.'" target="_blank">'.$this->showColumn($v, $val->$v['colname']).'</a></td>'."\n" : '<td '.$v['attrib'].' class="'.$rclass.'" ><a onclick="gotoUrl(\''.$href.'\')" class="item_name" href="#">'.$this->showColumn($v, $val->$v['colname']).'</a></td>'."\n") : (($mod=='product')? '<td '.$v['attrib'].' class="'.$rclass.'" ><a target="_blank" class="item_name" href="'.$href.'">'.$this->showColumn($v, $current_row_down).'</a></td>'."\n" : '<td '.$v['attrib'].' class="'.$rclass.'" ><a onclick="gotoUrl(\''.$href.'\')" class="item_name" href="#">'.$this->showColumn($v, $current_row_down).'</a></td>'."\n");
				}else{					
					$column_value = ($v['coltype']!='orderlabel')? $this->showColumn($v, $val->$v['colname'], $val->{$this->pkey}) : $this->showColumn($v, $val->$v['colname'], $current_row_down);
					if ($column_value=="") $column_value = "&nbsp;";
					$html.= ($v['coltype']!='orderlabel')? '<td '.$v['attrib'].' class="'.$rclass.'" >'.$column_value.'</td>'."\n" : '<td '.$v['attrib'].' class="'.$rclass.'" >'.$current_row_down.'</td>'."\n";
				}
			}
			$html.= '</tr>'."\n";	
		}			
		$html.= '</table>'."\n";
		return $html;
	}
	//function
	function saveData(){
		global $dbconn;
		foreach ($this->columns as $key => $val){
			$arrList = $_POST[$val["colname"]."List"];
			if (is_array($arrList))
			foreach ($arrList as $k => $v){
				$set = $val["colname"]."='".$v."'";
				$sql = "UPDATE ".$this->table." SET $set WHERE ".$this->pkey."='$k'";
				$dbconn->Execute($sql);
			}
		}
	}
}
?>