<?php
class Leave extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('session');
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
			$this->load->view('superuser_home_x', $data);					
		}
		else
			redirect('login');
			
			
	}

	function validateForm($type){
		//load form validation library
		$this->load->library('form_validation');
	
		//form validation rules for employee information
		if($type=="insert") $this->form_validation->set_rules('empnum','Employee Number',	'required|callback_script_input');

	}//function for validating forms
	
	function Insert()//function for viewing the inserting employee page
	{	
		$this->load->helper('form');  
		$this->load->model('Leave_model');
		$data['months'] = $this->Leave_model->buildMonthDropdown(); 
		$data['days'] = range(1,31);
		$data['years'] = range(1990,2020); 
		$data['type_options'] = array(
                 'vacation' => 'Vacation',
				 'sick' => 'Sick',
				 'emergency' => 'Emergency',
				 'bereavement' => 'Bereavement',
				 'maternity' => 'Maternity',
				 'paternity' => 'Paternity',
				 'leave without pay' => 'Leave Without Pay'
                );
		$this->validateForm("insert");//call function for validating forms
	
		if ($this->form_validation->run() == FALSE)
			$this->load->view('leave_view',$data);
			//validation errors are present
		else $this->InsertDb();//insert data
	}
	
	function Accepted()
	{
		$this->load->helper('form');  
		$this->load->model('Leave_model');
		$this->Leave_model->Leave_approved();
		$data['query']=$this->Leave_model->Leave_getinfo();
		$this->load->view('Leave_all',$data);
	}
	
	function Empview()
	{
		$this->load->helper('form');  
		$this->load->model('Leave_model');
		$data['query']=$this->Leave_model->Empview();
		$this->load->view('Leave_empviewall',$data);
	}
	
	function Not_approved()
	{
		$this->load->helper('form');  
		$this->load->model('Leave_model');
		$this->Leave_model->Leave_notapproved();
		$data['query']=$this->Leave_model->Leave_getinfo();
		$this->load->view('Leave_all',$data);
	}
	
	function Approve()//function for viewing the editing an employee page 
	{	
		if(!isset($_POST['editEmp']))
		{
			//get all information from the previous viewing of Emp_edit form
			$data['empnum'] = $_POST['empnum'];//employee number
			$data['type'] = $_POST['type'];//first name
			$data['reason'] = $_POST['reason'];//middle name
			$data['approval'] = $_POST['approval'];//last name
			
			//file date
			$data['fyear'] = $_POST['fyear'];
			$data['fmonth'] = $_POST['fmonth'];
			$data['fday'] = $_POST['fday'];
						
			//starting date
			$data['syear'] = $_POST['syear'];
			$data['smonth'] = $_POST['smonth'];
			$data['sday'] = $_POST['sday'];
			
			//birthdate
			$data['ryear'] = $_POST['ryear'];
			$data['rmonth'] = $_POST['rmonth'];
			$data['rday'] = $_POST['rday'];
			
			$this->load->helper('form');
			$this->load->model('Leave_model');
		}
		else{
			$this->load->helper('form');
			$this->load->model('Leave_model');
			$data['query']=$this->Leave_model->Leave_edit();
			}
		
		$data['months'] = $this->Leave_model->buildMonthDropdown(); 
		$data['days'] = range(1,31);
		$data['years'] = range(1990,2020); 
		$data['type_options'] = array(
                 'vacation' => 'Vacation',
				 'sick' => 'Sick',
				 'emergency' => 'Emergency',
				 'bereavement' => 'Bereavement',
				 'maternity' => 'Maternity',
				 'paternity' => 'Paternity',
				 'leave without pay' => 'Leave Without Pay'
                );
		$this->validateForm("update");//call function for form validation
		
		if ($this->form_validation->run() == FALSE)
			$this->load->view('Leave_approve',$data);
			//validation errors are present
		else $this->Update();//update information
		
	}
	
	function Delete()//deletes an employee
	{
		$this->load->helper('form');  
		$this->load->model('Leave_model');
		$this->Leave_model->Leave_delete();
		$data['query']=$this->Leave_model->Leave_getall();
		$this->load->view('Leave_all',$data);
	}
	
	
	function Update()//update an employee info
	{
		$this->load->helper('form');  
		$this->load->model('Leave_model');
		$this->Leave_model->Leave_update();
		$data['query']=$this->Leave_model->Leave_getall();
		$this->load->view('leave_viewall',$data);
	}
	
	function GetAll()//Getting all info of employee and 
	{
		$this->load->helper('form');  
		$this->load->model('Leave_model');
		$data['query']=$this->Leave_model->Leave_getall();
		$this->load->view('leave_viewall',$data);
	}

	function InsertDb()//insert an employee info to the database then redirect for viewing all employee page
	{
		$this->load->helper('form');  
		$this->load->model('Leave_model');
		$this->Leave_model->Leave_insert();
		$this->load->view('leave_success');
	}
	
	function Viewall()//insert an employee info to the database then redirect for viewing all employee page
	{
		$this->load->helper('form');  
		$this->load->model('Leave_model');
		$data['query']=$this->Leave_model->Leave_getinfo();
		$this->load->view('leave_all', $data);
	}
	
	function script_input($str){
		$response = TRUE;
	
		//user entered a script as input
		if((stripos($str,"script") !== false)){
			if((stripos($str,"<") !== false) && (stripos($str,">") !== false)){
				$this->form_validation->set_message('script_input', 'Invalid &ltscript&gt&lt/script&gt input for %s');
				$response = FALSE;
			}
		}	
		return $response;
	}//check if user entered a script as input
	
	function redirect_success(){
	$this->load->view('leave_success');
	}
	
	/**SQL INJECTIONS!**/
	//HR
}
?>