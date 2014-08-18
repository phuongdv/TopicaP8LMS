<?php
require_once("../config.php");
require_login();
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Lấy tài khoản");
echo 'Bảng điểm của '.$USER->lastname.' '.$USER->firstname.'<br>';
$filename = $USER->username.'.xml';
$url = 'http://210.245.87.137/SCMSUploadImages/StorageXML/XML_DIEM/'.$filename;
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
echo '<table border=1 cellspacing=0 cellpadding =2><tr><th class="show-diem-head">Mã Môn</th><th class="show-diem-head">Tên Môn</th><th class="show-diem-head">Số học trình</th><th class="show-diem-head">Điểm chuyên cần</th><th class="show-diem-head">Điểm giữa kỳ</th><th class="show-diem-head">Điểm cuối kỳ</th><th  class="show-diem-head">Điểm tổng kết</th></tr>';
foreach($xml->MON_HOC as $mon)
  {
  	  echo '<tr>';
 	$tits = $mon->attributes();
 	foreach($tits as $tit => $tit1)
 	{
 		if($tit == 'MA_MON'){ echo '<td>'.$tit1.'</td>';}
 		if($tit == 'TEN_MON'){ echo '<td>'.$tit1.'</td>';}
 		if($tit == 'SO_DVHT'){ echo '<td align="right">'.$tit1.'</td>';}
 	}
  	echo '<td align="right">'.$mon->DIEM_CHUYEN_CAN.'</td><td align="right">'.$mon->DIEM_GIUA_KY.'</td><td align="right">'.$mon->DIEM_CUOI_KY.'</td><td align="right">'.$mon->DIEM_TONG_KET.'</td></tr>';
  }
 echo '</table>';
} else { echo 'Dữ liệu điểm đang được cập nhật ';}
  print_footer($site);
?> 