<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Sss extends CI_Controller{

		function __construct()
		{
			parent::__construct();	// to load controller constructor
			$this->load->helper('url');	// to load the url helper file
		}
		
		function GetAll()
		{
			$this->load->helper('form');	// to load the url helper file  
			$this->load->model('Sss_model');	// to load a model
			$data['query'] = $this->Sss_model->Sss_getall();
			$data['trows'] = $this->Sss_model->Sss_numrows();
			$this->load->view('Sss_view',$data);	// to load a particular view file
		}	
	
		function Edit()
		{
			$this->load->helper('form');  
			$this->load->model('Sss_model');
			$data['edit'] = $this->input->post('hidden');
			$data['query'] = $this->Sss_model->Sss_getall();
			$data['trows'] = $this->Sss_model->Sss_numrows();
			$this->load->view('sss_edit',$data);
			$this->load->library('session');
			
			// load the database and connect to MySQL
			$this->load->database();
			// load the needed helpers
			$this->load->helper(array('form','url'));
		}

			// display the posted entries
		/*function index()
		{
			if ($this->session->userdata('logged_in') != TRUE){
				redirect('login');
			}
			
			$data['title']='Sss table';	// load the data from the database
			$data['result'] = $this->Sss_model->get_all_data();	// use the model to get all entries
			$this->load->view('Sss_view',$data);	// load 'forms_view' view
		}*/
		
		function Update()
		{
			$this->load->helper('form');	// to load the url helper file  
			$this->load->model('Sss_model');	// to load a model
			$this->Sss_model->Sss_update();
			//($this->input->post('hidden'),$this->input->post('rangel'),$this->input->post('rangeh'),$this->input->post('msc'),$this->input->post('ser'),$this->input->post('stotal'),$this->input->post('ecer'),$this->input->post('ter'),$this->input->post('tee'),$this->input->post('ttotal'),$this->input->post('totalcont'));
			$data['query'] = $this->Sss_model->Sss_getall();
			$data['trows'] = $this->Sss_model->Sss_numrows();
			$this->load->view('Sss_view',$data);	// to load a particular view file
		}	
}
?>