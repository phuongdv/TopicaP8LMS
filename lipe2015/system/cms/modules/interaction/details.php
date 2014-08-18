<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author CaoPV
 * @package Interaction
 */
class Module_Interaction extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Interaction'
			),
			'description' => array(
				'en' => 'Interaction'
			),
			'frontend'	=> true,
			'backend'	=> true,
			'skip_xss'	=> true,
			'menu'		=> 'content',
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
