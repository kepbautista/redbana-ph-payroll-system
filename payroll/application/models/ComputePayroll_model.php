<?php
class ComputePayroll_model extends CI_Model{
	
	function getWithholdingTax($empnum,$cutoffL,$cutoffH){
		$this->load->database();
		
		//select data from employee table
		$sql = "SELECT * FROM `salary` WHERE EmployeeNumber = '".$empnum.
				"' AND CutoffL='".$cutoffL."' AND CutoffH='".$cutoffH."'";
		//$query = $this->db->query($sql);
		$query = mysql_query($sql);
		
		$row = mysql_fetch_array($query);
		
		//compute additions
		
		
		//return $tax;
	}//perform arithmetic computations for withholding tax
	
}
?>