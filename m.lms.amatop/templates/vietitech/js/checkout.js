function checkOut(){
	// Check email
	var regMail = /^([a-zA-Z0-9_\-])+(\.([a-zA-Z0-9_\-])+)*@((\[(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5]))\]))|((([a-zA-Z0-9])+(([\-])+([a-zA-Z0-9])+)*\.)+([a-zA-Z])+(([\-])+([a-zA-Z0-9])+)*))$/;
	// Check telephone
	var regPhone = /^[0-9]{2,3}-?|.? ?[0-9]{6,7}$/;
	
	fname = document.frm_checkout;
	
	if(fname.fullname.value == ""){
		alert('Xin vui lòng nhập vào họ tên của bạn !');
		fname.fullname.focus();
		return false;
	}
	if(fname.address.value == ""){
		alert('Xin vui lòng nhập vào địa chỉ liên hệ !');
		fname.address.focus();
		return false;
	}
	if(fname.phone.value == ""){
		alert('Xin vui lòng nhập vào số điện thoại !');
		fname.phone.focus();
		return false;
	}
	if(regPhone.test(fname.phone.value)==false){
		alert('Số điện thoại của bạn không hợp lệ !');
		fname.phone.focus();
		return false;
	}
	if(regMail.test(fname.email.value)==false || fname.email.value == ""){
		alert('Địa chỉ Email của bạn không hợp lệ !');
		fname.email.focus();
		return false;
	}
	
	fname.agree.value = 'agree';
	fname.submit();
	return true;
}