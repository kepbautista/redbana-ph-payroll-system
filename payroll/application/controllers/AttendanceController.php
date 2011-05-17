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
		
		//$this->load->view("GenerateAbsences_and_Late_View");
		//$this->generateAttendanceFault('', '', '');
		
		//is current date found on an entry in `payperiod`
		if ( $this->Attendance_model->isCurrentDate_on_a_payPeriod() )
		{	
			//is there any generated list for this payperiod?			
			$obj_result = $this->Payperiod_model->pull_Payperiod_This_Date_Falls( $this->Attendance_model->getCurrentDate_MySQL_Format() );			
				
			if($obj_result == NULL)
			{
				//someone deleted the payperiod table so fast. put error in here.
			}else
			{
				if( $obj_result->num_rows() > 1 )
				{
					//error, why two payperiods with the same date inclusive, there should be only one?
				}else
				{
					$payperiod_array = $obj_result->result();
					
					/*
						the concerned 'row' in the SQL table is accessible by index 0
						see if for this payperiod, there is at least one data generated for absences and tardiness
					*/
					if ( $this->Attendance_model->areAbsences_and_Late_Already_Generated( $payperiod_array[0]->ID ) )
					{
							// do you want to regenerate?
							echo site_url();
							echo "Already generated.<br/>";			
							echo '<a href="'.site_url().'/AttendanceController/clearAttendanceFaultData/'.$payperiod_array[0]->ID.'" >';
							echo 'Click here if you want to delete all for this current payperiod. </a>';							
					}else
					{
							echo "Not yet";
							echo '<a href="'.site_url().'/AttendanceController/generateAttendanceFault/'.$payperiod_array[0]->ID.'/'.$payperiod_array[0]->TOTAL_WORK_DAYS.'/8" >';
							//echo '<a href="'.site_url().'/AttendanceController/generateAttendanceFault/'.$payperiod_array[0]->ID.'/22/8" >';
							echo 'Click here to generate. </a>';
					}
					
					//now try if there is already existing attendance record then.
				}
				
				//die(var_dump( $payperiod_array ));
			}
		}else
		{	//not found, ask is time correct or do you want to generate payperiod now?
			$data['date_today'] =  $this->Attendance_model->getCurrentDate_European_Union_Format();
			$data['lastPayPeriod'] = $this->Payperiod_model->get_Last_PayPeriod();		
			$this->load->view('AttendanceFault_CannotFindDate_In_PayPeriod', $data);
		}
	}
	
	function regenerateAttendanceFaultData ($payperiod = NULL)
	{
		// abe | made | 17MAY2011_1437
		
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
		
		/*
			though in the view (AttendanceController) this shouldn't be accessible if there is no payperiod data in the DB
			a user can access this via his/her browser's history, so, safety net.
		*/
		$lastPayPeriod = $this->Payperiod_model->get_Last_PayPeriod();
		if($lastPayPeriod == NULL)
		{
			$validation_errors["ERROR_CODE"] = "NO_PAYPERIOD_DATA";
			$validation_errors["ERROR_MESSAGE"] = "There isn't any Payperiod in the database. Please insert first.";
			die(var_dump($validation_errors));
			//$this->load->view('???');
		}else
		{
			$this->clearAttendanceFaultData($lastPayPeriod->ID);
			$this->generateAttendanceFault('1', $lastPayPeriod->ID, $lastPayPeriod->TOTAL_WORK_DAYS, 8);
			
			die("Successfully regenerated.");
			
		}	
	}
	
	
	function clearAttendanceFaultData( $payperiod = NULL )
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
		$this->Attendance_model->deleteAttendanceFaultData_thisPayPeriod( $payperiod );
		if( $this->Attendance_model->areAbsences_and_Late_Already_Generated( $payperiod ) == FALSE)
		{
			echo "Successfully deleted.";
		}
	}
		
	function generateAttendanceFault
	(	
		$payment_mode = NULL,
		$payperiod = NULL, 
		$defaultWorkingDays = NULL,
		$defaultWorkingHours = NULL
	)
	{
	$validation_errors = array(
		"RESULT" => false, 
		"ERROR_CODE" => NULL,
		"ERROR_MESSAGE" => NULL
	);
	
	if( $payment_mode == NULL||
		$payperiod == NULL || 
		$defaultWorkingDays == NULL ||
		$defaultWorkingHours == NULL
	)
	{
		$validation_errors["ERROR_CODE"] = "DATA_NOT_SUPPLIED";
		$validation_errors["ERROR_MESSAGE"] = "You are trying to access a page that requires data be submitted first.";
		die(var_dump($validation_errors));
		//$this->load->view('login_view');
	}				
		$this->Attendance_model->generateAbsences_and_Late($payment_mode, $payperiod, $defaultWorkingDays, $defaultWorkingHours);
		
		
	}
			
	

}//class


/* End of file AttendanceController.php */
/* Location: ./application/controllers/AttendanceController.php */