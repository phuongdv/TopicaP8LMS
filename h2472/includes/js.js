var xmlhttp
/*@cc_on @*/
/*@if (@_jscript_version >= 5)
  try {
  xmlhttp=new ActiveXObject("Msxml2.XMLHTTP")
 } catch (e) {
  try {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")
  } catch (E) {
   xmlhttp=false
  }
 }
@else
 xmlhttp=false
@end @*/
if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 try {
  xmlhttp = new XMLHttpRequest();
 } catch (e) {
  xmlhttp=false
 }
}
function myXMLHttpRequest() {
  var xmlhttplocal;
  try {
    xmlhttplocal= new ActiveXObject("Msxml2.XMLHTTP")
 } catch (e) {
  try {
    xmlhttplocal= new ActiveXObject("Microsoft.XMLHTTP")
  } catch (E) {
    xmlhttplocal=false;
  }
 }

if (!xmlhttplocal && typeof XMLHttpRequest!='undefined') {
 try {
  var xmlhttplocal = new XMLHttpRequest();
 } catch (e) {
  var xmlhttplocal=false;
  alert('couldn\'t create xmlhttp object');
 }
}
return(xmlhttplocal);
}

// ajax call
function vote(link, id, voted) {
	//if (voted == 'voted') return false;
	var element = document.getElementById(id);
	var comment = document.getElementById("comments");
	comment.style.display = '';	
	comment.style.top = (element.offsetTop + 22) + 'px';
	var postcomment = document.getElementById("postcomment");
	var ctext = document.getElementById("comment");
	ctext.value = '';
	var cbutton = document.getElementById("cancelcomment");
	cbutton.onclick = function(){comment.style.display = 'none'}
	postcomment.onclick = function() {
		if(trimAll(ctext.value) == '') {
			alert('Please post your comments');
			return false;
		}
		var params = "comment=" + ctext.value;
		element.innerHTML = '<div style="height: 20px;"><em>Loading ...</em></div>';	
		xmlhttp.open('POST', 'rpc.php?'+ link.getAttribute('href'));
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.setRequestHeader("Content-length", params.length);
		xmlhttp.setRequestHeader("Connection", "close");

		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4){
				if (xmlhttp.status == 200){
					var response = xmlhttp.responseText;
					element.innerHTML = xmlhttp.responseText;
					comment.style.display = 'none';
				}
			}
		};
		
		xmlhttp.send(params);	
	}
	return false;
}

function trimAll( strValue ) {

 var objRegExp = /^(\s*)$/;

    //check for all spaces
    if(objRegExp.test(strValue)) {
       strValue = strValue.replace(objRegExp, '');
       if( strValue.length == 0)
          return strValue;
    }

   //check for leading & trailing spaces
   objRegExp = /^(\s*)([\W\w]*)(\b\s*$)/;
   if(objRegExp.test(strValue)) {
       //remove leading and trailing whitespace characters
       strValue = strValue.replace(objRegExp, '$2');
    }
  return strValue;
}

