<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Setting_mode
 * @author CaoPV <vancao.vn@gmail.com>
 */
class Setting_mode extends Public_Controller
{
	protected $validation_rules = array(
		array(
			'field' => 'mode_id',
			'label' => 'Mode',
			'rules' => 'trim|required|numeric|max_length[2]'
		)
	);

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('mdl_course_m','lipe_course_mode_m'));

		$this->base_url="/lipe";
	}

	function index(){
		echo 'Thiết lập Mode';
	}

	/**
	 * Thiết lập Mode
	 * @param int $course_id
	 */
	function course($course_id=0,$is_popup=false){

		check_access($course_id,true,uri_string());

		$course=$this->mdl_course_m->get($course_id);
		if(!$course){
			$this->session->set_flashdata('error','Khóa học không tồn tại !');
			redirect($this->base_url);
		}
		$row=$this->lipe_course_mode_m->get_by(array('course'=>$course_id));

		if($row){
			if($this->input->post()){
				if($this->lipe_course_mode_m->update($row->id,array('mode'=>$this->input->post('mode')))){
					$this->session->set_flashdata('success','Cập nhật thành công');
					redirect($this->base_url);
				}

				$this->session->set_flashdata('error','Có lỗi xảy ra');
				redirect(uri_string());
			}

			$title='Cập nhật mode cho : '.$course->shortname;
			$btn_title="Cập nhật";

		}else{
			if($this->input->post()){
				if($this->lipe_course_mode_m->insert(array('course'=>$course->id,'mode'=>$this->input->post('mode')))){
					$this->session->set_flashdata('success','Thiết lập mode thành công');
					redirect($this->base_url);
				}

				$this->session->set_flashdata('error','Có lỗi xảy ra');
				redirect(uri_string());
			}

			$title='Thiết lập mode cho '.$course->shortname;
			$btn_title="Thiết lập";
			$row=new stdClass();
			$row->mode=1;
		}

		$modes=array(
			1=>'1 - Lớp học có Offline',
			2=>'2 - Lớp học không có Offline, có diễn đàn',
			3=>'3 - Lớp học không có Offline, không có diễn đàn'
		);

		$this->template
			->title($title)
			->set('title',$title)
			->set('btn_title',$btn_title)
			->set('course',$course)
			->set('row',$row)
			->set('modes',$modes)
			->set_layout($is_popup?false:'default')
			->build('setting_mode_form');
	}

}
