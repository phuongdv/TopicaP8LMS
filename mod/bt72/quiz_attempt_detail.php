<style type="text/css">

div.item_quiz,div.quest_item{ clear:both; overflow:hidden; margin-bottom:7px;}
div.quest_item{margin:5px;}
div.item_quiz h3{margin:0px; padding:0px;}
div.item_quiz{ border-bottom:#cccccc 1px dashed; padding-bottom:7px;}
ul.studen_answer,ol{ display:block; margin:0px; padding:0px;}
ul.studen_answer li{ list-style:none; display:block; height: 27px; line-height:27px; padding-left:7px; background-color:#eeeeee;}
ul.studen_answer li.chan{background-color:#dddddd;}}
div.reasons{ display:block; background-color:#DDDDDD; overflow:hidden; clear:both;
</style>
<link href="css.css" type="text/css" rel="stylesheet" />

<?php
	ini_set('display_errors',1);
	require_once("../../config.php");
	 require_once("locallib.php");
	require_once("libs_trung.php");
	print_header("Q168 - xem chi tiết bài làm ",'<a href="index.php">'. "$stradministration</a>->Tai khoan");
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
	if(isset($_GET["key"])){
		$key=$_GET["key"];
	}
	$diemtong=0;
	
	// kiem tra xem da nop bay hay chua
	$sql="select count(*) from tbl_user_answer_log where txtkey = '$key'";
	$result = mysql_query($sql);
	$danopbai = mysql_fetch_assoc($result);
	// lay ra thong tin lan lam bai
	$sql ="SELECT
	(
		SELECT
			count(*)
		FROM
			tbl_user_answer_quiz
		WHERE
			quiz_id = $q
	)lan_lam_bai_so,
	CONCAT_WS(' ', u.lastname, u.firstname)hoten,
	DATE_FORMAT(tuaq.join_date,'%h:%i:%s %d-%m-%Y') bat_dau_luc
FROM
	tbl_user_answer_quiz tuaq
INNER JOIN mdl_user u ON u.id = tuaq.user_id
WHERE
	`key` = '$key'";
	$result=mysql_query($sql);
		$attempt_info=mysql_fetch_assoc($result);
		//print_r($attempt_info);
	// lay ra userchoice
	
	$sql_userchoice = "SELECT
							tual.userchoice,
							DATE_FORMAT(
								tual.endtime,
								'%h:%i:%s %d-%m-%Y'
							)TIMESTAMP,
							tual.attemptno,
						  CONCAT_WS(' ',u.lastname,u.firstname) hoten,
						  q.`name` tenquiz
						FROM
							tbl_user_answer_log tual
						  INNER join tbl_user_answer_quiz tuaq on tuaq.`key` = tual.txtkey
						  INNER join mdl_user u on u.id = tuaq.user_id
						  INNER join mdl_quiz q on q.id = tuaq.quiz_id
						WHERE
							tual.txtKEY = '$key'";	
							
	$result=mysql_query($sql_userchoice);
	$choices="";
	if(mysql_num_rows($result)==1){
		$rows=mysql_fetch_array($result);
		$choices=$rows["userchoice"];
	}		
	$thoigiannopbai=$rows["TIMESTAMP"]=='' ? 'không nộp bài' :$rows["TIMESTAMP"];
    echo '<div align="center"><p><h3>'.$rows["tenquiz"].'</h3></p>
	                          <p>Học viên<h3> '.$attempt_info["hoten"].'</h3></p>
							  <p>Lần làm bài số<h3> '.$rows["attemptno"].'</h3></p>
							  <p>Bắt đầu lúc <h3>'.$attempt_info["bat_dau_luc"].'</h3></p>
							  <p>Hoàn thành lúc <h3>'.$thoigiannopbai.'</h3></p>
							  </div>';	
	$choices_array=explode(",",$choices);		
	
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
		$diemcau=0;
		
		$count_quiz++;
		//lay ra cau tra loi va dap an
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
					<input type="radio" name="choice_id_<?php echo $rows["id"];?>" value="<?php echo $rows_answer["id"];?>"
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
					if($choices_array[$i]==$rows_answer["id"] and $rows_answer["fraction"]==1 )
						{
						$diemtong++;
						echo '<strong style="color:#16B53F;font-size:12px">&nbsp  Đúng</strong>'; 
						$diemcau=1;
						}
					elseif($choices_array[$i]==$rows_answer["id"] and $rows_answer["fraction"]!=1)
					  {
					   echo '<strong style="color:#ff0000;font-size:12px">  Sai</strong>';
					  }
                        					
					?>
					</span>
					</li>
				<?php }?>
				</ul>
			</div>
			<div class="reasons" id="reasons_<?php echo $rows["id"];?>"><strong>Điểm : <?php echo $diemcau;?></strong></div>
			</fieldset>
		</div>
		<?php
	}// end for
	$diem=round(($diemtong/$count_quiz),2)*10;
	echo '<div><strong>Tổng điểm : </strong>'.$diemtong.'/'.$count_quiz.' = <strong>'.$diem.'</strong></div>';
 if (empty($popup)) {
        print_footer($course);
    }
	?>
