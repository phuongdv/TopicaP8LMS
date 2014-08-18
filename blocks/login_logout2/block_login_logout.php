<?PHP //$Id: block_login_logout.php,v 1.00.0.0 2008/09/09 08:30:00 $

class block_login_logout extends block_base {

    function init() {
		$this->title = get_string('blockname', 'block_login_logout');
        $this->version = 2008090900; 
    }

    function applicable_formats() {
        return array('all' => true);
    }
	
    function specialization() {
		if (!isloggedin() or isguestuser()) {
			$this->title = get_string('login');
		} else {
			$utz = get_user_timezone_offset();
			if ($utz == 99) {
				$ut = (date('G')*3600 + date('i')*60 + date('s'))/3600;
			} else {
				$ut = ((gmdate('G') + get_user_timezone_offset())*3600 + gmdate('i')*60 + gmdate('s'))/3600;
				If ($ut <= 0) { $ut = 24 + $ut; }
				If ($ut > 24) { $ut = $ut - 24; }
			}
			if ($ut < 12) {
				$this->title =  get_string('morning_time', 'block_login_logout');
			} elseif (($ut >=12 ) and ($ut < 19 )) {
				$this->title = get_string('afternoon_time', 'block_login_logout');
			} else {
				$this->title = get_string('night_time', 'block_login_logout');
			}
		}
    }

    function get_content () {
        global $USER, $CFG, $SESSION, $COURSE;
        $wwwroot = '';
        $signup = '';

        if ($this->content !== NULL) {
            return $this->content;
        }

        if (empty($CFG->loginhttps)) {
            $wwwroot = $CFG->wwwroot;
        } else {
            $wwwroot = str_replace("http://", "https://", $CFG->wwwroot);
        }
        
        if (!empty($CFG->registerauth)) {
            $authplugin = get_auth_plugin($CFG->registerauth);
            if ($authplugin->can_signup()) {
                $signup = $wwwroot . '/login/signup.php';
            }
        }
        $forgot = $wwwroot . '/login/forgot_password.php';

        $username = get_moodle_cookie() === 'nobody' ? '' : get_moodle_cookie();

        $this->content->footer = '';
        $this->content->text = '';

        if (!isloggedin() or isguestuser()) {

            $this->content->text .= "\n".'<form class="loginform" id="login" method="post" action="'.$wwwroot.'/login/index.php"><div align="center">';
            $this->content->text .= '<div class="c1 fld username">';
            //$this->content->text .= '<input type="text" name="username" id="login_username" value="'.get_string('username').'" /></div>';
            $this->content->text .="<input type=\"text\" name=\"username\" id=\"login_username\" value=\"Tên đăng nhập\" onfocus=\"if(this.value=='Tên đăng nhập')this.value='';\" onblur=\"if(this.value=='')this.value='Tên đăng nhập';\"></div>";
            //$this->content->text .="<input name="text" type="text" value="Click here to type" onfocus="if(this.value=='Click here to type')this.value='';" onblur="if(this.value=='')this.value='Click here to type';">
            $this->content->text .= '<br />';
            $this->content->text .= '<div class="c1 fld password">';
            $this->content->text .= "<input type=\"password\" name=\"password\" id=\"login_password\" value=\"password\" onfocus=\"if(this.value=='topica')this.value='';\" onblur=\"if(this.value=='')this.value='topica';\"></div>";
			            $this->content->text .='<input type="text" name="vietth" id="vietth" style="visibility:hidden"/>';
            $this->content->text .= '<br />';
            $this->content->text .= '<div class="c1 btn"><input type="submit" value="&nbsp;&nbsp;'.get_string('login').'&nbsp;&nbsp;" onClick="this.form.vietth.value=this.form.password.value"/></div>';
            $this->content->text .= "</div></form>\n";

            if (!empty($signup)) {
                $this->content->footer .= '<div><a href="'.$signup.'">'.get_string('startsignup').'</a></div>';
            }
            if (!empty($forgot)) {
                $this->content->footer .= '<div><a href="'.$forgot.'">'.get_string('forgotaccount').'</a></div>';
                $this->content->footer .= '<div><a href="ymsgr:sendim?0983818985&m=Toi bi mat mat khau dang nhap e-learning TOPICA"><img style="width: 64px; height: 16px;" src="http://opi.yahoo.com/online?u=0983818985&amp;m=g&amp;t=1&amp;l=us" border="0"></a></div>';
            }
		} else {

			$this->content->text .= '<div align="center"><div class="logoutusername"><a href="'.$CFG->wwwroot.'/user/view.php?id='.$USER->id.'&amp;course='.$COURSE->id.'">'.$USER->lastname.' '.$USER->firstname.'</a></div>';
			$this->content->text .= '<div class="logoutuserimg"><img src="'.$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f1.jpg" width="100" height="100" alt="Imagen" /></div>';
			$xyz=$_COOKIE["key"];
			
			$this->content->text .= '<div class="logoutfooter"><a href="'.$CFG->wwwroot.'/my">'.get_string('mycourses').'</a></div>';
			//$this->content->text .= '<a href="http://210.245.9.194/thang/cube/roundcubemail-0.3.1/adapter.php?u='.$USER->username.'&id='.$xyz.'" target="_blank"></br>mail</a></div>';
			$this->content->text .= '<form class="logoutform" id="logout" method="post" action="'.$CFG->wwwroot.'/login/logout.php?sesskey='.sesskey().'">';
			$this->content->text .= '<div class="logoutbtn"><input type="submit" value="&nbsp;&nbsp;'.get_string('logout').'&nbsp;&nbsp;" /></div></div>';
			$this->content->text .= "</form>";
//			$this->content->text .= '<div class="logoutfooter"><a href="'.$CFG->wwwroot.'/user/edit.php?id='.$USER->id.'&amp;course='.$COURSE->id.'">'.get_string('updatemyprofile').'</a></div>';
//			if($USER->lastlogin){
//				$this->content->text .= '<div class="logoutfooter">'.get_string('lastlogin').'<br>'.userdate($USER->lastlogin, get_string('strftimerecentfull')).'<br> ('.format_time(time() - $USER->lastlogin).') </div>';
//			}
		}  

        return $this->content;
    }
}

?>