<?PHP 
  
$nomoodlecookie = true;     // Because it interferes with caching ?

include('../../config.php');
include($CFG->libdir . '/filelib.php');
include($CFG->dirroot . '/pluginwiris/wrs_config.php');

error_reporting(E_ALL);
  
function create_image($mathml, $filepath) {
	global $CFG;

	if (!$CFG->wirisPHP4compatibility) {
		$postdata = http_build_query(
			array(
				'mml' => $mathml,
				'bgColor' => $CFG->wirisimagebgcolor,
				'symbolColor' => $CFG->wirisimagesymbolcolor,
				'fontSize' => $CFG->wirisimagefontsize,
				'transparency' => $CFG->wiristransparency
			)
		);

		$contextArray = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
				'content' => $postdata
			)
		);
		
		if (isset($CFG->wirisproxy) and $CFG->wirisproxy) {
			$contextArray['http']['proxy'] = 'tcp://' . $CFG->wirisproxy_host . ':' . $CFG->wirisproxy_port;
			$contextArray['http']['request_fulluri'] = true;
		}

		$context = stream_context_create($contextArray);

		if (($response = file_get_contents('http://' . $CFG->wirisimageservicehost . ':' . $CFG->wirisimageserviceport . $CFG->wirisimageservicepath, false, $context)) === false) {
			unlink ($filepath);
		}
		else {
			file_put_contents($filepath, $response);
		}
	}
	else {
		if (($socket = fsockopen($CFG->wirisimageservicehost, $CFG->wirisimageserviceport)) === false) {
			unlink ($filepath);
		}
		else {
			$postdata = 'mml=' . rawurlencode($mathml);
			$postdata .= '&bgColor=' . rawurlencode($CFG->wirisimagebgcolor);
			$postdata .= '&=symbolColor' . rawurlencode($CFG->wirisimagesymbolcolor);
			$postdata .= '&=fontSize' . rawurlencode($CFG->wirisimagefontsize);
			$postdata .= '&=transparency' . rawurlencode($CFG->wiristransparency);
			
			$query = 'POST ' . $CFG->wirisimageservicepath . " HTTP/1.0\r\n";
			$query .= 'Host: ' . $CFG->wirisimageservicehost . ':' . $CFG->wirisimageserviceport . "\r\n";
			$query .= "Connection: close\r\n";
			$query .= "Content-Type: application/x-www-form-urlencoded; charset=UTF-8\r\n";
			$query .= 'Content-Length: ' . strlen($postdata) . "\r\n";
			$query .= "\r\n";
			$query .= $postdata;
			
			fwrite($socket, $query);
			
			$content = '';
			while (!feof($socket)) {
		        $content .= fgets($socket, 128);
		    }
			fclose($socket);
			
			$content_splited = explode("\r\n\r\n", $content, 2);
			
			$handle = fopen($filepath, 'w');
			fwrite($handle, $content_splited[1]);
			fclose($handle);
		}
	}
}

$relativepath = get_file_argument('wrs_showimage.php');
$args = explode('/', trim($relativepath, '/'));

if (!isset($args[0])) {
	echo '<h1>Error</h1>No valid arguments supplied.';
	exit;
}

$image    = $args[0];
$pathname = $CFG->dataroot . '/' . $CFG->wirisimagedir . '/' . $image;

// If image doesn't exists, create it from database information
if (!file_exists($pathname)) {
	$md5 = str_replace('.png', '', $image);

	// Getting params from database through md5sum
	if (($wrscache = get_record('cache_filters', 'filter', 'wiris', 'md5key', $md5)) !== false) {
		if (!file_exists($CFG->dataroot.'/'.$CFG->wirisimagedir) and make_upload_directory($CFG->wirisimagedir) === false) {
			echo '<h1>Error</h1>WIRIS cache directory could not be created.';
		}
		$mathml = $wrscache->rawtext;
		create_image($mathml, $pathname);
	}
}

// Now, if file already exists, return it
if (file_exists($pathname)) {
	send_file($pathname, $image);
}
else {  
	echo '<h1>Error</h1>Image not found.</h1>';  
}

?>