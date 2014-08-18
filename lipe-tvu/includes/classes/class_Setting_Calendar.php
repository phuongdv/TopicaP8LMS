<?
//this is b e t a version !
class Setting_Calendar extends DbBasic{
	
	function Setting_Calendar(){
		$this->pkey = "id";
		$this->tbl = "huy_setting_calendar";	
	}		
	
	function getRelationCalendarAndLipesetting($u_id,$id,$c_id) {
	
		global $dbconn;
		
		$sql2 = "select c.id,c.start_date,c.end_date,l.lipe_type,l.active_id from huy_setting_calendar c, huy_setting_lipe l where c.id = l.calendar_id and c.c_id= $c_id and c.id= $id;";
		
		/*select c.week_number,c.start_date,c.end_date,l.lipe_type,l.active_id from huy_setting_calendar c, huy_setting_lipe l where c.id = l.calendar_id and c.c_id = $c_id and c.week_number = $w_n;";*/
	//	echo $sql2.'<br>';
		//die($sql);
		$res = $dbconn->GetAll($sql2);
		if(is_array($res)) {
			$variable = ($res[0]["lipe_type"]=='I')? $this->countPostInWeek($u_id, date('Y-m-d',$res[0]["start_date"]), date('Y-m-d',$res[0]["end_date"]), $res[0]["active_id"]) : 0;
		}
		
		return $variable;
	}
	
	function countPostInWeek($u_id,$start,$end,$active_id) {
		global $dbconn;
		
		$sql = "select count(id) from mdl_forum_posts where created BETWEEN UNIX_TIMESTAMP('$start') and UNIX_TIMESTAMP('$end') and discussion in (select id from mdl_forum_discussions where forum = $active_id) and userid = $u_id";
		
		
		/*new
		$sql="Select count(frp.id) from mdl_forum_posts frp
where frp.userid = $u_id
and
frp.created BETWEEN
 UNIX_TIMESTAMP('$start') and UNIX_TIMESTAMP('$end')";
	*/
		$res = $dbconn->GetAll($sql);
		
		$result_count = is_array($res)? $res[0]["count(id)"] : 0;
		
		return $result_count;
		
		
	}
	
	//Dien dan VBB
	# Creat by : TrungVQ
	# Time : 31/01/2010
	
	//Dien dan VBB
	# Modifi by : VietTh
	# Time : 18/10/2011
	
	
	function getRelationCalendarAndLipesettingVBB($username,$id,$c_id) {

		global $dbconn;
		
		$sql2 = "select c.id,c.start_date,c.end_date,l.lipe_type,l.active_id from huy_setting_calendar c, huy_setting_lipe l where c.id = l.calendar_id and c.c_id= $c_id and c.id= $id and l.lipe_type='V'";
		

		$res = $dbconn->GetAll($sql2);
		if(is_array($res)) {
			//$variable = ($res[0]["lipe_type"]=='V')? $this->countPostInWeekVBB($username, date('Y-m-d',$res[0]["start_date"]), date('Y-m-d',$res[0]["end_date"]), $res[0]["active_id"]) : 0;
			$variable = $this->countPostInWeekVBB($username, date('Y-m-d',$res[0]["start_date"]), date('Y-m-d',$res[0]["end_date"]), $res[0]["active_id"]);
			//print_r($variable);die();
		}
		else
		{
		$variable=0;
		}
		return $variable;
		//return $sql2;
	}
	
