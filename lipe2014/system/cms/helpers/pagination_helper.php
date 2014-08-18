<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * PyroCMS Pagination Helpers
 *  
 * @package PyroCMS\Core\Helpers
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */
if ( ! function_exists('create_pagination'))
{

	/**
	 * The Pagination helper cuts out some of the bumf of normal pagination
	 *
	 * @param string $uri The current URI.
	 * @param int $total_rows The total of the items to paginate.
	 * @param int|null $limit How many to show at a time.
	 * @param int $uri_segment The current page.
	 * @param boolean $full_tag_wrap Option for the Pagination::create_links()
	 * @return array The pagination array. 
	 * @see Pagination::create_links()
	 */
	function create_pagination($uri, $total_rows, $limit = null, $uri_segment = 4, $full_tag_wrap = true)
	{
		$ci = & get_instance();
		$ci->load->library('pagination');

		$current_page = $ci->uri->segment($uri_segment, 0);
		$suffix = $ci->config->item('url_suffix');

		$limit = $limit === null ? Settings::get('records_per_page') : $limit;

		// Initialize pagination
		$ci->pagination->initialize(array(
			'suffix' 				=> $suffix,
			'base_url' 				=> ( ! $suffix) ? rtrim(site_url($uri), $suffix) : site_url($uri),
			'total_rows' 			=> $total_rows,
			'per_page' 				=> $limit,
			'uri_segment' 			=> $uri_segment,
			'use_page_numbers'		=> true,
			'reuse_query_string' 	=> true,
		));

		$offset = $limit * ($current_page - 1);
		
		//avoid having a negative offset
		if ($offset < 0) $offset = 0;

		return array(
			'current_page' => $current_page,
			'per_page' => $limit,
			'limit' => $limit,
			'offset' => $offset,
			'links' => $ci->pagination->create_links($full_tag_wrap)
		);
	}

	function create_my_pagination($uri, $total_rows, $limit, $uri_segment,$add_select_page = 0, $option = array('navigate_function' => 'navigate', 'limit_id' => 'limit')) {

		$CI =& get_instance();
		$CI->load->library('pagination');
		$CI->lang->load('common');
		//die($CI->lang->line('first_link'));

		$current_page = $uri_segment; //
		//$current_page = $CI->uri->segment($uri_segment, 0);

		// Initialize pagination
		$config['base_url'] = site_url().$uri.'/';
		$config['total_rows'] = $total_rows; // count all records
		$config['per_page'] = $limit === NULL ? $CI->settings->item('records_per_page') : $limit;
		$config['uri_segment'] = $uri_segment;
		$config['page_query_string'] = FALSE;

		$config['num_links'] = 4;


		$config['first_link'] = $CI->lang->line('first_link');
		$config['first_tag_open'] = '<div class="button2-right"><span class="start">';
		$config['first_tag_open_off'] = '<div class="button2-right off"><span class="start">';
		$config['first_tag_close'] = '</span></div>';

		$config['prev_link'] = $CI->lang->line('prev_link');
		$config['prev_tag_open'] = '<div class="button2-right"><span class="prev">';
		$config['prev_tag_open_off'] = '<div class="button2-right off"><span class="prev">';
		$config['prev_tag_close'] = '</span></div>';

		$config['cur_tag_open'] = '<span class="current roundedBordersLite">';
		$config['cur_tag_close'] = '</span>';

		$config['num_tag_open'] = '<span>';
		$config['num_tag_close'] = '</span>';

		$config['next_link'] = $CI->lang->line('next_link');
		$config['next_tag_open'] = '<div class="button3-left"><span class="next">';
		$config['next_tag_open_off'] = '<div class="button3-left off"><span class="next">';
		$config['next_tag_close'] = '</span></div>';

		$config['last_link'] = $CI->lang->line('last_link');
		$config['last_tag_open'] = '<div class="button3-left"><span class="end">';
		$config['last_tag_open_off'] = '<div class="button3-left off"><span class="end">';
		$config['last_tag_close'] = '</span></div>';

		$config['page_location_tag_open'] = '<div class="page_location">';
		$config['page_location_tag_close'] = '</div>';
		$config['page_location'] = $CI->lang->line('page_location');

		$config['add_select_page'] = $add_select_page;

		$config['navigate_function'] = isset($option['navigate_function']) ? $option['navigate_function'] : 'navigate';
		$config['limit_id'] = isset($option['limit_id']) ? $option['limit_id'] : 'limit';

		$CI->pagination->initialize($config); // initialize pagination

		return array(
			'current_page'     => $current_page,
			'per_page'         => $config['per_page'],
			'limit'            => array($config['per_page'], $current_page),
			'limit_id'         => $config['limit_id'],
			'links'            => $CI->pagination->create_links()
		);
	}


	function create_ajax_pagination($uri, $total_rows, $limit, $uri_segment,$add_select_page = 0, $option = array('navigate_function' => 'navigate', 'limit_id' => 'limit')) {

		$CI =& get_instance();
		$CI->load->library('pagination');
		$CI->lang->load('common');
		//die($CI->lang->line('first_link'));

		$current_page = $uri_segment; //
		//$current_page = $CI->uri->segment($uri_segment, 0);

		// Initialize pagination
		$config['base_url'] = site_url().$uri.'/';
		$config['total_rows'] = $total_rows; // count all records
		$config['per_page'] = $limit === NULL ? $CI->settings->item('records_per_page') : $limit;
		$config['uri_segment'] = $uri_segment;
		$config['page_query_string'] = FALSE;

		$config['num_links'] = 4;


		$config['first_link'] = $CI->lang->line('first_link');
		$config['first_tag_open'] = '<div class="button2-right"><span class="start">';
		$config['first_tag_open_off'] = '<div class="button2-right off"><span class="start">';
		$config['first_tag_close'] = '</span></div>';

		$config['prev_link'] = $CI->lang->line('prev_link');
		$config['prev_tag_open'] = '<div class="button2-right"><span class="prev">';
		$config['prev_tag_open_off'] = '<div class="button2-right off"><span class="prev">';
		$config['prev_tag_close'] = '</span></div>';

		$config['cur_tag_open'] = '<span class="current roundedBordersLite">';
		$config['cur_tag_close'] = '</span>';

		$config['num_tag_open'] = '<span>';
		$config['num_tag_close'] = '</span>';

		$config['next_link'] = $CI->lang->line('next_link');
		$config['next_tag_open'] = '<div class="button3-left"><span class="next">';
		$config['next_tag_open_off'] = '<div class="button3-left off"><span class="next">';
		$config['next_tag_close'] = '</span></div>';

		$config['last_link'] = $CI->lang->line('last_link');
		$config['last_tag_open'] = '<div class="button3-left"><span class="end">';
		$config['last_tag_open_off'] = '<div class="button3-left off"><span class="end">';
		$config['last_tag_close'] = '</span></div>';

		$config['page_location_tag_open'] = '<div class="page_location">';
		$config['page_location_tag_close'] = '</div>';
		$config['page_location'] = $CI->lang->line('page_location');

		$config['add_select_page'] = $add_select_page;

		$config['navigate_function'] = isset($option['navigate_function']) ? $option['navigate_function'] : 'navigate';
		$config['limit_id'] = isset($option['limit_id']) ? $option['limit_id'] : 'limit';

		$CI->pagination->initialize($config); // initialize pagination

		return array(
			'current_page'     => $current_page,
			'per_page'         => $config['per_page'],
			'limit'            => array($config['per_page'], $current_page),
			'limit_id'         => $config['limit_id'],
			'links'            => $CI->pagination->create_ajax_links()
		);
	}


	function create_url_pagination($uri, $total_rows, $limit, $uri_segment,$target_id='',$add_select_page = 0, $option = array('navigate_function' => 'navigate', 'limit_id' => 'limit')) {

		$CI =& get_instance();
		$CI->load->library('pagination');
		$CI->lang->load('common');
		//die($CI->lang->line('first_link'));

		$current_page = $uri_segment; //
		//$current_page = $CI->uri->segment($uri_segment, 0);

		// Initialize pagination
		$config['base_url'] = site_url().$uri.'/';
		$config['total_rows'] = $total_rows; // count all records
		$config['per_page'] = $limit === NULL ? $CI->settings->item('records_per_page') : $limit;
		$config['uri_segment'] = $uri_segment;
		$config['page_query_string'] = FALSE;

		$config['num_links'] = 4;


		$config['first_link'] = $CI->lang->line('first_link');
		$config['first_tag_open'] = '<div class="button2-right"><span class="start">';
		$config['first_tag_open_off'] = '<div class="button2-right off"><span class="start">';
		$config['first_tag_close'] = '</span></div>';

		$config['prev_link'] = $CI->lang->line('prev_link');
		$config['prev_tag_open'] = '<div class="button2-right"><span class="prev">';
		$config['prev_tag_open_off'] = '<div class="button2-right off"><span class="prev">';
		$config['prev_tag_close'] = '</span></div>';

		$config['cur_tag_open'] = '<span class="current roundedBordersLite">';
		$config['cur_tag_close'] = '</span>';

		$config['num_tag_open'] = '<span>';
		$config['num_tag_close'] = '</span>';

		$config['next_link'] = $CI->lang->line('next_link');
		$config['next_tag_open'] = '<div class="button3-left"><span class="next">';
		$config['next_tag_open_off'] = '<div class="button3-left off"><span class="next">';
		$config['next_tag_close'] = '</span></div>';

		$config['last_link'] = $CI->lang->line('last_link');
		$config['last_tag_open'] = '<div class="button3-left"><span class="end">';
		$config['last_tag_open_off'] = '<div class="button3-left off"><span class="end">';
		$config['last_tag_close'] = '</span></div>';

		$config['page_location_tag_open'] = '<div class="page_location">';
		$config['page_location_tag_close'] = '</div>';
		$config['page_location'] = $CI->lang->line('page_location');

		$config['add_select_page'] = $add_select_page;

		$config['navigate_function'] = isset($option['navigate_function']) ? $option['navigate_function'] : 'navigate';
		$config['limit_id'] = isset($option['limit_id']) ? $option['limit_id'] : 'limit';
		$config['target_id']=$target_id;

		$CI->pagination->initialize($config); // initialize pagination

		return array(
			'current_page'     => $current_page,
			'per_page'         => $config['per_page'],
			'limit'            => array($config['per_page'], $current_page),
			'limit_id'         => $config['limit_id'],
			'links'            => $CI->pagination->create_url_links()
		);
	}
}