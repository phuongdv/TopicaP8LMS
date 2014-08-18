<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>
    <link rel="shortcut icon" href="http://elearning.hou.topica.vn/theme/topica/favicon.ico">


<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
<link rel="stylesheet" href="mobile_theme/topica.css" />
<link rel="stylesheet" href="css/global_bt30.css" media="all">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.countdown.js"></script>
        <script type="text/javascript" src="js/jquery.countdown-vi.js"></script>
<link rel="stylesheet" href="css/checknet.css" media="all" />
		<link rel="stylesheet" href="css/jquery.countdown.css" media="all" />
<script src="js/checknet-1.3.min.js"></script>
<link rel="stylesheet" href="css/mobile.css" />
<script>



    
	
  
</script>
</head>


<body>
<?php

require_once("../../config.php");
require_once("libs_trung.php");
//check logi
$uid  =  $_COOKIE["m_userid"];
if($uid=='')
{
echo '<script>Alert("Vui lòng đăng nhập")</script>';
die();
}
$qid=0;
if(isset($_GET['qid'])==true){
	$qid=$_GET['qid'];
}
// lay thong tin quiz 
	$sql_quiz_extra_info 	=	"SELECT * FROM mdl_quiz
	INNER JOIN mdl_course on mdl_course.id = mdl_quiz.course
	 where mdl_quiz.id = $qid";
	
	$result_quiz_info		=	mysql_query($sql_quiz_extra_info);
	$quiz_info				=  mysql_fetch_assoc($result_quiz_info);
if ($quiz_info['timeclose']!=0 && time()>$quiz_info['timeclose'])
 {
	header( 'Location: http://elearning.tvu.topica.vn/mod/bt30/bt30_mobile.php?q='.$qid ) ;
	die();
 }
if ($quiz_info['timeopen']!=0 && time()<$quiz_info['timeopen'])
 {
	header( 'Location: http://elearning.tvu.topica.vn/mod/bt30/bt30_mobile.php?q='.$qid ) ;
	die();
 }

