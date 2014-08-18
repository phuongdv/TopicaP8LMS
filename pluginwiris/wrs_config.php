<?php
/* Wiris Image Service */
$CFG->wirisformulaeditorenabled=true;                  // enable the insertion of formulas using WIRIS Editor
$CFG->wirisimageservicehost='services.wiris.com';      // host of the Java application server
$CFG->wirisimageserviceport='80';                        // port of the Java application server
$CFG->wirisimageservicepath='/formula/render';         // context root of the Image service
$CFG->wirisimagebgcolor='#fafafa';                     // background color of the formulas
$CFG->wiristransparency='true';       // set transparent background for the formulas (available for Mozilla / IE 7 or greater)
$CFG->wirisimagesymbolcolor='#000000'; // symbol color of the formulas
$CFG->wirisimagefontsize='16';         // font size of the formula


/* Wiris editor */
$CFG->wiriseditorcodebase='/pluginwiris/editor/jar/';  // codebase of your WIRIS Editor jar file
$CFG->wiriseditorarchive='wiriseditor.jar';            // SHOULD NOT BE USUALLY MODIFIED
$CFG->wiriseditorclass='WirisFormulaEditor';           // SHOULD NOT BE USUALLY MODIFIED


/* Wiris CAS calculator */
$CFG->wiriscasenabled=true;                                               // enable the insertion of WIRIS CAS Applet in the HTML Editor
$CFG->wiriscascodebase='http://www.wiris.net/demo/wiris/wiris-codebase';  // codebase of the WIRIS CAS applet
$CFG->wiriscasarchive='wrs_net_en.jar';                // file of the WIRIS CAS applet
$CFG->wiriscasclass='WirisApplet_net_en';              // class name of the WIRIS CAS applet
$CFG->wiriscaslang='es,en,fr';                         // available languages 'en,es,fr,it,nl,et,ca,eu' (depend on your WIRIS CAS installation).


/* Filter variables */
$CFG->wirisfilterdir = 'filter/wiris';                 // SHOULD USUALLY NOT BE MODIFIED
$CFG->wirisimagedir  = 'filter/wiris';                 // SHOULD USUALLY NOT BE MODIFIED
$CFG->wirisformulaimageclass = 'Wirisformula';         // SHOULD USUALLY NOT BE MODIFIED
$CFG->wiriscasimageclass = 'Wiriscas';                 // SHOULD USUALLY NOT BE MODIFIED

/* Proxy variables */
$CFG->wirisproxy = false;
$CFG->wirisproxy_host = '';
$CFG->wirisproxy_port = 8080;

$CFG->wirisPHP4compatibility = true;		// PHP 4 COMPATIBILITY: MARKT IT IF YOU ARE USING PHP 4, BUT DON'T USE PROXY.

$CFG->wirisversion = '2.1.22';	// SHOULD NOT BE MODIFIED
?>
