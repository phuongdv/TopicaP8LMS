<?php // $Id: view.php,v 1.106.2.6 2009/02/12 02:29:34 jerome Exp $

//  Display the course home page.

    require_once('../config.php');
    require_once('lib.php');
    require_once($CFG->libdir.'/blocklib.php');
    require_once($CFG->libdir.'/ajax/ajaxlib.php');
    require_once($CFG->dirroot.'/mod/forum/lib.php');

    $id          = optional_param('id', 0, PARAM_INT);
    $name        = optional_param('name', '', PARAM_RAW);
    $edit        = optional_param('edit', -1, PARAM_BOOL);
    $hide        = optional_param('hide', 0, PARAM_INT);
    $show        = optional_param('show', 0, PARAM_INT);
    $idnumber    = optional_param('idnumber', '', PARAM_RAW);
    $section     = optional_param('section', 0, PARAM_INT);
    $move        = optional_param('move', 0, PARAM_INT);
    $marker      = optional_param('marker',-1 , PARAM_INT);
    $switchrole  = optional_param('switchrole',-1, PARAM_INT);

//Begin Intergrade mdl-vbb
	function curPageURL() {
	 $pageURL = 'http';
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
	}
	$url=curPageURL();
	setcookie("f","",time()-3600*24,"/","topica.vn");
	setcookie("user", $url,time()-3600*24,"/","topica.vn");
	setcookie("user", $url,time()+3600*24,"/","topica.vn");

if($USER->username!='')
   {
    // set cookie
            
            require '../vietth/securecookie.php';
            $C = new SecureCookie('6rCgffX5mX','Iq6cJ0116W',time()+3600*24,'/','topica.vn');
			$C->Set('username',$USER->username);
			$C->Set('password',$USER->password);
			$C->Set('email',$USER->email);
			$C->Set('source','TVU');
			$C->Set('login','1');
       // end set cookie
    
       // end set cookie
   }

	
