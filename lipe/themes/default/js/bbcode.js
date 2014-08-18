function log_out()
{
	ht = document.getElementsByTagName("html");
	ht[0].style.filter = "progid:DXImageTransform.Microsoft.BasicImage(grayscale=1)";
	if (confirm('Are you sure ?'))
	{
		return true;
	}
	else
	{
		ht[0].style.filter = "";
		return false;
	}
}

function smilie(thesmilie) {
// inserts smilie text
	ajtTexte(" "+thesmilie+" ", "content");
	//document.fAddTopic.content.value += thesmilie+" ";
	//document.fAddTopic.content.focus();
}

function ajtTexte(txt,id)
{

var obj = document.getElementById(id), sel;
 obj.focus();
 if(document.selection && document.selection.createRange){
 sel = document.selection.createRange();
 if (sel.parentElement()==obj)//si sel est dans obj
sel.text = sel.text+txt;
 }

else if(String(typeof obj.selectionStart)!="undefined"){
sel = obj.selectionStart;
obj.value = (obj.value).substring(0,sel) +
          txt +
(obj.value).substring(sel,obj.value.length);
}
else obj.value+=txt;
 obj.focus();
}

function ajtBBCode(Tag, fTag, id)
{
var obj = document.getElementById(id), sel;
 obj.focus();
 if (document.selection && document.selection.createRange){//if ie
   sel = document.selection.createRange();
   if (sel.parentElement()==obj)//si sel est dans obj
sel.text = Tag+sel.text+fTag;
 }
 else if(String(typeof obj.selectionStart)!="undefined"){
 
   var longueur= parseInt(obj.textLength);
   var selStart = obj.selectionStart;
   var selEnd = obj.selectionEnd;
   if (selEnd == 2 || selEnd == 1)selEnd = longueur;

   obj.value = (obj.value).substring(0,selStart) +
              Tag +
    (obj.value).substring(selStart,selEnd) +
                 fTag +
  (obj.value).substring(selEnd,longueur);
 }
else obj.value+=Tag+fTag;
obj.focus();
}

//----------------------------------------------------
//	CTT code
//----------------------------------------------------
var imageTag = false;
var theSelection = false;

htext_text	= "Hướng dẫn: Di chuột vào các tag để xem hướng dẫn.";
b_text		= "Chữ in đậm: [B]văn bản[/B]  (alt+b). Hoặc bôi đen đoạn văn bản trước khi ấn.";
i_text		= "Chữ in nghiêng: [I]văn bản[/I]  (alt+i). Hoặc bôi đen đoạn văn bản trước khi ấn.";
u_text		= "Chữ gạch dưới: [U]văn bản[/U]  (alt+u). Hoặc bôi đen đoạn văn bản trước khi ấn.";
php_text	= "PHP code: [PHP]văn bản[/PHP]  Hoặc bôi đen đoạn văn bản trước khi ấn.";
code_text	= "CODE: [CODE]văn bản[/CODE]  Hoặc bôi đen đoạn văn bản trước khi ấn.";
http_text	= "Link: [URL=đườngdẫn]tiêu đề[/URL]. Nhập đường dẫn và nội dung.";
img_text	= "Ảnh: [IMG]đường dẫn[/IMG]. Nhập đường dẫn đến ảnh.";
quote_text	= "Trích dẫn: [QUOTE]văn bản[/QUOTE]. Hoặc bôi đen đoạn văn bản trước khi ấn.";
font_text	= "Font chữ: [FONT=font]văn bản[/FONT]. Hoặc bôi đen đoạn văn bản trước khi ấn.";
size_text	= "Cỡ chữ: [SIZE=size]văn bản[/SIZE]. Hoặc bôi đen đoạn văn bản trước khi ấn.";
color_text	= "Màu chữ: [COLOR=color]văn bản[/COLOR]. Hoặc bôi đen đoạn văn bản trước khi ấn.";

function helptext(help) {
	document.forms[0].helpbox.value = eval(help + "_text");
}
//-------------------------------------------------------------
//-------------------------------------------------------------
function getarraysize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}
//-------------------------------------------------------------
//-------------------------------------------------------------
function arraypush(thearray,value) {
	thearray[ getarraysize(thearray) ] = value;
}
//-------------------------------------------------------------
//-------------------------------------------------------------
function arraypop(thearray) {
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}

