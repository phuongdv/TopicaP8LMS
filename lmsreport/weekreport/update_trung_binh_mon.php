<?php
require('global.php');
$mon_id  = $_GET['mon'];
// get mon
   $sql = "select * from lmsreport_mon_trung_binh ";
   $arr_mon = $DB->fetch_assoc($sql);

   
 
if($_POST['save']!='')
{
$sql  = "UPDATE `lmsreport_mon_trung_binh`
SET 
tb_hv_h2472 = ".$_POST['tb_hv_h2472'].",
tb_hv_dd = ".$_POST['tb_hv_dd'].",
dk_cc = ".$_POST['dk_cc'].",
yc_dang_nhap_tuan_gvcm = ".$_POST['yc_dang_nhap_tuan_gvcm'].",
yc_dang_nhap_tuan_gvdn = ".$_POST['yc_dang_nhap_tuan_gvdn'].",
yc_so_post_tuan_gvdn = ".$_POST['yc_so_post_tuan_gvdn'].",
dk_diem_giua_ky = ".$_POST['dk_diem_giua_ky']." 
Where id = $mon_id";

$DB->execute($sql);

// get chi tiet mon


$msg="<br>Đã lưu, !<br><br>";
}
if($mon_id!='')
{
 $sql ="select * from lmsreport_mon_trung_binh  where id = $mon_id";
   $chitietmon = $DB->fetch_assoc($sql);
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
        <td width="50%"><div align="right">Môn:</div></td>
        <td width="50%">
        <select name="mon" onchange= "this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="?mon=" > Chọn </option>
        <?php
        foreach ($arr_mon as $mon) {
        	if($mon['id']== $mon_id)
        	{
        	echo '<option value="?mon='.$mon['id'].'" selected="selected">'.$mon['ma_mon'].'</option>';
        	}
        	else 
        	{
            echo '<option value="?mon='.$mon['id'].'">'.$mon['ma_mon'].'</option>';
        	}
        }
        ?>
        </select>
        </td>
      </tr>
      <tr>
        <td><div align="right">Trung bình các course trước 1HV/tuần (câu hỏi H2472)</div></td>
        <td><label>
          <input name="tb_hv_h2472" type="text" id="socauh2472" size="5" maxlength="5" accesskey="h" style="text-align:center" value="<?php echo $chitietmon[0]['tb_hv_h2472']?>" />
        </label></td>
      </tr>
      <tr>
        <td><div align="right">Trung bình các course trước 1HV/tuần (số post diễn đàn)</div></td>
        <td><label>
          <input name="tb_hv_dd" type="text" id="hvh2472" size="5" maxlength="5" accesskey="t" style="text-align:center"  value="<?php echo $chitietmon[0]['tb_hv_dd']?>" />
        </label></td>
      </tr>
      <tr>
        <td><div align="right">Điều kiện đạt điểm chuyên cần >=</div></td>
        <td><label>
          <input name="dk_cc" type="text" id="sopdiendan" size="5" maxlength="5" style="text-align:center" accesskey="d" value="<?php echo $chitietmon[0]['dk_cc']?>" />
        </label></td>
      </tr>
      <tr>
        <td><div align="right">Điều kiện đạt điểm giữa kỳ >=</div></td>
        <td><label>
          <input name="dk_diem_giua_ky" type="text" id="hvdd" size="5" maxlength="5" accesskey="p" style="text-align:center" value="<?php echo $chitietmon[0]['dk_diem_giua_ky']?>" />
        </label></td>
      </tr>
            <tr>
        <td><div align="right">Yêu cầu số lần đăng nhập / tuần (GVCM)</div></td>
        <td><label>
          <input name="yc_dang_nhap_tuan_gvcm" type="text" id="hvdd" size="5" maxlength="5" accesskey="p" style="text-align:center" value="<?php echo $chitietmon[0]['yc_dang_nhap_tuan_gvcm']?>" />
        </label></td>
      </tr>
                  <tr>
        <td><div align="right">Yêu cầu số lần đăng nhập / tuần (GVDN)</div></td>
        <td><label>
          <input name="yc_dang_nhap_tuan_gvdn" type="text" id="hvdd" size="5" maxlength="5" accesskey="p" style="text-align:center" value="<?php echo $chitietmon[0]['yc_dang_nhap_tuan_gvdn']?>" />
        </label></td>
      </tr>
                  <tr>
        <td><div align="right">Yêu cầu số bài post diễn đàn của GVDN/tuần</div></td>
        <td><label>
          <input name="yc_so_post_tuan_gvdn" type="text" id="hvdd" size="5" maxlength="5" accesskey="p" style="text-align:center" value="<?php echo $chitietmon[0]['yc_so_post_tuan_gvdn']?>" />
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