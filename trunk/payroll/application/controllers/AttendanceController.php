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
		$this->load->model('Employee_model');
		$this->load->model('ErrorReturn_model');
		
		/*  ABE | 15MAY2011 2326 | The succeeding lines until the end of this functionareunder development,
			isn't it nice that such error is displayed on the login page on the circumstance?				
		*/			
		$data['relayThisError'] = $this->ErrorReturn_model->createSingleError(455, NULL, NULL);
		$this->login_model->check_and_Act_on_Login('Login', NULL, $data);
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
		// abe | edited | 07JUN2011_2217
		
		$payperiod = $this->input->post('PAYPERIOD');
		$payment_mode = $this->input->post('PAYMENT_MODE');
		if( !$payperiod or !$payment_mode)
		{ 			
			die(var_dump($this->ErrorReturn_model->createSingleError(408, NULL, NULL)));			
		}
		$payperiod_obj = $this->Payperiod_model->pull_PayPeriod_Info_X($payperiod, $payment_mode);
		if($payperiod_obj == NULL)
		{
			die(var_dump($this->ErrorReturn_model->createSingleError(407, NULL, NULL)));			
		}		
		$this->clearAttendanceFaultData($payperiod, $payment_mode);
		$mode['present_progressive'] = 'regenerating';
		$mode['past'] = 'regenerated';
		$data['generation_result'] = $this->generateAttendanceFault($payment_mode, $payperiod, 8, $mode);						
		
	}
		
	function clearAttendanceFaultData( $payperiod = NULL, $payment_mode = NULL )
	{
		//abe | edited | 07JUN2011_2218
	
		if( $payperiod == NULL )
		{			
			die(var_dump($this->ErrorReturn_model->createSingleError(455, NULL, NULL)));
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
			die(var_dump($this->ErrorReturn_model->createSingleError(408, NULL, NULL)));			
		}				
		
		
		$payperiod_obj = $this->Payperiod_model->pull_PayPeriod_Info_X($payperiod, $payment_mode);		
		if( empty($mode) )
		{
			$mode['present_progressive'] = 'generating';
			$mode['past'] = 'generated';
		}
		$currentEmployees = $this->Employee_model->get_Employees_Associative();
		$currentEmployeesDailyRate = array();
		
		foreach($currentEmployees as $eachEmployee)
		{			
			$xyza = floatval($this->Employee_model->getDailyRate_from_SalaryTable($payperiod_obj, $eachEmployee->empnum));			
		    $currentEmployeesDailyRate[$eachEmployee->empnum] = $xyza;
		}		
		$data['generation_result'] = $this->Attendance_model->generateAbsences_and_Late($payment_mode, $payperiod, $payperiod_obj->TOTAL_WORK_DAYS, 8, $currentEmployeesDailyRate);
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
			die(var_dump($this->ErrorReturn_model->createSingleError(408, NULL, NULL)));			
		}	
		
		$data['payperiod_obj'] = $payperiod_obj = $this->Payperiod_model->pull_PayPeriod_Info_X($payperiod, $payment_mode);	
		$data['result'] = $this->Attendance_model->getAttendanceFaults($payperiod, $payment_mode);
		$data['statistics'] = $this->Attendance_model->computeTotal_AttendanceFaults($data['result']);		
		if( !empty($data['result']) )
		{
			$data['employees'] = $this->Employee_model->get_Employees_Associative();
		}
		$this->load->view('viewAttendanceFaultResult', $data);
	}

}//class


/* End of file AttendanceController.php */
/* Location: ./application/controllers/AttendanceController.php */