<?php  defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Huy_setting_calendar_m
 * @author CaoPV <vancao.vn@gmail.com>
 */
class Huy_setting_calendar_m extends MY_Model {
	protected $_cache_on=FALSE;
	protected $_table='huy_setting_calendar';

	/**
	 * @param int $course_id
	 * @param int $calendar_id
	 * @return bool
	 * @author CaoPV <vancao.vn@gmail.com>
	 */
	function getMaxDateOfCourse($course_id=0,$calendar_id=0){
		$this->db->select_max('end_date');
		if($course_id)
			$this->db->where('c_id',$course_id);
		if($calendar_id)
			$this->db->where('(id)<',$calendar_id);
		$query = $this->db->get($this->_table);
		if($query->num_rows())
			return $query->row()->end_date;
		return false;
	}

	/**
	 * @param int $course_id
	 * @return bool
	 * Get Min and Max date
	 * @author CaoPV <vancao.vn@gmail.com>
	 */
	function getMinMaxDateOfCourse($course_id=0){
		$this->db->select('min(start_date) as min_date,max(end_date) as max_date');
		if($course_id)
			$this->db->where('c_id',$course_id);
		$query = $this->db->get($this->_table);
		if($query->num_rows())
			return $query->row();
		return false;
	}

	/**
	 * @param int $course_id
	 * @param string $lipe_type
	 * @return bool
	 * @author CaoPV <vancao.vn@gmail.com>
	 */
	function getCalendarAndSettingLipe($course_id=0,$lipe_type='E'){
		$where_params=array($course_id,$lipe_type);
		if($this->_cache_on){
			$result=$this->_cache->_read($this->_model,__FUNCTION__,$where_params);
			if($result !== FALSE)
				return $result;
		}

		$sql="SELECT huy_setting_calendar.*,count(huy_setting_lipe.calendar_id) AS number_setting_lipe
				from huy_setting_calendar LEFT JOIN huy_setting_lipe
				on huy_setting_calendar.id=huy_setting_lipe.calendar_id AND huy_setting_lipe.lipe_type='".$lipe_type."'
				GROUP BY huy_setting_calendar.id
				HAVING huy_setting_calendar.c_id=".$course_id;

		$result=$this->db->query($sql);
		if($result->num_rows()){
			$rs=$result->result();

			if($this->_cache_on){
				$this->_cache->_write($this->_model,__FUNCTION__,$where_params,$rs);
			}

			return $rs;
		}
		return false;
	}
}