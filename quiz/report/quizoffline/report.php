<?php
/**
 * This script lists student attempts
 *
 * @version $Id: report.php,v 1.98.2.47 2009/02/16 04:17:54 tjhunt Exp $
 * @author Martin Dougiamas, Tim Hunt and others.
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package quiz
 *//** */

require_once($CFG->libdir.'/tablelib.php');
require_once($CFG->dirroot.'/mod/quiz/report/overview/overviewsettings_form.php');
require_once $CFG->dirroot.'/grade/lib.php';
class quiz_report extends quiz_default_report {

    /**
     * Display the report.
     */
	 
    function display($quiz, $cm, $course) {
        global $CFG, $db, $COURSE, $USER;
        // Define some strings
        $strreallydel  = addslashes(get_string('deleteattemptcheck','quiz'));
        $strtimeformat = get_string('strftimedatetime');
        $strreviewquestion = get_string('reviewresponse', 'quiz');

        $context = get_context_instance(CONTEXT_MODULE, $cm->id);

        // Only print headers if not asked to download data
        if (!$download = optional_param('download', NULL)) {
            $this->print_header_and_tabs($cm, $course, $quiz, "quizoffline");
        } 
		
        $quizid=$_GET['q'];
		$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
		$mysqli->select_db($CFG->dbname);
		$mysqli->query("SET NAMES 'utf8'");
		
		
		// xem bai nay co bao nhieu cau hoi
		$sql =" select questions from mdl_quiz where id = $quizid";
		
		$question_count=$mysqli->query($sql);
		$question = $question_count->fetch_assoc();
		$questids_array=explode(",",$question['questions']);
		$total_question =  count($questids_array)-1;	
		
		
        if(isset($_POST["btnxoa"])){
			$btnxoa=$_POST["btnxoa"];
        }         
  		if($btnxoa!='')
        {
			$iddes = implode(",", $_POST['idde']);
			if($iddes!='')
			  {
				$sql = "update vietth_q169_attempts set deleted='1',attempt='0',usermodified='".$USER->id."' WHERE id in ($iddes) ";
				$mysqli->query($sql);
			  }
			else{
						echo '<script> alert("Phải chọn ít nhất 1 bài làm để xóa")</script>';
			} 
		
		}		
 		
		// vietth
		// check role
		$candelete = has_capability('mod/quiz:deleteattempts', $context);
		
		//chuc nang quizoffline chi dung cho loai quiz bt30 va bt72
		$sql = "select  tuaq.id tuaqid,u.id uid,
		concat_ws(' ',u.lastname,u.firstname ) hoten , tuaq.starttime start_time, tuaq.finishtime finish_time,tuaq.sumgrade diem,tuaq.quiz,tuaq.ma_de,tuaq.status,tuaq.type
		from 
		vietth_q169_attempts tuaq
		INNER join mdl_user u on u.id = tuaq.userid
		where tuaq.quiz=$quizid and tuaq.deleted =0 order by uid , start_time";	

		$ad=$mysqli->query($sql);
		//
		echo '
			<script language="JavaScript">
			function toggle(source) {
			  checkboxes = document.getElementsByName(\'idde[]\');
			  for each(var checkbox in checkboxes)
				checkbox.checked = source.checked;
			}
			function abc()
			{
			alert(111);
			return false;
			}
			function confirmSubmit()
			{

			var agree=confirm("Bạn chắc chắn muốn xóa ? ");
			if (agree)
				return true ;
			else
				return false ;
			}
			</script>';
		if($candelete)
			echo'
				<form action="" method="POST"  name="xoa">';
		echo '
			<style>
			tr:hover {
			background-color: #e1eafe;
			}
			</style>
					<table width="100%" border="1" style="border-collapse:collapse;" cellpadding="3"  >
			  <tr style="background:#EDEAE4;color:#810c15;white-space: nowrap;">
				<th >STT</th>
				<th >Họ tên học viên</th>
				<th>Bắt đầu vào lúc</th>
				<th>Được hoàn thành</th>
				<th>Trạng thái</th>
				<th>Điểm / 10</th>';
		if($candelete)
			echo '<th><input type="checkbox" onClick="toggle(this)" /></th>';
		for($i=1;$i<=$total_question;$i++)
		{
				echo '<th>#'.$i.'</th>'; 
		}
			
		echo '
		  </tr>';
  
        $j=1;
		while($dd = $ad->fetch_assoc()) 
		{
		  if($dd['uid']==$uid)
			$hoten='';
		  else 
			$hoten=$dd['hoten'];
		  
			 switch ($dd['status'])
			 {
				case 'inprogress':
				$status= 'Đang làm bài';
				break;

				case 'submited':
				$status= 'Đã nộp bài';
				break;

				case 'disconnected':
				$status= 'Mất kết nối ';
				break;
			}
			echo '
              <tr>
			    <td  align="center">'.$j.'</td>
			    
			    <td  align="center"><a href = "/user/view.php?id='.$dd['uid'].'&course=1">'.$hoten.'</td>
				  <td  align="center">'.$dd['start_time'].'</td>';
			  if ($dd['type']=='bt72')
				echo'
					<td  align="center"><a href ="/mod/bt72/quiz_attempt_review.php?attemptid='.$dd['tuaqid'].'" target="_blank">'.$dd['finish_time'].'</a></td>';
			  else if ($dd['type']=='bt30')
				echo'
					<td  align="center"><a href ="/mod/bt30/quiz_attempt_review.php?attemptid='.$dd['tuaqid'].'" target="_blank">'.$dd['finish_time'].'</a></td>';
			  else echo'
					<td  align="center"><a href ="#">'.$dd['finish_time'].'</a></td>';
			
			  echo'
				 <td align="center">'.$status.'</td>
			
			    <td align="center">'.$dd['diem'].'</td>';
			 if($candelete)
				echo '<td><input type="checkbox" name="idde[]" value="'.$dd['tuaqid'].'"></td>';
				// lay xem dap an la gi
				$sql_dap_an = "select answers,quest_ids from vietth_q169_de where id = ".$dd['ma_de'];
				$ad_dap_an=$mysqli->query($sql_dap_an);
				$dap_an = $ad_dap_an->fetch_assoc();
				$arr_dap_an = explode(",",$dap_an['answers']);
				$arr_quest = explode(",",$dap_an['quest_ids']);
				// lay xem hoc vien chon dap an gi
				$sql_hv_chon = "select answer from vietth_q169_answer where attempt = ".$dd['tuaqid'];
				$ad_hv_chon  = $mysqli->query($sql_hv_chon);
				$hv_chon     = $ad_hv_chon->fetch_assoc();
				$arr_hv_chon = explode(",",$hv_chon['answer']);
				
				//danglx 11-03-2014
				for($i=1;$i<=$total_question;$i++)
				 {
				 	$diem_1_cau = 10/$total_question;
					$sql_answer="SELECT * FROM mdl_question_answers WHERE mdl_question_answers.question='".$rows["id"]."' ";
					$result_answer=mysql_query($sql_answer);
					while($rows_answer=mysql_fetch_array($result_answer)){
						if($arr_hv_chon[$i-1]==$rows_answer["id"] and $rows_answer["fraction"]==1 and $arr_hv_chon[$i]!='undefined' )
						 {
						  $diemcau = round($diem_1_cau,2).'/'.round($diem_1_cau,2);
						 }
						 else
						  {
						  $diemcau = '0/'.round($diem_1_cau,2); 
						  }
						}
						echo ' <td align="center">';
					if ($dd["type"]=='bt72')
						echo '<a href="/mod/bt72/quiz_attempt_review.php?attemptid='.$dd['tuaqid'].'#'.$arr_quest[$i-1].'" target="_blank">';
					else if ($dd["type"]=='bt30')
						echo '<a href="/mod/bt30/quiz_attempt_review.php?attemptid='.$dd['tuaqid'].'#'.$arr_quest[$i-1].'" target="_blank">';
					else
						echo '<a href="#" target="_blank">';
					echo $diemcau;
					echo '</a></td>';
				}
				// end danglx
				/*
				for($i=1;$i<=$total_question;$i++)
				 {
      			     $diem_1_cau = 10/$total_question;
					 if($arr_dap_an[$i-1]==$arr_hv_chon[$i-1])
					 {
					  $diemcau = round($diem_1_cau,2).'/'.round($diem_1_cau,2);
					 }
					 else
					  {
					  $diemcau = '0/'.round($diem_1_cau,2); 
					  }
					echo ' <td align="center">';
					if ($dd["type"]=='bt72')
						echo '<a href="/mod/bt72/quiz_attempt_review.php?attemptid='.$dd['tuaqid'].'#'.$arr_quest[$i-1].'" target="_blank">';
					else if ($dd["type"]=='bt30')
						echo '<a href="/mod/bt30/quiz_attempt_review.php?attemptid='.$dd['tuaqid'].'#'.$arr_quest[$i-1].'" target="_blank">';
					else
						echo '<a href="#" target="_blank">';
					echo $diemcau;
					echo '</a></td>';
				 }
				*/
				echo '</tr>';
				
             $uid=  $dd['uid'];
             $j++; 
			}
		echo '</table>';
		// close
		$mysqli->close();
		if($candelete)
		echo '<br><br><div align="left"><input type="submit" name="btnxoa" value=" Xóa các lần làm đã chọn " onClick="return confirm(\'Bạn có chăc chắn xóa?\');"></div>
		</form>';	
        return true;
    }
}

?>