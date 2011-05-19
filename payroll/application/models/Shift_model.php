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
	*/
	{
		$returnThisArray = array();
		$shifts = $this->getShifts();
		
		if($shifts == NULL)
		{
			die("SHIFT TABLES is empty. Put at least one first before continuing.");
			//return NULL;
		}
		//die(var_dump($shifts));
		foreach($shifts as $s_rows)
		{
			$returnThisArray[$s_rows->ID] = array( 
				"POSITION_ID_FK" => $s_rows->POSITION_ID_FK,
				"START_TIME" =>  $s_rows->START_TIME,
				"END_TIME" =>  $s_rows->END_TIME,
				"OVERFLOW" => $s_rows->START_TIME
			);
		}
		
		
		return $returnThisArray;
	}
}

/* End of file shift_model.php */
/* Location: ./application/models/shift_model.php */