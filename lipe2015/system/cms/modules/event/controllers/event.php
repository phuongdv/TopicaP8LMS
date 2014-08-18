<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends Public_Controller
{
	function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
		if(isset($_GET)&&$_GET){
			log_message('error',json_encode($_GET));
		}
	}

	public function listen(){
		while(ob_get_level())

		ob_end_clean();
		header('Connection: close');
		ignore_user_abort();
		ob_start();
		echo "ok";
		$size = ob_get_length();
		header("Content-Length: $size");
		ob_end_flush();
		flush();

		if(isset($_POST)&&$_POST){
			log_message('error',json_encode($_POST));
		}
		$this->process();
	}

	function process(){

	}
}