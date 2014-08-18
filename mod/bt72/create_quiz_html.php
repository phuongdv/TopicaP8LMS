<form name="frm_test" method="post" action="">
<?php
	require_once("../../config.php");
	require_once("libs_trung.php");
	$q=0;
	$id=1;
	// id quiz
	if(isset($_GET["qid"])){
		$q=$_GET["qid"];
	}
	// so de duoc tao
	if(isset($_GET["id"])){
		$id=$_GET["id"];
	}
	// GET Quest IDS
	$sql="SELECT * FROM vietth_q169_de WHERE quizid='$q' AND id='$id'";
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
		$count_quiz++;
		//$sql="SELECT mdl_question.id,mdl_question.name,mdl_question.questiontext FROM mdl_question INNER JOIN mdl_quiz_question_instances ON  mdl_question.id=mdl_quiz_question_instances.question WHERE quiz='$q' AND mdl_question.id in('".$questids_array[$i]."') ";
		$sql="SELECT
					mdl_question.id,
					mdl_question. NAME,
					mdl_question.questiontext
				FROM
					mdl_question
				
				WHERE
				 mdl_question.id =$questids_array[$i]";
		$result=mysql_query($sql);
		$rows=mysql_fetch_array($result);
		
		// Create database;
		$images_array=array();
		$content_quest=$rows["questiontext"];
		//----------------------------------
		?>
		<div class="item_quiz">
			<h3>Câu  <?php echo $count_quiz;?>:</h3> <a class="baoloi" href="http://ccms.topica.vn/mycc.php?question=<?php echo $rows["id"]?>" target="_blank"> Báo lỗi - góp ý</a>
			<div class="quest_item"><strong><?php echo $content_quest;?></strong></div>
			<div class="answer">
			<fieldset id = "<?php echo $rows["id"];?>"><legend>Chọn một đáp án đúng</legend>
				<ul class="studen_answer">
				<?php 
					$sql_answer="SELECT * FROM mdl_question_answers WHERE mdl_question_answers.question='".$rows["id"]."' ORDER BY mdl_question_answers.id ASC ";
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
					<input type="radio" name="choice_id_<?php echo $rows["id"];?>" value="<?php echo $rows_answer["id"];?>"/>
					<?php 
						echo $ar_item[$count].")&nbsp &nbsp;";
						echo $rows_answer["answer"];
					?> 
					</label>
					<span id="status_<?php echo $rows_answer["id"];?>"></span>
					</li>
				<?php }?>
				</ul>
			</div>
			<div class="reasons" id="reasons_<?php echo $rows["id"];?>"></div>
			</fieldset>
		</div>
		<?php
	}// end for
?>
</form>