<?php
require_once("../../config.php");
    require_once('locallib.php');
$attempt = required_param('a', PARAM_INT);
$question = required_param('q', PARAM_INT);
$course = required_param('c', PARAM_INT);
$so = required_param('ss', PARAM_INT);
$name = required_param('n', PARAM_TEXT);
require_login();
    global $CFG, $QTYPES;
    $usehtmleditor = can_use_richtext_editor();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
echo '<h2 class="main"> <a style="color:#790000">Chào bạn: '. $USER->lastname .' '.$USER->firstname .'</a></h2><br>';
?>
<center>

	Bạn đang gửi phản hồi về câu hỏi số: Q<?php echo $so; ?>
<form action="rp_ins.php" method="POST">
<div style="width:600px">
	Nội dung phản hồi:<br>
      <?php
        print_textarea($usehtmleditor, 15, 40, 400, 300, 'content','');
        if ($usehtmleditor) {
        use_html_editor();
    	}
      ?>
</div>
	<input type="hidden" name="attempt" value="<?php echo $attempt; ?>">
	<input type="hidden" name="question" value="<?php echo $question; ?>">
	<input type="hidden" name="course" value="<?php echo $course; ?>">
	<input type="hidden" name="username" value="<?php echo $USER->username; ?>">
	<input type="hidden" name="email" value="<?php echo $USER->email; ?>">
	<input type="hidden" name="name" value="<?php echo $name; ?>">	<input type="hidden" name="qname" value="<?php echo $so; ?>">
	<br>
	<input type="submit" name="submit" value="Gửi">
</form>

	</center>
<?php
print_footer($site); 
?>