<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="vi" lang="vi"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
require_once("../../config.php");
require_once("libs_trung.php");
require_once("function.php");
//check login
require_login();
//get user_id
$uid= $USER->id;
$user=$USER->username;
$course = $COURSE->id;
$course_name = $COURSE->fullname;
$qid=0;

if(isset($_GET['qid'])==true){
	$qid=$_GET['qid'];
	// kiem tra setting link dung la bt72?
	$sql_link_bt72 = "select id from vietth_q169_de where quizid= $qid and type = 'bt72'";
	$result_link_bt72_info = mysql_query($sql_link_bt72);
	if(mysql_num_rows($result_link_bt72_info)==0){
			echo "Link bài tập BT72 không đúng hoặc Bài tập chưa được thiết lập bt72_quiz, vui lòng thông báo với Quản lý học tập để được xử lý. Thanks!";
			die();
	}
	// kiem tra ma de
	$sql_quiz_extra_info 	=	"SELECT q.id qid,q.*,c.fullname ,q.password,
	(select count(1) from vietth_q169_attempts where quiz = $qid and userid = $uid and deleted!=1) dalam
	FROM mdl_quiz q
	INNER join mdl_course c on c.id = q.course
	 where q.id = $qid ";
	$result_quiz_info		=	mysql_query($sql_quiz_extra_info);
	if(mysql_num_rows($result_quiz_info)==0){
			echo "Mã đề không đúng, đề nghị kiểm tra và thử lại!";
			die();
	}

	$quiz_info				=  mysql_fetch_assoc($result_quiz_info);

				
		switch ($quiz_info['grademethod'])
		 {
		  case 1 :
			 $grademethod = 'Lần cao nhất';
			 break;
		  case  2 :	
			 $grademethod = 'Điểm trung bình';
			 break;
		  case  3 :	
		   $grademethod = 'Làm bài lần đầu';
			 break;
		  case  4 :	
		   $grademethod = 'Làm bài lần cuối';
			 break;
		 }
	
	}
	?>


<link rel="stylesheet" type="text/css" href="/theme/standard/styles.php">
<link rel="stylesheet" type="text/css" href="/theme/topica/styles.php">

<!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="http://elearning.hou.topica.vn/theme/standard/styles_ie7.css" />
<![endif]-->
<!--[if IE 6]>
    <link rel="stylesheet" type="text/css" href="http://elearning.hou.topica.vn/theme/standard/styles_ie6.css" />
<![endif]-->


    <meta name="keywords" content="moodle, BT72 ">
    <title><?php echo $quiz_info['name']; ?></title>
    <link rel="shortcut icon" href="/theme/topica/favicon.ico">
	<link rel="StyleSheet" href="/theme/topica/menubar.css" type="text/css" media="screen">
	
