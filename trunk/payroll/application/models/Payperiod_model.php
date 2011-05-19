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
			abe | changed | 18MAY2011_1325
				now just called get_All_PayPeriods(..)			
		*/
				
		$allPayPeriod = $this->get_All_PayPeriods( $payment_mode );
		if( count($allPayPeriod) < 1 )	
		{	return  NULL;			}
		else		
		{	
			/*
				Because in some tables, entries start with '1', not 0
			*/
			if( isset($allPayPeriod[0]) )
				return $allPayPeriod[0];	
			else 
				return $allPayPeriod[1];
		}
		
	}
	
	function get_All_PayPeriods($payment_mode = NULL)
	{
		/*
			abe | 18MAY2011_1318
			if there is no argument passed to this, all payperiods regardless of payment_mode will be gotten.						
			
			RETURNS
			NULL - if no dB entries gotten
			ARRAY - of the dB entries gotten directly accessible via numerical indices
		*/
		$rows_result;		
		$returnThis = array();
		
		if( $payment_mode == NULL )
		{
			$sql_x = "SELECT * from `payperiod` ORDER BY `payment_mode` and `END_DATE` DESC ";
			$rows_result = $this->db->query($sql_x)->result();
		}else
		{			
			$sql_x = "SELECT * from `payperiod` where `payment_mode` = ? ORDER BY `END_DATE` DESC";
			$rows_result = $this->db->query($sql_x, array($payment_mode) )->result();
		}
		//die(var_dump($rows_result));
		if( empty($rows_result) )
		{	return NULL;			}
		else
		{	
			foreach($rows_result as $x) $returnThis[$x->ID] = $x;
			
			/*foreach($rows_result as $x)			
				$abcd = array();
				foreach($x as $y)
					$abcd[$y->TITLE]
			*/
			return $returnThis;	
		}		
	}//get_All_PayPeriods
	
	function y_get_All_PayPeriods($payment_mode = NULL)
	{
		/*
			abe | 18MAY2011_1318
			if there is no argument passed to this, all payperiods regardless of payment_mode will be gotten.						
			
			RETURNS
			NULL - if no dB entries gotten
			OBJECT - of the dB entries gotten directly accessible via numerical indices
		*/
		$obj_result;		
		$returnThis = array();
		
		if( $payment_mode == NULL )
		{
			$sql_x = "SELECT * from `payperiod` ORDER BY `payment_mode` and `END_DATE` DESC ";
			$obj_result = $this->db->query($sql_x, array());
		}else
		{
			$sql_x = "SELECT * from `payperiod` where `payment_mode` = ? ORDER BY `END_DATE` DESC";
			$obj_result = $this->db->query($sql_x, array($payment_mode) );
		}
		//die(var_dump($rows_result));
		if( $obj_result->num_rows == 0 )
		{	return NULL;			}
		else
		{							
			return $obj_result;	
		}		
	}//get_All_PayPeriods
	
	function add_new_PayPeriod($payment_mode, $start_date, $end_date, $workingDays)
	{
		$start_date[4] = '-';	
		$start_date[7] = '-';
		$end_date[4] = '-';	
		$end_date[7] = '-';
		
		$sql_x = "INSERT INTO `payperiod` VALUES ('', ?, ?, ?, ?, FALSE, FALSE) ";			
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