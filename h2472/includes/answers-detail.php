<?php
include('header.php');
include($dir_inc.'RatingManager.inc.php');
global $prntques;
$prntques= array();
$template -> set_filenames(array(
'answers-detail'	=> $dir_template . 'answers-detail.tpl')
);
$template -> assign_vars(array(
'user'	=>	$pro_author,
'id_answer' => $id,
));
$template -> assign_vars(array(
'username'	=>	get_username_from_id($profiles['id']),
));
$template -> assign_vars(array(
'back'	=>	$_COOKIE['URLCookie'],
));
$sql="select status,knowledgebase from tblthread where id=$id";
//print_r($sql);die();
$thread_status = mysql_query($sql);
$thr_status=mysql_fetch_array($thread_status);
$template -> assign_vars(array(
'thread_status'	=>	return_status($thr_status['status']),
));
$p_submit = '';
if(isset($_POST['submit']))
$p_submit = $_POST['submit'];
$per = true;
if($do=="close") {
	// kiem tra xem co phai po ko
	if($profiles['code']=='povh_lop_mon'||$profiles['code']=='admin' || $profiles['code']=='gvcm' || $profiles['code']=='gvhd')
	{
		//-----------------------------------------------------------------
		$sql_thread_close = "UPDATE tblthread SET status = 1 WHERE id=".$id;
		$sql_thread_close = $db->sql_query($sql_thread_close) or die(mysql_error());
		$template -> assign_vars(array(
		'newuser_msg'	=>"<script>
	        alert('Topic close!');
			window.parent.location='?act=answers&do=detail&id=$id';
			</script>",));
	}
	else
	{
		$template -> assign_vars(array(
		'newuser_msg'	=>"You have no permission to use this function, role = ".$profiles['code'],));
	}
}
if($do=="open") {
	// kiem tra xem co phai po ko
	if($profiles['code']=='povh_lop_mon'||$profiles['code']=='admin' || $profiles['code']=='gvcm' || $profiles['code']=='gvhd')
	{
		//-----------------------------------------------------------------
		$sql_thread_close = "UPDATE tblthread SET status = 0 WHERE id=".$id;
		$sql_thread_close = $db->sql_query($sql_thread_close) or die(mysql_error());
		$template -> assign_vars(array(
		'newuser_msg'	=>"<script>
	        alert('Topic open');
			window.parent.location='?act=answers&do=detail&id=$id';
			</script>",));
	}
	else
	{
		$template -> assign_vars(array(
		'newuser_msg'	=>"You have no permission to use this function, role = ".$profiles['code'],));
	}
}
#      insert by vietth for release answer to system - unassign
if($do=="unassign")
{
	if($profiles['code']!='hoc_vien')
	{
		$sql_answer_close = "UPDATE tblthread SET assignid=0,status=0 WHERE id=".$thr_id;
		$sql_answer_close = $db->sql_query($sql_answer_close) or die(mysql_error());
		$sql_answer_update = "UPDATE tblanswer SET unassign = '".$profiles['id']."',assignid=0 WHERE id=".$id;
		$sql_answer_update = $db->sql_query($sql_answer_update) or die(mysql_error());
		$template -> assign_vars(array(
		'newuser_msg'	=>"<script>
	        alert('Forward this question to system');
			window.parent.location='?act=answers&do=detail&id=$thr_id';
			</script>",
			));
	}
	else
	{
		$template -> assign_vars(array(
		'newuser_msg'	=>"You have no permission to use this function",));
	}
}
if($do=="set_kkt") {
	//-----------------------------------------------------------------
	$sql_thread_close = "UPDATE tblthread SET knowledgebase = 1 WHERE id=".$id;
	$sql_thread_close = $db->sql_query($sql_thread_close) or die(mysql_error());
	$template -> assign_vars(array(
	'newuser_msg'	=>"<script>
	        alert('Topic was forwarded to Knowledge base');
			window.parent.location='?act=answers&do=detail&id=$id';
			</script>",));
}
if($do=="unset_kkt") {
	//-----------------------------------------------------------------
	$sql_thread_close = "UPDATE tblthread SET knowledgebase = 0 WHERE id=".$id;
	$sql_thread_close = $db->sql_query($sql_thread_close) or die(mysql_error());
	$template -> assign_vars(array(
	'newuser_msg'	=>"<script>
	        alert('Topic was removed from Knowledge base');
			window.parent.location='?act=answers&do=detail&id=$id';
			</script>",));
}
if($profiles['code']=='hoc_vien' || $profiles['code']=='povh_lop_mon')
{
	$txt_ask = '<a href="#questionform" onclick="questionactive();" class="detail-reply" title="">Not agree? Continue!</a>';
	$editor='<textarea id="editor" name="editor" rows="20" cols="75"></textarea>';
	$editor='<textarea cols="80" id="editor_kama" name="editor_kama" rows="10"></textarea>';
	$template -> assign_vars(array(
	'editor1' => 	$editor,
	));
}
#  end
if($mess=='1')
$msg = '<div class="mess">Failed to upload!</div>';
elseif($mess=='2')
$msg = '<div class="mess">Please complete form!</div>';
elseif($mess=='3')
$msg = '<div class="mess">You have no permission to use this function!</div>';
$template -> assign_block_vars('NEWUSER_MSG', array(
'newuser_msg'	=> $msg
));


/**
*@auther: Le Xuan Dang (danglx@topica.edu.vn)
*@name:Thêm mục cảm ơn H2472
*@date: 27/05/2014
**/
//Thêm đếm số lần thanks cho câu trả lời
if($do=="thanks") {
	//-----------------------------------------------------------------
	//Kiểm tra xem user đã cảm ơn thread này lần náo chưa
	
	$sql_thread_thanks_user = "select u_id FROM tblthread_thanks WHERE username='".get_username_from_id($profiles['id'])."' and threadid=".$id;
	$sql_thread_thanks_user = $db->sql_query($sql_thread_thanks_user) or die(mysql_error());
	$thanks_user_rows = $db->sql_fetchrow($sql_thread_thanks_user);
	$thanks_user_number = $thanks_user_rows['u_id'];
	//$thanks_user_number = $thanks_user_rows['username'];
	if ($thanks_user_number==$profiles['id'])
	{
		$template -> assign_vars(array(
	'newuser_msg'	=>"<script>
	        alert('Thank to topic $id.');
	        window.parent.location='?act=answers&do=detail&id=$id';
			</script>",));
	}
	else
	{
		$sql_thread_thanks = "UPDATE tblthread SET thanks_number = thanks_number+1 WHERE id=".$id;
		$sql_thread_thanks = $db->sql_query($sql_thread_thanks) or die(mysql_error());
		
		$insert_thread_thanks = "INSERT INTO tblthread_thanks(u_id,username,date,threadid) VALUES(".$profiles['id'].",'".get_username_from_id($profiles['id'])."',".time().",".$id.")";
		$insert_thread_thanks = $db->sql_query($insert_thread_thanks) or die(mysql_error());
		/**
		*@auther: Le Xuan Dang (danglx@topica.edu.vn)
		*@name:Gui email cho người tra loi cau hoi H2472
		*@date: 27/05/2014
		**/
			$sql_hv ="SELECT r.userid user_reply,t.answername, t.thanks_number
						FROM tblreply r, tblanswer a, tblthread t
						WHERE r.answerid=a.id 
						AND a.thread = t.id
						AND a.thread=".$id." ORDER BY r.id LIMIT 0,1";
			$result_hv = mysql_query($sql_hv);
			$reply_hv=mysql_fetch_array(($result_hv));
			send_mail('[TVU-H2472] TB co cam on cho cau tra loi',get_email($reply_hv['user_reply']),'+ Acount cảm ơn câu trả lời: <b>'.get_name_from_id($profiles['id']).' ('.get_username_from_id($profiles['id']).')</b><br>+ Thời điểm cảm ơn: <b>'.date('d/m/Y H:s:i',time()).'</b><br>+ Tên câu hỏi: <b>'.$reply_hv['answername'].'</b><br>+ Trước khi xem chi tiết xin vui lòng đăng nhập hệ thống lớp học <a href="'.$linkelearning.'">tại dây</a><br>+ Đường link xem câu hỏi: <a href="'.$url.'/?act=answers&do=detail&id='.$id.'">'.$url.'/?act=answers&do=detail&id='.$id.'</a><br>+ <b>Tổng số cảm ơn cho câu trả lời: <font color="red">'.$reply_hv['thanks_number'].'</font></b><br>+ <b>Xin chú ý</b>: <font color="red">Không Reply email này.</font>',get_email_canhan($reply_hv['user_reply']),'','');
		//end danglx gui mail khi cam on cau tra loi
		$template -> assign_vars(array(
		'newuser_msg'	=>"<script>
		        alert('Thank to topic $id.');
				window.parent.location='?act=answers&do=detail&id=$id';
				</script>",));
	}
}
$sql_thanks_number = "SELECT thanks_number, reply_time FROM tblthread WHERE id = ".$id;
$sql_thanks_number = $db->sql_query($sql_thanks_number) or die(mysql_error());
$thanks_number_rows = $db->sql_fetchrow($sql_thanks_number);
$thanks_number = $thanks_number_rows['thanks_number'];
$reply_thanks_thread = $thanks_number_rows['reply_time'];

if ($reply_thanks_thread<>0)
{

$template -> assign_vars(array(
	'thanks' => '<a href="./?act=answers&do=thanks&id='.$id.'" title=""><img class="answerother_thanks1" title="Click to thanks this topic" src="'.$linkelearning.'/h2472/thanks.png" width="" height=""/></a> <div class="answerother_thanks">Thanks: '.$thanks_number.' </div>',
	));
	
}
//if ($profiles['code']=='admin' || $profiles['code']=='po2' || $profiles['code']=='povh_lop_mon')
//{	
if ($thanks_number>=1)
{
	$template -> assign_vars(array(
	'ds_thanks' =>"Thanks list: ",
	));
	
	$sql_thread_thanks_username = "select username, date(FROM_UNIXTIME(date)) date_thanks FROM tblthread_thanks WHERE threadid=".$id;
	//echo $sql_thread_thanks_username;
	$sql_thread_thanks_username = $db->sql_query($sql_thread_thanks_username) or die(mysql_error());
	//Lay danh sanh nguoi cam on
	$thanks_username=array();
	while ( $thanks_username_rows = $db->sql_fetchrow($sql_thread_thanks_username))  {
	$thanks_username[]=$thanks_username_rows;
	}
	
	for($i=0;$i<count($thanks_username);$i++)
	{  
		$template -> assign_block_vars('U_ANWSER', array(
		'username_thanks'     => $thanks_username[$i]['username'],
		'date_thanks'     => $thanks_username[$i]['date_thanks'],
	));
	}
	
}
//}
//End Thêm đếm số lần thanks cho câu trả lời

//$sql_answer = "SELECT ans.*, tp.topicname as topicname, us.username as username, us.picture as picture FROM tblanswer as ans, mdl_user as us, tbltopic as tp WHERE ans.userid = us.id AND ans.topicid =tp.id AND ans.id = ".$id." ORDER BY ans.id DESC";
$sql_answer = "SELECT
ans.*, tp.topicname, us.username, us.picture,c.fullname
FROM tblanswer ans
INNER JOIN mdl_user us  ON us.id = ans.userid
INNER JOIN tbltopic tp  ON tp.id = ans.topicid
INNER JOIN mdl_course c ON ans.courseid=c.id
where ans.thread=".$id."
ORDER BY id ASC ";
$sql_answer = $db->sql_query($sql_answer) or die(mysql_error());
$a_status = 0;
$a_author = 0;
//---------------------------------------------------------------------------------------------
while ($answer_rows = $db->sql_fetchrow($sql_answer))
{
	$a_status = $answer_rows['status'];
	$a_topic = $answer_rows['topicid'];
	$a_author = $answer_rows['userid'];
	$a_id = $answer_rows['id'];
	$a_name=$answer_rows['answername'];
	$a_classid=$answer_rows['class_id'];
	$a_topicid=$answer_rows['topicid'];
	$a_courseid=$answer_rows['courseid'];
	$a_groupid=$answer_rows['groupid'];
	$a_userid=$answer_rows['userid'];
	if(check_have_reply($answer_rows['id']))
	{
		$sql_reply ="SELECT r.*, us.username,us.lastname,us.firstname,us.picture
				 FROM 
				tblreply r
				INNER JOIN mdl_user us  ON us.id = r.userid
				WHERE r.answerid = '" . $answer_rows['id'] . "' ";
		$_reply = mysql_query($sql_reply);
		$reply=mysql_fetch_array(($_reply));
		// show rate
		$ratingManager = RatingManager::getInstance();
		$template -> assign_block_vars('A_DETAIL', array(
		'uname'       =>  get_name_from_id($answer_rows['userid']),
		'group'			=> get_group($answer_rows['userid']).' class '.get_course($answer_rows['userid']),
		'uid'           => $answer_rows['userid'],
		'id'			=> $answer_rows['id'],
		'title'			=> $answer_rows['answername'],
		'edit'			=> ($thr_status['status']!=1 && return_answer_status($answer_rows['id'])) ? '' : (($answer_rows['userid'] == $profiles['id']) ? ((return_answer_status($answer_rows['id'])==0) ? ' [ <a href="./?act=answers&do=edit&id='.$answer_rows['id'].'&thread='.$id.'&course='.$course.'" title="">Edit</a> ]': "") : ""),
		'picture'		=> ($answer_rows['picture']!=0) ? '<p><img src="'.$linkelearning.'/user/pix.php?file=/'.$answer_rows['userid'].'/f1.jpg" width="100" height="100" alt="" class="avatar" /></p>' : '<p><img src="./assets/images/nopic.gif" alt="" class="avatar" /></p>',
		'author'		=> $answer_rows['username'],
		'time'			=> (return_answer_status($answer_rows['id'])) ? 'Question time: ' .date('d/m/Y H:i:s ',$answer_rows['time']) : date('d/m/Y H:i:s ',$answer_rows['time']).'. Delay '.get_date_POST($answer_rows['time']),
		'answerdes'		=> $answer_rows['answerdes'],
		'reply'			=> '',
		'attach'		=> ($answer_rows['attach']!= '') ? '<div class="detail-attach"><a href="./uploads/'.$answer_rows['attach'].'">'.$answer_rows['attach'].'</a></div>' : '',
		'topic'			=> '<span class="open">'.$answer_rows['topicname'].'</span>',
		'cname'         => $answer_rows['fullname'],
		'forward'		=> '',
		'close'			=> ($profiles['code']=='povh_lop_mon') ? '<a href="./?act=answers&do=close&id='.$answer_rows['id'].'&thr_id='.$id.'" class="answerother" title="">Close topic&nbsp;|&nbsp;</a>' : '',
		'reply_group'	=> '( '.get_group($reply['userid']).' )',
		'reply_id'			=> 'Answer ID :'.$reply['id'],
		'reply_edit'		=> ($thr_status['status']!=1&&$reply['userid']==$profiles['id']) ? ' [<a href="./?act=rp&aid='.$a_id.'&id='.$reply['id'].'&thr_id='.$id.'">Edit</a>]' : '',
		'reply_picture'		=> get_picture($reply['userid']),
		'reply_replytitle'	=> $reply['replytitle'],
		'reply_replydes'	=> '<img src="./images/a.png" width="32" height="32" />&nbsp;'.$reply['replydes'],
		'reply_author'		=> $reply['username'],
		'reply_name'		=> $reply['lastname'].' '.$reply['firstname'],
		'reply_attach'		=> ($reply['attach']!= '') ? '<div class="repley-attach">File đình kèm: <a href="./uploads/'.$reply['attach'].'" target="_blank">'.$reply['attach'].'</a></div>' : '',
		'reply_time'		=> ($reply['userid']==check_latest_replay($a_id)) ? 'Answer time: ' . date('d/m/Y H:i:s ',$reply['time']) : 'Answer time: ' . date('d/m/Y H:i:s ',$reply['time']),
		'reply_answerdes'	=> $reply['answerdes'],
		'reply_ask'         => ($thr_status['status']!=1 && check_ask_q($reply['id'],$id) && $answer_rows['userid']==$profiles['id'] && $answer_rows['status']!=1) ? $txt_ask : '' ,
		'lreplay'            => 'border:solid 1px #810c15;',
		'repuid'           => $reply['userid'],
		));
	}
	else
	{
		//if ($profiles['code']=='povh_lop_mon' || $profiles['code']=='tro_giang_nganh' || $profiles['code']=='po2' ||  $profiles['code']=='admin' ||($profiles['code']=='gvcm'&&$answer_rows['assignid']==$profiles['id'])||$profiles['code']=='admin'||($profiles['code']=='gvhd'&&$answer_rows['assignid']==$profiles['id']))
		if ($profiles['code']=='povh_lop_mon' || $profiles['code']=='tro_giang_nganh' || $profiles['code']=='po2' ||  $profiles['code']=='admin' )
		{
			$txt_reply = "<a style=\"font-size:10pt;font-weight:bold\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: 570, y: 550}}\" href=\"./?do=assign&id=".$answer_rows['id']."&userid=".$answer_rows['userid']."&r=1&thr_id=".$answer_rows['thread']."\" style=\"{L_ANWSER.forward}\">Assign question</a>"
			."&nbsp; | &nbsp; <a href=\"#replyform\" onclick=\"replyactive();\" class=\"detail-reply\" title=\"\">Answer</a> | ";
			$editor='<textarea id="editor" name="editor" rows="20" cols="75"></textarea>';
			$editor='<textarea cols="80" id="editor_kama" name="editor_kama" rows="10"></textarea>
';
			$template -> assign_vars(array(
			'editor2' => 	$editor,
			));
		}
		//elseif($profiles['code']=='po2'||$profiles['code']=='povh_lop_mon' || $profiles['code']=='tro_giang_nganh' ||$profiles['code']=='admin'|| ($profiles['code']=='gvcm'&&$answer_rows['assignid']==$profiles['id'])|| $profiles['code']=='admin'||($profiles['code']=='gvhd'&&$answer_rows['assignid']==$profiles['id']))
		elseif(($profiles['code']=='po2'||$profiles['code']=='povh_lop_mon' || $profiles['code']=='tro_giang_nganh' ||$profiles['code']=='admin') &&$answer_rows['assignid']==$profiles['id'])
		{
			$txt_reply = "<a style=\"font-size:10pt;font-weight:bold\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: 570, y: 550}}\" href=\"./?do=assign&id=".$answer_rows['id']."&userid=".$answer_rows['userid']."&r=1\" style=\"{L_ANWSER.forward}\">Assign this question</a>"
			."&nbsp;&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; <a href=\"#reolyform\" onclick=\"replyactive();\" class=\"detail-reply\" title=\"\">Answer this question</a>";
			$editor='<textarea id="editor" name="editor" rows="20" cols="75"></textarea>';
			$editor='<textarea cols="80" id="editor_kama" name="editor_kama" rows="10"></textarea>';
			$template -> assign_vars(array(
			'editor2' => 	$editor,
			));
		}
		elseif($profiles['code']=='povh_lop_mon' || $profiles['code']=='po2' || $profiles['code']=='tro_giang_nganh' ||($profiles['code']=='giang_vien'&&$answer_rows['assignid']==$profiles['id'])||$profiles['code']=='admin')
		{
			$txt_reply = "<a style=\"font-size:10pt;font-weight:bold\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: 570, y: 550}}\" href=\"./?do=assign&id=".$answer_rows['id']."&userid=".$answer_rows['userid']."&r=1\" style=\"{L_ANWSER.forward}\">Assign this question</a>"
			."&nbsp;&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp; <a href=\"#reolyform\" onclick=\"replyactive();\" class=\"detail-reply\" title=\"\">Or answer this question</a>";
			$editor='<textarea id="editor" name="editor" rows="20" cols="75"></textarea>';
			$editor='<textarea cols="80" id="editor_kama" name="editor_kama" rows="10"></textarea>';
			$template -> assign_vars(array(
			'editor2' => 	$editor,
			));
		}
		elseif (($profiles['code']=='cbqlht'||$profiles['code']=='gvhd' || $profiles['code']=='gvcm' ||$profiles['code']=='tro_giang_nganh')&&$answer_rows['assignid']==$profiles['id'])
		{
			$txt_reply = '<a href="#reolyform" onclick="replyactive();" class="detail-reply" title="">Answer this question |</a>';
			$editor='<textarea id="editor" name="editor" rows="20" cols="75"></textarea>';
			$editor='<textarea cols="80" id="editor_kama" name="editor_kama" rows="10"></textarea>';
			$template -> assign_vars(array(
			'editor2' => 	$editor,
			));
		}
		$template -> assign_block_vars('A_DETAIL', array(
		'group'			=> get_group($answer_rows['userid']).' lớp '.get_course($answer_rows['userid']),
		'uid'           => $answer_rows['userid'],
		'id'			=>  $answer_rows['id'],
		'title'			=> $answer_rows['answername'],
		'edit'			=> (return_answer_status($answer_rows['id']) && $thr_status['status']!=1) ? '' : (($answer_rows['userid'] == $profiles['id']&&$thr_status['status']!=1) ? ((return_answer_status($answer_rows['id'])==0) ? ' [ <a href="./?act=answers&do=edit&id='.$answer_rows['id'].'&thread='.$id.'&course='.$a_courseid.'" title="">Edit</a> ]': "") : ""),
		'picture'		=> ($answer_rows['picture']!=0) ? '<p><img src="'.$linkelearning.'/user/pix.php?file=/'.$answer_rows['userid'].'/f1.jpg" width="100" height="100" alt="" class="avatar" /></p>' : '<p><img src="./assets/images/nopic.gif" alt="" class="avatar" /></p>',
		'author'		=> $answer_rows['username'],
		'uname'       =>  get_name_from_id($answer_rows['userid']),
		'time'			=> (return_answer_status($answer_rows['id'])) ? 'Question time : '.date('d/m/Y H:i:s ',$answer_rows['time']) : 'Question time : '.date('d/m/Y H:i:s',$answer_rows['time']),
		'answerdes'		=> $answer_rows['answerdes'],
		'reply'			=> (($profiles['code']=='po2'|| $profiles['code']=='povh_lop_mon' || $profiles['code']=='povh_lop_mon' || $profiles['code']=='admin'|| $profiles['code']=='tro_giang_nganh'|| $answer_rows['assignid']==$profiles['id']) && $thr_status['status']!=1) ? $txt_reply : '',
		'attach'		=> ($answer_rows['attach']!= '') ? '<div class="detail-attach"><a href="./uploads/'.$answer_rows['attach'].'">'.$answer_rows['attach'].'</a></div>' : '',
		'topic'			=> '<span class="open">'.$answer_rows['topicname'].'</span>',
		'cname'         => $answer_rows['fullname'],
		'forward'		=> ($answer_rows['assignid']==$profiles['id'] && check_have_reply($answer_rows['id'])==0 && $thr_status['status']!=1) ? '<a class="modal" rel="{handler: \'iframe\', size: {x: 430, y: 150}}"  href="./?do=alert_unassign&id='.$answer_rows['id'].'&thr_id='.$id.'"> <b>Reject question</b>&nbsp;</a>' : '',
		'close'			=> '',
		'link'          =>  ($profiles['code']=='povh_lop_mon')||($profiles['code']=='admin') ? '<a href="ds_cvht.html" rel="{handler: \'iframe\', size: {x: 750, y: 500}}" class="modal">QLHT List</a> &nbsp;<a href="ds_po.html" rel="{handler: \'iframe\', size: {x: 750, y: 500}}" class="modal">PO list</a> &nbsp;<a class="modal" rel="{handler: \'iframe\', size: {x: 570, y: 550}}" href="?act=getlink&qid='.base64_encode($answer_rows['id']).'&time='.base64_encode(time()).'&username='.md5('h2472support').'&from='.base64_encode($profiles['id']).'">Send e-email request answer</a>':'',
		'thread_edit'          =>  ($profiles['code']=='povh_lop_mon')||($profiles['code']=='admin') ? '<a class="modal" rel="{handler: \'iframe\', size: {x: 600, y: 240}}"  href="?do=edit_thread&id='.$id.'"><img  style="border-style: none;" src="images/edit.png"/></a>':'',
		));
		//'forward'		=> ($answer_rows['assignid']==$profiles['id'] && check_have_reply($answer_rows['id'])==0 && $thr_status['status']!=1) ? '<a href="./?act=answers&do=unassign&id='.$answer_rows['id'].'&thr_id='.$id.'" class="detail-reply"  title=""> Từ chối trả lời&nbsp;</a>' : '',
	}
}
if($thr_status['status']!=1)
{
	$template -> assign_vars(array(
	'close' => 	($profiles['code']=='po2' || $profiles['code']=='povh_lop_mon' ||$profiles['code']=='admin' || $profiles['code']=='gvcm' || $profiles['code']=='gvhd' || check_have_reply($answer_rows['id'])==1) ? '<a href="./?act=answers&do=close&id='.$id.'" class="answerother" title="">&nbsp;Close topic&nbsp;&nbsp;</a>' : '',
	));
}
if($thr_status['status']==1)
{
	$template -> assign_vars(array(
	'close' => 	($profiles['code']=='po2' || $profiles['code']=='povh_lop_mon' || $profiles['code']=='admin' || $profiles['code']=='gvcm' || $profiles['code']=='gvhd' || check_have_reply($answer_rows['id'])==1) ? '<a href="./?act=answers&do=open&id='.$id.'" class="answerother" title="">Open topic&nbsp;&nbsp;</a>' : '',
	));
}
if($thr_status['knowledgebase']==0)
{
	$template -> assign_vars(array(
	'setkkt' => 	($profiles['code']=='po2' || $profiles['code']=='povh_lop_mon' || $profiles['code']=='admin' || $profiles['code']=='gvcm' || $profiles['code']=='gvhd') ? '<a href="./?act=answers&do=set_kkt&id='.$id.'" class="answerother" title="">Move to Knowledge base | </a>' : '',
	));
}
if($thr_status['knowledgebase']==1)
{
	$template -> assign_vars(array(
	'setkkt' => 	($profiles['code']=='po2' || $profiles['code']=='povh_lop_mon' || $profiles['code']=='admin' || $profiles['code']=='gvcm' || $profiles['code']=='gvhd') ? '<a href="./?act=answers&do=unset_kkt&id='.$id.'" class="answerother" title="">Discard from Knowledge base | </a>' : '',
	));
}
if($profiles['code']=='hoc_vien' && ($a_author != $profiles['id']))
$per = false;
$bOK = true;
$p_submit = $_POST['addreply'];
if($p_submit == 'Chấp nhận' && $per) {
	$file1Name 		= $_FILES['attach']['name'];
	$file1Type 		= $_FILES['attach']['type'];
	$file1Temp 		= $_FILES['attach']['tmp_name'];
	$p_editor 		= $_POST['editor_kama'];
	if($bOK) {
		if( !isset($p_editor) || $p_editor=='' ) {
			$bOK = false;
			if(isset($p))
			echo '<script>window.location="./?act=answers&do=detail&id='.$id.'&p='.$p.'&mess=2";</script>';
			else
			echo '<script>window.location="./?act=answers&do=detail&id='.$id.'&mess=2";</script>';
		} else {
			$bOK = true;
		}
		if($bOK)
		{
			if (!empty($file1Name))
			{
				if($file1Type=="image/jpeg"||$file1Type=="image/gif"||$file1Type=="image/png") {
					$result = @upload_files($file1Name, $file1Type, $file1Temp, $dir_upload);
				} elseif( $file1Type=="application/msword"||$file1Type=="text/plain"||$file1Type=="application/vnd.ms-excel"||$file1Type=="application/zip"||$file1Type=="application/rar"||$file1Type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" ||$file1Type=="application/octet-stream" ||$file1Type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  	

||$file1Type=="application/vnd.ms-powerpoint" ||$file1Type=="application/vnd.openxmlformats-officedocument.presentationml.presentation" ||$file1Type=="application/pdf" ) {
					$result = @upload_files_doc($file1Name, $file1Type, $file1Temp, $data_upload);
				}
				if(!$result)
				{
					$bOK = false;
					if(isset($p))
					echo '<script>window.location="./?act=answers&do=detail&id='.$id.'&p='.$p.'&mess=1";</script>';
					else
					echo '<script>window.location="./?act=answers&do=detail&id='.$id.'&mess=1";</script>';
				}
				else
				$file1 = $file1Name . $file1Type;
			}
			$sql_answer_insert = "INSERT INTO tblreply (userid, answerid, replydes, attach, time)
								VALUES('".$profiles['id']."', '".$a_id."', '".$p_editor."', '".$file1."', '".time()."')";
			$sql_answer_insert = $db->sql_query($sql_answer_insert) or die(mysql_error());
			$sql_answer_update = "UPDATE  tblthread set status=2,reply_time='".time()."',assignid='".$profiles['id']."'  where id='".$id."'";
			$sql_answer_update = $db->sql_query($sql_answer_update) or die(mysql_error());
			// Thong bao insert thanh cong
			if(isset($p))
			echo '<script>window.location="./?act=answers&do=detail&id='.$id.'&p='.$p.'";</script>';
			else
			echo '<script>window.location="./?act=answers&do=detail&id='.$id.'";</script>';
		}
	}
}
//------------------------------------------------------------
$q_submit = $_POST['addquestion'];
if($q_submit == 'Chấp nhận') {
	$file1Name 		= $_FILES['attach']['name'];
	$file1Type 		= $_FILES['attach']['type'];
	$file1Temp 		= $_FILES['attach']['tmp_name'];
	$p_editor 		= $_POST['editor_kama'];
	if($bOK) {
		if( !isset($p_editor) || $p_editor=='' ) {
			$bOK = false;
			if(isset($p))
			echo '<script>window.location="./?act=answers&do=detail&id='.$id.'&p='.$p.'&mess=2";</script>';
			else
			echo '<script>window.location="./?act=answers&do=detail&id='.$id.'&mess=2";</script>';
		} else {
			$bOK = true;
		}
		if($bOK)
		{
			if (!empty($file1Name))
			{
				if($file1Type=="image/jpeg"||$file1Type=="image/gif"||$file1Type=="image/png") {
					$result = @upload_files($file1Name, $file1Type, $file1Temp, $dir_upload);
				} elseif( $file1Type=="application/msword"||$file1Type=="text/plain"||$file1Type=="application/vnd.ms-excel"||$file1Type=="application/zip"||$file1Type=="application/rar"||$file1Type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" ||$file1Type=="application/octet-stream" ||$file1Type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"  	

||$file1Type=="application/vnd.ms-powerpoint" ||$file1Type=="application/vnd.openxmlformats-officedocument.presentationml.presentation" ||$file1Type=="application/pdf" ) {
					$result = @upload_files_doc($file1Name, $file1Type, $file1Temp, $data_upload);
				}
				if(!$result)
				{
					$bOK = false;
					if(isset($p))
					echo '<script>window.location="./?act=answers&do=detail&id='.$id.'&p='.$p.'&mess=1";</script>';
					else
					echo '<script>window.location="./?act=answers&do=detail&id='.$id.'&mess=1";</script>';
				}
				else
				$file1 = $file1Name . $file1Type;
			}
			$sql_question_insert = "INSERT INTO tblanswer (answername, class_id, topicid, courseid, groupid, userid, answerdes, attach, time, setting, status, parent, voteup, votedown,count,thread)
								VALUES('".$a_name."', '".$a_classid."', '".$a_topicid."', '".$a_courseid."', '".$a_groupid."', '".$a_userid."', '".$p_editor."', '".$file1."', '".time()."', '0', '0', '".$id."', '0', '0', '0','".$id."')";
			$sql_question_insert = $db->sql_query($sql_question_insert) or die(mysql_error());
			$sql_question_update = "UPDATE tblthread set answername='".$a_name."', class_id='".$a_classid."', topicid= '".$a_topicid."', courseid='".$a_courseid."', groupid='".$a_groupid."', userid='".$a_userid."',assignid='0',answerdes='".$p_editor."', attach='".$file1."', time='".time()."', setting='0', status='0', parent='0', voteup='0', votedown='0',count='0',reply_time='0'
								    WHERE id='".$id."'";
			$sql_question_thread = $db->sql_query($sql_question_update) or die(mysql_error());
			// Thong bao insert thanh cong
			if(isset($p))
			echo '<script>window.location="./?act=answers&do=detail&id='.$id.'&p='.$p.'";</script>';
			else
			echo '<script>window.location="./?act=answers&do=detail&id='.$id.'";</script>';
		}
	}
}
/***********************************REPLY***********************************************/
$sql_asign="select assignid from tblthread where id = '$id'";
$sql_asign = $db->sql_query($sql_asign) or die(mysql_error());
//---------------------------------------------------------------------------
while ($assigner = $db->sql_fetchrow($sql_asign))
$template -> assign_vars(array(
'assigner' =>get_name_from_id($assigner['assignid']),
));
//set link
$template->assign_vars(array(
'linkportal'		=> $linkportal,
'linkforum'         => $linkforum, 
'linkelearning'     => $linkelearning,
));	
$template -> pparse('answers-detail');
?>
