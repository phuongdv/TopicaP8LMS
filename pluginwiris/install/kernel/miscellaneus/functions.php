<?php
if (!defined('SECURITY_CONSTANT')) exit;

function stripSlashesInRequestVariables() {
	$_REQUEST = array_map('secure_stripslashes', $_REQUEST);
	$_GET = array_map('secure_stripslashes', $_GET);
	$_POST = array_map('secure_stripslashes', $_POST);
}

function secure_stripslashes($element) {
	if (is_array($element)) {
		return array_map('secure_stripslashes', $element);
	}

	return stripslashes($element);
}

function translate($string) {
	global $TRANSLATION;
	
	if (isset($TRANSLATION[$string])) {
		return $TRANSLATION[$string];
	}
	
	return $string;
}

function errorMessage($tag = '') {
	$toReturn = translate('If you want to install Plugin WIRIS manually, see') . ' <a href="http://www.wiris.com/download/moodle/install.html#' . $tag . '">' . translate('our manual') . '</a>.<br /><br />';
	$toReturn .= '<a href="..">' . translate('Return to moodle home.') . '</a><br /><br />';
	$toReturn .= '<a href="./install.php">' . translate('Try to reinstall') . '</a>.';
	
	return $toReturn;
}

function downloadEditor() {
	if (isset($_POST['proxy']) and isset($_POST['proxy_host']) and isset($_POST['proxy_port'])) {
		$aContext = array(
		    'http' => array(
			        'proxy' => 'tcp://' . $_POST['proxy_host'] . ':' . (int)$_POST['proxy_port'],
			        'request_fulluri' => true,
		        ),
		    );
		$cxContext = stream_context_create($aContext);
		
		if (($content = file_get_contents('http://www.wiris.com/download/editor/download?file=wiriseditor.zip', false, $cxContext)) !== false) {
			return file_put_contents('./editor/jar/pluginwiris.zip', $content);
		}
		
		return false;
	}
	
	if (($content = wrs_http_get_contents('http://www.wiris.com/download/editor/download?file=wiriseditor.zip')) !== false) {
		return wrs_file_put_contents('./editor/jar/pluginwiris.zip', $content);
	}
	
	return false;
}

function extractEditor() {
	$handle = new PclZip('./editor/jar/pluginwiris.zip');
	if ($handle->extract(PCLZIP_OPT_PATH, "./editor/jar/") === false) {
		return false;
	}
	return true;
}

function full_copy($source, $target) {
	if (is_dir($source)) {
		if (!file_exists($target)) {
			mkdir($target);
		}
		$dirList = opendir($source);
		while ($itemReaded = readdir($dirList)) {
			if ($itemReaded != '.' and $itemReaded != '..') {
				$fullPath = $source . '/' . $itemReaded;
				if (!full_copy($fullPath, $target . '/' . $itemReaded)) {
					closedir($dirList);
					return false;
				}
			}
		}
		return true;
	}
	else {
		return copy($source, $target);
	}
}

function full_remove($target) {
	if (is_dir($target)) {
		$dirList = opendir($target);
		while ($file = readdir($dirList)) {
			if ($file != '.' and $file != '..') {
				$fullPath = $target . '/' . $file;
				if (!full_remove($fullPath)) {
					closedir($dirList);
					return false;
				}
			}
		}
		
		rmdir($target);
		return true;
	}

	return unlink($target);
}

function parseWeblib() {
	if (($content = file_get_contents('../lib/weblib.php')) !== false) {
		if (strpos($content, 'WIRIS') !== false) {
			return ALREADY_PARSED;
		}
		
		$contentSplited = explode("\n", $content);
		
		include('../version.php');
		if (($position = strpos($release, '+')) !== false) {
			$release = substr($release, 0, $position + 1);
		}
		else if (($position = strpos($release, ' ')) !== false) {
			$release = substr($release, 0, $position);
		}
		
		if (isset($_POST['proxy']) and isset($_POST['proxy_host']) and isset($_POST['proxy_port'])) {
			$aContext = array(
			    'http' => array(
				        'proxy' => 'tcp://' . $_POST['proxy_host'] . ':' . (int)$_POST['proxy_port'],
				        'request_fulluri' => true,
			        ),
			    );
			$cxContext = stream_context_create($aContext);
			
			$toEval = file_get_contents('http://www.wiris.com/download/moodle/versions.php?version=' . urlencode($release), false, $cxContext);
		}
		else {
			$toEval = wrs_http_get_contents('http://www.wiris.com/download/moodle/versions.php?version=' . urlencode($release));
		}

		if ($toEval !== false) {
			$printTextarea_passed = false;
			$useHTMLEditor_passed = false;
			$scriptcount_passed = false;
			$echo_passed = false;

			$content = '';
			
			eval($toEval);
			
			if ($scriptcount != 'UNKNOWN') {
				foreach ($contentSplited as $line) {
					if (strpos($line, "function print_textarea(") !== false) {
						$printTextarea_passed = true;
					}
					if (strpos($line, "function use_html_editor(") !== false) {
						$useHTMLEditor_passed = true;
					}
					if (strpos($line, "\$scriptcount++;") !== false and $printTextarea_passed and !$scriptcount_passed) {
						$content .= "/**** begin WIRIS Plugin ****/\n";
						$content .= $scriptcount;
						$content .= "/**** end WIRIS Plugin ****/\n";
						$scriptcount_passed = true;
					}

					$content .= $line . "\n";

					if (strpos($line, "echo print_editor_config(\$editorhidebuttons);") !== false and $useHTMLEditor_passed and !$echo_passed) {
						$content .= "/**** begin WIRIS Plugin ****/\n";
						$content .= $echo;
						$content .= "/**** end WIRIS Plugin ****/\n";
						$echo_passed = true;
					}
				}
				
				$content = substr($content, 0, strlen($content) - 1);		// Deletes last \n (else moodle don't works)
				
				if ($printTextarea_passed and $useHTMLEditor_passed and $scriptcount_passed and $echo_passed) {
					if (!copy('../lib/weblib.php', '../lib/weblib.php.old')) {		// Backuping weblib.php
						return NO_WRITE_PERMISION;
					}

					if (file_put_contents('../lib/weblib.php', $content) === false) {
						return NO_WRITE_PERMISION;
					}
					return ALL_WELL;
				}
				return UNKNOWN_VERSION;
			}
			return UNKNOWN_VERSION;
		}
		return CAN_NOT_CONNECT;
	}
	return NO_READ_PERMISION;
}

