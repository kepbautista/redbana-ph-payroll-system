<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Philhealth extends CI_Controller{
	
		function __construct()
		{
			parent::__construct();	// to load controller constructor
			$this->load->helper('url');	// to load the url helper file
		}
			
		function GetAll()
		{
			$this->load->helper('form');	// to load the url helper file
			$this->load->model('Philhealth_model');	// to load a model
			$data['query'] = $this->Phihealth_model->Phihealth_getall();
			$data['trows'] = $this->Philhealth_model->Philhealth_numrows();
			$this->load->view('Philhealth_view',$data);	// to load a particular view file
		}
			
		function Edit()
		{
			$this->load->helper('form');	// to load the url helper file
			$this->load->model('Philhealth_model');	// to load a model
			$data['edit'] = $this->input->post('hidden');
			$data['query'] = $this->Philhealth_model->Philhealth_getall();
			$data['trows'] = $this->Philhealth_model->Philhealth_numrows();
			$this->load->view('philhealth_edit',$data);	// to load a particular view file
			$this->load->library('session');
			$this->load->database();	// to load the database and connect to MySQL
			$this->load->helper(array('form','url'));	// load the needed helpers
		}
			
			// display the posted entries
		function index()
		{
			if ($this->session->userdata('logged_in') != TRUE){
					redirect('login');
				}
					
				$data['title'] = 'Philhealth table';	// load the data from the database
				$data['result'] = $this->Philhealth_model->get_all_data();	// use the model to get all entries
				$this->load->view('Philhealth_view',$data);	// load 'forms_view' view
			}
			
		function Update()
		{
			$this->load->helper('form');	// to load the url helper file
			$this->laod->model('Philhealth_model');	// to load a model
			$this->Philhealth_model->Philhealth_update();
			$data['query'] = $this->Philhealth_model->Philhealth_getall();
			$data['trows'] = $this->Philhealth_model->Philhealth_numrows();
			$this->load->view('Philhealth_view',$data);	// to load a particular view file
		}	
}			
?>