//-------------------------------------------------------------
//-------------------------------------------------------------
zcode = new Array();
ztags = new Array('[B]','[/B]','[I]','[/I]','[U]','[/U]','[PHP]','[/PHP]','[QUOTE]','[/QUOTE]','[CODE]','[/CODE]');


function bbstyle(bbnumber) {

	donotinsert = false;
	theSelection = false;
	ztes = 0;

	if (bbnumber == -1) {
		while (zcode[0]) {
			butnumber = arraypop(zcode) - 1;
			document.fAddTopic.content.value += ztags[butnumber + 1];
			buttext = eval('document.fAddTopic.addcode' + butnumber + '.value');
			eval('document.fAddTopic.addcode' + butnumber + '.value ="['+buttext.substr(2,(buttext.length - 3))+']"');
		}
		document.fAddTopic.content.focus();
		return;
	}

	theSelection = document.selection.createRange().text;
	if (theSelection) {
		document.selection.createRange().text = ztags[bbnumber] + theSelection + ztags[bbnumber+1];
		document.fAddTopic.content.focus();
		theSelection = '';
		return;
	}

	for (i = 0; i < zcode.length; i++) {
		if (zcode[i] == bbnumber+1) {
			ztes = i;
			donotinsert = true;
		}
	}

	if (donotinsert) {
		while (zcode[ztes]) {
				butnumber = arraypop(zcode) - 1;
				document.fAddTopic.content.value += ztags[butnumber + 1];
				buttext = eval('document.fAddTopic.addcode' + butnumber + '.value');
				eval('document.fAddTopic.addcode' + butnumber + '.value ="['+buttext.substr(2,(buttext.length - 3))+']"');
			}
			document.fAddTopic.content.focus();
			return;
	} else {

		if (bbnumber <= 10) {
		document.fAddTopic.content.value += ztags[bbnumber];
		arraypush(zcode,bbnumber+1);
		buttext = eval('document.fAddTopic.addcode' + bbnumber + '.value');
		eval('document.fAddTopic.addcode'+bbnumber+'.value = "[/'+buttext.substr(1,(buttext.length - 2))+']"');
		} 
		document.fAddTopic.content.focus();
		return;
	}
	storeCaret(document.fAddTopic.content);
}
//-------------------------------------------------------------
//-------------------------------------------------------------
function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}
//-------------------------------------------------------------
//-------------------------------------------------------------
function tag_url()
{
	var url;
	var title;
    url	= prompt('Nhập đường dẫn:','http://');
	if(!url)
	{
		alert("Bạn phải nhập đường đẫn cho link");
		return false;
	}
	title= prompt('Nhập tiêu đề','Click here');
	if(!title)
	{
		alert("Bạn phải nhập tiều đề cho link");
		return false;
	}
	ajtTexte(" [URL="+url+"]"+title+"[/URL] ", "content");

	//document.fAddTopic.content.value += '[URL='+url+']'+title+'[/URL]';	
	//document.fAddTopic.content.focus();	
	return;
}
//-------------------------------------------------------------
//-------------------------------------------------------------
function tag_img()
{
	var url;
    url	= prompt('Nhập đường dẫn:','http://');
	if(!url)
	{
		alert("Bạn phải nhập đường đẫn cho ảnh");
		return false;
	}
	ajtTexte(' [IMG]'+url+'[/IMG] ', "content");
	//document.fAddTopic.content.value += '[IMG]'+url+'[/IMG]';	
	//document.fAddTopic.content.focus();	
	return;
}
//-------------------------------------------------------------
//-------------------------------------------------------------
function alterfont(font, type)
{
	theSelection = document.selection.createRange().text;
	if (theSelection) {
		document.selection.createRange().text = '[' + type + '=' + font + ']' + theSelection + '[/' + type + ']';
		document.fAddTopic.content.focus();
		theSelection = '';
		return;
	}else{
		document.fAddTopic.content.value	+= '[' + type +'=' + font + ']';
		document.fAddTopic.content.focus();
		return;
	}
}

