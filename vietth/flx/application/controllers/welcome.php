<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	$this->load->helper('url');	
	$this->load->database();
	$this->load->library('pagination');
	$config['base_url'] = base_url().'index.php/welcome/index/';
	$config['total_rows'] = $this->db->count_all('mdl_course');
	$config['per_page'] = '50';
	$config['full_tag_open'] = '<p>';
	$config['full_tag_close'] = '</p>';
	$this->pagination->initialize($config);
	$this->load->model('Courses_model');
	$query=$this->Courses_model->get_courses($config['per_page'],$this->uri->segment(3));

		$this->load->library('table');
		$this->table->set_heading('id', 'fullname', 'shortname', 'timemodified','link');
	foreach($query->result_array() as $row)
    {
   $row['id']=anchor('user/index/'.$row['id'],$row['id']);
   $this->table->add_row($row);
    }

    //echo $this->table->generate();
    $this->load->view('welcome_message', $row);
        

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>