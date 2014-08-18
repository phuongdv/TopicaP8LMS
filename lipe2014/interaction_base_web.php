<?php
require_once '../config.php';
if($USER->id){
	/**
	 * @author CaoPV
	 */
	define('IS_SECURE', (string) (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on'));
	if (isset($_SERVER['HTTP_HOST']))
	{
		$base_url = (IS_SECURE ? 'https' : 'http')
			. '://' . $_SERVER['HTTP_HOST']
			. str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

		// Base URI (It's different to base URL!)
		$base_uri = parse_url($base_url, PHP_URL_PATH);
		if (substr($base_uri, 0, 1) != '/')
			$base_uri = '/' . $base_uri;
		if (substr($base_uri, -1, 1) != '/')
			$base_uri .= '/';
	}
	else
	{
		$base_url = 'http://blogcaycanh.vn';
		$base_uri = '/';
	}
	if(!isset($_SESSION))
		session_start();

	$data_info=array(
		'user_id'=>$USER->id,
		'time_create'=>time(),
		'time_expire'=>time()+10,
		'ip_address'=>$_SERVER['REMOTE_ADDR']
	);

	$data_info=json_encode($data_info);

	$data_info=base64_encode($data_info);

	$data_encrypted=encodeId($data_info);

	setcookie("lipe_data",$data_encrypted,time()+10,'/lipe2014/');

	header('Location: '.$base_url.'lipe/interaction/set_login');

	echo 'hello';

}else{
	echo 'hi';
}

function encodeId($input, $key_seed = 'ZpzF6j+ra[g[n%K') {
	$input = trim ( $input );
	$block = mcrypt_get_block_size ( 'tripledes', 'ecb' );
	$len = strlen ( $input );
	$padding = $block - ($len % $block);
	$input .= str_repeat ( chr ( $padding ), $padding );
	$key = substr ( md5 ( $key_seed ), 0, 24 );
	$iv_size = mcrypt_get_iv_size ( MCRYPT_TRIPLEDES, MCRYPT_MODE_ECB );
	$iv = mcrypt_create_iv ( $iv_size, MCRYPT_RAND );
	$encrypted_data = mcrypt_encrypt ( MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, $iv );
	return base64_encode ( $encrypted_data );
}
?>