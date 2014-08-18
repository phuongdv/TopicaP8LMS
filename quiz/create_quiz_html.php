<style type="text/css">
html,body{ margin:0px; padding:0px; font-family:arial; color:#333; font-size:12px; line-height:150%;}
div.item_quiz,div.quest_item{ clear:both; overflow:hidden; margin-bottom:7px;}
div.quest_item{margin:5px;}
div.item_quiz h3{margin:0px; padding:0px;}
div.item_quiz{ border-bottom:#cccccc 1px dashed; padding-bottom:7px;}
ul.studen_answer,ol{ display:block; margin:0px; padding:0px;}
ul.studen_answer li{ list-style:none; display:block; height: 27px; line-height:27px; padding-left:7px; background-color:#eeeeee;}
ul.studen_answer li.chan{background-color:#dddddd;}}
div.reasons{ display:block; background-color:#DDDDDD; overflow:hidden; clear:both;
</style>
<form name="frm_test" method="post" action="">
<?php
	ini_set('display_errors',1);
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
	$sql="SELECT * FROM tbl_quiz_html WHERE quizid='$q' AND id='$id'";
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
		$images_array=Get_Image($content_quest);
		for($dem=0;$dem<count($images_array);$dem++){
			$arr=explode("/",$images_array[1][$dem]);
			$images_name=$arr[(count($arr)-1)];
			$dir="../../lib_quiz_html/images/";
			$file="../../lib_quiz_html/images/$images_name";
			
			if(is_file($file)!=true && is_dir($file)!=true ){
				upload_url($images_array[1][$dem],$dir);
				//echo $images_array[1][$dem];
			}
			$content_quest=str_replace($images_array[1][$dem],$file,$content_quest);
			//upload_url($url,$save_to); echo $images_array[1][0]
		}
		?>
		<div class="item_quiz">
			<h3>Câu  <?php echo $count_quiz;?>:</h3>
			<div class="quest_item"><strong><?php echo $content_quest;?></strong></div>
			<div class="answer">
			<fieldset><legend>Chọn một đáp án đúng</legend>
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