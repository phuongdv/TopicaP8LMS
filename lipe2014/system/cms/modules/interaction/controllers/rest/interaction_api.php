<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Interaction_api
 * @author CaoPV
 */
class Interaction_api extends REST_Controller
{
	/**
	 * @return array|bool|string
	 * Send mail
	 * @author CaoPV
	 */
	function send_mail(){

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

		$this->_parse_post();

		if($this->input->post()){
			$results = Events::trigger('email', $this->input->post(), 'array');
			return $results;
		}
		return false;
	}
}