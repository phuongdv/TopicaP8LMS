<?php
 $template -> set_filenames(array(
	'po'	=> $dir_template . 'po.tpl')
);

	$template -> assign_vars(array(
		'user'	=>	$pro_author
	));

	if($do=="myanswer")
		$template->assign_block_vars('ALLANSWER',array());
	else
		$template->assign_block_vars('MYANSWER',array());

	// -------------------- lấy ra khóa học của user đang đăng nhập  đưa vào selecte box----------------------------------------------*/
	$sql_course ="SELECT left(c.fullname,6) sname FROM mdl_course c INNER JOIN tblassign_role ra ON c.id = ra.courseid WHERE ra.userid = 396 group by sname";
	echo $sname;
	$sql_subject_results = $db->sql_query($sql_course);
	while($sql_subject_result = $db->sql_fetchrow($sql_subject_results))
	{
		$template->assign_block_vars('SUBJECT',array(
			'sname'			=> displayData_DB($sql_subject_result['sname']),
			'name'		=> displayData_DB($sql_subject_result['sname']),
			'gv'			=> $gv,
			'selected'		=> ($sql_subject_result['sname']==$sname) ? ' selected' : '',
		));
	}
	// -------------------- End lấy ra khóa học của user đang đăng nhập ----------------------------------------------*/
	// -------------------- End lấy ra Giang vien  user có thể gán ----------------------------------------------*/
	
	$sql_gvhd ="SELECT
				u.id, u.username, u.firstname, u.lastname
				FROM
				mdl_user u
				INNER JOIN tblassign_role ra ON ra.userid = u.id
				where
				ra.courseid in (SELECT
				c.id
				FROM
				mdl_course c
				INNER JOIN tblassign_role ra ON ra.userid ='".$profiles['id']."'
				WHERE 
				c.id = ra.courseid)
				and ra.roleid=14 or ra.roleid=4
				";
	$sql_gvhd_results = $db->sql_query($sql_gvhd);
	while($sql_gvhd_result = $db->sql_fetchrow($sql_gvhd_results))
	{
		$template->assign_block_vars('GVHD',array(
			/*'id'			=> displayData_DB($sql_gvhd_result['id']),
			'name'			=> displayData_DB($sql_gvhd_result['code'].'-'.$sql_gvhd_result['firstname'].' '.$sql_gvhd_result['lastname']),
			'subject'		=> $subject,
			'selected'		=> ($sql_gvhd_result['id']==$gv) ? ' selected' : '',*/
			
			'id'			=> displayData_DB($sql_gvhd_result['id']),
			'name'			=> displayData_DB($sql_gvhd_result['firstname'].' '.$sql_gvhd_result['lastname']),
			'subject'		=> $subject,
			'selected'		=> ($sql_gvhd_result['id']==$gv) ? ' selected' : '',
		));
	}
	// -------------------- End lấy ra Giang vien  user có thể gán ----------------------------------------------*/

	$do_close_count = "";
	$do_close_item = "";
	if($do=="close") {
		$do_close_count = " status = 1 AND ";
		$do_close_item = " ans.status = 1 AND ";
	}

	if(isset($sname)&&$sname!=0&&isset($gv)&&$gv!=0)
		/*$sql_answer_count = "SELECT * FROM tblanswer WHERE".$do_close_count." courseid IN (".get_list_course2($subject).") AND assignid = '".$gv."'";*/
		$sql_answer_count ="SELECT  *
							FROM
							tblanswer
							where
							".$do_close_count."
							assignid ='".$gv."' and
							courseid ='".$subject."' and
							courseid in (SELECT c.id
							FROM
							mdl_course c
							INNER JOIN tblassign_role ra ON ra.userid ='".$profiles['id']."'
							WHERE 
							c.id = ra.courseid)";
	    elseif(isset($sname)&&$sname!='')
		/*$sql_answer_count = "SELECT * FROM tblanswer WHERE".$do_close_count." courseid IN (".get_list_course2($subject).")";*/
