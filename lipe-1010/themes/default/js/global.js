// JavaScript Document
function gotoUrl(str){
	window.location.href = str;
}

function changeto(obj,strClass){
	if(strClass!=""){
		obj.className = strClass;		
	}
	obj.style.cursor = 'hand';
}

function dropCategory(obj){
	
	if(obj.className == "on"){
		obj.className = "off";
		document.frmTemp.objdrop.value = "";	
	}
	else{
		obj.className = "on";
		if(document.frmTemp.objdrop.value != ""){
			identity=document.getElementById(document.frmTemp.objdrop.value);
			identity.className = "off";
		}
		document.frmTemp.objdrop.value = obj.id;
	}
}


function winpopup(urlx,param,twidth,theight)
{
	var strurl= urlx + '?param=' + param;
	var tposx= (screen.width- twidth)/2
	var tposy= (screen.height- theight)/2;

	var newWin=window.open(strurl,"CatTien","toolbar=no,width="+ twidth+",height="+ theight+ ",directories=no,status=no,scrollbars=yes,resizable=no, menubar=no")
	newWin.moveTo(tposx,tposy);
	newWin.focus();
}

function submitSearch(field,e) {
	var frm = document.frmSearTour;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	
	if (keycode == 13) {
		if(frm.keyword.value == "") {
			alert("Please enter your keyword for search !");
			frm.keyword.focus();
			return false;
		}
		
		frm.action = '?mod=home&act=search&keyword='+frm.keyword.value;
		frm.submit();
		return true;
	}
	
}

function checkSearch() {
	var frm = document.frmSearTour;
	
	if(frm.keyword.value == "") {
		alert("Please enter your keyword for search !");
		frm.keyword.focus();
		retval = false;
		return false;
	}
	
	
	frm.action = '?mod=home&act=search&keyword='+frm.keyword.value;
	frm.submit();
	return true;
}

$(document).ready(function() {
	  $('#menu ul').hide();
	  $('#menu ul:first').show();
	  $('#menu li a').mouseover(function() {
		if($(this).next().is('ul') && $(this).next().is(':visible')) return false;
		if($(this).next().is('ul') && !$(this).next().is(':visible')) {$('#menu ul:visible').slideUp('normal');$(this).next().slideDown('normal');return false;}			
	  });
});

function validateForm() {
	var frm = document.frmCustomizeTrip;
	var regMail = /^([a-zA-Z0-9_\-])+(\.([a-zA-Z0-9_\-])+)*@((\[(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5])))\.(((([0-1])?([0-9])?[0-9])|(2[0-4][0-9])|(2[0-5][0-5]))\]))|((([a-zA-Z0-9])+(([\-])+([a-zA-Z0-9])+)*\.)+([a-zA-Z])+(([\-])+([a-zA-Z0-9])+)*))$/;
	
	if(frm.txtFirstName.value=="")
		{
			alert("Please enter your first name !");
			frm.txtFirstName.focus();
			return false;
		}
	if(frm.txtLastName.value=="")
		{
			alert("Please enter your last name !");
			frm.txtLastName.focus();
			return false;
		}
	if(regMail.test(frm.txtEmail.value)==false || frm.txtEmail.value == "") {
			alert("Your email is not valid !");
			frm.txtEmail.focus();
			return false;
	}
	
	if(frm.start_date.value.search(/\d\//)==-1)
		{
			alert("Your Date of anticipated travel is not valid !");
			frm.start_date.focus();
			return false;	
		}
	
	if(frm.start_date.value.search(/\d\//)==-1)
		{
			alert("Your Date of anticipated travel is not valid !");
			frm.start_date.focus();
			return false;	
		}
		
	frm.valid.value = 'valid';
	frm.submit();
	return true;
}

jQuery.extend({
setHomepage: function(url) {
 if (document.all) {
  document.body.style.behavior = 'url(#default#homepage)';
  document.body.setHomePage(url);
 }
 else if (window.sidebar) {
  if (window.netscape) {
   try {
    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
   }
   catch (e) {
    var strTemp = '';
    strTemp += "this action was aviod by your browser,";
    strTemp += "if you want to enable,please enter about:config in your address line,";
    strTemp += "and change the value of signed.applets.codebase_principal_support to true";
    alert(strTemp);
   }
  }
  var prefs = Components.classes['@mozilla.org/preferences-service;1']
      .getService(Components.interfaces.nsIPrefBranch);
  prefs.setCharPref('browser.startup.homepage', url);
 }
}
});