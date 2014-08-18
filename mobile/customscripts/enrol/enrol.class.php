<?php // $Id: enrol.class.php,v 1.2 2006/06/22 08:00:10 jamiesensei Exp $

/**
* enrolment_factory is used to "manufacture" an instance of required enrolment plugin.
*/

class enrolment_factory {
    function factory($enrol = '') {
        global $CFG;
        if (!$enrol) {
            $enrol = $CFG->enrol;
        }
        if (file_exists("$CFG->mfm_dirroot/enrol/$enrol/enrol.php")) {
            if (file_exists("$CFG->dirroot/enrol/$enrol/enrol.php")) {
                require_once("$CFG->dirroot/enrol/$enrol/enrol.php");
            } else {
                trigger_error("$CFG->dirroot/enrol/$enrol/enrol.php does not exist");
                mfm_error("$CFG->dirroot/enrol/$enrol/enrol.php does not exist");
            }
            require_once("$CFG->mfm_dirroot/enrol/$enrol/enrol.php");
            $class = "mfm_enrolment_plugin_$enrol";
            return new $class;
        } elseif (file_exists("$CFG->dirroot/enrol/$enrol/enrol.php")) {
            require_once("$CFG->dirroot/enrol/$enrol/enrol.php");
            $class = "enrolment_plugin_$enrol";
            return new $class;
        } else {
            trigger_error("$CFG->dirroot/enrol/$enrol/enrol.php does not exist");
            mfm_error("$CFG->dirroot/enrol/$enrol/enrol.php does not exist");
        }
    }
}

?>