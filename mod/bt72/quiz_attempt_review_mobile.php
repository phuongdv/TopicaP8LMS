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

<div data-role="page" style="height:100%;">
<div data-role="header">
<h1>Kết quả làm bài</h1>
</div>
<div data-role="content"  style="min-height:100%;height:100%">



<?php

	require_once("../../config.php");
	
	// require_once("locallib.php");

	require_once("libs_trung.php");
	
		$error = $_GET['error'];
	$q=0;
	$id=1;
	// id quiz
	if(isset($_GET["attemptid"])){
		$attemptid=$_GET["attemptid"];
	}
	
	$diemtong=0;
	
	// lay ra userchoice
	
	$sql_userchoice = "SELECT
						*
						from vietth_q169_answer
					where attempt = $attemptid";
	$result=mysql_query($sql_userchoice);
	if(mysql_num_rows($result)==0){
	 if (empty($popup)) {
     //   print_footer($course);
    }

	}
	$choices="";
	if(mysql_num_rows($result)==1){
		$rows=mysql_fetch_array($result);
		$choices=$rows["answer"];
	}	
	
	// get attempt info
	$sql="SELECT
	qa.*, CONCAT_WS(' ', u.lastname, u.firstname)hoten,q.`name` quizname
FROM
	vietth_q169_attempts qa
INNER JOIN mdl_user u ON u.id = qa.userid
INNER join mdl_quiz q on q.id = qa.quiz
WHERE qa.id = $attemptid";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);

	$quiz_id = $rows['quiz'];
	$id_quiz = $rows['quiz'];
	echo '<div><strong>Tổng điểm :<span id="top_diem_cau"></span> = <span id="top_diem"></span></strong></div>
