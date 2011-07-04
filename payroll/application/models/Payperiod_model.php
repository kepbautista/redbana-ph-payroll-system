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
		
		$sql_x = "INSERT INTO `payperiod` VALUES ('', ?, ?, ?, ?, ?, FALSE, NULL, NULL, 0, NULL, NULL, ?, ?) ";			
		$obj_result = $this->db->query($sql_x, array($payment_mode, $start_date, $end_date, $workingDays, $endOfMonth, 0, ''));
	
		$check_it = $this->get_Last_PayPeriod($payment_mode);
		
		return 
		( 
			$check_it->START_DATE ==  $start_date &&
			$check_it->END_DATE ==  $end_date
		);
	}
	
	function deletePayPeriod($payperiod)
	{
		/*
			made | abe | 09JUN2011_2100
			
			started using transactions
		*/
		$payperiod_array = $this->pull_PayPeriod_Info( $payperiod )->result();
		$payperiod_obj = $payperiod_array[0];
		
		if( empty($payperiod_array) ) die(var_dump($this->ErrorReturn_model->createSingleError(407, NULL, NULL) ));	//payperiod not found error
		
		$this->db->trans_begin(); //should create a restore point first
		
		$sql_x = "DELETE FROM `payperiod` WHERE `id` = ?";
		$payperiod_deletion_self = $this->db->query($sql_x, array($payperiod) );
		
		$sql_x = "DELETE FROM `payroll_absence` WHERE `payperiod` = ? and `payment_mode` = ?";
		$payperiod_deletion_PA = $this->db->query($sql_x, array($payperiod, $payperiod_obj->PAYMENT_MODE) );
		
		$sql_x = "DELETE FROM `salary` WHERE `start_date` = ? and `end_date` = ?";
		$payperiod_deletion_S = $this->db->query($sql_x, array($payperiod_obj->START_DATE, $payperiod_obj->END_DATE) );
		
		if (
			$payperiod_deletion_self 
			and $payperiod_deletion_PA
			and $payperiod_deletion_S
		){
			$this->db->trans_commit();
			return $this->ErrorReturn_model->createSingleError(0, NULL, NULL);		//success			 
		}else{
			//rollback transaction
			$this->db->trans_rollback();
			return $this->ErrorReturn_model->createSingleError(300, NULL, NULL);	//payperiod deletion error			  
		}
	}//deletePayPeriod($payperiod);
	
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
	
	function getWorkDays()
	{
		/*	made | abe | 24JUN2011_1151
			returns NULL if no entries, ARRAY if there is/are
		*/
		$sql_x = "SELECT * FROM `daily_desc`  ORDER BY `ID`  ASC";
		$array_result = $this->db->query($sql_x, array())->result();
		$returnThis = array();
		
		if(empty($array_result))
			return NULL;
		
		foreach($array_result as $each_obj)
		{
			$returnThis[$each_obj->id] = $each_obj;
		}
		return $returnThis;
	}
	
	function getOvertimeRates()
	{
		/*	made | abe | 24JUN2011_1151
			returns NULL if no entries, ARRAY if there is/are
		*/
		$sql_x = "SELECT * FROM `overtime_rate` ORDER BY `ID` ASC";
		$array_result = $this->db->query($sql_x, array())->result();
		$returnThis = array();
		
		foreach($array_result as $each_obj)
		{
			$returnThis[$each_obj->id] = $each_obj;
		}
		return $returnThis;
	}
	
	function getOvertimeRateSingle($id)
	{
		$sql_x = "SELECT * FROM `overtime_rate` WHERE `id` = ?";
		$array_result = $this->db->query($sql_x, array($id))->result();
		
		if(empty($array_result)) return NULL;
		
		return $array_result;		
	}
	
	
	function getAllowedOT_Rates($each_attendance_obj)
	{
		/*	made by abe forgot na kung kelan.. anyway
			me pa rin to, 04 JUL 2011 1816
			sa sql, it would be better if `HOL_TYPE` IS INCLUDED as another criterion.
			However, the `daily_desc` table was modified by someone and added the ff
			   "Regular Holiday on Rest Day",
			   "Special Holiday on Rest Day",
			   "Double Holiday on Rest Day"
			 which could conflict here, as I previously set that a Rest day should be referenced
			 to the entry in `timesheet`					
		*/
		
		if($each_attendance_obj == NULL) return NULL;
		$sql_x = "SELECT * FROM `overtime_rate` WHERE `IS_OVERTIME` = ? AND `IS_NIGHTDIFF` = ? AND `IS_RESTDAY` = ? ORDER BY `ID` ASC";
		$array_result = $this->db->query($sql_x, 
			array(
				($each_attendance_obj->overtime == "00:00:00" ? 0 : 1),
				($each_attendance_obj->night_diff == "00:00:00" ? 0 : 1),
				($each_attendance_obj->restday)
			)
		)->result();
	    				
		if(empty($array_result))
			return NULL;
		else
			return $array_result;	
	}
}

/* End of file Payperiod_model.php */
/* Location: ./application/model/Payperiod_model.php */