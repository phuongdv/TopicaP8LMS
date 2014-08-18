<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

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
	$this->load->library('table');
	$this->load->model('Users_model');
	$query=$this->Users_model->get_users($this->uri->segment(3));
	$week=$this->Users_model->get_week($this->uri->segment(3));
	$weekname=$week->result_array();
	
	foreach($weekname as $row)
    {
    	
   $week_data[]=$row['week_name']. '<br><div align="center">'.$row['start_date'].'  -  '.$row['end_date'].'</div>';
    }
	echo strtotime('2011-06-06');
	$title = array('','id', 'Ho', 'Ten', 'Username','Nhom','Lop');
    $list = array('one'=>'1 3 6 0','two'=>'one');
	$heding = array_merge($title,$week_data);	
    $this->table->set_heading($heding);
    print_r($query->result_array());
	foreach($query->result_array() as $row)
    {
  
  $this->table->add_row(array_merge($row,$list));
    }
 

  
    //echo $this->table->generate();
   $this->load->view('users');
        

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>