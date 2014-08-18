<?php
mfm_setup();
mfm_require_login();
$context = get_context_instance(CONTEXT_SYSTEM, SITEID);
if (!has_capability('moodle/site:config', $context)){
   mfm_error('You don\'t have permission to access this page!');
}

if (!file_exists($CFG->mfm_dirroot.'/admin/version.php')) {
   mfm_error('Can\'t find admin/version.php!!');
}

require_once ($CFG->mfm_dirroot.'/admin/version.php');  // Get $mfm_version
$continueto=$CFG->wwwroot;
if (empty($CFG->mfm_version)) {
    mfm_print_header('',mfm_get_string('upgrading_mfm_db'));
    mfm_print_heading(mfm_get_string('upgrading_mfm_db'));
    if (modify_database($CFG->mfm_dirroot.'/admin/'.$CFG->dbtype .'.sql')) {
        mfm_notify(mfm_get_string('databasesuccess', '', $module->name), '');
        set_config('mfm_version', $mfm_version);
        echo '<hr>';
        mfm_print_continue($continueto);
        mfm_print_footer();
        exit;
    } else { 
        mfm_error('Tables could NOT be set up successfully!');
    }
}


if ($mfm_version > $CFG->mfm_version) { // upgrade! 
    
    require_once ($CFG->mfm_dirroot.'/admin/'. $CFG->dbtype .'.php');

    if (mfm_upgrade($CFG->mfm_version)) {
        if (set_config('mfm_version', $mfm_version)) {
            mfm_print_header('',mfm_get_string('upgrading_mfm_db'));
            mfm_notify(mfm_get_string('databasesuccess'));
            mfm_print_continue($continueto);
            mfm_print_footer();
            exit;
        } else {
            mfm_error('Upgrade of local database customisations failed! (Could not update version in config table)');
        }
    } else {
        mfm_error('Upgrade failed!  See local/version.php');
    }

} else if ($mfm_version < $CFG->mfm_version) {
    mfm_print_header('',mfm_get_string('upgrading_mfm_db'));
    mfm_notify('WARNING!!!  The mfm version you are using is OLDER than the version that made these databases!');
    mfm_print_continue($continueto);
    mfm_print_footer();
} else {
    mfm_print_header('',mfm_get_string('mfm_db_ok'));
    mfm_notify(mfm_get_string('mfm_db_ok'));
    mfm_print_continue($continueto);
    mfm_print_footer();

}
die;
?>