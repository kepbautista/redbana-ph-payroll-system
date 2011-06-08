<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shift_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();		
	}
	
	function getShifts()
	/*
		made | abe | 17MAY2011_2310
	*/
	{
		$sql_x = "SELECT * FROM `shift`";
		$rows_result = $this->db->query($sql_x, null)->result();
		
		if( empty($rows_result) )		
			return NULL;
		else
			return $rows_result;
	}
	
	function makeAssociativeArray_of_Shifts()
	/*
		made | abe | 17MAY2011_2314
		edited | abe | 07JUN2011_2352 | fixed a bug, added feature
	*/
	{
		$returnThisArray = array();
		$shifts = $this->getShifts();
		
		if($shifts == NULL)
		{
			die("SHIFT TABLES is empty. Put at least one first before continuing.");
			//return NULL;
		}
		
		foreach($shifts as $s_rows)
		{
			$returnThisArray[$s_rows->ID] = array( 
				"POSITION_ID_FK" => $s_rows->POSITION_ID_FK,
				"START_TIME" =>  $s_rows->START_TIME,
				"END_TIME" =>  $s_rows->END_TIME,
				"OVERFLOW" => $s_rows->OVERFLOW,
				"NIGHT_DIFF" => $s_rows->NIGHT_DIFF,
				"BREAKTIME" => $s_rows->BREAKTIME
			);
		}
		
		
		return $returnThisArray;
	}
	//differenceTime_in_Float($time1, $time2, $overflow)
	function getShift($shift_id)
	{
		/*
			abe | made | 07JUN2011_2332
						
			returns OBJECT if shift is present, NULL if not
		*/
		$sql_x = "SELECT * FROM `shift` WHERE `ID` = ?";
		$rows_result = $this->db->query($sql_x, arrayt($shift_id) )->result();
		
		if( empty($rows_result) )		
			return NULL;
		else
			return $rows_result[0];
	}
}

/* End of file shift_model.php */
/* Location: ./application/models/shift_model.php */