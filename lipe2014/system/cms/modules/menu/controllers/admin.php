<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		CaoPV
 * @package 	Menu
 */
class Admin extends Admin_Controller
{   
	protected $validation_rules = array(
		array(
			'field' => 'name',
			'label' => 'Tiêu đề',
			'rules' => 'trim|required|max_length[255]'
		),
		array(
			'field' => 'order_number',
			'label' => 'Thứ tự hiển thị',
			'rules' => 'trim|numeric'
		),
		array(
			'field' => 'link',
			'label' => 'Đường link',
			'rules' => 'trim|max_length[500]'
		),
		array(
			'field' => 'active',
			'label' => 'Trạng thái',
			'rules' => 'numeric'
		)
	);

	protected $index_uri="/admin/menu";
	/**
	 * The constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('menus_m');
		$this->base_model=$this->menus_m;
	}


	public function add(){
		$data=new stdClass();
		$this->form_validation->set_rules($this->validation_rules);
		if($this->input->post()){
			unset($_POST['btn']);
			if(!$_POST['order_number'])
				$_POST['order_number']=$this->base_model->maxOrderNumber()+1;
			if ($this->form_validation->run()){
				if($this->base_model->insert($_POST)){
					$this->session->set_flashdata('success','Thêm mới thành công !');
					redirect($this->index_uri);
				}else{
					 $this->session->set_flashmessage('error','Thất bại !');
				}
			}else{
				 //$this->session->set_flashmessage('error',$this->form_validation->error_string());
			}
		}

		foreach ($this->validation_rules as $key => $field)
		{
			$data->$field['field'] = set_value($field['field']);
		}
		$data->id=0;
		$data->sort_order=$this->base_model->maxOrderNumber()+1;
		$this->template
			->title('Thêm mới menu')
			->set('title','Thêm mới menu')
			->set('btn_title','Thêm mới')
			->set('data',$data)
			->build('form');

	}


	public function index()
	{                  
		$base_where = array();  

		$total_rows = $this->base_model->count_by($base_where); 

		$rows = $this->base_model->get_many_where($base_where);
		//do we need to unset the layout because the request is ajax?
		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';

		//Nếu tồn tại giá trị post
		if($this->input->post()) {
			//Lưu giữ liệu post theo dạng mảng
			$arrId              = $_POST['arr_id'];
			$arrName            = $_POST['arr_name'];
			$arrLink            = $_POST['arr_link'];
			$arrOrderNumber     = $_POST['arr_order_number'];
			$arrActive          = $_POST['arr_active'];
			foreach ($arrId as $key => $value) {
				 $id_update = $this->base_model->update($value,
					array(
						'name'          => $arrName[$key],
						'link'          => $arrLink[$key],
						'order_number'  => $arrOrderNumber[$key],
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
			->title('Menu')
			->set('rows', $rows)
			->set('total_rows', $total_rows)
			->set('index_uri',$this->index_uri)
			->build('index');
	}


	/**
   * @author:CaoPV
   * Cập nhật thông tin menu
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
					redirect($this->index_uri);
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
			->title('Thông tin menu : '.$data->name)
			->set('title','Thông tin menu : '.$data->name)
			->set('btn_title','Cập nhật')
			->set('data', $data)
			->build('form',$data);
	}

	public function delete($id = 0)
	{
		if($this->base_model->delete($id)){
			$this->session->set_flashdata('sucess','Xóa thành công bản ghi mã '.$id);
			redirect($this->index_uri);
		}else{
			$this->session->set_flashmessage('error','Thất bại !');
		}
	}   
}
