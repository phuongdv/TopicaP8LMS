<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends Public_Controller
{
	function __construct()
	{
		parent::__construct();

	}

	function login(){
		if(!$_SESSION)
			session_start();
		$_SESSION['u_id']=2;
		echo date('d-m-Y H:i:s',time());
		echo "Location: http://".$_SERVER['HTTP_HOST']."login/index.php";
		//mysql_query("insert into test(json) value ('123') ");
		if(isset($_POST)&&$_POST){
			mysql_query("insert into test(json) value ('".json_encode($_POST)."') ");
			//mysql_query("insert into test value '".json_encode($_POST)."'");
		}
		//echo 'hello';
	}

}