function boolTostring($boolean) {
	if (!isset($boolean) or !$boolean) {
		return 'false';
	}
	
	return 'true';
}

function POSTCASConfigValues(&$codebase, &$archive, &$class, &$lang) {
	$codebase = $_POST['codebase'];
	$archive = $_POST['archive'];
	$class = $_POST['class'];

	$langList = array('es', 'en', 'ca', 'it', 'fr', 'eu', 'nl', 'et');
	$lang = '';
	foreach ($langList as $langItem) {
		if (isset($_POST[$langItem])) {
			$lang .= $langItem . ',';
		}
	}
	$lang = substr($lang, 0, strlen($lang) - 1);
}

function parseConfig() {
	$toWrite = "<?php\n";
	$toWrite .= "/* Wiris Image Service */\n";
	
	$enableEditor = (isset($_POST['enableEditor'])) ? 'true' : 'false';
	$transparency = (isset($_POST['transparency'])) ? 'true' : 'false';
	
	$toWrite .= "\$CFG->wirisformulaeditorenabled=" . $enableEditor . ";                  // enable the insertion of formulas using WIRIS Editor\n";
	$toWrite .= "\$CFG->wirisimageservicehost='" . $_POST["imagehost"] . "';      // host of the Java application server\n";
	$toWrite .= "\$CFG->wirisimageserviceport='" . $_POST["imageport"] . "';                        // port of the Java application server\n";
	$toWrite .= "\$CFG->wirisimageservicepath='" . $_POST["imagepath"] . "';         // context root of the Image service\n";
	$toWrite .= "\$CFG->wirisimagebgcolor='" . $_POST["imagebgcolor"] . "';                     // background color of the formulas\n";
	$toWrite .= "\$CFG->wiristransparency='" . $transparency . "';       // set transparent background for the formulas (available for Mozilla / IE 7 or greater)\n";
	$toWrite .= "\$CFG->wirisimagesymbolcolor='" . $_POST["imagesymbolcolor"] . "'; // symbol color of the formulas\n";
	$toWrite .= "\$CFG->wirisimagefontsize='" . $_POST["imagefontsize"] . "';         // font size of the formula\n";
	$toWrite .= "\n\n";

	$toWrite .= "/* Wiris editor */\n";
	$toWrite .= "\$CFG->wiriseditorcodebase='/pluginwiris/editor/jar/';  // codebase of your WIRIS Editor jar file\n";
	$toWrite .= "\$CFG->wiriseditorarchive='wiriseditor.jar';            // SHOULD NOT BE USUALLY MODIFIED\n";
	$toWrite .= "\$CFG->wiriseditorclass='WirisFormulaEditor';           // SHOULD NOT BE USUALLY MODIFIED\n";
	$toWrite .= "\n\n";

	$toWrite .= "/* Wiris CAS calculator */\n";

	$codebase = $archive = $class = $lang = '';
	if (isset($_POST['server'])) {
		$toInclude = './install/servers/' . basename($_POST['server']) . '.php';

		if (is_file($toInclude)) {
			include($toInclude);
		}
		else {
			POSTCASConfigValues($codebase, $archive, $class, $lang);
		}
	}
	else {
		POSTCASConfigValues($codebase, $archive, $class, $lang);
	}
	
	$version = '2.1.22';
	
	$enableCAS = (isset($_POST['enableCAS'])) ? 'true' : 'false';
	
	$toWrite .= "\$CFG->wiriscasenabled=" . $enableCAS . ";                                               // enable the insertion of WIRIS CAS Applet in the HTML Editor\n";
	$toWrite .= "\$CFG->wiriscascodebase='" . $codebase . "';  // codebase of the WIRIS CAS applet\n";
	$toWrite .= "\$CFG->wiriscasarchive='" . $archive . "';                // file of the WIRIS CAS applet\n";
	$toWrite .= "\$CFG->wiriscasclass='" . $class . "';              // class name of the WIRIS CAS applet\n";
	$toWrite .= "\$CFG->wiriscaslang='" . $lang . "';                         // available languages 'en,es,fr,it,nl,et,ca,eu' (depend on your WIRIS CAS installation).\n";

	$toWrite .= "\n\n";

	$toWrite .= "/* Filter variables */\n";
	$toWrite .= "\$CFG->wirisfilterdir = 'filter/wiris';                 // SHOULD USUALLY NOT BE MODIFIED\n";
	$toWrite .= "\$CFG->wirisimagedir  = 'filter/wiris';                 // SHOULD USUALLY NOT BE MODIFIED\n";
	$toWrite .= "\$CFG->wirisformulaimageclass = 'Wirisformula';         // SHOULD USUALLY NOT BE MODIFIED\n";
	$toWrite .= "\$CFG->wiriscasimageclass = 'Wiriscas';                 // SHOULD USUALLY NOT BE MODIFIED\n\n";
	
	if (isset($_POST['proxy']) and isset($_POST['proxy_host']) and isset($_POST['proxy_port'])) {
		$toWrite .= "/* Proxy variables */\n";
		$toWrite .= "\$CFG->wirisproxy = true;\n";
		$toWrite .= "\$CFG->wirisproxy_host = '" . str_replace("'", "\\'", $_POST['proxy_host']) . "';\n";
		$toWrite .= "\$CFG->wirisproxy_port = " . (int)$_POST['proxy_port'] . ";\n";
		
		$toWrite .= "\$CFG->wirisPHP4compatibility = false;		// PHP 4 COMPATIBILITY: MARKT IT IF YOU ARE USING PHP 4, BUT DON'T USE PROXY.\n\n";
	}
	else {
		$toWrite .= "/* Proxy variables */\n";
		$toWrite .= "\$CFG->wirisproxy = false;\n";
		$toWrite .= "\$CFG->wirisproxy_host = '';\n";
		$toWrite .= "\$CFG->wirisproxy_port = 8080;\n\n";
		
		$toWrite .= "\$CFG->wirisPHP4compatibility = true;		// PHP 4 COMPATIBILITY: MARKT IT IF YOU ARE USING PHP 4, BUT DON'T USE PROXY.\n\n";
	}

	$toWrite .= "\$CFG->wirisversion = '" . $version . "';	// SHOULD NOT BE MODIFIED\n";
	$toWrite .= "?>\n";
	
	if (file_put_contents('./wrs_config.php', $toWrite) === false) {
		return NO_WRITE_PERMISION;
	}
	
	return ALL_WELL;
}

