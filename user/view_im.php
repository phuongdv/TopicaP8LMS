<?php
require_once("../config.php");
require_login();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Lấy tài khoản");
echo 'Thông tin của '.$USER->lastname.' '.$USER->firstname.'<br>';
$filename = $USER->username.'.xml';
//$filename = 'anhtv09a1.xml';
$url = 'http://210.245.87.137/SCMSUploadImages/xmldata/'.$filename;
//$url = $filename;
$xml = '';
$xml = simplexml_load_file($url);
echo '
<style>
.show-diem-head {
background-color:#790000;
color:#FFFFFF;
font-size:13px;
}
</style>
';
if ( isset($xml) && $xml != '' ){

	$ho_so = $xml->HO_SO;
	echo 'Mã học viên: '.$ho_so->MA_HOC_VIEN.' <br>';
	$hoc_phi = $xml->HOC_PHI;
	echo '<h3>Học phí</h3>';
	echo '<table  border=1 cellspacing=0 cellpadding =2><tr><td>Đợt</td><td>Phải nộp</td><td>Đã nộp</td><td>Còn thiếu</td></tr>';
	foreach($hoc_phi->DOT_HOC as $dothoc)
	  {
	  	  echo '<tr>';
	 	$tits = $dothoc->attributes();
	 	foreach($tits as $tit => $tit1)
	 	{
	 		if($tit == 'DOT'){ echo '<td>'.$tit1.'</td>';}
	 	}
	 	$muc_dich = $dothoc->MUC_DICH;
		 foreach($muc_dich as $muc)
		  {
		 	
		  	echo '<td align="right">'.$muc->SO_TIEN.'</td>';
		  }
		  
	  	echo '</tr>';
	  }
	  echo '</table>';
	  	echo '<h3>Bảng điểm</h3>';
	$bang_diem = $xml->BANG_DIEM;
echo '<table border=1 cellspacing=0 cellpadding =2><tr><th class="show-diem-head">Mã Môn</th><th class="show-diem-head">Tên Môn</th><th class="show-diem-head">Số học trình</th><th class="show-diem-head">Điểm chuyên cần</th><th class="show-diem-head">Điểm giữa kỳ</th><th class="show-diem-head">Điểm cuối kỳ</th><th  class="show-diem-head">Điểm tổng kết</th></tr>';
foreach($bang_diem->MON_HOC as $mon)
  {
  	  echo '<tr>';
 	$tits = $mon->attributes();
 	foreach($tits as $tit => $tit1)
 	{
 		if($tit == 'MA_MON'){ echo '<td>'.$tit1.'</td>';}
 		if($tit == 'TEN_MON'){ echo '<td>'.$tit1.'</td>';}
 		if($tit == 'SL_DV_HT'){ echo '<td align="right">'.$tit1.'</td>';}
 	}
  	echo '<td align="right">'.$mon->DIEM_CHUYEN_CAN.'</td><td align="right">'.$mon->DIEM_GIUA_KY.'</td><td align="right">'.$mon->DIEM_CUOI_KY.'</td><td align="right">'.$mon->DIEM_TONG_KET.'</td></tr>';
  }
 echo '</table>';
} else { echo 'Dữ liệu điểm đang được cập nhật ';}
  print_footer($site);
?> 