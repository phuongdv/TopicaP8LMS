<? 
class GuestOrder extends DbBasic {
	
	function GuestOrder() {
		$this->pkey = "order_id";
		$this->tbl = "guest_order";
	}
	
	function checkContentExist($product_id=0, $fullname='', $address='', $mobile='') {
		$arrListOneRecordExists = $this->getAll("product_id='".$product_id."' and fullname='".$fullname."' and address='".$address."' and mobile='".$mobile."'");
		
		if(is_array($arrListOneRecordExists) && count($arrListOneRecordExists)>0) return true;
		else
			return false;
	}
	
	function sendMail($to, $content="") {
		$is_send = 0;
		$subject = 'Thông báo từ http://www.chesach.com';
		$from = "chehuongtra@chesach.com";	
		$message = '<table cellpadding="0" cellspacing="0" border="1" width="100%" style="border:1px solid #ccc">
						<tr>
							<td width="25%" height="80px" align="center">
								<font style="font-family:Arial; font-size:16px; color:#0000FF; font-weight:bold; font-style:bold;">chesach.com</font>
							</td>
							<td align="center" valign="middle"><font style="font-family:Tahoma; font-size:31px; color:#0000FF; font-weight:bold; font-style:italic">THÔNG TIN ĐƠN HÀNG</font></td>
						</tr>
					</table>'; 
		$message .= "<br><b><i>Bạn nhận được một đơn hàng từ website chesach.com</i></b> "; 
		$message .= "<br>Dưới đây là thông tin chi tiết của đơn hàng.";	
		$message .= "<br> ".$content;						
		$message .= "<br>=======================================================================
					<br>Phòng Thương Mại Điện tử - Tổng công ty chè sạch Việt Nam
					<br>ĐT: (84-4) 22452929/ 098 76 77 168
					<br>Fax: (84-4) 22452929
					<br>Email: chehuongtra@chesach.com
					";			
		$headers = 	"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=utf-8\r\n".
					"From:  <".$from.">\r\n".
					"To:  <".$to.">\r\n".
					"Subject: ".$subject."\r\n";
		if($to != "")
			$is_send = (@mail($to, $subject, $message, $headers))? 1 : 0;
		
		return $is_send;
	}
	
	function htmlDecode($var){
		if (is_array($var)){
			foreach ($var as $k => $v){
				$var[$k] = $this->htmlDecode($v);
			}
		}else{
			$var = html_entity_decode($var);
		}
		return $var;
	}	
}
?>