//Eng Intergrade mdl-vbb

    if (empty($id) && empty($name) && empty($idnumber)) {
        error("Must specify course id, short name or idnumber");
    }

    if (!empty($name)) {
        if (! ($course = get_record('course', 'shortname', $name)) ) {
            error('Invalid short course name');
        }
    } else if (!empty($idnumber)) {
        if (! ($course = get_record('course', 'idnumber', $idnumber)) ) {
            error('Invalid course idnumber');
        }
    } else {
        if (! ($course = get_record('course', 'id', $id)) ) {
            error('Invalid course id');
        }
    }

    preload_course_contexts($course->id);
    if (!$context = get_context_instance(CONTEXT_COURSE, $course->id)) {
        print_error('nocontext');
    }

    // Remove any switched roles before checking login
    if ($switchrole == 0 && confirm_sesskey()) {
        role_switch($switchrole, $context);
    }

    require_login($course);

    // Switchrole - sanity check in cost-order...
    $reset_user_allowed_editing = false;
    if ($switchrole > 0 && confirm_sesskey() &&
        has_capability('moodle/role:switchroles', $context)) {
        // is this role assignable in this context?
        // inquiring minds want to know...
        $aroles = get_assignable_roles_for_switchrole($context);
        if (is_array($aroles) && isset($aroles[$switchrole])) {
            role_switch($switchrole, $context);
            // Double check that this role is allowed here
            require_login($course->id);
        }
        // reset course page state - this prevents some weird problems ;-)
        $USER->activitycopy = false;
        $USER->activitycopycourse = NULL;
        unset($USER->activitycopyname);
        unset($SESSION->modform);
        $USER->editing = 0;
        $reset_user_allowed_editing = true;
    }

    //If course is hosted on an external server, redirect to corresponding
    //url with appropriate authentication attached as parameter 
    if (file_exists($CFG->dirroot .'/course/externservercourse.php')) {
        include $CFG->dirroot .'/course/externservercourse.php';
        if (function_exists('extern_server_course')) {
            if ($extern_url = extern_server_course($course)) {
                redirect($extern_url);
            }
        }
    }


    require_once($CFG->dirroot.'/calendar/lib.php');    /// This is after login because it needs $USER

    add_to_log($course->id, 'course', 'view', "view.php?id=$course->id", "$course->id");

    $course->format = clean_param($course->format, PARAM_ALPHA);
    if (!file_exists($CFG->dirroot.'/course/format/'.$course->format.'/format.php')) {
        $course->format = 'weeks';  // Default format is weeks
    }

    $PAGE = page_create_object(PAGE_COURSE_VIEW, $course->id);
    $pageblocks = blocks_setup($PAGE, BLOCKS_PINNED_BOTH);

    if ($reset_user_allowed_editing) {
        // ugly hack
        unset($PAGE->_user_allowed_editing);
    }

    if (!isset($USER->editing)) {
        $USER->editing = 0;
    }
    if ($PAGE->user_allowed_editing()) {
        if (($edit == 1) and confirm_sesskey()) {
            $USER->editing = 1;
        } else if (($edit == 0) and confirm_sesskey()) {
            $USER->editing = 0;
            if(!empty($USER->activitycopy) && $USER->activitycopycourse == $course->id) {
                $USER->activitycopy       = false;
                $USER->activitycopycourse = NULL;
            }
        }

        if ($hide && confirm_sesskey()) {
            set_section_visible($course->id, $hide, '0');
        }

        if ($show && confirm_sesskey()) {
            set_section_visible($course->id, $show, '1');
        }

        if (!empty($section)) {
            if (!empty($move) and confirm_sesskey()) {
                if (!move_section($course, $section, $move)) {
                    notify('An error occurred while moving a section');
                }
            }
        }
    } else {
        $USER->editing = 0;
    }

    $SESSION->fromdiscussion = $CFG->wwwroot .'/course/view.php?id='. $course->id;


    if ($course->id == SITEID) {
        // This course is not a real course.
        redirect($CFG->wwwroot .'/');
    }


    // AJAX-capable course format?
    $useajax = false; 
    $ajaxformatfile = $CFG->dirroot.'/course/format/'.$course->format.'/ajax.php';
    $bodytags = '';

    if (empty($CFG->disablecourseajax) and file_exists($ajaxformatfile)) {      // Needs to exist otherwise no AJAX by default

        // TODO: stop abusing CFG global here
        $CFG->ajaxcapable = false;           // May be overridden later by ajaxformatfile
        $CFG->ajaxtestedbrowsers = array();  // May be overridden later by ajaxformatfile

        require_once($ajaxformatfile);

        if (!empty($USER->editing) && $CFG->ajaxcapable && has_capability('moodle/course:manageactivities', $context)) {
                                                             // Course-based switches

            if (ajaxenabled($CFG->ajaxtestedbrowsers)) {     // Browser, user and site-based switches
                
                require_js(array('yui_yahoo',
                                 'yui_dom',
                                 'yui_event',
                                 'yui_dragdrop',
                                 'yui_connection',
                                 'ajaxcourse_blocks',
                                 'ajaxcourse_sections'));
                
                if (debugging('', DEBUG_DEVELOPER)) {
                    require_js(array('yui_logger'));

                    $bodytags = 'onload = "javascript:
                    show_logger = function() {
                        var logreader = new YAHOO.widget.LogReader();
                        logreader.newestOnTop = false;
                        logreader.setTitle(\'Moodle Debug: YUI Log Console\');
                    };
                    show_logger();
                    "';
                }

                // Okay, global variable alert. VERY UGLY. We need to create
                // this object here before the <blockname>_print_block()
                // function is called, since that function needs to set some
                // stuff in the javascriptportal object.
                $COURSE->javascriptportal = new jsportal();
                $useajax = true;
            }
        }
    }

    $CFG->blocksdrag = $useajax;   // this will add a new class to the header so we can style differently


    $PAGE->print_header(get_string('course').': %fullname%', NULL, '', $bodytags);
    // Course wrapper start.
    echo '<div class="course-content">';

    $modinfo =& get_fast_modinfo($COURSE);
    get_all_mods($course->id, $mods, $modnames, $modnamesplural, $modnamesused);
    foreach($mods as $modid=>$unused) {
        if (!isset($modinfo->cms[$modid])) {
            rebuild_course_cache($course->id);
            $modinfo =& get_fast_modinfo($COURSE);
            debugging('Rebuilding course cache', DEBUG_DEVELOPER);
            break;
        }
    }

    if (! $sections = get_all_sections($course->id)) {   // No sections found
        // Double-check to be extra sure
        if (! $section = get_record('course_sections', 'course', $course->id, 'section', 0)) {
            $section->course = $course->id;   // Create a default section.
            $section->section = 0;
            $section->visible = 1;
            $section->id = insert_record('course_sections', $section);
        }
        if (! $sections = get_all_sections($course->id) ) {      // Try again
            error('Error finding or creating section structures for this course');
        }
    }

    // Include the actual course format.
    require($CFG->dirroot .'/course/format/'. $course->format .'/format.php');
    // Content wrapper end.
    echo "</div>\n\n";


    // Use AJAX?
    if ($useajax && has_capability('moodle/course:manageactivities', $context)) {
        // At the bottom because we want to process sections and activities
        // after the relevant html has been generated. We're forced to do this
        // because of the way in which lib/ajax/ajaxcourse.js is written.
        echo '<script type="text/javascript" ';
        echo "src=\"{$CFG->wwwroot}/lib/ajax/ajaxcourse.js\"></script>\n";

        $COURSE->javascriptportal->print_javascript($course->id);
    }

	   // create db conn
	    $mysqli = new mysqli($CFG->dbhost,$CFG->dbuser,$CFG->dbpass);
		$mysqli->select_db($CFG->dbname);
	    $mysqli->query("SET NAMES 'utf8'");
	   // find btvn cua course
	    
	   $sql  = "SELECT
						q.name,q.id,q.timeclose
					FROM
						huy_setting_lipe hsl
					INNER JOIN
					  mdl_quiz q 
					ON 
					  q.id = hsl.active_id
					WHERE
						hsl.c_id = ".$COURSE->id."
					AND hsl.lipe_type = 'E'
					ORDER BY id asc";
					
		$ad = $mysqli->query($sql);
		if (mysqli_num_rows($ad) > 0){
			$btvn_notifier = '';
			while($dd = $ad->fetch_assoc()) 
			{
				// kiem tra xem hv da lam bai chua
				//$sql_attempt = "select *  from mdl_quiz_attempts
				$sql_attempt = "select *  from vietth_q169_attempts
				        where quiz = ".$dd["id"]." and userid = ".$USER->id;
						
				$attempt  = $mysqli->query($sql_attempt);
				$count_attempt = mysqli_num_rows($attempt);
				// neu chua lam
				//if($count_attempt ==0)
				 //{
					 $btvn_notifier.= '<br><br>'.$dd["name"].' :';
					 // kiem tra xem het han chua
					 if($dd["timeclose"] <= time())
					 {
					
					  $btvn_notifier.= ' Đã hết hạn làm bài.';	 
					 }
					 else
					 {
					   	$remain = (secondsToTime($dd["timeclose"]- time()));
						$btvn_notifier.= ' Còn <strong style="color:yellow">'.$remain['d'].' ngày '.$remain['h'].' h '.$remain['m'].' Phút </strong>';
					    if($count_attempt >0)
						{
						// lay diem
						$sql = "select * from mdl_quiz_grades  where userid = ".$USER->id." and quiz = ".$dd["id"]." limit 0,1";
						$grade = $mysqli->query($sql);
						$grades = $grade->fetch_assoc();
						//danglx sua sql 13-11-2013
						$num_rows = mysqli_num_rows($grade);
						if($num_rows==0)
						{
						$sql = "select round(avg(sumgrade),2) grade from vietth_q169_attempts where quiz = ".$dd['id']." and userid = ".$USER->id." and deleted=0 and status='submited'";
						$grade = $mysqli->query($sql);
						$grades = $grade->fetch_assoc();
						}
						//end danglx
						$btvn_notifier.= '<br>Điểm đã đạt được là  <strong style="color:yellow">'.$grades['grade'].' điểm </strong>';
						}
					}
					 
				// }
			 }
			
		}
	// check bt ky nang
	    $sql_btkn = "select * from mdl_assignment 
		             where course = ".$COURSE->id." and 
					       `name` like '%bài tập kỹ năng%' 
				     ORDER BY id asc";
      
	   $ds_btkn = $mysqli->query($sql_btkn);
	   
		if (mysqli_num_rows($ds_btkn) > 0){
			$i=1;
			$btkn_notifier = '';
			while($btkn = $ds_btkn->fetch_assoc()) 
			{
			
			 // kiem tra xem hv da lam bai chua
			$sql = "select * from mdl_assignment_submissions where assignment = '".$btkn['id']."' and userid = ".$USER->id;
		//	echo $sql;
			$user_btkn = $mysqli->query($sql);
			if(mysqli_num_rows($user_btkn) == 0)
			 {
				$btkn_notifier.='<br /><br>Bài tập kỹ năng '.$i.': ';
				 if($btkn["timedue"] <= time())
					 {
					
					  $btkn_notifier.= ' Đã hết hạn nộp bài<br><br>';	 
					 }
				else
					 {
					   	$remain = (secondsToTime($btkn["timedue"]- time()));
						$btkn_notifier.= ' Còn <strong style="color:yellow">'.$remain['d'].' ngày '.$remain['h'].' h '.$remain['m'].' Phút </strong><br><br>';
					 }
				 
			 }
			//echo $sql;
			$i++;
			}
		   // tinh diem chuyen can
		  
		   
		
		
		}
		
	   // danglx 4-10-2013 : loai bo course odc ra khoi ds
	   $find   = 'ODC';
       $pos = strpos($COURSE->fullname, $find);
	   //end danglx : loai bo course odc ra khoi ds
	   //close connection
	   $mysqli->close();
	   if($pos === false && ($btvn_notifier!='' || $btkn_notifier!='') )
	   {
	?>
	<style type="text/css">

		* html div#fl813691 {position: absolute; overflow:hidden;

		top:expression(eval(document.compatMode &amp;&amp;

		document.compatMode=='CSS1Compat') ?

		documentElement.scrollTop

		+(documentElement.clientHeight-this.clientHeight)

		: document.body.scrollTop

		+(document.body.clientHeight-this.clientHeight));}

		#fl813691{background-color:#810c15; font: 12px Arial, Helvetica, sans-serif; color:#FFFFFF; font-weight: bold; position:fixed; _position: absolute; left:0; bottom:0; height:225px;width:320px; }

		#eb951855{ width:270px; padding-right:7px; background:url(http://lienthong.topica.edu.vn/wp-content/uploads/qc_right.gif) no-repeat right top;}

		#cob263512{background-color:#810C15; no-repeat left top; height:220px; padding-left:7px;}

		#coh963846{color:#FFFFFF;display:block; height:20px; line-height:18px; font-size:12px; width:px;}

		#coh963846 a{color:#690;text-decoration:none;}

		#coc67178{float:right; padding:0; margin:0; list-style:none; overflow:hidden; height:15px;}

					#coc67178 li{display:inline;}

					#coc67178 li a{background-image:url(../closebutton.gif); background-repeat:no-repeat; width:30px; height:0; padding-top:15px; overflow:hidden; float:left;}

						#coc67178 li a.close{background-position: 0 0;}

						#coc67178 li a.close:hover{background-position: 0 -15px;}

						#coc67178 li a.min{background-position: -30px 0;}

						#coc67178 li a.min:hover{background-position: -30px -15px;}

						#coc67178 li a.max{background-position: -60px 0;}

						#coc67178 li a.max:hover{background-position: -60px -15px;}

		#co453569{display:block; margin:0; padding:0; height:210px;  border-style:solid; border-width:0px; border-color:#111 #999 #999 #111; line-height:1.6em; overflow:hidden;}

		</style> 
     <div id="fl813691" style="height: 210px;z-index:95"> 
        <div id="eb951855 " style"z-index:96"> 
			<div id="cob263512" style"z-index:97"> 
			  <div style"z-index:98" id="coh963846"> 
					<ul id="coc67178"> 
						<li style="display: inline;" id="pf204652hide"><a class="min" href="javascript:pf204652clickhide();" title="&#7848;n &#273;i">
						Ẩn</a></li> 
						<li id="pf204652show" style="display: none;"><a class="max" href="javascript:pf204652clickshow();" title="Hi&#7879;n l&#234;n">
						Hiện </a></li> 
					</ul> 
	 				TH&#212;NG B&#193;O TH&#7900;I GIAN H&#7870;T H&#7840;N L&#192;M B&#192;I T&#7852;P
				</div> 
<?php echo $btvn_notifier ;?><br> 
<?php echo $btkn_notifier; ?><br>
		</div>
	</div>


<script type="text/javascript"> 

//<![CDATA[

pf204652bottomLayer = document.getElementById('fl813691');

var pf204652IntervalId = 0;

var pf204652maxHeight = 150;//Chieu cao khung quang cao

var pf204652minHeight = 20;

var pf204652curHeight = 0;

function pf204652show( ){

  pf204652curHeight += 2;

  if (pf204652curHeight > pf204652maxHeight){

	clearInterval ( pf204652IntervalId );

  }

  pf204652bottomLayer.style.height = pf204652curHeight+'px';

}

function pf204652hide( ){

  pf204652curHeight -= 3;

  if (pf204652curHeight < pf204652minHeight){

	clearInterval ( pf204652IntervalId );

  }

  pf204652bottomLayer.style.height = pf204652curHeight+'px';

}

pf204652IntervalId = setInterval ( 'pf204652show()', 5 );

function pf204652clickhide(){

	document.getElementById('pf204652hide').style.display='none';

	document.getElementById('pf204652show').style.display='inline';

	pf204652IntervalId = setInterval ( 'pf204652hide()', 5 );

}

function pf204652clickshow(){

	document.getElementById('pf204652hide').style.display='inline';

	document.getElementById('pf204652show').style.display='none';

	pf204652IntervalId = setInterval ( 'pf204652show()', 5 );

}

function pf204652clickclose(){

	document.body.style.marginBottom = '0px';

	pf204652bottomLayer.style.display = 'none';

}

//]]>

</script> 


	<?php
	   }
   

    print_footer(NULL, $course);
function secondsToTime($seconds)
{
	
    // extract hours
    $hours = floor($seconds / (60 * 60));
    
	// day 
	$day   =  floor($hours / 24);
	$divisor_hour = $hours % 24;
    // extract minutes
    $divisor_for_minutes = $seconds % (60 * 60);
    $minutes = floor($divisor_for_minutes / 60);
 
    // extract the remaining seconds
    $divisor_for_seconds = $divisor_for_minutes % 60;
    $seconds = ceil($divisor_for_seconds);
 
    // return the final array
    $obj = array(
	    "d" => (int) $day,
        "h" => (int) $divisor_hour,
        "m" => (int) $minutes,
        "s" => (int) $seconds,
    );
    return $obj;
}
?>