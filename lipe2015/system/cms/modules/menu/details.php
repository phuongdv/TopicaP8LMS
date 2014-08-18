<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author CaoPV
 * Class Module_Menu
 */
class Module_Menu extends Module
{

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Menu'
			),
			'description' => array(
				'en' => 'Menu',
			),
			'frontend' => true,
			'backend' => true,
			'menu' => '',
			'shortcuts' => array(
			)
		);
	}

	public function install()
	{

		return true;
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