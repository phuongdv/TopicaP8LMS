<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author CaoPV
 * @package Interaction
 */
class Module_Event extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Event'
			),
			'description' => array(
				'en' => 'Event'
			),
			'frontend'	=> true,
			'backend'	=> true,
			'skip_xss'	=> true,
			'menu'		=> '',
			'roles' => array(
				'index','add','edit','delete'
			),
		);
	}

	public function install()
	{
		return false;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}
