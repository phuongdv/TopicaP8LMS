<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Basic_Auth_Controller extends Controller
{
	function Basic_Auth_Controller()
	{
		parent::Controller();
		if ( !isset($_SERVER['PHP_AUTH_USER']) )
		{
			header('WWW-Authenticate: Basic realm="viiny is a tiny service"');
			header('HTTP/1.0 401 Unauthorized');
			// echo or view some message
			exit();
		}
		// also you can use your own model/library for check usename and password
		else if ($_SERVER['PHP_AUTH_USER'] == 'needim' AND $_SERVER['PHP_AUTH_PW'] == 'passwd')
		{
			return true;
		}
		else
		{
			// echo or view some message
			exit();
		}
	}
}

