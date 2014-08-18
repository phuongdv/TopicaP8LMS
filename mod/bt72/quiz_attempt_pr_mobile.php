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
//check login

//get user_id
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
$sql="SELECT * FROM vietth_q169_de WHERE quizid='$qid' ORDER BY RAND() LIMIT 0,1";

$result=mysql_query($sql);
if(mysql_num_rows($result)<=0){
	echo "Mã đề không đúng, đề nghị kiểm tra và thử lại!";
	die();
}

$nop_bai =0;
if($_POST['user_choice']!='')
{
echo($_POST['user_choice']);
$nop_bai=1;
}
else
{
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
}



?>



<div data-role="page" style="height:100%;" id="quiz_attepmt_page">
      <div data-role="header">
	  
<h2>Làm bài luyện tập </h2>
</div>
<div align="center"><a href="#" data-role="button" id="btn_nopbai1"  > Nộp bài </a></div>
<h2 id="result" ></h2>
<h2 id="result_grade" ></h2>
<form name="attempt" id="frm_attempt" action="" method="POST" >
<div data-role="content"  style="min-height:100%;height:100%">
			<?php
			   include_once($question_file);
			?>
<input type="hidden" value="" name="user_choice" id="user_choice">            
</form>	
			<div align="center"><a href="#" data-role="button" id="btn_nopbai"  > Nộp bài </a></div>


<script>
	        var _answer="<?php echo $answer_encode;?>";
            var _quests="<?php echo $quest_encode ;?>";
			var _attempt=<?php echo $attemptid;?>;	
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



   function reason(questionid,flag)
			{
				
				$.post("getreasons.php", { question: questionid, flag:flag },
				   function(data) {
				     $("#reasons_"+questionid).html(data);
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
   			function save_mark(choice,attemptid)
        {
		  $.ajax({
		  type: 'POST',
		  url: "gradesave.php",
          data: { attemptid: attemptid, choice: choice },
		  cache: false,
		  success: function(html){	
          $.mobile.changePage( "http://elearning.tvu.topica.vn/mod/bt72/quiz_attempt_review_mobile.php?attemptid=<?php echo $attemptid;?>", {
            transition: "pop",
            reverse: false,
            changeHash: false
            });
         		  
		  }
		});
		}        
           
    	function submit()
			{
			  var arr_user_choice=get_user_choice(_quests);
			  var grade = get_grade(_quests,_answer);
			  save_mark(arr_user_choice,_attempt);			
			} 
            
              
           
           		
    $("#btn_nopbai").click(function(e){
        e.preventDefault();
        	var un_check = check_un_choice(_quests);
			var str_uncheck
			if (un_check > 0)
			str_uncheck = 'Có '+un_check+' câu hỏi bạn chưa trả lời , bạn vẫn muốn nộp bài?';					
			else
			str_uncheck = 'Bạn chắc chắn muốn nộp bài  ?';
			if (confirm(str_uncheck)) {
			    submit();
			  }	
        return false;
        });
        
            $("#btn_nopbai1").click(function(e){
        e.preventDefault();
        	var un_check = check_un_choice(_quests);
			var str_uncheck
			if (un_check > 0)
			str_uncheck = 'Có '+un_check+' câu hỏi bạn chưa trả lời , bạn vẫn muốn nộp bài?';					
			else
			str_uncheck = 'Bạn chắc chắn muốn nộp bài  ?';
			if (confirm(str_uncheck)) {
			    submit();
			  }	
        return false;
        });
		
</script>

 </div> <!-- end content-->		
</div>  <!-- end page -->		
		  
