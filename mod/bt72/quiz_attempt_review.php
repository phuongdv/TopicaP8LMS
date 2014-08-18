<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" href="css/global.css" media="all">
<link rel="stylesheet" href="css/global_bt30.css" media="all">
<link href="css.css" type="text/css" rel="stylesheet" />
<?php
	ini_set('display_errors',1);
	require_once("../../config.php");
	require_once("locallib.php");
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
					where attempt = $attemptid order by timestamp desc limit 0,1";
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
	print_header("Xem chi tiết bài làm ".$rows["quizname"].' Lần làm số '.$rows["attempt"]);
	$quiz_id = $rows['quiz'];
	if($rows["finishtime"]=='')
		$rows["finishtime"]=' Chưa nộp bài ';
		echo '<div align="center"><p><h3>'.$rows["quizname"].'</h3></p>
	                          <p>Học viên<h3> '.$rows["hoten"].'</h3></p>
							  <p>Lần làm bài số<h3> '.$rows["attempt"].'</h3></p>
							  <p>Bắt đầu lúc <h3>'.$rows["starttime"].'</h3></p>
							  <p>Hoàn thành lúc <h3>'.$rows["finishtime"].'</h3></p>
							  </div>';	?>
	<div align="center">Tổng điểm: <span id="marktotal"></span> = <span style="font-weight:bold" id="total"></span></div>;
	<?php
	// nut quay lai
	echo '<div align="center"><a style="font-size:1.4em;font-weight:bold" href="/mod/bt72/bt72.php?qid='.$quiz_id.'" >Quay lại </a></div>';
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
		
		?>
		<div class="item_quiz"
		
		<?php 
  if($error ==  $rows["id"])
   {
   echo 'style="background:#FFAAAA"';
   }
  ?>
		
		>
			<h3>Câu  <?php echo $count_quiz;?>:</h3>
			<a id="<?php echo $rows["id"];?>">
			<a href="http://ccms.topica.vn/mycc.php?attempt_bt72=<?php echo $attemptid;?>&question=<?php echo $rows['id'];?>" target="_blank">[Góp ý]</a>	
			<div class="quest_item"><strong><?php echo $content_quest;?></strong></div>
			<div class="answer">
			<fieldset><legend>Chọn một câu trả lời</legend>
				<ul class="studen_answer">
				<?php 
					
					$sql_answer="SELECT * FROM mdl_question_answers WHERE mdl_question_answers.question='".$rows["id"]."' ORDER BY mdl_question_answers.id ASC ";
					$result_answer=mysql_query($sql_answer);
					$ar_item=array("","A","B","C","D","E","F");
					$count=0;
					$choice_hv = false;
					while($rows_answer=mysql_fetch_array($result_answer)){
					
					$count++; 
					$class="";
					if($count%2==0){$class="chan";}
				?>
				<li class="<?php echo $class;?>"
				<?php 
				
				// danglx them highlight cho cau tra loi dung 04-11-2013
				if($rows_answer["fraction"]==1) // neu la dap an
					{
						echo 'style="background:#afa"';
					}
					else
					{
					echo 'class="status_false"';
					}
				// End danglx them highlight cho cau tra loi dung
					?> >
				
					<label>
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
					//echo '$choices_array[$i]:'.$choices_array[$i].'<br/>';
					//echo '$rows_answer["id"]:'.$rows_answer["id"].'<br/>';
					//echo '$rows_answer["fraction"]:'.$rows_answer["fraction"].'<br/>';
					if($choices_array[$i]==$rows_answer["id"] and $rows_answer["fraction"]==1 and $choices_array[$i]!='undefined' )
						{
						$diemtong++;
						//echo '<strong style="color:#16B53F;font-size:12px">&nbsp  Đúng</strong>'; 
						echo '<img src="/pix/smartpix.php/topica/i/tick_green_big.gif" alt="Đúng" class="icon">'; 
					    $feedback = $rows['correctfeedback'];
						$diemcau=1;
						$dung=1;
						$choice_hv = true;
						}
					elseif($choices_array[$i]==$rows_answer["id"] and $rows_answer["fraction"]!=1 and $choices_array[$i]!='undefined')
					  {
					   //echo '<strong style="color:#ff0000;font-size:12px">  Sai</strong>';
					   echo '<img src="/pix/smartpix.php/topica/i/cross_red_big.gif" alt="Không đúng" class="icon">';
					   $feedback = $rows['incorrectfeedback'];
					   $dung=0;//danglx sua $dung=0
					  }
					  
					elseif($rows_answer["fraction"]==1) // dap an
					{
						//echo '<strong style="color:#16B53F;font-size:12px">&nbsp  Đúng</strong>'; 
						echo '<img src="/pix/smartpix.php/topica/i/tick_green_small.gif" alt="Đúng" class="icon">';
					}
					elseif($choices_array[$i]==0)
					{	
						//echo '<strong style="color:#ff0000;font-size:12px">  Sai</strong>';
						echo '<img src="/pix/smartpix.php/topica/i/cross_red_small.gif" alt="Không đúng" class="icon">';
					}  
					
					else 
					{
						echo '<img src="/pix/smartpix.php/topica/i/cross_red_small.gif" alt="Không đúng" class="icon">';
					   $feedback = $rows['incorrectfeedback'];	
					} 
					if($choices_array[$i]=='undefined')
					{
						// $feedback = $rows['incorrectfeedback'];
						$dung=0;
					}
                        					
					?>
					</span>
					
					</li>
				<?php }?>
				</ul>
				<div id = "feedback">
				   
                    <?php 
						if ($choice_hv){
							$feedback = $rows['correctfeedback'];
						}else{
							$feedback = $rows['incorrectfeedback'];	
						}
						echo $feedback; 
					?>
					</div>
			<?php
			// danglx them dung sai 4-11-2-13
			if($dung==0 )
						{	
						?>
      <div class="incorrect">Không đúng</div>  
			<?php
			
			}
			else
			{
			?>
			
			<div class="correct">Đúng</div> 
			<?php
			}
			// End danglx them dung sai 4-11-2-13
			?>
			</div>
			
			</fieldset>
		</div>
		<?php
	}// end for
	$diem=round(($diemtong/$count_quiz),2)*10;
	
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

	echo '<div><strong>Tổng điểm : </strong>'.$diemtong.'/'.$count_quiz.' = <strong>'.$diem.'</strong></div>';
	echo '<div align="center"><a style="font-size:1.4em;font-weight:bold" href="/mod/bt72/bt72.php?qid='.$quiz_id.'" >Quay lại </a></div>';
 if (empty($popup)) {
        print_footer($course);
    }
	?>
<script>
$("#marktotal").html('<?php echo $diemtong.'/'.$count_quiz;?>');
$("#total").html('<?php echo $diem;?>');
</script>
