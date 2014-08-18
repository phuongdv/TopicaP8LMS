<?
/**
*  Session Handling
*  @author		: Vu Quoc Trung (vuquoctrung@gmail.com)
*  @date		: 25/11/2006
*  @version		: 1.0.0
*/
if (!isset($SESSION_NAME)){
	$SESSION_NAME = "VNNC";
}
$SESSION_NAME = $SESSION_NAME."_".$_SITE_ROOT;
/**
 * Set up session handling
 */
function vnSessionSetup(){
	global $SESSION_NAME, $SESSION_COOKIE, $SESSION_TIME_OUT;
	$path = "/";
    $host = $_SERVER['HTTP_HOST'];
    $host = preg_replace('/:.*/', '', $host);
    $lifetime = 0;
    // Stop adding SID to URLs
    @ini_set('session.use_trans_sid', 0);
    // How to store data
    @ini_set('session.serialize_handler', 'php');
    // Use cookie to store the session ID
    @ini_set('session.use_cookies', $SESSION_COOKIE);
    // Name of our cookie
    @ini_set('session.name', $SESSION_NAME);
	@session_name($SESSION_NAME);
	// Check each HTTP Referer
    @ini_set('session.referer_check', "$host");
	// Life time of cookie
    @ini_set('session.cookie_lifetime', $SESSION_TIME_OUT);
	@session_set_cookie_params($SESSION_TIME_OUT);
    // Auto-start session
    @ini_set('session.auto_start', 1);
    return true;
} 

/**
 * Initialise session
 */
function vnSessionInit($_sessid=""){
	global $SESSION_NAME;
	$ok = false;
	//echo session_name();
	//if (@ini_get('session.name')!=$SESSION_NAME) return false;
	if (@session_name()!=$SESSION_NAME){
		echo "	<script language='javascript'>
					alert('Your session name is not valid!');					
					</script>";
		return false;
	}
	
    session_start();
    header('Cache-Control: cache');
	
	if ($_sessid!=""){
 	   $sessid = session_id($_sessid);
    }else{
	   $sessid = session_id();
	}
    return true;
} 

/**
 * Get a session variable
 * @param name $ name of the session variable to get
 */
function vnSessionGetVar($name){
	global $SESSION_NAME;
	//print_r($_SESSION);echo $name."<BR>";
    if(isset($_SESSION[$SESSION_NAME.'_'.$name])) {
        return $_SESSION[$SESSION_NAME.'_'.$name];
    }
    return false;
}

/**
 * Determine a session variable is set or not
 * @param name $ name of the session variable
 */
function vnSessionExist($name) {
	global $SESSION_NAME;
	if(isset($_SESSION[$SESSION_NAME.'_'.$name])) {
    return true;
  }
  return false;
}

/**
 * Set a session variable
 * @param name $ name of the session variable to set
 * @param value $ value to set the named session variable
 */
function vnSessionSetVar($name, $value){
	global $SESSION_NAME;
    $_SESSION[$SESSION_NAME.'_'.$name] = $value;
    return true;
} 

/**
 * Delete a session variable
 * @param name $ name of the session variable to delete
 */
function vnSessionDelVar($name){
	global $SESSION_NAME;
    unset($_SESSION[$SESSION_NAME.'_'.$name]);
    unset($GLOBALS[$SESSION_NAME.'_'.$name]);
    return true;
} 

?>