$sql_answer_count ="SELECT *
					FROM
					tblanswer
					where
					".$do_close_count."
					courseid in (select id from mdl_course where fullname like '".$sname."%') ";
	elseif(isset($gv)&&$gv!=0)
		/*$sql_answer_count = "SELECT * FROM tblanswer WHERE".$do_close_count." assignid = '".$gv."'";*/
		$sql_answer_count ="SELECT *
							FROM
							tblanswer
							where
							".$do_close_count."
							assignid ='".$gv."' and
							courseid in (SELECT c.id
							FROM
							mdl_course c
							INNER JOIN tblassign_role ra ON ra.userid ='".$profiles['id']."'
							WHERE 
							c.id = ra.courseid)";
	else
		/*$sql_answer_count = "SELECT * FROM tblanswer WHERE".$do_close_count." courseid IN (".get_list_course_gvhd($profiles['id']).")";*/
		$sql_answer_count ="SELECT
		*
		FROM
		tblanswer
		where
		".$do_close_count."
		courseid in (SELECT c.id
		FROM
		mdl_course c
		INNER JOIN tblassign_role ra ON ra.userid ='".$profiles['id']."'
		WHERE 
		c.id = ra.courseid)";
	$sql_answer_count = $db->sql_query($sql_answer_count) or die(mysql_error());
	$r_count = 0;
	$c2 = 0;
	
	while($row = $db->sql_fetchrow($sql_answer_count)){
		if(check_have_reply($row['id']))
		{	$c2=$c2+1; }
	$r_count = $r_count + 1; 
	}
	
	
	//$r_count = $db->sql_fetchfield(0);

	if($r_count != 0) {

		$page = 1;
		$stt = 1;
		$final = '';
		$show_page = '';
		$p = !empty($_GET['p']) ? (int)$_GET['p'] : 0;
		$p = (!is_numeric($p) || ($p > $r_count ) || ($p < 0 )) ? 0 : $p;
		$nPageSize = 20;

		if(isset($subject)&&$subject!=0&&isset($gv)&&$gv!=0)
			/*$sql_answer = "SELECT ans.*, us.username as username FROM tblanswer as ans, mdl_user as us WHERE".$do_close_item." ans.userid = us.id AND ans.courseid IN (".get_list_course2($subject).") AND ans.assignid = '".$gv."' ORDER BY ans.id DESC LIMIT " . $p . ", " . $nPageSize . "";*/
			$sql_answer ="SELECT
			*
			FROM
			tblanswer
			where
			assignid = '".$gv."' and
			courseid ='".$subject."'
			";
		elseif(isset($sname)&&$sname!='')
		{
			/*$sql_answer = "SELECT ans.*, us.username as username FROM tblanswer as ans, mdl_user as us WHERE".$do_close_item." ans.userid = us.id AND ans.courseid IN (".get_list_course2($subject).") ORDER BY ans.id DESC LIMIT " . $p . ", " . $nPageSize . "";*/
			$sql_answer ="SELECT
			*
			FROM
			tblanswer
			where
			".$do_close_item."
			courseid in (select id from mdl_course where fullname like '".$sname."%') 
			and parent=0
			";
			//echo $sql_answer;
			//die();
		}
		elseif(isset($gv)&&$gv!=0)
			/*$sql_answer = "SELECT ans.*, us.username as username FROM tblanswer as ans, mdl_user as us WHERE".$do_close_item." ans.userid = us.id AND ans.assignid = '".$gv."' ORDER BY ans.id DESC LIMIT " . $p . ", " . $nPageSize . "";*/
			$sql_answer ="SELECT
			*
			FROM
			tblanswer
			where
			".$do_close_item."
			assignid = '".$gv."' and
			courseid in (SELECT c.id
			FROM
			mdl_course c
			INNER JOIN tblassign_role ra ON ra.userid ='".$profiles['id']."'
			WHERE 
			c.id = ra.courseid)";
	
		else
			/*$sql_answer = "SELECT ans.*, us.username as username FROM tblanswer as ans, mdl_user as us WHERE".$do_close_item." ans.userid = us.id ORDER BY ans.id DESC LIMIT " . $p . ", " . $nPageSize . "";*/
			$sql_answer ="SELECT
				*
				FROM
				tblanswer
				where
				courseid in (SELECT c.id
				FROM
				mdl_course c
				INNER JOIN tblassign_role ra ON ra.userid ='".$profiles['id']."'
				WHERE 
				c.id = ra.courseid)
				and parent=0
				";
	//--------------------- fix aswer for child question ------------------------------
	// if have  child(s) get infomation that child else get parents infomation

	    $sql_answer = $db->sql_query($sql_answer) or die(mysql_error());
 if(mysql_numrows($sql_answer)>0)
{
	    
	    
	    	
	    
		while ( $answer_rows = $db->sql_fetchrow($sql_answer)) {
		$final[] = $answer_rows;
		}
		//echo count($final);
		//die();
		if($r_count !=0 ) {
			for ($i = 0; $i < count($final); $i++) {
				if($final[$i]['id'] != '') {
														   $sql="SELECT count(id) from tblanswer where parent='".$final[$i]['id']."'";
														   $check= mysql_query($sql) or die(mysql_error());
														   $child=mysql_fetch_array($check);
														   if($child[0]!=0) // if have childs get lastest child 
														   {
															 $sql="SELECT
																*
																FROM
																tblanswer
																where
																courseid in (SELECT c.id
																FROM
																mdl_course c
																INNER JOIN tblassign_role ra ON ra.userid ='".$profiles['id']."'
																WHERE 
																c.id = ra.courseid)
																and parent='".$final[$i]['id']."'
																order by id desc 
																limit 0,1
																";
																//echo $sql;
																$sql= $db->sql_query($sql) or die(mysql_error());
																	while ( $answer_rows = $db->sql_fetchrow($sql)) {
																	$final2[] = $answer_rows;
																	}
																	
																	//------
																				for ($j = 0; $j < count($final2); $j++) {
															if($final2[$j]['id'] != '') {
															$template -> assign_block_vars('L_ANWSER', array(
															'tr_class'	=> ($j % 2 == 0) ? 'bg_color1' : 'bg_color2',
															'stt'		=> $stt,
															'id'		=> $final[$i]['id'],
															'id2'		=> $final2[$j]['id'],
															'name'		=> $final2[$j]['answername'],
															'author'	=> $final2[$j]['username'],
															'forward'	=> (check_have_reply($final2[$j]['id'])) ? 'display:none' : '',
															'rate'		=> get_answer_rate($final[$i]['id'],$final[$i]['userid']),
															'time'		=> date('d/m/Y',$final2[$j]['time']),
															'delay'		=> return_answer_delay($final2[$j]['id'],$final2[$j]['userid'],$final2[$j]['time']),
															'answer'	=> get_latest_answers($final2[$j]['id'],$final2[$j]['userid']),
															'status'	=> check_answer_status($final2[$j]['id']),
															'userid'    => $profiles['id']
														));
														
														$stt++;
													}
												}
											
			            }
				       else{
				
				
				
					$template -> assign_block_vars('L_ANWSER', array(
						'tr_class'	=> ($i % 2 == 0) ? 'bg_color1' : 'bg_color2',
						'stt'		=> $stt,
						'id'		=> $final[$i]['id'],
						'id2'		=> $final[$i]['id'],
						'name'		=> $final[$i]['answername'],
						'author'	=> $final[$i]['username'],
						'forward'	=> (check_have_reply($final[$i]['id'])) ? 'display:none' : '',
						'rate'		=> get_answer_rate($final[$i]['id'],$final[$i]['userid']),
						'time'		=> date('d/m/Y',$final[$i]['time']),
						'delay'		=> return_answer_delay($final[$i]['id'],$final[$i]['userid'],$final[$i]['time']),
						'answer'	=> get_latest_answers($final[$i]['id'],$final[$i]['userid']),
						'status'	=> check_answer_status($final[$i]['id']),
						'userid'    => $profiles['id']
					));
					}
					$stt++;
					$template -> assign_vars(array(
						'empty'	=>	'none'
						));
				}
			}
			
			if(isset($course)&&$course!=0)
				$num_page = generate_pagination('./?course='.$course, $r_count, $nPageSize, $p);
			else
				$num_page = generate_pagination('./?', $r_count, $nPageSize, $p);
			$template -> assign_vars(array(
				'linkpage'				=>	'<div class="pagination">'.$num_page.'</div>',
			));

		}
		}
		else{
			
			$template -> assign_vars(array(
		'empty'	=>	'block'
	));
			
		}
		// neu ko co ket qua tra ve
		
		
		
	}

	if(isset($subject)&&isset($gv))
		$url_close = "./?subject=".$subject."&gv=".$gv."&do=close";
	else
		$url_close = "./?do=close";

	if($do=="myanswer") {
		$sql_answer_finish = "SELECT * FROM tblanswer WHERE status = 1 AND assignid = ".$profiles['id'];
	} else {
		if(isset($subject)&&$subject!=0&&isset($gv)&&$gv!=0)
			/*$sql_answer_finish = "SELECT * FROM tblanswer WHERE status = 1 AND courseid IN (".get_list_course2($subject).") AND assignid = '".$gv."'";*/
			$sql_answer ="SELECT
*
FROM
tblanswer
where
assignid = '".$gv."' and
courseid ='".$subject."'
";

		elseif(isset($subject)&&$subject!=0)
			$sql_answer_finish = "SELECT * FROM tblanswer WHERE status = 1 AND courseid IN (".get_list_course2($subject).")";
		elseif(isset($gv)&&$gv!=0)
			$sql_answer_finish = "SELECT * FROM tblanswer WHERE status = 1 AND courseid IN (".get_list_course_gvhd($profiles['id']).") AND assignid = '".$gv."'";
		else
			$sql_answer_finish = "SELECT * FROM tblanswer WHERE status = 1 AND courseid IN (".get_list_course_gvhd($profiles['id']).")";
	}

	/*$sql_answer_finish = $db->sql_query($sql_answer_finish) or die(mysql_error());
	$count_answer_finish = 0;
	$num_answer_finish = 0;
	while($row_answer_finish = $db->sql_fetchrow($sql_answer_finish)){
		$sql_answer_finish = "SELECT * FROM tblreply WHERE answerid = '".$row_answer_finish['id']."' AND userid = '".$row_answer_finish['userid']."'";
		$sql_answer_finish = @mysql_query($sql_answer_finish) or die(mysql_error());
		while($count_f = @mysql_fetch_array($sql_answer_finish)){
			$count_answer_finish++;  
		}
		$sql_answer_finish = $num_answer_finish + $count_answer_finish;
	}*/
	$sql_answer_finish = $db->sql_query($sql_answer_finish) or die(mysql_error());
