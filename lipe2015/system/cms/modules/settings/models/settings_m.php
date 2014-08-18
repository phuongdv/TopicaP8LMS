<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroCMS Settings Model
 *
 * Allows for an easy interface for site settings
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Settings\Models
 */

class Settings_m extends MY_Model {

	protected $_cache_on=TRUE;

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get
	 *
	 * Gets a setting based on the $where param.  $where can be either a string
	 * containing a slug name or an array of WHERE options.
	 *
	 * @access	public
	 * @param	mixed	$where
	 * @return	object
	 */
	public function get($where,$props=array())
	{
		if ( ! is_array($where))
		{
			$where = array('slug' => $where);
		}

		$where_params=array($where,$props);
		if($this->_cache_on){
			$result=$this->_cache->_read($this->_model,__FUNCTION__,$where_params);
			if($result)
				return $result;
		}

		$result=$this->db
			->select('*, IF(`value` = "", `default`, `value`) as `value`', false)
			->where($where)
			->get($this->_table)
			->row();

		if($this->_cache_on){
			$this->_cache->_write($this->_model,__FUNCTION__,$where_params,$result);
		}

		return $result;
	}

	/**
	 * Get Many By
	 *
	 * Gets all settings based on the $where param.  $where can be either a string
	 * containing a module name or an array of WHERE options.
	 *
	 * @access	public
	 * @param	mixed	$where
	 * @return	object
	 */
	public function get_many_by($where = array())
	{
		if ( ! is_array($where))
		{
			$where = array('module' => $where);
		}

		if($this->_cache_on){
			$result=$this->_cache->_read($this->_model,__FUNCTION__,$where);
			if($result)
				return $result;
		}

		$this->db
			->select('*, IF(`value` = "", `default`, `value`) as `value`', false)
			->where($where)
			->order_by('`order`', 'DESC');

		$result=$this->get_all();

		if($this->_cache_on){
			$this->_cache->_write($this->_model,__FUNCTION__,$where,$result);
		}

		return $result;
	}

	/**
	 * Update
	 *
	 * Updates a setting for a given $slug.
	 *
	 * @access	public
	 * @param	string	$slug
	 * @param	array	$params
	 * @return	bool
	 */
	public function update($slug = '', $params = array(), $skip_validation = false)
	{
		if($this->_cache_on)
			$this->_cache->_delete($this->_model,__FUNCTION__);
		return $this->db->update($this->_table, $params, array('slug' => $slug));
	}

	/**
	 * Sections
	 *
	 * Gets all the sections (modules) from the settings table.
	 *
	 * @access	public
	 * @return	array
	 */
	public function sections()
	{
		$sections = $this->select('module')
			->distinct()
			->where('module != ""')
			->get_all();

		$result = array();

		foreach ($sections as $section)
		{
			$result[] = $section->module;
		}

		return $result;
	}

}

/* End of file settings_m.php */