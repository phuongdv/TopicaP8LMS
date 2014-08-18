<?php
	ini_set('display_errors',1);
	require_once("../../config.php");
	//require_once("locallib.php");
	require_once("libs_trung.php");
	$error_feed_back = $_GET['error'];
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
					where attempt = $attemptid order by id desc limit 0,1";
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
	qa.*, CONCAT_WS(' ', u.lastname, u.firstname)hoten,q.`name` quizname,q.timelimit timelimit
FROM
	vietth_q169_attempts qa
INNER JOIN mdl_user u ON u.id = qa.userid
INNER join mdl_quiz q on q.id = qa.quiz
WHERE qa.id = $attemptid";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	print_header("Xem lại lần làm bài số ".$rows["attempt"],'<a href="index.php">'. "$stradministration</a>->Tai khoan");

$quiz_id = $rows['quiz'];
// lay thong tin quiz
$sql_quiz_extra_info 	=	"SELECT * FROM mdl_quiz
INNER JOIN mdl_course on mdl_course.id = mdl_quiz.course
 where mdl_quiz.id = ".$rows['quiz'];

$result_quiz_info		=	mysql_query($sql_quiz_extra_info);
$quiz_info				=  mysql_fetch_assoc($result_quiz_info);


	//print_header("$site->shortname: ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
		?>
	<link rel="stylesheet" href="css/global_bt30.css" media="all">
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery-migrate-1.2.1.min.js"></script>
		<div class="navbar clearfix">
        <div class="breadcrumb"><h2 class="accesshide ">Bạn đang ở đây</h2> <ul>
<li class="first"><a onclick="this.target='_top'" href="/">TOPICA</a></li>
<li class="first"> <span class="accesshide ">/&nbsp;</span><span class="arrow sep">►</span> <a onclick="this.target='_top'" href="/course/view.php?id=<?php echo $quiz_info['course'];?>"><?php echo $quiz_info['fullname'];?></a></li>
<li class="first"> <span class="accesshide ">/&nbsp;</span><span class="arrow sep">►</span> <a onclick="this.target='_top'" href="/mod/bt30/bt30.php?qid=<?php echo $rows['quiz'];?>"><?php echo $quiz_info['name'];?></a></li><li class="first"> <span class="accesshide ">/&nbsp;</span><span class="arrow sep">►</span>Xem lại lần làm bài số <?php echo $rows["attempt"];?></li></ul></div>
        <div class="navbutton">&nbsp;</div>
    </div>

	
	
	<?php

    $cm = get_coursemodule_from_instance("quiz",$rows['quiz'], $quiz_info['course']);
	$context = get_context_instance(CONTEXT_MODULE, $cm->id);
	echo '<h2 class="main" style="color:#000;font-size:1.4em;padding:5px">'.$quiz_info['name'].'</h2>';
	echo '<h2 class="main" style="color:#000;font-size:1.4em;padding:5px">Xem lại lần làm bài số '.$rows["attempt"].'</h2>';
	
	?>
	<div align="center"><a style="font-size:1.4em;font-weight:bold" href="/mod/bt30/bt30.php?qid=<?php echo $quiz_id;?>" >Quay lại </a></div>
	    <table class="generaltable generalbox quizreviewsummary"><tbody>
		<tr><th scope="row" class="cell">Bắt đầu vào lúc</th><td class="cell"><?php echo date('l, d F Y, h:i:s A',strtotime($rows["starttime"]));?></td></tr>
		<tr><th scope="row" class="cell">Kết thúc lúc</th><td class="cell"><?php echo $rows['finishtime']==''? 'Không nộp bài': date('l, d F Y, h:i:s A',strtotime($rows["finishtime"]));?></td></tr>
		<tr><th scope="row" class="cell">Thời gian thực hiện </th>
        <td class="cell"><?php  echo $rows['finishtime']==''? 'Không nộp bài': gmdate('H  \g\i\ờ : i  \p\h\ú\t : s \g\i\â\y',strtotime($rows["finishtime"])-strtotime($rows["starttime"]));?></td>
        </tr>
        <?php
		
		if($rows['timelimit']>0 &&  (strtotime($rows["finishtime"]) - (strtotime($rows["starttime"])+10))- ($rows['timelimit']*60)>=0)
		{//neu qua han nop bai thi 0 diem
			echo '<tr style="color:red"><th scope="row" class="cell">Quá hạn </th><td class="cell">';
			echo gmdate('H  \g\i\ờ : i  \p\h\ú\t : s \g\i\â\y',strtotime($rows["finishtime"])-strtotime($rows["starttime"])-$rows['timelimit']*60);
			echo '</td></tr>';
			?>
			<tr><th scope="row" class="cell">Điểm </th><td class="cell">0</td></tr>
			<tr><th scope="row" class="cell">Điểm</th><td class="cell">0</td></tr>
			<?php
		}
		else
		{
			?>
			<tr><th scope="row" class="cell">Điểm </th><td class="cell"><span id="marktotal"></span></td></tr>
			<tr><th scope="row" class="cell">Điểm</th><td class="cell"><span style="font-weight:bold" id="total"></span></td></tr>
			<?php
		}
		?>
        </tbody></table>
	<?php
	
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
	
	//

	//print_r($questids_array);
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
			//echo $sql;
		$result=mysql_query($sql);
		$rows=mysql_fetch_array($result);
		    $correct = $rows['correctfeedback'];
            $incorrect  = $rows['incorrectfeedback'];
		// Create database;
		$images_array=array();
		$content_quest=$rows["questiontext"];
		//----------------------------------
		
		?>
		

		 <!-- start 1 cau -->
  <div  class="que multichoice clearfix" 
  
  <?php 

  if($error_feed_back ==  $rows["id"])
   {
   echo 'style="background:#FFAAAA"';
   }
  ?>
  >
  <a id="<?php echo $rows["id"];

  
  ?>">
    <div class="info">
     <span class="no"><span class="accesshide">Câu </span><?php echo $count_quiz;?></span>
     <?php
	// echo $choices_array[$i].'<br>';
     $v_q_id = $rows["id"];
	 if (has_capability('mod/quiz:manage', $context)) {
        echo '<a title="Soạn thảo "';
		echo 'href="/question/question.php?id='.$rows["id"].'&cmid=166668" target="_blank"><img alt="Soạn thảo " ';
		echo 'src="/pix/smartpix.php/topica/t/edit.gif"></a><br>';
    }
	 ?>
	 <a href="http://ccms.topica.vn/mycc.php?question=<?php echo $rows["id"];?>&attempt_bt30=<?php echo $attemptid;?>&attempt=0" target="_blank">[Góp ý]</a>
          <div class="grade">
        Điểm : 1      </div>
      </div>
  <div class="content">
    <div class="qtext">
  <div style="text-align: justify;"><span style="font-weight: bold;"><font size="3"><p><?php echo $content_quest;?></p></font></span></div></div>

