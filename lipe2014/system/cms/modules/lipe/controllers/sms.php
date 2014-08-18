<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Sms
 * @author CaoPV <vancao.vn@gmail.com>
 */
class Sms extends Public_Controller
{
	protected $validation_rules = array(
		array(
			'field' => 'sms_content',
			'label' => 'Nội dung tin nhắn',
			'rules' => 'required|trim|max_length[160]'
		)
	);

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('mdl_user_m','mdl_course_m','sms_info_m','sms_send_m',
		'mdl_quiz_m','ozekimessagein_m','ozekimessageout_m'));
		$this->base_url="/lipe/sms";
	}

	function index(){
		echo 'SMS';
	}

	/**
	 * Gửi SMS
	 * @param int $course_id
	 */
	function course($course_id=0){

		check_access($course_id);

		$user_data=$this->session->userdata('user_data');

		$course=$this->mdl_course_m->get($course_id);
		if(!$course){
			$this->session->set_flashdata('error','Khóa học không tồn tại !');
			redirect($this->base_url);
		}

		//Lấy danh sách quiz
		$quiz=$this->mdl_quiz_m->get_many_where(array('course'=>$course->id),array('id','name'));
		$quiz_options=array(0=>'==Choose incomplete tasks==');
		if(!empty($quiz)){
			foreach($quiz as $qz){
				$quiz_options[$qz->id]=$qz->name;
			}
		}

		//Các điều kiện tìm kiếm
		$base_where=array(
			'topica_lop'	=>'',
			'topica_nhom'	=>'',
			'username'		=>'',
			'email'			=>'',
			'quiz_id'		=>0
		);

		//Nếu có hành động Post thì lưu các dữ liệu post vào biến Params
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

		$params['mdl_course.id']=$course->id;
		$params['mdl_role_assignments.roleid']=5;

		//Lấy danh sách lớp và danh sách nhóm
		$arr_lop=array(''=>'==Search by Classes==','1'=>'==Chọn tất cả==');
		$arr_nhom=array(''=>'==Search by groups==');

		//Nếu post lên thì lấy theo dữ liệu post lên
		if($this->input->post()){
			$lop=$this->input->post('arr_lop');
			$nhom=$this->input->post('arr_nhom');
			$lop_array=explode('}||{',$lop);
			$nhom_array=explode('}||{',$nhom);
			if(!empty($lop_array)){
				$cnt=0;
				foreach($lop_array as $value){
					$cnt++;
					if($cnt<=2) continue;
					$arr_lop[$value]=$value;
				}
			}
			if(!empty($nhom_array)){
				$cnt=0;
				foreach($nhom_array as $value){
					$cnt++;
					if($cnt==1) continue;
					$arr_nhom[$value]=$value;
				}
			}
		//Nếu không thì vào cơ sở dữ liệu để lấy
		}else{
			$join_lop_nhom=array(
				'mdl_role_assignments'=>array('on'=>'mdl_user.id=mdl_role_assignments.userid','type'=>'inner'),
				'mdl_context'=>array('on'=>'mdl_role_assignments.contextid=mdl_context.id','type'=>'inner'),
				'mdl_course'=>array('on'=>'mdl_course.id=mdl_context.instanceid','type'=>'inner')
			);
			//Danh sách sinh viên
			$lop_nhom=$this->mdl_user_m->get_many_where(
				$params,
				array('distinct(mdl_user.id)','mdl_user.topica_lop','mdl_user.topica_nhom'),
				$join_lop_nhom
			);

			if(!empty($lop_nhom)){
				foreach($lop_nhom as $row){
					if(empty($arr_lop[$row->topica_lop]))
						$arr_lop[$row->topica_lop]=$row->topica_lop;
					if(empty($arr_nhom[$row->topica_nhom]))
						$arr_nhom[$row->topica_nhom]=$row->topica_nhom;
				}
			}

			if(!empty($arr_lop)){
				$lop=implode('}||{',$arr_lop);
			}else{
				$lop=false;
			}
			if(!empty($arr_nhom)){
				$nhom=implode('}||{',$arr_nhom);
			}else{
				$nhom=false;
			}
		}

		//Nếu có điều kiện tìm kiếm thì mới lấy dữ liệu ra hiển thị
		if(!empty($params['topica_lop'])||!empty($params['topica_nhom'])||!empty($params['username'])||!empty($params['email'])){
			if($params['topica_lop']==1)
				unset($params['topica_lop']);
			//Điều kiện Join giữa các bảng
			$join=array(
				'mdl_role_assignments'=>array('on'=>'mdl_user.id=mdl_role_assignments.userid','type'=>'inner'),
				'mdl_context'=>array('on'=>'mdl_role_assignments.contextid=mdl_context.id','type'=>'inner'),
				'mdl_course'=>array('on'=>'mdl_course.id=mdl_context.instanceid','type'=>'inner'),
				//'mdl_course_categories'=>array('on'=>'mdl_course.category=mdl_course_categories.id','type'=>'inner'),
				'offline'=>array('on'=>'mdl_user.id=offline.u_id and offline.c_id='.$course->id,'type'=>'left'),
				'lipe_course_mode'=>array('on'=>'mdl_course.id=lipe_course_mode.course','type'=>'left')
			);

			if(!empty($params['quiz_id'])){
				$this->load->model('vietth_q169_attempts_m');
				//Lấy ra danh sách sinh viên đã có quiz
				$user_quiz=$this->vietth_q169_attempts_m->get_many_where(array('quiz'=>$params['quiz_id']),
				array('distinct(userid)'));
				$user_quiz_arr=array();
				if(!empty($user_quiz)){
					foreach($user_quiz as $u_quiz){
						$user_quiz_arr[]=$u_quiz->userid;
					}
				}
				if(!empty($user_quiz_arr)){
					$params['where_not_in']=array('mdl_user.id'=>$user_quiz_arr);
				}
				unset($params['quiz_id']);
			}
			//Tổng số sinh viên của khóa học
			$total_student_rows=$this->mdl_user_m->count_many_where($params,$join,'distinct(mdl_user.id)');

			//Danh sách sinh viên
			$student_rows=$this->mdl_user_m->get_many_where(
				$params,
				array('distinct(mdl_user.id)','mdl_user.lastname','mdl_user.firstname','mdl_user.username','mdl_user.email',
					'mdl_user.topica_lop','mdl_user.topica_nhom','mdl_user.topica_msv','mdl_user.topica_namsinh','mdl_user.topica_dienthoai',
					'offline.btvn as btvn_offline','offline.number as number_offline',
					'lipe_course_mode.mode as course_mode'
				),
				$join,
				array('mdl_user.firstname'=>'asc')
			);

			//Danh sách số điện thoại
			$student_phones=array();

			if(!empty($student_rows)){
				foreach($student_rows as $student){
					$student_phones[$student->id]=$student->topica_dienthoai;
				}
			}
		}else{
			$total_student_rows=0;
			$student_rows=null;
			$student_phones=null;
		}

		$student_phones[$user_data['user_id']]=$user_data['user_phone'];

		$this->form_validation->set_rules($this->validation_rules);
		if($this->input->post('send')){

			//check_access($course_id,true,uri_string());

			while(true){

				//check_access($course_id,true,uri_string());

				if(!$this->form_validation->run()){
					$this->session->set_flashmessage('error',$this->form_validation->error_string());
					break;
				}
				$student_ids=$this->input->post('student_ids');
				if(empty($student_ids)){
					$this->session->set_flashmessage('error','Bạn phải chọn sinh viên để gửi tin nhắn !');
					break;
				}
				//Insert dữ liệu
				$data=array(
					'content'=>trim($this->input->post('sms_content')),
					'so_ky_tu'=>strlen(trim($this->input->post('sms_content'))),
					'topica_lop'=>$this->input->post('topica_lop')&&$this->input->post('topica_lop')!='1'?$this->input->post('topica_lop'):'',
					'course_id'=>$course->id,
					'quiz_id'=>$this->input->post('quiz_id')?$this->input->post('quiz_id'):0,
					'list_user_send'=>implode(',',$student_ids),
					'date_creat'=>getCurrentDateTime(),
					'list_user_error_mobie'=>''
				);

				$sms_info_id=$this->sms_info_m->insert($data);
				//log_message('error','sms_info_id:'.$sms_info_id);

				$sms_send_ids=array();
				$list_user_phone_error=array();
				foreach($student_ids as $student_id){
					if(!trim($student_phones[$student_id])){
						$list_user_phone_error[]=$student_id;
					}else{
						$sms_send_data=array(
							'sms_info_id'=>$sms_info_id,
							'user_id'=>$student_id,
							'topica_dienthoai'=>$student_phones[$student_id],
							'sms_status'=>'send',
							'reg_date'=>getCurrentDateTime()
						);
						//Insert vào bảng sms_send
						if($sms_send_id=$this->sms_send_m->insert($sms_send_data)){
							//log_message('error','sms_send_id:'.$sms_send_id);
							$sms_send_ids[]=$sms_send_id;
							//Insert vào bảng ozekimessageout
							$ozekimessageout_data=array(
								'receiver'=>$student_phones[$student_id],
								'msg'=>trim($this->input->post('sms_content')),
								'status'=>'send',
								'code'=>'TVU'.$sms_send_id
							);
							$this->ozekimessageout_m->insert($ozekimessageout_data);
							//log_message('error','ozekimessageout_id:'.$ozekimessageout_id);
						}
					}
				}


				$sms_info_data_update=array(
					'count_send'=>count($sms_send_ids),
					'count_error_mobile'=>count($list_user_phone_error),
					'list_user_error_mobie'=>!empty($list_user_phone_error)?implode(',',$list_user_phone_error):''
				);
				$this->sms_info_m->update_by(array('sms_info_id'=>$sms_info_id),$sms_info_data_update);


				if(!empty($sms_send_ids))
					$this->sms_info_m->update_by(array('sms_info_id'=>$sms_info_id),array('send_status'=>1));

				$this->session->set_flashdata('success','Tạo dữ liệu gửi tin thành công !');
				$this->session->set_flashdata('success','Tạo dữ liệu gửi tin thành công !');
				redirect('/lipe/sms/course/'.$course->id);

				break;
			}
		}

		$this->template
			->title('Gửi SMS: '.$course->shortname)
			->set('title','Gửi SMS: '.$course->shortname)
			->set('course',$course)
			->set('arr_lop',$arr_lop)
			->set('arr_nhom',$arr_nhom)
			->set('lop',$lop)
			->set('nhom',$nhom)
			->set('course',$course)
			->set('total_student_rows',$total_student_rows)
			->set('student_rows',$student_rows)
			->set('base_where',$base_where)
			->set('quiz_options',$quiz_options)
			->set('user_data',$user_data)
			->build('sms_form');
	}
}
