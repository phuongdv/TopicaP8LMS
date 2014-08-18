<?
function xlsBOF() {
   echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
   return;
}

function xlsEOF() {
   echo pack("ss", 0x0A, 0x00);
   return;
}

function xlsWriteNumber($Row, $Col, $Value) {
   echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
   echo pack("d", $Value);
   return;
}

function xlsWriteLabel($Row, $Col, $Value ) {
   $L = strlen($Value);
   echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
   echo $Value;
return;
}
/*
header("Pragma: public");
   header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("Content-Type: application/force-download");
   header("Content-Type: application/octet-stream");
   header("Content-Type: application/download");;
   header("Content-Disposition: attachment;filename=php2xls.xls "); // �?ล้วนี่�?็ชื่อไฟล์
   header("Content-Transfer-Encoding: binary ");
*/
header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
    header("Content-Disposition: attachment;filename=test.xls");
      $ho="H? t�n";
   // XLS Data Cell

               xlsBOF();
               xlsWriteLabel(0,0,mb_convert_encoding($ho,"UTF-8"));
               xlsWriteLabel(0,1,"T&#234;n");
               xlsWriteLabel(0,2,"L&#7899;p");
               xlsWriteLabel(0,3,"Nh&#243;m");
               xlsWriteLabel(0,4,"Ng&#224;");
               /*
               xlsWriteLabel(4,0,"Copyright @ ");
               xlsWriteLabel(4,1,"PHP Group VN");
               xlsWriteLabel(6,0,"NO");
               xlsWriteLabel(7,0,"1");
               xlsWriteLabel(6,1,"ID");
               xlsWriteLabel(7,1,"2104");
               xlsWriteLabel(6,2,"Gender");
               xlsWriteLabel(7,2,"Male");
               xlsWriteLabel(6,3,"Name");
               xlsWriteLabel(7,3,"TG");
                */
  xlsEOF();
?>
