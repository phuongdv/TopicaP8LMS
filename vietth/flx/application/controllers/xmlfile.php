<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xmlfile extends CI_Controller {

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
	function write_xml() {
    // Load XML writer library
    $this->load->library('myxml');
    
    // Initiate class
    $xml = new Myxml;
    $xml->setRootName('my_store');
    $xml->initiate();
    
    // Start branch 1
    $xml->startBranch('cars');
    
    // Set branch 1-1 and its nodes
    $xml->startBranch('car', array('country' => 'usa')); // start branch 1-1
    $xml->addNode('make', 'Ford');
    $xml->addNode('model', 'T-Ford', array(), true);
    $xml->endBranch();
    
    // Set branch 1-2 and its nodes
    $xml->startBranch('car', array('country' => 'Japan')); // start branch
    $xml->addNode('make', 'Toyota');
    $xml->addNode('model', 'Corolla', array(), true);
    $xml->endBranch();
    
    // End branch 1
    $xml->endBranch();
    
    // Start branch 2
    $xml->startBranch('bikes'); // start branch
    
    // Set branch 2-1  and its nodes
    $xml->startBranch('bike', array('country' => 'usa')); // start branch
    $xml->addNode('make', 'Harley-Davidson');
    $xml->addNode('model', 'Soft tail', array(), true);
    $xml->endBranch();
    
    // End branch 2
    $xml->endBranch();
    
    // Print the XML to screen
    $xml->getXml(true);
}  
   write_xml();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */