<?php
	class Philhealth extends CI_Controller {
	
		function __construct(){
		// load Controller constructor
			parent::__construct();
			// load the model we will be using
			$this->load->model('philhealth_model');
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
				$data['title']='Philhealth table';
				
				//use the model to get all entries
				
				$data['result'] = $this->philhealth_model->get_all_data();
				// load 'forms_view' view
				$this->load->view('philhealth_view',$data);
			
			}
	}
?>