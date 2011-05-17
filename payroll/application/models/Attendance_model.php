<?php

class Attendance_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Payperiod_model');
	}

	function getAbsences
	( $payperiod = NULL, $dateFrom = NULL, $dateTo = NULL )
	{
		/*
			If $payperiod is not null, it will be preferred.
		*/
		
		$employee_absence_count = NULL;
		$employee_Absences_Data = array();
		
		$theResult = array("error_code" => NULL,
						   "error_message" => NULL,
							"result_array" => NULL
		);
		
		/*
			if payperiod is not null, let's follow this,
			the starting date and ending date from this pay period will
			be considered
		*/
		if($payperiod != NULL)
		{
			//get date inclusives during the payperiod specified from database			
			$obj_result = $this->Payperiod_model->pull_PayPeriod_Info($payperiod);
						 		
			if($obj_result->num_rows == 0)
			{
				$theResult["error_code"] = -2;
				$theResult["error_message"] = "Pay period does not exist";
				return $theResult;
			}
			
			/*now store dates
			  :: might be a potential for bugs
			*/
			$temp = $obj_result->result();
			$dateFrom = $temp[0]->START_DATE;
			$dateTo   = $temp[0]->END_DATE;			
		}else	//no payperiod specified but only dates inclusive
		{			
			if($dateFrom == NULL or $dateTo == NULL) 
			{
				$theResult["error_code"] = -1;
				$theResult["error_message"] = 'Date(s) is/are NULL.';
				return $theResult;
			}
		}
		
		/*			now pull-all employees
			
			abe | 10may2011 2030 | i am making my own fetch all function so far
				since I'm not sure of Employee_model->Employee_getall()
		*/		
		$employees = $this->getAllEmployees()->result();		
		if( empty ($employees) )
		{			
			$theResult["error_code"] = -3;
			$theResult["error_message"] = "No employee so far.";
			return $theResult;
		}		

		/*
		Get all the type of absences
		*/
		$sql_x = "SELECT * from `absence_reason` ";	
		$this_obj =  $this->db->query($sql_x);
		$absence_reason = $this_obj->result() ;
		
					
		foreach($employees as $emp_x)
		{			
			/*
				Make an associative array out of the type of absences
			*/				
			foreach($absence_reason as $absence_reason_individual)
			{
				$employee_absence_count[ $absence_reason_individual->ID ] = array(
						"TITLE" => $absence_reason_individual->TITLE,
						"DEDUCTIBLE" =>  $absence_reason_individual->DEDUCTIBLE,
						"ABSENCE_REASON_CATEGORY" => $absence_reason_individual->ABSENCE_REASON_CATEGORY,
						"VALUE" => 0
				);
			}
			
			/*
				pull all records between the date specified for the employee
			*/
			$daily_attendance = $this->pullAttendanceRecord($emp_x->empnum, $dateFrom, $dateTo)->result();																	
			foreach($daily_attendance as $daily_attendance_each_day)
			{																			
				if ($daily_attendance_each_day->absence_reason != NULL ) 
				{
					$employee_absence_count[$daily_attendance_each_day->absence_reason]['VALUE']++;
				}
			}
			
			$employee_Absences_Data[$emp_x->empnum] = $employee_absence_count;
			
			unset( $employee_absence_count ); //unset to make a new associative array upon reiteration / clear memory upon finishing loop
		}//foreach (employees
		
		$theResult['result_array'] = $employee_Absences_Data;
		$theResult['error_code'] = 0;
		$theResult['error_message'] = 'SUCCESS';
			
		return $theResult;
	}
	
	function getTardiness
	( $payperiod = NULL, $dateFrom = NULL, $dateTo = NULL )
	{
		/*
			If $payperiod is not null, it will be preferred.
		*/
		
		$emp_tardiness_result = array();		
		$theResult = array("error_code" => NULL,
						   "error_message" => NULL,
							"result_array" => NULL
		);
		
		/*
			if payperiod is not null, let's follow this,
			the starting date and ending date from this pay period will
			be considered
		*/
		if($payperiod != NULL)
		{
			//get date inclusives during the payperiod specified from database
			$obj_result = $this->Payperiod_model->pull_PayPeriod_Info($payperiod);
			
			if($obj_result->num_rows == 0)
			{
				$theResult["error_code"] = -2;
				$theResult["error_message"] = "Pay period does not exist";
				return $theResult;
			}
			
			/*now store dates
			  :: might be a potential for bugs
			*/
			$temp = $obj_result->result();
			$dateFrom = $temp[0]->START_DATE;
			$dateTo   = $temp[0]->END_DATE;			
		}else	//no payperiod specified but only dates inclusive
		{			
			if($dateFrom == NULL or $dateTo == NULL) 
			{
				$theResult["error_code"] = -1;
				$theResult["error_message"] = 'Date(s) is/are NULL.';
				return $theResult;
			}
		}
		
		/*
			now pull-all employees
			
			abe | 10may2011 2030 | i am making my own fetch all function so far
				since I'm not sure of Employee_model->Employee_getall()
		*/		
		$employees = $this->getAllEmployees()->result();		
		if( empty ($employees) )
		{			
			$theResult["error_code"] = -3;
			$theResult["error_message"] = "No employee so far.";
			return $theResult;
		}			
		
		foreach($employees as $emp_x)
		{								
			$tardiness_count = 0;		//initialize, in mins
			
			/*
			*	pull all records between the dates, inclusive,  specified for the employee
			*/					
			$daily_attendance = $this->pullAttendanceRecord($emp_x->empnum, $dateFrom, $dateTo)->result();
					
			foreach($daily_attendance as $daily_attendance_each_day)
			{																			
				//get shift id from it's table				
				$shift_info = $this->pullShiftInfo($daily_attendance_each_day->shift_id)->result();
				
				if( empty ($shift_info) )
				{
					$theResult["error_code"] = -4;
					$theResult["error_message"] = "INVALID SHIFT ID.";
					return $theResult;
				}
				
				/*
				*	if absence_reason is NULL, means person is not absent.
				*	and we only compute the late if start_time of that person for the day
				*	is later than what should be for his/her shift
				*/
				if( $daily_attendance_each_day->absence_reason == NULL
					and
					( $daily_attendance_each_day->time_in > $shift_info[0]->START_TIME) 
				)
				{
					$tardiness_count += ( strtotime($daily_attendance_each_day->time_in) - strtotime($shift_info[0]->START_TIME) );					
				}
			}//foreach daily_attendance...
			
			//at the end of sifting through the days, store it to some variable
			$emp_tardiness_result[$emp_x->empnum] = $tardiness_count; 
		}//foreach (employees
	
		
		//prep up the final results
		$theResult['result_array'] = $emp_tardiness_result;
		$theResult['error_code'] = 0;
		$theResult['error_message'] = 'success';
				
		return($theResult);
	}//getTardiness(..)
	
	function getAllEmployees()
	/*
		gets all employees from the employee table.
		 		 
		RETURNS: OBJECT containing the MySQL results or NULL, if no entry exists in the dB
	*/
	{
		$sql_x = "SELECT * from `employee`";			
		$obj_result = $this->db->query($sql_x);
		
		return $obj_result;
	}
	
	private function pullAttendanceRecord
	($empnum = NULL, $dateFrom = NULL, $dateTo = NULL)
	/*
		gets all attendance record of the employee specified for the periods specified.
		no more date checking here as this should be done in the calling functions.
		 
		RETURNS: OBJECT containing the MySQL results or NULL, if no entry exists in the dB
	*/
	{
		$sql_x = "SELECT * from `timesheet` WHERE `empnum` = ? AND `date_in` BETWEEN ? AND ?";
		$obj_result = $this->db->query($sql_x, array($empnum, $dateFrom, $dateTo) );
		
		return $obj_result;
	}
	
	private function pullShiftInfo($shiftId)
	/*	
		RETURNS: OBJECT containing the MySQL results or NULL, if no entry exists in the dB
	*/
	{
		$sql_x = "SELECT * from `shift` WHERE `ID` = ?";
		$obj_result = $this->db->query($sql_x, array($shiftId) );
		
		return $obj_result;
	}
	
	function insertComputation
	(
		$empnum, 
		$payperiod,
		$payment_mode,
		$monthly_rate,
		$daily_rate,
		$absences_and_lwop,
		$absences_and_lwop_amount,
		$vacation_and_sick_leave,
		$vacation_and_sick_leave_amount,
		$suspension,
		$suspension_amount,
		$tardiness_count,
		$tardiness_amount,
		$total_amount,
		$paid_vl_days,
		$paid_sl_days,
		$paid_emergency_leave_days,
		$timestamp,	//is it really needed?
		$currentUser					
	)
	{
		$sql_x = "INSERT INTO `payroll_absence` VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP,?)";
		$obj_result = $this->db->query($sql_x, array(
				$empnum, 
				$payperiod,
				$payment_mode,
				$monthly_rate,
				$daily_rate,
				$absences_and_lwop,
				$absences_and_lwop_amount,
				$vacation_and_sick_leave,
				$vacation_and_sick_leave_amount,
				$suspension,
				$suspension_amount,
				$tardiness_count,
				$tardiness_amount,
				$total_amount,
				$paid_vl_days,
				$paid_sl_days,
				$paid_emergency_leave_days,				
				$currentUser
			)		
		);
		
		return $obj_result;
	}//insertComputation

	function areAbsences_and_Late_Already_Generated($payperiod)
	{
		$sql_x =  "SELECT * from `payroll_absence` WHERE `payperiod` = ?";
		$obj_result = $this->db->query( $sql_x, array($payperiod) );
	
		return ($obj_result->num_rows != NULL || $obj_result->num_rows != 0);
	}
	
	function generateAbsences_and_Late($payment_mode, $payperiod, $defaultWorkingDays, $defaultHoursPerDay = 8)
	{
		/*
			abe | 11MAY2011 1335 | attention on $defaultWorkingDays - shouldn't it be included in `payperiod`?
			furtherwork:
			perform checking first if nasa dB na yung record:
				are there settings like: prompt, no, or overwrite?
		
			returns an array with the following structure and details
			
			['result'] = (boolean) TRUE|FALSE : if all successful, true, else false.
			['validation_errors'] = (array) 
						=> array with indexes ['ERROR_CODE'],['ERROR_TITLE'],['DESCRIPTION']
		*/
		$result_to_be_returned = array(
			"result" => false, "validation_errors" => array()		
		);
		
		/*
			.. under construction as of 12MAY2011
			
			TABLE OF ERRORS.
			
			101	-	NO_EMPLOYEE_EXISTS	- There is no single employee in the database.
			102	-	MISSING_ABSENCE_DETAILS - No attendance record for this employee exists.
			200 -	INSERTION_FINAL_ERROR - All details are computed, but there is something that failed while inserting.
			201 -   ABSENCES_AND_LATE_ALREADY - For this payperiod, absences and tardiness info have been already generated. If you want
												to generate again, clear all records first.
		
		*/
		
		if( $this->areAbsences_and_Late_Already_Generated($payperiod) )	// later, an 'overwrite?' condition should be considered
		{
			$result_to_be_returned["validation_errors"][] = array(
				'ERROR_CODE' => 201,
				'ERROR_TITLE' => "ABSENCES_AND_LATE_ALREADY",
				'DESCRIPTION' => "For this payperiod, absences and tardiness info have been already generated. If you want to generate again, clear all records first."			
			);
			die(var_dump($result_to_be_returned["validation_errors"]) );
		}		
		
		//get employee details first
		$employees_data = $this->Attendance_model->getAllEmployees()->result();

		if( empty ($employees_data) )
		{
			die('No employee so far.');
			//redirect('/errorWhatever');
		}
		
		$absences_data = $this->Attendance_model->getAbsences($payperiod, ``, ``);
		$tardiness_data = $this->Attendance_model->getTardiness($payperiod, ``, ``);		
		
		//check absences data
		if($absences_data['error_code'] != 0)
		{
			die("ABSENCES DATA ERROR: ".$absences_data['error_message']);
		}
		
		//check tardiness data first
		if($tardiness_data['error_code'] != 0)
		{
			die("tardiness DATA ERROR: ".$tardiness_data['error_message']);
		}
		
		foreach($employees_data as $employee_individual)
		{	
			$daily_rate;
			if($defaultWorkingDays == 0)
			{
				$daily_rate = -1;
			}else
			{
				//calculate daily rate
				
				if( (int) $payment_mode == 1 || $payment_mode == "SEMI-MONTHLY" )
				{
					$daily_rate = ($employee_individual->mrate / 2) / $defaultWorkingDays;	
				}else
				if( (int) $payment_mode == 2 || $payment_mode == "MONTHLY" )
				{
					$daily_rate = $employee_individual->mrate / $defaultWorkingDays;	
				}else
				{
					//later for this
				}
			}
			$absences_and_lwop = 0;
			$absences_and_lwop_amount = 0;
			
			$vacation_and_sick_leave = 0;
			$vacation_and_sick_leave_amount = 0;
			
			$suspension = 0;
			$suspension_amount = 0;
			
			$tardiness_count = 0;
			$tardiness_amount = 0;
			$total_amount = 0;
									
			$paid_vl_days = 0;
			$paid_sl_days = 0;
			$paid_emergency_leave_days = 0;
			
			//access the absences data got from calling the respective function in the model
			$this_employee_absence_data = $absences_data['result_array'][$employee_individual->empnum];
			
			//self-explanatory
			if( empty($this_employee_absence_data) || $this_employee_absence_data == NULL)
			{
				echo "No absence data for {$employee_individual->empnum}.";
				$result_to_be_returned['validation_errors'][] = array( 
					'ERROR_CODE' => 102,
					'ERROR_TITLE' => 'MISSING_ABSENCE_DETAILS',
					'DESCRIPTION' => 'For employee: {$employee_individual->empnum}'
				);
				//continue;
			}
						
			echo "<br/>EMPNUM: {$employee_individual->empnum}";			
			
			foreach($this_employee_absence_data as $this_employee_absence_data_x)
			{		
				switch($this_employee_absence_data_x['ABSENCE_REASON_CATEGORY'])
				{
					case '1': $absences_and_lwop += $this_employee_absence_data_x['VALUE'];
							  break;
					case '2': $vacation_and_sick_leave  += $this_employee_absence_data_x['VALUE']; 
							  break;
					case '3': $suspension += $this_employee_absence_data_x['VALUE'];
							  break;
					case '4': $paid_vl_days += $this_employee_absence_data_x['VALUE'];
							  break;
					case '5': $paid_sl_days += $this_employee_absence_data_x['VALUE'];
							  break;							  
					case '6': $paid_emergency_leave_days += $this_employee_absence_data_x['VALUE'];
							  break;							  
				}
			}//foreach absence data of an employee
							
			//now, compute for tardiness			
			if( isset ($tardiness_data['result_array'][$employee_individual->empnum]) )
			{
				$tardiness_count = $tardiness_data['result_array'][$employee_individual->empnum];
			}else
			{
				echo "No data for tardiness of {.$employee_individual->empnum}";
				//further error handling
			}
								
			/*
				COMPUTATION SECTION
			*/
			$absences_and_lwop_amount = $absences_and_lwop * $daily_rate;
			$vacation_and_sick_leave_amount = $vacation_and_sick_leave * $daily_rate;
			// if you are searching for suspension, it seems that it is not deductible.
			
			/*	abe | 12may2011
			*	isn't the computation of these supposed to change?	
			*/
			$tardiness_amount = ($daily_rate / $defaultHoursPerDay) * ($tardiness_count * 0.01);
			$total_amount = $absences_and_lwop_amount + $vacation_and_sick_leave_amount + 
							$suspension_amount + $tardiness_amount;
			
			/*
				DISPLAY RESULT SECTION. should be erased upon finalization.
			*/
			echo $daily_rate."|".($defaultHoursPerDay * $tardiness_count);
			echo "FOR ".$employee_individual->empnum."<br/>";
			echo "ABSENCES/LWOP: ".$absences_and_lwop."|".$absences_and_lwop_amount."<br/>";
			echo "VL/SL   : ".$vacation_and_sick_leave."|".$vacation_and_sick_leave_amount."<br/>";
			echo "Suspension: ".$suspension."|".$suspension_amount."<br/>";
			echo "Tardiness	   : ".$tardiness_count."|".$tardiness_amount."<br/>";			
			echo $this->login_model->getCurrentUser();
											
			$result_to_be_returned['result'] = $this->insertComputation
			(
				$employee_individual->empnum,
				$payperiod,
				$employee_individual->payment_mode,
				$employee_individual->mrate,
				$daily_rate,
				$absences_and_lwop,
				$absences_and_lwop_amount,
				$vacation_and_sick_leave,
				$vacation_and_sick_leave_amount,
				$suspension,
				$suspension_amount,
				$tardiness_count,
				$tardiness_amount,
				$total_amount,
				$paid_vl_days,
				$paid_sl_days,
				$paid_emergency_leave_days,				
				"",					//the constant CURRENT_TIMESTAMP is 'hardcoded' in the SQL statement
				$this->login_model->getCurrentUser()
			);
			
			$result_to_be_returned['validation_errors'][] = array( 
				'ERROR_CODE' => 200,
				'ERROR_TITLE' => 'INSERTION_FINAL_ERROR',
				'DESCRIPTION' => 'Cannot insert ATTENDANCE_FAULT_DATA for '.$employee_individual->empnum." ",
			);
			
			if( $result_to_be_returned['result'] )
			{
				 echo "Successfully inserted.";
			}else
			{
				echo "Failed to insert.";
			}
			
			echo 'reiterating...<br/><br/>';
		}//foreach(employees)
		
		return $result_to_be_returned;
	}//generateEverything
	
	function getCurrentDate_MySQL_Format()
	{
		/*
			made | abe | 15may2011_2350
		*/
		$my_time_in_PHP;
		$date_in_SQL;
		
		$my_time_in_PHP = getdate(date("U"));
				
		/* as of the MySQL version included in the current version 
			of WampServer used in the development of this app, the date format is
			YYYY-MM-DD, all numbers
		*/
		$date_in_SQL = "{$my_time_in_PHP['year']}-{$my_time_in_PHP['mon']}-{$my_time_in_PHP['mday']}";
		
		return $date_in_SQL;
	}
	
	function getCurrentDate_European_Union_Format()
	{
		/*
			made | abe | 16may2011_1600
		*/
		$my_time_in_PHP;
		$date_in_SQL;
		
		$my_time_in_PHP = getdate(date("U"));
						
		$date_in_SQL = "{$my_time_in_PHP['mday']}-{$my_time_in_PHP['month']}-{$my_time_in_PHP['year']}";
		
		return $date_in_SQL;
	}
	
	function isCurrentDate_on_a_payPeriod()
	{
		/*
			made | abe | 15may2011_2333
		*/			
		$obj_result = $this->Payperiod_model->pull_Payperiod_This_Date_Falls( $this->getCurrentDate_MySQL_Format() ) ;
		
		if( $obj_result->num_rows == 0 || $obj_result == null )	
			return false;
		else
			return true;			
	}
				
	function deleteAttendanceFaultData_thisPayPeriod( $payperiod )
	{
		/*		
			made | abe | 16may2011_0045
			
		RETURNS: BOOLEAN indicating if the query has been successful
		*/
		
		$sql_x = "delete FROM `payroll_absence` WHERE `payperiod` = ? ";		
		$obj_result = $this->db->query( $sql_x, array($payperiod) );
		
		return $obj_result;
	}
	
	function getPaymentModes()
	{
		/*
		
			returns NULL if no content gotten from dB
			else    ARRAY of the rows in the dB
		*/
		$sql_x = "SELECT * FROM `payment_mode` ORDER BY `id` ASC";
		$rows_result = $this->db->query( $sql_x, array() )->result();
		
		if( empty($rows_result) ) 
		{
			return NULL;
		}else
		{
			return $rows_result;
		}
	}
	
}//class

/* End of file Attendance_model.php */
/* Location: ./application/model/Attendance_model.php */