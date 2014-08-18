  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({
        mode : "textareas",
		theme:"simple"

});
</script>

<?php
$week_id=$_REQUEST['w']; // lay ma tuan
$f=$_GET['f']; // lay loai can sua

$data_upload='upload';
$file1Name = $_FILES['card_gv']['name'];
$file1Type = $_FILES['card_gv']['type'];
$file1Temp = $_FILES['card_gv']['tmp_name'];


require_once("../config.php");
global $CFG, $QTYPES,$USER;
$usehtmleditor = can_use_richtext_editor();

$conn = mysql_connect($CFG->dbhost, $CFG->dbuser,$CFG->dbpass);
$dbname = $CFG->dbname;
mysql_select_db($dbname);


// check role
// checkrole

$sql = "SELECT min(r.id) rid,c.id cid
 FROM
	mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
INNER JOIN vietth_tam vt on vt.course=c.id
WHERE 
vt.id=$week_id
and
u.id=$USER->id
";

$data = mysql_query($sql);
	while($info = mysql_fetch_array( $data )) 
     {
     	$roleid=$info['rid'];
     	$cid=$info['cid'];
     }	  
     
if($roleid!=4 && $roleid!=13 && $roleid!=211 ){
	    echo '<script>alert(\'Rất tiếc, Thầy \ cô không phải GVCM của lớp môn này !\');</script>';	
      	echo '<script>window.location=\'index.php?c='.$cid.'\'</script>';	
      	die('Rất tiếc, Thầy \ cô không phải GVCM của lớp môn này !');
      	} 
      	 

if($_POST['submit']!='')
{	
	if($f!=3)
	{
$query_string = "update vietth_tam set ".ftofiled($f)." = '".$_POST['content']."',timestamp=NOW() where  id=$week_id";
	}
	else 
	{
		
		if (!empty($file1Name))
			{
				
					$result = @upload_files_doc($file1Name, $file1Type, $file1Temp, $data_upload);
				
				if(!$result)
				{
					echo "upload lỗi";
				}
				else
					$file1 = $file1Name . $file1Type;
			}
		
		
$query_string = "update vietth_tam set ".ftofiled($f)." = '".$file1."',timestamp=NOW() where  id=$week_id";		
	} 

$data = mysql_query($query_string);	
$msg=" Đã lưu ";
}





//print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");


// lay thong tin course
$query_string = "select c.fullname coursename,vt.* from mdl_course c,vietth_tam vt where c.id=vt.course and vt.id=$week_id";

	$data = mysql_query($query_string);
	while($info = mysql_fetch_array( $data )) 
     { 
     $coursename=$info['coursename'];
     $content=$info[ftofiled($f)];
     $name='tuần '.$info['stttuan'];
	 $tuan=$info['stttuan'];
	 $tuantoi=intval($info['stttuan'])+1;
     }     
 // print brecum
     /* echo '<div class="breadcrumb"><h2 class="accesshide ">Bạn đang ở đây</h2> <ul>
<li class="first"><a href="http://elearning.hou.topica.vn/">TOPICA</a></li><li class="first"> <span class="accesshide ">/&nbsp;</span><span class="arrow sep">►</span><a href="http://elearning.hou.topica.vn/course/view.php?id='.$cid.'">'.$coursename.'</a> </li><li class="first"> <span class="accesshide ">/&nbsp;</span><span class="arrow sep">►</span>TIM</li></ul></div>';
*/   if($f==4)
    {echo '<h2 class="main help"><img alt="" src="http://elearning.hou.topica.vn/pix/smartpix.php/topica/mod/label/icon.gif">'.ftotext($f).' tuần '.$tuantoi.'<img src="http://elearning.hou.topica.vn/pix/smartpix.php/topica/help.gif" alt="Help with Đang cập nhật Nhãn trong chủ đề 1 (new window)" class="iconhelp"></h2>';
 }
   else 
   {
    if($tuan==1)
	{
	 echo '<h2 class="main help"><img alt="" src="http://elearning.hou.topica.vn/pix/smartpix.php/topica/mod/label/icon.gif">'.ftotext($f).'<img src="http://elearning.hou.topica.vn/pix/smartpix.php/topica/help.gif" alt="Help with Đang cập nhật Nhãn trong chủ đề 1 (new window)" class="iconhelp"></h2>';
   
	}
	else
	{
	echo '<h2 class="main help"><img alt="" src="http://elearning.hou.topica.vn/pix/smartpix.php/topica/mod/label/icon.gif">'.ftotext($f).'<img src="http://elearning.hou.topica.vn/pix/smartpix.php/topica/help.gif" alt="Help with Đang cập nhật Nhãn trong chủ đề 1 (new window)" class="iconhelp"></h2>';
    }
  }
 ?>
 <form action="" method="POST" enctype="multipart/form-data">
 <?php
   if($f==3)
   {
   	echo '<div align="center"><input type="file" name="card_gv" id="card_gv" /></div><br><div align="center">(*) Chấp nhận các file dạng : *.doc,*.docx,*.txt,*.pdf,*.zip,*.rar</div>';
   }
   else 
   {
   echo '<textarea style="width:100%;height:200px" name="content" id="content">'.$content.'</textarea>';
   /*
   print_textarea($usehtmleditor, 15, 40, 400, 300, 'content',$content);
       if ($usehtmleditor) {
        use_html_editor();
    	}
	*/	
   }

