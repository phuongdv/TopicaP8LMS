<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Interaction
 * @author CaoPV <vancao.vn@gmail.com>
 */
class Interaction extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @author CaoPV
	 */
	function set_login(){

		if(!isset($_SESSION))
			session_start();

		$data_encrypt=isset($_COOKIE['lipe_data'])?$_COOKIE['lipe_data']:null;

		if(!$data_encrypt)
			exit('Empty data');

		$data_decrypt=decodeId($data_encrypt);

		$data_info=base64_decode($data_decrypt);

		$data_info=json_decode($data_info);

		if(empty($data_info))
			exit('Empty data');

		if($_SERVER['REMOTE_ADDR']!=$data_info->ip_address)
			exit('IP invalid');

		if(time()>$data_info->time_expire)
			exit('Time expired');

		$user_id=$data_info->user_id;

		if(!$user_id) exit('Khong ton tai ma tai khoan');

		$this->load->model(array('mdl_user_m','mdl_role_assignments_m','mdl_course_m'));
		$user=$this->mdl_user_m->get_where(array('id'=>$user_id),array('id','firstname','lastname','username')) or exit('User not found');
		$user_role=$this->mdl_role_assignments_m->get_where(array('userid'=>$user->id),array('roleid')) or exit('Role not found');
		$role_id=$user_role->roleid;

		$params=array(
			'mdl_user.id'=>$user->id
		);
		//Điều kiện Join giữa các bảng
		$join=array(
			'mdl_context'=>array('on'=>'mdl_context.instanceid=mdl_course.id','type'=>'inner'),
			'mdl_role_assignments'=>array('on'=>'mdl_role_assignments.contextid=mdl_context.id','type'=>'inner'),
			'mdl_user'=>array('on'=>'mdl_user.id=mdl_role_assignments.userid','type'=>'inner'),
			'mdl_course_categories'=>array('on'=>'mdl_course.category=mdl_course_categories.id','type'=>'inner')
		);
		$courses=$this->mdl_course_m->get_many_where(
			$params,
			array('DISTINCT(mdl_course.id)'),
			$join
		);

		$course_ids=array();
		if(!empty($courses)){
			foreach($courses as $course)
				$course_ids[]=intval($course->id);
		}

		$user_data=array(
			'user_id'		=>$user->id,
			'user_phone'	=>$user->topica_dienthoai,
			'user_role_id'	=>$role_id,
			'username'		=>$user->username,
			'fullname'		=>$user->lastname.' '.$user->firstname,
			'course_ids'	=>$course_ids
		);
//'user_phone'	=>$user->topica_dienthoai,
		$this->session->set_userdata('user_data',$user_data);
		if($role_id==5)
			redirect('/lipe/report_personal');
		else
			redirect('/lipe'); 
	}

	/**
	 * @author CaoPV
	 */
	function set_logout(){
		setcookie("user_id",false,-1,'/',$_SERVER['HTTP_HOST']);
		$this->session->set_userdata('user_data',null);
		exit('Logout success!');
	}
}
