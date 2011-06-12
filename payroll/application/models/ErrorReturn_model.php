<?php

/*
 MODEL Created by Abe | 02JUN2011_1356
*/

class ErrorReturn_model extends CI_Model
{
									
	function __construct()
	{
		parent::__construct();		
	}
	
	
	function createSingleError($code = NULL, $furtherInfo = NULL, $reserved = NULL)
	{
		/* created by & same timestamp as model	
		
			RETURNS AN ARRAY, a single instance of an error
		*/
		/*echo "called for ".$code."<br/>";
		echo var_dump($furtherInfo);*/
		$thisError = array
		(
			"ERROR_CODE" => -1,
			"result" => true,
			"ERROR_NAME" => "UNDEFINED",
			"ERROR_MESSAGE" => NULL,
			"FURTHER_INFO" => NULL			
		);		
		
		$sql_x = "SELECT * FROM `errorcodes` WHERE `CODE` = ?";
		$array_result = $this->db->query($sql_x, array($code) )->result();
		
		if( !empty($array_result) )
		{
			$thisError['ERROR_CODE'] = $code;
			$thisError['result'] = FALSE;
			$thisError['ERROR_NAME'] = $array_result[0]->NAME;
			$thisError['ERROR_MESSAGE'] = $array_result[0]->MESSAGE;
			if($furtherInfo == NULL)
				$thisError['FURTHER_INFO'] = $array_result[0]->FURTHER_INFO;
			else
				$thisError['FURTHER_INFO'] = $furtherInfo."|"."Tried to call ".$code;
		}
		if($code == 0) $thisError['result'] = TRUE;		
		
		return $thisError;
	}
	
	
}

/* End of file ErrorReturn_model.php */
/* Location: ./application/model/ErrorReturn_model.php */