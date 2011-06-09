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
		$this->load->model('ErrorReturn_model');		
		
		if( ! $this->login_model->isUser_LoggedIn() ) 
		{
			/* ABE | 15MAY2011 2326 | The succeeding two lines are under development,
			*	isn't it nice that such error is displayed on the login page on the circumstance?
			*/
			$data['relayThisError'] = array("ERROR_CODE" => "NEED_TO_LOGIN", "ERROR_MESSAGE" => "You are accessing a page that requires you to be logged in.");		
			$this->login_model->check_and_Act_on_Login('Login', NULL, $data);
		}
	}
	
	function index()
	{
		redirect('/');
	}
	
	function addPayPeriod($payment_mode = NULL)
	{
		
		if($payment_mode == NULL)
		{
			$data['payment_mode_specified'] = FALSE;
		}else{
			$data['lastPayPeriod'] = $this->Payperiod_model->get_Last_PayPeriod($payment_mode);							
			$data['payment_mode_specified'] = TRUE;
			$data['payment_mode'] = $payment_mode;
		}		
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
		
		if($this->form_validation->run() == FALSE){				//has not been run or failed validation.
			$this->addPayPeriod();
		}else{	
			$data['result'] = $this->Payperiod_model->add_new_PayPeriod(
				$this->input->post('PAYMENT_MODE'),
				$this->input->post('START_DATE'), 
				$this->input->post('END_DATE'),
				$this->input->post('WORKING_DAYS'),
				$this->input->post('END_OF_THE_MONTH')
			);
			$this->load->view('success_AddedPayPeriod', $data);
		}			
	}
	
	function deletePayPeriod_Process()
	{
		$payperiod = $this->input->post('payperiod');	//index number of payperiod
		/*
		if($payperiod == FALSE)
		{
			$this->addPayPeriod();
		}
		$sql_x = "DELETE FROM";
		*/
	}//deletePayPeriod_Process
	
	
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
		
		$lastPayPeriod = $this->Payperiod_model->get_Last_PayPeriod( $this->input->post('payment_mode') );
	
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
		$lastPayPeriod = $this->Payperiod_model->get_Last_PayPeriod( $this->input->post('payment_mode') );
		
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
		
		//inconformance to supposedly 10 chars
		if( strlen($str) != 10 )return $this->ErrorReturn_model->createSingleError(700, NULL, NULL);	
		
		/*
			Since it doesn't matter much what separator we can use in a date e.g.
			1992.04/25, we are concerned only with the numeric values.
		*/
		$str[4] = '-';	
		$str[7] = '-';
		
		$splitted = explode('-', $str);		//now explode, so that they wil be separated into year, month and day
		
		// ISO format non-conformance return error
		if( count($splitted) != 3) return $this->ErrorReturn_model->createSingleError(701, NULL, NULL);	
		
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
		// ISO format non-conformance return error
		if( $found_fault ) return $this->ErrorReturn_model->createSingleError(701, NULL, NULL);	
		
		return $this->ErrorReturn_model->createSingleError(0, NULL, NULL);	//success		
	}//is_This_Date($str)
	
	function finalizePayPeriod()
	{		
		/*
			made | abe | 19may2011_1235
		*/
		$stillErrors = TRUE;
		$missing_in_TimeSheet = array();
		$there_is_entry_for_payperiod = TRUE;		
		$payperiod_lapsed = TRUE;
		$payperiod = $this->input->post('PAYPERIOD');
		$payment_mode = $this->input->post('PAYMENT_MODE');				
		$this->load->model('Employee_model');	//only used here, move to __construct() if used by multiple functions already
		
		
		$payperiod_obj = $this->Payperiod_model->pull_PayPeriod_Info_X( $payperiod, $payment_mode );				
		$eligible_employees = $this->Employee_model->getAllEmployees_eligible_this_PayPeriod($payperiod_obj, $payment_mode);
		
		//determine if each and every employee eligible does have an entry in timesheet
		foreach( $eligible_employees as $each_employee)
		{							
			if( 				
			  ! $this->Attendance_model->areThere_AbsenceAndTardiness_of_Employee_during_Payperiod($each_employee->empnum, $payperiod_obj)
			  and ($each_employee->payment_mode == $payment_mode)
			)
			{
				$missing_in_TimeSheet[] = $each_employee->empnum;
			}					
		}//foreach					
		$data['payperiod'] = $payperiod;
		$data['payperiod_obj'] = $payperiod_obj;
		$data['payment_mode'] = $payment_mode;
		$data['eligible_employees'] = $eligible_employees;
		$data['payperiod_lapsed'] = FALSE;
		
		$payperiod_of_today = $this->Payperiod_model->pull_Payperiod_This_Date_Falls( $this->Attendance_model->getCurrentDate_MySQL_Format() )->result();
		
		//checks if today is within the payperiod, if so, display appropriate message
		if( !empty($payperiod_of_today) ) $data['payperiod_lapsed'] = ($payperiod == $payperiod_of_today[0]->ID);				
		
		if( !empty($missing_in_TimeSheet) ||  !empty($payperiod_of_today) )
		{
			$data['missing_in_TimeSheet'] = $missing_in_TimeSheet;
			$this->load->view("payperiodFinalizeDisplayAnomalies", $data);
		}else{
			$this->finalizePayPeriod_askConfirmation();
		}
	}

	function finalizePayPeriod_askConfirmation($data = NULL)
	{	
		if($data == NULL)	//this is true, if this was accessed from view("payperiodFinalizeDisplayAnomalies")
		{
			$data['payperiod'] = $this->input->post('PAYPERIOD');
			$data['payment_mode'] = $this->input->post('PAYMENT_MODE');
		}
		
		$this->load->view('payperiodFinalizeConfirm', $data);
	}
	
	function finalizePayPeriod_Confirmed()
	{
		$result;		
		$this->load->model('Login_model');
	
		$payperiod = $this->input->post('PAYPERIOD');
		$payment_mode = $this->input->post('PAYMENT_MODE');				
		
		if( !$payperiod or ! $payment_mode )
		{
			die("You should not access this thing directly.");
		}
		
		$result = $this->Payperiod_model->finalizePayPeriod(
			$payment_mode,
			$payperiod,
			$this->Login_model->getCurrentUser()
		);
		
		$data['result'] = $result['result'];
		$this->load->view('payperiodFinalizeResult', $data);				
	}
	
}//class

/* End of file PayperiodController.php */
/* Location: ./application/controllers/PayperiodController.php */