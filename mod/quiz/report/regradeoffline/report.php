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
            $this->print_header_and_tabs($cm, $course, $quiz, "regradeoffline");
        } 
		
		$mysqli = mysql_connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
mysql_select_db($CFG->dbname);
mysql_query("SET NAMES 'utf8'");
$quizid = $_GET['q'];
// get all 
         // get quiz limit time - ingore if expried time
		 $sql_quiz = "select * from mdl_quiz where id = ".$quizid;
         $ad_quiz = mysql_query($sql_quiz);
		 while($dd_quiz = mysql_fetch_assoc($ad_quiz)) 
		 {
		  $quiz_limit_time = $dd_quiz['timelimit']*60;
		 }
		 $sql="select *,u.id uid,q.id attid,q.type from vietth_q169_attempts q 
               INNER join mdl_user u on u.id=q.userid where quiz = $quizid and q.deleted!=1 and q.finishtime !='' ";
		
$ad = mysql_query($sql);
?>
<table width="100%" border="1">
  <tbody>
    <tr>
    <th width="10%">STT</th>
    <th width="35%">Họ tên học viên</th>
    <th width="30%">Thời gian làm bài</th>
    <th width="10%">Điểm cũ </th>
	<th width="15%">Điểm mới</th>
  </tr>
<?php
        $stt=1; 
		while($dd = mysql_fetch_assoc($ad)) 
		{
		  if($dd['uid']==$uid)
			  	$hoten='';
			  else 
			    $hoten=$dd['lastname'].' '.$dd['firstname'];
		 $mark=0;
		 // get questions id
		 $sql2= 'select quest_ids from vietth_q169_de where id = '.$dd['ma_de'];
		// echo $sql2;
		$ad2 = mysql_query($sql2);
        $dd2 = mysql_fetch_assoc( $ad2);
		$question_ids=$dd2['quest_ids'];
		// get userchoice
		$sql22 = "select * from vietth_q169_answer where attempt = '".$dd['attid']."'";

		$ad22 = mysql_query($sql22);
        $dd22 = mysql_fetch_assoc( $ad22);		
		$userchoice = $dd22['answer'];
		if ($userchoice!='')
		 {
		$arr_question = explode(',',$question_ids);
		$arr_userchoice = explode(',',$userchoice);
		
		$total_quest = count($arr_question)-1;
        for($i=0;$i<count($arr_question)-1;$i++)
		 {
		// echo $arr_question[$i];
		 $sql3="SELECT * FROM mdl_question_answers WHERE question=".$arr_question[$i]." and fraction =1";
		 $ad3 = mysql_query($sql3);
         $dd3 = mysql_fetch_assoc($ad3);
		 
		 
		 
		 if ($arr_question[$i]==1145315)
		 {
		  echo count($dd3);
		  print_r($dd3);
		 }
		 if($dd3['id']==$arr_userchoice[$i] )
		 {
		  
		  $mark++;
		  
		 }
		 
		 }
		 
		$diem=round(($mark/$total_quest),2)*10;
		
		$sql_update="update vietth_q169_attempts set sumgrade='$diem',corrects=$mark where id =".$dd['attid'];
		if($diem < $dd['sumgrade'])
		  {
		  $alert = ' (*)';
		  }
           
		  else if($quiz_limit_time > 0 &&  (strtotime($dd["finishtime"]) - (strtotime($dd["starttime"])+10))- $quiz_limit_time>=0)
		{
		  $alert.='(**)';
		}
				else
          {		
		   mysql_query($sql_update);
		   $alert = '';
		  }
		//echo $dd['lastname'].' '.$dd['firstname'].'&nbsp &nbsp'.$dd['mark'].' '.$mark.' '.$diem.'  '.$total_quest.' '.$error.'<br>';
		echo '
		     <tr>
				<td align="center">'.$stt.'</td>
				<td align="center">'.$hoten.'</td>';
			if ($dd['type']=='bt72')
				echo'
					<td  align="center"><a href ="/mod/bt72/quiz_attempt_review.php?attemptid='.$dd['attid'].'" target="_blank">'.$dd['finishtime'].'</a></td>';
			else if ($dd['type']=='bt30')
				echo'
					<td  align="center"><a href ="/mod/bt30/quiz_attempt_review.php?attemptid='.$dd['attid'].'" target="_blank">'.$dd['finishtime'].'</a></td>';
			else echo'
					<td  align="center"><a href ="#">'.$dd['finish_time'].'</a></td>';
			echo '

				<td align="center">'.$dd['sumgrade'].'</td>
				<td align="center">'.$diem.$alert.'</td>
			  </tr>
		';
		}
		else
		{
		$error = "Không tìm thấy lịch sử làm bài";
		echo '
		     <tr>
				<td align="center">'.$stt.'</td>
				<td align="center">'.$hoten.'</td>
				<td align="center"><a href="/mod/quiz/quiz_attempt_detail.php?qid=17093&id='.$dd['static_id'].'&key='.$dd['key'].'">'.$dd['join_date'].'</a></td>
				<td colspan="2" align="center">'.$error.'</td>
			  </tr>
		';
		}
		$stt++;
		$uid =  $dd['uid'];
    	}
		echo '</tbody></table>';
		echo '<div align="center">Đã hoàn thành update điểm !<br> (*) : Không update do điểm cũ thấp hơn hoặc bằng điểm mới.<br>(**) : Không update do bài làm quá hạn cho phép</div>';
			
        return true;
		
		
		
    } 
}

?>
