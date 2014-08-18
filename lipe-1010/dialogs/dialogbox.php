<?php
//error_reporting(0);
//check session state
$sid = $_REQUEST["sid"];
if($sid == "") {
	header("Content-type: text/html; charset=utf-8");
	echo "<script language=\"javascript\">alert(\"Bạn không được phép làm như vậy !\");</script>";
	die();
}
session_id($sid);
session_start();

$user_name = isset($_SESSION["TOPICA_topica_NVC_USERNAME"])? $_SESSION["TOPICA_topica_NVC_USERNAME"] : "";
if($user_name == "") {
	header("Content-type: text/html; charset=utf-8");
	echo "<script language=\"javascript\">alert(\"Bạn không được phép làm như vậy !\");</script>";
	die();
}


$baseURL = "http://".$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']))."/uploads";
$nopic = "nopic.gif";
$thumbwidth = "100px";

require_once("dialog.inc.php");
require_once("clsWriteTextOnImage.php");

$inputname = $_REQUEST["inputname"];
$maxfilesize = $_REQUEST["maxfilesize"];
$curr_dir=$_REQUEST['curr_dir'];

$pDir=$_REQUEST['pDir'];
$type=$_REQUEST['type'];
$filetypes=$_REQUEST['filetypes'];


$arrListExtendFileUpload = explode(',',$filetypes);
if(is_array($arrListExtendFileUpload))
	foreach($arrListExtendFileUpload as $k => $v) {		
		if(preg_match('/^(php|pl|py|cgi|aspx|asp|jsp|jar|txt)$/i',strtolower(trim($v))) || (strlen(trim($v))>3 && trim($v)!='jpeg'))
			die();
	}
	
//End Mod
	
$basedir=$_REQUEST['basedir'];
if(empty($curr_dir))
	$curr_dir=$pDir;
$dialog=new DIALOG($pDir,$type);
$dialog->setBaseDir(".");
$dialog->setBaseURL($baseURL);
$dialog->setCurrentDir($curr_dir);
$dialog->setFileType($filetypes);
$dialog->setInputName($inputname);

if($dialog->dialogtype==DIALOG_OPEN)
	$title="Open";
elseif($dialog->dialogtype==DIALOG_SAVE)
	$title="Save";
elseif($dialog->dialogtype==DIALOG_SAVEAS)
	$title="Save As";
	

if($_POST['act']=='AddDir')
{
	$dialog->makeDir($_POST['variable']);
}

if($_POST['act']=='SaveAs')
{
	$dialog->saveFile($_POST['variable']);
}

if ($_POST["btnUpload"]!=""){
	if (!is_uploaded_file($_FILES["upfile"]["tmp_name"])){
		echo "<script>alert('1This file can\'t be uploaded to server!')</script>";
	}else{
		$ftmp_name = $_FILES["upfile"]["tmp_name"];
		$fname = $_FILES["upfile"]["name"];
		$errNo = 0;
		if (checkValidImageFile($_FILES["upfile"], "", $filetypes, $errNo)){
			if ($errNo==1){
				echo "<script>alert('This file type is not allow!')</script>";
			}else
			if ($erroNo==2){
				echo "<script>alert('This size of file at most is ".$maxfilesize."!')</script>";
			}else
			if (@is_writable($_POST["currentDir"])){
				@copy($ftmp_name, $_POST["currentDir"]."/".$fname);
				
				$path_file_name = $_POST["currentDir"]."/".$fname;
				$ext_file = strtolower(getImageExtension($fname));
				if($ext_file=="jpg" || $ext_file=="jpeg" || $ext_file=="png" || $ext_file=="bmp" || $ext_file=="gif" || $ext_file=="tif") {
					$objWriter = new writeTextToImage();
					
					$objWriter->inputImage 	= ''.$path_file_name.'';
					$objWriter->inputType 	= ''.$ext_file.'';
					$objWriter->outputImage = ''.$path_file_name.'';
					$objWriter->outputType 	= ''.$ext_file.'';
					$objWriter->text 		= 'tnktravel.com';
					$objWriter->fontSize 	= 5;
					$objWriter->textColor 	= array(255, 255, 255);
					$objWriter->borderFlag	= false;
					$objWriter->borderColor = array(0, 0, 0);
					$objWriter->backFlag	= false;
					$objWriter->backColor	= array(0, 0, 0);
					$objWriter->marginH 	= 0;
					$objWriter->marginV 	= 0;
					$objWriter->alignH 		= 'RIGHT';	
					$objWriter->alignV 		= 'BOTTOM';
					$objWriter->quality 	= 95;
					$objWriter->opacity 	= 80;
					$objWriter->show 		= false;
					$objWriter->save 		= true;
					$objWriter->_doWrite();					
				}
				
					
			}else{
				echo "<script>alert('This directory is not allow to upload!')</script>";
			}
		}else{
			echo "<script>alert('This file can\'t be uploaded to server!')</script>";
		}
	}
}

