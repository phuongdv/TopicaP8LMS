<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show Right Content
 * @author		CaoPV
 * @package		PyroCMS\Core\Widgets
 */
class Widget_Footer extends Widgets
{

	/**
	 * The translations for the widget title
	 *
	 * @var array
	 */
	public $title = array(
		'en' => 'Footer'
	);

	/**
	 * The translations for the widget description
	 *
	 * @var array
	 */
	public $description = array(
		'en' => 'Footer'
	);

	/**
	 * The author of the widget
	 *
	 * @var string
	 */
	public $author = 'CaoPV';

	/**
	 * The author's website.
	 *
	 * @var string
	 */
	public $website = 'http://blogcaycanh.vn';

	/**
	 * The version of the widget
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * The fields for customizing the options of the widget.
	 *
	 * @var array
	 */
	public $fields = array();

	public function __construct()
	{
		// Load the navigation model from the navigation module.
		$this->load->model('static_info/static_info_m');
	}
	/**
	 * The main function of the widget.
	 *
	 * @param array $options The options for the AddThis widget.
	 * @return array
	 */
	public function run()
	{
		$footer = $this->static_info_m->get(1);
		return array(
			'footer'=>$footer
		);
	}

}