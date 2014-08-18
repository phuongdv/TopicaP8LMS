<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Show Right Content
 * @author		CaoPV
 * @package		PyroCMS\Core\Widgets
 */
class Widget_Top_menu extends Widgets
{

	/**
	 * The translations for the widget title
	 *
	 * @var array
	 */
	public $title = array(
		'en' => 'Top Menu'
	);

	/**
	 * The translations for the widget description
	 *
	 * @var array
	 */
	public $description = array(
		'en' => 'Top Menu'
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
		$this->load->model('menu/menus_m');
	}
	/**
	 * The main function of the widget.
	 *
	 * @param array $options The options for the AddThis widget.
	 * @return array
	 */
	public function run()
	{
		$params=array(
			'active'=>1,
			'limit'=>10
		);
		$rows = $this->menus_m->get_many_where($params,null,null,array('order_number'=>'asc'));
		return array(
			'rows'=>$rows
		);
	}

}