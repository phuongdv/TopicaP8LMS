<?php // $Id: index.php,v 1.26.2.9 2008/08/17 20:18:52 skodak Exp $

///////////////////////////////////////////////////////////////////////////
// NOTICE OF COPYRIGHT                                                   //
//                                                                       //
// Moodle - Modular Object-Oriented Dynamic Learning Environment         //
//          http://moodle.org                                            //
//                                                                       //
// Copyright (C) 1999 onwards  Martin Dougiamas  http://moodle.com       //
//                                                                       //
// This program is free software; you can redistribute it and/or modify  //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation; either version 2 of the License, or     //
// (at your option) any later version.                                   //
//                                                                       //
// This program is distributed in the hope that it will be useful,       //
// but WITHOUT ANY WARRANTY; without even the implied warranty of        //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         //
// GNU General Public License for more details:                          //
//                                                                       //
//          http://www.gnu.org/copyleft/gpl.html                         //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

require_once '../../../config.php';
require_once $CFG->libdir.'/gradelib.php';
require_once $CFG->dirroot.'/grade/lib.php';
require_once $CFG->dirroot.'/grade/report/user/lib.php';

$courseid = required_param('id');
$userid   = optional_param('userid', $USER->id, PARAM_INT);

/// basic access checks
if (!$course = get_record('course', 'id', $courseid)) {
    print_error('nocourseid');
}
require_login($course);

$context     = get_context_instance(CONTEXT_COURSE, $course->id);
require_capability('gradereport/user:view', $context);

if (empty($userid)) {
    require_capability('moodle/grade:viewall', $context);

} else {
    if (!get_complete_user_data('id', $userid)) {
        error("Incorrect userid");
    }
}

$access = true;
if (has_capability('moodle/grade:viewall', $context)) {
    //ok - can view all course grades

} else if ($userid == $USER->id and has_capability('moodle/grade:view', $context) and $course->showgrades) {
    //ok - can view own grades

} else if (has_capability('moodle/grade:viewall', get_context_instance(CONTEXT_USER, $userid)) and $course->showgrades) {
    // ok - can view grades of this user- parent most probably

} else {
    $access = false;
}

/// return tracking object
$gpr = new grade_plugin_return(array('type'=>'report', 'plugin'=>'user', 'courseid'=>$courseid, 'userid'=>$userid));

/// last selected report session tracking
if (!isset($USER->grade_last_report)) {
    $USER->grade_last_report = array();
}
$USER->grade_last_report[$course->id] = 'user';

/// Build navigation
$strgrades  = get_string('grades');
$reportname = get_string('modulename', 'gradereport_user');

$navigation = grade_build_nav(__FILE__, $reportname, $courseid);

/// Print header
print_header_simple($strgrades.': '.$reportname, ': '.$strgrades, $navigation,
                    '', '', true, '', navmenu($course));

/// Print the plugin selector at the top
print_grade_plugin_selector($courseid, 'report', 'user');