	function countPostInWeekVBB($username,$start,$end,$active_id) {
		// Moi
		/*
				$start_date= strtotime($start);
		$end_date=strtotime($end);
		*/
		//return 0;
	
		$start_date=$start.' 00:00:00';
		$end_date= $end.' 00:00:00';
		
		$link= mysql_connect("192.168.79.2","c5forumtvu","viet123");
		mysql_select_db("c5forumtvu");
		
		$sql="select count(vp.postid) from vbb_post vp,vbb_thread vt where (vp.dateline > UNIX_TIMESTAMP('$start_date') and vp.dateline < UNIX_TIMESTAMP('$end_date'))and vp.username= '".$username."' and vp.threadid=vt.threadid and vt.forumid = $active_id";

		$data = mysql_query($sql) ;
        $info = mysql_fetch_array( $data ); 
		$result_count = is_array($info)? $info["count(vp.postid)"] : 0;
        return $result_count;
 
		
		// cu
		/* global $dbconn;
		    $start_date= strtotime($start);
		    $end_date=strtotime($end);
		    $sql="select count(vp.postid) from vbb_post vp,vbb_thread vt where (vp.dateline > '$start_date' and vp.dateline < '$end_date') and vp.username= '".$username."' and vp.threadid=vt.threadid and vt.forumid= $active_id";
            $res = $dbconn->GetAll($sql);
            $result_count = is_array($res)? $res[0]["count(vp.postid)"] : 0;
            return $result_count; 
           */ 

		
	}
	
	function countPostInWeekH2472($c_id,$start,$end,$userid) {
		global $dbconn;
		
			$sql = "select count(id) from tblanswer where courseid='".$c_id."' and userid='".$userid."' and time BETWEEN '".$start."' and '".$end."'  ";
	//print_r($sql);die(); 
		
		
		$res = $dbconn->GetAll($sql);
		
		$result_count = is_array($res)? $res[0]["count(id)"] : 0;
		
		return $result_count;
		//return $sql;
		
		
	}
	
	//End dien dan VBB
	
