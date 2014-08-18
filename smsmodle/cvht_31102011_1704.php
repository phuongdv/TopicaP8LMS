<?php

$content = $_POST['TextField']; // Noi dung
$frmcourse = $_POST['frmcourse']; // Noi dung
$c_id = intval($_GET['c_id']); // Course ID
$CharsTyped = intval($_POST['CharsTyped']); // So ky tu
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
	//xoa dau .
	$str_find3 = ".";
	$str_find_replace3="";
	$mobile = str_replace($str_find3,$str_find_replace3,$mobile);
	
	return $mobile;
	
}

function checkRoleID($userid){
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	
	$mysqli->select_db($CFG->dbname);

	$mysqli->query("SET NAMES 'utf8'");
	
	$sqlRole="SELECT DISTINCT r.id roleid
		FROM mdl_user u
		INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
		INNER JOIN mdl_context ct ON ct.id = ra.contextid
		INNER JOIN mdl_course c ON c.id = ct.instanceid
		INNER JOIN mdl_role r ON r.id = ra.roleid
		INNER JOIN mdl_course_categories cc ON cc.id = c.category
		
		WHERE u.id =$userid
		limit 0,1";
	
	$OneRole = $mysqli->query($sqlRole);
	
	if (mysqli_num_rows($OneRole) > 0){
			while($vv = $OneRole->fetch_assoc()) 
				{
					$roleid=$vv['roleid'];	
										
				}
		return $roleid;			
	}
	else {
		return 0;	
	}
	//
	$OneCourse->close();
	$mysqli->close();
	
	
	
}

function getNameCourse($c_id){
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	
	$mysqli->select_db($CFG->dbname);

	$mysqli->query("SET NAMES 'utf8'");
	
	$sqlCourse="select fullname from mdl_course where id=$c_id";
	
	$OneCourse = $mysqli->query($sqlCourse);
	if (mysqli_num_rows($OneCourse) > 0){
			while($vv = $OneCourse->fetch_assoc()) 
				{
					$fullname=$vv['fullname'];	
										
				}
		return $fullname;			
	}
	else {
		return $c_id;	
	}
	//
	$OneCourse->close();
	$mysqli->close();
	
	
	
}

// Get SMS INFO ID
function getSMS_INFO_ID(){
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	
	$mysqli->select_db($CFG->dbname);

	$mysqli->query("SET NAMES 'utf8'");
	
	$sqlSMSINFO="select sms_info_id from sms_info where usercreat=2740 and reg_date=1320054312";
	
	$OneSMSINFO = $mysqli->query($sqlSMSINFO);
	if (mysqli_num_rows($OneSMSINFO) > 0){
			while($vv = $OneSMSINFO->fetch_assoc()) 
				{
					$sms_info_id=$vv['sms_info_id'];	
										
				}
		return $sms_info_id;			
	}
	else {
		return 0;	
	}
	//
	$OneSMSINFO->close();
	$mysqli->close();
	
	
	
}


//
function checkCID($c_id,$userid){
	global $CFG;
	$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	
	$mysqli->select_db($CFG->dbname);

	$mysqli->query("SET NAMES 'utf8'");
	
	$sqlRole="SELECT  DISTINCT c.fullname
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category

WHERE u.id ='".$userid."' AND c.id='".$c_id."' AND c.visible=1";
	
	$OneRole = $mysqli->query($sqlRole);
	
	if (mysqli_num_rows($OneRole) > 0){
			while($vv = $OneRole->fetch_assoc()) 
				{
					return 1;	
										
				}
		return $roleid;			
	}
	else {
		return 0;	
	}
	//
	$OneCourse->close();
	$mysqli->close();
	
	
}

//check login
require_login();

$userid= $USER->id;

$roleid=checkRoleID($userid);

//check roleid
if($roleid!=3)  header("Location: http://elearning.hou.topica.vn/");


print_header("$site->shortname: ",'<a href="cvht.php">'. "$stradministration</a>->Tai khoan");

$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
		
$mysqli->select_db($CFG->dbname);

$mysqli->query("SET NAMES 'utf8'");