function getImageExtension($imgName) {
	if(strpos($imgName,"."))
		{
			$arrListExpExtension = explode(".",$imgName);
			if(is_array($arrListExpExtension))
				return end($arrListExpExtension);
		}
	else return "";
}

function checkValidImageFile($imgfile, $max_file_size="", $allowExt="", &$errNo){
	if ($max_file_size==""){
		$max_file_size = 10485760;
	}
	if ($allowExt==""){
		$allowExt="jpeg, jpg, gif";
	}
	$file_tmp = $imgfile['tmp_name'];
	$file_name = $imgfile["name"];
	
	$arrListExpExtension = explode("\.",$file_name);
	if(is_array($arrListExpExtension))
		foreach($arrListExpExtension as $k => $v)
			if(eregi("php",$v)) die("Cút ngay !!!");
	
	//End Modifier			
	$extension = strtolower(substr(strrchr($file_name,"."),1));
	//check extension
	if (strpos($allowExt, $extension)===false){
		$errNo = 1;//extension is not allow
		return 0;
	}
	//check size
	$size = @filesize($file_tmp);
	if ($size>$max_file_size){
		$errNo = 2;//size is not allow
		return 0;
	}
	//else
	return 1;
}

?>
<html>
<head>
<title><?php echo $title?></title>
<style>
body,td
{
	font-family:verdana;
	font-size:11px;
}
a{
text-decoration:none;
color:#000000;
}
a:hover
{
text-decoration:underline;
}
.title{
background-color:#999999;
color:#FFFFFF;
font-weight:bold;
height:25px;
padding-left:5px;
}
.filebox
{
	border:1px solid #CCCCCC;
	padding-top:5px;
	padding-bottom:5px;
	width:<?=$dialog->boxWidth-$thumbwidth-20?>px;
	height:<?=$dialog->boxHeight-170?>px;
	overflow:auto;
}
.inputfield{
	height:22px;
}
.btn{
	width:75px;
	height:22px;
}

</style>
<script type="text/javascript" language="javascript">

var httpRequest = false; 

function makeRequest(url) {

	httpRequest = false;
	
	if (window.XMLHttpRequest) { 
	
		httpRequest = new XMLHttpRequest();
	
		if (httpRequest.overrideMimeType) {
	
			httpRequest.overrideMimeType(text/xml);
	
		}
	} else 
	if (window.ActiveXObject) {

		try {
	
			httpRequest = new ActiveXObject("Msxml2.XMLHTTP");

		} catch (e) {
			
			try {
		
				httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
		
			} catch (e) {
		
				
				alert(e.toString());
		
			}
		
		}
	
	}
	
	if (!httpRequest) {
	
		alert("Giving up : Cannot create an XMLHTTP instance");
		
		return false;
	
	}
	
	httpRequest.onreadystatechange = alertContents;
	
	httpRequest.open("POST",url, true);
	
	httpRequest.send("bb=bbbs");
	
}
	
function alertContents() {
		
	if (httpRequest.readyState == 4) {
		
		if (httpRequest.status == 200) {
		
			//alert("Dimension:"+httpRequest.responseText);
			showDimension(httpRequest.responseText);
		} else {
		
			alert("There was a problem with the request.");
		
		}
	
	}

}

</script>

