<?php

$content = $_POST['TextField']; // Noi dung
$c_id = intval($_GET['c_id']); // Course ID
$date = time();
//	$ten = intval($_GET['so']);

require_once('../config.php');

function formatMobile($mobile){
	// xoa khoang trang hai dau
	$mobile = trim($mobile);
	// xoa khoang trang trong chuoi
	$str_find1 = " ";
	$str_find_replace1="";
	$mobile = str_replace($str_find1,$str_find_replace1,$mobile);
	//lay 11 ky tu
	$mobile = substr($mobile, 0, 11); 
	//xoa ky tu khong phai so
	$str_find2 = "/";
	$str_find_replace2="";
	$mobile = str_replace($str_find2,$str_find_replace2,$mobile);
	
	return $mobile;
	
}

require_login();
if(!isadmin()) header("Location: http://elearning.hou.topica.vn/ ");
print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");

if($content==''){
	
	
	//$ad = $mysqli->query("select * from sms_info where sms_info_id=1 limit 0,1 ");
	//print_r($ad);die();
	
	
	
	
?>
<SCRIPT LANGUAGE="JavaScript">
	/*
	Created by: Will Bontrager 
	Web Site: http://willmaster.com/
*/


/* For additional information about this JavaScript
and how to use it, see the "Displaying Number of Words
Typed Into Form Fields" article, linked from the archives
at from http://willmaster.com/possibilities/archives/
The above note and the copyright line must remain with
this JavaScript source code. Comments below this point
in the code may be removed if desired.
*/
// Customizing this JavaScript code requires specifying eight values.

// Value One:
// Specify the maximum number of characters the form field
// may contain. If you have no maximum, specify 0 (zero).

var MaximumCharacters = "320";

// Value Two:
// Specify the maximum number of words the form field may
// contain. If you have no maximum, specify 0 (zero).

var MaximumWords = "100";

// Value Three:
// Specify the form's name (provided by the name="_____"
// attribute in the FORM tag).

var FormName = "theForm";

// Value Four:
// Specify the name of the text field being monitored
// (provided by the name="_____" attribute in the
// INPUT or TEXTARE tag).

var TextFieldName = "TextField";

// Value Five:
// Specify the field name where where is to be displayed
// the number of characters the user has typed. Make
// it blank (nothing between the quotation marks) if
// you aren't displaying the number of characters typed.

var CharactersTypedFieldName = "CharsTyped";

// Value Six:
// Specify the field name where where is to be displayed
// the number of characters left that may be typed.
// Make it blank (nothing between the quotation marks)
// if you aren't displaying the number of characters
// left.

var CharactersLeftFieldName = "CharsLeft";

// Value Seven:
// Specify the field name where where is to be displayed
// the number of words the user has typed. Make it
// blank (nothing between the quotation marks) if you
// aren't displaying the number of words typed.

var WordsTypedFieldName = "WordsTyped";

// Value Eight:
// Specify the field name where where is to be displayed
// the number of words left that may be typed. Make it
// blank (nothing between the quotation marks) if you
// aren't displaying the number of words left.

var WordsLeftFieldName = "WordsLeft";

//////////////////////////////////////////////////////
//                                                  //
//  No modfications are required below this point.  //
//                                                  //
//////////////////////////////////////////////////////

var WordsMonitor = 0;
var MaxWords = parseInt(MaximumWords);
var MaxChars = parseInt(MaximumCharacters);
var textfield = 'document.' + FormName + '.' + TextFieldName + '.value';

function WordLengthCheck(s,l) {
WordsMonitor = 0;
var f = false;
var ts = new String();
for(var vi = 0; vi < s.length; vi++) {
	vs = s.substr(vi,1);
	if((vs >= 'A' && vs <= 'Z') || (vs >= 'a' && vs <= 'z') || (vs >= '0' && vs <= '9')) {
		if(f == false)	{
			f = true;
			WordsMonitor++;
			if((l > 0) && (WordsMonitor > l)) {
				s = s.substring(0,ts.length);
				vi = s.length;
				WordsMonitor--;
				}
			}
		}
	else { f = false; }
	ts += vs;
	}
return s;
} // function WordLengthCheck()

function CharLengthCheck(s,l) {
if(s.length > l) { s = s.substring(0,l); }
return s;
} // function CharLengthCheck()

function InputCharacterLengthCheck() {
if(MaxChars <= 0) { return; }
var currentstring = new String();
eval('currentstring = ' + textfield);
var currentlength = currentstring.length;
eval('currentstring = CharLengthCheck(' + textfield + ',' + MaxChars + ')');
if(CharactersLeftFieldName.length > 0) {
	var left = 0;
	eval('left = ' + MaxChars + ' - ' + textfield + '.length');
	if(left < 0) { left = 0; }
	eval('document.' + FormName + '.' + CharactersLeftFieldName + '.value = ' + left);
	if(currentstring.length < currentlength) { eval(textfield + ' = currentstring.substring(0)'); }
	}
if(CharactersTypedFieldName.length > 0) {
	eval('document.' + FormName + '.' + CharactersTypedFieldName + '.value = ' + textfield + '.length');
	if(currentstring.length < currentlength) { eval(textfield + ' = currentstring.substring(0)'); }
	}
} // function InputCharacterLengthCheck()

function InputWordLengthCheck() {
if(MaxWords <= 0) { return; }
var currentstring = new String();
eval('currentstring = ' + textfield);
var currentlength = currentstring.length;
eval('currentstring = WordLengthCheck(' + textfield + ',' + MaxWords + ')');
if (WordsLeftFieldName.length > 0) {
	var left = MaxWords - WordsMonitor;
	if(left < 0) { left = 0; }
	eval('document.' + FormName + '.' + WordsLeftFieldName + '.value = ' + left);
	if(currentstring.length < currentlength) { eval(textfield + ' = currentstring.substring(0)'); }
	}
if (WordsTypedFieldName.length > 0) {
	eval('document.' + FormName + '.' + WordsTypedFieldName + '.value = ' + WordsMonitor);
	if(currentstring.length < currentlength) { eval(textfield + ' = currentstring.substring(0)'); }
	}
} // function InputWordLengthCheck()

function InputLengthCheck() {
InputCharacterLengthCheck();
InputWordLengthCheck();
} // function InputLengthCheck()


	 </script>
     
<form name="theForm" action="index.php?c_id=<?php echo $c_id; ?>" method="post">
<table cellpadding="5" cellspacing="0" width="600px" border="0" class="girdtable" align="center">
	<tr>
		<td class="gridrow1" style="padding-left:10px;padding-top:15px;">
			<b>Nội dung tin nhắn :</b><br />
           
		</td>
	</tr>
    <tr>
    	<td>
         <textarea  style="border:1px solid #A8C3D6;width:100%" rows="5" name="TextField" onBlur="InputLengthCheck();" onKeyUp="InputLengthCheck();" ></textarea>
        
        <br>
        Số ký tự : <input readonly type="text" name="CharsTyped" size="8" value=""> 
        <br>
        <input readonly type="hidden" name="CharsLeft" size="8"> 
        <br>
        <input readonly type="hidden" name="WordsTyped" size="8">
        <br>
        
        <input readonly type="hidden" name="WordsLeft" size="8"> 
        <br>
        &nbsp;&nbsp;&nbsp;<input type="submit" value="Gửi tin"  />
        <br>
        <br>
        <input type="hidden" id="hi_feed" name="hi_feed" value="hi_feed" /> 
        </td>
    </tr>
</table>
</form>
<?

	
}
else {
		$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	
		$mysqli->select_db($CFG->dbname);
	
		$mysqli->query("SET NAMES 'utf8'");
		if($c_id!=''){
				$sql="
				SELECT DISTINCT u.id,u.username,u.topica_lop,u.topica_nhom,u.lastname,u.topica_dienthoai,trim(u.firstname) firstname
					FROM mdl_user u
					INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
					INNER JOIN mdl_context ct ON ct.id = ra.contextid
					INNER JOIN mdl_course c ON c.id = ct.instanceid
					INNER JOIN mdl_role r ON r.id = ra.roleid
					INNER JOIN mdl_course_categories cc ON cc.id = c.category				
					WHERE r.id =5
					AND
					c.id=$c_id
					order by firstname asc  limit 0,500
					";
				$ad = $mysqli->query($sql);
				//print_r($sql); die();
		}
	
			//Ghi file
			$fp=fopen("txt/".$date."sms.txt",w)or exit("khong tim thay file can mo");

			$contentfile = $content."\r\n";
			
			
			/*if(is_array($arrUser) && count($arrUser)>0)
		 		foreach($arrUser as $k => $v)
			{
				if($v['topica_dienthoai']!='')
				$contentfile= $contentfile.$v['topica_dienthoai']."\r\n";
			}*/
			if (mysqli_num_rows($ad) > 0){
			while($dd = $ad->fetch_assoc()) 
				{
					if($dd['topica_dienthoai']!='')
					$soDT = formatMobile($dd['topica_dienthoai']);
					$contentfile= $contentfile.$soDT."\r\n";
					//print_r($contentfile);die();
				}
			}
			
			fwrite($fp,$contentfile);
			
			fclose($fp);
			
			//end file
	echo 'Tin nhắn đã được gửi';
	$ad->close();
	$mysqli->close();
}


echo '<br> <a href="index.php">Quay lại</a>';

print_footer($site);

?>