if($content==''){	
//
	if($c_id==''){
		
		
		$sqllistClass1 ="SELECT  DISTINCT u.topica_lop
		FROM mdl_user u
		INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
		INNER JOIN mdl_context ct ON ct.id = ra.contextid 
		INNER JOIN mdl_course c ON c.id = ct.instanceid
		INNER JOIN mdl_role r ON r.id = ra.roleid 
		INNER JOIN mdl_course_categories cc ON cc.id = c.category 
		WHERE c.id IN
		(SELECT  DISTINCT c.id
		FROM mdl_user u
		INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
		INNER JOIN mdl_context ct ON ct.id = ra.contextid 
		INNER JOIN mdl_course c ON c.id = ct.instanceid
		INNER JOIN mdl_role r ON r.id = ra.roleid 
		INNER JOIN mdl_course_categories cc ON cc.id = c.category 
		WHERE u.id='".$userid."' AND c.visible=1 AND c.id<>238 AND c.fullname NOT LIKE '%mẫu%')
		AND r.id=5
		AND u.topica_lop<>'' 
		AND u.topica_lop not like '%PM%' 
		AND u.topica_lop not like '%bảo%' 
		AND u.topica_lop not like '%Bao_luu%' 
		AND u.topica_lop not like '%chua_xac_dinh%' 
		AND u.topica_lop not like '%Da_nghi_hoc%'
		AND u.topica_lop not like '%hoc%'
		";
		//print_r($sqllistClass1);
		//$arrCourse = $mysqli->query($sqlarrCourse);
	}
	else{
		
		
		$sqllistClass1="SELECT  DISTINCT u.topica_lop
		FROM mdl_user u
		INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
		INNER JOIN mdl_context ct ON ct.id = ra.contextid
		INNER JOIN mdl_course c ON c.id = ct.instanceid
		INNER JOIN mdl_role r ON r.id = ra.roleid
		INNER JOIN mdl_course_categories cc ON cc.id = c.category
		
		WHERE c.id='".$c_id."' AND r.id=5 AND c.visible=1 AND c.id<>238";
		
	}
	$arrlistClass1 = $mysqli->query($sqllistClass1);
/**/
	
	
	
	
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
     
<form name="theForm" action="cvht.php" method="post">
<table cellpadding="5" cellspacing="0" width="600px" border="0" class="girdtable" align="center">

	<tr>
    	<td class="gridrow1" style="padding-left:10px;padding-top:15px;">Chọn lớp :
        </td>
   	</tr>
    <tr>
    	<td>
        <?php
			if($c_id==''){
				echo '<select style="width: 200px;"  name="frmcourse">';
			   
				if (mysqli_num_rows($arrlistClass1) > 0){
				while($vv = $arrlistClass1->fetch_assoc()) 
					{
						
						echo '<option value="'.$vv['topica_lop'].'">'.$vv['topica_lop'].'</option>';
					}
				}
				echo '</select>';
			}
			
   
	?>
    	
     	</td>
    </tr>
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
	//$arrCourse->close();
	$arrlistClass1->close();
	$mysqli->close();
	
}
else {
		$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	
		$mysqli->select_db($CFG->dbname);
		
		$mysqli->query("SET NAMES 'utf8'");
		if($frmcourse!=''){
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
					u.topica_lop='$frmcourse'
					order by firstname asc  limit 0,500
					";
					
				$ad = $mysqli->query($sql);
			
		}
		//print_r($sql);
			
			
			
			//Ghi file
			$fp=fopen("txt/".$date."sms.txt",w)or exit("khong tim thay file can mo");

			$contentfile = $content."\r\n";
			
			if (mysqli_num_rows($ad) > 0){
			while($dd = $ad->fetch_assoc()) 
				{
					if($dd['topica_dienthoai']!='')
					$soDT = formatMobile($dd['topica_dienthoai']);
					$contentfile= $contentfile.$soDT."\r\n";
					
				}
			}
			
			fwrite($fp,$contentfile);
			
			fclose($fp);
			
			//end file
			
			//
				$sqlcount_send="
					SELECT DISTINCT u.topica_dienthoai, u.id
					FROM mdl_user u
					INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
					INNER JOIN mdl_context ct ON ct.id = ra.contextid
					INNER JOIN mdl_course c ON c.id = ct.instanceid
					INNER JOIN mdl_role r ON r.id = ra.roleid
					INNER JOIN mdl_course_categories cc ON cc.id = c.category				
					WHERE r.id =5
					AND
					u.topica_lop='$frmcourse' AND u.topica_dienthoai <>''
					order by firstname asc  limit 0,500
				";
				
				$qcount_send=$mysqli->query($sqlcount_send);
				$count_send = mysqli_num_rows($qcount_send);
				//echo $count_send;die();
			//
				$sqlcount_errormobile="
					SELECT DISTINCT u.topica_dienthoai
					FROM mdl_user u
					INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
					INNER JOIN mdl_context ct ON ct.id = ra.contextid
					INNER JOIN mdl_course c ON c.id = ct.instanceid
					INNER JOIN mdl_role r ON r.id = ra.roleid
					INNER JOIN mdl_course_categories cc ON cc.id = c.category				
					WHERE r.id =5
					AND
					u.topica_lop='$frmcourse' AND u.topica_dienthoai =''
					order by firstname asc  limit 0,500
				";
				
				$qcount_errormobile=$mysqli->query($sqlcount_errormobile);	
				$count_errormobile = mysqli_num_rows($qcount_errormobile);
			//Insert SMS INFO
				
				$sqlsmsinfo = "
					INSERT INTO sms_info (content, so_ky_tu, usercreat,count_send,count_errormobile,topica_lop,course_id,reg_date)
					VALUES ('$content', '$CharsTyped', '$userid', '$count_send', '$count_errormobile', '$frmcourse', '$c_id', '$date') 
				";
				$smsinfo = $mysqli->query($sqlsmsinfo);
				
			//
			//GET SMS INFO ID
			//echo "da den";
			/*$sms_info_id=getSMS_INFO_ID();
			print_r($sms_info_id);die();*/
			
			//Insert SMS SEND
			/*if (mysqli_num_rows($qcount_send) > 0){
				while($cc = $qcount_send->fetch_assoc()) 
					{
						$useridin=$cc["id"];
						$sqlsmssend = "
							INSERT INTO sms_send (sms_info_id, userid, reg_date)
							VALUES ($sms_info_id, $useridin, $date) 
						";
						$smssend = $mysqli->query($sqlsmssend);
						$smssend->close();
											
					}
			}*/
				
			//Tong 
			$SumNeedSend=$count_send+$count_errormobile;
			
	echo "Có tổng số ".$count_send."/".$SumNeedSend." tin nhắn đã được gửi đến lớp : ".$frmcourse."";
	$qcount_send->close();
	$qcount_errormobile->close();
	$ad->close();
	$smsinfo->close();
	$mysqli->close();
}


echo '<br> <a href="index.php">Quay lại</a>';

print_footer($site);

?>