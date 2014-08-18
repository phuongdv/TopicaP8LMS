<?php
require_once("../../config.php");
require_once("libs_trung.php");
//check login
require_login();
//get user_id
$uid= $USER->id;
$user=$USER->username;
$qid=0;
if(isset($_GET['qid'])==true){
	$qid=$_GET['qid'];
}
$sql="SELECT * FROM vietth_q169_de WHERE quizid='$qid' ORDER BY RAND() LIMIT 0,1";

$result=mysql_query($sql);
if(mysql_num_rows($result)<=0){
	echo "Mã đề không đúng, đề nghị kiểm tra và thử lại!";
	die();
}

$rows=mysql_fetch_array($result);
$ma_de = $rows["id"];
$question_file=$rows["url_file"];
$answer=$rows["answers"];
$answer_encode =  encode($answer);
$quest_encode= encode($rows["quest_ids"]);

// dem so cau hoi của de vua lay ra;
$sql =  "select * from vietth_q169_de where id = $ma_de limit 0,1";

$result=mysql_query($sql);
$rows=mysql_fetch_array($result);
$so_cau_hoi = $rows['number_question'];

// get attempt
$sql = "select max(attempt) maxattempt,count(*) count from vietth_q169_attempts where quiz = $qid and userid= $uid and deleted!=1 ";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);
if($rows['count']==0)
$attempted= $rows['count'];
else 
$attempted= $rows['maxattempt'];
// save attempt
$starttime = date('Y-m-d H:i:s');
$attemptno = $attempted+1; 
$sql="Insert vietth_q169_attempts(userid,ma_de,quiz,attempt,starttime,type) values('$uid','$ma_de','$qid','$attemptno','$starttime','bt72')";
mysql_query($sql);
$attemptid = mysql_insert_id();
/*--------------------- add by vietth -----------------------------------
# lay them thong tin cho quiz
@title : ten bai quiz
@mota  : mota quiz 
-----------------------------------------------------------------------*/
$sql_quiz_extra_info 	=	"SELECT * FROM mdl_quiz where id = $qid ";
$result_quiz_info		=	mysql_query($sql_quiz_extra_info);
$quiz_info				=  mysql_fetch_assoc($result_quiz_info);

print_header($quiz_info['name']."-  Lần làm bài ".$attemptno,'<a href="index.php">'. "$stradministration</a>->Tai khoan");
?>

		<link rel="stylesheet" href="css/global.css" media="all">
        <link rel="stylesheet" href="css/checknet.css" media="all" />
		<link rel="stylesheet" href="css/jquery.countdown.css" media="all" />
		
        <script src='js/jquery-1.7.2.min.js'></script>
        <script src="js/checknet-1.3.min.js"></script>
		<script type="text/javascript" src="js/jquery.countdown.js"></script>
        <script type="text/javascript" src="js/jquery.countdown-vi.js"></script>
         <script type="text/javascript" src="js/encode.js"></script>
      <script type="text/javascript" src="getreasons.php?made=<?php echo $ma_de;?>"></script>
      
        <script>
            $(document).ready(function(){
			
			var _answer="<?php echo $answer_encode;?>";
            var _quests="<?php echo $quest_encode ;?>";
			var _attempt=<?php echo $attemptid;?>;
			var submit_state=0;
          //  $.fn.checknet();
		//	checknet.config.checkInterval = 1;
          //  checknet.config.warnMsg = 'Trạng thái : Mất kết nối internet (đề nghị anh chị học viên vẫn tiếp tục làm bài và nộp bài bình thường!)';
			//$(function () {
			//$('#countdown').countdown({until: <?php echo intval($quiz_info['timelimit'])*60 ;?>,format:'HMS',expiryText:'Hết giờ làm bài',onExpiry: submit,layout:'<span style="color:#000">Thời gian còn lại</span><br>'+ 
			//'<b>{hn} {hl}:  {mn} {ml} : {sn} {sl}</b>'});
			// });
			$('#code').hide();
			$('#btn_nopbai').click(function() {
			var un_check = check_un_choice(_quests);
			var str_uncheck
			if (un_check > 0)
			str_uncheck = 'Có '+un_check+' câu hỏi bạn chưa trả lời , bạn vẫn muốn nộp bài?';					
			else
			str_uncheck = 'Bạn chắc chắn muốn nộp bài  ?';
			
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
			  $("#result").append('<p>Đúng : <b>'+grade+'/<?php echo $so_cau_hoi;?> Câu</b></p>');
			  $("#result2").append('<p>Đúng : <b>'+grade+'/<?php echo $so_cau_hoi;?> Câu</b></p>');
			  var sumgrade = Math.round(grade*10*100/<?php echo $so_cau_hoi;?>)/100;
			  $("#result").append('<p>Điểm : <b>'+sumgrade+' điểm</b></p>');
			  $("#result2").append('<p>Điểm : <b>'+sumgrade+' điểm</b></p>');
			  show_result(_answer);
			  var result_encript = doencript(_attempt,arr_user_choice);
			  $("#code").text(result_encript);
			//  $('#code').show();
				$('#btn_nopbai').attr("disabled","disabled");
			 submit_state=1;			
			}
			
		   window.onbeforeunload =function(){   
		   if (submit_state==0){
		         return  confirm('Chú ý : Nếu Anh(chị) chưa nộp bài thì bài đang làm sẽ bị 0 điêm , A/C lưu lại mã kiểm tra nếu bị ngừng kết nối Internet.\n OK để thoát. cancel và chọn stay page để tiếp tục làm bài?');      
		      }
		   }
  
		   
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
		  	 window.location='/mod/bt72/quiz_attempt_review.php?attemptid=<?php echo $attemptid;?>';	  
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
									$("#status_" + user_choice).html('<img src="/pix/smartpix.php/topica/i/cross_red_big.gif" alt="Không đúng" class="icon">');
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
				  $("#status_" + this).html('<img src="/pix/smartpix.php/topica/i/tick_green_big.gif" alt="Đúng" class="icon">'); 
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

<script language="">

</script>


</head>
<body >
          <div id="wrapper">
		  <div >
    	 <?php
             echo $quiz_info['intro'];
             ?>
        </div>
		<div id="result">
		<p>Tài khoản đăng nhập  :<b><?php echo $USER->username;?></b></p>
		<p>Lần làm bài số :<b><?php echo $attemptno;?></b></p>
		<p>Bắt đầu lúc:<b><?php echo $starttime?></b></p>
		<p>Mã đề : <b><?php echo $ma_de;?></b></p>
      
		</div>
		  <div id="countdown"></div>
			<?php
				include_once($question_file);
			?>
			<div align="center"><input type="button" id="btn_nopbai" value="  Nộp bài  "></div>
			<div id="result2">
			<p>Tài khoản đăng nhập  :<b><?php echo $USER->username;?></b></p>
			<p>Lần làm bài số :<b><?php echo $attemptno;?></b></p>
			<p>Bắt đầu lúc:<b><?php echo $starttime?></b></p>
			<p>Mã đề : <b><?php echo $ma_de;?></b></p>
	      
			</div>
			
			<textarea id="code"></textarea>
		 </div>
		  
</body>
</html>