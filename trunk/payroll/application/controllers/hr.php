<?php
	class Hr extends CI_Controller {
	
		function __construct(){
		// load Controller constructor
			parent::__construct();
			// load the model we will be using
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
			else $this->load->view('hr_home');	
					
			}
			
			}

			
			//Process the posted form
			
?>