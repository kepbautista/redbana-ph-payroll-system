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
		$this->load->model('Shift_model');
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
		$OvertimeTakenNoteAlready;
		$payperiod_obj;
		
		//get user info for displaying on our header later
		$data['userData'] = $this->login_model->getUserInfo_for_Panel();
		
		//FORM DATA GATHERING
		if($payperiod == NULL)  $payperiod = $this->input->post('PAYPERIOD');
		if($payment_mode == NULL) $payment_mode = $this->input->post('PAYMENT_MODE');
		$OvertimeTakenNoteAlready = $this->input->post('OT_TOOK_NOTE_ALREADY');
		
		// DEALING WITH INVALID, NSUFFICIENT, ABSENT FORM DATA
		if( !( $OvertimeTakenNoteAlready == '0' or $OvertimeTakenNoteAlready == '1'))
		{ 
			$OvertimeTakenNoteAlready = FALSE;
		}
		
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
		
		//GETTING DAILY RATES OF EMPLOYEES  PART
		$GDR_x = $this->Employee_model->getAllEmployees_DailyRate($payperiod_obj);
		if( $GDR_x['ERROR_CODE'] != 0)
		{
			if($GDR_x['FURTHER_INFO'] != NULL)
			{
				//$this->load->view("ShowErrorsGeneral", $GDR_x['FURTHER_INFO']);
			}else{
				//$this->load->view("ShowErrorsGeneral", $GDR_x);
			}			
			die('GDR Error');
		}
		$currentEmployeesDailyRate = $GDR_x['FURTHER_INFO'];	//daily rates are here		
		$absences_data = $this->Attendance_model->getAbsences($payperiod, ``, ``, $payment_mode);
		$tardiness_data = $this->Attendance_model->getTardiness($payperiod, ``, ``, $payment_mode);		
		
		//calculate times concerned for these
		$this->Attendance_model->get_OverTime($payperiod, $payment_mode);
		$this->Attendance_model->get_UnderTime($payperiod, $payment_mode);
		$this->Attendance_model->get_NightDifferential($payperiod, $payment_mode);
						
		if( $OvertimeTakenNoteAlready == '0' AND $this->Attendance_model->isThereOvertime_in_PayPeriod($payperiod_obj) )
		{
			$allowedOvertime = array();
			$nameList = array();
			$data['overtime_entries'] = $this->Attendance_model->getOvertimes_in_Payperiod($payperiod_obj);
			foreach($data['overtime_entries'] as $each_day)
			{				
				foreach($each_day as $each_attendance)
				{
					if( !isset( $allowedOvertime[$each_attendance->work_date] ) )
					{
						$allowedOvertime[$each_attendance->work_date] = array();
					}
					$allowedOvertime[$each_attendance->work_date][$each_attendance->empnum] = $this->Payperiod_model->getAllowedOT_Rates($each_attendance);
					if(! isset ($nameList[$each_attendance->empnum]) )	$nameList[$each_attendance->empnum] = $this->Payperiod_model->getName($each_attendance->empnum);
				}
			}
			//echo var_dump($allowedOvertime);
			$data['allowedOvertime'] = $allowedOvertime;
			$data['nameList'] = $nameList;
			$data['payperiod'] = $payperiod;
			$data['payment_mode'] = $payment_mode;		
			$data['shifts'] = $this->Shift_model->makeAssociativeArray_of_Shifts();
			$data['workday_classes'] = $this->Payperiod_model->getWorkDays();			
			$this->load->view("inputOvertimeRates", $data);				
		}else{			
			$data['generation_result'] = $this->Attendance_model->generateAbsences_and_Late(
				$payment_mode, 
				$payperiod, 
				$payperiod_obj->TOTAL_WORK_DAYS, 
				8, 
				$currentEmployeesDailyRate,
				$absences_data,
				$tardiness_data
			);
			$data['mode'] = $mode;
			
			$this->loadGenerationResult($data);
		}
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
		if($payperiod_obj == NULL) die(var_dump($this->ErrorReturn_model->createSingleError(407, NULL, NULL)));		//payperiod not found
		$data['result'] = $this->Attendance_model->getAttendanceFaults($payperiod, $payment_mode);
		$data['statistics'] = $this->Attendance_model->computeTotal_AttendanceFaults($data['result']);		
		if( !empty($data['result']) )
		{
			$data['employees'] = $this->Employee_model->get_Employees_Associative();
		}
		$this->load->view('viewAttendanceFaultResult', $data);
	}

	function updateOvertime()
	{
		$empnum = $this->input->post('empnum');
		$workDate = $this->input->post('work_date');
		$OT_ID = $this->input->post('value');
	
		if( !( 
		  $empnum != FALSE AND
		  $workDate != FALSE AND
		  $OT_ID != FALSE
		  )
		) 
		{
			echo "DATA_INSUFFICIENT";		
			return;
		}
		
		$OT_array = $this->Payperiod_model->getOvertimeRateSingle($OT_ID);
		if($OT_array == NULL)
		{			
			echo "OVERTIME_RATE_NOT_FOUND";
			return;
		}				
		if(!$this->Attendance_model->update_Overtime_in_Timesheet($empnum, $workDate, $OT_array[0]->MULFACTOR)) echo "INSERTION_ERROR";
		return;
	}
	
}//class


/* End of file AttendanceController.php */
/* Location: ./application/controllers/AttendanceController.php */