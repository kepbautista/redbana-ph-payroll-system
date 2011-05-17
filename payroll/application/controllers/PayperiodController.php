<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PayperiodController extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
				
		$this->load->helper(array('form','url') );		
		$this->load->model('login_model');
		$this->load->model('Payperiod_model');		
		$this->load->model('Attendance_model');		
		
		if( ! $this->login_model->isUser_LoggedIn() ) 
		{
			/* ABE | 15MAY2011 2326 | The succeeding two lines are under development,
			*	isn't it nice that such error is displayed on the login page on the circumstance?
			*/
			//$data['relayThisError'] = array("ERROR_CODE" => "NEED_TO_LOGIN", "ERROR_MESSAGE" => "You are accessing a page that requires you to be logged in.");
			//$this->load->view('login_view', $data);
			
			redirect('Login', $data);						
		}
	}
	
	function index()
	{
	
	}
	
	function addPayPeriod()
	{
		$data['lastPayPeriod'] = $this->Payperiod_model->get_Last_PayPeriod(1);		
		$data['payment_modes'] = $this->Attendance_model->getPaymentModes();
		$this->load->view('addNewPayPeriod', $data);
	}
	
		
	function addPayPeriod_Process()
	{
		$this->load->library('form_validation');
		$start_date = strtotime( $this->input->post('START_DATE') );
		$end_date =  strtotime( $this->input->post('END_DATE') );
		
		//setup validation rules.		
		$this->form_validation->set_rules('START_DATE', 'Start Date', 'callback_startDate_check');
		$this->form_validation->set_rules('END_DATE', 'End date', 'callback_endDate_check');	
		$this->form_validation->set_rules('WORKING_DAYS', 'Working days', 'callback_workingDays_check');	
		
		if($this->form_validation->run() == FALSE){				
			//has not been run or failed validation.
			$this->addPayPeriod();
		}else{	
			$data['result'] = $this->Payperiod_model->add_new_PayPeriod(
				$this->input->post('PAYMENT_MODE'),
				$this->input->post('START_DATE'), 
				$this->input->post('END_DATE'),
				$this->input->post('WORKING_DAYS')
			);
			$this->load->view('success_AddedPayPeriod', $data);
		}			
	}

	function workingDays_check($str)		
	{	
		if($str == "")
		{
			$this->form_validation->set_message('workingDays_check', '"Working Days" is required.');
			return FALSE;
		}
	
		if( is_numeric($str) )
		{	return TRUE;	}
		else
		{
			$this->form_validation->set_message('workingDays_check', 'Working Days should be a number.');
			return FALSE;
		}
	}
	
	function startDate_check($str)
	{
		
		$lastPayPeriod = $this->Payperiod_model->get_Last_PayPeriod();
	
		if($str == ""){ 
			$this->form_validation->set_message('startDate_check', 'Start Date cannot be blank.');		
			return false;
		}
		
		$check_date_return = $this->is_This_Date($str);
		
		if( $check_date_return['result'] == FALSE)
		{
			$this->form_validation->set_message('startDate_check', "Invalid format for Start Date.");		
			return false;
		}
		
		//how about if no payperiod gotten?		
		if( $lastPayPeriod != NULL &&
			!( strtotime($str) >=  strtotime($lastPayPeriod->END_DATE)  )   
		)
		{
			$this->form_validation->set_message('startDate_check', "Start Date should be later than or the same as the previous pay period's end date.");		
			return false;
		}
	
		
		return true;
	}
	
	function endDate_check($str)
	{
		$lastPayPeriod = $this->Payperiod_model->get_Last_PayPeriod();
		
		if($str == ""){
			$this->form_validation->set_message('endDate_check', 'End Date cannot be blank.');		
			return false;
		}
		
		$check_date_return = $this->is_This_Date($str);
		
		if( $check_date_return['result'] == FALSE)
		{
			$this->form_validation->set_message('endDate_check', "Invalid format for End Date.");		
			return false;
		}
		
		//how about if no payperiod gotten?
		if( $lastPayPeriod != NULL &&
			!( strtotime($str) >=  strtotime($lastPayPeriod->END_DATE)  )   
		)
		{
			$this->form_validation->set_message('endDate_check', "End Date should be later than or the same as the previous pay period's end date.");		
			return false;
		}
		
		if(  
		 ! ( strtotime($str) >  strtotime($this->input->post('START_DATE'))  )   
		)
		{
			$this->form_validation->set_message('endDate_check', "End Date should be later than the start date.");		
			return false;
		}
		
		return true;
	}
	
	private function is_This_Date($str)
	{
		$allowedChars = "0123456789";
		$found_fault = FALSE;
		
		//DATE FORMAT IN THIS APP: YYYY/MM/DDD
		$returnThis = array("result" => false, "ERROR_CODE" => null, "ERROR_MESSAGE" => null);
		
		if( strlen($str) != 10 )
		{
			$returnThis["ERROR_CODE"] =  "DATE_INCONFORMANCE_TO_STANDARD";
			$returnThis["ERROR_MESSAGE"] = "The date submitted is not in accordance to the YYYY/MM/DD (ISO) format.";			
			return $returnThis;
		}
		
		/*
			Since it doesn't matter much what separator we can use in a date e.g.
			1992.04/25, we are concerned only with the numeric values.
		*/
		$str[4] = '-';	
		$str[7] = '-';
		
		$splitted = explode('-', $str);		//now explode, so that they wil be separated into year, month and day
		
		if( count($splitted) != 3 )
		{
			$returnThis["ERROR_CODE"] =  "DATE_INCONFORMANCE_TO_STANDARD";
			$returnThis["ERROR_MESSAGE"] = "The date submitted is not in accordance to the YYYY/MM/DD (ISO) format.";			
			return $returnThis;
		}
		
		foreach($splitted as $individual_date_elements)
		{
			$y = strlen($individual_date_elements);
			for($x=0; $x<$y; $x++)
			{			
				if( !stristr($allowedChars, $individual_date_elements[$x]) )
				{			
					$found_fault = TRUE;
					break;
				}
			}
		}
		
		if( 
			$found_fault
		) 
		{
			$returnThis["ERROR_CODE"] =  "DATE_INCONFORMANCE_TO_STANDARD";
			$returnThis["ERROR_MESSAGE"] = "The date submitted is not in accordance to the YYYY/MM/DD (ISO) format.";			
			
			return $returnThis;
		}
		
		$returnThis['result'] = TRUE;		
		return $returnThis;
	}
}//class

/* End of file PayperiodController.php */
/* Location: ./application/controllers/PayperiodController.php */