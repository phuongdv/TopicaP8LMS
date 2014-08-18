<?php
/*
E-commerce Solutions Promotion - ECOPRO Co.,Ltd
By Pham Anh Tuan 0915.805.145 
vinawebmaster@gmail.com   phamanhtuan@live.com
*/
$type = $_GET['type'];
$file = $_GET['f'];

//Kiem tra su ton tai cua file hay khong
//Neu file khong ton tai se thay bang mot file mac dinh
if($file == '')
{ 
	$filename = './images_upload/noimage.jpg';
	//echo "Ko ton tai";
} 
else 
{ 
	$filename = './images_upload/' . $file;
}

//Kich thuoc cho anh duong hien thi
if($type == '1')
{
	$width = '80';
	$height = '80';
}
elseif($type == '2')
{
	$width = '140';
	$height = '140';
}
elseif($type == '3')
{
	$width = '200';
	$height = '200';
}
elseif($type == '4')
{
	$width = '150';
	$height = '150';
}
elseif($type == 'full')
{
	$width = '305';
	$height = '407';
}
elseif($type == 'small')
{
	$width = '80';
	$height = '80';
}
else
{
	$width = '116';
	$height = '112';
}
if(isset($type) && isset($width) && isset($height))
{
	//Dinh dang file duong tra ve
	if(
		substr($file, -5, 5) == '.jpeg' ||
		substr($file, -5, 5) == '.JPEG' || 
		substr($file, -4, 4) == '.jpg' || 
		substr($file, -4, 4) == '.JPG')
	{
		$format = 'jpg';
		@header('Content-type: image/jpeg');
	}
	elseif(
		substr($file, -4, 4) == '.gif' || 
		substr($file, -4, 4) == '.GIF')
	{
		$format = 'gif';
		@header('Content-type: image/gif');
	}
	else
	{
		$format = 'jpg';
		@header('Content-type: image/jpeg');
	}

	@list($width_orig, $height_orig) = @getimagesize($filename);
	$ratio_orig = $width_orig/$height_orig;
	if ($width/$height > $ratio_orig) {
	   $width = $height*$ratio_orig;
	} else {
	   $height = $width/$ratio_orig;
	}

	$image_p = @imagecreatetruecolor($width, $height);

	if($format == 'jpg')
		$image = @imagecreatefromjpeg($filename);
	elseif($format == 'gif')
		$image = @imagecreatefromgif($filename);
	else
		$image = @imagecreatefromjpeg($filename);

	@imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

	if($format == 'jpg')
		@imagejpeg($image_p, null, 100);
	elseif($format == 'gif')
		@imagegif($image_p, null, 100);
	else
		@imagejpeg($image_p, null, 100);
}
?>
