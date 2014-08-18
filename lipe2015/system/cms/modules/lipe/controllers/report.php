<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Report
 * @author CaoPV <vancao.vn@gmail.com>
 */
class Report extends Public_Controller
{
	protected $validation_rules = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('mdl_course_m','offline_m','mdl_user_m','huy_setting_calendar_m','vbb_post_m',
			'vietth_q169_attempts_m','huy_setting_lipe_m','tblanswer_m','lipe_course_mode_m'));

		$this->base_url="/lipe/report";
	}

	function index(){
		echo 'Xem báo cáo';
	}

	/**
	 * Báo cáo tổng hợp
	 * @param int $course_id
	 */
	function course($course_id=0){

		check_access($course_id);

		//Lấy thông tin khóa học
		$course=$this->mdl_course_m->get($course_id);
		if(!$course){
			$this->session->set_flashdata('error','Khóa học không tồn tại !');
			redirect($this->base_url);
		}
		$course_mode=$this->lipe_course_mode_m->get_by(array('course'=>$course->id));
		//Lấy thông tin tuần học
		$calendar_rows=$this->huy_setting_calendar_m->get_many_where(array('c_id'=>$course_id),null,null,array('end_date'=>'asc'));
		$calendar_number=count($calendar_rows);
		//Thời gian từ đầu tuần 1 cho đến kết thúc tuần cuối
		$min_max_date=$this->huy_setting_calendar_m->getMinMaxDateOfCourse($course_id);

		$min_date=$min_max_date->min_date;
		$time_stamp_min_date=date('Y-m-d',$min_date).' 00:00:00';
		$int_time_min_date=strtotime($time_stamp_min_date);

		$max_date=$min_max_date->max_date;
		$time_stamp_max_date=date('Y-m-d',$max_date).' 23:59:59';
		$int_time_max_date=strtotime($time_stamp_max_date);

		//Lấy thông tin các cài đặt LIPE
		$setting_lipes=$this->huy_setting_lipe_m->get_many_where(array('c_id'=>$course->id),
			array('id','c_id','style','active_id','lipe_type','calendar_id'));

		//$setting_lipes_P=$setting_lipes;
		//$setting_lipes_E=$setting_lipes;

		$setting_lipes_P=array();
		$setting_lipes_E=array();

		if(!empty($setting_lipes)){
			foreach($setting_lipes as $setting_lipe){
				if($setting_lipe->lipe_type=='P'){
					$setting_lipes_P[]=$setting_lipe;
				}
				if($setting_lipe->lipe_type=='E'){
					$setting_lipes_E[]=$setting_lipe;
				}
			}
		}

		$setting_lipes_P2=$setting_lipes_P;

		$p_active_ids=array();
		if(!empty($setting_lipes_P2)){
			foreach($setting_lipes_P2 as $slp){
				$p_active_ids[]=$slp->active_id;
			}
		}

		//Các điều kiện tìm kiếm
		$base_where=array(
			'topica_lop'	=>'',
			'topica_nhom'	=>'',
			'username'		=>'',
			'email'			=>'',
			'btvn'			=>'',
			'number'		=>''
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
		$arr_lop=array(''=>'==Tìm theo lớp==');
		$arr_nhom=array(''=>'==Tìm theo nhóm==');

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
					if($cnt==1) continue;
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

			//Điều kiện Join giữa các bảng
			$join=array(
				'mdl_role_assignments'=>array('on'=>'mdl_user.id=mdl_role_assignments.userid','type'=>'inner'),
				'mdl_context'=>array('on'=>'mdl_role_assignments.contextid=mdl_context.id','type'=>'inner'),
				'mdl_course'=>array('on'=>'mdl_course.id=mdl_context.instanceid','type'=>'inner'),
				//'mdl_course_categories'=>array('on'=>'mdl_course.category=mdl_course_categories.id','type'=>'inner'),
				'offline'=>array('on'=>'mdl_user.id=offline.u_id and offline.c_id='.$course->id,'type'=>'left'),
				'lipe_course_mode'=>array('on'=>'mdl_course.id=lipe_course_mode.course','type'=>'left')
			);

			//Tổng số sinh viên của khóa học
			$total_student_rows=$this->mdl_user_m->count_many_where($params,$join,'distinct(mdl_user.id)');

			//Danh sách sinh viên
			$student_rows=$this->mdl_user_m->get_many_where(
				$params,
				array('distinct(mdl_user.id)','mdl_user.lastname','mdl_user.firstname','mdl_user.username','mdl_user.email',
					'mdl_user.topica_lop','mdl_user.topica_nhom','mdl_user.topica_msv','mdl_user.topica_namsinh','offline.btvn as btvn_offline','offline.number as number_offline',
					'lipe_course_mode.mode as course_mode'
				),
				$join,
				array('mdl_user.firstname'=>'asc')
			);

			//Lấy danh sánh mảng mã,tên đăng nhập của sinh viên
			$username_students=array();
			$id_students=array();

			if(!empty($student_rows)){
				foreach($student_rows as $student){
					$id_students[]=$student->id;
					$username_students[]=$student->username;
				}
			}

			//Lấy danh sách bài đã đăng trong forum
			if(!empty($username_students)&&$this->input->post()){
				$vbb_params=array(
					'where_in'=>array('username'=>$username_students),
					'vbb_post.dateline>='=>$int_time_min_date,
					'vbb_post.dateline<='=>$int_time_max_date
				);
				$vbb_posts=$this->vbb_post_m->get_many_where($vbb_params,
					array('vbb_post.username','vbb_post.postid','vbb_thread.forumid','vbb_post.dateline'),
					array('vbb_thread'=>'vbb_post.threadid=vbb_thread.threadid')
				);

				$q169_attempt_P_params=array(
					'finishtime>='=>$time_stamp_min_date,
					'finishtime<='=>$time_stamp_max_date,
					'sumgrade>='=>5,
					'type'=>'bt72',
					'where_in'=>array('userid'=>$id_students)
				);

				$q169_attempts_p=$this->vietth_q169_attempts_m->get_many_where(
					$q169_attempt_P_params,
					array('id','quiz','userid','finishtime')
				);

				//Lấy điểm số trung bình E
				$q169_attempt_E_params=array(
					'finishtime>='=>$time_stamp_min_date,
					'finishtime<='=>$time_stamp_max_date,
					'deleted'=>0,
					'status'=>'submited',
					'type'=>'bt30',
					'where_in'=>array('userid'=>$id_students)
				);
				$q169_attempts_e=$this->vietth_q169_attempts_m->get_many_where(
					$q169_attempt_E_params,
					array('sumgrade','quiz','userid','finishtime')
				);

				//Danh sách câu trả lời
				$answer_params=array(
					'courseid'=>$course->id,
					'where_in'=>array('userid'=>$id_students),
					'time>='=>$int_time_min_date,
					'time<='=>$int_time_max_date
				);
				$answers=$this->tblanswer_m->get_many_where(
					$answer_params,
					array('id','userid','time')
				);

			}else{
				$vbb_posts=null;
				$q169_attempts_p=null;
				$q169_attempts_e=null;
				$answers=null;
			}
		}else{
			$vbb_posts=null;
			$q169_attempts_p=null;
			$q169_attempts_e=null;
			$answers=null;
			$total_student_rows=0;
			$student_rows=null;
		}

		//Xuất màn hình ra file excel
		if($this->input->post('export')){
			$arr=explode('.',$course->shortname);
			if(!empty($arr))
				$course_name=$arr[0];
			else
				$course_name=$course->id;

			$this->template
				->set('course',$course)
				->set('course_name',$course_name)
				->set('course_mode',$course_mode)
				->set('calendar_rows',$calendar_rows)
				->set('calendar_number',$calendar_number)
				->set('vbb_posts',$vbb_posts)
				->set('student_rows',$student_rows)
				->set('q169_attempts_p',$q169_attempts_p)
				->set('q169_attempts_e',$q169_attempts_e)
				->set('setting_lipes',$setting_lipes)
				->set('setting_lipes_P',$setting_lipes_P)
				->set('setting_lipes_P2',$setting_lipes_P2)
				->set('p_active_ids',$p_active_ids)
				->set('setting_lipes_E',$setting_lipes_E)
				->set('answers',$answers)
				->set('base_where',$base_where)
				->set('total_student_rows',$total_student_rows)
				->set_layout(false)
				->build('report_table_excel');
			
			header('Content-type: application/excel');
			if($this->input->post('topica_lop'))
				$filename = 'lipe_'.$course_name.'_'.$this->input->post('topica_lop').'_'.date('d_m_Y_H:i:s',time()).'.xls';
			else
				$filename = 'lipe_'.$course_name.'_'.date('d_m_Y_H:i:s',time()).'.xls';
			header('Content-Disposition:attachment;filename='.$filename);
			exit($this->output->get_output());
		}


		$this->template
			->title('F300 - Tổng hợp báo cáo điểm lớp môn: '.$course->shortname)
			->set('title','F300 - Tổng hợp báo cáo điểm lớp môn: '.$course->shortname)
			->set('course',$course)
			->set('course_mode',$course_mode)
			->set('arr_lop',$arr_lop)
			->set('arr_nhom',$arr_nhom)
			->set('lop',$lop)
			->set('nhom',$nhom)
			->set('calendar_rows',$calendar_rows)
			->set('calendar_number',$calendar_number)
			->set('base_where',$base_where)
			->set('vbb_posts',$vbb_posts)
			->set('student_rows',$student_rows)
			->set('q169_attempts_p',$q169_attempts_p)
			->set('q169_attempts_e',$q169_attempts_e)
			->set('setting_lipes',$setting_lipes)
			->set('setting_lipes_P',$setting_lipes_P)
			->set('setting_lipes_P2',$setting_lipes_P2)
			->set('p_active_ids',$p_active_ids)
			->set('setting_lipes_E',$setting_lipes_E)
			->set('answers',$answers)
			->set('total_student_rows',$total_student_rows)
			->build('report_index');
	}

	/**
	 * @param bool $is_popup
	 * Các bài đã post trên diễn đàn
	 * @author CaoPV
	 */
	function display_vbb_post($is_popup=false){
		$data=$this->input->get('data');
		if($data){
			$data=base64_decode($data);
			$vbbs=json_decode($data);
		}else{
			$vbbs=null;
		}

		if(!empty($vbbs)){
			$rows=$this->vbb_post_m->get_many_where(
				array('where_in'=>array('postid'=>$vbbs)),
				array('vbb_post.username','vbb_post.postid','vbb_thread.forumid','vbb_post.dateline','vbb_post.title','vbb_post.threadid'),
				array('vbb_thread'=>'vbb_post.threadid=vbb_thread.threadid')
			);
			//danglx
			$user_name=$rows[0]->username;
			//end danglx
		}else{
			$rows=null;
			$user_name=NULL;//danglx
		}

		$user=$this->mdl_user_m->get_where(array('username'=>$user_name),array('firstname','lastname','username'));
		$title='<h2>F301 - Tra cứu danh sách số bài post forum (I) </h2><h3>Sinh viên: '.$user->lastname.' '.$user->firstname.' ('.$user->username.')</h3>';

		$this->template
			->title(strip_tags($title))
			->set('title',$title)
			->set('rows',$rows)
			->set('user',$user)
			->set_layout($is_popup?false:'default')
			->build('popup_vbb_post_view');
	}

	/**
	 * @param bool $is_popup
	 * Hiển thị danh sách câu trả lời
	 */
	function display_answer_post($is_popup=false){
		$data=$this->input->get('data');
		if($data){
			$data=base64_decode($data);
			$ids=json_decode($data);
		}else{
			$ids=null;
		}

		if(!empty($ids)){
			$rows=$this->tblanswer_m->get_many_where(
				array('where_in'=>array('id'=>$ids)),
				array('answername','time','thread','userid')
			);
			$user_id=$rows[0]->userid;
		}else{
			$rows=null;
			$user_id=null;
		}

		$user=$this->mdl_user_m->get($user_id,array('firstname','lastname','username'));

		$title='<h2>F302 - Chi tiết các câu hỏi H2472 (H) </h2><h3>Sinh viên: '.$user->lastname.' '.$user->firstname.' ('.$user->username.')</h3>';
		
		$this->template
			->title(strip_tags($title))
			->set('title',$title)
			->set('rows',$rows)
			->set('user',$user)
			->set_layout($is_popup?false:'default')
			->build('popup_answer_post_view');
	}


	/**
	 * @param bool $is_popup
	 * Bài luyện tập trắc nghiệm
	 * @author CaoPV
	 */
	function display_practice($is_popup=false){
		$data=$this->input->get('data');
		if($data){
			$data=base64_decode($data);
			$p_data=json_decode($data);
			$start_date=$p_data->start_date;
			$end_date=$p_data->end_date;
		}else{
			$p_data=null;
		}

		if(!empty($p_data)){
			$time_stamp_min_date=date('Y-m-d',$start_date).' 00:00:00';
			$time_stamp_max_date=date('Y-m-d',$end_date).' 23:59:59';

			$rows=$this->vietth_q169_attempts_m->get_many_where(
				array(
					'userid'=>$p_data->user_id,
					'finishtime>='=>$time_stamp_min_date,
					'finishtime<='=>$time_stamp_max_date,
					'where_in'=>array('quiz'=>(array)$p_data->quiz),
					'sumgrade>='=>5,
					'type'=>'bt72'
				),
				array('mdl_quiz.id as quiz_id','mdl_quiz.name as quiz_name','vietth_q169_attempts.ma_de','vietth_q169_attempts.id as attempt',
					'vietth_q169_attempts.starttime','vietth_q169_attempts.finishtime','vietth_q169_attempts.sumgrade')
				,
				array('mdl_quiz'=>'vietth_q169_attempts.quiz=mdl_quiz.id')
			);

		}else{
			$rows=null;
		}

		$user=$this->mdl_user_m->get($p_data->user_id,array('firstname','lastname','username'));

		$title='<h2>F302- Danh sách số bài luyện tập trắc nghiệm (Practice) </h2><h3>Sinh viên: '.$user->lastname.' '.$user->firstname.' ('.$user->username.')</h3>';

		$this->template
			->title(strip_tags($title))
			->set('title',$title)
			->set('rows',$rows)
			->set('user',$user)
			->set_layout($is_popup?false:'default')
			->build('popup_practice_view');
	}



	/**
	 * @param bool $is_popup
	 * Bài tập về nhà
	 * @author CaoPV
	 */
	function display_exam($is_popup=false){
		$data=$this->input->get('data');
		if($data){
			$data=base64_decode($data);
			$e_data=json_decode($data);
		}else{
			$e_data=null;
		}

		if(!empty($e_data)){
			$rows=$this->vietth_q169_attempts_m->get_many_where(
				array(
					'userid'=>$e_data->user_id,
					'where_in'=>array('quiz'=>(array)$e_data->quiz),
					'deleted'=>0,
					'status'=>'submited',
					'type'=>'bt30'
				),
				array('mdl_quiz.id as quiz_id','mdl_quiz.name as quiz_name','vietth_q169_attempts.ma_de',
					'vietth_q169_attempts.id','vietth_q169_attempts.starttime','vietth_q169_attempts.finishtime','vietth_q169_attempts.sumgrade')
				,
				array('mdl_quiz'=>'vietth_q169_attempts.quiz=mdl_quiz.id')
			);

		}else{
			$rows=null;
		}

		$user=$this->mdl_user_m->get($e_data->user_id,array('firstname','lastname','username'));
		if($user)
			$fullname=$user->lastname.' '.$user->firstname;
		else
			$fullname=null;

		if($e_data->is_last_week){
			$prefix_title='F303B';
		}else{
			$prefix_title='F303A';
		}
		$title='<h2>'.$prefix_title.' - Số bài tập về nhà (Exam) : </h2><h3>Sinh viên : '.$fullname.' ('.$user->username.')<h3>';
		$this->template
			->title(strip_tags($title))
			->set('title',$title)
			->set('rows',$rows)
			->set('user',$user)
			->set('is_last_week',$e_data->is_last_week)
			->set('fullname',$fullname)
			->set_layout($is_popup?false:'default')
			->build('popup_exam_view');
	}
}
