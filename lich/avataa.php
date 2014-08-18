<?php

header("Content-type: image/png");
$im = @imagecreate(90, 90)
    or die("Cannot Initialize new GD image stream");
$font = './arial.ttf';
$background_color = imagecolorallocate($im, 255, 255, 255);
$text_color = imagecolorallocate($im, 255, 0, 0);
$ngay = date("j");
$thang = date("n");
$nam = date("Y");
$gio = date("h");
$phut = date("i");
CenterString($im,45,10,'Bây giờ là:',11,$text_color,$font);
$str1 = $gio.'giờ'.$phut;
CenterString($im,45,33,$str1,13,$text_color,$font);
$str2 = "ngày $ngay tháng $thang";
CenterString($im,45,52,$str2,9,$text_color,$font);
$str3 = 'năm '.$nam;
CenterString($im,45,75,$str3,12,$text_color,$font);
imagepng($im);
imagedestroy($im);
function CenterString($image, $center_x, $center_y, $string, $font_size, $color, $font)
 {
 $bbox = imagettfbbox($font_size, 0, $font,$string);
 $text_width = $bbox[2] - $bbox[0];
 $text_height = $bbox[5] - $bbox[1];
 $x = $center_x - (ceil($text_width/2));
 $y = $center_y - (ceil($text_height/2));
 imagettftext($image,$font_size,0,$x,$y,$color,$font,$string);
 }
 

?>
