<?php
/**
 * Return decoded agent string. 'DoCoMo'', 'Vodafone'', 'EZweb' or 'AirHPhone' or
 * if this is not an access from a Japanese mobile phone return ''
 * 
 * @uses $_SERVER
 */
function mfm_agent() {
    $docomoRegex    = '^DoCoMo/\d\.\d[ /]';
    $vodafoneRegex  = '^(?:(?:Vodafone|J-PHONE|SoftBank)/\d\.\d|MOT-)';
    $ezwebRegex     = '^(?:KDDI-[A-Z]+\d+[A-Z]? )?UP\.Browser\/';
    $airhphoneRegex = '^Mozilla/3\.0\((?:DDIPOCKET|WILLCOM);';
    $symbianRegex= '; Symbian OS;';
    $operaminiRegex= 'J2ME/MIDP; Opera Mini';
    $mobileRegex =
        "(?:($docomoRegex)|($vodafoneRegex)|($ezwebRegex)|($airhphoneRegex)|($symbianRegex)|($operaminiRegex))";
    
    $ua=$_SERVER['HTTP_USER_AGENT'];
    $agent = '';
    if (preg_match("!$mobileRegex!", $ua, $matches)) {
        $agent = @$matches[1] ? 'DoCoMo' :
            (@$matches[2] ? 'Vodafone' :
            (@$matches[3] ? 'EZweb' :
            (@$matches[4] ? 'AirHPhone':
            (@$matches[5] ? 'SymbianOS' :
                            'OperaMini')
        )));
       return $agent;

    }else {
        return false;
    }
}
/**
 * Recursive implementation of mb_convert_encoding()
 *
 * @param mixed $var the variable to convert the character encoding of
 * @param mixed $to char set to convert to
 * @param mixed $from  char set to convert from
 * @return mixed
 */
function mfm_conv_inp_enc_recursive($var, $to='UTF-8', $from='SJIS') {
    if(is_object($var)) {
        $properties = get_object_vars($var);
        foreach($properties as $property => $value) {
            $var->$property = mfm_conv_inp_enc_recursive($value, $to, $from);
        }
    }
    else if(is_array($var)) {
        foreach($var as $property => $value) {
            $var[$property] = mfm_conv_inp_enc_recursive($value, $to, $from);
        }
    }
    else if(is_string($var)) {
        $var = mb_convert_encoding($var, $to, $from);
    }
    return $var;
}
$CFG->mfm_dirroot=$CFG->dirroot.'/mobile/customscripts';
$CFG->mfm_wwwroot=$CFG->wwwroot.'/mobile/www';
if ($CFG->mfm_agent=mfm_agent()){
    
    //mobile phone
        
    //this may be turned on in config.php as well to allow 
    //cookieless access for a regular browser.
    //But we will also force it on here because for mobile phones it
    //is essential.
    $CFG->usesid=true;
    $_POST=mfm_conv_inp_enc_recursive($_POST);
    
    
    $CFG->customscripts=$CFG->mfm_dirroot;
    $CFG->themedir=$CFG->mfm_dirroot.'/theme/';
    $CFG->themewww=$CFG->mfm_wwwroot.'/theme/';
    
    //functions for mobile phones
    require_once($CFG->mfm_dirroot.'/lib/weblib.php');
    require_once($CFG->mfm_dirroot.'/lib/moodlelib.php');
    require_once($CFG->mfm_dirroot.'/lib/accesslib.php');
    
    //now start regular setup.php
    require_once("$CFG->dirroot/lib/setup.php");
} else {
    //not a mobile phone
    require_once("$CFG->dirroot/lib/setup.php");
    
}

?>
