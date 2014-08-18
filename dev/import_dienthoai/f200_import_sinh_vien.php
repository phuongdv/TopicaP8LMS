<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>f200 - Cập nhật số điện thoại cho user</title>
<style type="text/css">
<!--
.style2 {color: #810C15}
-->
</style>
</head>

<body>
<div align="center"><span class="style2"><h1>F200 - CẬP NHẬT SỐ ĐIỆN THOẠI CHO USER</h1></span></div>

    	<form enctype="multipart/form-data" action="" method="post">
              <table width="70%" align="center" >
              <tr><td colspan="4"><a href="ds_dienthoai.xls">Download file mẫu</a> | <a href="huongdan_import_dienthoai.doc">Hướng dẫn import điện thoại</a></td></tr>
              <tr>
              <td><strong>Bước 1</strong>: Chọn file import</td>
              <td>1. <input type="file" name="file" /></td>
			  <td><strong>Bước 2</strong>: Upload dữ liệu</td>
			  <td><input type="submit" name="upfile"  value="2. Upload" /></td>
              </tr>
              <tr>
              <td><strong>Bước 3</strong>: Kiểm tra dữ liệu</td>
              <td><input type="submit" name="kiem_tra"  value="3. Kiểm tra dữ liệu" /></td>
              <td><strong>Bước 4</strong>: Cập nhật số điện thoại</td>
              <td><input type="submit" name="update"  value="4. Cập nhật số điện thoại" /></td>
              </tr></form>
              <tr><form enctype="multipart/form-data" action="export_excel.php" method="post"> <!-- Truy xuất tới trang xuất excel  -->
              <td>&nbsp;</td>
              <td colspan="3"><input type="submit" name="excel"  value="5. Xuất excel kết quả kiểm tra" /> </td>
              </tr>
              </table>
</form>
         
         <?php
		 
//khai bao thong so ket noi		 
require_once("../../config.php");
error_reporting (E_ALL ^ E_NOTICE);
//khi kich nut upload file
if ($_POST['upfile'])
{
	//1. xoa trang du lieu trong ban tam tmp_import_dienthoai_topica truoc khi import dot moi
	$sql_delete = "delete from tmp_import_dienthoai_topica ";
	$ket_qua = mysql_query($sql_delete);
	/*--------------------------------------------
	/* Đọc và hiển thị file Excel
	/*------------------------------------------*/
	$filename=$_FILES['file']['tmp_name'];
		require_once 'excel_reader.php'; // Thư viện xử lý
	$data = new Spreadsheet_Excel_Reader($filename,true,"UTF-8"); // Đọc file excel, hỗ trợ Unicode UTF-8
	$rowsnum = $data->rowcount($sheet_index=0); // Số hàng của sheet
	$colsnum =  $data->colcount($sheet_index=0);  //Số cột của sheet
	
	//2. read excel file va insert csdl	
	for ($i=4;$i<=$rowsnum;$i++) // Duyệt từng hàng, bắt đầu lấy dữ liệu từ hàng 4
	{
		
		$j=$i-1;
		/*----------------------------------------------
		/* Lưu dữ liệu vào DB
		/*---------------------------------------------*/
		$sql = "insert into tmp_import_dienthoai_topica(username, dien_thoai, ho_ten, ghi_chu) values(";
		$sql .= "'".$data->val($i,2)."'";
		$sql .= ",'".$data->val($i,3)."'";
		$sql .= ",'".$data->val($i,4)."'";
		$sql .= ",'".$data->val($i,5)."');";
		$result=mysql_query($sql);
		
	}	
		
	//3. Hien thi du lieu lên form
	include("ds_sinh_vien.php");
	

}

	//4. Kiểm tra khi nhấn nút cập nhật
	if ($_POST['update'])
	{
		$sql_kiem_tra = " SELECT * FROM tmp_import_dienthoai_topica where ket_qua_kiem_tra_yn = 'Y'";
		$result = mysql_query($sql_kiem_tra);
		$num_row = mysql_num_rows($result); // Số user được cập nhật
		while ($row = mysql_fetch_array($result))
		{
			
				//neu co ton tai sinh vien thi update ma sinh vien vao bang mdl_user
				$sql_update_user = "update mdl_user set topica_dienthoai = '".$row['dien_thoai']."'where username = '".$row['username']."'";
				mysql_query($sql_update_user);
		}
		$sql = " SELECT * FROM tmp_import_dienthoai_topica ";
		$result = mysql_query($sql);
		$tong_so_sinh_vien = mysql_num_rows($result); // Tong so ban ghi
			echo "<table border='0' align='center' width='70%'><tr>";
			echo "<td><strong> Thông báo kết quả</strong>:</td>";
			echo "<td><font color='#FF0000'>Import thành công: ".$num_row."/".$tong_so_sinh_vien."</font></td></tr>";
			echo "<tr><td>&nbsp;</td>";
			echo "<td><font color='#FF0000'>Import không thành công: ".($tong_so_sinh_vien - $num_row)."/".$tong_so_sinh_vien."</font></td></tr>";
			echo "</table>";
		//load du lieu len form goi trang ds_sinh_vien
			include("ds_sinh_vien.php");
	}	
	
// 5. kiem tra khi chua chon nút kiem tra
if ($_POST['kiem_tra'])
	{

		$sql = " SELECT * FROM tmp_import_dienthoai_topica ";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 0 )
		{
		echo " Chưa có dữ liệu để kiểm tra";
		}
	else
	{
	while ($row = mysql_fetch_array($result))
		{
			//update 
			$sql_check = "select * from mdl_user where username = '".$row["username"]."'";
			$ket_qua = mysql_query($sql_check);
			if(mysql_num_rows($ket_qua)>0)
			{
				//neu co ton tai sinh vien thi update la Y
				$sql_update = "update tmp_import_dienthoai_topica set ket_qua_kiem_tra_yn = 'Y' where id=".$row["id"];
				$ket_qua = mysql_query($sql_update);
			}
			else
			{
				//neu khong ton tai sinh vien thi update N va comment
				$sql_update = "update tmp_import_dienthoai_topica set ket_qua_kiem_tra_yn = 'N', ghi_chu_kiem_tra ='Username không tồn tại'
																where id=".$row["id"];
				$ket_qua = mysql_query($sql_update);
			}
		}
		
	}
	// Hien thi du lieu da update
include("ds_sinh_vien.php");
}

//6. Khi nhấn nút xuất excel kết quả kiểm tra

	?>
    	
</body>
</html>