	function getRelationCalendarAndLipesettingGrades($u_id,$id,$c_id) {
		global $dbconn;
		
		//$sql3 = "select c.id,c.start_date,c.end_date,l.lipe_type,l.active_id from huy_setting_calendar c, huy_setting_lipe l where c.id = l.calendar_id and c.c_id= $c_id and c.id= $id and l.lipe_type = 'E' order by l.id desc limit 0,1";
	      $sql3 = "select l.active_id from huy_setting_calendar c, huy_setting_lipe l where c.id = l.calendar_id and c.c_id= $c_id and c.id= $id and l.lipe_type = 'E' ";
	//	echo $sql3;
			
		
		$res = $dbconn->GetAll($sql3);
		//if($c_id==1970 || $c_id == 2283 || $c_id==2286)
		$variable = $this->GradesInWeektest($u_id,$res); 
	//	else 
	//	$variable = $this->GradesInWeekfix($u_id,$res); 
		//print_r($arr_activeid);
		// if(is_array($res)) 
		// {
		// $variable = $this->GradesInWeek($u_id,$res[0]["active_id"]);
		// }
		return $variable;
	}
	
	
	// for q169 test only
	function GradesInWeektest($u_id,$arr_active_id) {
		global $dbconn;

		$clsQuizGrades = new QuizGrades();	
        $max_grade=0;
		$max_grade_moodle=0;
		foreach($arr_active_id as $actvid)
		{
			$active_id=$actvid['active_id'];
			//echo $active_id;
			$res = $clsQuizGrades->getAll("quiz = $active_id and userid = $u_id");	
			$sql_quiz= "select grademethod from mdl_quiz where id = $active_id";
			$res_quiz = $dbconn->GetAll($sql_quiz);
			$grade_method = $res_quiz[0]['grademethod'];
			if($grade_method==1)
			{
				$sql_grade = "select max(sumgrade) grade from vietth_q169_attempts where quiz = $active_id and userid = $u_id and deleted=0 and status='submited'";      	
				$res_grade = $dbconn->GetAll($sql_grade);
				$grade_q168 = $res_grade[0]['grade'];  			    
			}		
					elseif($grade_method==2)
			{
	$sql_grade = "select round(avg(sumgrade),2) grade from vietth_q169_attempts where quiz = $active_id and userid = $u_id and deleted=0 and status='submited'";
	//echo $sql_grade;
				$res_grade = $dbconn->GetAll($sql_grade);
				$grade_q168 = $res_grade[0]['grade'];  	
			}
			if($grade_q168=='' || $grade_q168 < $res[0]['grade'] ){	
                   if($res[0]['grade']>$max_grade){
                   $max_grade=$res[0]['grade'];		
				   }
		    }
			else 	
            {	
                 if($grade_q168 > $max_grade){
                  $max_grade= $grade_q168;
				 }			 	 
			}
			
			//check moodle quiz;
			$sql = "select grade from mdl_quiz_grades where quiz = $active_id and userid = $u_id";
			$res_moodle_grade = $dbconn->GetAll($sql);
			$grade_moodle = $res_moodle_grade[0]['grade'];  
            if($grade_moodle > $max_grade_moodle){
                  $max_grade_moodle= $grade_moodle;
				 }			 			
		}
		if($max_grade_moodle <$max_grade)
		return $max_grade;
		else
		return $max_grade_moodle;
		
	} 
	
	
function getRelationCalendarAndLipesettingGrades_dang($u_id,$id,$c_id) {
		global $dbconn;
		
		//$sql3 = "select c.id,c.start_date,c.end_date,l.lipe_type,l.active_id from huy_setting_calendar c, huy_setting_lipe l where c.id = l.calendar_id and c.c_id= $c_id and c.id= $id and l.lipe_type = 'E' order by l.id desc limit 0,1";
	      $sql3 = "select l.active_id from huy_setting_calendar c, huy_setting_lipe l where c.id = l.calendar_id and c.c_id= $c_id and c.id= $id and l.lipe_type = 'E' ";
	//	echo $sql3;
			
		
		$res = $dbconn->GetAll($sql3);
		//if($c_id==1970 || $c_id == 2283 || $c_id==2286)
		$variable = $this->GradesInWeektest_dang($u_id,$res); 
	//	else 
	//	$variable = $this->GradesInWeekfix($u_id,$res); 
		//print_r($arr_activeid);
		// if(is_array($res)) 
		// {
		// $variable = $this->GradesInWeek($u_id,$res[0]["active_id"]);
		// }
		return $variable;

	}
	
function GradesInWeektest_dang($u_id,$arr_active_id) {
		global $dbconn;

		$clsQuizGrades = new QuizGrades();	
        $max_grade='';
		$max_grade_moodle='';
		foreach($arr_active_id as $actvid)
		{
			$active_id=$actvid['active_id'];
			//echo $active_id;
			$res = $clsQuizGrades->getAll("quiz = $active_id and userid = $u_id");	
			$sql_quiz= "select grademethod from mdl_quiz where id = $active_id";
			$res_quiz = $dbconn->GetAll($sql_quiz);
			$grade_method = $res_quiz[0]['grademethod'];
			if($grade_method==1)
			{
				$sql_grade = "select max(sumgrade) grade from vietth_q169_attempts where quiz = $active_id and userid = $u_id and deleted=0 and status='submited'";      	
				$res_grade = $dbconn->GetAll($sql_grade);
				$grade_q168 = $res_grade[0]['grade'];  			    
			}		
					elseif($grade_method==2)
			{
	$sql_grade = "select round(avg(sumgrade),2) grade from vietth_q169_attempts where quiz = $active_id and userid = $u_id and deleted=0 and status='submited'";
	//echo $sql_grade;
				$res_grade = $dbconn->GetAll($sql_grade);
				$grade_q168 = $res_grade[0]['grade'];  	
			}
			
			//if($grade_q168=='' || $grade_q168 < $res[0]['grade'] ){	
			if($grade_q168 < $res[0]['grade'] ){	
                   //if($res[0]['grade']>$max_grade){
				    if($res[0]['grade']!= $max_grade){
                   $max_grade=$res[0]['grade'];		
				   }
		    }
			
			else 	
            {	
                 //if($grade_q168 > $max_grade){
				 if($grade_q168 != $max_grade){
                  $max_grade= $grade_q168;
				 }			 	 
			}
			
			//check moodle quiz;
			$sql = "select grade from mdl_quiz_grades where quiz = $active_id and userid = $u_id";
			$res_moodle_grade = $dbconn->GetAll($sql);
			$grade_moodle = $res_moodle_grade[0]['grade'];  
            if($grade_moodle > $max_grade_moodle){
                  $max_grade_moodle= $grade_moodle;
				 }			 			
		}
		
		if($max_grade_moodle <$max_grade)
		return $max_grade;
		else
		return $max_grade_moodle; 
		
	}
	
	
	
	
	function GradesInWeekfix($u_id,$arr_active_id) {
		global $dbconn;

		$clsQuizGrades = new QuizGrades();	
        $max_grade=0;
		$max_grade_moodle=0;
		foreach($arr_active_id as $actvid)
		{
			$active_id=$actvid['active_id'];
			//echo $active_id;
			$res = $clsQuizGrades->getAll("quiz = $active_id and userid = $u_id");	
			$sql_quiz= "select grademethod from mdl_quiz where id = $active_id";
			$res_quiz = $dbconn->GetAll($sql_quiz);
			$grade_method = $res_quiz[0]['grademethod'];
			if($grade_method==1)
			{
				$sql_grade = "select max(mark) grade from tbl_user_answer_quiz where quiz_id = $active_id and user_id = $u_id";      	
				$res_grade = $dbconn->GetAll($sql_grade);
				$grade_q168 = $res_grade[0]['grade'];  			    
			}		
					elseif($grade_method==2)
			{
				$sql_grade = "select round(avg(mark),2) grade from tbl_user_answer_quiz where quiz_id = $active_id and user_id = $u_id";
				$res_grade = $dbconn->GetAll($sql_grade);
				$grade_q168 = $res_grade[0]['grade'];  	
			}
			if($grade_q168=='' || $grade_q168 < $res[0]['grade'] ){	
                   if($res[0]['grade']>$max_grade){
                   $max_grade=$res[0]['grade'];		
				   }
		    }
			else 	
            {	
                 if($grade_q168 > $max_grade){
                  $max_grade= $grade_q168;
				 }			 	 
			}
			
			//check moodle quiz;
			$sql = "select grade from mdl_quiz_grades where quiz = $active_id and userid = $u_id";
			$res_moodle_grade = $dbconn->GetAll($sql);
			$grade_moodle = $res_moodle_grade[0]['grade'];  
            if($grade_moodle > $max_grade_moodle){
                  $max_grade_moodle= $grade_moodle;
				 }			 			
		}
		if($max_grade_moodle <$max_grade)
		return $max_grade;
		else
		return $max_grade_moodle;
		
	} 
	
	
	function GradesInWeek($u_id,$active_id) {
		global $dbconn;
		
		//$sql4 = "select grade from mdl_quiz_grades where quiz = $active_id and userid = $u_id";
		//die($sql4);
		//$res = $dbconn->GetOne($sq4);
		$clsQuizGrades = new QuizGrades();		
		$res = $clsQuizGrades->getAll("quiz = $active_id and userid = $u_id");
		// add if q168	
		$sql_quiz= "select grademethod from mdl_quiz where id = $active_id";
		$res_quiz = $dbconn->GetAll($sql_quiz);
		$grade_method = $res_quiz[0]['grademethod'];
        if($grade_method==1)
        {
        	$sql_grade = "select max(mark) grade from tbl_user_answer_quiz where quiz_id = $active_id and user_id = $u_id";      	
        	$res_grade = $dbconn->GetAll($sql_grade);
		    $grade_q168 = $res_grade[0]['grade'];  			    
        }		
                elseif($grade_method==2)
        {
        	$sql_grade = "select round(avg(mark),2) grade from tbl_user_answer_quiz where quiz_id = $active_id and user_id = $u_id";
        	$res_grade = $dbconn->GetAll($sql_grade);
		    $grade_q168 = $res_grade[0]['grade'];  	
        }
		if($grade_q168=='' || $grade_q168 < $res[0]['grade'] )		 
		return $res[0]['grade'];		
		else 		
		return  $grade_q168;
	}
	function GradesInWeek2($u_id,$active_id,$start,$end) {
		global $dbconn;
		$end_date=$end_date+(60*60*7)+(60*60*24)-1;
		$start_date=$start_date +(60*60*7);
		//$sql4 = "select grade from mdl_quiz_grades where quiz = $active_id and userid = $u_id and timemodified BETWEEN $start and $end";
		//die($sql4);
		//$res = $dbconn->GetOne($sq4);
		$clsQuizGrades = new QuizGrades();		
		$res = $clsQuizGrades->getAll("quiz = $active_id and userid = $u_id and timemodified BETWEEN $start and $end");
		//print_r($res);die();
		return $res[0]['grade'];
		//  return $active_id;
		
		//return $res["name"];
		//$result_grades = $res["grade"];
		
		//return $result_grades;
	}
	function GetActiveID($c_id) {
		global $dbconn; 
		$clsSettingLipe = new Setting_Lipe();		
		$res = $clsSettingLipe->getAll("c_id= $c_id and lipe_type = 'P'");
		//die($res);
		return $res[0]['active_id'];
		
	}
	function GetActiveID_E($c_id) {
		global $dbconn; 
		$clsSettingLipe = new Setting_Lipe();		
		$res = $clsSettingLipe->getAll("c_id= $c_id and lipe_type = 'E'");
		//die($res);
		return $res[0]['active_id'];
		
	}
	function GetActiveID_V($c_id) {
		global $dbconn; 
		$clsSettingLipe = new Setting_Lipe();		
		$res = $clsSettingLipe->getAll("c_id= $c_id and lipe_type = 'V'");
		//die($res);
		return $res[0]['active_id'];
		
	}
	function GetGradeFromAssignment ($u_id,$activeID){
		global $dbconn;
			$sql5 = "select * from mdl_assignment_submissions where assignment= $activeID and userid = $u_id";
			//die($sql5);
		$res = $dbconn->GetAll($sql5);
		return $res[0]['grade'];
	}
	// dang dung
	function CountPractice2($c_id,$id,$u_id)
	{
	
	 global $dbconn;	
		$sqlPractice="Select count(grade) count
		from mdl_quiz_grades
		where
		quiz in (select active_id from huy_setting_lipe where lipe_type='P' and c_id =$c_id and calendar_id=$id)
		and userid=$u_id";
	 $res = $dbconn->GetAll($sqlPractice);
		
		$result_count = is_array($res)? $res[0]["count"] : 0;
		//return $sqlPractice;
		return $result_count;
	}
	
