<?php
class Employee extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('session');	
		$this->load->library('form_validation');//load form validation library
		$this->load->helper('form');
		$this->load->model('Employee_model');
		$this->load->model('login_model');
	}
	function validateForm($type){		
		//form validation rules for employee information
		if($type=="insert") $this->form_validation->set_rules('empnum','Employee Number',	'required|callback_script_input|callback_duplicate_empnum');
		$this->form_validation->set_rules('fname','First Name','required|callback_script_input');
		$this->form_validation->set_rules('mname','Middle Name','required|callback_script_input');
		$this->form_validation->set_rules('sname','Last Name','required|callback_script_input');
		$this->form_validation->set_rules('mrate','Monthly Rate','required|numeric|greater_than[0]');
		$this->form_validation->set_rules('password','Password','required|callback_script_input|min_length[10]');
		$this->form_validation->set_rules('hphone','Home Phone Number','callback_script_input');
		$this->form_validation->set_rules('mphone','Mobile Phone Number','callback_script_input');
		$this->form_validation->set_rules('email','E-mail Address','valid_email|callback_script_input');
		$this->form_validation->set_rules('address','Present Address','callback_script_input');
		$this->form_validation->set_rules('zip','Zip Code','callback_script_input');
		$this->form_validation->set_rules('sss','SSS Number','required|callback_script_input');
		$this->form_validation->set_rules('tin','TIN Number','required|callback_script_input');
		$this->form_validation->set_rules('pagibig','Pag-Ibig Number','required|callback_script_input');
		$this->form_validation->set_rules('phil','Philhealth Number','required|callback_script_input');
		
	}//function for validating forms
	
	function Insert()//function for viewing the inserting employee page
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("addemp"))
			{
				$data['months'] = $this->Employee_model->buildMonthDropdown(); 
				$data['days'] = range(1,31);
				$data['years'] = range(1990,2020); 
				$data['title'] =  array(
		                  'Mr.'  => 'Mr.',
		                  'Ms.'    => 'Ms.',
						  'Mrs.'    => 'Mrs.'
		                );
				$data['pmode'] = $this->Employee_model->getPmode(); 
				$data['pos_options'] = $this->Employee_model->get_pos();
				$data['shift_id'] = $this->Employee_model->get_shift();
				$data['civil_status'] = array(
		                  'Single'  => 'Single',
		                  'Married'    => 'Married'
						);
				$data['emp_status'] = array(
		                  'Active'  => 'Active',
		                  'On-Leave'    => 'On-Leave',
						  'Terminated'    => 'Terminated',
						  'Resigned'    => 'Resigned'
						);
				$data['dept_options'] = $this->Employee_model->get_dept();
				$data['tax_options'] = $this->Employee_model->get_tax();
				$data['type_options'] = $this->Employee_model->get_type();
				$data['user_right'] = $this->Employee_model->get_user_right();
				$this->validateForm("insert");//call function for validating forms
			
				if ($this->form_validation->run() == FALSE)
					$this->load->view('Emp_view',$data);
					//validation errors are present
				else $this->InsertDb();//insert data
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	function Edit()//function for viewing the editing an employee page 
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("editemp"))
			{
				if(!isset($_POST['editEmp']))
				{
				//get all information from the previous viewing of Emp_edit form
					$data['empnum'] = $_POST['empnum'];//employee number
					$data['fname'] = $_POST['fname'];//first name
					$data['mname'] = $_POST['mname'];//middle name
					$data['sname'] = $_POST['sname'];//last name
					$data['title1'] = $_POST['title'];//title
					$data['mrate'] = $_POST['mrate'];//monthly rate
					$data['position'] = $_POST['position'];//position
					$data['dept'] = $_POST['dept'];//department
					$data['gender'] = $_POST['gender'];//gender
					$data['emp_status1'] = $_POST['emp_status'];//employee status
					$data['cstatus'] = $_POST['cstatus'];//civil status
					$data['user'] = $_POST['user_right'];//user right or type of user
					$data['sss'] = $_POST['sss'];//SSS number
					$data['phil'] = $_POST['phil'];//Philhealth number
					$data['tin'] = $_POST['tin'];//TIN number
					$data['mphone'] = $_POST['mphone'];//Mobile Phone number
					$data['hphone'] = $_POST['hphone'];//Home Phone number
					$data['email'] = $_POST['email'];//e-mail address
					$data['address'] = $_POST['address'];//present address
					$data['emp_type1'] = $_POST['emp_type'];//employee type
					$data['zip'] = $_POST['zip'];//zip code
					$data['shift'] = $_POST['shift_id'];//zip code
					$data['tax'] = $_POST['tax_status'];//tax status
					$data['pagibig'] = $_POST['pagibig'];//Pag-Ibig Number
					$data['pmode1'] = $_POST['pmode'];//payment mode
					$data['password'] = $_POST['password'];//password
					
					//starting date
					$data['syear'] = $_POST['syear'];
					$data['smonth'] = $_POST['smonth'];
					$data['sday'] = $_POST['sday'];
					
					//birthdate
					$data['byear'] = $_POST['byear'];
					$data['bmonth'] = $_POST['bmonth'];
					$data['bday'] = $_POST['bday'];			
				}
				else
					$data['query']=$this->Employee_model->Employee_edit();
					//Edit Employee Form is executed for the 1st time
				
				$data['months'] = $this->Employee_model->buildMonthDropdown(); 
				$data['days'] = range(1,31);
				$data['years'] = range(1990,2020); 
				$data['title'] =  array(
		                  'Mr.'  => 'Mr.',
		                  'Ms.'    => 'Ms.',
						  'Mrs.'    => 'Mrs.'
		                );
				$data['pmode'] = $this->Employee_model->getPmode(); 
				$data['pos_options'] = $this->Employee_model->get_pos();
				$data['civil_status'] = array(
		                  'Single'  => 'Single',
		                  'Married'    => 'Married'
						);
				$data['emp_status'] = array(
		                  'Active'  => 'Active',
		                  'On-Leave'    => 'On-Leave',
						  'Terminated'    => 'Terminated',
						  'Resigned'    => 'Resigned'
						);
				$data['dept_options'] = $this->Employee_model->get_dept();
				$data['tax_options'] = $this->Employee_model->get_tax();
				$data['type_options'] = $this->Employee_model->get_type();
				$data['user_right'] = $this->Employee_model->get_user_right();
				$data['shift_id'] = $this->Employee_model->get_shift();
				
				$this->validateForm("update");//call function for form validation
				
				if ($this->form_validation->run() == FALSE)
					$this->load->view('Emp_edit',$data);
					//validation errors are present
				else $this->Update();//update information
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	function GetAll()//Getting all info of employee and 
	{
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("viewemp"))
			{
				$data['query']=$this->Employee_model->Employee_getall();
				$data['person']=$this->session->userdata("fname").' '.$this->session->userdata("sname");
				$this->load->view('Emp_viewall',$data);
			} else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	function Show($empnum)//Getting all info of employee and 
	{
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("viewemp"))
			{
				$data['query']=$this->Employee_model->Employee_get($empnum);
				$data['rows']=$this->Employee_model->Employee_getRows($empnum);
				$data['person']=$this->session->userdata("fname").' '.$this->session->userdata("sname");
				$this->load->view('profile',$data);			
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	function Delete()//deletes an employee
	{
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("editemp"))
			{
				$this->Employee_model->Employee_delete();
				$data['query']=$this->Employee_model->Employee_getall();
				$this->load->view('Emp_viewall',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	function InsertDb()//insert an employee info to the database then redirect for viewing all employee page
	{
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("addemp"))
			{	
				$this->Employee_model->Employee_insert();
				$data['query']=$this->Employee_model->Employee_getall();
				$this->load->view('Emp_viewall',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	function Update()//update an employee info
	{
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("editemp"))
			{
				$this->Employee_model->Employee_update();
				$data['query']=$this->Employee_model->Employee_getall();
				$data['person']=$this->session->userdata("fname").' '.$this->session->userdata("sname");
				$this->load->view('Emp_viewall',$data);
				}else $this->load->view('no_access');
		}
		else
			redirect('login');
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
		
	function duplicate_empnum($str){	
		$response = $this->Employee_model->duplicate_EmployeeNum($str);
		$this->form_validation->set_message('duplicate_empnum','%s already exists.');
		
		return $response;
	}//check if duplicate employee number
	function Privilege($user)//Getting all info of employee and 
	{
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("access"))
			{
				$data['user']=$user;
				$data['query']=$this->Employee_model->get_privilege($user);
				$data['query1']=$this->Employee_model->get_privilege($user);
				$data['rows']=$this->Employee_model->get_privilegeRows($user);
				$this->load->view('privilege',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	function insertPriv()//Getting all info of employee and 
	{
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("access"))
			{
				//echo $this->input->post('user');//
				$this->Employee_model->insert_privilege($_POST['user']);
				redirect('employee/getall');
				//$this->load->view('privilege',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
}
?>