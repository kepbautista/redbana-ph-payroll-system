<?php

class Payperiod_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper( array('form','url') );		
	}

	function pull_PayPeriod_Info( $payperiod_id )
	{
		/*		
			made | abe | 15may2011_2359, should be used for the getTardiness and getAbsences to simplify code
			changed | abe | 17may2011_1350, moved from 'Attendance_model' to 'Payperiod_model'
			
		RETURNS: OBJECT containing the MySQL results or NULL, if no entry exists in the dB
		*/
		
		//get date inclusives during the payperiod specified from database
		$sql_x = "SELECT * from `payperiod` WHERE `id` = ? ";			
		$obj_result = $this->db->query( $sql_x, array($payperiod_id) );
		
		return $obj_result;
	}
	
	function pull_PayPeriod_Info_X( $payperiod_id, $payment_mode )
	{
		/*		
			made | abe | 19may2011_1253, differs from the 'without X' function because
			this will return OBJECT or NULL
			
		RETURNS: OBJECT containing the first MySQL results row, index is the payperiod->ID ;
				 NULL, if no entry exists in the dB
		*/
		
		//get date inclusives during the payperiod specified from database
		$sql_x = "SELECT * from `payperiod` WHERE `id` = ? AND `payment_mode` = ?";			
		$rows_result = $this->db->query( $sql_x, array($payperiod_id, $payment_mode) )->result();
		
		if( empty($rows_result) )
		{	return NULL;	}

		return $rows_result[0];
	}//_X
	
	function pull_Payperiod_This_Date_Falls($date_in_SQL, $payment_mode = 1)
	{
		/*		
			made | abe | 15may2011_2345
			changed | abe | 17may2011_1350, moved from 'Attendance_model' to 'Payperiod_model'
			
		RETURNS: OBJECT containing the MySQL results or NULL, if no entry exists in the dB
		*/
	
		$sql_x = "SELECT * FROM `payperiod` WHERE `START_DATE` <= ? AND `END_DATE` >= ? AND `payment_mode` = ?";
		$obj_result = $this->db->query($sql_x, array($date_in_SQL, $date_in_SQL, $payment_mode) );
		
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
			abe | changed | 19MAY2011_1117
				came back to it's own SQL execution
		*/
				
		$sql_x = "SELECT * FROM `payperiod` WHERE `payment_mode` = ? ORDER BY (CURRENT_DATE - `END_DATE`) ASC";
		$rows_result = $this->db->query($sql_x, array($payment_mode) )->result();
		
		if( empty($rows_result) )
		{
			return  NULL;
		}else
		{
			return $rows_result[0];
		}
		
	}
	
	function get_All_PayPeriods($payment_mode = NULL, $sort_order = "ASC")
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
		
		$sort_order = strtoupper($sort_order);
		if( ! ($sort_order == "ASC" or $sort_order == "DESC") )
		{
			die("get_Last_PayPeriod: INVALID SORTING METHOD.");
		}
								
		if( $payment_mode == NULL )
		{
			$sql_x = "SELECT * from `payperiod` ORDER BY `payment_mode` and `END_DATE` ".$sort_order;
			$rows_result = $this->db->query($sql_x)->result();
		}else
		{			
			$sql_x = "SELECT * from `payperiod` where `payment_mode` = ? ORDER BY `END_DATE` ".$sort_order;
			$rows_result = $this->db->query($sql_x, array($payment_mode) )->result();
		}
		
		if( empty($rows_result) )
		{	return NULL;			}
		else
		{	
			foreach($rows_result as $x) $returnThis[$x->ID] = $x;					
			
			return $returnThis;	
		}		
	}//get_All_PayPeriods
			
	function add_new_PayPeriod($payment_mode, $start_date, $end_date, $workingDays, $endOfMonth)
	{
		$start_date[4] = '-';	
		$start_date[7] = '-';
		$end_date[4] = '-';	
		$end_date[7] = '-';
		
		$this->insertPayslips($start_date,$end_date);
		
		$sql_x = "INSERT INTO `payperiod` VALUES ('', ?, ?, ?, ?, ?, FALSE, NULL, NULL, 0, NULL, NULL) ";			
		$obj_result = $this->db->query($sql_x, array($payment_mode, $start_date, $end_date, $workingDays, $endOfMonth));
	
		$check_it = $this->get_Last_PayPeriod($payment_mode);
		
		return 
		( 
			$check_it->START_DATE ==  $start_date &&
			$check_it->END_DATE ==  $end_date
		);
	}
	
	function finalizePayPeriod($payment_mode = NULL, $payperiod = NULL, $currentUser = NULL)
	{
		$result = array
		(			
			"result" => false,
			"ERROR_CODE" => 0,
			"ERROR_TITLE" => NULL,
			"ERROR_MESSAGE" => NULL
		);
		
		$sql_x = "UPDATE `payperiod` SET `FINALIZED` = '1',`FINALIZED_BY` = ?,`FINALIZED_DATE` = CURRENT_TIMESTAMP WHERE `id` = ? AND `payment_mode` = ?";
		$sql_result = $this->db->query($sql_x, array($currentUser, $payperiod, $payment_mode) );
		
		$result['result'] = TRUE;
		
		return $result;
	}
	
	/**TIN**/
	function insertPayslips($start_date,$end_date){
		$sql = "SELECT empnum FROM `employee`";
		$query = mysql_query($sql);
		
		while($data = mysql_fetch_array($query)){
			//get employee name
			$empname = $this->getName($data['empnum']);
			
			$sql = "INSERT INTO `salary` VALUES 
				('".$start_date."','".$end_date."',
				'".$data['empnum']."',
				'".$empname."',0,0,0,
				0,0,0,0,0,0,0,0,0,0,
				0,0,0,0,0,0,0,0,0,0,
				null)";
			mysql_query($sql);
		}
	}//create pay slips for certain pay period
	
	/*TIN*/
	function getName($employeeNum){
		$sql = "SELECT * FROM `employee` 
				WHERE empnum='".$employeeNum."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
	
		return $data['sname'].", "
			.$data['fname']." "
			.$data['mname'];
	}//get name of the employee
}

/* End of file Payperiod_model.php */
/* Location: ./application/model/Payperiod_model.php */