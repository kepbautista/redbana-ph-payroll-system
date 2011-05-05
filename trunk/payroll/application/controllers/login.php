<?php
	class Login extends CI_Controller {
	
		function __construct()
		{
			// load Controller constructor			
			parent::__construct();
			
			//$this->load->model('sniffBrowser_model');		//for browser-related issues use in the future
			
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
		function index() 
		{	
			/*
			*	changed | abe | 05may2011_2129: modified so that if a user is logged in, moved to some page (except home of course) then went to home again,
			*					he/she will not be asked to login again.
			*/
		
			if($this->login_model->isUser_LoggedIn())
			{				
				$this->redirect_To();
			}else
			{			
				$this->load->view('login_view');	
			}
			
		} //index         
		
		//Process the posted form		
		function view_form()
		{		
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
					
					if($query) 
						$this->login($empnum); // if the user's credentials validated...
					else 
						echo "wrong pas"; // incorrect username or password
				}			
			}
					
		/*
			suggestion | abe | 05may2011_2108: how about changing function name to 'login_Success'?			
			change | abe | 05may201_2115: moved set_userdata($data) to the end of the function
			change | same.. | instead of immediately redirecting upon checking of a user, iset muna sa session data kung anong type of data siya
								then call redirect_To(..)
		*/
		function login($empnum){
			
			$data = array(
				   'empnum'  => $empnum,
				   'logged_in'  => TRUE,
				   'userType' => NULL			// added | abe | 05may2011_2113pm: para sa pag-access kapag naka-login na at hindi kailangang bumalik sa login
				);
					
			//check what type of user he/she is.
			
			
			$check_super = $this->admin_model->validate_superuser( $empnum );
			$check_hr = $this->admin_model->validate_hr( $empnum );
			$check_accounting = $this->admin_model->validate_accounting( $empnum );
			$check_emp = $this->admin_model->validate_emp( $empnum );
			$check_supervisor = $this->admin_model->validate_supervisor( $empnum );
			
			if($check_super)
			{
				$data['userType'] = 'super';			
			}
			else if($check_hr)  				
			{
				$data['userType'] = 'hr';			
			}
			else if($check_accounting) 				
			{
				$data['userType'] = 'accounting';
			}
			else if($check_emp)				
			{
				$data['userType'] = 'employee';				
			}
			else if($check_supervisor) 				
			{
				$data['userType'] = 'supervisor';
			}
				
			$this->session->set_userdata($data);
			$this->redirect_To();
		}//login
		
		function redirect_To()
		{
			$userType = $this->session->userdata('userType');
					
			switch($userType)
			{
				case 'super': 
							redirect('super'); break;
				case 'hr':	
							redirect('hr'); break;
				case 'accounting':
							redirect('accounting'); break;
				case 'employee': 
							redirect('employee_home'); break;
				case 'supervisor':
							redirect('supervisor'); break;
				default:
							$this->load->view('login_view');			
							break;
			}//switch
		}//redirect_To
		
		function logout(){
			$this->session->sess_destroy();
			redirect('login');
		}
			
	}
?>