?>
<div align="center"><br><br>
<input type="hidden" name="f" value="<?php echo $f; ?>">
<input type="submit" name="submit" value=" Hoàn tất  "> <br>
<span style="color:green;font-family:arial;font-weight:bold"><?php echo $msg ?></span>
</div>
<?php
function ftofiled($f)
{
 switch ($f) {
 		case 6:
 			return 'dh_nv';
 			break;
 		case 7:
 			return 'tongket';
 			break;
 		case 5:
 			return 'nhanxet';
 			break;
 		case 4:
 			return 'dh_tuantoi';
 			break;
 		case 3:
 			return 'cardgv';
 			break;	
 		default:
 			break;
 	}	
	
	
}

function ftotext($f)
{
 switch ($f) {
 		case 6:
 			return 'Nhiệm vụ toàn khóa học và định hướng công việc tuần 2:';
 			break;
 		case 7:
 			return 'Nhận xét công việc trong tuần của GVHD';
 	       break;
 		case 5:
 			return 'Nhận xét công việc trong tuần của GVHD';
 			break;
 		case 4:
 			return 'Định hướng công việc';	
 			break;
 		case 3:
 		   return 'Card giảng viên';
 		   break;
 		   	
 		default:
 			break;
 	}	
	
	
}

function upload_files_doc(&$file_name, &$file_type, $file_tmp, $dir_upload)
{
	$date = getdate();	
	$time_update = $date[0];
	$file_name = $time_update;
	//$file_type = substr($file_type, -strpos($file_type, '/'));
	switch ($file_type) {
		case 'text/plain':
			$file_type = '.txt';
		break;
		case 'application/msword':
			$file_type = '.doc';
		break;
		case 'application/zip':
			$file_type = '.zip';
		break;		
		//rar
		case 'application/x-zip-compressed';
		    $file_type='.rar';
		break;    
		// docx
		case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
		    $file_type='.docx';
		break;
		// pdf
		case 'application/pdf';
		     $file_type='.pdf';
	}
	if ( !is_dir($dir_upload) )
	{
		//echo 'Can not found the folder: <b>'.$dir_upload.'</b>';		
		return false;
	}
	if ( $file_name == '' or !$file_name or $file_name == 'none')
	{
		//echo 'Can not found the file';
		//exit;
		return false;
	}
	// Copy file can upload len 1 thu muc tren SERVER
	chmod($dir_upload, 0777);
	if ( !@move_uploaded_file($file_tmp, $dir_upload . '/' . $file_name . $file_type) )
	{
		//echo 'Upload failed';
		//exit;
		return false;
	}
	else
		@chmod($dir_upload . '/' . $file_name . $file_type , 0777);
	chmod($dir_upload, 0755);
	return true;
}



?>
<?php
//print_footer($site); 
?>