<?
$imagefile = isset($_REQUEST["f"])? $_REQUEST["f"] : "";
$imagefile = str_replace(" ", "%20", $imagefile);
if ($f=="") die("unknown");
if ($size = @getimagesize($imagefile)){
	list($width, $height, $type, $attr) = $size;
	echo $width."x".$height;
}else
	die("unknown");
?>
