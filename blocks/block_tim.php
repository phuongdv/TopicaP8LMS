<?php
class block_tim extends block_base {
  function init() {
    $this->title   = 'TIM';
    $this->version = 2009111200;
  }

function get_content() {
	 global $USER, $SESSION, $CFG,$COURSE;
    if ($this->content !== NULL) {
      return $this->content;
    }

    //  start login:
    



    
     
    $this->content         =  new stdClass;
   // $link='http://www.topica.vn/h2472/?name='.$USER->username.'&ss='.$USER->password;
   if($COURSE->id!=1)
   {
   $link='http://elearning.hou.topica.vn/h2472/?subject='.$COURSE->id; 
   }
   else
   {
   $link='http://elearning.hou.topica.vn/h2472/?subject=1333'; 
   }
   $mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
	$mysqli->query("SET NAMES 'utf8'");
	
	if(isset($COURSE->id))
	{
		$query_string = "select count(*) count FROM tblanswer where courseid='$COURSE->id' and ( userid = '$USER->id' or assignid='$USER->id')";
        $reply_count_sql="select count(tblreply.answerid) count from tblreply,tblanswer where tblanswer.id = tblreply.answerid and tblanswer.courseid='$COURSE->id' and  (tblreply.userid='$USER->id' or tblreply.answerid=$USER->id)";
	
	}
	else 
	{
	$query_string = "select count(*) count FROM tblanswer where userid = '$USER->id' or assignid='$USER->id'";
	$reply_count_sql="select count(tblreply.answerid) count from tblreply,tblanswer where tblreply.userid='$USER->id'";
	}

	$ad = $mysqli->query($query_string);
		if (mysqli_num_rows($ad) > 0){
			while($dd = $ad->fetch_assoc()) 
			{
				
				$total = $dd["count"];
			 }
			
		}
	
	$rc = $mysqli->query($reply_count_sql);
		if (mysqli_num_rows($rc) > 0){
			while($dd = $rc->fetch_assoc()) 
			{
				$reply = $dd["count"];
			 }
			
		}

	
	
	

    if($USER->id==0)
    {
    $this->content->text   = 'Bạn cần đăng nhập để vào H2472';	
    	
    }
    else 
    {
 
    if($COURSE->id==1)
    {
    $course=1333;
    $thongbao='<span style="color:red;"> Chú ý : </span>Khóa này chỉ nhận các câu hỏi kỹ thuật liên quan đến H2472';
    }
    elseif ($COURSE->id>1)
    {
    $course=$COURSE->id;	
    }
    	
    $this->content->text   = '<table width="200" border="0">
  <tr>
    <td colspan="2"><div align="center">Các câu hỏi của tôi: ('.$reply.'/'.$total.')</div></td>
  </tr>
  <tr>
    <td rowspan="2"><img src="http://elearning.hou.topica.vn/2472.jpg" width="70" height="71" /></td>
    <td><a href="'.$link.'">Xem chi tiết</a></td>
  </tr>
  <tr>
    <td>'.$thongbao.'</td>
    <td style="display:none">'.$_SESSION['fe']['username'].'</td>
    
    </tr>
  <tr>
    <td colspan="2"><a href="http://elearning.hou.topica.vn/h2472/?act=answers&do=creat&course='.$course.'&topic=0">Đặt câu hỏi</a></td>
    
    
    </tr>
    
   <tr>
    <td></td>
    <td style="display:none">xxxxxx</td>
    </tr>
</table><a target="_blank" href="http://elearning.hou.topica.vn/course/view.php?id=1333">Xem tài liệu hướng dẫn</a>';
    
    }
	$ad->close();
	$mysqli->close(); 
    $this->content->footer = '';
    return $this->content;
    
}
}   
?>