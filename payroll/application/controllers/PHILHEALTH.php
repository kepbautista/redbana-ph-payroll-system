<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Philhealth extends CI_Controller {

	function __construct()
	{
		parent::__construct();	// to load controller constructor
		$this->load->helper('url');	// to load the url helper file
		$this->load->library('table');	// to invoke the the class name
	}
			
	function GetAll()
	{
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Philhealth_model');	// to load a model
		$data['query'] = $this->Philhealth_model->Philhealth_getall();
		$data['trows'] = $this->Philhealth_model->Philhealth_numrows();
		$this->load->view('philhealth_view',$data);	// to load a particular view file
	}
			
	function Edit()
	{
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Philhealth_model');	// to load a model
		$data['edit'] = $this->input->post('hidden');
		$data['query'] = $this->Philhealth_model->Philhealth_getall();
		$data['trows'] = $this->Philhealth_model->Philhealth_numrows();
		$this->load->view('philhealth_edit',$data);	// to load a particular view file
		$this->load->library('session');	// to invoke the the class name
		$this->load->database();	// to load the database and connect to MySQL
		$this->load->library('table');	// to invoke the the class name
		$this->load->helper(array('form','url'));	// load the needed helpers
	}
				
	function Update()
	{
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Philhealth_model');	// to load a model
		$this->Philhealth_model->Philhealth_update();
		$data['query'] = $this->Philhealth_model->Philhealth_getall();
		$data['trows'] = $this->Philhealth_model->Philhealth_numrows();
		$this->load->view('philhealth_view',$data);	// to load a particular view file
	}	
}			
?>