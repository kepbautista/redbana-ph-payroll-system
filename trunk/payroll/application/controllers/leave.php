<?php
class Leave extends CI_Controller {

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
		$data['query']=$this->Leave_model->Leave_getall();
		$this->load->view('leave_viewall',$data);
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
	//HR
}
?>