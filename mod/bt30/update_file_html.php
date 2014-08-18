<?php
require_once("../../config.php");
require_once("libs_trung.php");

	if(isset($_GET["id"])){
		$id=$_GET["id"]; // id cua de
	}
	
	// get info of de
	$sql = "select * from vietth_q169_de where id = $id";
	$result=mysql_query($sql);
    $de=mysql_fetch_assoc($result);
	$questids=$de["quest_ids"];
	$questids_array=explode(",",$questids);
	$count_question=0;
		for($i=0;$i<count($questids_array);$i++)
		{
			if($questids_array[$i]!='')
			{
				$count_question++;
				$sql_question="SELECT
					mdl_question.id,
					mdl_question. NAME,
					mdl_question.questiontext
				FROM
					mdl_question
				
				WHERE
				 mdl_question.id =$questids_array[$i]";
			$result_question=mysql_query($sql_question);
			$arr_question_info=mysql_fetch_assoc($result_question);
			$content_quest=$arr_question_info["questiontext"];
	    	
			// update content
			?>
			 <!-- start 1 cau -->
		<div id="q<?php echo $arr_question_info["id"]?>" class="que multichoice clearfix">
  <div class="info">
    <span class="no"><span class="accesshide">Câu </span><?php echo $count_question;?></span>
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
<fieldset id = "<?php echo $rows["id"];?>">
				<ul class="studen_answer">
				<?php 
					//$sql_answer="SELECT * FROM mdl_question_answers WHERE mdl_question_answers.question='".$arr_question_info["id"]."' order by rand() ";
					$sql_answer="SELECT * FROM mdl_question_answers WHERE mdl_question_answers.question='".$arr_question_info["id"]."' ORDER BY mdl_question_answers.id ASC ";
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
					<input type="radio" name="choice_id_<?php echo $arr_question_info["id"];?>" value="<?php echo $rows_answer["id"];?>"/>
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
			<div class="reasons" id="reasons_<?php echo $arr_question_info["id"];?>"></div>
			</fieldset></table>
    </div>
    <div class="grading">
          </div>  </div>
</div>
		
		<!-- end 1 cau -->
 <?php
			// end update content
			}
		}
	?>