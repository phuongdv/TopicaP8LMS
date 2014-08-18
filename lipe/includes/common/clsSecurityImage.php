<?
/**
*  @class       : Security image 
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 18/07/2007
*  @version		: 1.0.0
*/
class generateImages {
	var $image;
	var $height;
	var $width;
	var $numchar;
	var $strCode="";
	
	//Constructor
	function generateImages($height,$width,$numchar)  {
		$this->height = $height;
		$this->width = $width;
		$this->numchar = $numchar;	
			
		if(isset($_SESSION["strSecurity"])) {
			$this->hideCode = $_SESSION["strSecurity"];
		}
		else {
			$_SESSION["strSecurity"] = "";
		}
	}
	
	function generateCode() {
		$arListChar = "23456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
		$i=0;
		$str = "";
		while($i < $this->numchar) {
			$str .= substr($arListChar, mt_rand(0, strlen($arListChar)-1), 1);
			$i++;
		}
		return $str;
	}
	
	function outputImage() {
		$this->createImage();
		header("Content-type: image/jpeg");
		imagejpeg($this->image);
		imagedestroy($this->image);
	}
	
	function verifyString($hide_string) {
		if($this->hideCode === $hide_string) {
			return true;
		} else {
			return false;
		}
	}
	
	function createTextBox($name, $parameters = "") {
		return '<input type="text" name="' . $name . '" ' . $parameters . ' /> ';
	}
	
	function createImage() {
	    /**
		*  Init
		*/		
		$this->strCode = $this->generateCode();
		$_SESSION["strSecurity"] = $this->strCode;
		/**
		*  Create image
		*/
		$this->image = @imagecreatetruecolor($this->width, $this->height);
		/**
		*  Define some common color
		*/
		$black = imagecolorallocate($this->image, 0, 0, 0);
		$white = imagecolorallocate($this->image, 255, 255, 255);
		$red = imagecolorallocatealpha($this->image, 255, 0, 0, 75);
		$green = imagecolorallocatealpha($this->image, 0, 255, 0, 75);
		$blue = imagecolorallocatealpha($this->image, 0, 0, 255, 75);
		$brown = imagecolorallocatealpha($this->image, 130, 8, 0, 15);
		/**
		*  Generate random dots in background
		*/	
		imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, $white);	
		/**
		*  Ellipse
		*/
		imagefilledellipse($this->image, ceil(rand(5,145)), ceil(rand(0,35)), 30, 30, $red);
		imagefilledellipse($this->image, ceil(rand(5,145)), ceil(rand(0,35)), 30, 30, $green);
		imagefilledellipse($this->image, ceil(rand(5,145)), ceil(rand(0,35)), 30, 30, $blue);
		/**
		*  Border for image
		*/	
		imagefilledrectangle($this->image, 0, 0, $this->width, 0, $black);
		imagefilledrectangle($this->image, $this->width - 1, 0, $this->width - 1, $this->height - 1, $black);
		imagefilledrectangle($this->image, 0, 0, 0, $this->height - 1, $black);
		imagefilledrectangle($this->image, 0, $this->height - 1, $this->width, $this->height - 1, $black);
		/**
		*  Add string to image
		*/
		imagestring ($this->image, 5, intval(($this->width - (strlen($this->strCode) * 9)) / 2),  intval(($this->height - 15) / 2), $this->strCode, $brown);				
	}	
}
?>