<div class="ablock clearfix">
  <div class="prompt"style="padding-right:10px">
    Chọn một câu trả lời  </div>
  <table class="answer">
<fieldset>
				<ul class="studen_answer">
				<?php 
					$sql_answer="SELECT * FROM mdl_question_answers WHERE mdl_question_answers.question='".$rows["id"]."' ORDER BY mdl_question_answers.id ASC ";
					//echo $sql_answer;
					$result_answer=mysql_query($sql_answer);
					$ar_item=array("","A","B","C","D","E","F");
					$count=0;
					while($rows_answer=mysql_fetch_array($result_answer)){
					
					$count++; 
					$class="";
					if($count%2==0){$class="chan";}
				?>
				<li class="<?php echo $class;?>"
				<?php if($rows_answer["fraction"]==1) // neu la dap an
					{
						echo 'style="background:#afa"';
					}
					else
					{
					echo 'class="status_false"';
					}
					?> >
					<label
					
										
					
					>
					<input type="radio" name="choice_id_<?php echo $rows["id"];?>" value="<?php echo $rows_answer["id"];?>"
                    <?php 
					
					if($choices_array[$i]==$rows_answer["id"])
                    {
					echo 'checked="checked" ';
					}    
					else echo ' disabled ';
					?>    
					/>
					<?php 
						echo $ar_item[$count].")&nbsp &nbsp;";
						echo $rows_answer["answer"];
					?> 
					</label>
					
					
					
					<span id="status_<?php echo $rows_answer["id"];?>" 	>
					<?php
					
					if($choices_array[$i]!=0 and $choices_array[$i]==$rows_answer["id"] and $rows_answer["fraction"]==1 and $choices_array[$i]!='undefined' )
						{
						$diemtong++;
						echo '<img src="/pix/smartpix.php/topica/i/tick_green_big.gif" alt="Đúng" class="icon">'; 
					    //$feedback = $rows['correctfeedback'];
						//$feedback =$correct;
						$diemcau=1;
						$dung=1;
						
						}
					elseif($choices_array[$i]!=0 and $choices_array[$i]==$rows_answer["id"] and $rows_answer["fraction"]!=1 and $choices_array[$i]!='undefined')
					  {
					   echo '<img src="/pix/smartpix.php/topica/i/cross_red_big.gif" alt="Không đúng" class="icon">';
					   //$feedback = $rows['incorrectfeedback'];
					   $dung=0;
					   
					  }
					elseif($rows_answer["fraction"]==1) // dap an
					{
						echo '<img src="/pix/smartpix.php/topica/i/tick_green_small.gif" alt="Đúng" class="icon">';
						// $feedback = $rows['correctfeedback'];
					}
					else
					{	
					echo '<img src="/pix/smartpix.php/topica/i/cross_red_small.gif" alt="Không đúng" class="icon">';
						  // $feedback = $rows['incorrectfeedback'];

					}
					
					if($choices_array[$i]=='undefined')
					{
						// $feedback = $rows['incorrectfeedback'];
						$dung=0;
					}
					
					if($dung==1)
					 $feedback =$correct;
                    else
					  $feedback = $incorrect;
					  
					?>
					</span>
					
					</li>
				<?php }?>
				</ul>
				<div id = "feedback">
				   
                    <?php echo $feedback; ?>
					</div>
			</div>
			<div class="grading">
			<?php
			
			if($dung==0 )
						{
						
						// check xem cau nay co duoc cham lại ko
			$sql ="Select * from vietth_cham_lai_bt30 where attemptid= $attemptid and questionid = ".$rows["id"]." order by id desc limit 0,1";
			$result=mysql_query($sql);
		    $cham_lai=mysql_fetch_array($result);
		    //print_r($cham_lai);
		    if(count($cham_lai[0])>0 )
		     {
		       $diemcau=1;
              						$diemtong++;
               		     
		     }
						
						?>
      <div class="correctness  incorrect">Không đúng</div><div class="gradingdetails">Điểm: <?php echo $diemcau;?>/1. </div>    </div>
			<?php
			if(count($cham_lai[0])>0 )
		     {
		       
               echo 'Lý do sửa điểm: "<em>'.$cham_lai['comment'].'</em>"';
               		     
		     }
			
			}
			else
			{
			?>
			
			<div class="correctness  correct">Đúng</div><div class="gradingdetails">Điểm: <?php echo $diemcau;?>/1. </div>    </div>
			<?php
			}
			?>
			</fieldset></table>
	</div>
