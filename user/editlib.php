<?php  //$Id: editlib.php,v 1.11.2.10 2008/07/05 22:46:58 skodak Exp $

function cancel_email_update($userid) {
    unset_user_preference('newemail', $userid);
    unset_user_preference('newemailkey', $userid);
    unset_user_preference('newemailattemptsleft', $userid);
}

function useredit_load_preferences(&$user, $reload=true) {
    global $USER;

    if (!empty($user->id)) {
        if ($reload and $USER->id == $user->id) {
            // reload preferences in case it was changed in other session
            unset($USER->preference);
        }
        
        if ($preferences = get_user_preferences(null, null, $user->id)) {
            foreach($preferences as $name=>$value) {
                $user->{'preference_'.$name} = $value;
            }
        }
    }
}

function useredit_update_user_preference($usernew) {
    $ua = (array)$usernew;
    foreach($ua as $key=>$value) {
        if (strpos($key, 'preference_') === 0) {
            $name = substr($key, strlen('preference_'));
            set_user_preference($name, $value, $usernew->id);
        }
    }
}

function useredit_update_picture(&$usernew, &$userform) {
    global $CFG;

    if (isset($usernew->deletepicture) and $usernew->deletepicture) {
        $location = make_user_directory($usernew->id, true);
        @remove_dir($location);
        set_field('user', 'picture', 0, 'id', $usernew->id);
    } else if ($usernew->picture = save_profile_image($usernew->id, $userform->get_um(), 'user')) {
        set_field('user', 'picture', 1, 'id', $usernew->id);
    }
}

function useredit_update_bounces($user, $usernew) {
    if (!isset($usernew->email)) {
        //locked field
        return;
    }
    if (!isset($user->email) || $user->email !== $usernew->email) {
        set_bounce_count($usernew,true);
        set_send_count($usernew,true);
    }
}

function useredit_update_trackforums($user, $usernew) {
    global $CFG;
    if (!isset($usernew->trackforums)) {
        //locked field
        return;
    }
    if ((!isset($user->trackforums) || ($usernew->trackforums != $user->trackforums)) and !$usernew->trackforums) {
        require_once($CFG->dirroot.'/mod/forum/lib.php');
        forum_tp_delete_read_records($usernew->id);
    }
}

function useredit_update_interests($user, $csv_tag_names) {
    tag_set('user', $user->id, explode(',', $csv_tag_names));
}

