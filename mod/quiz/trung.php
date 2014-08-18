<?php
require_once("../../config.php");
require_once("libs_trung.php");
require_once("function.php");
//check login
require_login();
//get user_id
$uid= $USER->id;
$user=$USER->username;
$qid=0;
if(isset($_GET['qid'])==true){
	$qid=$_GET['qid'];
}

$sql="SELECT * FROM tbl_quiz_html WHERE quizid='$qid' ORDER BY RAND() LIMIT 0,1";
$result=mysql_query($sql);
if(mysql_num_rows($result)<=0){
	echo "Mã đề không đúng, đề nghị kiểm tra và thử lại!";
	die();
}
$rows=mysql_fetch_array($result);

/*--------------------- add by vietth -----------------------------------
# lay them thong tin cho quiz
@title : ten bai quiz
@mota  : mota quiz 
-----------------------------------------------------------------------*/

$sql_quiz_extra_info 	=	"SELECT * FROM mdl_quiz where id = $qid ";
$result_quiz_info		=	mysql_query($sql_quiz_extra_info);
if(mysql_num_rows($result_quiz_info)==0){
		echo "Mã đề không đúng, đề nghị kiểm tra và thử lại!";
	    die();
}

$quiz_info				=  mysql_fetch_assoc($result_quiz_info);
$now = time();

if($now < $quiz_info['timeopen'] or $now > $quiz_info ['timeclose']){
		echo "<h3 style='color:red; text-align:center;'>Bài chưa mở hoặc đã đóng <br> Thời gian mở : ".date('h:i:s d-m-Y',$quiz_info['timeopen'])." <br> Thời gian đóng : ".date('h:i:s d-m-Y',$quiz_info['timeclose'])."</h3>";
		echo '<div align="center"><input type="button" value = " Đóng " onclick = "window.close()" ></div>';
	die();
}



$question_file=$rows["url_file"];
$num_question=$rows["number_question"];
$time_question=$rows["times"];
$course_id=$rows["course_id"];
$answer=$rows["answers"];
$quest=$rows["quest_ids"];

/*------------------------Check number test-----------------------------*/
$sql="SELECT id FROM tbl_user_answer_quiz WHERE user_id='$uid' AND quiz_id='$qid'";
//echo $sql;
$result=mysql_query($sql);
if($quiz_info['attempts']!=0)
{
if(mysql_num_rows($result)>=$quiz_info ['attempts']){
	echo "<h3 style='color:red; text-align:center;'>Bạn đã làm bài thi ".$quiz_info ['attempts']." lần. Bạn không có quyền tiếp tục làm bài. Liên hệ với ban quản trị để tiếp tục!</h3><a href='http://elearning.hou.topica.vn/course/view.php?id=$course_id' style='text-align:center;'>Quay lại lớp học</a>";
	die();
}
}
/*--- Check lan lam bai --*/
$sql_numberplay="Select count(id) from tbl_user_answer_quiz WHERE user_id='$uid' AND quiz_id='$qid'";
$result_numberplay=mysql_query($sql_numberplay);
$numberplay=mysql_fetch_array($result_numberplay);

/*-----------------------------------------------------------*/
$answer_id = $rows["id"];
// zend code cho vào database
$key=genRandomString(5);
$date=date("Y-m-d h:i:s");

// Insert
$sql_insert="INSERT INTO tbl_user_answer_quiz(`user_id`,`static_id`,`quiz_id`,`key`,`join_date`) VALUES ('$uid','$answer_id','$qid','$key','$date')";
mysql_query($sql_insert);
$ans_id = mysql_insert_id();



$sql_course="select fullname from mdl_course where id='$course_id'";
$result_course=mysql_query($sql_course);
$rows_course=mysql_fetch_array($result_course);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Q168 - TOPICA</title>
<link href="css.css" type="text/css" rel="stylesheet" />
<script language="">
var _answer="<?php echo $answer;?>";
var _key="<?php echo $key;?>";
var _quests="<?php echo $quest;?>";
</script>
<script language="javascript" src="trung_js.js" ></script>
<script language="javascript" src="encode.js" ></script>
<script language="javascript">
/*
var OnTest=true;
window.onbeforeunload =function(){
   if(check_time==false)
		return true;
   //return  confirm('Không được Refresh hoặc đóng bài test của bạn.\n OK để lưu Bài thi và thoát. cancel để tiếp tục làm bài?');

   if (OnTest){
         return  confirm('Không được Refresh hoặc đóng bài test của bạn.\n OK để lưu Bài thi và thoát. cancel để tiếp tục làm bài?');      
      }
   }
 */