</div>
 <?php
	 if (has_capability('mod/quiz:manage', $context)) {
	 ?>
        <a style="margin-left:10px" href="javascript:void(0)" onClick="MyWindow=window.open('/mod/bt30/question_regrade.php?attemptid=<?php echo $attemptid;?>&questionid=<?php echo $v_q_id ?>','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=300'); return false;">Viết nhận xét và cho lại điểm</a>
     <?php
    }
	 ?>
</div>

		<!-- end 1 cau -->
		

	
		<?php
	}// end for
	$diem=round(($diemtong/$count_quiz),2)*10;
	// up date diem moi
		//echo '<div><strong>Tổng điểm : </strong>'.$diemtong.'/'.$count_quiz.' = <strong>'.$diem.'</strong></div>';
	?>
	<div align="center"><a style="font-size:1.4em;font-weight:bold" href="/mod/bt30/bt30.php?qid=<?php echo $quiz_id;?>" >Quay lại </a></div>
<?php
/*update diem sau khi xem lai bai*/
//can kiem tra diem cham lai neu > diem cu thi moi update
//1. lay lai diem cu
	$sql_diem_cu = mysql_query("select sumgrade as diem_cu, corrects as cau_dung_cu from vietth_q169_attempts where id = $attemptid ");
	while($result=mysql_fetch_array($sql_diem_cu)){
		$diem_cu = $result['diem_cu'];
		$cau_dung_cu = $result['cau_dung_cu'];
	} 
//2. so sanh diem cu diem moi
	if($diem_cu <$diem){
		//update diem
		$sql_update = "update vietth_q169_attempts set sumgrade = $diem ,corrects= $diemtong where id = $attemptid ";
		mysql_query($sql_update);
	}else{
		$diem = $diem_cu;
		$diemtong = $cau_dung_cu;
	}
print_footer($site); 

function SecToDateTime($seconds) {
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours*3600)) / 60);
        $days = floor($hours/24);
        $gio  = floor($hours - ($days*24));
        $output='';
        if($days>0)
        $output .= ' '.$days.' ngày';
        $output .= ' '.$gio.' giờ '.$mins.' phút';
        return $output;
      }

?>
<script>
$("#marktotal").html('<?php echo $diemtong.'/'.$count_quiz;?>');
$("#total").html('<?php echo $diem;?>');

</script>