function useredit_shared_definition(&$mform) {
    global $CFG, $USER;

    $user = get_record('user', 'id', $USER->id);
    useredit_load_preferences($user, false);

    $strrequired = get_string('required');

    $nameordercheck = new object();
    $nameordercheck->firstname = 'a';
    $nameordercheck->lastname  = 'b';
    if (fullname($nameordercheck) == 'b a' ) {  // See MDL-4325
        $mform->addElement('text', 'lastname',  get_string('lastname'),  'maxlength="100" size="30"');
        $mform->addElement('text', 'firstname', get_string('firstname'), 'maxlength="100" size="30"');
    } else {
        $mform->addElement('text', 'firstname', get_string('firstname'), 'maxlength="100" size="30"');
        $mform->addElement('text', 'lastname',  get_string('lastname'),  'maxlength="100" size="30"');
    }

    $mform->addRule('firstname', $strrequired, 'required', null, 'client');
    $mform->setType('firstname', PARAM_NOTAGS);

    $mform->addRule('lastname', $strrequired, 'required', null, 'client');
    $mform->setType('lastname', PARAM_NOTAGS);


    // Do not show email field if change confirmation is pending
    if ($CFG->emailchangeconfirmation && !empty($user->preference_newemail)) {
        $notice = get_string('auth_emailchangepending', 'auth', $user);
        $notice .= '<br /><a href="edit.php?cancelemailchange=1&amp;id='.$user->id.'">'
                . get_string('auth_emailchangecancel', 'auth') . '</a>';
        $mform->addElement('static', 'emailpending', get_string('email'), $notice);
    } else {
        $mform->addElement('text', 'email', get_string('email'), 'maxlength="100" size="30"');
        $mform->addRule('email', $strrequired, 'required', null, 'client');
    }

    $choices = array();
    $choices['0'] = get_string('emaildisplayno');
    $choices['1'] = get_string('emaildisplayyes');
    $choices['2'] = get_string('emaildisplaycourse');
    $mform->addElement('select', 'maildisplay', get_string('emaildisplay'), $choices);
    $mform->setDefault('maildisplay', 2);

    $choices = array();
    $choices['0'] = get_string('emailenable');
    $choices['1'] = get_string('emaildisable');
    $mform->addElement('select', 'emailstop', get_string('emailactive'), $choices);
    $mform->setDefault('emailenable', 1);

    $choices = array();
    $choices['0'] = get_string('textformat');
    $choices['1'] = get_string('htmlformat');
    $mform->addElement('select', 'mailformat', get_string('emailformat'), $choices);
    $mform->setDefault('mailformat', 1);
    $mform->setAdvanced('mailformat');

    if (!empty($CFG->allowusermailcharset)) {
        $choices = array();
        $charsets = get_list_of_charsets();
        if (!empty($CFG->sitemailcharset)) {
            $choices['0'] = get_string('site').' ('.$CFG->sitemailcharset.')';
        } else {
            $choices['0'] = get_string('site').' (UTF-8)';
        }
        $choices = array_merge($choices, $charsets);
        $mform->addElement('select', 'preference_mailcharset', get_string('emailcharset'), $choices);
        $mform->setAdvanced('preference_mailcharset');
    }

    $choices = array();
    $choices['0'] = get_string('emaildigestoff');
    $choices['1'] = get_string('emaildigestcomplete');
    $choices['2'] = get_string('emaildigestsubjects');
    $mform->addElement('select', 'maildigest', get_string('emaildigest'), $choices);
    $mform->setDefault('maildigest', 0);
    $mform->setAdvanced('maildigest');

    $choices = array();
    $choices['1'] = get_string('autosubscribeyes');
    $choices['0'] = get_string('autosubscribeno');
    $mform->addElement('select', 'autosubscribe', get_string('autosubscribe'), $choices);
    $mform->setDefault('autosubscribe', 1);
    $mform->setAdvanced('autosubscribe');

    if (!empty($CFG->forum_trackreadposts)) {
        $choices = array();
        $choices['0'] = get_string('trackforumsno');
        $choices['1'] = get_string('trackforumsyes');
        $mform->addElement('select', 'trackforums', get_string('trackforums'), $choices);
        $mform->setDefault('trackforums', 0);
        $mform->setAdvanced('trackforums');
    }

    if ($CFG->htmleditor) {
        $choices = array();
        $choices['0'] = get_string('texteditor');
        $choices['1'] = get_string('htmleditor');
        $mform->addElement('select', 'htmleditor', get_string('textediting'), $choices);
        $mform->setDefault('htmleditor', 1);
        $mform->setAdvanced('htmleditor');
    }

    if (empty($CFG->enableajax)) {
        $mform->addElement('static', 'ajaxdisabled', get_string('ajaxuse'), get_string('ajaxno'));
        $mform->setAdvanced('ajaxdisabled');
    } else {
        $choices = array();
        $choices['0'] = get_string('ajaxno');
        $choices['1'] = get_string('ajaxyes');
        $mform->addElement('select', 'ajax', get_string('ajaxuse'), $choices);
        $mform->setDefault('ajax', 0);
        $mform->setAdvanced('ajax');
    }

    
    //---------------------------------------
    $choices = array();
    $choices['0'] = get_string('screenreaderno');
    $choices['1'] = get_string('screenreaderyes');
    $mform->addElement('select', 'screenreader', get_string('screenreaderuse'), $choices);
    $mform->setDefault('screenreader', 0);
    $mform->setAdvanced('screenreader');

    $mform->addElement('text', 'city', get_string('city'), 'maxlength="20" size="21"');
    $mform->setType('city', PARAM_MULTILANG);
    $mform->addRule('city', $strrequired, 'required', null, 'client');


    $choices = get_list_of_countries();
    $choices= array(''=>get_string('selectacountry').'...') + $choices;
    $mform->addElement('select', 'country', get_string('selectacountry'), $choices);
    $mform->addRule('country', $strrequired, 'required', null, 'client');
    if (!empty($CFG->country)) {
        $mform->setDefault('country', $CFG->country);
    }

    $choices = get_list_of_timezones();
    $choices['99'] = get_string('serverlocaltime');
    if ($CFG->forcetimezone != 99) {
        $mform->addElement('static', 'forcedtimezone', get_string('timezone'), $choices[$CFG->forcetimezone]);
    } else {
        $mform->addElement('select', 'timezone', get_string('timezone'), $choices);
        $mform->setDefault('timezone', '99');
    }

    $mform->addElement('select', 'lang', get_string('preferredlanguage'), get_list_of_languages());
    $mform->setDefault('lang', $CFG->lang);

    if (!empty($CFG->allowuserthemes)) {
        $choices = array();
        $choices[''] = get_string('default');
        $choices += get_list_of_themes();
        $mform->addElement('select', 'theme', get_string('preferredtheme'), $choices);
        $mform->setAdvanced('theme');
    }

    $mform->addElement('htmleditor', 'description', get_string('userdescription'));
    $mform->setType('description', PARAM_CLEAN);
    $mform->setHelpButton('description', array('text', get_string('helptext')));

    if (!empty($CFG->gdversion)) {
        $mform->addElement('header', 'moodle_picture', get_string('pictureof'));//TODO: Accessibility fix fieldset legend

        $mform->addElement('static', 'currentpicture', get_string('currentpicture'));

        $mform->addElement('checkbox', 'deletepicture', get_string('delete'));
        $mform->setDefault('deletepicture',false);

        $mform->addElement('file', 'imagefile', get_string('newpicture'));
        $mform->setHelpButton('imagefile', array('picture', get_string('helppicture')));

        $mform->addElement('text', 'imagealt', get_string('imagealt'), 'maxlength="100" size="30"');
        $mform->setType('imagealt', PARAM_MULTILANG);

    }

    if( !empty($CFG->usetags)) {
        $mform->addElement('header', 'moodle_interests', get_string('interests'));
        $mform->addElement('textarea', 'interests', get_string('interestslist'), 'cols="45" rows="3"');
        $mform->setHelpButton('interests', array('interestslist', get_string('helpinterestslist'),
                          false, true, false));
    }

    /// Moodle optional fields
    $mform->addElement('header', 'moodle_optional', get_string('optional', 'form'));
    $mform->setAdvanced('moodle_optional');

    $mform->addElement('text', 'url', get_string('webpage'), 'maxlength="255" size="50"');
    $mform->setType('url', PARAM_URL);

    $mform->addElement('text', 'icq', get_string('icqnumber'), 'maxlength="15" size="25"');
    $mform->setType('icq', PARAM_CLEAN);

    $mform->addElement('text', 'skype', get_string('skypeid'), 'maxlength="50" size="25"');
    $mform->setType('skype', PARAM_CLEAN);

    $mform->addElement('text', 'aim', get_string('aimid'), 'maxlength="50" size="25"');
    $mform->setType('aim', PARAM_CLEAN);

    $mform->addElement('text', 'yahoo', get_string('yahooid'), 'maxlength="50" size="25"');
    $mform->setType('yahoo', PARAM_CLEAN);

    $mform->addElement('text', 'msn', get_string('msnid'), 'maxlength="50" size="25"');
    $mform->setType('msn', PARAM_CLEAN);

    $mform->addElement('text', 'idnumber', get_string('idnumber'), 'maxlength="255" size="25"');
    $mform->setType('idnumber', PARAM_CLEAN);

    $mform->addElement('text', 'institution', get_string('institution'), 'maxlength="40" size="25"');
    $mform->setType('institution', PARAM_MULTILANG);

    $mform->addElement('text', 'department', get_string('department'), 'maxlength="30" size="25"');
    $mform->setType('department', PARAM_MULTILANG);

    $mform->addElement('text', 'phone1', get_string('phone'), 'maxlength="20" size="25"');
    $mform->setType('phone1', PARAM_CLEAN);

    $mform->addElement('text', 'phone2', get_string('phone2'), 'maxlength="20" size="25"');
    $mform->setType('phone2', PARAM_CLEAN);

    $mform->addElement('text', 'address', get_string('address'), 'maxlength="70" size="25"');
    $mform->setType('address', PARAM_MULTILANG);


}


