<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
require_once("../../config.php");
if( isset($_POST['excel']) )
{
	
// Xuất dữ lireeuk ra excel 
header("Pragma: public");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("Content-Type: application/force-download");

    header("Content-Type: application/octet-stream");

    header("Content-Type: application/download");;

    header("Content-Disposition: attachment;filename=Danh_sach_dien_thoai_SV.xls");
// Bảng danh sách mã sinh vien
include ('ds_sinh_vien.php');
}
?>
