<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Import điểm BTN File Excel</title>
</head>

<body>
<div align="center"><h1>CẬP NHẬT SỐ BUỔI OFFLINE CỦA SINH VIÊN</h1><br /></div>

    	<form enctype="multipart/form-data" action="" method="post">
              <table width="70%" align="center" >
              <tr><td colspan="4"><a href="ds_offline.xls">Download file mẫu</a> </td></tr>
              <tr>
              <td><strong>Bước 1</strong>: Chọn file import</td>
              <td>1. <input type="file" name="file" /></td>
			  <td><strong>Bước 2</strong>: Upload dữ liệu</td>
			  <td><input type="submit" name="upfile"  value="2. Upload" /></td>
              </tr>
              <tr>
              <td><strong>Bước 3</strong>: Kiểm tra dữ liệu</td>
              <td><input type="submit" name="kiem_tra"  value="3. Kiểm tra dữ liệu" /></td>
              <td><strong>Bước 4</strong>: Cập nhật số buổi Offline cho sinh viên</td>
              <td><input type="submit" name="update"  value="4. Cập nhật buổi Offline" /></td>
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
error_reporting (E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
//khi kich nut upload file
if ($_POST['upfile'])
{
	//1. xoa trang du lieu trong ban tam tmp_import_offline truoc khi import dot moi
	$sql_delete = "delete from tmp_import_offline ";
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
		$sql = "insert into tmp_import_offline(username,ho_ten,number_offline,course,ghi_chu) values(";
		$sql .= "'".$data->val($i,2)."'";
		$sql .= ",'".$data->val($i,3)."'";
		$sql .= ",'".$data->val($i,4)."'";
		$sql .= ",'".$data->val($i,5)."'";
		//$sql .= ",'".$data->val($i,6)."'";
		$sql .= ",'".$data->val($i,6)."');";
		$result=mysql_query($sql);
		
	}	
		
	//3. Hien thi du lieu lên form
	include_once('ds_offline_sinh_vien.php');
	

}

	//4. Kiểm tra khi nhấn nút cập nhật
	if ($_POST['update'])
	{
		$sql_kiem_tra = " SELECT * FROM tmp_import_offline where ket_qua_kiem_tra_yn = 'Y'";
		$result = mysql_query($sql_kiem_tra);
		$num_row = mysql_num_rows($result); // Số user được cập nhật
		$num_insert=0;
		$num_update=0;
		$num_old=0;
		while ($row = mysql_fetch_array($result))
		{
				$sql_check_user = "select id u_id from mdl_user where username = '".$row["username"]."'";
				$result_user = mysql_query($sql_check_user);
				$row_user = mysql_fetch_array($result_user);
				//neu co ton tai sinh vien thi insert vao bang offline
				$sql_offline="SELECT * FROM offline WHERE c_id=".$row['course']." AND u_id=".$row_user['u_id'];
				$ket_qua = mysql_query($sql_offline);
				$row_check = mysql_fetch_array($ket_qua);
				
				if(mysql_num_rows($ket_qua)>0)
				{
					// Nếu điểm BTN khác với điểm BTN đã có thì update
					if ( $row['number_offline'] != $row_check['number'])
					{
						$sql  = "update offline set number=".$row['number_offline']." WHERE c_id=".$row['course']." AND u_id=".$row_user['u_id'] ;
						mysql_query($sql);
						echo 'Đã update ';
						$num_update++;
					}
					else 
					{	// Nếu điểm BTN bằng điểm BTN đã có thì update điểm đã tồn tại
						$sql_update = "update tmp_import_offline set ghi_chu_kiem_tra ='Đã tồn tại bằng số buổi hiện tại' where id=".$row["id"];
						mysql_query($sql_update);
						$num_old++;	
					}
					
					
				}
				else
				{
					//Nếu không có trong bảng offline thì insert mới
					$sql  = "insert into offline(number,c_id,u_id,btvn) values(";
					$sql .= "'".$row['number_offline']."'";
					$sql .= ",'".$row['course']."'";
					$sql .= ",'".$row_user['u_id']."'";
					$sql .= ",'');";
					mysql_query($sql);
					$num_insert++;
				}
				
		}
		$sql = " SELECT * FROM tmp_import_offline ";
		$result = mysql_query($sql);
		$tong_so_sinh_vien = mysql_num_rows($result); // Tong so ban ghi
			echo "<table border='0' align='center' width='70%'><tr>";
			echo "<td><strong> Thông báo kết quả</strong>:</td>";
			echo "<td>&nbsp;</td></tr>";
			echo "<tr><td>&nbsp;</td>";
			echo "<td><font color='#FF0000'>Import không thành công: ".($tong_so_sinh_vien - $num_row)."/".$tong_so_sinh_vien."</font></td></tr>";
			echo "<tr><td>&nbsp;</td>";
			echo "<td><font color='#FF0000'>Update thành công: ".$num_update."</font></td></tr>";
			echo "<tr><td>&nbsp;</td>";
			echo "<td><font color='#FF0000'>Insert thành công: ".$num_insert."</font></td></tr>";
			echo "<tr><td>&nbsp;</td>";
			echo "<td><font color='#FF0000'>Điểm đã tồn tại: ".$num_old."</font></td></tr>";
			echo "</table>";
		//load du lieu len form goi trang ds_offline_sinh_vien
			include_once('ds_offline_sinh_vien.php');
	}	
	
// 5. kiem tra khi chua chon nút kiem tra

if ($_POST['kiem_tra'])
	{

		$sql = " SELECT * FROM tmp_import_offline ";
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
			$sql_check = "select id u_id from mdl_user where username = '".$row["username"]."'";
			$ket_qua = mysql_query($sql_check);
			//$row_check = mysql_fetch_array($ket_qua);
			if(mysql_num_rows($ket_qua)>0)
			{
				//neu co ton tai sinh vien thi update la Y
				//$sql_update = "update tmp_import_offline set ket_qua_kiem_tra_yn = 'Y', u_id=".$row_check['u_id']." where id=".$row["id"];
				$sql_update = "update tmp_import_offline set ket_qua_kiem_tra_yn = 'Y' where id=".$row["id"];
				$ket_qua = mysql_query($sql_update);
			}
			else
			{
				//neu khong ton tai sinh vien thi update N va comment
				$sql_update = "update tmp_import_offline set ket_qua_kiem_tra_yn = 'N', ghi_chu_kiem_tra ='Username không tồn tại'
																where id=".$row["id"];
				$ket_qua = mysql_query($sql_update);
			}
		}
		
	}
	// Hien thi du lieu da update
include_once('ds_offline_sinh_vien.php');
}

//6. Khi nhấn nút xuất excel kết quả kiểm tra

	?>
    	
</body>
</html>
