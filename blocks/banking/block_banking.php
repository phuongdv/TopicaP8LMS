<?php
class block_banking extends block_base {
  function init() {
    $this->title   = 'Quản lý Tài khoản';
    $this->version = 2009111200;
  }

function get_content() {
	 global $USER, $SESSION, $CFG;
    if ($this->content !== NULL) {
      return $this->content;
    }
 
    $this->content         =  new stdClass;
  
     if($USER->topica_staff=='1') // check xem co phai nhan vien nha minh
    {
        $mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
	$mysqli->select_db($CFG->dbname);
	$mysqli->query("SET NAMES 'utf8'");
        $query_string = "SELECT u.id
                                                FROM mdl_user u
                                                INNER join mdl_role_assignments ra on ra.userid=u.id
                                                INNER join mdl_role r on r.id=ra.roleid 
                                                WHERE 
                                                ra.contextid = 1
                                                and r.id=1 and u.id='".$USER->id."'";
        $ad = $mysqli->query($query_string);
        if (mysqli_num_rows($ad) > 0)
		{
                 $query_string = "SELECT
	count(mdl_user.username)num
FROM
	mdl_user
LEFT JOIN tp_tai_khoan ON mdl_user.username = tp_tai_khoan.chu_tk
WHERE
    mdl_user.deleted !=1 and
	tp_tai_khoan.chu_tk IS NULL
";               
                 $num=$mysqli->query($query_string);
                 while($dd = $num->fetch_assoc()) 
			{
				
				$total = $dd["num"];
			}



		}

$this->content->text   = 'Số HV chưa có tài khoản :<br><div align="center"><span  style="color:#ff0000;">'.$total.'</span></div><br> <a href="bank/sync.php" target="_blank">Click vào đây để đồng bộ</a>';

    }
	else
	{
	$this->content->text ='';
	}
    
    
    
	
    $this->content->footer = '';
    return $this->content;
  }
}   
?>
