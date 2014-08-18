<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author CaoPV
 * @package Test
 */
class Module_Test extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Test'
			),
			'description' => array(
				'en' => 'Test'
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
