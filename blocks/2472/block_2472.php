<?php
class block_2472 extends block_base {
  function init() {
    $this->title   = get_string('block2472.main_menu', 'block_login_logout');
    $this->version = 2009111200;
  }

function get_content() {
	 global $USER, $SESSION, $CFG,$COURSE;
    if ($this->content !== NULL) {
      return $this->content;
    }

    //  start login:
    



    
     
    $this->content         =  new stdClass;
   // $link='http://elearning.dtu.topica.vn/h2472/?name='.$USER->username.'&ss='.$USER->password;
   if($COURSE->id!=1)
   {
   $link='http://elearning.tvu.topica.vn/h2472/?subject='.$COURSE->id; 
   }
   else
   {
   $link='http://elearning.tvu.topica.vn/h2472/'; 
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
    $this->content->text   =get_string('block2472.dangnhapdevaoh2472', 'block_login_logout');	
    	
    }
    else 
    {
 
    if($COURSE->id==1)
    {
    $course=238;
    $thongbao='<span style="color:red;"> '.get_string('block2472.chuy', 'block_login_logout').' : </span>'.get_string('block2472.khoanaychinhannhungcauhoilienquantoih2472', 'block_login_logout');
    }
    elseif ($COURSE->id>1)
    {
    $course=$COURSE->id;	
    }
    	
    $this->content->text   = '<table width="200" border="0">
  <tr>
    <td colspan="2"><div align="center">'.get_string('block2472.caccauhoicuatoi', 'block_login_logout').': ('.$reply.'/'.$total.')</div></td>
  </tr>
  <tr>
    <td rowspan="2"><img src=".././2472.jpg" width="70" height="71" /></td>
    <td><a href="'.$link.'">'.get_string('block2472.xemchitiet', 'block_login_logout').'</a></td>
  </tr>
  <tr>
    <td>'.$thongbao.'</td>
    <td style="display:none">'.$_SESSION['fe']['username'].'</td>
    
    </tr>
  <tr>
    <td colspan="2">';

	$this->content->text.='<a href="http://elearning.tvu.topica.vn/h2472/?act=answers&do=creat&course='.$course.'&topic=0">'.get_string('block2472.datcauhoi', 'block_login_logout').'</a></td>';
    
    
    $this->content->text.='</tr>
    
   <tr>
    <td></td>
    <td style="display:none">xxxxxx</td>
    </tr>
</table><!-- <a target="_blank" href="http://www.topica.vn/elearning/course/view.php?id=238">'.get_string('block2472.xemtailieuhuongdan', 'block_login_logout').'</a>-->';
    
    }
	$ad->close();
	$mysqli->close(); 
    $this->content->footer = '';
    return $this->content;
    
}
}   
?>