<script language="javascript">
function chDir(dir)
{
	if(dir==null || dir=="" )
		dir="<?php echo str_replace('\\','/',dirname($dialog->currentDir))?>";
	for(i=0;i<document.form1.curr_dir.options.length;i++)
	{
		if(document.form1.curr_dir.options[i].value==dir)
		{
			document.form1.curr_dir.options[i].selected=true;
			document.form1.submit();
		}
	}
}
function newDir()
{
	newDir=prompt("Enter New Directory Name","New Folder")
	document.form1.act.value="AddDir";
	document.form1.variable.value=newDir;
	document.form1.submit();
}

function about(){
	alert("Open File Browser 1.0.0\nLast Update:06/24/2007\nAuthor: NVCOM\nWebsite: http://www.nhanviet.vn\nEmail:support@nhanviet.vn");
}

function selFile(file, furl)
{
	document.form1.filename.value=file;
}
function viewFile(furl){
	if (document.thumb.src != furl){
		//document.getElementById("athumb").href = furl;
		document.thumb.src = furl;
		getImgSize("thumb");
	}
}

function openFile()
{
	<?php if($dialog->dialogtype==DIALOG_OPEN) {?>
		window.opener.openFile<?="_".$inputname?>(document.form1.filename.value);
		window.close();
	<?php }elseif($dialog->dialogtype==DIALOG_SAVE) {?>
		window.opener.newFile(document.form1.filename.value);
		window.close();
	<?php }elseif($dialog->dialogtype==DIALOG_SAVEAS) {?>
		window.opener.saveFileAs(document.form1.filename.value);
		window.close();
	<?php }?>
}
function openFile1()
{
//	window.opener.document.getElementById("openfile").value="<?php echo $dialog->currentDir?>/"+document.form1.filename.value;
	<?php if($dialog->dialogtype==DIALOG_OPEN) {?>
		window.opener.openFile("<?php echo $dialog->baseURL?>/"+document.form1.filename.value);
		window.close();
	<?php }elseif($dialog->dialogtype==DIALOG_SAVE) {?>
		window.opener.newFile("<?php echo $dialog->baseURL?>/"+document.form1.filename.value);
		window.close();
	<?php }elseif($dialog->dialogtype==DIALOG_SAVEAS) {?>
		window.opener.saveFileAs("<?php echo $dialog->baseURL?>/"+document.form1.filename.value);
		window.close();
	<?php }?>
}

function PopupPic(sPicURL) { 
	window.open("popup.htm?"+sPicURL, "", "resizable=1,height=200,width=200,status=0");
}

function getWidthAndHeight() {
    //alert("'" + this.name + "' is " + this.width + " by " + this.height + " pixels in size.");
	showDimension(this.width+"x"+this.height);
    return true;
}
function loadFailure() {
    alert("'" + this.name + "' failed to load.");
    return true;
}

function showDimension(val){
	if (document.form1.resolution){
		document.form1.resolution.value = val;
	}else{
		document.getElementById("resolution").value = val;
	}
}

function getImgSize(id)
{
	var pic = document.getElementById(id);
	var imgSrc = pic.src;
	showDimension("");
	makeRequest('getsize.php?f='+imgSrc);
	/*
	var myImage = new Image();
	myImage.name = imgSrc;
	myImage.src = imgSrc;
	myImage.onload = getWidthAndHeight;
	myImage.onerror = loadFailure;*/
}

function getImgSize1(id){
	var pic = document.getElementById(id);
	//var h = pic.offsetHeight;
	//var w = pic.offsetWidth;
	var h = pic.height;
	var w = pic.width;
	showDimension(w+" x "+h);
}


