<?php
class ComputePayroll_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->database();
	}//constructor
	
	function selectSalaryData($empnum,$cutoffL,$cutoffH){
		//select data from salary table
		$sql = "SELECT * FROM `salary` WHERE EmployeeNumber = '".$empnum.
				"' AND CutoffL='".$cutoffL."' AND CutoffH='".$cutoffH."'";
		
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		return $data;
	}//select needed employee data from salary table
	
	function selectEmployeeData($empnum){
		//select data from salary table
		$sql = "SELECT * FROM `employee` WHERE empnum='".$empnum."'";
		
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		return $data;
	}//select needed employee data from employee table
	
	function getTaxStatus($empnum){
		//select all employee data
		$data = $this->selectEmployeeData($empnum);
		$taxStatus = $data['tax_status'];
		
		$query = mysql_query("SELECT * FROM `tax_status` 
				WHERE status='".$taxStatus."'");
		
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		return $data;
	}//get tax status of employee
	
	function getPayType($empnum){
		//select all employee data
		$data = $this->selectEmployeeData($empnum);
		
	
	}//get pay type
	
	function computeNetPay($empnum,$cutoffL,$cutoffH){
		//get needed information
		$info = array($empnum,$cutoffL,$cutoffH);
		
		/**LAGYAN ng VALIDATION kung ano yung Current Payperiod
		if evaluate pa kung semi-monthly o hindi
		si employee semi-monthly, tingnan kung kinsenas o hindi**/
		
		/**evaluate pa pala kung monthly o semi-monthly
		ang employee**/
		
		$pagibig = $this->pagIbig($info);//for pagibig fund
		$gross = $this->grossPay($info);//compute Gross Pay
		$totalPay = $this->totalPay($info);//compute Total Pay
		$taxBasis = $this->taxBasis($info);//compute Tax Basis
		$withholdingTax = $this->getTaxStatus($info);//compute Withholding Tax
		
		echo $taxBasis;
	}//perform arithmetic computations for withholding tax
	
	function grossPay($info){
		//select all employee data
		$data = $this->selectSalaryData($info[0],$info[1],$info[2]);
		
		$gross = $data['PayPeriodRate'] - $data['AbsencesTardiness'] +
		         $data['Overtime'] + $data['Holiday'] + $data['TaxRefund'] +
				 $data['NightDifferential'];
		$sql = "UPDATE `salary` SET GrossPay='".$gross."' WHERE 
				EmployeeNumber='".$info[0]."' AND CutoffL='".$info[1]."' 
				AND CutoffH='".$info[2]."'";
		
		mysql_query($sql);//update gross pay
		
		return $gross;
	}//function that computes gross pay
	
	function totalPay($info){
		//select all employee data
		$data = $this->selectSalaryData($info[0],$info[1],$info[2]);
	
		$totalPay = $data['GrossPay'] + $data['NonTax'] +
					$data['TaxShield'];
		$sql = "UPDATE `salary` SET TotalPay='".$totalPay."' WHERE 
				EmployeeNumber='".$info[0]."' AND CutoffL='".$info[1]."' 
				AND CutoffH='".$info[2]."'";
		
		mysql_query($sql);//update total pay
		
		return $totalPay;
	}//function for computing Total Pay
	
	function taxBasis($info){
		//select all employee data
		$data = $this->selectSalaryData($info[0],$info[1],$info[2]);
	
		$taxBasis = $data['PayPeriodRate'] - $data['AbsencesTardiness'] +
					$data['Overtime'] + $data['Overtime'] + $data['Holiday'] +
					$data['NightDifferential'] - $data['SSS'] -
					$data['Philhealth'] - $data['Pagibig'];
		$sql = "UPDATE `salary` SET WithholdingBasis='".$taxBasis."' WHERE 
				EmployeeNumber='".$info[0]."' AND CutoffL='".$info[1]."' 
				AND CutoffH='".$info[2]."'";
				
		mysql_query($sql);//update withholding tax basis
	
		return $taxBasis;
	}//compute withholding tax basis
	
	function pagIbig($info){
		//get the value for pagibig
		$sql = "SELECT * FROM `variables` WHERE Name='pagibig'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		$pagibig = $data['Value'];
	
		$sql = "UPDATE `salary` SET Pagibig='".$pagibig."' WHERE 
				EmployeeNumber='".$info[0]."' AND CutoffL='".$info[1]."' 
				AND CutoffH='".$info[2]."'";
				
		mysql_query($sql);//update withholding tax basis
	
		return $pagibig;
	}//compute withholding tax basis
}
?>