<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Setting_calendar
 * @author CaoPV <vancao.vn@gmail.com>
 */
class Setting_calendar extends Public_Controller
{

	protected $validation_rules = array(
		array(
			'field' => 'week_name',
			'label' => 'Tên tuần',
			'rules' => 'trim|required|max_length[50]'
		),
		array(
			'field' => 'start_date',
			'label' => 'Ngày bắt đầu',
			'rules' => 'required|trim'
		),
		array(
			'field' => 'end_date',
			'label' => 'Ngày kết thúc',
			'rules' => 'required|trim'
		),
		array(
			'field' => 'comment',
			'label' => 'Ghi chú',
			'rules' => 'trim|max_length[200]'
		)
	);

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('mdl_course_m','huy_setting_calendar_m','huy_setting_lipe_m','lipe_course_mode_m'));
		$this->base_url="/lipe";
	}

	function index(){
		echo 'Thiết lập thời gian học';
	}

	function course($course_id=0){

		check_access($course_id);

		$course=$this->mdl_course_m->get($course_id);
		if(!$course){
			$this->session->set_flashdata('error','Khóa học không tồn tại !');
			redirect($this->base_url);
		}
		$rows=$this->huy_setting_calendar_m->get_many_where(array('c_id'=>$course->id),null,null,array('end_date'=>'asc'));
		$total_rows=count($rows);

		$this->template
			->title('Thiết lập lịch học')
			->set('title','Thời gian học của khóa : '.$course->shortname)
			->set('course',$course)
			->set('rows',$rows)
			->set('total_rows',$total_rows)
			->build('setting_calendar_index');
	}

	/**
	 * Thêm mới tuần học cho khóa học
	 * @author CaoPV <vancao.vn@gmail.com>
	 */
	function add($course_id){

		check_access($course_id,true);

		$course=$this->mdl_course_m->get($course_id);
		if(!$course){
			$this->session->set_flashdata('error','Khóa học không tồn tại !');
			redirect($this->base_url);
		}

		/*$max_end_date=$this->huy_setting_calendar_m->getMaxDateOfCourse($course_id);
		if($max_end_date)
			$max_end_date=date(DATE_DATABASE_FORMAT,$max_end_date+86400);
		else
			$max_end_date=date('1970-01-01');*/

		$rows=$this->huy_setting_calendar_m->get_many_where(array('c_id'=>$course->id));
		$total_rows=count($rows);

		$data=new stdClass();
		$this->form_validation->set_rules($this->validation_rules);

		if($this->input->post()){
			while(TRUE){
				if(!$this->form_validation->run()){
					$this->session->set_flashmessage('error',$this->form_validation->error_string());
					break;
				}
				$input=array(
					'c_id'			=>$course_id,
					'week_number'	=>0,
					'week_name'		=>$this->input->post('week_name'),
					'start_date'	=>strtotime($this->input->post('start_date')),
					'end_date'		=>strtotime($this->input->post('end_date').' 23:59:59'),
					'comment'		=>$this->input->post('comment')
				);
				if($this->huy_setting_calendar_m->insert($input)){
					$this->session->set_flashdata('success','Thiết lập lịch học thành công !');
					redirect(uri_string());
				}else{
					$this->session->set_flashmessage('error','Có lỗi xảy ra trong quá trình cập nhật dữ liệu vào database !');
					break;
				}
				break;
			}
		}

		foreach ($this->validation_rules as $key => $field)
		{
			$data->$field['field'] = set_value($field['field']);
		}

		$this->template
			->title('Thiết lập lịch học')
			->set('title','Thiết lập lịch học mới cho : '.$course->shortname)
			->set('course',$course)
			->set('data',$data)
			->set('rows',$rows)
			->set('total_rows',$total_rows)
			->set('max_end_date',false)
			->set('btn_title','Thêm mới')
			->build('setting_calendar_form');
	}

	function addLastWeek(){

	}

	/**
	 * Thêm mới tuần học cho khóa học
	 * @author CaoPV <vancao.vn@gmail.com>
	 */
	function edit($id){
		$data=$this->huy_setting_calendar_m->get($id);
		if(!$data){
			$this->session->set_flashdata('error','Khóa học không tồn tại !');
			redirect($this->base_url);
		}

		check_access($data->c_id,true);

		$course=$this->mdl_course_m->get($data->c_id);

		if(!$course){
			$this->session->set_flashdata('error','Khóa học không tồn tại !');
			redirect($this->base_url);
		}

		$rows=$this->huy_setting_calendar_m->get_many_where(array('c_id'=>$data->c_id));
		$total_rows=count($rows);

		$this->form_validation->set_rules($this->validation_rules);

		if($this->input->post()){
			while(TRUE){
				if(!$this->form_validation->run()){
					$this->session->set_flashmessage('error',$this->form_validation->error_string());
					break;
				}
				$input=array(
					'c_id'			=>$data->c_id,
					'week_name'		=>$this->input->post('week_name'),
					'start_date'	=>strtotime($this->input->post('start_date')),
					'end_date'		=>strtotime($this->input->post('end_date').' 23:59:59'),
					'comment'		=>$this->input->post('comment')
				);
				if($this->huy_setting_calendar_m->update($data->id,$input)){
					$this->session->set_flashdata('success','Cập nhật lịch học thành công !');
					redirect(uri_string());
				}else{
					$this->session->set_flashmessage('error','Có lỗi xảy ra trong quá trình cập nhật dữ liệu vào database !');
					break;
				}
				break;
			}

			foreach ($this->validation_rules as $key => $field)
			{
				$data->$field['field'] = set_value($field['field']);
			}
		}

		//Convert date về dạng ngày tháng
		$data->start_date=date(DATE_DATABASE_FORMAT,$data->start_date);
		$data->end_date=date(DATE_DATABASE_FORMAT,$data->end_date);

		/*$max_end_date=$this->huy_setting_calendar_m->getMaxDateOfCourse($course->id,$id);
		if($max_end_date)
			$max_end_date=date(DATE_DATABASE_FORMAT,$max_end_date+86400);
		else
			$max_end_date=date('1970-01-01');*/

		$this->template
			->title('Cập nhật lịch học')
			->set('title','Cập nhật lịch học cho : '.$course->shortname)
			->set('course',$course)
			->set('data',$data)
			->set('rows',$rows)
			->set('total_rows',$total_rows)
			->set('max_end_date',false)
			->set('btn_title','Cập nhật')
			->build('setting_calendar_form');
	}

	/**
	 * @param int $id
	 * Xóa tuần học
	 * @author CaoPV <vancao.vn@gmail.com>
	 */
	function delete($id=0,$course_id=0){

		check_access($course_id,true);

		//Kiểm tra hành động xóa phải được thực hiện từ màn hình quản lý danh sách các tuần học
		if(!isset($_SERVER['HTTP_REFERER'])||(
			isset($_SERVER['HTTP_REFERER'])&&strpos($_SERVER['HTTP_REFERER'],'lipe/setting_calendar')===false)){
			exit("Khong hop le");
		}
		if($this->huy_setting_calendar_m->delete($id)){
			$this->session->set_flashdata('success','Xóa lịch học thành công !');
			$this->session->set_flashdata('success','Xóa lịch học thành công !');
			redirect('/lipe/setting_calendar/course/'.$course_id);
		}else{
			$this->session->set_flashmessage('error','Có lỗi xảy ra trong quá trình cập nhật dữ liệu vào database !');
			redirect('/lipe/setting_calendar/course/'.$course_id);
		}
	}
	/**
	 * Thêm mới tuần học tự động cho khóa học
	 * @author CaoPV <vancao.vn@gmail.com>
	 */
	function add_auto($course_id){
		check_access($course_id,true);

		$course=$this->mdl_course_m->get($course_id);
		if(!$course){
			$this->session->set_flashdata('error','Khóa học không tồn tại!');
			redirect($this->base_url);
		}

		/*$max_end_date=$this->huy_setting_calendar_m->getMaxDateOfCourse($course_id);
		if($max_end_date)
			$max_end_date=date(DATE_DATABASE_FORMAT,$max_end_date+86400);
		else
			$max_end_date=date('1970-01-01');*/

		$rows=$this->huy_setting_calendar_m->get_many_where(array('c_id'=>$course->id));
		$total_rows=count($rows);

		$data=new stdClass();
		$validation_rules = array(
			array(
				'field' => 'week_number',
				'label' => 'Số tuần học',
				'rules' => 'trim|required|numeric'
			),
			array(
				'field' => 'start_date',
				'label' => 'Ngày bắt đầu',
				'rules' => 'required|trim'
			)
		);
		$this->form_validation->set_rules($validation_rules);

		if($this->input->post()){
			while(TRUE){
				if(!$this->form_validation->run()){
					$this->session->set_flashmessage('error',$this->form_validation->error_string());
					break;
				}
				$week_number=$this->input->post('week_number');
				$start_date_time_stamp=date('Y-m-d',strtotime($this->input->post('start_date')));

				$start_day=date('D',strtotime($this->input->post('start_date')));
				$day_in_week=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
				foreach($day_in_week as $key=>$value){
					if($start_day==$value){
						$count_day_first_week=7-$key;
					}
				}

				$input=array();

				$end_date=null;
				for($i=1;$i<=$week_number;$i++){
					if(!$end_date){
						$start_date_time=$start_date_time_stamp;
					}else{
						$start_date_time=date('Y-m-d',strtotime("+1 day",strtotime($end_date)));
					}
					$start_date=date('Y-m-d',strtotime($start_date_time));

					if($i==1){
						$week_number_day=$count_day_first_week;
					}else{
						$week_number_day=7;
					}

					$end_date=date('Y-m-d',strtotime('+'.($week_number_day-1).' day',strtotime($start_date)));

					$input[]=array(
						'c_id'			=>$course_id,
						'week_number'	=>0,
						'week_name'		=>'Tuần '.$i,
						'start_date'	=>strtotime($start_date.' 00:00:00'),
						'end_date'		=>strtotime($end_date.' 23:59:59'),
						'comment'		=>''
					);
				}
				if($this->huy_setting_calendar_m->insert_many($input)){
					$this->session->set_flashdata('success','Thiết lập lịch học thành công!');
					redirect(uri_string());
				}else{
					$this->session->set_flashmessage('error','Có lỗi xảy ra trong quá trình cập nhật dữ liệu vào database!');
					break;
				}
				break;
			}
		}

		foreach ($validation_rules as $key => $field)
		{
			$data->$field['field'] = set_value($field['field']);
		}

		if(!$this->input->post()){
			$data->week_number=7;
			$data->week_number_day=7;
		}

		$this->template
			->title('Thiết lập tự động thời gian học')
			->set('title','Thiết lập tự động thời gian học mới cho: '.$course->shortname)
			->set('course',$course)
			->set('data',$data)
			->set('rows',$rows)
			->set('total_rows',$total_rows)
			->set('max_end_date',false)
			->set('btn_title','Thêm mới')
			->build('setting_calendar_form_auto');
	}
}
