<?php
/**
*  @pakage      : Advanced upload
*  @author		: Vu Quoc Trung (trungvq@vietitech.com)
*  @date		: 02/02/2009
*  @version		: 1.0.0
*/

class AdvancedUpload {
	public $errors = array(); //array used to store any errors that occur.
	public $upload_dir = ''; //the upload_dir being used by the script
	public $make_safe = false; //default don't modify the file name to safe version
	public $max_file_size = 1048576; //Max File Size in Bytes, 1MB
	public $overwrite = false; //default don't overwrite files that already exsist
	public $check_file_type = false; //don't check for file type by default but can check for allowed and denied files.
	public $allowed_mime_types = array('image/jpeg', 'image/png', 'image/gif', 'image/tiff', 'image/vnd.wap.wbmp'); //array of allowed mime types used when check_file_type is set to allowed
	public $denied_mime_types = array('application/x-php', 'application/octet-stream', 'application/zip', 'video/mpeg', 'text/html'); //array of denied mime types used when check_file_type is set to denied
	public $arrFileNameUploaded = array();
	public $mime_current_image = ''; //mime type current image
	public $current_tmp_name = ''; 
	public $current_file_name = ''; //current file name
	public $current_width;          //image width 
	public $current_height;         //image height
	public $resize_width;           //image width resize
	
	/**
	 * Check if the upload dir is valid, if it is not valid attempt to make the dir, if dir is succesfully created chmod it to 0777. 
	 * If any elments fail return false else set upload_dir and return true.
	 * @param string $dir
	 * @param boolean $mkdir
	 * @return true or false
	 */
	public function upload_dir($dir, $mkdir = false) {
		$errors =& $this->errors;
		$status = true;
		
		if (!is_dir($dir)) {
			if ($mkdir) {
				if (!mkdir($dir)) {
					$status = false;
				} else {
					if (!chmod($dir, 0777)) $status = false;
				}
			} else {
				$status = false;
			}
		}
		
		if ($status) {
			$this->upload_dir = $dir;
			return true;
		} else {
			$errors['general'][] = 'Upload Dir is Not Valid and/or a dir could not be created/chmod.';
			return false;
		}
	}
	
	/**
	 * check that the upload dir is valid and that it is writeable
	 *
	 * @param string $dir
	 * @return true or false
	 */
	public function check_dir($dir) {
		if (!is_dir($dir) || !is_writable($dir)) return false;
		
		return true;
	}
	

	/**
	 * make the uploaded file name safe
	 *
	 * @param string $file_name
	 * @return safe file name
	 */
	public function make_safe($file_name) {
	
		$charset = "0123456789abcdefghijklmnopqrstuvwxyz";
		$new_name = '';
		
		$length = ($file_name!="")? (strlen($file_name)+5) : 12;
		$image_extension = end(explode('.',$file_name));
		
		for ($i=0; $i<$length; $i++) $new_name .= $charset[(mt_rand(0,(strlen($charset)-1)))];
		
		$new_name .= '.';
		$new_name .= $image_extension;
		
		return $new_name;
	}
	
	/**
	 *	Create image
	 *
	 */
	public function createImage()
	{		
		switch ($this->mime_current_image)
		{
			case 'image/jpeg':
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
				throw new NotSupportedUploadFileException("");
				break;
		}
	}
	
	/**
	 *	Create image
	 *
	 */
	public function setWidthImageResize($width="") {
		$this->resize_width = $width;
	}
	/**
	*	Save image
	*
	*/
	public function saveImage($destinationImage) {
		switch ($this->mime_current_image)
		{
			case 'image/jpeg':
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
				throw new NotSupportedUploadFileException("");
				break;
		}
	}
	
	/**
	 *	Image size
	 *
	 */
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
	 
	/**
	 *	Resize image 
	 *
	 */
	public function resizeImage($size = array(), $border = 0)
	{
		//	calculate
		if (!$size['width'] || !$size['height']) {
			if ($size['width'])
			{
				$size['height'] = ($this->current_height * $size['width']) / $this->current_width;
			} 
			else {
				$size['width'] = ($this->current_width * $size['height']) / $this->current_height;
			}
		}
		
		//	create image
		$sourceImage = $this->createImage();
		
		//	create new image
		$destinationImage = imagecreatetruecolor($size['width'], $size['height']);
		
		if ($border)
		{
			//	fill image with white color and grey border
			$white = imagecolorallocate($destinationImage, 0xFF, 0xFF, 0xFF);
			imagefilledrectangle($destinationImage, 1, 1, $size['width'] - 2, $size['height'] - 2, $white);
		}
		
		//	copy image
		if ($border)
		{
			imagecopyresampled($destinationImage, $sourceImage, 2, 2, 0, 0, $size['width'] - 4, $size['height'] - 4, $this->current_width, $this->current_height);
		} else {
			imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $size['width'], $size['height'], $this->current_width, $this->current_height);
		}
		
