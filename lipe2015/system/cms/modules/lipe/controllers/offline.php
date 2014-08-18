<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Setting_offline
 * @author CaoPV <vancao.vn@gmail.com>
 */
class Offline extends Public_Controller
{
	protected $validation_rules = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('mdl_course_m','offline_m','mdl_user_m'));

		$this->base_url="/lipe/offline";
	}

	function index(){
		echo 'Điểm offline';
	}

	/**
	 * Điểm offline
	 * @param int $course_id
	 */
	function course($course_id=0){

		check_access($course_id);

		$course=$this->mdl_course_m->get($course_id);
		if(!$course){
			$this->session->set_flashdata('error','Khóa học không tồn tại !');
			redirect($this->base_url);
		}

		$data_insert=array();
		$ids_inserted=array();
		if($this->input->post('update')){
			check_access($course_id,true);
			while(true){
				if(!isset($_POST['arr_offline_id'])){
					$this->session->set_flashmessage('error','Không có dữ liệu !');
					break;
				}

				$arrOfflineId		= $_POST['arr_offline_id'];
				$arrOfflineNumber	= $_POST['arr_number'];
				$arrBtvn			= $_POST['arr_btvn'];
				$arrUserId			= $_POST['arr_user_id'];

				$ids_updated=array();
				foreach ($arrOfflineId as $key => $value) {
					$input=array(
						'number'		=> $arrOfflineNumber[$key],
						'btvn'			=> $arrBtvn[$key]
					);
					//Nếu đã có thì cập nhật
					if($value){
						if($this->offline_m->update_by(array('offline_id'=>$value),$input)){
							$ids_updated[]=$value;
						}
						//Nếu chưa có thì thêm mới
					}else{
						//Nếu có giá trị là số buổi hoặc điểm thì thêm mới
						if($arrOfflineNumber[$key]||$arrBtvn[$key]){
							$input['u_id']=$arrUserId[$key];
							$input['c_id']=$course->id;
							$data_insert[]=$input;
						}
					}
				}
				if(!empty($data_insert)){
					$ids_inserted=$this->offline_m->insert_many($data_insert);
				}

				if(!empty($ids_updated)||!empty($ids_inserted)){
					$this->session->set_flashdata('success','Cập nhật thành công : '.implode(',',$ids_updated).','.implode(',',$ids_inserted));
					$this->session->set_flashdata('success','Cập nhật thành công : '.implode(',',$ids_updated).','.implode(',',$ids_inserted));
					redirect(uri_string());
				}else{
					$this->session->set_flashmessage('error','Cập nhật thất bại !');
				}
				break;
			}
		}

		if(isset($_GET['start'])&&$_GET['start'])
			$start=$_GET['start'];
		else if(isset($_POST['start'])&&$_POST['start'])
			$start=$_POST['start'];
		else
			$start=0;

		$base_where=array(
			'start'			=>$start,
			'limit'			=>RECORDS_PER_PAGE,
			'topica_lop'	=>'',
			'topica_nhom'	=>'',
			'username'		=>'',
			'email'			=>'',
			'btvn'			=>'',
			'number'		=>''
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

		$params['mdl_course.id']=$course->id;
		$params['mdl_role_assignments.roleid']=5;

		$join=array(
			'mdl_role_assignments'=>array('on'=>'mdl_user.id=mdl_role_assignments.userid','type'=>'inner'),
			'mdl_context'=>array('on'=>'mdl_role_assignments.contextid=mdl_context.id','type'=>'inner'),
			'mdl_course'=>array('on'=>'mdl_course.id=mdl_context.instanceid','type'=>'inner'),
			'mdl_course_categories'=>array('on'=>'mdl_course.category=mdl_course_categories.id','type'=>'inner'),
			'offline'=>array('on'=>'mdl_user.id=offline.u_id and offline.c_id='.$course->id,'type'=>'left')
		);

		$total_rows=$this->mdl_user_m->count_many_where($params,$join,'distinct(mdl_user.id)');

		$pagination = create_ajax_pagination(uri_string(),$total_rows,$base_where['limit'],$base_where['start']);

		$params['limit']=$pagination['limit'];
		unset($params['start']);

		$rows=$this->mdl_user_m->get_many_where(
			$params,
			array('distinct(mdl_user.id)','offline.offline_id','offline.number','offline.u_id','offline.btvn','mdl_user.lastname','mdl_user.firstname','mdl_user.username','mdl_user.email',
			'mdl_user.topica_lop','mdl_user.topica_nhom'),
			$join,
			array('mdl_user.firstname'=>'asc')
		);

		//Lấy danh sách lớp và danh sách nhóm
		$arr_lop=array(''=>'==Tìm theo lớp==');
		$arr_nhom=array(''=>'==Tìm theo nhóm==');
		if($this->input->post()){
			$lop=$_POST['arr_lop'];
			$nhom=$_POST['arr_nhom'];
			$lop_array=explode('}||{',$lop);
			$nhom_array=explode('}||{',$nhom);
			if(!empty($lop_array)){
				$cnt=0;
				foreach($lop_array as $value){
					$cnt++;
					if($cnt>=2)
						$arr_lop[$value]=$value;
				}
			}
			if(!empty($nhom_array)){
				$cnt=0;
				foreach($nhom_array as $value){
					$cnt++;
					if($cnt>=2)
						$arr_nhom[$value]=$value;
				}
			}
		}else{
		
			/*
			//danglx comment 17-07-2014
			if(!empty($rows)){
				foreach($rows as $row){
					if(empty($arr_lop[$row->topica_lop]))
						$arr_lop[$row->topica_lop]=$row->topica_lop;
					if(empty($arr_nhom[$row->topica_nhom]))
						$arr_nhom[$row->topica_nhom]=$row->topica_nhom;
				}
			}
			
			*/
			//Begin danglx insert 17-07-2014
			$join_lop_nhom=array(
				'mdl_role_assignments'=>array('on'=>'mdl_user.id=mdl_role_assignments.userid','type'=>'inner'),
				'mdl_context'=>array('on'=>'mdl_role_assignments.contextid=mdl_context.id','type'=>'inner'),
				'mdl_course'=>array('on'=>'mdl_course.id=mdl_context.instanceid','type'=>'inner')
			   );
			   $lop_nhom=$this->mdl_user_m->get_many_where(
				array('mdl_course.id'=>$course->id,'mdl_role_assignments.roleid'=>5),
				array('mdl_user.topica_lop','mdl_user.topica_nhom'),
				$join_lop_nhom
			   );
			   if(!empty($lop_nhom)){
				foreach($lop_nhom as $row){
				 if(empty($arr_lop[trim($row->topica_lop)]))
				  $arr_lop[trim($row->topica_lop)]=$row->topica_lop;
				 if(empty($arr_nhom[trim($row->topica_nhom)]))
				  $arr_nhom[trim($row->topica_nhom)]=$row->topica_nhom;
				}
			   }
			
			//end danglx
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

		//Số buổi offline và điểm
		$arr_offline_number=array();
		$arr_diem_btvn=array();
		for($i=0;$i<=10;$i++){
			$arr_offline_number[$i]=$i;
			$arr_diem_btvn[$i]=$i;
		}

		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';

		$this->template
			->title('Quản lý điểm offline : '.$course->shortname)
			->set('title','Quản lý điểm offline : '.$course->shortname)
			->set('course',$course)
			->set('rows',$rows)
			->set('arr_lop',$arr_lop)
			->set('arr_nhom',$arr_nhom)
			->set('lop',$lop)
			->set('nhom',$nhom)
			->set('arr_offline_number',$arr_offline_number)
			->set('arr_diem_btvn',$arr_diem_btvn)
			->set('pagination',$pagination)
			->set('base_where',$base_where)
			->set('total_rows',$total_rows);

		$this->input->is_ajax_request()
			? $this->template->build('offline_table')
			: $this->template->build('offline_index');
	}

	/**
	 * @param int $offline_id
	 * @author caopv <vancao.vn@gmail.com>
	 */
	function updateInfo($user_id=0,$course_id=0){

		check_access($course_id,true);

		//@todo: Cần phân quyền
		$offline=$this->offline_m->get_by(array('u_id'=>$user_id,'c_id'=>$course_id)) or $this->output->set_output(0);
		if($this->input->post()){
			$data_post=array(
				'number'=>$this->input->post('offline_number'),
				'btvn'=>$this->input->post('offline_btvn')
			);
			if(empty($data_post))
				$this->output->set_output(0);
			if($offline){
				if($this->offline_m->update_by(array('offline_id'=>$offline->offline_id),$data_post)){
					$this->output->set_output(1);
				}else{
					$this->output->set_output(0);
				}
			}else{
				$data_post['u_id']=$user_id;
				$data_post['c_id']=$course_id;
				if($this->offline_m->insert($data_post)){
					$this->output->set_output(2);
				}else{
					$this->output->set_output(0);
				}
			}
		}
	}
}
