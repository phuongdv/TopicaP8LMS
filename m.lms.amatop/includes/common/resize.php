<?
/**
*  Created by   :
*  @author		: Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
$filename = $_GET['f'];

$width = $_GET['w'];

$height = $_GET['h'];

header('Content-type: image/jpeg');
list($width_orig, $height_orig) = getimagesize($filename);
$ratio_orig = $width_orig/$height_orig;
if ($width/$height > $ratio_orig) {
   $width = $height*$ratio_orig;
} else {
   $height = $width/$ratio_orig;
}

$image_p = imagecreatetruecolor($width, $height);
$image = imagecreatefromjpeg($filename);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
imagejpeg($image_p, null, 100);
?>