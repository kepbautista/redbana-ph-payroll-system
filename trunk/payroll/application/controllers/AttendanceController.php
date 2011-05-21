<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AttendanceController extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		
		$this->load->helper(array('form','url') );		
		$this->load->model('login_model');
		$this->load->model('Attendance_model');		
		$this->load->model('Payperiod_model');		
		
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
		$this->load->model('Payment_mode');
		
		$data['payment_modes'] = $this->Payment_mode->get_All_PaymentModes();				
		
		foreach( $data['payment_modes'] as $individ )
		{			
			$data['payperiods'][$individ->ID] = $this->Payperiod_model->get_All_PayPeriods($individ->ID, "DESC");
						
			if( $data['payperiods'][$individ->ID] != NULL )
			{
				foreach( $data['payperiods'][$individ->ID] as $individual_payperiods)
				{
					if($individual_payperiods == NULL) continue;
					$data['payperiods_already_generated'][$individ->ID][$individual_payperiods->ID] = $this->Attendance_model->areAbsences_and_Late_Already_Generated($individual_payperiods->ID, $individ->ID );				
				}
			}
			
		}		
				
		$this->load->view('AttendanceFaultHome', $data);			
	}
	
	function regenerateAttendanceFaultData ($payperiod = NULL, $payment_mode = NULL)
	{
		// abe | made | 17MAY2011_1437
		
		$validation_errors = array(
			"RESULT" => false, 
			"ERROR_CODE" => NULL,
			"ERROR_MESSAGE" => NULL
		);
			
		$payperiod = $this->input->post('PAYPERIOD');
		$payment_mode = $this->input->post('PAYMENT_MODE');
		/*
			though in the view (AttendanceController) this shouldn't be accessible if there is no payperiod data in the DB
			a user can access this via his/her browser's history, so, safety net.
		*/
		$lastPayPeriod = $this->Payperiod_model->get_Last_PayPeriod($payment_mode);	
		if($lastPayPeriod == NULL)
		{
			$validation_errors["ERROR_CODE"] = "NO_PAYPERIOD_DATA";
			$validation_errors["ERROR_MESSAGE"] = "There isn't any Payperiod in the database. Please insert first.";
			die(var_dump($validation_errors));
			//$this->load->view('???');
		}else
		{
			$this->clearAttendanceFaultData($lastPayPeriod->ID, $payment_mode);
			$mode['present_progressive'] = 'regenerating';
			$mode['past'] = 'regenerated';
			$data['generation_result'] = $this->generateAttendanceFault($payment_mode, $lastPayPeriod->ID, 8, $mode);						
		}	
	}
	
	
	function clearAttendanceFaultData( $payperiod = NULL, $payment_mode = NULL )
	{
		$validation_errors = array(
			"RESULT" => false, 
			"ERROR_CODE" => NULL,
			"ERROR_MESSAGE" => NULL
		);
	
		if( $payperiod == NULL )
		{
			$validation_errors["ERROR_CODE"] = "DATA_NOT_SUPPLIED";
			$validation_errors["ERROR_MESSAGE"] = "You are trying to access a page that requires data be submitted first.";
			die(var_dump($validation_errors));
			//$this->load->view('login_view');
		}
		$this->Attendance_model->deleteAttendanceFaultData_thisPayPeriod( $payperiod, $payment_mode );
		if( $this->Attendance_model->areAbsences_and_Late_Already_Generated( $payperiod, $payment_mode ) == FALSE)
		{
			//echo "Successfully deleted.";
		}else
		{
			//echo 'not deleted.';
		}
	}
		
	function generateAttendanceFault
	($payment_mode = NULL, $payperiod = NULL, $WORKING_HOURS = 8, $mode = array() )
	{
		$validation_errors = array(
			"RESULT" => false, 
			"ERROR_CODE" => NULL,
			"ERROR_MESSAGE" => NULL
		);
		
		if($payperiod == NULL)  $payperiod = $this->input->post('PAYPERIOD');
		if($payment_mode == NULL) $payment_mode = $this->input->post('PAYMENT_MODE');
		
		if( !$payment_mode or !$payperiod )
		{
			$validation_errors["ERROR_CODE"] = "DATA_NOT_SUPPLIED";
			$validation_errors["ERROR_MESSAGE"] = "You are trying to access a page that requires data be submitted first.";
			die(var_dump($validation_errors));
			//$this->load->view('login_view');
		}				
		
		
		$payperiod_obj = $this->Payperiod_model->pull_PayPeriod_Info_X($payperiod, $payment_mode);		
		if( empty($mode) )
		{
			$mode['present_progressive'] = 'generating';
			$mode['past'] = 'generated';
		}
		$data['generation_result'] = $this->Attendance_model->generateAbsences_and_Late($payment_mode, $payperiod, $payperiod_obj->TOTAL_WORK_DAYS, 8);
		$data['mode'] = $mode;
		
		$this->loadGenerationResult($data);
	}
			
	private function loadGenerationResult($data)
	{
		$this->load->view('generateAttendanceFaultResult', $data);
	}
	
	function viewAttendanceFaultData($payperiod = NULL, $payment_mode = NULL)
	{
		if($payperiod == NULL)  $payperiod = $this->input->post('PAYPERIOD');
		if($payment_mode == NULL) $payment_mode = $this->input->post('PAYMENT_MODE');
		
		if( !$payment_mode or !$payperiod )
		{
			$validation_errors["ERROR_CODE"] = "DATA_NOT_SUPPLIED";
			$validation_errors["ERROR_MESSAGE"] = "You are trying to access a page that requires data be submitted first.";
			die(var_dump($validation_errors));
			//$this->load->view('login_view');
		}	
		
		$data['payperiod_obj'] = $payperiod_obj = $this->Payperiod_model->pull_PayPeriod_Info_X($payperiod, $payment_mode);	
		$data['result'] = $this->Attendance_model->getAttendanceFaults($payperiod, $payment_mode);
		$data['statistics'] = $this->Attendance_model->computeTotal_AttendanceFaults($data['result']);
		$this->load->view('viewAttendanceFaultResult', $data);
	}

}//class


/* End of file AttendanceController.php */
/* Location: ./application/controllers/AttendanceController.php */