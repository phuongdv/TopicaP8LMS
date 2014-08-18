<?php
$qid="0";
if(isset($_GET["qid"])){
	$qid=$_GET["qid"];
}
require_once("../../config.php");
$sql="SELECT * FROM tbl_quiz_html WHERE quizid='$qid'";
$result=mysql_query($sql);
$count_quiz=mysql_num_rows($result);
?>
<html>
<head>
	<title>Create static quiz</title>
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
</head>
<body>
<form method="POST" name="frm" action="process_create_html.php">
<fieldset><legend>Thông tin tạo đề</legend>
	<div style="color:red;"> bạn có thể tạo <?php $num=20-$count_quiz; echo $num;?> đề nữa</div>
	<b>Chọn số đề(*):</b>
	<input type="hidden" name="txt_quizid" value="<?php echo $qid;?>"/><br/><br/>
	<select name="cbo_number">
		<?php for($i=3;$i<=$num;$i++){ $item=$i<10?"0".$i:$i;?>
		<option value="<?php echo $i;?>"><?php echo $item;?></option>
		<?php }?>
	</select> <br/>
	<input type="submit" value="Tạo đề" />
</fieldset>
</form>

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
<a href="javascript:history.back()">Go Back</a>
</body>
</html>