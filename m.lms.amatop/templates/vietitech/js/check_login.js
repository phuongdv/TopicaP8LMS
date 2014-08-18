// JavaScript Document
function checkLogin() {
	var frm = document.frmLogin;
	if(frm.username.value == "" || frm.password.value == "")
		return false;
	else {	
		frm.doLogin.value = "signin";
		frm.submit();
		return true;
	}
}