	function CountPractice ($u_id,$c_id,$start_date,$end_date) {
		global $dbconn;
		$end_date=$end_date+3600;
		//$start_date=$start_date +(60*60*7)+(60*60*24)-1;
		$sql6_goc = "select count(*) count
		from mdl_quiz_grades q
		where
		 q.quiz in (select active_id from huy_setting_lipe where lipe_type='P' and calendar_id in(select id from huy_setting_calendar where c_id= $c_id))
		and userid=$u_id
		and timemodified between $start_date and $end_date
		";
		// vietth fix bug 27-09-2012 loi khi xoa bang quizattemp
		$sql5 = "select count(DISTINCT quiz) count from mdl_quiz_attempts q 
		INNER join mdl_quiz quiz on q.quiz=quiz.id
		where
        q.quiz in (select active_id from huy_setting_lipe where lipe_type='P' and calendar_id in(select id from huy_setting_calendar where c_id= $c_id))
		and q.userid=$u_id
		and (q.sumgrades/quiz.sumgrades)*10 >=5
		and q.timemodified between $start_date and $end_date 
		";
		$res = $dbconn->GetAll($sql5);
		$result_count_attempt = is_array($res)? $res[0]["count"] : 0;
		
		
		
		$sql6="SELECT
	count(DISTINCT quiz)count
FROM
	mdl_quiz_grades qg
INNER JOIN mdl_quiz quiz ON qg.quiz = quiz.id
WHERE
	qg.quiz IN(
		SELECT
			active_id
		FROM
			huy_setting_lipe
		WHERE
			lipe_type = 'P'
		AND calendar_id IN(
			SELECT
				id
			FROM
				huy_setting_calendar
			WHERE
				c_id = $c_id
		)
	)
AND qg.userid = $u_id
AND qg.grade >= 5
AND qg.timemodified BETWEEN $start_date
AND $end_date";


		//echo $sql6;
		$res = $dbconn->GetAll($sql6);
	// get q168 grade
        
		$sql7="SELECT
					count(DISTINCT quiz)count
				FROM
					vietth_q169_attempts
				WHERE
					quiz in (select active_id from huy_setting_lipe where lipe_type='P' and calendar_id in(select id from huy_setting_calendar where c_id= $c_id))
				AND userid = $u_id
				AND sumgrade >= 5
				AND date(finishtime) > DATE(FROM_UNIXTIME($start_date))  
				AND date(finishtime) <= DATE(FROM_UNIXTIME($end_date))";
				
				//AND UNIX_TIMESTAMP(finishtime) BETWEEN $start_date
				//AND $end_date";
		$res168 = $dbconn->GetAll($sql7);
		if($res168[0]['count']>0)
		{
		 //return $sql7;
		// return $res168[0]['count'];
		}
         	
		
		$result_count = is_array($res)? $res[0]["count"] : 0;
		
		if($result_count_attempt==0)
		return $result_count+$res168[0]['count'];
		else
		return $result_count_attempt+$res168[0]['count'];
		
	}

//Cai nay de dem so bai lt co diem lon hon hoac bang 5 theo yeu cau tinh diem chuyen can ngay 30-03-2010
   
