<?
$bai = $_REQUEST['bai'];
$bai = 'Bai'.$bai;
$code = $_REQUEST['code'];
$xmlget = simplexml_load_string(file_get_contents('http://hoclieu.topica.vn/monhoc/monhoc.xml'));
$arrInfo = get_object_vars($xmlget->$code);
$MaGoc= $arrInfo['MaGoc'];
$xmlgetBai = simplexml_load_string(file_get_contents('http://hoclieu.topica.vn/monhoc/'.$MaGoc.'.xml'));
$arrBai = get_object_vars($xmlgetBai->$bai);
$referer=$_SERVER['HTTP_REFERER'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $arrInfo['TenMon']; ?></title>
<link rel="stylesheet" href="trungvq/style.css" />

</head>

<body >
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

<div style="width:100%" style="background-color:#606060;" align="center">
	<iframe width="992px" scrolling="no" height="652px" frameborder="0" border="0" framespacing="0" src="<? echo $arrBai['slide']; ?>"></iframe>
</div>
</body>
</html>