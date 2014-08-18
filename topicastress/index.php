<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Topica stress</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9pt;
}
-->
</style>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
require_once "class.phpmailer.php";
require_once "class.smtp.php";
$submit=$_REQUEST['submit'];
$hoten=$_REQUEST['txt_hoten'];
$lop=$_REQUEST['txt_lop'];
$email=$_REQUEST['txt_email'];
$noidung=$_REQUEST['txt_noidung'];


if($submit!="")
{
     $body="Họ tên học viên :".$hoten."<br>".
	       "Lớp             :".$lop."<br>".
		   "Email           :".$email."<br>".
		   "Nội dung góp ý  :".$noidung."";


		global $error;
    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPDebug = 1;  
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'ssl'; 
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465; 
    $mail->Username = "h2472support@topica.edu.vn";  
    $mail->Password = "viet!@#$";           
    $mail->SetFrom("h2472support@topica.edu.vn", "Topica STRESS");
    $mail->Subject = "TOPICA STRESS - Thac mac hoc vien";
    //$mail->Body = $body;
	$mail->MsgHTML($body);
    $mail->AddAddress("vietth@topica.edu.vn");

	
if(!$mail->Send()) {
        $error = 'Gửi mail báo lỗi: '.$mail->ErrorInfo; 
        echo $error;
    } else {
        $error = 'Thư của bạn đã được gửi đi ';
       echo $error;
    }

   



}


?>













<div align="center">
  <form id="form1" name="form1" method="post" action="">
  	<table cellpadding="0" cellspacing="0" width="500px" align="center">
    	<tr>
        	<td style=" border:1px solid #ccc; width:500px;">
            	<table style="background-color:" width="500" border="0px" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
                  <tr>
                    <td  colspan="2"><div align="center"></div></td>
                  </tr>
                  <tr>
                    <td width="200" ><span class="style1">Họ và tên học viên:</span></td>
                    <td width="300"><span id="sprytextfield1">
                      <label>
                      <input type="text" name="txt_hoten" id="txt_hoten" value="<?php echo $hoten; ?>" />
                      </label>
                    <span class="textfieldRequiredMsg" style="font-family:Arial, Helvetica, sans-serif">Phần thông tin bắt buộc.</span></span></td>
                  </tr>
                  <tr>
                    <td class="style1">Lớp</td>
                    <td><span id="sprytextfield2">
                      <label>
                      <input type="text" name="txt_lop" id="txt_lop" value="<?php echo $lop;?>" />
                      </label>
                    <span class="textfieldRequiredMsg" style="font-family:Arial, Helvetica, sans-serif">Phần thông tin bắt buộc.</span></span></td>
                  </tr>
                  <tr>
                    <td class="style1">Email</td>
                    <td><span id="sprytextfield3">
                    <label>
                    <input type="text" name="txt_email" id="txt_email" value="<?php echo $email; ?>" />
                    </label>
                    <span class="textfieldRequiredMsg" style="font-family:Arial, Helvetica, sans-serif">Phần thông tin bắt buộc.</span><span class="textfieldInvalidFormatMsg">Địa chỉ mail không hợp lệ.</span></span></td>
                  </tr>
                  <tr>
                    <td class="style1">Nội dung thắc mắc,góp ý</td>
                    <td><span id="sprytextarea1">
                      <label>
                      <textarea name="txt_noidung" id="txt_noidung" cols="45" rows="5"><?php echo $noidung; ?></textarea>
                      </label>
                    <span class="textareaRequiredMsg" style="font-family:Arial, Helvetica, sans-serif">Phần thông tin bắt buộc.</span></span></td>
                  </tr>
                  <tr>
                    <td height="36" colspan="2" class="style1"><div align="center">
                      <label>
                      <input type="submit" name="submit" id="submit" value="    Gửi đi   " />
                      </label>
                    </div></td>
                  </tr>
                </table>
            </td>
        </tr>
    </table>
    
  </form>
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {validateOn:["blur"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