	function CountPracticeCC ($u_id,$c_id) {
		global $dbconn;
		
		$sql6 = "select count(*) 
		from mdl_quiz_grades q
		where
		 q.quiz in (select active_id from huy_setting_lipe where lipe_type='P' and calendar_id in(select id from huy_setting_calendar where c_id= $c_id))
		and userid=$u_id and q.grade >= 5";
	   $res = $dbconn->GetAll($sql6);
		
		$result_count = is_array($res)? $res[0]["count(*)"] : 0;
		
		return $result_count;

		
	}


	function CountPracticeCC2 ($u_id,$c_id,$start_date,$end_date) {
		global $dbconn;
		$end_date=$end_date+(60*60*7)+(60*60*24)-1;
		$start_date=$start_date +(60*60*7);
		$sql6 = "select count(*) 
		from mdl_quiz_grades q
		where
		 q.quiz in (select active_id from huy_setting_lipe where lipe_type='P' and calendar_id in(select id from huy_setting_calendar where c_id= $c_id))
		and userid=$u_id and q.grade >= 5
		and q.timemodified beetwen $startdate and $enddate";
		// moi dung cai nay
		
		$sql6="select count(DISTINCT quiz) count from mdl_quiz_attempts q 
		where
		 q.quiz in (select active_id from huy_setting_lipe where lipe_type='P' and calendar_id in(select id from huy_setting_calendar where c_id= $c_id))
		and userid=$u_id
		and q.sumgrades >= 5
		and timemodified between $start_date and $end_date ";
	   $res = $dbconn->GetAll($sql6);
		
		$result_count = is_array($res)? $res[0]["count"] : 0;
		
		return $result_count;
       // return  $sql6;
		
	}



