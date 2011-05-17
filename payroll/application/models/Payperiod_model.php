<?php

class Payperiod_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function pull_PayPeriod_Info( $payperiod_id )
	{
		/*		
			made | abe | 15may2011_2359, should be used for the getTardiness and getAbsences to simplify code
			changed | abe | 17may2011_1350, moved from 'Attendance_model' to 'Payperiod_model'
			
		RETURNS: OBJECT containing the MySQL results or NULL, if no entry exists in the dB
		*/
		
		//get date inclusives during the payperiod specified from database
		$sql_x = "SELECT * from `payperiod` WHERE id = ? ";			
		$obj_result = $this->db->query( $sql_x, array($payperiod_id) );
		
		return $obj_result;
	}

	function pull_Payperiod_This_Date_Falls($date_in_SQL)
	{
		/*		
			made | abe | 15may2011_2345
			changed | abe | 17may2011_1350, moved from 'Attendance_model' to 'Payperiod_model'
			
		RETURNS: OBJECT containing the MySQL results or NULL, if no entry exists in the dB
		*/
	
		$sql_x = "SELECT * FROM `payperiod` WHERE `START_DATE` <= ? AND `END_DATE` >= ?";
		$obj_result = $this->db->query($sql_x, array($date_in_SQL, $date_in_SQL) );
		
		return $obj_result;
	}
	
	function get_Last_PayPeriod($payment_mode = 1)
	{
		/*
			abe | 17MAY2011_1440
			if there is no argument passed to this, the default value '1' / 'SEMI-MONTHLY' is
			assigned to payment mode,
			
			!!!! however, make it dynamic so that we determine first from the dB what index is 'SEMI-MONTHLY'
			as it might change.
		*/
		
		$sql_x = "SELECT * FROM `payperiod` WHERE `payment_mode` = ? ORDER BY `END_DATE` DESC ";			
		$allPayPeriod = $this->db->query($sql_x, array($payment_mode) )->result();
		if( empty ($allPayPeriod) )	
		{	return  NULL;			}
		else		
		{	return $allPayPeriod[0];	}
		
	}
	
	function add_new_PayPeriod($payment_mode, $start_date, $end_date, $workingDays)
	{
		$start_date[4] = '-';	
		$start_date[7] = '-';
		$end_date[4] = '-';	
		$end_date[7] = '-';
		
		$sql_x = "INSERT INTO `payperiod` VALUES ('', ?, ?, ?, ?, FALSE) ";			
		$obj_result = $this->db->query($sql_x, array($payment_mode, $start_date, $end_date, $workingDays) );
	
		$check_it = $this->get_Last_PayPeriod($payment_mode);
		
		return 
		( 
			$check_it->START_DATE ==  $start_date &&
			$check_it->END_DATE ==  $end_date
		);
	}
	
	
	
}

/* End of file Payperiod_model.php */
/* Location: ./application/model/Payperiod_model.php */