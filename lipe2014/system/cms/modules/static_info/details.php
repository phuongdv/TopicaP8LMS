<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Static info module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\static info
 */
class Module_static_info extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'static_info'
			),
			'description' => array(
				'en' => 'static_info'
			),
			'frontend'    => true,
			'backend'     => true,
			'skip_xss'    => true,
			'menu'        => 'content'
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

//a:23:{s:2:"en";s:11:"static_info";s:2:"ar";s:11:"static_info";s:2:"br";s:11:"static_info";s:2:"pt";s:11:"static_info";s:2:"cs";s:11:"static_info";s:2:"da";s:11:"static_info";s:2:"de";s:11:"static_info";s:2:"el";s:11:"static_info";s:2:"es";s:11:"static_info";s:2:"fi";s:11:"static_info";s:2:"fr";s:11:"static_info";s:2:"he";s:11:"static_info";s:2:"id";s:11:"static_info";s:2:"it";s:11:"static_info";s:2:"lt";s:11:"static_info";s:2:"nl";s:11:"static_info";s:2:"pl";s:11:"static_info";s:2:"ru";s:11:"static_info";s:2:"sl";s:11:"static_info";s:2:"zh";s:11:"static_info";s:2:"hu";s:11:"static_info";s:2:"th";s:11:"info_blocks";s:2:"se";s:11:"static_info";}