function inforedit_shared_definition(&$mform) {
    global $CFG, $USER;

    $user = get_record('user', 'id', $USER->id);
    useredit_load_preferences($user, false);

//    $strrequired = get_string('required');

// nhap ten lop day du textbox    	
//    $mform->addElement('text', 'topica_lop', get_string('topica_lop'), 'maxlength="20" size="30"');
// neu muon chon ten lop tu combo box thi comment dong tren lai

    $mform->setType('topica_lop', PARAM_MULTILANG);
//kh�ng require    $mform->addRule('topica_lop', $strrequired, 'required', null, 'client');
//-----------------------------------------------------------------
	
/*
    $choices = array();
    $choices['chua_xac_dinh'] = get_string('topica_lop_0');
    $choices['0941EL.A1'] = get_string('0941EL.A1');
    $choices['0941EL.B1'] = get_string('0941EL.B1');
    $choices['0942EL.C1'] = get_string('0942EL.C1');
    $choices['0942EL.D1'] = get_string('0942EL.D1');
 //--------------------------------------------------------------------------   
    $mform->addElement('select', 'topica_lop', get_string('topica_lop'), $choices);
//-----------------------------------------------
*/
//-----------------------------------------------------------------
//-----------------------------------------------------------------	
	$sql="SELECT DISTINCT
		u.topica_lop
		FROM
		mdl_user u
		WHERE u.topica_lop!='' and u.deleted=0
		ORDER BY topica_lop";
	$result = mysql_query($sql);
	
  
	while($row = mysql_fetch_array($result))
					{
					$choices[$row[topica_lop]]= $row[topica_lop];
					}
    $mform->addElement('select', 'topica_lop', get_string('topica_lop'), $choices);

//-----------------------------------------------------------------
//----------------------
$choices = array();
    $choices['chua_xac_dinh'] = get_string('topica_nganh_0');
    $choices['QTKD'] = get_string('topica_nganh_ba');
    $choices['KT'] = get_string('topica_nganh_fi1');
    $choices['TCNH'] = get_string('topica_nganh_fi2');
    $choices['CNTT'] = get_string('topica_nganh_it');
	$choices['LUAT'] = 'Luật';//danglx add 05-12-2013
    $mform->addElement('select', 'topica_nganh', get_string('topica_nganh'), $choices);

	$choices = array();
    $choices['chua_xac_dinh'] = get_string('topica_nhom0');
    $choices['N1'] = get_string('topica_nhom1');
    $choices['N2'] = get_string('topica_nhom2');
    $choices['N3'] = get_string('topica_nhom3');
    $choices['N4'] = get_string('topica_nhom4');
    $choices['N5'] = get_string('topica_nhom5');
    $choices['N6'] = get_string('topica_nhom6');
    $choices['N7'] = get_string('topica_nhom7');
    $choices['N8'] = get_string('topica_nhom8');
    $choices['N9'] = get_string('topica_nhom9');
    $choices['N10'] = get_string('topica_nhom10');
    $choices['N11'] = get_string('topica_nhom11');
    $choices['N12'] = get_string('topica_nhom12');
    $choices['N13'] = get_string('topica_nhom13');
    $choices['N14'] = get_string('topica_nhom14');
    $choices['N15'] = get_string('topica_nhom15');
    $choices['N16'] = get_string('topica_nhom16');
    $choices['N17'] = get_string('topica_nhom17');
    $choices['N18'] = get_string('topica_nhom18');
    $choices['N19'] = get_string('topica_nhom19');
    $choices['N20'] = get_string('topica_nhom20');
    $mform->addElement('select', 'topica_nhom', get_string('topica_nhom'), $choices);
    	
	$choices = array();
    $choices['Thanh_vien'] = get_string('topica_chucvutronglop_thanhvien');
    $choices['Lop_pho'] = get_string('topica_chucvutronglop_loppho');
    $choices['Lop_Truong'] = get_string('topica_chucvutronglop_loptruong');
    $mform->addElement('select', 'topica_chucvutronglop', get_string('topica_chucvutronglop'), $choices);
    	
	$choices = array();
    $choices['Nhom_Vien'] = get_string('topica_chucvutrongnhom_nhomvien');
    $choices['Nhom_Pho'] = get_string('topica_chucvutrongnhom_nhompho');
    $choices['Nhom_Truong'] = get_string('topica_chucvutrongnhom_nhomtruong');
    $mform->addElement('select', 'topica_chucvutrongnhom', get_string('topica_chucvutrongnhom'), $choices);
    	

	$choices = array();
    $choices['Candicate_Y'] = get_string('topica_candidatey');
    $choices['Candicate_N'] = get_string('topica_candidaten');
    $mform->addElement('select', 'topica_candidate', get_string('topica_candidate'), $choices);


	$mform->addElement('text', 'topica_msv', get_string('topica_msv'), 'maxlength="200" size="30"');
    $mform->setType('topica_msv', PARAM_MULTILANG);
    $mform->addElement('text', 'topica_coquan', get_string('topica_coquan'), 'maxlength="200" size="30"');
    $mform->setType('topica_coquan', PARAM_MULTILANG);
    	
	$choices = array();
    $choices['Nhan_Vien'] = get_string('topica_chucdanh_nhanvien');
    $choices['Chuyen_Vien'] = get_string('topica_chucdanh_chuyenvien');
    $choices['Truong_Nhom'] = get_string('topica_chucdanh_truongnhom');
    $choices['Pho_Phong'] = get_string('topica_chucdanh_phophong');
    $choices['Truong_Phong'] = get_string('topica_chucdanh_truongphong');
    $choices['Pho_Giam_Doc'] = get_string('topica_chucdanh_phogiamdoc');
    $choices['Giam_Doc'] = get_string('topica_chucdanh_giamdoc');
    $choices['Chuc_danh_khac'] = get_string('topica_chucdanh_chucdanhkhac');
    $choices['Chua_di_lam'] = get_string('topica_chucdanh_chuadilam');
    $mform->addElement('select', 'topica_chucdanh', get_string('topica_chucdanh'), $choices);
    	
	$choices = array();
    $choices['Tot_nghiep_THPT'] = get_string('topica_trinhdo_thpt');
    $choices['Trung_Cap'] = get_string('topica_trinhdo_tc');
    $choices['Cao_Dang'] = get_string('topica_trinhdo_cd');
    $choices['Dai_hoc'] = get_string('topica_trinhdo_dh');
    $mform->addElement('select', 'topica_trinhdo', get_string('topica_trinhdo'), $choices);

	$choices = array();
    $choices['Tot_nghiep_THPT'] = get_string('topica_doituongtuyensinh_0');
    $choices['Trung_Cap_lien_thong'] = get_string('topica_doituongtuyensinh_1');
    $choices['Cao_Dang_lien_thong'] = get_string('topica_doituongtuyensinh_2');
    $choices['Dai_hoc_VB2'] = get_string('topica_doituongtuyensinh_3');
    $choices['Cac_Ctr_Diploma'] = get_string('topica_doituongtuyensinh_4');
    $mform->addElement('select', 'topica_doituongtuyensinh', get_string('topica_doituongtuyensinh'), $choices);
    	
    $mform->addElement('text', 'topica_namsinh', get_string('topica_namsinh'), 'maxlength="20" size="30"');
    $mform->setType('topica_namsinh', PARAM_MULTILANG);
    	
    $mform->addElement('text', 'topica_dienthoai', get_string('topica_dienthoai'), 'maxlength="50" size="30"');
    $mform->setType('topica_dienthoai', PARAM_MULTILANG);
	
	// danglx them 08-01-2014
	$mform->addElement('text', 'email_canhan', 'Email cá nhân', 'maxlength="100" size="30"');
	$mform->setType('email_canhan', PARAM_MULTILANG);
	//end danglx
    	
    $mform->addElement('text', 'topica_ym', get_string('topica_ym'), 'maxlength="20" size="30"');
    $mform->setType('topica_ym', PARAM_MULTILANG);

    $mform->addElement('textarea', 'topica_ghichu', get_string('topica_ghichu'), 'cols="45" rows="3"');
    	
    $mform->addElement('text', 'topica_namsinh', get_string('topica_namsinh'), 'maxlength="20" size="30"');
    $mform->setType('topica_namsinh', PARAM_MULTILANG);
	$choices = array();
    $choices['Binh_Thuong'] = get_string('topica_status_binhthuong');
    $choices['Hang_Hai'] = get_string('topica_status_hanghai');
    $choices['Bao_Dong'] = get_string('topica_status_baodong');
    $mform->addElement('select', 'topica_status', get_string('topica_status'), $choices);

    /// Moodle optional fields
    $mform->addElement('header', 'moodle_optional', get_string('optional', 'form'));
    $mform->setAdvanced('moodle_optional');

    $mform->addElement('select', 'lang', get_string('preferredlanguage'), get_list_of_languages());
    $mform->setDefault('lang', $CFG->lang);


    if (!empty($CFG->gdversion)) {
//      $mform->addElement('header', 'moodle_picture', get_string('pictureof'));//TODO: Accessibility fix fieldset legend

        $mform->addElement('static', 'currentpicture', get_string('currentpicture'));

    }

}

?>
