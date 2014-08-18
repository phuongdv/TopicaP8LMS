<?
function isMobileDevice(){ //return true;
	$isMobile = (bool)preg_match('#\b(ip(hone|od|ad)|android|opera m(ob|in)i|windows (phone|ce)|blackberry|tablet'.
		'|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.
		'|mobile|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i',$_SERVER['HTTP_USER_AGENT']);
	return $isMobile;
}
$bai = $_REQUEST['bai'];
$bai = 'Bai'.$bai;
$code = $_REQUEST['code'];
$xmlget = simplexml_load_string(file_get_contents('http://hoclieu.topica.vn/monhoc/monhoc.xml'));
$arrInfo = get_object_vars($xmlget->$code);
$MaGoc= $arrInfo['MaGoc'];
$xmlgetBai = simplexml_load_string(file_get_contents('http://hoclieu.topica.vn/monhoc/'.$MaGoc.'.xml'));
$arrBai = get_object_vars($xmlgetBai->$bai);
$referer=$_SERVER['HTTP_REFERER'];
if(isMobileDevice()){
	echo '<script> window.location.assign("'.$arrBai['new_slide'].'")</script>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $arrInfo['TenMon']; ?></title>
<link rel="stylesheet" href="trungvq/style.css" />
<script> 
	function onload(){
		document.domain = 'topica.vn';
		frames[0].location = '<? echo $arrBai['new_slide']; ?>';
	}
</script>
</head>

<body onload="onload()">
<div id="ja-header" class="wrap">
	<div class="main">
		<div class="inner clearfix">
			<h1 class="logo">
      		<a href="/index.php" target="_top" title="Topica - Cử nhân trực tuyến, uy tín quốc tế"><span><img height="80px" src="trungvq/logo.jpg" ></span></a>
			</h1>
			<div id="top_banner">
			</div>
			<div id="ja-login">
				<p><a target="_blank" title="Chương trình cử nhân trực tuyến TOPICA" href="http://www.topica.edu.vn"><img src="trungvq/logo.png"></a></p>
			</div>

		</div>
        
	</div>
    <div  class="bar">
    	<div class="inner clearfix" style="height:30px; padding-top:5px;">
        	<div style="width:100%; float:left; height:30px; background-color:#810C15;">
        		<div style="float:left; width:940px; padding-top:5px;">
        			<span style="padding-left:10px; color:#FFF; text-transform:uppercase;"><? echo $arrInfo['MaMon']; ?> : <? echo $arrInfo['TenMon']; ?></span>
            	</div>
            	<div style="width:60px; float:left;height:30px;">
            	<a href="<? echo $referer; ?>" style="padding-left:10px; color:#FFF; text-transform:uppercase;"><img src="trungvq/arrow_left.png" height="28" style=" position:absolute;" title="Quay lại" /></a>
            	</div>
            </div>
        </div>
    </div>
</div>

<div style="background-color:#606060;width:100%;" align="center">
	<iframe width="992px" scrolling="no" height="652px" frameborder="0" border="0" framespacing="0" src="<? echo $arrBai['new_slide']; ?>"></iframe>
</div>
</body>
</html>