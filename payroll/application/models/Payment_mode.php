<?php

class Payment_mode extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_All_PaymentModes()
	{
		$sql_x = "SELECT * from `payment_mode` ORDER BY ID ASC";
		$rows_result = $this->db->query( $sql_x )->result();
		$returnThis = array();
		
		if( empty($rows_result) )
		{	return NULL;		}
		else
		{	
			foreach($rows_result as $x)
				$returnThis[$x->ID] = $x;
				
			return $returnThis;			
		}
	}
	
	
	
}//class

/* End of file Payment_model.php */
/* Location: ./application/model/Payment_model.php */