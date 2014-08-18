<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Menu Top
* @author CaoPV
*/
class Menus_m extends MY_Model {
	protected $_cache_on=TRUE;
	function maxOrderNumber(){
		$this->db->select_max('order_number');
		$query = $this->db->get($this->_table);
		return (int)$query->row()->order_number;
	}
}