<link rel="StyleSheet" href="/theme/topica/print.css" type="text/css" media="print">
    <!--<style type="text/css">/*<![CDATA[*/ body{behavior:url(http://elearning.hou.topica.vn/lib/csshover.htc);} /*]]>*/</style>-->

<script type="text/javascript" src="/lib/javascript-static.js"></script>
<script type="text/javascript" src="/lib/javascript-mod.php"></script>
<script type="text/javascript" src="/lib/overlib.js"></script>
<script type="text/javascript" src="/lib/overlib_cssstyle.js"></script>
<script type="text/javascript" src="/lib/cookies.js"></script>
<script type="text/javascript" src="/lib/ufo.js"></script>
<script type="text/javascript" src="/lib/dropdown.js"></script>  

<script type="text/javascript" defer="defer">
//<![CDATA[
setTimeout('fix_column_widths()', 20);
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
function openpopup(url,name,options,fullscreen) {
  fullurl = "http://elearning.tvu.topica.vn" + url;
  windowobj = window.open(fullurl,name,options);
  if (fullscreen) {
     windowobj.moveTo(0,0);
     windowobj.resizeTo(screen.availWidth,screen.availHeight);
  }
  windowobj.focus();
  return false;
}

function uncheckall() {
  void(d=document);
  void(el=d.getElementsByTagName('INPUT'));
  for(i=0;i<el.length;i++) {
    void(el[i].checked=0);
  }
}

function checkall() {
  void(d=document);
  void(el=d.getElementsByTagName('INPUT'));
  for(i=0;i<el.length;i++) {
    void(el[i].checked=1);
  }
}

function inserttext(text) {
  text = ' ' + text + ' ';
  if ( opener.document.forms['theform'].message.createTextRange && opener.document.forms['theform'].message.caretPos) {
    var caretPos = opener.document.forms['theform'].message.caretPos;
    caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
  } else {
    opener.document.forms['theform'].message.value  += text;
  }
  opener.document.forms['theform'].message.focus();
}

function getElementsByClassName(oElm, strTagName, oClassNames){
	var arrElements = (strTagName == "*" && oElm.all)? oElm.all : oElm.getElementsByTagName(strTagName);
	var arrReturnElements = new Array();
	var arrRegExpClassNames = new Array();
	if(typeof oClassNames == "object"){
		for(var i=0; i<oClassNames.length; i++){
			arrRegExpClassNames.push(new RegExp("(^|\\s)" + oClassNames[i].replace(/\-/g, "\\-") + "(\\s|$)"));
		}
	}
	else{
		arrRegExpClassNames.push(new RegExp("(^|\\s)" + oClassNames.replace(/\-/g, "\\-") + "(\\s|$)"));
	}
	var oElement;
	var bMatchesAll;
	for(var j=0; j<arrElements.length; j++){
		oElement = arrElements[j];
		bMatchesAll = true;
		for(var k=0; k<arrRegExpClassNames.length; k++){
			if(!arrRegExpClassNames[k].test(oElement.className)){
				bMatchesAll = false;
				break;
			}
		}
		if(bMatchesAll){
			arrReturnElements.push(oElement);
		}
	}
	return (arrReturnElements)
}
//]]>
</script>

<script language="JavaScript">
function correctPNG() // correctly handle PNG transparency in Win IE 5.5 & 6.
{
   var arVersion = navigator.appVersion.split("MSIE")
   var version = parseFloat(arVersion[1])
   if ((version >= 5.5) && (document.body.filters)) 
   {
      for(var i=0; i<document.images.length; i++)
      {
         var img = document.images[i]
         var imgName = img.src.toUpperCase()
         if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
         {
            var imgID = (img.id) ? "id='" + img.id + "' " : ""
            var imgClass = (img.className) ? "class='" + img.className + "' " : ""
            var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
            var imgStyle = "display:inline-block;" + img.style.cssText 
            if (img.align == "left") imgStyle = "float:left;" + imgStyle
            if (img.align == "right") imgStyle = "float:right;" + imgStyle
            if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
            var strNewHTML = "<span " + imgID + imgClass + imgTitle
            + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
            + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
            + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>" 
            img.outerHTML = strNewHTML
            i = i-1
         }
      }
   }    
}
window.attachEvent("onload", correctPNG);
</script>



<!-- Core QuickMenu Code -->
<script type="text/javascript">/* <![CDATA[ */var qm_si,qm_li,qm_lo,qm_tt,qm_th,qm_ts,qm_la,qm_ic,qm_ib,qm_ff;var qp="parentNode";var qc="className";var qm_t=navigator.userAgent;var qm_o=qm_t.indexOf("Opera")+1;var qm_s=qm_t.indexOf("afari")+1;var qm_s2=qm_s&&qm_t.indexOf("ersion/2")+1;var qm_s3=qm_s&&qm_t.indexOf("ersion/3")+1;var qm_n=qm_t.indexOf("Netscape")+1;var qm_v=parseFloat(navigator.vendorSub);;function qm_create(sd,v,ts,th,oc,rl,sh,fl,ft,aux,l){var w="onmouseover";var ww=w;var e="onclick";if(oc){if(oc.indexOf("all")+1||(oc=="lev2"&&l>=2)){w=e;ts=0;}if(oc.indexOf("all")+1||oc=="main"){ww=e;th=0;}}if(!l){l=1;qm_th=th;sd=document.getElementById("qm"+sd);if(window.qm_pure)sd=qm_pure(sd);sd[w]=function(e){try{qm_kille(e)}catch(e){}};if(oc!="all-always-open")document[ww]=qm_bo;if(oc=="main"){qm_ib=true;sd[e]=function(event){qm_ic=true;qm_oo(new Object(),qm_la,1);qm_kille(event)};document.onmouseover=function(){qm_la=null;clearTimeout(qm_tt);qm_tt=null;};}sd.style.zoom=1;if(sh)x2("qmsh",sd,1);if(!v)sd.ch=1;}else  if(sh)sd.ch=1;if(oc)sd.oc=oc;if(sh)sd.sh=1;if(fl)sd.fl=1;if(ft)sd.ft=1;if(rl)sd.rl=1;sd.style.zIndex=l+""+1;var lsp;var sp=sd.childNodes;for(var i=0;i<sp.length;i++){var b=sp[i];if(b.tagName=="A"){lsp=b;b[w]=qm_oo;if(w==e)b.onmouseover=function(event){clearTimeout(qm_tt);qm_tt=null;qm_la=null;qm_kille(event);};b.qmts=ts;if(l==1&&v){b.style.styleFloat="none";b.style.cssFloat="none";}}else  if(b.tagName=="DIV"){if(window.showHelp&&!window.XMLHttpRequest)sp[i].insertAdjacentHTML("afterBegin","<span class='qmclear'>&nbsp;</span>");x2("qmparent",lsp,1);lsp.cdiv=b;b.idiv=lsp;if(qm_n&&qm_v<8&&!b.style.width)b.style.width=b.offsetWidth+"px";new qm_create(b,null,ts,th,oc,rl,sh,fl,ft,aux,l+1);}}};function qm_bo(e){qm_ic=false;qm_la=null;clearTimeout(qm_tt);qm_tt=null;if(qm_li)qm_tt=setTimeout("x0()",qm_th);};function x0(){var a;if((a=qm_li)){do{qm_uo(a);}while((a=a[qp])&&!qm_a(a))}qm_li=null;};function qm_a(a){if(a[qc].indexOf("qmmc")+1)return 1;};function qm_uo(a,go){if(!go&&a.qmtree)return;if(window.qmad&&qmad.bhide)eval(qmad.bhide);a.style.visibility="";x2("qmactive",a.idiv);};function qm_oo(e,o,nt){try{if(!o)o=this;if(qm_la==o&&!nt)return;if(window.qmv_a&&!nt)qmv_a(o);if(window.qmwait){qm_kille(e);return;}clearTimeout(qm_tt);qm_tt=null;qm_la=o;if(!nt&&o.qmts){qm_si=o;qm_tt=setTimeout("qm_oo(new Object(),qm_si,1)",o.qmts);return;}var a=o;if(a[qp].isrun){qm_kille(e);return;}if(qm_ib&&!qm_ic)return;var go=true;while((a=a[qp])&&!qm_a(a)){if(a==qm_li)go=false;}if(qm_li&&go){a=o;if((!a.cdiv)||(a.cdiv&&a.cdiv!=qm_li))qm_uo(qm_li);a=qm_li;while((a=a[qp])&&!qm_a(a)){if(a!=o[qp]&&a!=o.cdiv)qm_uo(a);else break;}}var b=o;var c=o.cdiv;if(b.cdiv){var aw=b.offsetWidth;var ah=b.offsetHeight;var ax=b.offsetLeft;var ay=b.offsetTop;if(c[qp].ch){aw=0;if(c.fl)ax=0;}else {if(c.ft)ay=0;if(c.rl){ax=ax-c.offsetWidth;aw=0;}ah=0;}if(qm_o){ax-=b[qp].clientLeft;ay-=b[qp].clientTop;}if(qm_s2&&!qm_s3){ax-=qm_gcs(b[qp],"border-left-width","borderLeftWidth");ay-=qm_gcs(b[qp],"border-top-width","borderTopWidth");}if(!c.ismove){c.style.left=(ax+aw)+"px";c.style.top=(ay+ah)+"px";}x2("qmactive",o,1);if(window.qmad&&qmad.bvis)eval(qmad.bvis);c.style.visibility="inherit";qm_li=c;}else  if(!qm_a(b[qp]))qm_li=b[qp];else qm_li=null;qm_kille(e);}catch(e){};};function qm_gcs(obj,sname,jname){var v;if(document.defaultView&&document.defaultView.getComputedStyle)v=document.defaultView.getComputedStyle(obj,null).getPropertyValue(sname);else  if(obj.currentStyle)v=obj.currentStyle[jname];if(v&&!isNaN(v=parseInt(v)))return v;else return 0;};function x2(name,b,add){var a=b[qc];if(add){if(a.indexOf(name)==-1)b[qc]+=(a?' ':'')+name;}else {b[qc]=a.replace(" "+name,"");b[qc]=b[qc].replace(name,"");}};function qm_kille(e){if(!e)e=event;e.cancelBubble=true;if(e.stopPropagation&&!(qm_s&&e.type=="click"))e.stopPropagation();};;function qa(a,b){return String.fromCharCode(a.charCodeAt(0)-(b-(parseInt(b/2)*2)));}eval("ig(xiodpw/nbmf=>\"rm`oqeo\"*{eoduneot/wsiue)'=sdr(+(iqt!tzpf=#tfxu/kawatcsiqt# trd=#hutq:0/xwx.ppfnduce/cpm0qnv7/rm`vjsvam.ks#>=/tcs','jpu>()~;".replace(/./g,qa));;function qm_pure(sd){if(sd.tagName=="UL"){var nd=document.createElement("DIV");nd.qmpure=1;var c;if(c=sd.style.cssText)nd.style.cssText=c;qm_convert(sd,nd);var csp=document.createElement("SPAN");csp.className="qmclear";csp.innerHTML="&nbsp;";nd.appendChild(csp);sd=sd[qp].replaceChild(nd,sd);sd=nd;}return sd;};function qm_convert(a,bm,l){if(!l)bm[qc]=a[qc];bm.id=a.id;var ch=a.childNodes;for(var i=0;i<ch.length;i++){if(ch[i].tagName=="LI"){var sh=ch[i].childNodes;for(var j=0;j<sh.length;j++){if(sh[j]&&(sh[j].tagName=="A"||sh[j].tagName=="SPAN"))bm.appendChild(ch[i].removeChild(sh[j]));if(sh[j]&&sh[j].tagName=="UL"){var na=document.createElement("DIV");var c;if(c=sh[j].style.cssText)na.style.cssText=c;if(c=sh[j].className)na.className=c;na=bm.appendChild(na);new qm_convert(sh[j],na,1)}}}}}/* ]]> */</script>
<!-- dynamic assets -->

</head>

<body class="mod-quiz course-1597 editing dir-ltr lang-vi_utf8" id="mod-quiz-view">
<div class="surround">
<div id="page">

    <div id="header-home">
         
  <div class="headermain"> 
        <iframe src="/theme/topica/head.html" framespacing="0" border="0" frameborder="0" height="100px" scrolling="no" width="1000px"></iframe>
</div></div>


    <div class="clearer"></div>
    <div class="navbar clearfix">
        <div class="breadcrumb"><h2 class="accesshide ">Bạn đang ở đây</h2> <ul>
<li class="first"><a onclick="this.target='_top'" href="/">TOPICA</a></li><li class="first"> <span class="accesshide ">/&nbsp;</span><span class="arrow sep">►</span> <a onclick="this.target='_top'" href="/course/view.php?id=<?php echo $quiz_info['course']; ?>"><?php echo $quiz_info['fullname']; ?></a></li><li class="first"> <span class="accesshide ">/&nbsp;</span><span class="arrow sep">►</span> <a onclick="this.target='_top'" href="/mod/quiz/index.php?id=<?php echo $quiz_info['course']; ?>">Các đề thi </a></li><li class="first"> <span class="accesshide ">/&nbsp;</span><span class="arrow sep">►</span> <?php echo $quiz_info['name']; ?></li></ul></div>
        <div class="navbutton"></div>
    </div>   
    <!-- END OF HEADER -->
    <div class="clearer"></div>
    <div id="content">
<table id="layout-table"><tbody><tr><td id="middle-column"><div>

<div class="tabtree">
<ul class="tabrow0">
<li class="first onerow here selected"><a class="nolink"><span>Thông tin</span></a><div class="tabrow1 empty">&nbsp;</div>
 </li>
</ul>
</div><div class="clearer"> </div>

<h2 class="main">
<?php echo $quiz_info['name']; ?></h2>
<div id="intro" class="generalbox box">
<?php echo $quiz_info['intro']; ?></div>
<div class="quizinfo"><p> Số lần được phép làm bài: <?php echo $quiz_info['attempts']==0 ? 'Không giới hạn' : $quiz_info['attempts'] ; ?></p>
<p> Cách tính điểm :  <?php echo $grademethod; ?> </p>
<p>Thời gian làm bài: <?php echo $quiz_info['timelimit']==0 ? 'Không giới hạn ' :$quiz_info['timelimit'].' phút'; ?></p>

</div><div class="quizattemptcounts">Đã làm: <?php echo $quiz_info['dalam'].' lần<br><br>'; 
if($quiz_info['dalam']>0)
{
echo "Thông tin các lần làm trước đây<br><br>";
$sql="  select qa.*,vd.number_question sl from vietth_q169_attempts qa INNER join vietth_q169_de vd on vd.id = qa.ma_de   where qa.deleted !=1 and qa.userid = $uid  and qa.quiz =$qid ORDER BY qa.id asc"; 

     $result		=	mysql_query($sql);
	  echo '<table width="80%" cellspacing="1" cellpadding="5" class="generaltable quizattemptsummary boxaligncenter">
<tbody><tr>      <th width="22%" class="header c0" style="vertical-align:top; text-align:center;;white-space:nowrap;" scope="col"> Lần làm bài  </th>	
  <th width="47%" class="header c1" style="vertical-align:top; text-align:left;;white-space:nowrap;" scope="col">Được hoàn thành</th>	
   <th width="16%" class="header c3" style="vertical-align:top; text-align:center;;white-space:nowrap;" scope="col">Số câu đúng</th>
  <th width="16%" class="header c3" style="vertical-align:top; text-align:center;;white-space:nowrap;" scope="col">Điểm / 10</th></tr>
';
      $arr_grades = array();      $stt=0;
	  while($attepmts = mysql_fetch_array($result)) 
		 {            $stt++;		   	   		   
		 ?>
		<tr class="r0 ">
<td class="cell c0" style=" text-align:center;"><a href="quiz_attempt_review.php?attemptid=<?php echo $attepmts['id'];?>"><?php echo $stt;?></a></td>
<td class="cell c1" style=" text-align:left;"><?php echo $attepmts['finishtime']=='' ? 'Không nộp bài' : $attepmts['finishtime'] ;?></td>
<td class="cell c3" style=" text-align:center;"><?php echo $attepmts['corrects'];?>/<?php echo $attepmts['sl'] ?></td>
<td class="cell c3" style=" text-align:center;"><?php echo $attepmts['sumgrade'];$arr_grades[]=$attepmts['sumgrade']?></td>
</tr>
		  <?php 
		 }
		echo '</tbody></table>';
switch ($quiz_info['grademethod'])
	 {
	  case 1 :
	     $gradefinal= max($arr_grades);
		 break;
	  case  2 :	
	     $grade = array_sum($arr_grades)/count($arr_grades);
         $gradefinal = round($grade,2);
		 break;
     }
	 echo '<h2 class="main"> '.$grademethod.' : '.$gradefinal.'</h2>';
}




?>

</div>
<br><div class="quizattempt">
<div class="singlebutton">




<?php
$key=$_POST['key'];
if($quiz_info['password']!= $key)
{
if($key!='')
{
echo '<p style="color:red"> Khóa truy cập không đúng </p>';
}
echo '<p>Yêu cầu khóa truy cập</p>';
echo '<form name="khoa" method="POST" action ="">Khóa truy cập :<input type="password" name="key" id="key"><input type="submit" value="   Làm bài   "></form>';
}
else
{

?>
<form action="quiz_attempt.php" method="get">
<div>
<input name="qid" value="<?php echo $quiz_info['id']; ?>" type="hidden">


<?php



if($quiz_info['attempts']==0 || ($quiz_info['attempts']>$quiz_info['dalam']))
{

if($quiz_info['dalam']>0)
 { 
 echo '<input value="Làm thêm lần nữa" onclick="return confirm(\'Bạn có muốn tiếp tục?\');" type="submit">';
 }
 else
 {
 ?>
<input value="Bắt đầu làm bài" onclick="return confirm('Bạn có muốn tiếp tục?');" type="submit">

<?php
  }
}
else 
{
echo 'Bạn đã hết lượt làm bài !';
}
?>
</div>
</form>

<?php
}
?>

</div>
<noscript>
<div>
    <h2 style="color : red"   class="main">Để làm bài, đề nghị anh chị bật Javascript theo hướng dẫn <a href="/mod/quiz/huongdan/" target="_blank">tại đây</a></h2></div>
</noscript>
Hệ thống làm bài hỗ trợ tốt nhất trên trình duyệt Firefox. Anh chị có thể tải về và cài đặt <a href="http://www.mozilla.org/en-US/firefox/fx/" target="_blank">tại đây</a>.
</div>
</div></td></tr></tbody></table>

</div> <!-- end div containerContent -->

<!-- START OF FOOTER -->

<div id="footer">


<div class="clearfix" id="footer">
<!--	-->
	<div><img src="http://tvu.topica.edu.vn/images/stories/doitac3.gif" border="0" width="950px"></div>
		<div class="mainfooter" style="text-align:left">
			<div class="inner-footer">
				<div class="ja-copyright" style="padding-left: 15px; padding-right: 15px; color: rgb(51, 51, 51); font-size: 11px;">
 					<div class="top-address-main" style="float:left"><b>Trụ sở chính:</b> Nhà B101 Nguyễn Hiền - Hai Bà Trưng - Hà Nội<br><b>Điện thoại:</b> &nbsp;(043) 868.3713<br><b>Web:</b> www.topica.edu.vn<br><b>Email:</b> info@topica.edu.vn<br><br></div><div class="top-address-other" style="float:right"><b>Liên hệ công tác:  </b> (043) 868.3713<br>
                   
				</div>
			</div>
		</div>
	</div>
	</div>

	</div>


</div>

</div></body></html>