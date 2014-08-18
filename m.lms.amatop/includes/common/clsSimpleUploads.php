<?php
/**
*  @pakage      : Advanced upload
*  @author		: Vu Quoc Trung (trungvq@vietitech.com)
*  @date		: 02/02/2009
*  @version		: 1.0.0
*/

class SimpleUpload {	

	public $files;
	public $upload_dir = '';
	public $make_safe = false; 
	public $max_file_size = 1048576;
	public $overwrite = false; 
	public $check_file_type = false; 
	public $allowed_mime_types = array('image/jpeg', 'image/png', 'image/gif', 'image/tiff', 'image/vnd.wap.wbmp'); 
	public $denied_mime_types = array('application/x-php', 'application/octet-stream', 'application/zip', 'video/mpeg', 'text/html'); 
	public $arrFileNameUploaded = array();
	public $make_thumb = false;
	public $upload_thumb_dir = '';
	public $resize_width;
	public $resize_height;
	public $resize_thumb_width;
	public $resize_thumb_height;
	public $current_width;
	public $current_height;
	public $current_tmp_name;
	public $current_file_name;
	public $current_image_mime;
	public $errors = array();
	
	public function __construct() {
	
	}
	
	public function checkDirUpload($dir) {
		$errors =& $this->errors;
		$status = true;
		
		if (!is_dir($dir)) {
			if (!is_writable($dir)) 
				{				
					$status = false;
					$errors[] = $dir.' is could not be writen.';
				}
			else 
				{
					$status = false;
					$errors[] = $dir.' is not valid a dir.';
				}							
		}
		$this->upload_dir = $dir;
			
		return $status;
	}
	
	public function makeSafeFileName($file_name) {
	
		$charset = "0123456789abcdefghijklmnopqrstuvwxyz";
		$new_name = '';
		
		$length = ($file_name!="")? (strlen($file_name)+5) : 12;
		$image_extension = end(explode('.',$file_name));
		
		for ($i=0; $i<$length; $i++) $new_name .= $charset[(mt_rand(0,(strlen($charset)-1)))];
		
		$new_name .= '.';
		$new_name .= $image_extension;
		
		return $new_name;
	}
	
	
	public function createImage()
	{		
		$errors =& $this->errors;
		switch ($this->current_image_mime)
		{
			case 'image/jpeg':
				return imagecreatefromjpeg($this->current_tmp_name);
				break;
			case 'image/pjpeg':
				return imagecreatefromjpeg($this->current_tmp_name);
				break;
			case 'image/gif':
				return imagecreatefromgif($this->current_tmp_name);
				break;
			case 'image/png':
				return imagecreatefrompng($this->current_tmp_name);
				break;
			case 'image/vnd.wap.wbmp':
				return imagecreatefromwbmp($this->current_tmp_name);
				break;
			default:
				$errors[] = "Cound not create image name is ".$this->current_file_name;
				break;
		}
	}
	
	public function saveImage($destinationImage) {
		
		switch ($this->current_image_mime)
		{
			case 'image/jpeg':
				return @imagejpeg($destinationImage, $this->upload_dir.$this->current_file_name);
				break;
			case 'image/pjpeg':
				return @imagejpeg($destinationImage, $this->upload_dir.$this->current_file_name);
				break;
			case 'image/gif':
				return imagegif($destinationImage, $this->upload_dir.$this->current_file_name);
				break;
			case 'image/png':
				return imagepng($destinationImage, $this->upload_dir.$this->current_file_name);
				break;
			case 'image/vnd.wap.wbmp':
				return imagewbmp($destinationImage, $this->upload_dir.$this->current_file_name);
				break;
			default:
				$errors[] = "Cound not save image name is ".$this->current_file_name;
				break;
		}
	}
	
    public function getImageSize() {
	 	$arrImageInfo = getimagesize($this->current_tmp_name);
		if(is_array($arrImageInfo) && count($arrImageInfo)>0) {
	 		$this->current_width  = $arrImageInfo[0];
			$this->current_height = $arrImageInfo[1];
		}
		else {
			$this->current_width  = 1;
			$this->current_height = 1;
		}
	}
	
	public function setWidthImageResize($width=130) {
		$this->resize_width = $width;
	}
	 
	public function resizeImage($size = array(), $border = 0)
	{
		if (!$size['width'] || !$size['height']) {
			if ($size['width'])
			{
				$size['height'] = ($this->current_height * $size['width']) / $this->current_width;
			} 
			else {
				$size['width'] = ($this->current_width * $size['height']) / $this->current_height;
			}
		}
		
		$sourceImage = $this->createImage();
		
		$destinationImage = imagecreatetruecolor($size['width'], $size['height']);
		
		if ($border!=0)
		{
			$white = imagecolorallocate($destinationImage, 0xFF, 0xFF, 0xFF);
			imagefilledrectangle($destinationImage, 1, 1, $size['width'] - 2, $size['height'] - 2, $white);
		}
		
		if ($border!=0)
		{
			@imagecopyresampled($destinationImage, $sourceImage, 2, 2, 0, 0, $size['width'] - 4, $size['height'] - 4, $this->current_width, $this->current_height);
		} else {
			@imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $size['width'], $size['height'], $this->current_width, $this->current_height);
		}
		
