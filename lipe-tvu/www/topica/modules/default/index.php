<?
$sub = $stdio->GET("sub", "default");
$act = $stdio->GET("act", "default");
$clsModule = new Module("default");
$clsModule->run($sub, $act);	

$assign_list["sub"] = $sub;
$assign_list["act"] = $act;	

$clsCP = new ControlPanel();


														

# Tour Content Management
$clsCP->addSection("Tour", $core->getLang("Quản lý học viên"));
$clsCP->addLink("Tour",
				"admin_tours",
				$core->getLang("Quản lý user"),
				"?{$_SITE_ROOT}&mod=user",
				URL_IMAGES."/largeicon/boxnet.png");
	

/*$clsCP->addLink("Tour",
				"admin_menu",
				$core->getLang("Quáº£n lÃ½ ngÃ nh há»�c"),
				"?{$_SITE_ROOT}&mod=category",
				URL_IMAGES."/largeicon/boxnet.png");
				*/
$clsCP->addLink("Tour",
				"admin_lipe",
				$core->getLang("Báo cáo tình hình học tập"),
				"?{$_SITE_ROOT}&mod=lipe",
				URL_IMAGES."/largeicon/boxnet.png");


# Controller System Management
$clsCP->addSection("system", $core->getLang("System-Management"));


$clsCP->addLink("system",
				"_module",
				"Modules",
				"?{$_SITE_ROOT}&mod=_module",
				URL_IMAGES."/largeicon/package.png");

/*$clsCP->addLink("system",
				"admin_user",
				$core->getLang("Users-Config"),
				"?{$_SITE_ROOT}&mod=user",
				URL_IMAGES."/largeicon/k-User-Quan-ly-nguoi-dung.gif");
$clsCP->addLink("system",
				"admin_usergroup",
				$core->getLang("User-Groups"),
				"?{$_SITE_ROOT}&mod=usergroup",
				URL_IMAGES."/largeicon/n-UserGroup-Quan-ly-nhom-nguoi-dung.gif");*/

$clsCP->expandSection("content");
$clsCP->collapseSection("primary");
$clsCP->collapseSection("system");

$assign_list["clsCP"] = $clsCP;

class ControlPanel{
	var $arrSection		=	array();
	var $onLoadFunc		=	"";
	
	function ControlPanel(){
	
	}
	
	function addSection($name, $title="Title of Section"){
		$this->arrSection[$name] = array();
		$this->arrSection[$name]["title"] = $title;
	}
	
	function addLink($section_name, $site_name, $link_name="", $link_href="", $imgsrc=""){
		$arr = array();
		$arr["site_name"] = $site_name;
		$arr["link_name"] = $link_name;
		$arr["link_href"] = $link_href;
		$arr["imgsrc"] = $imgsrc;
		$this->arrSection[$section_name]["link"][] = $arr;
	}
	
	function showSection($section_name){
		global $_SITE_ROOT, $core;
		$html = "<!--------------->\n";
		$i = 0;
				
		foreach ($this->arrSection[$section_name]["link"] as $key => $val)
		if ($core->_PERMISS[$val["site_name"]]["L"]>0 || $core->isAdmin()){
			$section_title = $this->arrSection[$section_name]["title"];
			if ($i==0){
				$html.= "<div id='div_$section_name' style=\"font-size:12px; padding-top:5px; padding-left:20px\">\n
<strong><img id='img_$section_name' src='".URL_IMAGES."/admin/nolines_minus.gif' border=0 align=left onClick=\"changeSection('tbl_$section_name', 'img_$section_name')\" style='cursor:pointer'>".$section_title."</strong><br />
<img src='".URL_IMAGES."/admin/bline.jpg' align='top'/>
</div>\n";
				$html.= "<table id='tbl_$section_name' cellpadding=\"5\" cellspacing=\"10\" style=\"font-size:12px;display:\">\n";
				$html.= "<tr>\n";
			}
			$i++;
			
			$html.= "<td class=\"tdlargeicon\" onmousemove=\"this.className='tdlargeiconActive'\"  onmouseout=\"this.className='tdlargeicon'\" onClick=\"gotoUrl('".$val["link_href"]."')\">\n";
			$html.= "<div align='center'>\n";
			$html.= "<img src=\"".$val["imgsrc"]."\"/><br />\n";
			$html.= $val["link_name"]."\n";
			$html.= "</div>\n";
			$html.= "</td>\n";
			if ($i%5==0){
				$html.= "</tr>\n";
				$html.= "<tr>\n";
			}
		}
		if ($i>0 && $i%5==0){
			$html.="<td></td>";
		}
		if ($i>0){
			$html.= "</tr>\n";
			$html.= "</table>\n<!--------------->\n";
		}
		return $html;
	}
	
	function expandSection($section_name){
		$this->onLoadFunc.= "expandSection('tbl_$section_name', 'img_$section_name');";
	}
	
	function collapseSection($section_name){
		$this->onLoadFunc.= "collapseSection('tbl_$section_name', 'img_$section_name');";
	}
	
	function showOnLoadFunc(){
		$html.= "<script language='javascript'>";
		$html.= "function onLoadFunc(){";
		$html.= $this->onLoadFunc;
		$html.= "}"; 
		$html.= "</script>";
		return $html;
	}
	
	function showAllSection(){
		$html = "";
		if (is_array($this->arrSection))
		foreach ($this->arrSection as $key => $val){
			$html.= $this->showSection($key);
		}
		return $html;
	}
}
?>