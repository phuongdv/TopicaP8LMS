<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Lipe
 * @author CaoPV <vancao.vn@gmail.com>
 */
class Lipe extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('mdl_course_m','huy_setting_calendar_m','huy_setting_lipe_m','lipe_course_mode_m'));
		$this->base_url="/lipe";
		$this->load->helper(array('language'));
		$this->lang->load('eng', 'english');
	}

	public function index()
	{
		check_access();

		if(isset($_GET['start'])&&$_GET['start'])
			$start=$_GET['start'];
		else if(isset($_POST['start'])&&$_POST['start'])
			$start=$_POST['start'];
		else
			$start=0;

		$base_where=array(
			'start'			=>$start,
			'limit'			=>RECORDS_PER_PAGE,
			'shortname'		=>'',
			'mode'			=>''
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

		$modes=array(
			0=> $this->lang->line('==Tất cả Mode=='),
			1=> $this->lang->line('1 - Lớp học có Offline'),
			2=> $this->lang->line('2 - Lớp học không có Offline, có diễn đàn'),
			3=> $this->lang->line('3 - Lớp học không có Offline, không có diễn đàn'),
		);

		$joins=array('lipe_course_mode'=>array('on'=>'mdl_course.id=lipe_course_mode.course','type'=>'left'));
		// Chỉ hiển thị các course có ngày bắt đầu >=2014-04-27 00:00:00
		$params['mdl_course.enrolstartdate>=']=strtotime('2014-04-27 00:00:00');
		$params['mdl_course.enrolstartdate<>']=0;
		
		$total_rows=$this->mdl_course_m->count_many_where($params,$joins);
		$pagination = create_ajax_pagination(uri_string(),$total_rows,$base_where['limit'],$base_where['start']);

		$params['limit']=$pagination['limit'];
		
		$rows = $this->mdl_course_m->get_many_where($params,array('mdl_course.id','shortname','lipe_course_mode.id as course_mode_id','lipe_course_mode.mode as mode_id'),
			$joins,array('mdl_course.id'=>'desc'));
		$check = "abc";
		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';
		
		//anh hoá view course_table
		$TKH = $this->lang->line ('Tên khoá học');
		$CDX = $this->lang->line ('Chế độ xem');
		$LH  = $this->lang->line ('Lịch học');
		$XBC = $this->lang->line ('Xem báo cáo');
		$SBO = $this->lang->line ('Số buổi offline');
		$DVS = $this->lang->line ('Dịch vụ SMS');
		

		$this->template
			->title('Lipe')
			->set('title',$this->lang->line('F100 - Quản lý lớp môn'))
			->set('total_rows',$total_rows)
			->set('pagination',$pagination)
			->set('base_where',$base_where)
			->set('modes',$modes)
			->set('rows',$rows)
			->set('TKH',$TKH)
			->set('CDX',$CDX)
			->set('LH',$LH)
			->set('XBC',$XBC)
			->set('SBO',$SBO)
			->set('DVS',$DVS);
			
		
			
		
		$this->input->is_ajax_request()
			? $this->template->build('course_table')
			: $this->template->build('course_index');
			
	
		
	}
}
