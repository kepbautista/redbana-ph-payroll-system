<?php
class Super extends CI_Controller {

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
		
		
	function index() {
		/* changed | abe | 06may2011_0030 : changed this condition in if so that the login_model is called, as part of 'Object-oriented approach',
											rather than calling the session data directly
		*/							
		$this->load->model('login_model');
		
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			$data['userData'] = array(
						   'empNum' => $this->session->userData('empnum'),
						   'sname' => $this->session->userData('sname'), 
						   'fname' => $this->session->userData('fname'),
						   'mname' => $this->session->userData('mname')
			);
			$data['sql']=$this->login_model->permission($this->session->userData('userType'));
			$this->load->view('superuser_home', $data);					
		}
		else
			redirect('login');
			
			
	}//index()
		
}//class

			
			//Process the posted form			
?>