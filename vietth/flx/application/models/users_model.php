<?php
class Users_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	
	function get_users($c_id) {
		
	
		
		
		$this->db->distinct();
		$this->db->select('u.id uid,u.lastname lastname,trim(u.firstname) firstname,u.username username,u.topica_nhom nhom,u.topica_lop lop');
		$this->db->from('mdl_user u');
		$this->db->join('mdl_role_assignments ra', 'ra.userid = u.id');
		$this->db->join('mdl_context ct', 'ct.id = ra.contextid');
		$this->db->join('mdl_course c', 'c.id = ct.instanceid');
		$this->db->join('mdl_role r', 'r.id = ra.roleid');
		$this->db->join('mdl_course_categories cc', 'cc.id = c.category');
		
		$this->db->where('r.id',5);
		$this->db->where('c.id',$c_id);
		
		$this->db->order_by("firstname", "asc"); 
		$query = $this->db->get('mdl_user');
       //debug  echo $this->db->last_query();  
       
	return $query;
	}
 function get_week($c_id)
	 {
	  $this->db->where('c_id',$c_id);
	  $this->db->order_by("id", "asc"); 
	  $query=$this->db->get('huy_setting_calendar');
	  return $query;
	 }	
}
?>