if ($access) {

    //first make sure we have proper final grades - this must be done before constructing of the grade tree
    grade_regrade_final_grades($courseid);

    if (has_capability('moodle/grade:viewall', $context)) { //Teachers will see all student reports
        /// Print graded user selector at the top
        echo '<div id="graded_users_selector">';
        print_graded_users_selector($course, 'report/user/index.php?id=' . $course->id, $userid);
        echo '</div>';
        echo "<p style = 'page-break-after: always;'></p>";

        if ($userid === 0) {
            $gui = new graded_users_iterator($course);
            $gui->init();
            while ($userdata = $gui->next_user()) {
                $user = $userdata->user;
                $report = new grade_report_user($courseid, $gpr, $context, $user->id);
                print_heading(get_string('modulename', 'gradereport_user'). ' - '.fullname($report->user));
                if ($report->fill_table()) {
                    echo $report->print_table(true);
                }
                echo "<p style = 'page-break-after: always;'></p>";
            }
            $gui->close();
        } elseif ($userid) { // Only show one user's report
            $report = new grade_report_user($courseid, $gpr, $context, $userid);
            print_heading(get_string('modulename', 'gradereport_user'). ' - '.fullname($report->user));
            if ($report->fill_table()) {
                echo $report->print_table(true);
            } 
        }
    } else { //Students will see just their own report 
	
		if(course_have_bt72($COURSE->id)==1){
			$report = new grade_report_user($courseid, $gpr, $context, $userid);
			print_heading(get_string('modulename', 'gradereport_user'). ' - '.fullname($report->user));
			// connect DB
			$mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
			$mysqli->select_db($CFG->dbname);
			$mysqli->query("SET NAMES 'utf8'");		  

			// get quiz for current course
			$sql  = "select q.id,q.`name`,q.grademethod,cm.id cmid,q.quiz_type_apply from mdl_quiz q 
				INNER JOIN mdl_course_modules   cm
				on cm.instance = q.id
				where cm.course = ".$COURSE->id;
			$rc = $mysqli->query($sql);
			$arr_quiz = array();
			if (mysqli_num_rows($rc) > 0){
				while($dd = $rc->fetch_assoc()) 
				{
					$arr_quiz[]=$dd;
				}
			}

		  echo '<table cellspacing="0" class="flexible boxaligncenter generaltable" id="user-grade">
		         <tbody>
				  <tr>
				  <th scope="col" class="header c0">Các bài tập<div class="commands"></div></th>
				  <th scope="col" class="header c1">Khóa học<div class="commands"></div></th>
				  <th scope="col" class="header c2">Điểm<div class="commands"></div></th>';
		 echo '</tr>';
			
			  foreach ($arr_quiz as $quiz_info)
			  {
			   echo ' 
			  <tr class="r0">
				<td class="cell c0">
				<span class="gradeitem">
				<a title="'.$quiz_info['name'].'" 
				href="';
				if($quiz_info['quiz_type_apply'] =='bt30_quiz')
				{
					echo '
						http://elearning.tvu.topica.vn/mod/bt30/bt30.php?qid='.$quiz_info['id'];
				}
				elseif($quiz_info['quiz_type_apply'] =='bt72_quiz')
				{
					echo '
					http://elearning.tvu.topica.vn/mod/bt72/bt72.php?qid='.$quiz_info['id'];
				}
				
				echo '">
					<img alt="Đề thi" class="icon itemicon" src="http://elearning.tvu.topica.vn/pix/smartpix.php/topica/mod/quiz/icon.gif">'.$quiz_info['name'].'</a></span>
					</td>
					<td class="cell c1"><span class="gradeitem">'.$COURSE->fullname.'</span></td>
					<td class="cell c2" align="center"><span class="gradeitem">';
				// get grade process
				//if($quiz_info['quiz_type_apply'] =='bt30_quiz')
				//danglx: 24-10-2013
				if(strpos($quiz_info['name'],'v')!='')
				//end danglx
				{
					$sql = "SELECT grade from mdl_quiz_grades where quiz = ".$quiz_info['id']." and userid = ".$USER->id;
					$rc = $mysqli->query($sql);
					$dd = $rc->fetch_assoc();
					$m_q = $dd['grade'];
				
					if($quiz_info['grademethod']==1) // tinh diem cao nhat cua cac lan lam
						{
							 $sql  = "select max(sumgrade) grade from vietth_q169_attempts where userid = ".$USER->id." and deleted=0 and status='submited' and quiz = ".$quiz_info['id']."";					 
							 $rc = $mysqli->query($sql);
							 $dd = $rc->fetch_assoc();
							 $bt30grade = round($dd['grade'],1);
						}
						elseif($quiz_info['grademethod']!=1) // tinh trung binh
						{
							 $sql  = "select avg(sumgrade) grade from vietth_q169_attempts where userid = ".$USER->id." and deleted=0 and status='submited' and quiz = ".$quiz_info['id'];				
													
							 $rc = $mysqli->query($sql);
							 $dd = $rc->fetch_assoc();
							 $bt30grade = round($dd['grade'],1);
						}		
					echo max($m_q,$bt30grade);
				}
				//else if($quiz_info['quiz_type_apply'] =='bt72_quiz')
				//danglx: 24-10-2013
				elseif(strpos($quiz_info['name'],'l')!='' || strpos($quiz_info['name'],'L')==0)
				//end danglx
				{
				   
					if($quiz_info['grademethod']==1) // tinh diem cao nhat cua cac lan lam
					{
					 $sql  = "select max(sumgrade) grade from vietth_q169_attempts where userid = ".$USER->id." and quiz = ".$quiz_info['id'];					 
					 $rc = $mysqli->query($sql);
					 $dd = $rc->fetch_assoc();
					 $bt72grade = ceil($dd['grade']);
					}
					elseif($quiz_info['grademethod']!=1) // tinh trung binh
					{
					 $sql  = "select avg(sumgrade) grade from vietth_q169_attempts where userid = ".$USER->id." and quiz = ".$quiz_info['id'];				
					 $rc = $mysqli->query($sql);
					 $dd = $rc->fetch_assoc();
					 $bt72grade = ceil($dd['grade']);
					}		
				
					   $sql_m_q = "SELECT grade FROM mdl_quiz_grades where userid = ".$USER->id." and quiz = ".$quiz_info['id'];
					  $rc_m_q = $mysqli->query($sql_m_q);
					  $dd_m_q = $rc_m_q->fetch_assoc();

					echo max($dd_m_q['grade'],$bt72grade);
				}
				
				echo '
				</span></td>
				
				</tr>';
			  
			  }
			  //close connection
			  $mysqli->close();
				echo '
				</tbody>
				</table>';
			}
			else
			{
				// Create a report instance
				$report = new grade_report_user($courseid, $gpr, $context, $userid);

				// print the page
				print_heading(get_string('modulename', 'gradereport_user'). ' - '.fullname($report->user));

				if ($report->fill_table()) {
					echo $report->print_table(true);
				}
			}
    }

} else {
    // no access to grades!
    echo "Can not view grades."; //TODO: localize
}
print_footer($course);

?>
