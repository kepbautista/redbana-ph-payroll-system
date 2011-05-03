<?php
class Employee extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
	}
	function Insert()//function for viewing the inserting employee page
	{	
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$data['options'] = $this->Employee_model->get_status();
	$data['months'] = $this->Employee_model->buildMonthDropdown(); 
	$data['days'] = range(1,31);
	$data['years'] = range(1990,2020); 
	$data['pos_options'] = array(
                  'hr'  => 'HR',
                  'admin'    => 'Admin',
				  'exec'    => 'Exec'
                );
	$data['pmode_options'] = array(
                  'Semi Monthly'  => 'Semi Monthly',
                  'Monthly'    => 'Monthly'
				);
	$data['dept_options'] = array(
                  'hr'  => 'HR',
                  'admin'    => 'Admin',
				  'exec'    => 'Exec'
                );
	
	//load form validation library
	$this->load->library('form_validation');
	
	//form validation rules for employee information
	$this->form_validation->set_rules('empnum','Employee Number','required|callback_script_input|callback_duplicate_empnum');//additional rule: nasa database na...
	$this->form_validation->set_rules('fname','First Name','required|callback_script_input');
	$this->form_validation->set_rules('mname','Middle Name','required|callback_script_input');
	$this->form_validation->set_rules('sname','Last Name','required|callback_script_input');
	$this->form_validation->set_rules('mrate','Monthly Rate','required|numeric|greater_than[0]');
	$this->form_validation->set_rules('password','Password','required|callback_script_input|min_length[10]');
	
	if ($this->form_validation->run() == FALSE){
		$this->load->view('Emp_view',$data);
	}//validation errors are present
	else
	{
		$this->InsertDb();
	}//insert data
	
	}
	
	function Edit()//function for viewing the editing an employee page 
	{
	$this->load->helper('form');
	$this->load->model('Employee_model');
	$data['query']=$this->Employee_model->Employee_edit();
	$data['options'] = $this->Employee_model->get_status();
	$data['months'] = $this->Employee_model->buildMonthDropdown(); 
	$data['days'] = range(1,31);
	$data['pos_options'] = array(
                  'hr'  => 'HR',
                  'admin'    => 'Admin',
				  'exec'    => 'Exec'
                );
	$data['pmode_options'] = array(
                  'Semi Monthly'  => 'Semi Monthly',
                  'Monthly'    => 'Monthly'
				);
	$data['dept_options'] = array(
                  'hr'  => 'HR',
                  'admin'    => 'Admin',
				  'exec'    => 'Exec'
                );
	$data['years'] = range(1990,2020); 
	$this->load->view('Emp_edit',$data);
	}
	function GetAll()//Getting all info of employee and 
	{
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$data['query']=$this->Employee_model->Employee_getall();
	$this->load->view('Emp_viewall',$data);
	}
	function Delete()//deletes an employee
	{
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$this->Employee_model->Employee_delete();
	$data['query']=$this->Employee_model->Employee_getall();
	$this->load->view('Emp_viewall',$data);
	}
	function ViewTimeSheet()//view the timesheet for today 
	{
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$data['date']=date("Y/n/j");
	$data['trows']=$this->Employee_model->view_time();
	$data['query']=$this->Employee_model->Employee_viewalltime();
	
	$this->load->view('View_time',$data);
	}	
	function InsertDb()//insert an employee info to the database then redirect for viewing all employee page
	{
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$this->Employee_model->Employee_insert();
	$data['query']=$this->Employee_model->Employee_getall();
	$this->load->view('Emp_viewall',$data);
	}
	function Inserttime()
	{
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$this->Employee_model->insert_time();
	$data['trows']=$this->Employee_model->Employee_viewalltime_rows();
	$data['query']=$this->Employee_model->Employee_viewalltime();
	$this->load->view('View_time',$data);
	}
	function Update()//update an employee info
	{
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$this->Employee_model->Employee_update();
	$data['query']=$this->Employee_model->Employee_getall();
	$this->load->view('Emp_viewall',$data);
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
	
	/**SQL INJECTIONS!**/
	
	function duplicate_empnum($str){	
		$this->load->helper('form'); 
		$this->load->model('Employee_model');
		$response = $this->Employee_model->duplicate_EmployeeNum($str);
		
		$this->form_validation->set_message('duplicate_empnum','%s already exists.');
		
		return $response;
	}//check if duplicate employee number
}
?>