// kiem tra xem , quiz nay, attemp cuoi cung la gì, co phai dang lam do hay khong
$sql = " select * from vietth_q169_attempts WHERE quiz = $qid and userid = $uid and deleted = 0 ORDER BY id desc limit 0,1";
$result=mysql_query($sql);
$last_attempt = mysql_fetch_assoc($result);
if($last_attempt['status']=='inprogress')
{
		 // thu tinh thoi gian con lai xem sao
		 // hard code 30phut = 60*30 s
		 // thoi gian con lai duoc tinh bang 30p-(hientai-start_time)
		 if($quiz_info['timelimit']==0)
		 {
		    $limit_time=0;
		 }
		 else
		 {
		 $start_time = strtotime($last_attempt['starttime']);
		 $current_time = time();	
		 $limit_time =max(1,($quiz_info['timelimit']*60)-($current_time-$start_time));
		 }

		 
         $attemptno  = $last_attempt['attempt'];
		 $attemptid  = $last_attempt['id'];
		 
		 if($limit_time ==1)
		 {
		   $finishtime = date('Y-m-d H:i:s');
		   $sql ="UPDATE vietth_q169_attempts set sumgrade='0',corrects='0',finishtime='$finishtime',status='disconnected' where id=$attemptid";
		   mysql_query($sql);
		 }
		 
		 // lay thong tin cua de cho lan lam nay
		 $id_de = $last_attempt['ma_de'];
		 $sql="SELECT * FROM vietth_q169_de WHERE id = $id_de";
		 $result=mysql_query($sql);
		 $rows=mysql_fetch_array($result);
		 $ma_de = $rows["id"];
		 $question_file=$rows["url_file"];
		 $answer=$rows["answers"];
		 $answer_encode =  encode($answer);
		 $quest_encode= encode($rows["quest_ids"]);
		 
}
else // neu khong co lan lam bai nao do. cho phep tao luot lam moi
{
         // tao de 
		$sql="SELECT * FROM vietth_q169_de WHERE quizid='$qid' ORDER BY RAND() LIMIT 0,1";
		
		$result=mysql_query($sql);
		if(mysql_num_rows($result)<=0){
			echo "Mã đề không đúng, đề nghị kiểm tra và thử lại!";
			die();
		  }
		// neu la bai lt thi bo qua
		if($quiz_info['attempts']>0)
		{
		
		$sql_count_status=" select qa.* from vietth_q169_attempts qa  where qa.userid = $uid  and qa.quiz =$qid and deleted = 0 ORDER BY qa.id asc"; 

		//echo $sql;
		  $result_count		=	mysql_query($sql_count_status);
		  while($attepmtcount = mysql_fetch_array($result_count)) 
				 {
				  if($attepmtcount['status']=='submited')
				   {
					$so_lan_lam_submited ++;   
				   }
				  if($attepmtcount['status']=='disconnected')
				   {
					$so_lan_lam_disconnected ++;
				   }
				 } 
		 if($so_lan_lam_submited >=$quiz_info['attempts'])
			 {
			  
			 echo '
			 		 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <div data-role="dialog">
	
		<div data-role="header" data-theme="d">
			<h1>Có lỗi xảy ra</h1>

		</div>

		<div data-role="content" data-theme="c">
		    <p>Bạn đã hết lượt làm bài !</p> 
			<a data-ajax="false" href="http://elearning.tvu.topica.vn/mod/bt30/bt30_mobile.php?q='.$qid.'" data-role="button"  data-theme="b">Quay trở lại</a>    
		</div>
	</div>
   
   ';
			  die();
			 } 
		 if($so_lan_lam_disconnected >= $quiz_info['disconnect'])
			 {
			 // header( 'Location: http://elearning.tvu.topica.vn/mod/bt30/bt30_mobile.php?qid='.$qid ) ;
			 die();
			 }
		
		}
			 
			 
		// kiem tra xem condu
		$rows=mysql_fetch_array($result);
		$ma_de = $rows["id"];
		$question_file=$rows["url_file"];
		$answer=$rows["answers"];
		$answer_encode =  encode($answer);
		$quest_encode= encode($rows["quest_ids"]);
		// get attempt
		$sql = "select max(attempt) maxattempt,count(*) count from vietth_q169_attempts where quiz = $qid and userid= $uid ";
		$result=mysql_query($sql);
		$rows=mysql_fetch_array($result);
		if($rows['count']==0)
		$attempted= $rows['count'];
		else 
		$attempted= $rows['maxattempt'];
		// them chuc nang chek xem truoc day da lam chua
		
		$sql = "select id,status from vietth_q169_attempts where quiz = $qid and userid= $uid order by id desc limit 0,1";
		$result=mysql_query($sql);
		$rows=mysql_fetch_array($result);
		if($rows['status']=='inprogress')
		{
			$sql = "UPDATE vietth_q169_attempts set status='disconnected' where id=".$rows['id'];
			mysql_query($sql);
		}
		// save attempt
		$starttime = date('Y-m-d H:i:s');
		$attemptno = $attempted+1; 
		$sql="Insert vietth_q169_attempts(userid,ma_de,quiz,attempt,starttime,type) values('$uid','$ma_de','$qid','$attemptno','$starttime','bt30')";

		mysql_query($sql);
		$attemptid = mysql_insert_id();
		$limit_time = intval($quiz_info['timelimit'])*60;

}
//print_header($quiz_info['name']."-  Lần làm bài ".$attemptno,'<a href="index.php">'. "$stradministration</a>->Tai khoan");
?>
 
        

<div data-role="page" style="height:100%;" id="quiz_attepmt_page">
      <div data-role="header">
	  
<h2>Làm bài tập về nhà </h2>
</div>

<div align="center"><a href="#" data-role="button" id="btn_nopbai1"  > Nộp bài </a></div>
<h2 id="result" ></h2>
<h2 id="result_grade" ></h2>

