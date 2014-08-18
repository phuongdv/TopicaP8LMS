$(function(){
	$('#btnUpdate').click(function(){
		if(confirm("Bạn thực sự muốn cập nhật giỏ hàng không?"))
		{
			document.frmViewcart.action= root_path + '/gio-hang.html';
			document.frmViewcart.mod.value='update';
			document.frmViewcart.submit();
			return true;
		}							   
	});		
	$('#btnCheckout').click(function(){
		if(confirm("Bạn thực sự muốn thanh toán đơn hàng này chứ?"))
		{
			document.frmViewcart.action= root_path + '/thanh-toan.html';
			document.frmViewcart.mod.value='checkout';
			document.frmViewcart.submit();
			return true;
		}							   
	});	
	$('#btnContinue').click(function(){
		document.frmViewcart.action= root_path + '/san-pham/0.html';
		document.frmViewcart.submit();
		return true;					   
	});	
});