		$result = $this->saveImage($destinationImage);
		
		if ($result)
		{
			@imagedestroy($destinationImage);
			@imagedestroy($sourceImage);
			
			return true;
		}
		
		return false;
	}
	
	public function getArrFileNameUploaded() {
		if(is_array($this->arrFileNameUploaded) && count($this->arrFileNameUploaded)>0)
			return $this->arrFileNameUploaded;
		else
			return "";
	}
	
	public function doUpload() {
		if(is_array($this->files['name']))
		{
			$this->_mutilUpload();					
		}	
		else
		{
			$this->_simpleUpload();					
		}
		
		return $this->errors;
	}
		
	public function _mutilUpload() {
		$errors =& $this->errors;
		
		if ($this->checkDirUpload($this->upload_dir)) {
			$count = count($this->files['name']);
			for ($current = 0; $current < $count; $current++) {
				$this->current_file_name  = $this->files['name'][$current];
				$this->current_tmp_name   = $this->files['tmp_name'][$current];
				$this->current_image_mime = $this->files['type'][$current];
				$this->getImageSize();
				
				if ($this->files['size'][$current] <= 0)
					$errors[]= $this->current_file_name.' is empty';
			
				if ($this->max_file_size) {
					if ($this->files['size'][$current] >= $this->max_file_size) 
						$errors[]= $this->current_file_name.' is exceeds the '.$this->max_file_size;
				}
				
				if ($this->check_file_type == 'allowed' && !in_array($this->current_image_mime, $this->allowed_mime_types)) {
					$errors[]= $this->current_file_name.' is not permission allowed to upload.';
				} 
				elseif ($this->check_file_type == 'denied' && in_array($this->current_image_mime, $this->denied_mime_types)) {
					$errors[]= $this->current_file_name.' is denied to upload.';
				}
					
				if ($this->make_safe)
					$this->current_file_name = $this->makeSafeFileName($this->current_file_name);
				
				$this->arrFileNameUploaded[] = $this->current_file_name;
				
				if (!$this->overwrite && file_exists($this->upload_dir.$this->current_file_name))
					$errors[]= $this->current_file_name.' already exsists.';
				
				if($this->resize_width == "" || $this->resize_width==0)	
					$this->resize_width = $this->current_width;
					
				if(!$this->resizeImage(array('width' => $this->resize_width)))
					$errors[]= $this->current_file_name.' was failed upload and resize.';
				
				if($this->make_thumb) {
					if($this->resize_thumb_width == "" || $this->resize_thumb_width==0)	
						$this->resize_thumb_width = 75;
					if($this->resize_thumb_height == "" || $this->resize_thumb_height==0)	
						$this->resize_thumb_height = ($this->current_height * $this->resize_thumb_width) / $this->current_width;
							
					if ($this->checkDirUpload($this->upload_thumb_dir)) {
						$this->resizeImage(array('width' => $this->resize_thumb_width, 'height' => $this->resize_thumb_height));
					}
				}					
			}
		}			
	}
	
	public function _simpleUpload() {
		$errors =& $this->errors;
		
		if ($this->checkDirUpload($this->upload_dir)) {
			$this->current_file_name  = $this->files['name'];
			$this->current_tmp_name   = $this->files['tmp_name'];
			$this->current_image_mime = $this->files['type'];
			$this->getImageSize();
			
			if ($this->files['size'] <= 0)
				$errors[]= $this->current_file_name.' is empty';
		
			if ($this->max_file_size) {
				if ($this->files['size'] >= $this->max_file_size) 
					$errors[]= $this->current_file_name.' is exceeds the '.$this->max_file_size;
			}
			
			if ($this->check_file_type == 'allowed' && !in_array($this->current_image_mime, $this->allowed_mime_types)) {
				$errors[]= $this->current_file_name.' is not permission allowed to upload.';
			} 
			elseif ($this->check_file_type == 'denied' && in_array($this->current_image_mime, $this->denied_mime_types)) {
				$errors[]= $this->current_file_name.' is denied to upload.';
			}
				
			if ($this->make_safe)
				$this->current_file_name = $this->makeSafeFileName($this->current_file_name);
			
			$this->arrFileNameUploaded[] = $this->current_file_name;
			
			if (!$this->overwrite && file_exists($this->upload_dir.$this->current_file_name))
				$errors[]= $this->current_file_name.' already exsists.';
			
			if($this->resize_width == "" || $this->resize_width==0)	
				$this->resize_width = $this->current_width;
				
			if(!$this->resizeImage(array('width' => $this->resize_width)))
				$errors[]= $this->current_file_name.' was failed upload and resize.';
			
			if($this->make_thumb) {
				if($this->resize_thumb_width == "" || $this->resize_thumb_width==0)	
					$this->resize_thumb_width = 75;
				if($this->resize_thumb_height == "" || $this->resize_thumb_height==0)	
					$this->resize_thumb_height = ($this->current_height * $this->resize_thumb_width) / $this->current_width;
						
				if ($this->checkDirUpload($this->upload_thumb_dir)) {
					$this->resizeImage(array('width' => $this->resize_thumb_width, 'height' => $this->resize_thumb_height));
				}
			}
		}			
	}
}
?>