<div data-role="content"  style="min-height:100%;height:100%;padding-bottom:80px">
<form name="attempt" id="frm_attempt" action="" method="POST" >	
		  <div style="width:100%;bottom:0;height:30px;padding-bottom:10px;padding-top:10px;z-index:99999999"  id="countdown"></div>
			<?php
				include_once($question_file);
				//echo $question_file;
			?>
		<input type="hidden" value="" name="user_choice" id="user_choice" />            
</form>	
			<div align="center"><a href="#" data-role="button" id="btn_nopbai"  > Nộp bài </a></div>
<script>
            $(document).ready(function(){
			var _answer="<?php echo $answer_encode;?>";
            var _quests="<?php echo $quest_encode ;?>";
			var _attempt=<?php echo $attemptid;?>;
			var submit_state=0;
            // $.fn.checknet();
			// checknet.config.checkInterval = 1;
           //  checknet.config.warnMsg = 'Trạng thái : Mất kết nối internet (đề nghị anh chị học viên vẫn tiếp tục làm bài và nộp bài bình thường!)'; 
		   <?php if(intval($limit_time)>0)
		     {
		   ?>
			$(function () {
			$('#countdown').countdown({until: <?php echo intval($limit_time) ;?>,format:'HMS',expiryText:'Hết giờ làm bài',onExpiry: submit,layout:'<span style="color:#000;font-size:100%;font-weight:bold">Thời gian còn lại</span><br>'+ 
			'<b>{hn} {hl}:  {mn} {ml} : {sn} {sl}</b>'});
			});
			<?php
			 }
			 ?>
			
			$('#code').hide();
			$('#btn_nopbai').click(function() {
			var un_check = check_un_choice(_quests);
			var str_uncheck
			if (un_check > 0)
			str_uncheck = 'Có '+un_check+' câu hỏi bạn chưa trả lời , bạn vẫn muốn nộp bài?';					
			else
			str_uncheck = 'Bạn chắc chắn muốn nộp bài sớm ?';
			
			if (confirm(str_uncheck)) {
			    $('#countdown').countdown('destroy')
				submit();
			  }	
				
		   		
				
			  
			});
			
			
			$('#btn_nopbai1').click(function() {
			var un_check = check_un_choice(_quests);
			var str_uncheck
			if (un_check > 0)
			str_uncheck = 'Có '+un_check+' câu hỏi bạn chưa trả lời , bạn vẫn muốn nộp bài?';					
			else
			str_uncheck = 'Bạn chắc chắn muốn nộp bài sớm ?';
			
			if (confirm(str_uncheck)) {
			    $('#countdown').countdown('destroy')
				submit();
			  }	
				
		   		
				
			  
			});
			
			
			function submit()
			{
			  var arr_user_choice=get_user_choice(_quests);
			  var grade = get_grade(_quests,_answer);
			  save_mark(arr_user_choice,_attempt);
			  $("#result").append('<p>Đúng : <b>'+grade+'/20 Câu</b></p>');
			  $("#result2").append('<p>Đúng : <b>'+grade+'/20 Câu</b></p>');
			  var sumgrade = Math.round(grade*10*100/20)/100;
			  $("#result").append('<p>Điểm : <b>'+sumgrade+' điểm</b></p>');
			  $("#result2").append('<p>Điểm : <b>'+sumgrade+' điểm</b></p>');
			  show_result(_answer);
			  var result_encript = doencript(_attempt,arr_user_choice);
			  $("#code").text(result_encript);
			  $('#code').show();
			  $('#btn_nopbai').attr("disabled","disabled");
			 submit_state=1;			
			
			}
			/*
		   window.onbeforeunload =function(){   
		   if (submit_state==0){
		         return  confirm('Chú ý : Nếu Anh(chị) chưa nộp bài thì bài đang làm sẽ bị 0 điêm , A/C lưu lại mã kiểm tra nếu bị ngừng kết nối Internet.\n OK để thoát. cancel và chọn stay page để tiếp tục làm bài?');      
		      }
		   }
           */   
		   
		   function check_un_choice(questions)
		   {
		   	var questions = unescape(questions);
		   	var t=0;
			arr_questions	= questions.split(",");
			jQuery.each(arr_questions, function(key,question) {
			        	
                    user_choice=$('input[name=choice_id_'+question+']:checked').val();
                         if(!!user_choice)
                         {
                         	$("#"+question).removeClass('un_check');
                         }
                         else
                         {	
				         t=t+1;    
                         $("#"+question).addClass('un_check'); 
                         }
				           
					});
		   	return t-1;
		   }
		   
			
			$('#code').click(function() {
                $(this).select();
             });
			
			function doencript(attempt,choice)
			{
				
				var currentime = Math.round((new Date()).getTime() / 1000);
			 	var str=attempt+'#'+currentime+'#'+choice;
				var encrypted = Aes.Ctr.encrypt(str,'topica', 256);
				return encrypted;
			}
			
			
			function save_mark(choice,attemptid)
        {
		  $.ajax({
		  type: 'POST',
		  url: "gradesave.php",
          data: { attemptid: attemptid, choice: choice },
		  cache: false,
		  success: function(html){		
		  $.mobile.changePage( "http://elearning.tvu.topica.vn/mod/bt30/quiz_attempt_review_mobile.php?attemptid=<?php echo $attemptid;?>", {
            transition: "pop",
            reverse: false,
            changeHash: false
            });
		  }
		});
		}
			
			
			
			
			
			function get_grade(questions,answers)
			{
				var questions = unescape(questions);
				var t=0;
			        arr_questions	= questions.split(",");
			    
			    var answers = unescape(answers);
				arr_answers	= answers.split(",");    
			        
			        jQuery.each(arr_questions, function(key,question) {
			        var i = 0;    	
                    user_choice=$('input[name=choice_id_'+question+']:checked').val();
				     if(user_choice=='' || user_choice!=null)
				                jQuery.each(arr_answers, function(key, answer) {
				                	if(user_choice==answer) 
				                	{  
				                	 t++;
				                	 reason(question,1);
				                	 i=1;
				                	}
				                	 else
									{
									$("#status_" + user_choice).html('<b  style="color:red;font-size:12px;">Sai</b>');
									//$("#reasons_"+question).html('câu '+question+' Sai, Đáp án đúng là ');
									}
				                });
				         if(i==0)
						{
							 reason(question,0);
						}       
				                
					});
			/*	
			var answers = unescape(answers);
				arr_answers	= answers.split(",");
				arr_choice  = user_choice.split(",");
			var t=0;
			jQuery.each(arr_answers, function(key, answer) {
                    jQuery.each(arr_choice, function(key, choice) {
					if(choice==answer)   
                      t++;
					else
					$("#status_" + choice).html('<b  style="color:red;font-size:12px;">Sai</b>');
					
				    });
				});
			*/	
			
			return t;			 
			}
			
			function get_user_choice(questions)
			{
			var arr_user_choice ='';
			var questions = unescape(questions);
			arr_questions	= questions.split(",");
			jQuery.each(arr_questions, function() {
			      
			      user_choice=$('input[name=choice_id_'+this+']:checked').val();
				  arr_user_choice+=user_choice+',';
				});
			return arr_user_choice;
			}
			function show_result(answers)
			{
				var answers = unescape(answers);
				arr_answers	= answers.split(",");
				jQuery.each(arr_answers, function() {
				  $("#status_" + this).html('<b  style="color:green;font-size:12px;">Đúng</b>'); 
				});
			}
			
			function liftOff() { 
			$('#btn_nopbai').attr("disabled","disabled");
			} 			
			});
			
			function reason(questionid,flag)
			{
				
				$.post("getreasons.php", { question: questionid, flag:flag },
				   function(data) {
				     $("#reasons_"+questionid).html(data);
				   });
			}
			
			
        </script>
        </div>
        <div data-role="footer" data-position="fixed" ><h5>(C) 2013 Topica </h5></div>
       </div>
     </body>
</html>   