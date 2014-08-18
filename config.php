<?php  /// Moodle Configuration File 



unset($CFG);


$CFG->dbtype    = 'mysql';

$CFG->dbhost    = 'amatoplmsforum.cdv75kqsz5y1.ap-southeast-1.rds.amazonaws.com';

$CFG->dbname    = 'amatoplms';

$CFG->dbuser    = 'amatoplms';

$CFG->dbpass    = 'KrWuTbNY';

$CFG->dbpersist =  false;

$CFG->prefix    = 'mdl_';


$CFG->wwwroot   = 'http://dev.lms.amatop.ph';
$CFG->dirroot   = '/mnt/lms';
$CFG->dataroot  = '/mnt/moodledata';
$CFG->admin     = 'admin';



$CFG->directorypermissions = 00777;  // try 02777 on a server in Safe Mode

$CFG->usesid=true;

require_once("$CFG->dirroot/lib/setup.php");

// MAKE SURE WHEN YOU EDIT THIS FILE THAT THERE ARE NO SPACES, BLANK LINES,

// RETURNS, OR ANYTHING ELSE AFTER THE TWO CHARACTERS ON THE NEXT LINE.

?>