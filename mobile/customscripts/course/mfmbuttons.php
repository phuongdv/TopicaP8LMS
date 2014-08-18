<?php
function make_mobile_enable_button($mod, $absolute, $section) {
    global $CFG;

    static $enabledmods;
    static $sesskey;
    static $mfmmods;

    if (!isset($enabledmods)) {
        $enabledmods=get_records('mfm_enable', '', '', '', 'cmid, cmid');
        $sesskey = sesskey();
        $mfmmods = get_list_of_plugins('mod', '', $CFG->mfm_dirroot);
    }
    if (!in_array($mod->modname, $mfmmods)){
        return '';
    }
    
    if ($enabledmods!==false){
        $enabled=array_key_exists($mod->id, $enabledmods);
    } else {
        $enabled=false;
    }

    if ($section >= 0) {
        $section = '&amp;sr='.$section;   // Section return
    } else {
        $section = '';
    }
    $path = $CFG->mfm_wwwroot;

    if ($enabled) {
        $enabledisable = '<a title="click to disable keitai access" href="'.$path.'/course/mfmenable.php?disable='.$mod->id.
                    '&amp;sesskey='.$sesskey.$section.'"><img'.
                    ' src="'.$CFG->mfm_wwwroot.'/pix/enabled.gif" hspace="2" height="16" width="16" '.
                    ' border="0" alt="click to disable keitai access" /></a> ';
    } else {
        $enabledisable = '<a title="click to enable keitai access" href="'.$path.'/course/mfmenable.php?enable='.$mod->id.
                    '&amp;sesskey='.$sesskey.$section.'"><img'.
                    ' src="'.$CFG->mfm_wwwroot.'/pix/disabled.gif" hspace="2" height="16" width="16" '.
                    ' border="0" alt="click to enable keitai access" /></a> ';
    }

    return '<span class="commands">'.$enabledisable.'</span>';
}?>