$sql_answer_finish = $db->sql_numrows($sql_answer_finish);
	
	
	if($do=="myanswer") {
	} else {
		if(isset($subject)&&$subject!=0&&isset($gv)&&$gv!=0)
		{
			/*$sql_answer_close = "SELECT * FROM tblanswer WHERE status = 1 AND courseid IN (".get_list_course2($subject).") AND assignid = '".$gv."'";*/
			$sql_answer_close ="SELECT
*
FROM
tblanswer
where
status = 1 and
assignid = '".$gv."' and
courseid ='".$subject."'
";
		
		}
		elseif(isset($subject)&&$subject!=0)
			$sql_answer_close = "SELECT * FROM tblanswer WHERE status = 1 AND courseid IN (SELECT c.id
							FROM
							mdl_course c
							WHERE 
							c.id = '".$subject."')";
		elseif(isset($gv)&&$gv!=0)
			$sql_answer_close = "SELECT * FROM tblanswer WHERE status = 1 AND courseid IN (SELECT courseid FROM tblassign_role WHERE userid ='".$profiles['id']."') AND assignid = '".$gv."'";
		else
			$sql_answer_close = "SELECT * FROM tblanswer WHERE status = 1 AND courseid IN (SELECT courseid FROM tblassign_role WHERE userid ='".$profiles['id']."')";
	}
	//echo $sql_answer_close;
	$sql_answer_close = $db->sql_query($sql_answer_close) or die(mysql_error());
	$sql_answer_close = $db->sql_numrows($sql_answer_close);


	$template -> assign_vars(array(
		'totalanswer'		=> $r_count,
		'finishanswer'		=> $c2,
		'delayanswer'		=> $r_count - $c2,
		'totalclose'		=> $sql_answer_close,
		'url_close'			=> $url_close,
	));

$template -> pparse('po');
?>