</script>
</head>
<body onLoad="genCode(<?php echo $id?>);"  >
	<div id="wapper" align="center">
    	<div id="title">
        	<div style="width:960px"><h1><?php echo $rows['name'];?></h1></div>
            <div style="width:960px; border:solid 1px #790000; height:28px;float:left; text-align:left; ">
            	<div  class="title_top"><a href="http://elearning.hou.topica.vn/">HOU E-Learning</a><span class="arrow_sep">►</span><a href="http://elearning.hou.topica.vn/course/view.php?id=<?php echo $course_id;?>"><?php echo $rows_course['fullname']; ?></a></div>
                <div style="width:550px;float:left; padding-top:6px;"><span id="status">Đang kết nối internet</span></div>
            </div>
            <div style="width:960px" align="left"><span class="title_top"><a href="http://ccms.topica.vn/mycc.php"  target="_blank" >GÓP Ý</a><br>
           
            </span>
            
            </div>
            
             </div>
    	<div id="left">
    	<div >
    	 <?php
             echo $quiz_info['intro'];
             ?>
        </div>
		<form method="post" action="" name="frm">
        	<h2>Bài làm - Lần làm bài số : <b style="color:#FF0000"><? echo $numberplay['count(id)']+1; ?></b> </h2> 
			Chọn phương án đúng nhất cho các câu sau<br>
            <div style="text-align:left; padding:7px;">
			<?php
				include_once($question_file);
			?>
			</div>
			<input type="hidden" name="txt_ansid" id="txt_ansid" value="<?php echo $ans_id;?>"/>
			<input type="hidden" name="txt_id" id="txt_id" value="<?php echo $answer_id;?>"/>
			<input type="hidden" name="txt_qid" id="txt_qid" value="<?php echo $qid;?>"/>
			<input type="hidden" name="txt_key" id="txt_key" value="<?php echo $key;?>"/>
			<input type="hidden" name="txt_user" id="txt_user" value="<?php echo $user;?>"/>
			<input type="hidden" name="result_answer" id="result_answer" value=""/>
			<input type="button" value="Nộp bài" onClick="submitExam();" /><br>
            <hr  width="90%" color="#0000FF" />
            <div id="result">
				<table width="100%">
					<tr>
                    	<td >
                        <div id="clock"> 
                Thời gian làm bài còn : <span id="time"><?php echo $time_question;?></span>&nbsp;&nbsp;&nbsp;<span id="time2"></span>
                </div>
                <div id="note"> 
                <span style="color:#FF0000"><b>Chú ý</b></span>: <br>Trong trường hợp ngừng kết nối internet, đề nghị anh chị học viên vẫn tiếp tục làm bài và nộp bài bình thường. Khi ấn nộp bài xong, anh chị (ấn CtrlA) và (ấn CtrlC) copy hết đoạn mã kiểm tra bên dưới gửi mail cho CVHT lớp mình để xác nhận điểm bài làm </div>
						</td>
                     </tr>
                     <tr>
                    	<td>
							<div id="ketqua">Kết quả : <span id="_result"></span></div>
                			<div id="ketqua">Điểm : <span id="mark"></span></div>
							
						</td>
                    </tr>
                    <tr>
                    	<td>
                        	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                	<td colspan="2"></td>
                                </tr>
                                <tr>
                                	<td  valign="middle" style="padding-left:10px;" width="20%">Mã kiểm tra</td>
                                    <td align="left"><div id="ketqua"><textarea id="code_result_text"  style="width:80%"  rows="2"></textarea></div></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    	<td height="50"></td>
                    </tr>
				</table>
            </div>
		</form>
        </div>
    </div>
</body>
</html>