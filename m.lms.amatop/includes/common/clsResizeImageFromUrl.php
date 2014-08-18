<?php
/**
*  @pakage      : Resize Image From URL
*  @author		: Vu Quoc Trung (trungvq@vietitech.com)
*  @date		: 30/07/2009
*  @version		: 1.0.0
*/

final class ResizeImageFromUrl {	

	public $null = NULL;
	public $url_image = '';
	public $resize_width = 130;
	public $resize_height;
	public $current_image_mime;
	
	public function __construct() {
		
	}
	
	private function getImageInfo() {		
		if(preg_match('/\//',$this->url_image))		
			{
				$arrExplodeFileFromUrl = explode('/',$this->url_image);
				$image_file_name = is_array($arrExplodeFileFromUrl)? end($arrExplodeFileFromUrl) : "";
				$this->url_image = str_replace("$image_file_name",rawurlencode($image_file_name),$this->url_image);				
			}
						
	 	$arrImageInfo = @getimagesize($this->url_image);
		if(is_array($arrImageInfo) && count($arrImageInfo)>0) {
			$this->current_image_mime = $arrImageInfo["mime"];	
		}
		else {
			$this->current_image_mime = 'image/jpeg';			
		}
		
		return true;
	}
	
	public function setImageHeader() {
		$this->getImageInfo();
		return header ( 'Content-type:' . $this->current_image_mime );
	}
	
	private function createImage()
	{		
		switch ($this->current_image_mime)
		{
			case 'image/jpeg':
				return imagecreatefromjpeg($this->url_image);
				break;
			case 'image/pjpeg':
				return imagecreatefromjpeg($this->url_image);
				break;
			case 'image/gif':
				return imagecreatefromgif($this->url_image);
				break;
			case 'image/png':
				return imagecreatefrompng($this->url_image);
				break;
			case 'image/vnd.wap.wbmp':
				return imagecreatefromwbmp($this->url_image);
				break;
			default:
				die("Cound not create image");
				break;
		}
	}
	
	public function saveImage($image_dest) {	
		switch ($this->current_image_mime)
		{
			case 'image/jpeg':
				return imagejpeg($image_dest);
				break;
			case 'image/pjpeg':
				return imagejpeg($image_dest);
				break;
			case 'image/gif':
				return imagegif($image_dest);
				break;
			case 'image/png':
				return imagepng($image_dest);
				break;
			case 'image/vnd.wap.wbmp':
				return imagewbmp($image_dest);
				break;
			default:
				return imagejpeg($image_dest);
				break;
		}
	}
	
	public function doResize() {
		if ( $tmp0 = $this->createImage() ) {
			if ( imagesy ( $tmp0 ) > imagesx ( $tmp0 ) ) {
				$dim = ($this->resize_height)? array ( 'w' => $this->resize_width , 'h' => $this->resize_height ) : array ( 'w' => round ( imagesx ( $tmp0 ) * $this->resize_width / imagesy ( $tmp0 ) ), 'h' => $this->resize_width );
			}
			else {
				$dim = ($this->resize_height)? array ( 'w' => $this->resize_width , 'h' => $this->resize_height ) : array ( 'w' => $this->resize_width, 'h' => round ( imagesy ( $tmp0 ) * $this->resize_width / imagesx ( $tmp0 ) ) );
			}
			$tmp1 = imagecreatetruecolor ( $dim [ 'w' ], $dim [ 'h' ] );
			if (
					imagecopyresized  ( $tmp1 , $tmp0, 0, 0, 0, 0, $dim [ 'w' ],
					$dim [ 'h' ], imagesx ( $tmp0 ), imagesy ( $tmp0 ) )
				) {
				imagedestroy ( $tmp0 );
				return $tmp1;
			}
			else {
				imagedestroy ( $tmp0 );
				imagedestroy ( $tmp1 );

				return $this->null;
			}
		}
		else {
			return $this->null;
		}
	}
}
?>