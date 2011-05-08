<?php
class Employee extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
	}
	
	function validateForm($type){
		//load form validation library
		$this->load->library('form_validation');
	
		//form validation rules for employee information
		if($type=="insert") $this->form_validation->set_rules('empnum','Employee Number',	'required|callback_script_input|callback_duplicate_empnum');
		$this->form_validation->set_rules('fname','First Name','required|callback_script_input');
		$this->form_validation->set_rules('mname','Middle Name','required|callback_script_input');
		$this->form_validation->set_rules('sname','Last Name','required|callback_script_input');
		$this->form_validation->set_rules('mrate','Monthly Rate','required|numeric|greater_than[0]');
		$this->form_validation->set_rules('password','Password','required|callback_script_input|min_length[10]');
		
	}//function for validating forms
	
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
	
		$this->validateForm("insert");//call function for validating forms
	
		if ($this->form_validation->run() == FALSE)
			$this->load->view('Emp_view',$data);
			//validation errors are present
		else $this->InsertDb();//insert data
	
	}
	
	function Edit()//function for viewing the editing an employee page 
	{	
		if(!isset($_POST['editEmp']))
		{
			//get all posted data from the previous viewing of Emp_edit form
			$data['empnum'] = $_POST['empnum'];//employee number
			$data['fname'] = $_POST['fname'];//first name
			$data['mname'] = $_POST['mname'];//middle name
			$data['sname'] = $_POST['sname'];//last name
			$data['mrate'] = $_POST['mrate'];//monthly rate
			$data['position'] = $_POST['position'];//position
			$data['dept'] = $_POST['dept'];//department
			$data['gender'] = $_POST['gender'];//gender
			$data['status'] = $_POST['status'];//status
			$data['payment_mode'] = $_POST['payment_mode'];//payment mode
			$data['password'] = $_POST['password'];//password
			
			//starting date
			$data['syear'] = $_POST['syear'];
			$data['smonth'] = $_POST['smonth'];
			$data['sday'] = $_POST['sday'];
			
			//Birthdate
			$data['byear'] = $_POST['byear'];
			$data['bmonth'] = $_POST['bmonth'];
			$data['bday'] = $_POST['bday'];
			
			$this->load->helper('form');
			$this->load->model('Employee_model');
		}
		else{
			$this->load->helper('form');
			$this->load->model('Employee_model');
			$data['query']=$this->Employee_model->Employee_edit();
		}//Edit Employee Form is executed for the 1st time
		
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
	
		$this->validateForm("update");//call function for form validation
		
		if ($this->form_validation->run() == FALSE){
			$this->load->view('Emp_edit',$data);
			//validation errors are present
		}
		else $this->Update();//update information
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
	
	function InsertDb()//insert an employee info to the database then redirect for viewing all employee page
	{
		$this->load->helper('form');  
		$this->load->model('Employee_model');
		$this->Employee_model->Employee_insert();
		$data['query']=$this->Employee_model->Employee_getall();
		$this->load->view('Emp_viewall',$data);
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
	
	//HR
	
	function Insertothertime()
	{
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$data['mos']= $this->Employee_model->buildMonthDropdown(); 
	$date_rows=$this->Employee_model->Employee_viewalltime_rows(1);
	if ($date_rows==0)$this->Employee_model->insert_time();
	$data['trows']=$this->Employee_model->Employee_viewalltime_rows(1);
	$data['query']=$this->Employee_model->Employee_viewalltime(1);	
	$data['date_today']=date("Y/n/j");
	$data['date']=$this->input->post('date');
	list($year,$month,$day) = explode('-', $data['date']);
	$data['mos']= $this->Employee_model->buildMonthDropdown(); 
	$data['year_s']=$year;
	$data['month_s']=$month;
	$data['day_s']=$day;
	$this->load->view('date_inserted',$data);
	}
	function ViewTimeSheet()//view the timesheet for today 
	{
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$data['date']=date("Y-n-j");
	$date=date("Y/n/j");
	list($year,$month,$day) = explode('/', $date);
	$data['trows']=$this->Employee_model->Employee_viewalltime_rows(2);
	$data['query']=$this->Employee_model->Employee_viewalltime(2);	
	$data['mos']= $this->Employee_model->buildMonthDropdown(); 
	$data['year_s']=$year;
	$data['month_s']=$month;
	$data['day_s']=$day;
	$this->load->view('View_time',$data);
	}
	function Viewotherdate()//view the timesheet for today 
	{
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$data['date']=$this->input->post('yrs').'-'.$this->input->post('mos').'-'.$this->input->post('days');
	list($year,$month,$day) = explode('-', $data['date']);
	$data['trows']=$this->Employee_model->Employee_viewalltime_rows(3);
	$data['query']=$this->Employee_model->Employee_viewalltime(3);	
	$data['mos']= $this->Employee_model->buildMonthDropdown(); 
	$data['year_s']=$year;
	$data['date_today']=date("Y/n/j");
	$data['month_s']=$month;
	$data['day_s']=$day;
	$this->load->view('View_otherdate',$data);
	}
	function Updatetime()//view the timesheet for today 
	{
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$this->Employee_model->Employee_updateTime();
	list($year,$month,$day) = explode('-', $this->input->post('date'));
	$data['query']=$this->Employee_model->Employee_viewalltime(1);	
	$data['mos']= $this->Employee_model->buildMonthDropdown(); 
	$data['year_s']=$year;
	$data['month_s']=$month;
	$data['day_s']=$day;
	$this->load->view('dateupdated',$data);
	}
	function EditTime()//view the timesheet for today 
	{
	$this->load->helper('form');  
	$this->load->model('Employee_model');
	$data['edit']=$this->input->post('empnum');
	$data['date']=$this->input->post('date');
	$data['hour']=range(01,12);
	$data['minute']=range(00,59);
	$data['second']=range(00,59);
	$data['ampm'] = array(
                  'am'  => 'am',
                  'pm'    => 'pm'
				);
	$date=$this->input->post('date');
	list($year,$month,$day) = explode('-', $date);
	$data['mos']= $this->Employee_model->buildMonthDropdown(); 
	$data['year_s']=$year;
	$data['month_s']=$month;
	$data['day_s']=$day;
	$data['query']=$this->Employee_model->Employee_viewalltime(1);	
	$this->load->view('Edit_time',$data);
	}
}
?>