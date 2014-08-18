<?php
header("Content-type: image/png");
//$f = $_GET['f'];
//$l = $_GET['l'];
$f = str_replace (" ", "", $_GET['f']);
$l = str_replace (" ", "", $_GET['l']);
//$fDate = strtotime('2009-12-8');
//$lDate = strtotime('2009-12-31');
$fDate = strtotime($f);
$lDate = strtotime($l);
$st = tinh_so_tuan ($fDate,$lDate);
$wi = $st * 64 + 3;
$we=0;
$one_day = 60*60*24-30;
$str = '';
$im = @imagecreate($wi, 40)
    or die("Cannot Initialize new GD image stream");
$font = './arial.ttf';
$background_color = imagecolorallocate($im, 255, 255, 255);
$text_color = imagecolorallocate($im, 121, 0, 0);
//fist
$i=1;
$x1=0;$y1=0;$x2=64;$y2=39;
$x3=($x2+$x1)/2;
$x4=($x2+3*$x1)/4;
$x5=(3*$x2+$x1)/4;
$y3=($y2+$y1)/2;
$y4=($y2+3*$y1)/4;
$y5=(3*$y2+$y1)/4;
$str1 = 'Tuần '.$i;
$me = $fDate;
$str2 = date( "d/m",$me);
if (date("N",$me) != 7){
$me = strtotime('next Sunday',$me);
$str3 = date( "d/m",$me);
} else {$str3 = $str2;}
if( time() <= ($me+$one_day) )
{
	box2($im,$x1,$y1,$x2,$y2,$text_color,$background_color);
	CenterString($im,$x3,$y4,$str1,12,$background_color,$font);
	CenterString($im,$x4,$y5,$str2,8,$background_color,$font);
	CenterString($im,$x5,$y5,$str3,8,$background_color,$font);
} else {
	box($im,$x1,$y1,$x2,$y2,$text_color);
	CenterString($im,$x3,$y4,$str1,12,$text_color,$font);
	CenterString($im,$x4,$y5,$str2,8,$text_color,$font);
	CenterString($im,$x5,$y5,$str3,8,$text_color,$font);
}

//imagefilledrectangle($im, 500, 0, 700, 39, $text_color);
while ($me < $lDate)
	{
	$TT=$i+1;
	$str1 = 'Tuần '.$TT;
	$me = strtotime('next Monday',$me);
	$dt = $me;
	$str2 = date( "d/m",$me);
	$me = strtotime('next Sunday',$me);
	$ct = $me+$one_day;
		if($me < $lDate)
		{
			$str3 = date( "d/m",$me);
		} else {
			$we = 1;
			$str3 = date( "d/m",$lDate);
		}
	if (( $dt <= time() && time() <=$ct ) || ($we == 1 && time() >= $lDate ))
	{
		box2($im,$x1+$i*64,$y1,$x2+$i*64,$y2,$text_color,$background_color);
		CenterString($im,$x3+$i*64,$y4,$str1,12,$background_color,$font);
		CenterString($im,$x4+$i*64,$y5,$str2,8,$background_color,$font);
		CenterString($im,$x5+$i*64,$y5,$str3,8,$background_color,$font);
	}
	else 
	{	
		box($im,$x1+$i*64,$y1,$x2+$i*64,$y2,$text_color);
		CenterString($im,$x3+$i*64,$y4,$str1,12,$text_color,$font);
		CenterString($im,$x4+$i*64,$y5,$str2,8,$text_color,$font);
		CenterString($im,$x5+$i*64,$y5,$str3,8,$text_color,$font);
	}
	$i++;
	}
imagepng($im);
imagedestroy($im);

function box($im,$x1,$y1,$x2,$y2,$text_color)
{
imageline($im,$x1,$y1,$x2,$y1,$text_color);
imageline($im,$x2,$y1,$x2,$y2,$text_color);
imageline($im,$x2,$y2,$x1,$y2,$text_color);
imageline($im,$x1,$y2,$x1,$y1,$text_color);
imageline($im,$x1,($y2+$y1)/2,$x2,($y2+$y1)/2,$text_color);
imageline($im,($x2+$x1)/2,($y2+$y1)/2,($x2+$x1)/2,$y2,$text_color);
}
function box2($im,$x1,$y1,$x2,$y2,$bg,$lin)
{
imagefilledrectangle($im,$x1,$y1,$x2,$y2, $bg);
imageline($im,$x1,($y2+$y1)/2,$x2,($y2+$y1)/2,$lin);
imageline($im,($x2+$x1)/2,($y2+$y1)/2,($x2+$x1)/2,$y2,$lin);
}
function CenterString($image, $center_x, $center_y, $string, $font_size, $color, $font)
 {
 $bbox = imagettfbbox($font_size, 0, $font,$string);
 $text_width = $bbox[2] - $bbox[0];
 $text_height = $bbox[5] - $bbox[1];
 $x = $center_x - (ceil($text_width/2));
 $y = $center_y - (ceil($text_height/2));
 imagettftext($image,$font_size,0,$x,$y,$color,$font,$string);
 //ImageString($image, $font_size, $x, $y, $string, $color);
 }
 
function tinh_so_tuan ($fDate,$lDate)
{
$td = 8 - date("N",$fDate);
$tc = date("N",$lDate) - 0;
$one_day = 60*60*24;
$h = ($lDate - $fDate + $one_day ) / $one_day;
$giua = $h - $td - $tc;
$st = $giua/7 + 2;
return $st;
}
?>
