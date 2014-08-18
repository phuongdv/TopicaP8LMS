<?php
require('global.php');
if($_GET['cid']!='')
 {
   $cid = $_GET['cid'];
   $sql = "select * from mdl_course c left join lmsreport_course_trung_binh ctb on ctb.courseid = c.id  where c.id = $cid ";
   $arr_course = $DB->fetch_assoc($sql);
 }
 
if($_POST['save']!='')
{
$sql  = "REPLACE INTO `lmsreport_course_trung_binh`
SET courseid = $cid,
trung_binh_h2472 = ".$_POST['socauh2472'].",
trung_binh_hoc_vien_h2472 = ".$_POST['hvh2472'].",
trung_binh_dien_dan = ".$_POST['sopdiendan'].",
trung_binh_hoc_vien_dien_dan = ".$_POST['hvdd'];
$DB->execute($sql);

 $cid = $_GET['cid'];
   $sql = "select * from mdl_course c left join lmsreport_course_trung_binh ctb on ctb.courseid = c.id  where c.id = $cid ";
   $arr_course = $DB->fetch_assoc($sql);

$msg="<br>Đã lưu, vui lòng đóng cửa sổ này và refresh trang báo cáo !<br><br>";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nhập giá trị trung bình</title>
</head>

<body>
<div style="font-family:Arial, Helvetica, sans-serif;font-size:10pt" align="center">
  <form id="form1" name="form1" method="post" action="">
    <table width="100%" border="0" cellpadding="3">
      <tr>
        <td width="50%"><div align="right">Lớp môn:</div></td>
        <td width="50%"><strong><?php echo $arr_course[0]['shortname'] ?></strong> </td>
      </tr>
      <tr>
        <td><div align="right">Trung bình số câu hỏi <u>H</u>2472</div></td>
        <td><label>
          <input name="socauh2472" type="text" id="socauh2472" size="5" maxlength="5" accesskey="h" value="<?php echo $arr_course[0]['trung_binh_h2472']?>" />
        </label></td>
      </tr>
      <tr>
        <td><div align="right"><u>T</u>rung bình sổ câu hỏi H2472 trên 1 sinh viên</div></td>
        <td><label>
          <input name="hvh2472" type="text" id="hvh2472" size="5" maxlength="5" accesskey="t" value="<?php echo $arr_course[0]['trung_binh_hoc_vien_h2472']?>" />
        </label></td>
      </tr>
      <tr>
        <td><div align="right">Trung bình số post <u>d</u>iễn đàn</div></td>
        <td><label>
          <input name="sopdiendan" type="text" id="sopdiendan" size="5" maxlength="5" accesskey="d" value="<?php echo $arr_course[0]['trung_binh_dien_dan']?>" />
        </label></td>
      </tr>
      <tr>
        <td><div align="right">Trung bình số <u>p</u>ost diễn đàn trên 1 sinh viên</div></td>
        <td><label>
          <input name="hvdd" type="text" id="hvdd" size="5" maxlength="5" accesskey="p" value="<?php echo $arr_course[0]['trung_binh_hoc_vien_dien_dan']?>" />
        </label></td>
      </tr>
    </table>
	
	<div align="center">
	<?php echo $msg; ?>
	<input type="submit" name="save" value="Lưu" ></div>
  </form>
</div>

</body>
</html>