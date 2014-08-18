


<?php
require_once("config.php");
    //require_once('locallib.php');

require_login();
    global $CFG, $QTYPES;
    $usehtmleditor = can_use_richtext_editor();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");


$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
        $query_string = "SELECT DISTINCT c.id,c.fullname,c.shortname
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
				WHERE  u.id=".$USER->id;
     $ad = $mysqli->query($query_string);
$key='rfbduhnXzS';	 
?>


	<div align="center"><p style="font-weight:bold; color:810c15">Gửi báo lỗi học liệu</p> </div>
<form name="form1" action="http://ccms.topica.vn/reciever.php" method="POST" enctype="multipart/form-data" >
<div style="width:600px">
    <p style="font-size:9pt">Tiêu đề thông báo lỗi: </p><input type="text" name="tieude"  size="55"  /><br>
   Môn học :<br>
   <input type="text" name="monhoc"  size="55"  /><br>	
		
    Loại sản phẩm:<br>
    <label>
									<input type="checkbox" name="loaihoclieu[]" value="Giáo trình" id="loaihoclieu_0" />
									Giáo trình</label>
								  <label>
									<input type="checkbox" name="loaihoclieu[]" value="Mp3" id="loaihoclieu_1" />
									Mp3</label>
								  <label>
									<input type="checkbox" name="loaihoclieu[]" value="Video bài giảng" id="loaihoclieu_2" />
									Video bài giảng</label>
								  <label>
									<input type="checkbox" name="loaihoclieu[]" value="Câu hỏi trắc nghiệm" id="loaihoclieu_3" />
									Câu hỏi trắc nghiệm</label>
								  <label>
									<input type="checkbox" name="loaihoclieu[]" value="File pdf" id="loaihoclieu_4" />
									File pdf</label><br>	
     Version:  (VD:1.0 , 1.1,...) <br>
   <input type="text" name="version"  size="55"  /><br>	<br>		
     Email nhận thông báo :<br>
   <input type="text" name="email"  size="55" value="<?php echo $USER->email; ?>"  /><br>	<br>							
	Nội dung báo lỗi<br>
      <?php
        print_textarea($usehtmleditor, 15, 40, 400, 300, 'noidunggopy','');
        if ($usehtmleditor) {
        use_html_editor();
    	}
      ?>
	  
</div>
    <input type="file" name="attach" /><br>  <p align="left"><em>Lưu ý : định dạng file đính kèm : .jpg, .gif, .png, .doc, .docx, .xls</em></p>
	<input type="hidden" name="username" value="<?php echo $USER->username; ?>">
	<input type="hidden" name="source" value="LMSTHO">
	<br>
	<input type="submit" name="submit" value="   Gửi đi    " >
</form>

	
<?php
  
   
print_footer($site); 
?>