		//	save image
		$result = $this->saveImage($destinationImage);
		
		if ($result)
		{
			//	close resources
			@imagedestroy($destinationImage);
			@imagedestroy($sourceImage);
			
			return true;
		}
		
		return false;
	}
	
	/**
	 *
	 *
	 */
	public function getArrFileNameUploaded() {
		if(is_array($this->arrFileNameUploaded) && count($this->arrFileNameUploaded)>0)
			return $this->arrFileNameUploaded;
		else
			return "";
	}
	/**
	 * Check the Attemted Uploads for errors etc if everything goes good move the file, to the upload_dir.
	 *
	 * @param array $object
	 * @return unknown
	 */
	public function upload($object) {
		$errors =& $this->errors;
		//print_r($_FILES);
		if (empty($errors['general'])) {
			if (empty($this->upload_dir)) $this->upload_dir = dirname(__FILE__).'/'; //if no default upload_dir has been specified used the current dir.
					
			if ($this->check_dir($this->upload_dir)) {
				$files = $_FILES[$object];
				$count = count($files['name']) - 1;
				
				for ($current = 0; $current <= $count; $current++) {
					$error = '';
					try {
						//file information
						$this->current_file_name  = $files['name'][$current];
						$this->current_tmp_name   = $files['tmp_name'][$current];
						$this->mime_current_image = $files['type'][$current];
						$this->getImageSize();
												
						//check for $_FILES Errors
						switch ($files['error'][$current]) {
							case 0 : break;
							case 1 : $error = $this->current_file_name.' exceeds the upload_max_filesize directive in php.ini'; break;
							case 2 : $error = $this->current_file_name.' exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'; break;
							case 3 : $error = $this->current_file_name.' was only partially uploaded'; break;
							case 4 : $error = 'No file was uploaded'; break;
							case 6 : $error = 'Missing a temporary folder'; break;
							case 7 : $error = 'Failed to write '.$this->current_file_name.' to disk'; break;
							case 8 : $error = $this->current_file_name.' stopped by extension'; break;
							default : $error = 'Unidentified Error, caused by '.$this->current_file_name; break;
						}
						if ($error) 
							throw new TrigerErrorException($error, $this->current_file_name);
						
						//check that the file is not empty
						if ($files['size'][$current] <= 0)
							throw new TrigerErrorException($this->current_file_name.' is empty', $this->current_file_name);
						
						//check that the file does not exceed the defined max_file_size
						if ($this->max_file_size) {
							if ($files['size'][$current] >= $this->max_file_size) 
								throw new TrigerErrorException($this->current_file_name.' exceeds defined max_file_size', $this->current_file_name);
						}
						
						if ($this->check_file_type == 'allowed' && !in_array($this->mime_current_image, $this->allowed_mime_types)) {
							throw new TrigerErrorException($this->current_file_name.' is not an allowed type', $this->current_file_name);
						} elseif ($this->check_file_type == 'denied' && in_array($this->mime_current_image, $this->denied_mime_types)) {
							throw new TrigerErrorException($this->current_file_name.' is a denied type', $this->current_file_name);
						}
						
						//if make_safe is true call make safe function		
						if ($this->make_safe)
							$this->current_file_name = $this->make_safe($this->current_file_name);
						
						$this->arrFileNameUploaded[] = $this->current_file_name;
						
						//if overwrite is false and the file exists error
						if (!$this->overwrite && file_exists($this->upload_dir.$this->current_file_name))
							throw new TrigerErrorException($this->current_file_name.' already exsists', $this->current_file_name);
						
						if($this->resize_width == "")	
							$this->resize_width = $this->current_width;
							
						//move the uploaded file, error if anything goes wrong.
						if(!$this->resizeImage(array('width' => $this->resize_width)))
							 throw new TrigerErrorException($this->current_file_name.' could not be moved', $this->current_file_name);
						/*	 
						if (!move_uploaded_file($files['tmp_name'][$current], $this->upload_dir.$this->current_file_name))
							throw new TrigerErrorException($this->current_file_name.' could not be moved', $this->current_file_name);
						*/
					} catch (TrigerErrorException $e) {
						$errors[$this->current_file_name][] = $e->Message();
					}
				}
				
				if (empty($errors)) {
					//return true if there where no errors
					return true;
				} else {
					//return the errors array if there where any errros
					return $errors;
				}
			} else {
				//return false as dir is not valid
				$errors['general'][] = "The Specified Dir is Not Valid or is Not Writeable";
				return false;
			}
		}
	}	
}

/**
 * Handle the Exceptions trigered by errors within upload code.
 *
 */
class TrigerErrorException extends Exception {
	protected $file = "";
	public function __construct($message, $file = "", $code = 0) {
		$this->file = $file;
   		parent::__construct($message, $code);
	}

  	public function Message() {
		return "{$this->message}";
   	}
}
?>