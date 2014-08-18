<?php

require_once("../../config.php");
require_once("libs_trung.php");

require_login();
$uid= $USER->id;
$attemptid  = $_GET['attemptid'];
$questionid = $_GET['questionid'];

 $sql = "select round(10/number_question,2) new_grade from vietth_q169_de where id =(
 select ma_de from vietth_q169_attempts where id = $attemptid)"; 

 $result=mysql_query($sql);
 
 $rows=mysql_fetch_array($result);
 $new_grade=$rows["new_grade"];

if($_POST['dong_y'])
 {
 
  if($_POST['comment'] ==''){
	echo 'Nội dung nhận xét không được để trống';
  }
  // insert cau hoi cham lai
  $sql="Insert vietth_cham_lai_bt30 (attemptid,questionid,comment,user_edit,new_grade) values('$attemptid','$questionid','".$_POST['comment']."','$uid','".$_POST['new_grade']."')";
  mysql_query($sql);
 }

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="vi" xml:lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
     <script language="JavaScript">
<!--
function refreshParent() {
window.opener.location.href = window.opener.location.href;
if (window.opener.progressWindow) window.opener.progressWindow.close();
window.close();
}
//-->
</script>
    
</head>
<body stlye="font-size:9pt;font-family:Arial" onunload="refreshParent()">
<?php
if(!$_POST['dong_y'])
{
?>

<form method="POST" action="">
<p>Nếu bạn Đông ý cho điểm câu hỏi này, hãy viết nhận xét kích nút Đồng ý </p>
<p>
   <textarea style="width:390px;height:100px" name="comment"></textarea>
</p>
<p>Điểm mới: 1/1</p>
<p><input type="hidden" name="new_grade" value="<?php echo $new_grade ?>"></p>
<p><input name="dong_y" type="submit" value="Đồng ý"></p>
</form>
<?php
 }
 else
 {
 echo 'Đã lưu';
 
 }

?>
</body>
</html>