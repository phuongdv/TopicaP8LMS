<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author   CaoPV
 * @package  InfoBlock
 */
Class Admin extends Admin_Controller
{
	protected $validation_rules = array(
		array(
			'field' => 'name',
			'label' => 'Tên khối nội dung',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'position',
			'label' => 'Vị trí hiển thị',
			'rules' => 'trim|numeric'
		),
		array(
			'field' => 'content',
			'label' => 'Nội dung',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'active',
			'label' => 'Trạng thái',
			'rules' => 'numeric'
		)
	);

	protected $index_uri="/admin/static_info";

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('static_info_m'));
		$this->base_model=$this->static_info_m;
	}

	/**
	 * Show all created news category
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$base_where=array();
		//add post values to base_where if f_module is posted
		if($this->input->post()){
			$active=$this->input->post('f_active');
			if($active!=2)
				$base_where['active']=$active;
		}

		// Create pagination links
		$total_rows = $this->base_model->count_by($base_where);

		// Using this data, get the relevant results
		$rows = $this->base_model->get_many_where($base_where);

		//do we need to unset the layout because the request is ajax?
		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';

		//Nếu tồn tại giá trị post
		if($this->input->post('btn_update')) {
			//Lưu giữ liệu post theo dạng mảng
			$arrId              = $_POST['arr_id'];
			$arrName            = $_POST['arr_name'];
			$arrActive          = $_POST['arr_active'];

			foreach ($arrId as $key => $value) {
				 $id_update = $this->base_model->update($value,
					array(
						'name'          => trim($arrName[$key]),
						'active'        => $arrActive[$key]
					)
				);
			}

			if($id_update){
				$this->session->set_flashdata('success','Cập nhật thành công !');
				redirect($this->index_uri);
			}else{
				$this->session->set_flashmessage('error','Cập nhật thất bại !');
			}
		}


		$this->template
			->title('Khối nội dung tĩnh')
			->append_js('admin/my_filter.js')
			->set('total_rows',$total_rows)
			->set_partial('filters', 'admin/partials/filters')
			->set('title','Khối nội dung tĩnh')
			->set('index_uri',$this->index_uri)
			->set('rows',$rows);

		$this->input->is_ajax_request()
			? $this->template->build('admin/tables/tables')
			: $this->template->build('admin/index');
	}

	/**
	 * @author:CaoPV
	 * @return void
	 */
	public function add()
	{
		$this->form_validation->set_rules($this->validation_rules);
		if($this->input->post()){
			unset($_POST['btn']);
			if ($this->form_validation->run()){
				if($this->base_model->insert($_POST)){
					$this->session->set_flashdata('success','Thêm mới thành công !');
					redirect($this->index_uri);
				}else{
					 $this->session->set_flashmessage('error','Thất bại!');
				}
			}else{
			   // $this->session->set_flashmessage('error',$this->form_validation->error_string());
			}
		}
		$data=new stdClass();
		foreach ($this->validation_rules as $key => $field)
		{
			$data->$field['field'] = set_value($field['field']);
		}
		$this->template
			->title('Thêm mới khối nội dung tĩnh')
			->set('title','Thêm mới khối nội dung tĩnh')
			->set('btn_title','Thêm mới')
			->set('data',$data)
			->append_metadata($this->load->view('fragments/wysiwyg',$data, TRUE))
			->build('admin/form');
	}


   /**
   * @author:CaoPV
   * Cập nhật static info
   * @param mixed $id
   */
	public function edit($id = 0)
	{
		$this->form_validation->set_rules($this->validation_rules);
		$data=$this->base_model->get($id);
		if(!$data){
			 $this->session->set_flashdata('error','Không tồn tại !');
			 redirect($this->index_uri);
		}

		if($this->input->post()){
			unset($_POST['btn']);
			if ($this->form_validation->run()){
				if($this->base_model->update($data->id,$_POST)){
					$this->session->set_flashdata('success','Cập nhật thành công !');
					redirect(uri_string());
				}else{
					$this->session->set_flashmessage('error','Thất bại!');
				}
			 }
		}

		foreach ($this->validation_rules as $key => $field)
		{
			if (isset($_POST[$field['field']]))
			{
				$data->$field['field'] = set_value($field['field']);
			}
		}

		$this->template
			->title('Khối nội dung tĩnh : '.$data->name)
			->set('title','Khối nội dung tĩnh : '.$data->name)
			->set('btn_title','Cập nhật')
			->set('data', $data)
			->append_metadata($this->load->view('fragments/wysiwyg',$data,TRUE))
			->build('admin/form');
	}


	/**
	* Xóa
	* @param mixed $id
	*/
	public function delete($id = 0)
	{
		redirect($this->index_uri);
		if($this->base_model->delete($id)){
			$this->session->set_flashdata('sucess','Xóa thành công bản ghi mã '.$id);
			redirect($this->index_uri);
		}else{
			$this->session->set_flashdata('error','Thất bại !');
			redirect($this->index_uri);
		}
	}

}
