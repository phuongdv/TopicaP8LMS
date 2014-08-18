<?php
$qid="0";
if(isset($_GET["qid"])){
	$qid=$_GET["qid"];
}
require_once("../../config.php");
global $COURSE;
if(isset($_POST["btnxoa"])){
	$btnxoa=$_POST["btnxoa"];
}
if($btnxoa!='')
{
	$iddes = implode(",", $_POST['idde']);
	if($iddes!='')
	{
		$sql="DELETE FROM vietth_q169_de WHERE id in ($iddes)";

		 mysql_query($sql);
	}
	else
	{
		echo '<script> alert("Phải chọn ít nhất 1 đề để xóa")</script>';
	}
}
$sql="SELECT * FROM vietth_q169_de WHERE quizid='$qid'";
$result=mysql_query($sql);
$count_quiz=mysql_num_rows($result);

print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
?>
	<style type="text/css">
	table.tbl_list{
		border-top:#ccc 1px solid;
		border-left:#ccc 1px solid;
	}
	table.tbl_list td,table.tbl_list th{
		border-right:#ccc 1px solid;
		border-bottom:#ccc 1px solid;
	}
	table.tbl_list th{ background-color:#DDDDDD;}
	a{color:#333333;}
	</style>
	<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('idde[]');
  for each(var checkbox in checkboxes)
    checkbox.checked = source.checked;
}
function confirmSubmit()
{
var agree=confirm("Bạn chắc chắn muốn xóa ? ");
if (agree)
	return true ;
else
	return false ;
}
</script>
<title>Chức năng tạo quiz BT30</title>
</head>
<body>
<form method="POST" name="frm" action="process_create_html.php">
<fieldset><legend>Thông tin tạo đề</legend>
	<div style="color:red;">Bạn có thể tạo <?php $num=20-$count_quiz; echo $num;?> đề nữa</div>
	<b>Chọn số đề (*):</b>
	<input type="hidden" name="txt_quizid" value="<?php echo $qid;?>"/><br/><br/>
	<select name="cbo_number">
		<?php 
		//for($i=3;$i<=$num;$i++)
		for($i=$num;$i>=3;$i--) 
		{ $item=$i<10?"0".$i:$i;?>
		<option value="<?php echo $i;?>"><?php echo $item;?></option>
		<?php }?>
	</select> <br/>
	<input type="submit" value="Tạo đề" />
      <a style="float:right" href="javascript:void(0)" onClick="window.open( 'update_html.php?qid=<?php echo $qid;?>','myWindow', 'scrollbars=true,height = 600, width = 800' )" > Update đề thi đã tạo</a> <br/>
	 <div align="right"> (Update câu hỏi, đáp án của các đề thi đã tạo nếu câu hỏi, đáp án có sự thay đổi so với ngân hàng câu hỏi)</div>
</fieldset>
</form>
<div align="center">Link phân phối: <h2>http://elearning.tvu.topica.vn/mod/bt30/bt30.php?qid=<?php echo $qid;?></h2></div>
<?php
if(isset($_SESSION["ISCREAT"])==true && $_SESSION["ISCREAT"]==true ){
	unset($_SESSION["ISCREAT"]);
?>
<p style="text-align:center; color:red; font-size:16px;">Tạo đề thành công</p>
<?php }?>

<div class="quiz_wapper">
	<fieldset><legend>Danh sách đề đã tạo</legend>
	
	<table width="100%" border="0" class="tbl_list">
		<tr>
			<th width="70">STT</th>
			<th width="150">Quiz ID</th>
			<th width="150">Mã đề</th>
			<th>Link đề</th>
			
		</tr>
		<?php
			if($count_quiz>0){
			$count=0;
			while($rows_quiz=mysql_fetch_array($result)){
				$count++;
		?>
		<tr>
			<td align="center"><?php echo $count;?></td>
			<td align="center"><?php echo $rows_quiz["quizid"];?></td>
			<td align="center"><?php echo $rows_quiz["code"];?>&nbsp;</td>
			<td><a href="<?php echo $rows_quiz["url_file"];?>"><?php echo $rows_quiz["url_file"];?></a></td>
		</tr>
		<?php } // end while
		}else{
		?>
		<tr><td colspan="4" style="color:red;">Chưa có đề nào được tạo cho quiz này</td>
		<?php }//end if ?>
	</table>

	</fieldset>
</div>
<div align="center">
<a href="/course/view.php?id=<?php echo $COURSE->id;?>"> Quay lại </a>
</div>
</body>
</html>
<?php
print_footer($site); 
?>