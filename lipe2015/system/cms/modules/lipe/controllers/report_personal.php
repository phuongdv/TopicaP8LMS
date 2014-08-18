<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Report_personal
 * @author CaoPV <vancao.vn@gmail.com>
 */
class Report_personal extends Public_Controller
{
	protected $validation_rules = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('mdl_course_m','offline_m','mdl_user_m','huy_setting_calendar_m','vbb_post_m',
			'vietth_q169_attempts_m','huy_setting_lipe_m','tblanswer_m','lipe_course_mode_m'));

		$this->base_url="/lipe/report";
	}

	/**
	 * @author CaoPV
	 */
	function index(){

		check_access();

		$user_data=$this->session->userdata('user_data');
		if(!$user_data)
			exit('Ban chua dang nhap');
		$student_id=$user_data['user_id'];

		$student=$this->mdl_user_m->get_where(array('id'=>$student_id),array('id','username','firstname','lastname','email',
			'topica_lop','topica_nhom','topica_namsinh'));
		if(!$student){
			exit('Student not found !');
		}
		// Chỉ cho hiển thị các course có ngày bắt đầu >=2014-04-27
		$params=array(
			'mdl_role_assignments.roleid'=>5,
			'mdl_user.id'=>$student_id,
			'where_not_like'=>array('mdl_course.fullname'=>'h2472'),
   			'mdl_course.enrolstartdate>='=>strtotime('2014-04-27 00:00:00')
		);
		/*
		$params=array(
			'mdl_role_assignments.roleid'=>5,
			'mdl_user.id'=>$student_id,
			'where_not_like'=>array('mdl_course.fullname'=>'h2472')
		);
		*/
		//Điều kiện Join giữa các bảng
		$join=array(
			'mdl_context'=>array('on'=>'mdl_context.instanceid=mdl_course.id','type'=>'inner'),
			'mdl_role_assignments'=>array('on'=>'mdl_role_assignments.contextid=mdl_context.id','type'=>'inner'),
			'mdl_user'=>array('on'=>'mdl_user.id=mdl_role_assignments.userid','type'=>'inner'),
			'mdl_course_categories'=>array('on'=>'mdl_course.category=mdl_course_categories.id','type'=>'inner'),
			'offline'=>array('on'=>'mdl_user.id=offline.u_id and offline.c_id=mdl_course.id','type'=>'left'),
			'lipe_course_mode'=>array('on'=>'mdl_course.id=lipe_course_mode.course','type'=>'left')
		);

		$courses=$this->mdl_course_m->get_many_where(
			$params,
			array('DISTINCT(mdl_course.id)','mdl_course.shortname','offline.btvn as btvn_offline','offline.number as number_offline','lipe_course_mode.mode as course_mode'),
			$join
		);

		$calendar_rows=array();
		$setting_lipes=array();
		$setting_lipes_P=array();
		// Chỉ cho hiển thị các course có ngày bắt đầu >=2014-04-27
		$setting_lipes_P2=null;
		$setting_lipes_E=array();
		$p_active_ids=array();
		$vbb_posts=array();
		$q169_attempts_p=array();
		$q169_attempts_e=array();
		$answers=array();

		if(!empty($courses)){
			foreach($courses as $course){
				$calendar_rows[$course->id]=$this->huy_setting_calendar_m->get_many_where(array('c_id'=>$course->id),null,null,array('end_date'=>'asc'));


				//Thời gian từ đầu tuần 1 cho đến kết thúc tuần cuối
				$min_max_date=$this->huy_setting_calendar_m->getMinMaxDateOfCourse($course->id);

				$min_date=$min_max_date->min_date;
				$time_stamp_min_date=date('Y-m-d',$min_date).' 00:00:00';
				$int_time_min_date=strtotime($time_stamp_min_date);

				$max_date=$min_max_date->max_date;
				$time_stamp_max_date=date('Y-m-d',$max_date).' 23:59:59';
				$int_time_max_date=strtotime($time_stamp_max_date);

				//Lấy thông tin các cài đặt LIPE
				$setting_lipes[$course->id]=$this->huy_setting_lipe_m->get_many_where(array('c_id'=>$course->id),
					array('id','c_id','style','active_id','lipe_type','calendar_id'));


				if(!empty($setting_lipes[$course->id])){
					foreach($setting_lipes[$course->id] as $setting_lipe){
						if($setting_lipe->lipe_type=='P'){
							$setting_lipes_P[$course->id][]=$setting_lipe;
						}
						if($setting_lipe->lipe_type=='E'){
							$setting_lipes_E[$course->id][]=$setting_lipe;
						}
					}
				}

				$setting_lipes_P2=$setting_lipes_P;

				if(!empty($setting_lipes_P2[$course->id])){
					foreach($setting_lipes_P2[$course->id] as $slp){
						$p_active_ids[$course->id][]=$slp->active_id;
					}
				}

				$vbb_params=array(
					'username'=>$student->username,
					'vbb_post.dateline>='=>$int_time_min_date,
					'vbb_post.dateline<='=>$int_time_max_date
				);

				$vbb_posts[$course->id]=$this->vbb_post_m->get_many_where($vbb_params,
					array('vbb_post.username','vbb_post.postid','vbb_thread.forumid','vbb_post.dateline'),
					array('vbb_thread'=>'vbb_post.threadid=vbb_thread.threadid')
				);

				$q169_attempt_P_params=array(
					'userid'=>$student->id,
					'finishtime>='=>$time_stamp_min_date,
					'finishtime<='=>$time_stamp_max_date,
					'sumgrade>='=>5,
					'type'=>'bt72'
				);

				$q169_attempts_p[$course->id]=$this->vietth_q169_attempts_m->get_many_where(
					$q169_attempt_P_params,
					array('id','quiz','userid','finishtime')
				);

				//Lấy điểm số trung bình E
				$q169_attempt_E_params=array(
					'userid'=>$student->id,
					'finishtime>='=>$time_stamp_min_date,
					'finishtime<='=>$time_stamp_max_date,
					'deleted'=>0,
					'status'=>'submited',
					'type'=>'bt30'
				);
				$q169_attempts_e[$course->id]=$this->vietth_q169_attempts_m->get_many_where(
					$q169_attempt_E_params,
					array('sumgrade','quiz','userid','finishtime')
				);

				//Danh sách câu trả lời
				$answer_params=array(
					'courseid'=>$course->id,
					'userid'=>$student->id,
					'time>='=>$int_time_min_date,
					'time<='=>$int_time_max_date
				);
				$answers[$course->id]=$this->tblanswer_m->get_many_where(
					$answer_params,
					array('id','userid','time')
				);

			}
		}

		$this->template
			->title('Sinh viên: '.$student->lastname.' '.$student->firstname.' - Lớp: '.$student->topica_lop)
			->set('title','Sinh viên: '.$student->lastname.' '.$student->firstname.' - Lớp: '.$student->topica_lop)
			->set('courses',$courses)
			->set('student',$student)
			->set('calendar_rows',$calendar_rows)
			->set('vbb_posts',$vbb_posts)
			->set('q169_attempts_p',$q169_attempts_p)
			->set('q169_attempts_e',$q169_attempts_e)
			->set('setting_lipes',$setting_lipes)
			->set('setting_lipes_P',$setting_lipes_P)
			->set('setting_lipes_P2',$setting_lipes_P2)
			->set('p_active_ids',$p_active_ids)
			->set('setting_lipes_E',$setting_lipes_E)
			->set('answers',$answers)
			->build('personal_report_index');
	}
}
