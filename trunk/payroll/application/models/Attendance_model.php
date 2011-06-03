<?php

class Attendance_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Payperiod_model');
		$this->load->model('ErrorReturn_model');
	}

	function getAbsences
	( $payperiod = NULL, $dateFrom = NULL, $dateTo = NULL, $payment_mode = NULL )
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
			if($dateFrom == NULL or $dateTo == NULL) return $this->ErrorReturn_model->createSingleError(453, NULL, NULL);			
		}
		
		/*			now pull-all employees
			
			abe | 10may2011 2030 | i am making my own fetch all function so far
				since I'm not sure of Employee_model->Employee_getall()
		*/		
		$employees = $this->getAllEmployees($payment_mode)->result();	
		
		if( empty ($employees) ) return $this->ErrorReturn_model->createSingleError(101, NULL, NULL);			
	
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
	( $payperiod = NULL, $dateFrom = NULL, $dateTo = NULL, $payment_mode = NULL )
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
			
			if($obj_result->num_rows == 0)return $this->ErrorReturn_model->createSingleError(407, NULL, NULL);			
			
			/*now store dates
			  :: might be a potential for bugs
			*/
			$temp = $obj_result->result();
			$dateFrom = $temp[0]->START_DATE;
			$dateTo   = $temp[0]->END_DATE;			
		}else	//no payperiod specified but only dates inclusive
		{			
			if($dateFrom == NULL or $dateTo == NULL) return $this->ErrorReturn_model->createSingleError(453, NULL, NULL);			
		}
		
		/*
			now pull-all employees
			
			abe | 10may2011 2030 | i am making my own fetch all function so far
				since I'm not sure of Employee_model->Employee_getall()
		*/		
		$employees = $this->getAllEmployees($payment_mode)->result();		
		if( empty ($employees) ) return $this->ErrorReturn_model->createSingleError(101, NULL, NULL);			
		
		foreach($employees as $emp_x)
		{								
			$tardiness_count = 0;		//initialize, in mins
			
			/*
			*	pull all records between the dates, inclusive,  specified for the employee
			*/					
			$daily_attendance = $this->pullAttendanceRecord($emp_x->empnum, $dateFrom, $dateTo)->result();
			
			foreach($daily_attendance as $daily_attendance_each_day)
			{																			
				//get shift id from its table				
				$shift_info = $this->pullShiftInfo($daily_attendance_each_day->shift_id)->result();
				
				if( empty ($shift_info) )
				{
					$theResult["error_code"] = -4;
					$theResult["error_message"] = "INVALID SHIFT ID.";
					return $theResult;
				}
								
				/*
				*	if absence_reason is 0, means person is not absent.
				*	and we only compute the late if start_time of that person for the day
				*	is later than what should be for his/her shift
				*/				
				if( ( $daily_attendance_each_day->absence_reason == NULL 
					  or $daily_attendance_each_day->absence_reason == '0')
					and
					( strtotime($daily_attendance_each_day->time_in) > strtotime($shift_info[0]->START_TIME) ) 
				)
				{	
					$today_tardiness = ( ( strtotime($daily_attendance_each_day->time_in) - strtotime($shift_info[0]->START_TIME) ) / 60 );					
					$this->update_Today("TARDINESS", $daily_attendance_each_day, "MIN", $today_tardiness);
					$tardiness_count += $today_tardiness;
					
				}								
			}//foreach daily_attendance...
			
			//at the end of sifting through the days, store it to some variable
			$emp_tardiness_result[$emp_x->empnum] = $tardiness_count; 									
		}//foreach (employees
			
		//prep up the final results
		$theResult['result_array'] = $emp_tardiness_result;
		$theResult['error_code'] = 0;
		$theResult['error_message'] = 'SUCCESS';
				
		return($theResult);
	}//getTardiness(..)
	
	function getAllEmployees($payment_mode = 1)
	/*
		gets all employees from the employee table.

			
		RETURNS: OBJECT containing the MySQL results or NULL, if no entry exists in the dB
	*/
	{
		$sql_x = "SELECT * from `employee` WHERE `payment_mode` = ?";			
		$obj_result = $this->db->query($sql_x, array($payment_mode) );
		
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

	function areAbsences_and_Late_Already_Generated($payperiod, $payment_mode)
	{
		/*
			abe | 18may2011 | changed | added 2nd param
			abe | 20may2011_1059 | changed | fixed return logic
		*/
		
		$sql_x =  "SELECT * from `payroll_absence` WHERE `payperiod` = ? and `payment_mode` = ?";
		$obj_result = $this->db->query( $sql_x, array($payperiod, $payment_mode) );
		
		return ($obj_result->num_rows != 0);
	}
	
	function generateAbsences_and_Late($payment_mode, $payperiod, $defaultWorkingDays, $defaultHoursPerDay = 8)
	{
		/*
			abe | 11MAY2011 1335 | attention on $defaultWorkingDays - shouldn't it be included in `payperiod`?
				| 23MAY2011_1423 | now done to include UT, OT and night diff
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
		
		if( $this->areAbsences_and_Late_Already_Generated($payperiod, $payment_mode) )	// later, an 'overwrite?' condition should be considered
		{
			$result_to_be_returned["validation_errors"][] = array(
				'ERROR_CODE' => 201,
				'ERROR_TITLE' => "ABSENCES_AND_LATE_ALREADY",
				'DESCRIPTION' => "For this payperiod, absences and tardiness info have been already generated. If you want to generate again, clear all records first."			
			);
			die(var_dump($result_to_be_returned["validation_errors"]) );
		}		
		
		//get employee details first
		$employees_data = $this->getAllEmployees($payment_mode)->result();

		if( empty ($employees_data) )
		{
			die('No employee so far.');
			//redirect('/errorWhatever');
		}
		
		//get payperiod obj, i don't think we need trouble shooting here
		$payperiod_obj = $this->Payperiod_model->pull_PayPeriod_Info($payperiod)->result();
																
		$absences_data = $this->getAbsences($payperiod, ``, ``, $payment_mode);
		$tardiness_data = $this->getTardiness($payperiod, ``, ``, $payment_mode);		
		/*
			These parts added 24MAY2011_2339, no need to assign to something as of the moment
		*/
		$this->get_OverTime($payperiod, $payment_mode);
		$this->get_UnderTime($payperiod, $payment_mode);
		$this->get_NightDifferential($payperiod, $payment_mode);
		$OT_and_ND_data = $this->generate_OT_and_ND_Cost($payperiod, $payment_mode);
		
		
		
		
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
				
				if( $payment_mode == '1' or $payment_mode == "SEMI-MONTHLY" )
				{
					$daily_rate = ($employee_individual->mrate / 2) / $defaultWorkingDays;	
				}else
				if( $payment_mode == '2' or $payment_mode == "MONTHLY" )
				{
					$daily_rate = $employee_individual->mrate / 22;	
				}else
				{
					//later for this
				}
			}
			$daily_rate = round($daily_rate, 2);
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
			$absences_and_lwop_amount = round($absences_and_lwop * $daily_rate, 2);
			$vacation_and_sick_leave_amount = round($vacation_and_sick_leave * $daily_rate, 2);
			$suspension_amount = round($suspension * $daily_rate, 2);
			
			
			/*	abe | 12may2011
			*	isn't the computation of these supposed to change?	
			*/
			$tardiness_amount = round(($daily_rate / $defaultHoursPerDay) * ($tardiness_count * 0.01), 2);
			$total_amount = $absences_and_lwop_amount + $vacation_and_sick_leave_amount + $suspension_amount 
							+ $tardiness_amount;
									
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
				"",					//the constant CURRENT_TIMESTAMP is 'hardcoded' in the SQL statement in function insertComputation(..)
				$this->login_model->getCurrentUser()
			);
			
			
			
			if( $result_to_be_returned['result'] == FALSE )			
			{
				$result_to_be_returned['validation_errors'][] = array( 
				'ERROR_CODE' => 200,
				'ERROR_TITLE' => 'INSERTION_FINAL_ERROR',
				'DESCRIPTION' => 'Cannot insert ATTENDANCE_FAULT_DATA for '.$employee_individual->empnum." ",
				);
			}			
			
			

			/*
				NOW for OVERTIME and NIGHT_DIFF
			*/						
			$sql_x = "UPDATE `salary` SET `Overtime`=?,`NightDifferential`=?,`AbsencesTardiness`=? WHERE `start_date` = ? AND `end_date` = ? AND `EmployeeNumber` =?";
			
			$OT_ND_Query_Result = $this->db->query( $sql_x, array(
					$OT_and_ND_data['result_array'][$employee_individual->empnum]['overtime']['amount'],
					$OT_and_ND_data['result_array'][$employee_individual->empnum]['night_diff']['amount'],
					$total_amount,
					$payperiod_obj[0]->START_DATE,
					$payperiod_obj[0]->END_DATE,
					$employee_individual->empnum
				)//end of array..
			);
			
			if( $OT_ND_Query_Result == FALSE )			
			{
				$result_to_be_returned['validation_errors'][] = array( 
				'ERROR_CODE' => 200,
				'ERROR_TITLE' => 'INSERTION_FINAL_ERROR',
				'DESCRIPTION' => 'Cannot insert OVERTIME AND NIGHT_DIFF for '.$employee_individual->empnum." ",
				);
			}
			
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
			
	function convert_Date_To_EU_Format($date)
	{
		/*	made | abe | 18MAY2011_1413
			
			ACCEPTS ONLY date in the format 'YYYY-MM-DD', all numbers
			
			returns NULL if string submitted has anomaly. 
			
			returns STRING date in 'DD-MMM-YYYY' format where MMM is the first 3 letters of months.
		*/
		$returnThis = array('result' => false, 'ERROR_CODE' => NULL, 'ERROR_TITLE' => NULL, 'ERROR_MESSAGE' => NULL);
		
		if( strlen($date) !=  10 )
		{
			$returnThis['ERROR_CODE'] = '700';
			$returnThis['ERROR_TITLE'] = 'INVALID_DATE_FORMAT_INSUFFICIENT_DIGITS';
			$returnThis['ERROR_MESSAGE'] = 'The date submitted should be composed exactly of 10 characters.';
			die($returnThis);
		}		
		$date[4] = $date[7] = '-';
		$month=array(
            '01'=>'JAN',
            '02'=>'FEB',
            '03'=>'MAR',
            '04'=>'APR',
            '05'=>'MAY',
            '06'=>'JUN',
            '07'=>'JUL',
            '08'=>'AUG',
            '09'=>'SEP',
            '10'=>'OCT',
            '11'=>'NOV',
            '12'=>'DEC'
		);
		list($sql_year, $sql_month, $sql_day) = explode('-', $date);
		$month_in_word = $month[$sql_month];
		
		return($sql_day."-".$month_in_word."-".$sql_year);		
	}
	
	
	function isCurrentDate_on_a_payPeriod($payment_mode = 1)
	{
		/*
			made | abe | 15may2011_2333
		*/			
		$obj_result = $this->Payperiod_model->pull_Payperiod_This_Date_Falls( $this->getCurrentDate_MySQL_Format(), $payment_mode ) ;
		
		if( $obj_result->num_rows == 0 || $obj_result == null )	
			return false;
		else
			return true;			
	}
				
	function deleteAttendanceFaultData_thisPayPeriod( $payperiod, $payment_mode )
	{
		/*		
			made | abe | 16may2011_0045
			
		RETURNS: BOOLEAN indicating if the query has been successful
		*/
		
		$sql_x = "DELETE FROM `payroll_absence` WHERE `payperiod` = ? and `payment_mode` = ? ";		
		$obj_result = $this->db->query( $sql_x, array($payperiod, $payment_mode) );
		
		return $obj_result;
	}
	
	function getPaymentModes()
	{
		/*	
			returns NULL if no content gotten from dB
			else  ASSOCIATIVE  ARRAY of the rows in the dB
		*/
		
		$sql_x = "SELECT * FROM `payment_mode` ORDER BY `id` ASC";
		$rows_result = $this->db->query( $sql_x, array() )->result();
		$returnThis = array();
		
		if( empty($rows_result) ) 
		{
			return NULL;
		}else
		{
			foreach($rows_result as $x)
			{
				$returnThis[$x->ID] = $x;
			}
			return $returnThis;
		}
	}
	
	function getAbsenceReasons()
	{
		/*
			made | abe | 17MAY2011_2331
			
			returns NULL if no content gotten from dB
			else    ARRAY of the rows in the dB
		*/
		$sql_x = "SELECT * FROM `absence_reason` ORDER BY `id` ASC";
		$rows_result = $this->db->query( $sql_x, array() )->result();
		
		$returnThisArray = array();
		
		if( empty($rows_result) ) 
		{
			die("ABSENCE REASONS are empty. Please fill it out first.");
			//return NULL;
		}
		
		foreach($rows_result as $indiv)
		{
			$returnThisArray[$indiv->ID] = $indiv;
		}
		
		return $returnThisArray;
	}
	
	function getAbsenceReasonCategory()
	{
		/*
			made | abe | 18MAY2011_1142
			
			returns NULL if no content gotten from dB
			else    ARRAY of the rows in the dB
		*/
		$sql_x = "SELECT * FROM `absence_reason_category` ORDER BY `id` ASC";
		$rows_result = $this->db->query( $sql_x, array() )->result();
		
		$returnThisArray = array();
		
		if( empty($rows_result) ) 
		{
			die("ABSENCE REASONS CATEGORY are empty. Please fill it out first.");
			//return NULL;
		}
		
		foreach($rows_result as $indiv)
		{
			$returnThisArray[$indiv->ID] = $indiv;
		}
		
		return $returnThisArray;
	}
	
	function areThere_AbsenceAndTardiness_of_Employee_during_Payperiod($empnum = NULL, $payperiod_obj)
	{
		/*
			abe | made | 19MAY2011_1333 |
			
			RETURNS BOOLEAN TRUE|FALSE
		*/
		
		if( 
			$empnum == NULL  or $payperiod_obj == NULL
		)
		{
			die("areThere_AbsenceAndTardiness_of_Employee_during_Payperiod: NO EMPLOYEE/PAYMENT_MODE/PAYPERIOD SUBMITTED.");
		}
				
		$sql_x = "SELECT * FROM `timesheet` WHERE  `empnum` = ? AND `date_in` >= ? AND `date_in` <= ?";
		$obj_result = $this->db->query($sql_x, array($empnum, $payperiod_obj->START_DATE, $payperiod_obj->END_DATE) );
		 
		return ($obj_result->num_rows != 0);
	}
	
	function getAttendanceFaults($payperiod, $payment_mode)
	{
		/*
			abe | made | 20MAY2011_1147
		*/
		
		$sql_x = "SELECT * FROM `payroll_absence` WHERE `payperiod` = ? AND `payment_mode` = ?";
		$rows_result = $this->db->query($sql_x, array($payperiod, $payment_mode) )->result();

		return $rows_result;
	}
	
	function computeTotal_AttendanceFaults($data)
	{
		/*
			abe | made | 20MAY2011_1149
	
			COMPUTES FOR THE SUM OF THE 'SUMMABLE' items
			during a payperiod
		*/
		$theData = array(
			'absences_lwop_days' => array( 'title' => "Absences and Leave without Pay Days"  , 'value' => (float) 0.0 ),
			'absences_lwop_amount' => array( 'title' => "Absences and Leave without Pay Amount" , 'value' => (float) 0.0),
			'leave_sick_vacation_days' => array( 'title' => "Sick and Vacation Leave Days ", 'value' => (float) 0.0),
			'leave_sick_vacation_amount' => array( 'title' => "Sick and Vacation Leave Amount" , 'value' => (float) 0.0),
			'suspension_days' => array( 'title' => "Suspension Days" , 'value' => (float) 0.0),
			'suspension_amount' => array ( 'title' => "Suspension  Amount" , 'value' =>(float) 0.0),
			'tardiness_min' => array( 'title' => "Tardiness in Minutes " , 'value' => (float) 0.0),
			'tardiness_amount' => array( 'title' => "Total Tardiness Amount" , 'value' => (float) 0.0),
			'total_amount' => array( 'title' => "Total Amount of Productivity Lost" , 'value' => (float) 0.0),
			'paid_vl_days' => array( 'title' => "Total Paid Vacation Leave Days"  , 'value' => (float) 0.0),
			'paid_sl_days' => array( 'title' => "Total Paid Sick Leave Days" , 'value' => (float) 0.0),
			'paid_emergency_leave_days' => array( 'title' => "Total Paid Emergency Leave Days" , 'value' => (float) 0.0)
		);
		
		if( (isset($data) and !empty($data) ) == FALSE )
		{
			return array();
		}

		foreach($data as $each_employee_data)
		{			
			$theData['absences_lwop_days']['value'] += round(floatval($each_employee_data->absences_lwop_days), 2);
			$theData['absences_lwop_amount']['value'] += round(floatval($each_employee_data->absences_lwop_amount), 2);
			$theData['leave_sick_vacation_days']['value'] += round(floatval($each_employee_data->leave_sick_vacation_days), 2);
			$theData['leave_sick_vacation_amount']['value'] += round(floatval($each_employee_data->leave_sick_vacation_amount), 2);
			$theData['suspension_days']['value'] += round(floatval($each_employee_data->suspension_days), 2);
			$theData['suspension_amount']['value'] += round(floatval($each_employee_data->suspension_amount), 2);
			$theData['tardiness_min']['value'] += round(floatval($each_employee_data->tardiness_min), 2);
			$theData['tardiness_amount']['value'] += round(floatval($each_employee_data->tardiness_amount), 2);
			$theData['total_amount']['value'] += round(floatval($each_employee_data->total_amount), 2);
			$theData['paid_vl_days']['value'] += round(floatval($each_employee_data->paid_vl_days), 2);
			$theData['paid_sl_days']['value'] += round(floatval($each_employee_data->paid_sl_days), 2);
			$theData['paid_emergency_leave_days']['value'] += round(floatval($each_employee_data->paid_emergency_leave_days), 2);		
		}
		
		return $theData;
	}
			
	function update_Today($whatField, $theTimeSheetObject, $passed_is_what = "MIN", $theNumber)
	{
	/*
		made | abe | 23MAY2011_1112H
		
		PARAMETERS:
		$whatField - what field of the row to be updated may take on: tardiness|undertime|overtime|night_diff
		$theTimeSheetObject - the row concerned. this contains the data where we want to insert $theNumber
		$passed_is_what - is $theNumber in MIN|HRS|SEC?
		$theNumber - should be integer.
	*/
	
		$theResult = array(
			"result" => false,
			"ERROR_CODE" => NULL,
			"ERROR_TITLE" => NULL,
			"ERROR_MESSAGE" => NULL
		);
		
		$updateThisField = "";		
		if($theTimeSheetObject == NULL)
		{
			$theResult['ERROR_CODE'] = 410;
			$theResult['ERROR_TITLE'] = "NON_EXISTENT_TIMESHEET";
			$theResult['ERROR_MESSAGE'] = "You have tried to update a TIMESHEET that does not exist.";
			return $theResult;
		}
	
		switch(strtoupper($whatField))
		{
			case "TARDINESS"	: $updateThisField = "tardiness" ; break;
			case "UNDERTIME"	: $updateThisField = "undertime" ; break;
			case "OVERTIME"		: $updateThisField = "overtime" ; break;
			case "NIGHT_DIFF"	: $updateThisField = "night_diff" ; break;
			default:	
				$theResult['ERROR_CODE'] = 0x000;
				$theResult['ERROR_TITLE'] = "UNKNOWN_FIELD";
				$theResult['ERROR_MESSAGE'] = "You have tried to update a field that does not exist.";
				die($theResult);
				return $theResult;
		}
		$sql_x = "UPDATE `timesheet` SET `".$updateThisField."` = ? WHERE `timesheet`.`id` = ?";		
				
		$theResult['result'] = $this->db->query($sql_x, array( $this->convert_to_Time($passed_is_what, $theNumber), $theTimeSheetObject->id) );	
		return $theResult;
	}
	
	function convert_to_Time($passed_is_what, $theTimeCount)
	{
		/*
		made | abe | 23MAY2011_1122H
		
			PARAMETERS:
			
			$passed_is_what = string, takes on "MIN|SEC|HRS"
			$theTimeCount = self-explanatory
			
			RETURNS TIME FORMAT IN STRING: HH:MM:SS
		*/
		$hours = 0;
		$mins = 0;
		$secs = 0;
		$returnThisTime = 0;
		
		switch(strtoupper($passed_is_what))
		{
			case "HRS"	: 
				$secs = $theTimeCount *= 3600;
			case "MIN"	: 				
				$secs = $theTimeCount *= 60;			
			case "SEC"	: 
				$secs = $theTimeCount;
				$hours = floor($secs / 3600);
				$secs = $secs % 3600;
				$mins = floor($secs / 60);
				$secs = $secs % 60; 				
				break;										
			default:					
				return "00:00:00";
		}						
				
		return $hours.":".$mins.":".$secs;
	}
	
	function get_OverTime
	( $payperiod = NULL, $payment_mode = NULL)
	{
		/*
			abe | made | 23MAY2011_1216
			for this, ditched the DateFrom and DateTo options, only $payperiod considered
		*/
		
		$employee_OT_count = NULL;
		$employee_OT_amount = 0;
		$employee_OT_Data = array();
		
		$theResult = array("error_code" => NULL,
						   "error_message" => NULL,
							"result_array" => NULL
		);
		
		if($payperiod == NULL || $payment_mode == NULL)
		{
			$theResult["error_code"] = -1;
			$theResult["ERROR_MESSAGE"] = "PAYPERIOD/PAYMENT_MODE NOT SPECIFIED";
			return $theResult;
		}
		
		//get date inclusives during the payperiod specified from database			
		$obj_result = $this->Payperiod_model->pull_PayPeriod_Info($payperiod);
							
		if($obj_result->num_rows == 0)
		{
			$theResult["error_code"] = -2;
			$theResult["error_message"] = "Pay period does not exist";
			return $theResult;
		}
		$payperiod_obj = $obj_result->result();
		
		/*			now pull-all employees
			
			abe | 10may2011 2030 | i am making my own fetch all function so far
				since I'm not sure of Employee_model->Employee_getall()
		*/		
		$employees = $this->getAllEmployees($payment_mode)->result();		
		if( empty ($employees) )
		{			
			$theResult["error_code"] = -3;
			$theResult["error_message"] = "No employee so far.";
			return $theResult;
		}		
					
		foreach($employees as $emp_x)
		{								
			$overtime_count = 0;		//initialize, in mins
			$overtime_amount = 0;
						
			/*
			*	pull all records between the dates, inclusive,  specified for the employee
			*/								
			$daily_attendance = $this->pullAttendanceRecord($emp_x->empnum, $payperiod_obj[0]->START_DATE, $payperiod_obj[0]->END_DATE)->result();
			
			foreach($daily_attendance as $daily_attendance_each_day)
			{																									
				//get shift id from its table				
				$shift_info = $this->pullShiftInfo($daily_attendance_each_day->shift_id)->result();				
				if( empty ($shift_info) )
				{
					$theResult["error_code"] = -4;
					$theResult["error_message"] = "INVALID SHIFT ID.";
					die(var_dump($theResult));
					//return $theResult;
				}
								
				/*
				*	if absence_reason is 0, means person is not absent.
				*
				*/										
				if( ( $daily_attendance_each_day->absence_reason == NULL 
					  or $daily_attendance_each_day->absence_reason == '0')
					and
					( strtotime($daily_attendance_each_day->time_out) > strtotime($shift_info[0]->END_TIME)  ) 
				)
				{						
					$overtime_today = ( strtotime($daily_attendance_each_day->time_out) - strtotime($shift_info[0]->END_TIME)) / 60 ;									
					$this->update_Today("OVERTIME", $daily_attendance_each_day, "MIN", $overtime_today);
					$overtime_count += $overtime_today;				
				}								
			}//foreach daily_attendance...
			
			//at the end of sifting through the days, store it to some variable			
			$employee_OT_Data[$emp_x->empnum]['count'] = $overtime_count;											
		}//foreach (employees
				
		$theResult['result_array'] = $employee_OT_Data;
		$theResult['error_code'] = 0;
		$theResult['error_message'] = 'SUCCESS';		
		return $theResult;
	}
			
	function get_UnderTime
	( $payperiod = NULL, $payment_mode = NULL)
	{
		/*
			abe | made | 23MAY2011_1316
			for this, ditched the DateFrom and DateTo options, only $payperiod considered
		*/
		
		$employee_UT_count = NULL;
		$employee_UT_Data = array();
		
		$theResult = array("error_code" => NULL,
						   "error_message" => NULL,
							"result_array" => NULL
		);
		if($payperiod == NULL || $payment_mode == NULL)
		{
			$theResult["error_code"] = -1;
			$theResult["ERROR_MESSAGE"] = "PAYPERIOD/PAYMENT_MODE NOT SPECIFIED";
			return $theResult;
		}
		
		//get date inclusives during the payperiod specified from database			
		$obj_result = $this->Payperiod_model->pull_PayPeriod_Info($payperiod);
							
		if($obj_result->num_rows == 0)
		{
			$theResult["error_code"] = -2;
			$theResult["error_message"] = "Pay period does not exist";
			return $theResult;
		}
		$payperiod_obj = $obj_result->result();
		
		/*			now pull-all employees
			
			abe | 10may2011 2030 | i am making my own fetch all function so far
				since I'm not sure of Employee_model->Employee_getall()
		*/		
		$employees = $this->getAllEmployees($payment_mode)->result();		
		if( empty ($employees) )
		{			
			$theResult["error_code"] = -3;
			$theResult["error_message"] = "No employee so far.";
			return $theResult;
		}		
					
		foreach($employees as $emp_x)
		{								
			$undertime_count = 0;		//initialize, in mins
			
			/*
			*	pull all records between the dates, inclusive,  specified for the employee
			*/								
			$daily_attendance = $this->pullAttendanceRecord($emp_x->empnum, $payperiod_obj[0]->START_DATE, $payperiod_obj[0]->END_DATE)->result();
			
			foreach($daily_attendance as $daily_attendance_each_day)
			{																			
				//get shift id from its table				
				$shift_info = $this->pullShiftInfo($daily_attendance_each_day->shift_id)->result();			
				if( empty ($shift_info) )
				{
					$theResult["error_code"] = -4;
					$theResult["error_message"] = "INVALID SHIFT ID.";
					die(var_dump($theResult));
					//return $theResult;
				}
								
				/*
				*	if absence_reason is 0, means person is not absent.
				*	and we only compute the late if start_time of that person for the day
				*	is later than what should be for his/her shift
				*/								
				if( ( $daily_attendance_each_day->absence_reason == NULL 
					  or $daily_attendance_each_day->absence_reason == '0')
					and
					( strtotime($daily_attendance_each_day->time_out) < strtotime($shift_info[0]->END_TIME)  ) 
				)
				{						
					$undertime_today = ( strtotime($shift_info[0]->END_TIME) - strtotime($daily_attendance_each_day->time_out)) / 60 ;					
					$this->update_Today("UNDERTIME", $daily_attendance_each_day, "MIN", $undertime_today);
					$undertime_count += $undertime_today;					
					
				}								
			}//foreach daily_attendance...
			
			//at the end of sifting through the days, store it to some variable			
			$employee_OT_Data[$emp_x->empnum] = $undertime_count;								
		}//foreach (employees
				
		$theResult['result_array'] = $employee_OT_Data;
		$theResult['error_code'] = 0;
		$theResult['error_message'] = 'SUCCESS';
			
		return $theResult;
	}
	
	function generate_OT_and_ND_Cost
	( $payperiod = NULL, $payment_mode = NULL)
	{
		/*
			made | abe | 24may2011_1516
		*/
		if($payperiod == NULL || $payment_mode == NULL)
		{
			$theResult["error_code"] = -1;
			$theResult["ERROR_MESSAGE"] = "PAYPERIOD/PAYMENT_MODE NOT SPECIFIED";
			return $theResult;
		}
		
		//get date inclusives during the payperiod specified from database			
		$obj_result = $this->Payperiod_model->pull_PayPeriod_Info($payperiod);
							
		if($obj_result->num_rows == 0)
		{
			$theResult["error_code"] = -2;
			$theResult["error_message"] = "Pay period does not exist";
			return $theResult;
		}
		$payperiod_obj = $obj_result->result();
		
		/*	now pull-all employees
			
			abe | 10may2011 2030 | i am making my own fetch all function so far
				since I'm not sure of Employee_model->Employee_getall()
		*/		
		$employees = $this->getAllEmployees($payment_mode)->result();		
		if( empty ($employees) )
		{			
			$theResult["error_code"] = -3;
			$theResult["error_message"] = "No employee so far.";
			die($theResult);
			return $theResult;
		}		
					
		foreach($employees as $emp_x)
		{								
			$emp_OT_amount = 0;
			$emp_OT_count = 0;
			$emp_ND_amount = 0;
			$emp_ND_count = 0;
			/*
			*	pull all records between the dates, inclusive,  specified for the employee
			*/								
			$daily_attendance = $this->pullAttendanceRecord($emp_x->empnum, $payperiod_obj[0]->START_DATE, $payperiod_obj[0]->END_DATE)->result();
			
			foreach($daily_attendance as $daily_attendance_each_day)
			{					
				//get shift id from its table				
				$shift_info = $this->pullShiftInfo($daily_attendance_each_day->shift_id)->result();			
				if( empty ($shift_info) )
				{
					$theResult["error_code"] = -4;
					$theResult["error_message"] = "INVALID SHIFT ID.";
					die(var_dump($theResult));
					//return $theResult;
				}
								
				/*
				*	if absence_reason is 0, means person is not absent.				
				*/						
				if( ($daily_attendance_each_day->absence_reason == NULL 
					  or $daily_attendance_each_day->absence_reason == '0')
					 and
					 ( $daily_attendance_each_day->overtime_rate != '0' )
				)									
				{	
					$OT_recipient_var = $this->generate_OT_Cost_Proper($daily_attendance_each_day->overtime_rate, $payperiod_obj, $emp_x->empnum, $daily_attendance_each_day, $shift_info[0]);				
					$ND_recipient_var = $this->generate_ND_Cost_Proper($payperiod_obj, $emp_x->empnum, $daily_attendance_each_day, $shift_info[0]);				
					$emp_OT_amount += $OT_recipient_var['amount'];
					$emp_OT_count  += $OT_recipient_var['count'];
					$emp_ND_amount += $ND_recipient_var['amount'];
					$emp_ND_count  += $ND_recipient_var['count'];
				}								
			}//foreach daily_attendance...
			
			//at the end of sifting through the days, store it to some variable		
			
			$employee_OT_Data[$emp_x->empnum]['overtime']['amount'] = $emp_OT_amount;
			$employee_OT_Data[$emp_x->empnum]['overtime']['count'] = $emp_OT_count;
			$employee_OT_Data[$emp_x->empnum]['night_diff']['amount'] = $emp_ND_amount;
			$employee_OT_Data[$emp_x->empnum]['night_diff']['count'] = $emp_ND_count;
		}//foreach (employees
				
		$theResult['result_array'] = $employee_OT_Data;
		$theResult['error_code'] = 0;
		$theResult['error_message'] = 'SUCCESS';
		
		/*foreach($employee_OT_Data as $x)
		{
			echo var_dump($x);
		}*/		
		return $theResult;
	}
	
	function generate_OT_Cost_Proper($OT_rate_id = NULL, $payperiod_obj, $empnum, $daily_attendance_each_day, $shift_obj)
	{
		/*
			made | abe | 24MAY2011_1413
			PARAMS:			
		*/
		$thisOT['amount'] = 0;
		$thisOT['count'] = 0;
		$OT_duration_float = 0;
		$ND_duration_float = 0;
		$mixed_durations = 0;
		$dailyHours = 0;
		
		if($OT_rate_id == NULL || $payperiod_obj == NULL )
		{
			die("generate_OTND_Cost_Proper: NO PP or OT_RATE_ID specified");
		}
				
		$sql_x = "SELECT * FROM `overtime_rates` where `ID` = ?"; 
		$OTND_rows = $this->db->query($sql_x, array($OT_rate_id) )->result();
		
		$sql_x = "SELECT * FROM `salary` where `start_date` = ? and `end_date` = ? and `EmployeeNumber` = ?" ;
		$SALARY_ROW = $this->db->query($sql_x, array($payperiod_obj[0]->START_DATE, $payperiod_obj[0]->END_DATE, $empnum) )->result();
		
		if(empty($SALARY_ROW))
		{
			echo("NO SALARY ROW FOR {$empnum}");
		}
		
		/*
			COMPUTATION SECTION!!!
		*/
		$OT_duration_float = round($this->thisTime_in_Float($daily_attendance_each_day->overtime ), 2);		
		$thisOT['count']  = $OT_duration_float;
		$dailyHours    = round($this->differenceTime_in_Float($shift_obj->START_TIME, $shift_obj->END_TIME, intval($shift_obj->OVERFLOW) ), 2);
		$dailyRate	   = round( floatval($SALARY_ROW[0]->DailyRate) , 2);
		$thisOT['amount'] = ($dailyRate/$dailyHours ) * ($OT_duration_float) * floatval($OTND_rows[0]->MUL_FACTOR);			
		$thisOT['amount'] = round($thisOT['amount'], 2);
		
		return $thisOT;
	}
	
	function generate_ND_Cost_Proper($payperiod_obj, $empnum, $daily_attendance_each_day, $shift_obj)
	{
		/*
			made | abe | 24MAY2011_1413
			PARAMS:			
		*/
		$thisND['amount'] = 0;
		$thisND['count'] = 0;		
		$ND_duration_float = 0;		
		$dailyHours = 0;
		
		if( $payperiod_obj == NULL )
		{
			die("generate_ND_Cost_Proper: NO PP specified");
		}
								
		$sql_x = "SELECT * FROM `salary` where `start_date` = ? and `end_date` = ? and `EmployeeNumber` = ?" ;
		$SALARY_ROW = $this->db->query($sql_x, array($payperiod_obj[0]->START_DATE, $payperiod_obj[0]->END_DATE, $empnum) )->result();
		if(empty($SALARY_ROW))
		{
			echo("NO SALARY ROW FOR {$empnum}");
		}
		
		$night_diff_rate = $this->db->query("SELECT * FROM `variables` WHERE `Name` = 'NIGHT_DIFF_RATE'")->result();
		if( empty($night_diff_rate) )
		{
			die("CRITICAL ERROR!!! NIGHT_DIFF_RATE is missing in `variables`");
		}
		if( !(floatval($night_diff_rate[0]->Value) >= 0) )
		{
			die("CRITICAL ERROR!!! NIGHT_DIFF_RATE must be greater than or equal to zero.");
		}
		
		/*
			COMPUTATION SECTION!!!
		*/	
		$ND_duration_float = round($this->thisTime_in_Float( $daily_attendance_each_day->night_diff), 2);		
		$thisND['count']   = $ND_duration_float;
		$dailyHours    = round($this->differenceTime_in_Float($shift_obj->START_TIME, $shift_obj->END_TIME, intval($shift_obj->OVERFLOW) ), 2);
		$dailyRate	   = round( floatval($SALARY_ROW[0]->DailyRate) , 2);
		$hourlyRate	   = round( $dailyRate/$dailyHours , 2);
		$night_diff_per_hour = $hourlyRate / (floatval($night_diff_rate[0]->Value));		
		$thisND['amount'] = round($ND_duration_float * $night_diff_per_hour, 2);		
		return $thisND;
	}
		
	function get_NightDifferential
	( $payperiod = NULL, $payment_mode = NULL)
	{
		/*
			abe | made | 23MAY2011_1431
			for this, ditched the DateFrom and DateTo options, only $payperiod considered
			IMPORTANT!!!! UNDERTIME SHOULD BE COMPUTED/CALLED BEFORE THIS
		*/
		
		$employee_ND_count = NULL;
		$employee_ND_Data = array();
		
		$theResult = array("error_code" => NULL,
						   "error_message" => NULL,
							"result_array" => NULL
		);
		if($payperiod == NULL || $payment_mode == NULL)
		{
			$theResult["error_code"] = -1;
			$theResult["ERROR_MESSAGE"] = "get_NightDifferential: PAYPERIOD/PAYMENT_MODE NOT SPECIFIED";
			return $theResult;
		}
		
		//get date inclusives during the payperiod specified from database			
		$obj_result = $this->Payperiod_model->pull_PayPeriod_Info($payperiod);
							
		if($obj_result->num_rows == 0)
		{
			$theResult["error_code"] = -2;
			$theResult["error_message"] = "Pay period does not exist";
			return $theResult;
		}
		$payperiod_obj = $obj_result->result();		//must access index 0 everytime referenced
		
		/*			now pull-all employees
			
			abe | 10may2011 2030 | i am making my own fetch all function so far
				since I'm not sure of Employee_model->Employee_getall()
		*/		
		$employees = $this->getAllEmployees($payment_mode)->result();		
		if( empty ($employees) )
		{			
			$theResult["error_code"] = -3;
			$theResult["error_message"] = "No employee so far for this payperiod.";
			return $theResult;
		}		
					
		foreach($employees as $emp_x)
		{								
			$night_diff_count = 0;		//initialize, in mins			
			/*
			*	pull all records between the dates, inclusive,  specified for the employee
			*/								
			$daily_attendance = $this->pullAttendanceRecord($emp_x->empnum, $payperiod_obj[0]->START_DATE, $payperiod_obj[0]->END_DATE)->result();
			
			foreach($daily_attendance as $daily_attendance_each_day)
			{							
				$difference = 0;
				//get shift id from its table				
				$shift_info = $this->pullShiftInfo($daily_attendance_each_day->shift_id)->result();			
				if( empty ($shift_info) )
				{
					$theResult["error_code"] = -4;
					$theResult["error_message"] = "INVALID SHIFT ID.";
					die(var_dump($theResult));					
				}
								
				/*
				*	if absence_reason is 0, means person is not absent.
				*	and we only compute the night diff if the night_diff for that shift
				* 	is not default value
				*/					
				
				if( ( $daily_attendance_each_day->absence_reason == NULL 
					  or $daily_attendance_each_day->absence_reason == '0')
					and
					( $shift_info[0]->NIGHT_DIFF != "00:00:00" 
					  and $shift_info[0]->NIGHT_DIFF != NULL
					) 
				)
				{															
					$night_diff_today = $this->abeMethod_convert_Time($shift_info[0]->NIGHT_DIFF);
					/*
						If worker has night diff but is undertime, then mababawasan ang kanyang night diff
					*/
					if($daily_attendance_each_day->undertime != "00:00:00" )
					{
						$difference = $night_diff_today - $this->abeMethod_convert_Time($daily_attendance_each_day->undertime);
						if($difference >= 0)
							$night_diff_today = $difference;
						else{
							$night_diff_today = 0;							
						}
					}								
					$this->update_Today("NIGHT_DIFF", $daily_attendance_each_day, "SEC", $night_diff_today);
					$night_diff_count += $difference;										
				}								
			}//foreach daily_attendance...
			
			//at the end of sifting through the days, store it to some variable			
			$employee_ND_Data[$emp_x->empnum] = $night_diff_count;								
		}//foreach (employees
				
		$theResult['result_array'] = $employee_ND_Data;	
		$theResult['error_code'] = 0;
		$theResult['error_message'] = 'SUCCESS';
			
		return $theResult;
	}
	
	function thisTime_in_Float($theTime, $includeSeconds = FALSE)
	{
		/*
			To address the issue in computing for hours, since when computing, we are using BASE 10. 
			However, in time, For seconds and minutes, it's base 60, while for hours, it base 24.
			So this functions does the following, e.g. you passed value from left, the corresponding to its right is returned
			
			01:30:00	-> 1.45
			02:45:00    -> 2.75
			00:05:00	-> 0.08
			
			accepts only time format HH*:MM:SS			
			*H can be so many
		*/
		
		$time_exp = explode(':', $theTime);
		if ( count($time_exp) != 3 )
		{
			echo("Invalid time format passed.");
			return 0;
		}
		$hours = intval($time_exp[0]);
		$mins = intval($time_exp[1]);
		if($includeSeconds) $mins += intval($time_exp[2]);
		$mins_decimal = ( intval($mins) / 60);
		$feedThisTime = floatval($hours) + floatval($mins_decimal);
		
		return $feedThisTime;
	}
	
	
	function differenceTime_in_Float($time1, $time2, $overflow)
	{
		/*
			made | abe | 24may2011_1558
			PARAMS:
			$time1, $time2 - INT, HH:MM:SS format
			$overflow - indicates if $time1 starts in this day and ends ($time2) next day
		*/
		if($overflow == 1)
		{
			$time1 = strtotime("24:00:00") - strtotime($time1);
		}
		
		return ($this->thisTime_in_Float($time1) + $this->thisTime_in_Float($time2));
		
	}
	
	function abeMethod_convert_Time($time)
	{
		/*
			made | abe | 24may2011_2239
			PARAM:
			
			$time = time in HH:MM:SS format
			
			returns INT which is time units in seconds, else BOOL na FALSE
		*/
		$grandTotal = 0;
		
		$time_exp = explode(':', $time);
		if(count($time_exp) != 3)
		{	
			echo("abeMethod_convert_Time: Invalid Time Format should be HH:MM:SS" );
			return FALSE;
		}
		
		if( !is_numeric($time_exp[0]) or !is_numeric($time_exp[1]) 
			or !is_numeric($time_exp[2])
		)
		{
			echo("abeMethod_convert_Time: Non-numeric character detected." );
			return FALSE;
		}
		$grandTotal = intval($time_exp[2]);
		$grandTotal += ( intval($time_exp[1]) * 60);
		$grandTotal += ( intval($time_exp[0]) * 3600);
		
		return $grandTotal;
	}
}//class

/* End of file Attendance_model.php */
/* Location: ./application/model/Attendance_model.php */