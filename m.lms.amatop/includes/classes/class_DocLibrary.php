<?
/**
*  Created by   : Technical Group (technical@vietitech.com)
*  @date		: 2009/1/18
*  @version		: 2.1.1
*/
class DocLibrary extends dbBasic{

	function DocLibrary() {
		$this->pkey = "doclib_id";
		$this->tbl = "doclib";
		$this->ficons = array(
			
				// Microsoft Office
				'doc' => array('doc', 'Word Document'),
				'xls' => array('xls', 'Excel Spreadsheet'),
				'ppt' => array('ppt', 'PowerPoint Presentation'),
				'pps' => array('ppt', 'PowerPoint Presentation'),
				'pot' => array('ppt', 'PowerPoint Presentation'),
			
				'mdb' => array('access', 'Access Database'),
				'vsd' => array('visio', 'Visio Document'),
				'rtf' => array('rtf', 'RTF File'),
			
				// XML
				'htm' => array('htm', 'HTML Document'),
				'html' => array('htm', 'HTML Document'),
				'xml' => array('xml', 'XML Document'),
			
				 // Images
				'jpg' => array('image', 'JPEG Image'),
				'jpe' => array('image', 'JPEG Image'),
				'jpeg' => array('image', 'JPEG Image'),
				'gif' => array('image', 'GIF Image'),
				'bmp' => array('image', 'Windows Bitmap Image'),
				'png' => array('image', 'PNG Image'),
				'tif' => array('image', 'TIFF Image'),
				'tiff' => array('image', 'TIFF Image'),
				
				// Audio
				'mp3' => array('audio', 'MP3 Audio'),
				'wma' => array('audio', 'WMA Audio'),
				'mid' => array('audio', 'MIDI Sequence'),
				'midi' => array('audio', 'MIDI Sequence'),
				'rmi' => array('audio', 'MIDI Sequence'),
				'au' => array('audio', 'AU Sound'),
				'snd' => array('audio', 'AU Sound'),
			
				// Video
				'mpeg' => array('video', 'MPEG Video'),
				'mpg' => array('video', 'MPEG Video'),
				'mpe' => array('video', 'MPEG Video'),
				'wmv' => array('video', 'Windows Media File'),
				'avi' => array('video', 'AVI Video'),
				
				// Archives
				'zip' => array('zip', 'ZIP Archive'),
				'rar' => array('zip', 'RAR Archive'),
				'cab' => array('zip', 'CAB Archive'),
				'gz' => array('zip', 'GZIP Archive'),
				'tar' => array('zip', 'TAR Archive'),
				'zip' => array('zip', 'ZIP Archive'),
				
				// OpenOffice
				'sdw' => array('oo-write', 'OpenOffice Writer document'),
				'sda' => array('oo-draw', 'OpenOffice Draw document'),
				'sdc' => array('oo-calc', 'OpenOffice Calc spreadsheet'),
				'sdd' => array('oo-impress', 'OpenOffice Impress presentation'),
				'sdp' => array('oo-impress', 'OpenOffice Impress presentation'),
			
				// Others
				'txt' => array('txt', 'Text Document'),	
				'js' => array('js', 'Javascript Document'),
				'dll' => array('binary', 'Binary File'),
				'pdf' => array('pdf', 'Adobe Acrobat Document'),
				'php' => array('php', 'PHP Script'),
				'ps' => array('ps', 'Postscript File'),
				'dvi' => array('dvi', 'DVI File'),
				'swf' => array('swf', 'Flash'),
				'chm' => array('chm', 'Compiled HTML Help'),
			
				// Unkown
				'default' => array('txt', 'Unkown Document'),
			);
	}
	
	function getLibraryTypeID() {
		global $dbconn;
		
		$arrListTypeLibrary = $dbconn->GetAll("select * from _type where type_key='library'");
		if (is_array($arrListTypeProduct) && count($arrListTypeProduct)>0)
			return $arrListTypeProduct[0]["type_id"];
		else
			return 0;
	}
	
	function getSrcIconFileType($file_name='') {
	
		$str_src = '';
		if($file_name != '' && ereg('.',$file_name))
			{
				$arrListExplodeFileName = @explode('.',$file_name);
				if(is_array($arrListExplodeFileName) && count($arrListExplodeFileName)>0)
					$str_src = URL_IMAGES."/filetype/".$this->ficons[end($arrListExplodeFileName)][0].".gif";
			}	
			
		return $str_src;	
	}	
	
	function getFileSize($file_name='') {
		$str_size = 0;
		if($file_name != '' && @file_exists(DIR_UPLOADS."/".$file_name))
			{
				$str_size = $this->convertFileSize(@filesize(DIR_UPLOADS."/".$file_name));
			}	
			
		return $str_size;	
	}
	
	function convertFileSize($size) {//bytes
		if ($size=="" || $size==NULL) return 0;
		$kb = 1024;
		$mb = 1024 * $kb;
		$gb = 1024 * $mb;
		$tb = 1024 * $gb;
		if ($size < $kb) {
			$file_size = "$size Bytes";
		}
		elseif ($size < $mb) {
			$final = round($size/$kb,2);
			$file_size = "$final KB";
		}
		elseif ($size < $gb) {
			$final = round($size/$mb,2);
			$file_size = "$final MB";
		}
		elseif($size < $tb) {
			$final = round($size/$gb,2);
			$file_size = "$final GB";
		} else {
			$final = round($size/$tb,2);
			$file_size = "$final TB";
		}
		return $file_size;
	} 
}
?>