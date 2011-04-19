<?php
	class Login extends CI_Controller {
		function __construct(){
		// load Controller constructor
			
			parent::__construct();
			// load the model we will be using
			$this->load->library('session');
			$this->load->model('login_model');
			$this->load->model('admin_model');
			// load the database and connect to MySQL
			$this->load->database();
			// load the needed helpers
			$this->load->helper(array('form','url'));	//laging form yung helper?
		}
		
		//Display the posted entries
		function index() {	$this->load->view('login_view');	}          
		
		//Process the posted form		
		function view_form(){		
				$this->load->library('form_validation');				
				$empnum = $this->input->post('empnum');
				//setup validation rules.		
				$this->form_validation->set_rules('empnum', 'empnum', 'required');
				$this->form_validation->set_rules('password', 'password', 'required');		
				if($this->form_validation->run() == FALSE){
				//has not been run or validation error.	
				$this->load->view('login_view');
				}else{
					$query = $this->login_model->validate();	
					if($query) $this->login($empnum); // if the user's credentials validated...
					else echo "wrong pas"; // incorrect username or password
				}			
			}
			//sessions
			function login($empnum){
			$data = array(
                   'empnum'  => $empnum,
                   'logged_in'  => TRUE
                );
				
			//check what type of user he/she is.
            $this->session->set_userdata($data);
			$check_super = $this->admin_model->validate_superuser($this->session->userdata('empnum'));
			$check_hr = $this->admin_model->validate_hr($this->session->userdata('empnum'));
			$check_accounting = $this->admin_model->validate_accounting($this->session->userdata('empnum'));
			$check_emp = $this->admin_model->validate_emp($this->session->userdata('empnum'));
			$check_supervisor = $this->admin_model->validate_supervisor($this->session->userdata('empnum'));
			if($check_super) $this->load->view('superuser_home');
			else if($check_hr) echo "hr to."; 
			else if($check_accounting) echo "accounting to."; 
			else if($check_emp) $this->load->view('employee_home');
			else if($check_supervisor) echo "supervisor to."; 
			}
			}
			
			function logout(){
			    $this->session->sess_destroy();
				redirect('login');
			}
?>