<?php

	define("DIALOG_OPEN",0);
	define("DIALOG_SAVE",1);
	define("DIALOG_SAVEAS",2);
	
	class DIALOG 
	{
		var $parentDir="";
		var $currentDir="";
		var $fileInRow=11;
		var $boxHeight="";
		var $boxWidth="";

		var $icons=null;
		var $iconDir="";
		var $dialogtype="";
		var $filetypes="";
		var $basedir = "";
		var $baseURL = "";
		var $maxFileSize = 102400;//100 Kbytes
		var $inputname = "InputName";

		var $filesincurrdir=array();
		var $dirincurrdir=array();


		/* 
		Constructor
		@PARAMS : $parentDir : Root Directory
				  $boxHeight : Dialog Box Height
				  $boxWidth  : Dialog Box Width
		*/
		
		function DIALOG($parentDir=".",$type=DIALOG_OPEN,$boxHeight=370,$boxWidth=580)
		{
			$this->setParentDir($parentDir);
			$this->currentDir=$this->parentDir;
			$this->boxHeight=$boxHeight;
			$this->boxWidth=$boxWidth;
			$this->dialogtype=$type;
			$this->iconDir=$this->basedir."/dialogimg/";
			

			$this->icons = array(
			
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
		
		function setBaseURL($_baseURL=""){
			$this->baseURL = $_baseURL;
		}
		
		function setBaseDir($dir)
		{
			$this->basedir=str_replace("\\","/",$dir);
			$this->iconDir=$this->basedir."/dialogimg/";
		}
		
		function setMaxFileSize($_maxFileSize=0){
			$this->maxFileSize = $_maxFileSize;
		}

		function setInputName($_inputname=0){
			$this->inputname = $_inputname;
		}

		function setCurrentDir($currDir)
		{
			$this->currentDir=str_replace("\\","/",$currDir);
		}
		function setParentDir($parentDir) 
		{
			if($parentDir=="/")
				$this->parentDir="/";
			elseif(preg_match("/\/$/",$parentDir))
				$this->parentDir=substr_replace($parentDir,"",-1);
			else 
				$this->parentDir=$parentDir;
			$this->parentDir = str_replace("\\","/",$this->parentDir);
		}
		
		function setFileType($filetye)
		{
			$this->filetypes=$filetye;
		}
		
		function setDialogType($type)
		{
			$this->dialogtype=$type;
		}

		function readDir()
		{
			if(!empty($this->filesincurrdir) || !empty($this->dirincurrdir))
				return;
			$this->filesincurrdir=$this->get_all_files($this->currentDir,$this->filetypes,false,&$this->dirincurrdir);
			return true;
		}

		function get_all_files($parent_dir=".",$file_type="",$include_sub_dir=true,$dir_arr=NULL)
		{
			static $file_arr=array();
			if (is_dir($parent_dir))
			{
				$file_type=strtolower($file_type);
				if(!preg_match("/\/$/",$parent_dir))
					$parent_dir.="/";
				if ($dh = opendir($parent_dir))
				{
					while (($file = readdir($dh)) !== false)
					{
						if(is_dir($parent_dir.$file) && $file!="." && $file!="..")
						{
							$dir_arr[]=$parent_dir.$file;
							if($include_sub_dir)
								$sub_dir=$this->get_all_files($parent_dir.$file,$file_type,$include_sub_dir,&$dir_arr);
						}
						elseif(is_file($parent_dir.$file)&& $file!="." && $file!="..")
						{
	
							$path_parts = pathinfo($file);
							$ext=$path_parts["extension"];
							if(!isset($ext)|| trim($ext)=="")
							  $ext="12356";
							if(strstr($file_type,strtolower($ext))||$file_type=="")
							   $file_arr[]=$parent_dir.$file;
						}

					}
					closedir($dh);
				}
				@arsort($file_arr);
				@sort($dir_arr);
				$return = $file_arr;
				unset($file_arr);
				return $return;
			}
			return 0;
		}
		
	
		function getFileIcon($file)
		{	
			$l = strlen($this->parentDir);
			$rfile = substr($file, $l+1);
			$furl = $this->baseURL."/".$rfile;
			$furl = str_replace(" ", "%20", $furl);
			
			if(!is_file($file))
				return false;
			$bfile = basename($file);
			$file_extension = strtolower(substr(strrchr($bfile,"."),1));
			$file_info=$this->icons[$file_extension];
			
			$icon=$this->iconDir.$file_info[0].".gif";
			if(!is_file($icon))
				$icon=$this->iconDir."txt.gif";
			$file_info="Type: ".$file_info[1]." \n";
			$file_info.="Date Modified: ".@date ("m/d/Y H:i A", @filemtime($file))." \n";
			$file_info.="Size: ".get_size(@filesize($file))." bytes";
			
			
			$arrExt = array("jpg", "jpe", "jpeg", "gif", "bmp", "png");
			$onomousemove = "";
			if (in_array($file_extension, $arrExt)){
				$onmousemove = "onmousemove='javascript:viewFile(\"".$furl."\")'";
			}
			$html = "<a href='#' title='$file_info' onclick='javascript:selFile(\"".$rfile."\", \"$furl\")' $onmousemove ><img src='$icon' border=0 align='top'>&nbsp;".$bfile."</a>";
			
			return $html;
		}
		
		function getParentDirForCurrentDir()
		{
			$curr_dir=str_replace($this->parentDir,"",$this->currentDir);
			return preg_split("/\//",$curr_dir,-1,PREG_SPLIT_NO_EMPTY);
		}
		
		function getFilesInCurrentDir()
		{	
			$return="<!---Begin BoxFile-->\n";
			$return.="<table cellpadding='0' cellspacing='0' style='margin-left:5px;' width='100%'>\n";
			$return.="<tr>\n";
			$this->readDir();
			//$gapinlist = "300px";
			$gapinlist = "";

			$file_arr= $this->filesincurrdir;
			$dir_arr=$this->dirincurrdir;
			$totalFile = count($file_arr);
			$totalDir = count($dir_arr);
			$rem=0;
			//print_r($file_arr);
			//die();
			if (($totalFile+$totalDir)/3>$this->fileInRow){
				$this->fileInRow = ceil(($totalFile+$totalDir)/3);
			}
			$return.="<!---Begin Dir-->\n";
			for($i=0;$i<$totalDir;)
			{
				$return.= "<Td valign='top' width='$gapinlist'>\n
							<table cellpadding='0' cellspacing='1' border=0 >\n";
				for($j=0;$j<$this->fileInRow && $i<count($dir_arr);$j++,$i++)
				{
					$return.="<tr>
								<td width=$gapinlist><a href='#' onclick='javascript:chDir(\"".$dir_arr[$i]."\")' ><img src='".$this->iconDir."folder.gif' border=0 align='top'>".basename($dir_arr[$i])."</a>
								</td>\n
							  </tr>\n";
				}
				
				if($j==$this->fileInRow )
					$return.= "</table>\n
								</td>\n
								";
			}
			$return.="<!---End Dir-->\n";
			
			$rem=$j;
			
			$return.="<!---Begin File-->\n";
			for($i=0;$i<$totalFile;)
			{
				if($rem==0)
					$return.= "<Td valign='top' width='$gapinlist'><table cellpadding='0' cellspacing='1' border=0  >\n";
				for($j=$rem;$j<$this->fileInRow && $i<$totalFile;$j++,$i++)
				{
					
					$rem=0;
					$return.="<tr><td  width='$gapinlist' nowrap>".$this->getFileIcon($file_arr[$i])."&nbsp;</td></tr>\n";
				}
				
				if($j==$this->fileInRow )
					$return.= "</table>\n
								</td>\n";
			}
			if($j!=$this->fileInRow && $totalFile+$totalDir>0)
				$return.= "</table>\n
							</td>\n";
			$return.="<!---End File-->\n";
			if ($totalFile==0) $return.= "<td></td>\n";
			$return.="</tr>\n
						</table>
						<!---End BoxFile-->\n";
			return $return;
		}
		
		function ftpConn() {
			$ftp = array(
					'ftp_server' => '203.113.134.8',
					'ftp_user' => 'uploads@tnktravel.com',
					'ftp_pass' => 'vietnamtravel@'
					);
			extract($ftp);
			
			// set up basic connection
			$this->conn_id = ftp_connect($ftp_server);
			
			// login with username and password
			$login_result = ftp_login($this->conn_id, $ftp_user, $ftp_pass);
		}
		
		function makeDir($dir)
		{
			$this->ftpConn();
			if(empty($dir))
				return;
			
			if(preg_match("/uploads/",$this->currentDir)) {
				$root_dir = $_SERVER['DOCUMENT_ROOT'].dirname(dirname($_SERVER['PHP_SELF']))."uploads";
				
				$suffix = '';
				if(strlen($root_dir) != strlen($this->currentDir)) {
					$len = strlen($root_dir) - strlen($this->currentDir) + 1;		
					$suffix = substr($this->currentDir,$len); 
				}
				
				if($suffix=='')
					{
						if(@ftp_mkdir($this->conn_id, trim($dir)))
							{
								if (ftp_site($this->conn_id, 'CHMOD 777 '.trim($dir)) !== false)
								@ftp_close($this->conn_id);
							}
						else {
							echo "<script>alert(\"Thư mục bạn tạo đã tồn tại hoặc thư mục đó không cho phép tạo thư mục trong nó !\");</script>"; die();
						}	
					}
				else {
					if(@ftp_mkdir($this->conn_id, $suffix."/".trim($dir)))
						{
							if (ftp_site($this->conn_id, 'CHMOD 777 '.$suffix.'/'.trim($dir)) !== false)
							@ftp_close($this->conn_id);
						}
					else {
						echo "<script>alert(\"Thư mục bạn tạo đã tồn tại hoặc thư mục đó không cho phép tạo thư mục trong nó !\");</script>"; die();
					}
				}	
									
			}
			else 
			{
				die();
			}	
		}
		
		function showDialog($dialogLink="", $session_id)
		{
			
			$content="window.open('".$this->basedir."/dialogbox.php?pDir=$this->parentDir&type=$this->dialogtype&filetypes=$this->filetypes&maxfilesize=".$this->maxFileSize."&inputname=".$this->inputname."&sid=".$session_id."','dialogwin','width=".$this->boxWidth."px,height=".$this->boxHeight."px,resizable=no,toolbar=no,status=no');";
			$html = "";
			if($this->dialogtype==DIALOG_OPEN)
			{
				$html.= "<a href='javascript:showOpenDialog_".$this->inputname."()'>";
				if(!empty($dialogLink))
					$html.= $dialogLink;
				else 
					$html.= "<img src='".$this->iconDir."folderopen.gif' border=0 title='Open' alt='Open'>";
				$html.= "</a>";
				$html.= "<script>function showOpenDialog_".$this->inputname."(){".$content."}</script>";
			}
			elseif($this->dialogtype==DIALOG_SAVE)
			{
				$html.= "<a href='javascript:showSaveDialog()'>";
				if(!empty($dialogLink))
					$html.= $dialogLink;
				else 
					$html.= "<img src='".$this->iconDir."save.gif' border=0 title='Open' alt='Open'>";
				$html.= "</a>";
				$html.= "<script>function showSaveDialog(){".$content."}</script>";
			}
			elseif($this->dialogtype==DIALOG_SAVEAS)
			{
				$html.= "<a href='javascript:showSaveAsDialog()'>";
				if(!empty($dialogLink))
					$html.= $dialogLink;
				else 
					$html.= "<img src='".$this->iconDir."save.gif' border=0 title='Open' alt='Open'>";
				$html.= "</a>";
				$html.= "<script>function showSaveAsDialog(){".$content."}</script>";
			}
			return $html;
		}
	}
if (!function_exists("get_size")){
	function get_size($size) {//bytes
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