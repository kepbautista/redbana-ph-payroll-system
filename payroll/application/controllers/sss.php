<?php
	class Sss extends CI_Controller {
	
		function __construct(){
		// load Controller constructor
			parent::__construct();
			// load the model we will be using
			$this->load->model('sss_model');
			$this->load->library('session');
			
			// load the database and connect to MySQL
			$this->load->database();
			// load the needed helpers
			$this->load->helper(array('form','url'));
			}
			
			//Display the posted entries
			function index() {
			if ($this->session->userdata('logged_in') != TRUE)
				{
					redirect('login');
				}		
				//LOAD DATA FROM DATABASE	
				$data['title']='User List';
				
				//use the model to get all entries
				
				$data['result'] = $this->sss_model->get_all_data();
				// load 'forms_view' view
				$this->load->view('sss_view',$data);
			
			}
	}
?>