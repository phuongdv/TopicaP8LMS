<?php
$template -> set_filenames(array(
	'assign'	=> $dir_template . 'assign.tpl')
);
$p_submit = '';
if(isset($_POST['submit']))
	$p_submit = $_POST['submit'];
if($p_submit == 'Chấp nhận') {
	$p_assign = $_POST['assign'];
	
	// add function to add into tblasssign
	  // get time delay
	  $sql="select time from tblanswer where id=$id";
	  $sql_answer = $db->sql_query($sql);
	  while ($answer_rows = $db->sql_fetchrow($sql_answer)) {
	  	$timedelay=time()-intval($answer_rows['time']);
	  }
	  //
	$sql="INSERT INTO tblassign (assignfrom,assignto,datime,answerid,threadid,delay) VALUES('".$profiles['id']."','".$p_assign."',NOW(),'".$id."','".$thr_id."','".$timedelay."')";
	$sql_assign = $db->sql_query($sql);
	//and add to table
	
	if($p_assign!=''&&$p_assign!=0) {
		$sql_assign = "UPDATE tblanswer SET assignid = ".$p_assign." WHERE id = ".$id;
		$sql_assign = $db->sql_query($sql_assign);
		//----------------------------- set trang thai lai cho chu de --------------------------
		$sql_assign_thread = "UPDATE tblthread SET assignid = ".$p_assign.",status = 3 WHERE id = '".$thr_id."'";
		$sql_assign_thread = $db->sql_query($sql_assign_thread);
		
		send_mail('[LMS TVU] Yeu cau tra loi cau hoi H2472 ',get_email($p_assign),'Bạn vừa có một  câu hỏi cần trả lời từ hệ thống  H2472 của LMS TVU<br> Ðược assign bởi: '.get_name_from_id($profiles['id']).'<br>Mã số chủ đề là :'.$thr_id.'<br> Để trả lời xin vui lòng dang nhập moodle <a href="'.$linkelearning.'">tại dây</a>,sau đó click link sau <a href="'.$url.'/?act=answers&do=detail&id='.$thr_id.'">'.$url.'/?act=answers&do=detail&id='.$thr_id.'</a> ',get_email_canhan($p_assign),'','');
		//---------------------------------------------
       if($norefresh=='1')
       {
		$template -> assign_block_vars('NEWUSER_MSG', array(
			'newuser_msg'		=> "<p><strong>Assign successful!</strong></p><br />[Window will be closed automatically in 2 seconds]
			<script>
			window.parent.location=window.parent.location.href;
			window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close()', 2000);
			</script>"
		));
       }
       else {
       	$template -> assign_block_vars('NEWUSER_MSG', array(
			'newuser_msg'		=> "<p><strong>Assign successful!</strong></p><br />[Window will be closed automatically in 2 seconds]
			<script>
			window.parent.location=window.parent.location.href;
			window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close()', 2000);
			</script>"
		));
       }
	} else {
		$template -> assign_block_vars('NEWUSER_MSG', array(
			'newuser_msg'		=> '<p style="color=#ff0000;" >Please choose object to assign!</p>'
		));
         $sql_answer="SELECT u.username author,a.answername answername,a.answerdes answerdes,a.courseid courseid,a.time time,c.fullname fullname FROM tblanswer a ,mdl_course c,mdl_user u where u.id=a.userid and a.id='".$id."' and a.courseid=c.id ";
	//$sql_answer = "SELECT * FROM tblanswer WHERE id =".$id;
	$sql_answer = $db->sql_query($sql_answer) or die(mysql_error());
	while ($answer_rows = $db->sql_fetchrow($sql_answer)) {
         $sql_unassign="select u.lastname,u.firstname from mdl_user u,tblanswer a where u.id=a.unassign and a.id='".$id."'";
          $sql_unassign = $db->sql_query($sql_unassign) or die(mysql_error());
		 $unassign_rows = $db->sql_fetchrow($sql_unassign);
		$author_repley = $answer_rows['assignid'];
		$template -> assign_block_vars('ASSIGNFORM', array(
			'name'			=>	$answer_rows['answername'],
			'answerdes'		=>	$answer_rows['answerdes'],
			'id'			=>	$id,
			'fullname'		=>	$answer_rows['fullname'],
				'author'		=> $answer_rows['author'],
				'delay'			=> return_answer_delay($id,$answer_rows['author'],$answer_rows['time']),
				'unassign'      => '<tr><td>Từ chối bởi </td><td style="color:red;">'.$unassign_rows['lastname'].'&nbsp;'.$unassign_rows['firstname'].'</td><tr>',
		));
			/*$sql_group = "SELECT u.*, g.code as code FROM mdl_user as u, tblgroup as g, tbleuser_group as ug  WHERE ug.user_id = u.id AND ug.group_id = g.id AND g.id NOT IN (1,2,3,8)";*/
			if($profiles['code']=='gvcm')
			{
			$sql_group ="SELECT
u.id, u.username, u.firstname, u.lastname,r.name
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
where
c.id = '".$answer_rows['courseid']."'
and r.id =14";	
			}
			else
			{
			$sql_group ="SELECT
u.id, u.username, u.firstname, u.lastname,r.name
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
where
c.id = '".$answer_rows['courseid']."'
and r.id in (3,4,14,13,211)";
			}
			$sql_group = $db->sql_query($sql_group) or die(mysql_error());
			while ($group_rows = $db->sql_fetchrow($sql_group)) {
				$template -> assign_block_vars('ASSIGNFORM.ASSIGN', array(
					'id'		=> $group_rows['id'],
					'name'		=> $group_rows['code'].'-'.$group_rows['firstname'].' '.$group_rows['lastname'],
					'selected'	=> ($group_rows['id'] == $answer_rows['assignid']) ? ' selected' : '',
					'role'      => $group_rows['name'],
				));
			}
		}
	}
} else {
 $sql_answer="SELECT u.username author,a.answername answername,a.answerdes answerdes,a.courseid courseid,a.time time,c.fullname fullname FROM tblanswer a ,mdl_course c,mdl_user u where u.id=a.userid and a.id='".$id."' and a.courseid=c.id ";
	//$sql_answer = "SELECT * FROM tblanswer WHERE id =".$id;
	$sql_answer = $db->sql_query($sql_answer) or die(mysql_error());
	while ($answer_rows = $db->sql_fetchrow($sql_answer)) {
         // add by vietth get unassign info
         $sql_unassign="select u.id,u.lastname,u.firstname from mdl_user u,tblanswer a where u.id=a.unassign and a.id='".$id."'";
          $sql_unassign = $db->sql_query($sql_unassign) or die(mysql_error());
		 $unassign_rows = $db->sql_fetchrow($sql_unassign);
		$author_repley = $answer_rows['assignid'];
		$template -> assign_block_vars('ASSIGNFORM', array(
			'name'			=>	$answer_rows['answername'],
			'answerdes'		=>	$answer_rows['answerdes'],
			'id'			=>	$id,
			'fullname'		=>	$answer_rows['fullname'],
			'author'		=> $answer_rows['author'],
			'delay'			=> return_answer_delay($id,$answer_rows['author'],$answer_rows['time']),
			'unassign'      => ($unassign_rows['lastname']) ? '<tr><td>Rejected by </td><td style="color:red;">'.$unassign_rows['lastname'].'&nbsp;'.$unassign_rows['firstname'].'</td><tr>':'',
		));
		/*$sql_group = "SELECT u.*, g.code as code FROM mdl_user as u, tblgroup as g, tbleuser_group as ug  WHERE ug.user_id = u.id AND ug.group_id = g.id AND g.id NOT IN (1,2,3,8)";*/
		if($profiles['code']=='gvcm')
			{
			$sql_group ="SELECT
u.id, u.username, u.firstname, u.lastname,r.name
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
where
c.id = '".$answer_rows['courseid']."'
and r.id =14";	
			}
			else
			{
			$sql_group ="SELECT
u.id, u.username, u.firstname, u.lastname,r.name
FROM mdl_user u
INNER JOIN mdl_role_assignments ra ON ra.userid = u.id
INNER JOIN mdl_context ct ON ct.id = ra.contextid
INNER JOIN mdl_course c ON c.id = ct.instanceid
INNER JOIN mdl_role r ON r.id = ra.roleid
INNER JOIN mdl_course_categories cc ON cc.id = c.category
where
c.id = '".$answer_rows['courseid']."'
and r.id in (3,4,14,2,13,211)";
			}
		//echo $sql_group;
		$sql_group = $db->sql_query($sql_group) or die(mysql_error());
		while ($group_rows = $db->sql_fetchrow($sql_group)) {
			$template -> assign_block_vars('ASSIGNFORM.ASSIGN', array(
				'id'		=> $group_rows['id'],
				'name'		=> /*$group_rows['code'].'-'.*/$group_rows['lastname'].' '.$group_rows['firstname'],
				'selected'	=> ($group_rows['id'] == $answer_rows['assignid']) ? ' selected' : '',
				'role'      => $group_rows['name'],
			));
		}
	}
}
$template -> pparse('assign');
?>