function enLarge(){
	PopupPic(document.thumb.src);
	//window.location = document.thumb.src;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">
<table width='100%' border=0 cellpadding="0" cellspacing="0" height="100%">
<form name='form1' action="" method="POST" enctype="multipart/form-data">
<input type="hidden" name="title" value="<?php echo $title?>">
<input type="hidden" name="pDir" value="<?php echo $pDir?>">
<input type="hidden" name="currentDir" value="<?php echo $dialog->currentDir?>">
<input type="hidden" name="inputname" value="<?=$inputname?>">
<input type="hidden" name="maxfilesize" value="<?=$maxfilesize?>">
<input type="hidden" name="type" value="<?php echo $type?>">
<input type="hidden" name="filetypes" value="<?php echo $filetypes?>">
<input type="hidden" name="basedir" value="<?php echo $basedir?>">
<input type="hidden" name="act" value="xxx">
<input type="hidden" name="variable" value="xxx">
<tr class="title">
	<td colspan="2">&nbsp;<?php echo $title?></td>
</tr>
<tr>
	<td width="<?=$thumbwidth?>" bgcolor="#FFFFFF" align="right">
		Look in:
	</td>
	<td align='left' valign="top" height="30">
		<table style='margin-left:10px' >
		<tr>
	
		<td>
			<?php
	
				$lookin = "<option value='".$dialog->parentDir."'>/</option>";
				
				$pdir_arr=$dialog->getParentDirForCurrentDir();
				$parentdir="";
				for($i=0;$i<count($pdir_arr);$i++)
				{
					$parentdir.="/".$pdir_arr[$i];
					$lookin .= "<option value='".$dialog->parentDir.$parentdir."' selected>".$parentdir."</option>";
				}
	
				$dialog->readDir();
				$dir_arr=$dialog->dirincurrdir;
				
				for($i=0;$i<count($dir_arr);$i++)
				{	
					$lookin .= "<option value='".$dir_arr[$i]."' >".str_replace($dialog->parentDir,"",$dir_arr[$i])."</option>";
				}

			?>
			<select name='curr_dir' onChange="javascript:document.form1.submit();"><?=$lookin?></select>
		</td> 
		<td style="padding-right:5px"><a href='javascript:chDir()' title="Parent Directory"><img src='<?php echo $dialog->iconDir."btnFolderUp.gif"?>' border=0></a></td>
		<td style="padding-right:5px"><a href='javascript:newDir()' title="New Directory"><img src='<?php echo $dialog->iconDir."btnFolderNew.gif"?>' border=0></a></td>
		<td style="padding-right:5px"><a href='javascript:about()' title="About"><img src='about.gif' border=0></a></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td style="border-top:solid #CCCCCC 1px;border-right:solid #CCCCCC 1px" align="center" valign="top">
		<a id="athumb" href="#" onClick="return enLarge();" title="Click to view orginal size!"><img name="thumb" id="thumb" src="<?=$nopic?>"  width="100px" border="0"></a>
		<input type="hidden" name="dfilename" value="">
		<input type="text" name="resolution" value="" style="width:80px;border:0px;text-align:center" readonly="">
	</td>	
	<td align='left' valign="top">
		<div style='margin-left:10px' class="filebox">
		<table cellpadding="0" cellspacing="0" border="0" >
		<tr>
			<td><?php echo $dialog->getFilesInCurrentDir();	?></td>
		</tr>
		</table>
		</div>
		<table cellpadding="5" cellspacing="0" border="0" style='margin-left:5px'>
		<tr>
			<td nowrap>File Name:</td>
			<td><input type="text" name='filename' size="35" class="inputfield"><input type="button" name="saveFile" value="   <?php 
			if($dialog->dialogtype==DIALOG_OPEN) {echo "Open";}
			elseif($dialog->dialogtype==DIALOG_SAVE) {echo "Save";}
			elseif($dialog->dialogtype==DIALOG_SAVEAS) {echo "Save as";}
			?>    " class="btn" onClick="openFile()"><input type="button" onClick="javascript:window.close();" value="Cancel " class="btn"></td>
		</tr>
		<tr>
			<td nowrap>Upload:</td>
			<td colspan="3"><input type="file" name='upfile' size="35"  class="inputfield"><input type="submit" value="Upload" class="btn" name="btnUpload"></td>
		</tr>
		</table>
	</td> 
</tr>
<tr>
	<td colspan="3" bgcolor="#EFEFEF" height="20px">&copy;2005-2007 All Rights Reserved. Nhan Viet Communication JSC. </td>
</tr>
</form>
</table>
</body>
</html>