	function CountPracticeWeek($u_id,$c_id,$start_date,$end_date)
	{
		$end_date=$end_date+(60*60*7)+(60*60*24)-1;
		$start_date=$start_date +(60*60*7);
		global $dbconn;
		$sql7="select count(*) 
		       from mdl_quiz_grades 
		       where userid = $u_id
			   and quiz in 
		       (select id from mdl_quiz where course= $c_id and name LIKE '%luyện tập%' and timemodified BETWEEN $start_date and $end_date)";
		       
		$res = $dbconn->GetAll($sql7);
		
		$result_count = is_array($res)? $res[0]["count(*)"] : 0;
		
		return $result_count;
        //return $sql7;
		
		
	}
	// get lop tren giay to - create by vietth
    function GetClass($c_id)
	{
    global $dbconn;
    /*
	$sqlClass="select distinct u.topica_lop
				from
				mdl_user u,
				mdl_course_display c
				where
				c.course= $c_id
				and
				c.userid=u.id
				and u.id not in (select userid from mdl_role_assignments where roleid in (1,2,3,4,8) )";
				*/
	$sqlClass=" SELECT distinct u.topica_lop
				FROM mdl_user u
				INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
				INNER JOIN mdl_context ct ON ct.id = ra.contextid
				INNER JOIN mdl_course c ON c.id = ct.instanceid
				INNER JOIN mdl_role r ON r.id = ra.roleid
				INNER JOIN mdl_course_categories cc ON cc.id = c.category
				
				WHERE  c.id=$c_id
				and r.id=5";
	$res = $dbconn->GetAll($sqlClass);
    return $res;
	}
	//dem so bai kiem tra da lam-create by vietth
	function CountExam($u_id,$c_id)
	{
	global $dbconn;
	/*$sqlEx="select count(*) 
			from mdl_quiz_grades q,huy_setting_lipe h,huy_setting_calendar c
			where
			h.calendar_id=c.id
			and
			q.quiz=h.active_id
			and 
			c.c_id=$c_id
			and
			q.userid=$u_id
			and
			q.timemodified between c.start_date and c.end_date
			";
			*/
			
    $t=$sqlEx;			
	$sqlEx="select count(*) 
from mdl_quiz_grades q
where
 q.quiz in (select active_id from huy_setting_lipe where lipe_type='E' and calendar_id in(select id from huy_setting_calendar where c_id= $c_id))
and userid=$u_id";
		$res = $dbconn->GetAll($sqlEx);
		
	// bo sung q168
$sql_q168 = "select COUNT(DISTINCT quiz) count from vietth_q169_attempts where quiz in (SELECT
			active_id
		FROM
			huy_setting_lipe
		WHERE
			lipe_type = 'E'
		AND calendar_id IN(
			SELECT
				id
			FROM
				huy_setting_calendar
			WHERE
				c_id = $c_id))
and userid = $u_id and deleted=0 and status='submited' ";	
         
