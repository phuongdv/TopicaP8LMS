<?php
class Courses_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	
	function get_courses($num, $offset) {
		$this->db->select('id, fullname, shortname, timemodified');
		$this->db->order_by("id", "asc"); 
		$query = $this->db->get('mdl_course', $num, $offset);
    // debug    echo  $this->db->last_query();
	return $query;
	}
}
?>