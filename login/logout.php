<?php // $Id: logout.php,v 1.25 2007/05/15 21:13:23 skodak Exp $
// Logs the user out and sends them to the home page

    require_once("../config.php");
	 $_SESSION['h2472'] = "";
	 
	require '../vietth/securecookie.php';
			$C = new SecureCookie('6rCgffX5mX','Iq6cJ0116W',time()+3600,'/','.topica.vn');
            $C->Set('login','0');

			
	
	
	
   
   
    // can be overriden by auth plugins
    $redirect = $CFG->wwwroot.'/';
     
    $sesskey = optional_param('sesskey', '__notpresent__', PARAM_RAW); // we want not null default to prevent required sesskey warning

    if (!isloggedin()) {
        // no confirmation, user has already logged out
        require_logout();
        redirect($redirect);

    } else if (!confirm_sesskey($sesskey)) {
        print_header($SITE->fullname, $SITE->fullname, 'home');
        notice_yesno(get_string('logoutconfirm'), 'logout.php', $CFG->wwwroot.'/', array('sesskey'=>sesskey()), null, 'post', 'get');
        print_footer();
        die;
    }

    $authsequence = get_enabled_auth_plugins(); // auths, in sequence
    foreach($authsequence as $authname) {
        $authplugin = get_auth_plugin($authname);
        $authplugin->logoutpage_hook();
    }

    require_logout();

    redirect($redirect);

?>