         $q168_count = $dbconn->GetAll($sql_q168);
		
		$result_count = is_array($res)? $res[0]["count(*)"] : 0;
		$result_count_168=is_array($q168_count)? $q168_count[0]["count"] : 0;
        
		//if($result_count=="0")
		//return $result_count_168;
		//else 
		return $result_count+$result_count_168;

		}
	function QuizPerWeek($c_id,$id)
	{
		global $dbconn;
		$sqlqpw="Select count(id) count
from mdl_quiz
where
id in (select active_id from huy_setting_lipe where lipe_type='P' and c_id =$c_id and calendar_id=$id)
";
		$res = $dbconn->GetAll($sqlqpw);
		
		$result_count = is_array($res)? $res[0]["count"] : 0;
		//return $sqlqpw;
		return $result_count;
		
		
		
	}
	function QuizPerWeek2($c_id,$start_date,$end_date)
	{
		$end_date=$end_date+(60*60*7)+(60*60*24)-1;
		$start_date=$start_date +(60*60*7);
		global $dbconn;
		$sqlqpw="select count(*) 
                from mdl_quiz
                where
                course=$c_id
				and name LIKE '%luyện tập%'
				and timemodified between $start_date and $end_date";
		$res = $dbconn->GetAll($sqlqpw);
		
		$result_count = is_array($res)? $res[0]["count(*)"] : 0;
		//return $sqlqpw;
		return $result_count;
		
		
		
		
	}
	
	function get2472($u_id,$c_id,$start_time,$end_time)
	{
	global $dbconn;
	$sql="select count(*) from tblthread where userid='".$u_id."' and courseid='".$c_id."' and time between '".$start_time."' and '".$end_time."'";	
	$res = $dbconn->GetAll($sql);
    $result_count = is_array($res)? $res[0]["count(*)"] : 0;
	//return $sql;
		return $result_count;	
		
	}
	
	
	
	
	
	function ConvertDateGMT($a)
	 {
		//$a = $a (60*60*24);
		
		return $a;
	}
 
 	function getCalendarInLipeCN($c_id){
		global $dbconn;
		$sql="select id,week_name,start_date,end_date from huy_setting_calendar where c_id=$c_id";
		$res = $dbconn->GetAll($sql);
		
		return $res;
	}
	
	function checkDoQuiz($user_id,$quiz_id){
		global $dbconn;
		$sqlEx="select count(*) 
				from mdl_quiz_grades q
				where
 				q.quiz = $quiz_id
				and userid=$user_id";
		//print_r($sqlEx);die();		
		$res = $dbconn->GetAll($sqlEx);
		
		$result_count = is_array($res)? $res[0]["count(*)"] : 0;
		
		if($result_count>0)
			return 1;
		else
			return 0;
		//return $t;
		//return $result_count;
		
	}
 
} 
?>
