<?php
ini_set('display_errors',1);
$qid="0";
$num="0";
if(isset($_POST["txt_quizid"])){
	$qid=$_POST["txt_quizid"];
	$num=$_POST["cbo_number"];
}	
require_once("../../config.php");
require_once("libs_trung.php");
// vietth add for q168 practice
require_once($CFG->libdir.'/questionlib.php');

/* Get course wapper this quiz*/
$sql="SELECT mdl_course.id,mdl_course.fullname,mdl_course.shortname FROM mdl_course INNER JOIN mdl_quiz ON mdl_course.id=mdl_quiz.course WHERE mdl_quiz.id='$qid'";
$result=mysql_query($sql);
$count_couser=mysql_num_rows($result);
if($count_couser<=0){
	echo "Cant' found course!";
	die();
}
$rows_course=mysql_fetch_array($result);
/* kiem tra xem quiz nay co cau hoi chua? neu chua co thi khong cho lam gi*/
$sql ="SELECT DISTINCT mdl_question.category  , count(mdl_question.category) count_cat 
	      FROM mdl_question 
		  INNER JOIN mdl_quiz_question_instances ON  mdl_question.id=mdl_quiz_question_instances.question 
		  WHERE quiz=$qid  
		  GROUP BY mdl_question.category";
$result=mysql_query($sql);
$count_question=mysql_num_rows($result);
if($count_question<=0){
	echo "Khong the tao de vi Quiz nay chua co cau hoi nao";
	die();
}
/* Creat dir lib_quiz_html to save file */
$dir_name="";
$dir_name=vietdecode($rows_course["shortname"]);
$dir_root_quiz="lib_quiz_html/".$dir_name;

if(!is_dir($dir_root_quiz)){
	mkdir($dir_root_quiz,0777);
}
/* create static quiz as html file */
for($i=1;$i<=$num;$i++){
	$code=getRandomString(10);
	$file_quiz=$dir_root_quiz."/".$qid."_".$code.".html";
	$order_str=" ORDER BY RAND() ";
		$sql ="SELECT DISTINCT mdl_question.category  , count(mdl_question.category) count_cat 
	      FROM mdl_question 
		  INNER JOIN mdl_quiz_question_instances ON  mdl_question.id=mdl_quiz_question_instances.question 
		  WHERE quiz=$qid  
		  GROUP BY mdl_question.category";

	$question= array();
	$result=mysql_query($sql); 
	$q=0;
	
	while($rows=mysql_fetch_array($result)){
		$cat= $rows['category'];
		$sub_cat_list = question_categorylist($cat);
		// old	
		//$sql_get_question = "select * from  mdl_question where category = $cat and qtype='multichoice' ORDER BY RAND() limit 0,".$rows['count_cat'];\
	   // new
	   $sql_get_question  = 
	     "select * from mdl_question where category in ($sub_cat_list) and parent = 0 and hidden = 0 ORDER BY RAND() limit 0,".$rows['count_cat'];	
		$result_quest=mysql_query($sql_get_question);
		while($rows_quest=mysql_fetch_array($result_quest)){
			$question[$q]['id'] = $rows_quest['id'];
			$question[$q]['name'] = $rows_quest['name'];
			$question[$q]['questiontext'] = $rows_quest['questiontext'];
			$q=$q+1;
		}
	}
	$stranswer="";
	$questids="";
	$count_quest=0;
	      for($j=0;$j<count($question);$j++)
	      {
			$count_quest++;
			$questids.=$question[$j]["id"].",";
			$sql_answer="SELECT * FROM mdl_question_answers WHERE mdl_question_answers.question='".$question[$j]["id"]."' ";
			$result_answer=mysql_query($sql_answer);
			while($rows_answer=mysql_fetch_array($result_answer)){
				if($rows_answer["fraction"]==1){
					$stranswer.=$rows_answer["id"].",";
					break;
				}
			}// end while
		}//end if

	// Get time open, time colose, time limit, name
	$sql_quiz="select timeopen, timeclose, timelimit, name from mdl_quiz WHERE id='$qid'";
	$result_quiz=mysql_query($sql_quiz);
	$rows_quiz=mysql_fetch_array($result_quiz);
	$timelimit=$rows_quiz['timelimit']*60;
	// insert quiz static to table
	$sql_insert="INSERT INTO vietth_q169_de(`quizid`,`course_id`,`code`,`quest_ids`,`number_question`,`answers`,`url_file`,`times`,`timeopen`,`timeclose`,`name`,`num`,`type`) ";
	$sql_insert.=" VALUES ('$qid','".$rows_course["id"]."','$code','$questids','$count_quest','$stranswer','$file_quiz','$timelimit','".$rows_quiz['timeopen']."','".$rows_quiz['timeclose']."','".$rows_quiz['name']."','$i','bt30')";
	@mysql_query($sql_insert);
	$lastid=mysql_insert_id();
	//echo $file_quiz;
	//echo "http://elearning.hou.topica.vn/vietth/bt30/create_quiz_html.php?qid=$qid&id=$lastid";
	//die();
	wwwcopy("http://elearning.tvu.topica.vn/mod/bt30/create_quiz_html.php?qid=$qid&id=$lastid",$file_quiz);
}
header("location:create_html.php?qid=$qid&iscreate=true");
?>