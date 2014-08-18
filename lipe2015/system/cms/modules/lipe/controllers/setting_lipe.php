<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Setting_lipe
 * @author CaoPV <vancao.vn@gmail.com>
 */
class Setting_lipe extends Public_Controller
{
	protected $validation_rules = array(
		array(
			'field' => 'style',
			'label' => 'Style',
			'rules' => 'trim|required|max_length[20]'
		),
		array(
			'field' => 'active_id',
			'label' => 'Active Id',
			'rules' => 'required|trim|numeric'
		),
		array(
			'field' => 'lipe_type',
			'label' => 'Lipe Type',
			'rules' => 'required|trim'
		),
		array(
			'field' => 'calendar_id',
			'label' => 'Tuần',
			'rules' => 'required|trim|numeric'
		),
		array(
			'field' => 'comment',
			'label' => 'Ghi chú',
			'rules' => 'trim|max_length[250]'
		)
	);

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('mdl_course_m','huy_setting_calendar_m','huy_setting_lipe_m','lipe_course_mode_m','mdl_quiz_m'));
		$this->style = array(
			'exam'=>'Exam',
			'forum'=>'Forum'
		);

		$this->lipe_type=array(
			'forum'=>array(
				array('id'=>'V','style_id'=>'forum','name'=>'V - Diễn đàn VBB')
			),
			'exam'=>array(
				array('id'=>'E','style_id'=>'exam','name'=>'E - Bài tập về nhà'),
				array('id'=>'P','style_id'=>'exam','name'=>'P - Bài luyện trắc nghiệm')
			)
		);

		$this->lipe_type_options=array();
		foreach($this->lipe_type as $key=>$value){
			foreach($value as $v){
				$this->lipe_type_options[$key][$v['id']]=$v['name'];
			}
		}

		$this->base_url="/lipe";
	}

	function index(){
		echo 'Thiết lập Lipe';
	}

	/**
	 * Thiết lập Lipe
	 * @param int $course_id
	 */
	function course($course_id=0){

		check_access($course_id);

		$base_where=array(
			'calendar_id'		=>'',
			'style'				=>'',
			'active_id'			=>'',
			'lipe_type'			=>'',
			'active_id_forum'	=>''
		);

		$params=array();
		if($this->input->post()||$this->input->get()){
			if($this->input->post())
				$data=$this->input->post();
			else
				$data=$this->input->get();
			if(!empty($data)){
				foreach($base_where as $key=>$value){
					if(!empty($data[$key])){
						$params[$key]=trim($data[$key]);
						$base_where[$key]=trim($data[$key]);
					}
				}
			}
		}

		if($this->input->post('active_id_forum')){
			$params['active_id']=$this->input->post('active_id_forum');
			unset($params['active_id_forum']);
			$base_where['active_id']='';
		}

		$params['huy_setting_lipe.c_id']=$course_id;

		$course=$this->mdl_course_m->get($course_id);
		if(!$course){
			$this->session->set_flashdata('error','Khóa học không tồn tại !');
			redirect($this->base_url);
		}
		$rows=$this->huy_setting_lipe_m->get_many_where(
			$params,
			array('huy_setting_lipe.id','huy_setting_lipe.c_id','huy_setting_lipe.calendar_id','huy_setting_lipe.style','huy_setting_lipe.active_id',
			'huy_setting_lipe.lipe_type','huy_setting_lipe.comment','huy_setting_calendar.week_name'),
			array('huy_setting_calendar'=>array('on'=>'huy_setting_lipe.calendar_id=huy_setting_calendar.id','type'=>'left')),
			array('huy_setting_lipe.id'=>'asc')
		);
		$total_rows=count($rows);


		$calendars=$this->huy_setting_calendar_m->get_many_where(array('c_id'=>$course->id),null,null,array('id'=>'asc'));
		$calendar_options=array(
			''=>'==Tuần học=='
		);
		if(!empty($calendars)){
			foreach($calendars as $calendar){
				$calendar_options[$calendar->id]=$calendar->week_name;
			}
		}

		$actives=$this->mdl_quiz_m->get_many_where(array('course'=>$course->id),array('id','name'),null,array('id'=>'asc'));
		$active_options=array(
			''=>'==Active_ID=='
		);
		if(!empty($actives)){
			foreach($actives as $active){
				$active_options[$active->id]=$active->id.' - '.$active->name;
			}
		}

		$lipe_type=array(
			''=>'==Lipe Type==',
			'V'=>'V - Diễn đàn VBB',
			'E'=>'E - Bài tập về nhà',
			'P'=>'P - Bài luyện trắc nghiệm'
		);

		$style=array(
			''=>'==Style==',
			'exam'=>'Exam',
			'forum'=>'Forum'
		);

		$this->template
			->title('Thiết lập Lipe')
			->set('title','Lipe của khóa : '.$course->shortname)
			->set('course',$course)
			->set('rows',$rows)
			->set('total_rows',$total_rows)
			->set('calendar_options',$calendar_options)
			->set('active_options',$active_options)
			->set('lipe_type',$lipe_type)
			->set('style',$style)
			->set('base_where',$base_where)
			->build('setting_lipe_index');
	}

	/**
	 * Thêm mới Lipe
	 * @author CaoPV <vancao.vn@gmail.com>
	 */
	function add($course_id){

		check_access($course_id,true);

		$course=$this->mdl_course_m->get($course_id);
		if(!$course){
			$this->session->set_flashdata('error','Khóa học không tồn tại !');
			redirect($this->base_url);
		}
		$rows=$this->huy_setting_lipe_m->get_many_where(
			array('huy_setting_lipe.c_id'=>$course->id),
			array('huy_setting_lipe.id','huy_setting_lipe.c_id','huy_setting_lipe.calendar_id','huy_setting_lipe.style','huy_setting_lipe.active_id',
				'huy_setting_lipe.lipe_type','huy_setting_lipe.comment','huy_setting_calendar.week_name'),
			array('huy_setting_calendar'=>array('on'=>'huy_setting_lipe.calendar_id=huy_setting_calendar.id','type'=>'left')),
			array('huy_setting_lipe.calendar_id'=>'asc')
		);
		$total_rows=count($rows);

		$calendars=$this->huy_setting_calendar_m->get_many_where(array('c_id'=>$course->id),null,null,array('id'=>'asc'));
		$calendar_options=array();
		if(!empty($calendars)){
			foreach($calendars as $calendar){
				$calendar_options[$calendar->id]=$calendar->week_name;
			}
		}

		$actives=$this->mdl_quiz_m->get_many_where(array('course'=>$course->id),array('id','name'),null,array('id'=>'asc'));
		$active_options=array();
		if(!empty($actives)){
			foreach($actives as $active){
				$active_options[$active->id]=$active->id.' - '.$active->name;
			}
		}

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
					'style'			=>$this->input->post('style'),
					'active_id'		=>$this->input->post('active_id'),
					'lipe_type'		=>$this->input->post('lipe_type'),
					'calendar_id'	=>$this->input->post('calendar_id'),
					'comment'		=>$this->input->post('comment')
				);
				if($this->input->post('style')=='forum'){
					//CaoPV:hard code với style là diễn đàn VBB
					if(!$this->input->post('active_id_vbb')){
						$this->session->set_flashdata('error','Bạn phải nhập mã Active ID theo mã bên forum !');
						redirect('/lipe/setting_lipe/add/'.$course->id);
						break;
					}
					$input['active_id']=$this->input->post('active_id_vbb');
					//End hard code
				}
				if($this->huy_setting_lipe_m->insert($input)){
					//$this->huy_setting_calendar_m->delete_cache();
					$this->session->set_flashdata('success','Thiết lập Lipe thành công !');
					redirect('/lipe/setting_lipe/course/'.$course->id);
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

		if(!$data->style){
			$data->style='exam';
		}
		$data->id=0;

		$lipe_type_options=$this->lipe_type_options[$data->style];

		$this->template
			->title('Thiết lập Lipe')
			->set('title','Thiết lập Lipe mới cho : '.$course->shortname)
			->set('course',$course)
			->set('data',$data)
			->set('rows',$rows)
			->set('total_rows',$total_rows)
			->set('calendar_options',$calendar_options)
			->set('active_options',$active_options)
			->set('style',$this->style)
			->set('lipe_type',json_encode($this->lipe_type))
			->set('lipe_type_options',$lipe_type_options)
			->set('btn_title','Thêm mới')
			->build('setting_lipe_form');
	}

	/**
	 * Thêm mới Lipe
	 * @author CaoPV <vancao.vn@gmail.com>
	 */
	function edit($id){
		$data=$this->huy_setting_lipe_m->get($id);
		if(!$data){
			$this->session->set_flashdata('error','Đường dẫn không tồn tại !');
			redirect($this->base_url);
		}

		check_access($data->c_id,true);

		$course=$this->mdl_course_m->get($data->c_id);

		if(!$course){
			$this->session->set_flashdata('error','Khóa học không tồn tại !');
			redirect($this->base_url);
		}
		$rows=$this->huy_setting_lipe_m->get_many_where(
			array('huy_setting_lipe.c_id'=>$course->id),
			array('huy_setting_lipe.id','huy_setting_lipe.c_id','huy_setting_lipe.calendar_id','huy_setting_lipe.style','huy_setting_lipe.active_id',
				'huy_setting_lipe.lipe_type','huy_setting_lipe.comment','huy_setting_calendar.week_name'),
			array('huy_setting_calendar'=>array('on'=>'huy_setting_lipe.calendar_id=huy_setting_calendar.id','type'=>'left')),
			array('huy_setting_lipe.calendar_id'=>'asc')
		);
		$total_rows=count($rows);

		$calendars=$this->huy_setting_calendar_m->get_many_where(array('c_id'=>$course->id),null,null,array('id'=>'asc'));
		$calendar_options=array();
		if(!empty($calendars)){
			foreach($calendars as $calendar){
				$calendar_options[$calendar->id]=$calendar->week_name;
			}
		}

		$actives=$this->mdl_quiz_m->get_many_where(array('course'=>$course->id),array('id','name'),null,array('id'=>'asc'));
		$active_options=array();
		if(!empty($actives)){
			foreach($actives as $active){
				$active_options[$active->id]=$active->id.' - '.$active->name;
			}
		}

		$this->form_validation->set_rules($this->validation_rules);

		if($this->input->post()){
			while(TRUE){
				if(!$this->form_validation->run()){
					$this->session->set_flashmessage('error',$this->form_validation->error_string());
					break;
				}

				$input=array(
					'style'			=>$this->input->post('style'),
					'active_id'		=>$this->input->post('active_id'),
					'lipe_type'		=>$this->input->post('lipe_type'),
					'calendar_id'	=>$this->input->post('calendar_id'),
					'comment'		=>$this->input->post('comment')
				);

				if($this->input->post('style')=='forum'){
					//CaoPV:hard code với style là diễn đàn VBB
					if(!$this->input->post('active_id_vbb')){
						$this->session->set_flashdata('error','Bạn phải nhập mã Active ID theo mã bên forum !');
						redirect('/lipe/setting_lipe/add/'.$course->id);
						break;
					}
					$input['active_id']=$this->input->post('active_id_vbb');
					//End hard code
				}

				if($this->huy_setting_lipe_m->update($id,$input)){
					//$this->huy_setting_calendar_m->delete_cache();
					$this->session->set_flashdata('success','Thiết lập Lipe thành công !');
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

		$lipe_type_options=$this->lipe_type_options[$data->style];

		$this->template
			->title('Cập nhật Lipe')
			->set('title','Cập nhật Lipe cho : '.$course->shortname)
			->set('course',$course)
			->set('data',$data)
			->set('rows',$rows)
			->set('total_rows',$total_rows)
			->set('calendar_options',$calendar_options)
			->set('active_options',$active_options)
			->set('style',$this->style)
			->set('lipe_type',json_encode($this->lipe_type))
			->set('lipe_type_options',$lipe_type_options)
			->set('btn_title','Cập nhật')
			->build('setting_lipe_form');
	}

	/**
	 * @param int $id
	 * Xóa Lipe
	 * @author CaoPV <vancao.vn@gmail.com>
	 */
	function delete($id=0,$course_id=0){

		check_access($course_id,true);

		//Kiểm tra hành động xóa phải được thực hiện từ màn hình quản lý danh sách lipe
		if(!isset($_SERVER['HTTP_REFERER'])||(
				isset($_SERVER['HTTP_REFERER'])&&strpos($_SERVER['HTTP_REFERER'],'lipe/setting_lipe')===false)){
			exit("Khong hop le");
		}
		if($this->huy_setting_lipe_m->delete($id)){
			$this->session->set_flashdata('success','Xóa lịch học thành công !');
			redirect('/lipe/setting_lipe/course/'.$course_id);
		}else{
			$this->session->set_flashmessage('error','Có lỗi xảy ra trong quá trình cập nhật dữ liệu vào database !');
			redirect('/lipe/setting_lipe/course/'.$course_id);
		}
	}
}