function addSlashesOnDoubleQuotes($string) {
	return str_replace('"', '\"', $string);
}

function wrs_http_get_contents($URL) {
	$URL_parsed = parse_url($URL);

	if (empty($URL_parsed['port'])) {
		$URL_parsed['port'] = 80;
	}
	
	if (!empty($URL_parsed['query'])) {
		$URL_parsed['query'] = '?' . $URL_parsed['query'];
	}
	
	if (($socket = fsockopen($URL_parsed['host'], $URL_parsed['port'])) !== false) {
		$query = 'GET ' . $URL_parsed['path'] . $URL_parsed['query'] . " HTTP/1.0\r\n";
		$query .= 'Host: ' . $URL_parsed['host'] . ':' . $URL_parsed['port'] . "\r\n";
		$query .= "Connection: close\r\n";
		$query .= "\r\n";
		
		fwrite($socket, $query);
		
		$content = '';
		while (!feof($socket)) {
			$content .= fgets($socket, 128);
		}
		fclose($socket);
		
		$content_splited = explode("\r\n\r\n", $content, 2);

		/* Parsing headers */
		$header_lines = explode("\r\n", $content_splited[0]);
		$header = array();
		
		foreach ($header_lines as $line) {
			$line_splited = explode(': ', $line, 2);
			
			if (count($line_splited) == 2) {
				$header[$line_splited[0]] = $line_splited[1];
			}
			else {
				$header['HTTP_INFO'] = $line;
			}
		}
		
		if (isset($header['Location'])) {
			return wrs_http_get_contents($header['Location']);
		}
		
		return $content_splited[1];
	}
	
	return false;
}

function wrs_file_put_contents($file, $content) {
	if (($handle = fopen('./editor/jar/pluginwiris.zip', 'wb')) !== false) {
		fwrite($handle, $content);
		fclose($handle);
		
		return true;
	}
	
	return false;
}
?>