// JavaScript Document
$(function(){
	$('#btnSubmit').click(function(){	
		if($('#title').val()=="") {
			alert("Xin vui lòng nhập vào tiêu đề cần liên hệ.");
			$('#title').get(0).focus();
			return false;
		}
		if($('#fullname').val()=="") {
			alert("Xin vui lòng nhập vào tên người liên hệ.");
			$('#fullname').get(0).focus();
			return false;
		}
		if($('#address').val()=="") {
			alert("Xin vui lòng nhập vào địa chỉ người liên hệ.");
			$('#address').get(0).focus();
			return false;
		}
		if($('#email').val().search(/^([a-zA-Z0-9_\-])+(\.([a-zA-Z0-9_\-])+)*@((\[(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5]))\]))|((([a-zA-Z0-9])+(([\-])+([a-zA-Z0-9])+)*\.)+([a-zA-Z])+(([\-])+([a-zA-Z0-9])+)*))$/)==-1) {
			alert("Địa chỉ Email của bạn không đúng định dạng.");
			$('#email').get(0).focus();
			return false;
		}
		if($('#txtcontent').val()=="") {
			alert("Xin vui lòng nhập vào nội dung liên hệ.");
			$('#txtcontent').get(0).focus();
			return false;
		}
				
		$('#docontact').val('docontact');
		$('#frmFeedback')[0].submit();
		return true;
	});
});