<div align="center"><a data-ajax="false" style="font-size:1.4em;font-weight:bold"  data-role="button" href="/mod/bt72/review_pr_mobile.php?q='.$quiz_id.'" >Quay lại </a></div>';
	
	if($rows["finishtime"]=='')
	$rows["finishtime"]=' Chưa nộp bài ';

	$choices_array=explode(",",$choices);	
   	
	// GET Quest IDS
	$sql="SELECT qd.* FROM vietth_q169_de qd 
					INNER join vietth_q169_attempts qa on qa.ma_de = qd.id
					WHERE qa.id = $attemptid";
	
	$result=mysql_query($sql);
	$questids="";
	if(mysql_num_rows($result)==1){
		$rows=mysql_fetch_array($result);
		$questids=$rows["quest_ids"];
	}
	
	$questids_array=explode(",",$questids);
	// Get question by questids
	$count_quiz=0;
	for($i=0;$i<count($questids_array);$i++){
		if($questids_array[$i]=="") continue;
		$diemcau=0;
		
		$count_quiz++;
		//lay ra cau tra loi va dap an
		//$sql="SELECT mdl_question.id,mdl_question.name,mdl_question.questiontext FROM mdl_question INNER JOIN mdl_quiz_question_instances ON  mdl_question.id=mdl_quiz_question_instances.question WHERE quiz='$q' AND mdl_question.id in('".$questids_array[$i]."') ";
		$sql="
		 SELECT
			mdl_question.id,
			mdl_question. NAME,
			mdl_question.questiontext,
			mdl_question_multichoice.correctfeedback,
			mdl_question_multichoice.incorrectfeedback
		FROM
			mdl_question
		INNER JOIN
			mdl_question_multichoice
		ON
			mdl_question_multichoice.question = mdl_question.id
		WHERE
			mdl_question.id = $questids_array[$i]";
		$result=mysql_query($sql);
		$rows=mysql_fetch_array($result);
		
		// Create database;
		$images_array=array();
		$content_quest=$rows["questiontext"];
		//----------------------------------
		//$diem=round(($diemtong/$count_quiz),2)*10;
		//echo '<div><strong>Tổng điểm : </strong>'.$diemtong.'/'.$count_quiz.' = <strong>'.$diem.'</strong></div>';
		?>
		<div class="item_quiz"
		
		<?php 
  if($error ==  $rows["id"])
   {
   echo 'style="background:#FFAAAA"';
   }
  ?>
		
		>  <hr>
			<h3>Câu  <?php echo $count_quiz;?>:</h3>
			<a id="<?php echo $rows["id"];?>">
			
			<div class="quest_item"><strong><?php echo $content_quest;?></strong></div>
			<div class="answer">
			<fieldset><legend>Chọn một câu trả lời</legend>
				<ul class="studen_answer">
				<?php 
					$sql_answer="SELECT * FROM mdl_question_answers WHERE mdl_question_answers.question='".$rows["id"]."' ";
					$result_answer=mysql_query($sql_answer);
					$ar_item=array("","A","B","C","D","E","F");
					$count=0;
					while($rows_answer=mysql_fetch_array($result_answer)){
					
					$count++; 
					$class="";
					if($count%2==0){$class="chan";}
				?>
				<li class="<?php echo $class;?>">
					<label>
					<input type="radio" disabled name="choice_id_<?php echo $rows["id"];?>" value="<?php echo $rows_answer["id"];?>"
                    <?php 
					
					if($choices_array[$i]==$rows_answer["id"])
                    {
					echo 'checked="checked" ';
					}       
					?>    
					/>
					<?php 
						echo $ar_item[$count].")&nbsp &nbsp;";
						echo $rows_answer["answer"];
					?> 
					
					<span id="status_<?php echo $rows_answer["id"];?>" 
					<?php if($rows_answer["fraction"]==1) // neu tra loi dung
					{
						echo 'class="status_true"';
						
					
					}
					else
					{
					echo 'class="status_false"';
					}
					?>
					>
					<?php
					//echo ($choices_array[$i].'-'.$rows_answer["id"]);
					
					
					
					
					if($choices_array[$i]!='' && $choices_array[$i]==$rows_answer["id"] && $rows_answer["fraction"]==1)
					{
					$diemtong++;
						echo '<strong style="color:#16B53F;font-size:12px">&nbsp  Đúng</strong>'; 
					    
						$diemcau=1;
						$dung=1;
					
					}
					elseif($rows_answer["fraction"]==1) // dap an
					{
						echo '<strong style="color:#16B53F;font-size:12px">&nbsp  Đúng</strong>'; 
						
					}
					else
					{
					echo '<strong style="color:#ff0000;font-size:12px">  Sai</strong>';
					   
					}
					
					
					
					/*
					
					
					if($choices_array[$i]==$rows_answer["id"] and $rows_answer["fraction"]==1 )
						{
						$diemtong++;
						echo '<strong style="color:#16B53F;font-size:12px">&nbsp  Đúng</strong>'; 
					    $feedback = $rows['correctfeedback'];
						$diemcau=1;
						$dung=1;
						}
					elseif($choices_array[$i]==$rows_answer["id"] and $rows_answer["fraction"]!=1)
					  {
					   echo '<strong style="color:#ff0000;font-size:12px">  Sai</strong>';
					   $feedback = $rows['incorrectfeedback'];
					   $dung=1;
					  }
					  
					elseif($rows_answer["fraction"]==1) // dap an
					{
						echo '<strong style="color:#16B53F;font-size:12px">&nbsp  Đúng</strong>'; 
						$feedback = $rows['correctfeedback'];
					}
					elseif($choices_array[$i]!=$rows_answer["id"])
					{	
					 echo '<strong style="color:#ff0000;font-size:12px">  Sai</strong>';
					   $feedback = $rows['incorrectfeedback'];	
					}  
					
					else 
					{
					
					   $feedback = $rows['incorrectfeedback'];	
					} 
                      */  					
					?>
					</span>
					</label>
					</li>
				<?php }?>
				</ul>
				<div id = "feedback">
				   
                    <?php 
                    if($diemcau==1)
                    $feedback = $rows['correctfeedback'];
                    else
                    $feedback = $rows['incorrectfeedback'];
                    echo $feedback; ?>
					</div>
			</div>
			<div class="reasons" id="reasons_<?php echo $rows["id"];?>"><strong>Điểm : <?php echo $diemcau;?></strong></div>
			</fieldset>
		</div>
		<?php
	}// end for
	$diem=round(($diemtong/$count_quiz),2)*10;
	echo '<hr><div><strong>Tổng điểm : </strong>'.$diemtong.'/'.$count_quiz.' = <strong>'.$diem.'</strong></div>';
	echo '<div align="center"><a data-ajax="false" style="font-size:1.4em;font-weight:bold"  data-role="button" href="/mod/bt72/review_pr_mobile.php?q='.$quiz_id.'" >Quay lại </a></div>';
   
   echo "<script>$('#top_diem_cau').html('".$diemtong."/".$count_quiz."');$('#top_diem').html('".$diem."');</script>";
	?>
</div>

	<div data-role="footer" data-position="fixed" ><h5>(C) 2013 Topica </h5></div>
</div>
</body>
</html>