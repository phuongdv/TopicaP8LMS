<?php
require_once("../../config.php");
$course = required_param('c', PARAM_INT);
$all = optional_param('all', 0, PARAM_INT);
require_login();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
print_continue($CFG->wwwroot . '/course/view.php?id=' . $course);
$check = '';
if ( $all == 1 ) {$check = 'checked';}
$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
$mysqli->select_db($CFG->dbname);
$mysqli->query("SET NAMES 'utf8'");
?>
<script language="javascript" type="text/javascript">
<!--
function popitup(url) {
	newwindow=window.open(url,'name','height=300,width=400');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</script>

<?php
echo '<form id="main" method="GET">Xem tất cả <input type="checkbox" name="all" value="1" '.$check.'><input type="hidden" name="c" value="'.$course.'"><input type="submit" value="ok"></form>';
$query_string = "SELECT *,UNIX_TIMESTAMP(time) as u_time FROM tp_question_fb where course = $course";
if ($all == 0 ){ $query_string .=  " and complete = $all";}
$query_string .=  " order by complete";
//echo $query_string;
$ad = $mysqli->query($query_string);
	if (mysqli_num_rows($ad) > 0){
		echo '<table border="1" cellspacing="0" cellpading ="2"><tr><th>Username</th><th>Mã câu</th><th>Nội dung</th><th>Thời gian</th><th>Trạng thái</th><th>Chi tiết</th></tr>';
		while($dd = $ad->fetch_assoc()) 
		{
			$tt = 'Chưa xử lý';
			$ac = 1;
			if ($dd["complete"]==1) {$tt = 'Đã xử lý'; $ac =0;}
			echo '<tr><td>'.$dd["username"].'</td><td>'.$dd["fullname"].'</td><td><a href="#" onClick="return popitup(\'rp_view_dt.php?id='.$dd["id"].'\')" title="'.strip_tags($dd["content"]).'">'.substr(strip_tags($dd["content"]),0,20).'...'.'</a></td><td>'.date("G:i d-m",$dd["u_time"]).'</td><td><a href="rp_up.php?id='.$dd["id"].'&c='.$course.'&a='.$all.'&ac='.$ac.'">'.$tt.'</a></td><td><a href="review.php?attempt='.$dd["attempt"].'&err='.$dd["question"].'#err">view</a></td></tr>';
		}
		echo '</table>';
	}
$ad->close();
$mysqli->close();
print_footer($site); 
?>