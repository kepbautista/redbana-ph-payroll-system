<?php
class ComputePayroll_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->database();
	}//constructor
	
	function selectSalaryData($empnum,$start_date,$end_date){
		//select data from salary table
		$sql = "SELECT * FROM `salary` WHERE EmployeeNumber = '".$empnum.
				"' AND start_date='".$start_date."' AND end_date='".$end_date."'";
		
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
	
	function getMonthlyRate($empnum){
		$sql = "SELECT * FROM `employee` WHERE empnum='".$empnum."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		return $data['mrate'];
	}//get monthly rate of employee
	
	function getTaxStatus($empnum){
		//select all employee data
		$data = $this->selectEmployeeData($empnum);
		$taxStatus = $data['tax_status'];
		
		return $taxStatus;
	}//get tax status of employee
	
	function paymentMode($info){
		$data = $this->selectEmployeeData($info[0]);
		$paymentMode = $data['payment_mode'];
		
		return $paymentMode;
	}//get payment mode
	
	function getPayPeriodRate($info){	
		//select all employee data
		$rate = $this->getMonthlyRate($info[0]);
		$paymentMode = $this->paymentMode($info);
		
		if($paymentMode=="SEMI-MONTHLY")
			$rate/=2;//see if payment mode is semi-monthly
		
		$sql = "UPDATE `salary` SET PayPeriodRate='".$rate."' WHERE 
				EmployeeNumber='".$info[0]."' AND start_date='".$info[1]."' 
				AND end_date='".$info[2]."'";
		mysql_query($sql);//update Pay Period Rate
		
		return $rate;
	}//get pay type
	
	function endOfMonth($start_date,$end_date){
		//select data from payperiod table
		$sql = "SELECT * FROM `payperiod` WHERE start_date='".$start_date."'
				AND end_date='".$end_date."'";
		
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		if($data['END_OF_THE_MONTH']==1)
			return true;
		else false;
	}//evaluate if payperiod is end of the month or not
	
	function getPhilhealth($empnum){
		$monthlyRate = $this->getMonthlyRate($empnum);//get monthly rate
		
		$sql = "SELECT pes FROM `philhealth` 
			    WHERE rangel<='".$monthlyRate."'
				AND rangeh>='".$monthlyRate."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
				
		return $data['pes'];
	}//get monthly contribution for Philhealth
	
	function getSSS($empnum){
		$monthlyRate = $this->getMonthlyRate($empnum);//get monthly rate
	
		$sql = "SELECT tee FROM `sss` 
			    WHERE rangel<='".$monthlyRate."'
				AND rangeh>='".$monthlyRate."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		return $data['tee'];
	}//get monthly contribution for SSS
	
	function getPagIbig($info){
		//get the value for pagibig
		$sql = "SELECT * FROM `variables` WHERE Name='pagibig'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		$pagibig = $data['Value'];
	
		return $pagibig;
	}//compute withholding tax basis
	
	function governmentContribs($info,$sss,$philhealth,$pagibig){	
		echo "Philhealth=".$philhealth."<br/>SSS=".$sss
			."<br/>Pagibig=".$pagibig;
		
		$sql = "UPDATE `salary` SET SSS='".$sss."',
				Philhealth='".$philhealth."',
				Pagibig='".$pagibig."' WHERE 
				EmployeeNumber='".$info[0]."' AND 
				start_date='".$info[1]."' 
				AND end_date='".$info[2]."'";
				
		mysql_query($sql);
	}//get values from SSS and Philhealth tables
	
	function computeNetPay($empnum,$start_date,$end_date){
		//initialize gov't contribs to zero
		$sss = $philhealth = $pagibig = 0;
	
		//get needed information
		$info = array($empnum,$start_date,$end_date);
		$this->getPayPeriodRate($info);//get Rate for current PayPeriod
		$this->dailyRate($info);//compute daily rate
		
		
		if($this->paymentMode($info)=="SEMI-MONTHLY"){
			/**get if end of the month or not**/
			if(!$this->endOfMonth($start_date,$end_date)){
				$sss = $this->getSSS($empnum);//sss contributions
				$philhealth = $this->getPhilhealth($empnum);//philhealth contributions
			}
			else $pagibig = $this->getPagIbig($info);//for pagibig contributions
			
			//call function for Government Dues
			$this->governmentContribs($info,$sss,$philhealth,$pagibig);
		}
		else{
			$philhealth = $this->getPhilhealth($empnum);//sss contributions
			$sss = $this->getSSS($empnum);//philhealth contributions
			$pagibig = $this->getPagIbig($info);//for pagibig contributions
			
			//call function for Government Dues
			$this->governmentContribs($info,$sss,$philhealth,$pagibig);
		}
		
		$taxStatus = $this->getTaxStatus($empnum);//get Tax Status
		echo "<br/>".$taxStatus;
		$this->compute($info,$taxStatus);
		
	}//perform arithmetic computations for net pay
	
	function findNumber($string){
		foreach(str_split($string) as $value)
			if(is_numeric($value)) return true;
		return false;
	}//check if a string contains a number
	
	function getWithholdingStatus($taxStatus){
		switch($taxStatus){
			case 'Z': $status = 'A_Z';
					  break;
			case 'S': $status = 'A_SME';
					  break;
			case 'ME': $status = 'A_SME';
					  break;
			case 'S1': $status = 'B_MES1';
					  break;
			case 'ME1': $status = 'B_MES1';
					  break;
			case 'S2': $status = 'B_MES2';
					  break;
			case 'ME2': $status = 'B_MES2';
					  break;
			case 'S3': $status = 'B_MES3';
					  break;
			case 'ME3': $status = 'B_MES3';
					  break;
			case 'S4': $status = 'B_MES4';
					  break;
			case 'ME4': $status = 'B_MES4';
					  break;
		}
		
		return $status;
	}//get tax status from tax bracket
	
	function computeWithholdingTax($taxStatus,$taxBasis,$info,$paymentMode){
		//get Payment Mode ID
		if($paymentMode=="SEMI-MONTHLY")
			$pmodeID = 1;
		else $pmodeID = 2;
	
		//get status for withholding tax table
		$status = $this->getWithholdingStatus($taxStatus);
	
		/*get withholding tax bracket*/
		$sql = "SELECT MAX(".$status.") FROM `witholding_tax` 
				WHERE ".$status."<='".$taxBasis."' AND 
				PAYMENT_MODE_ID_FK='".$pmodeID."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		$taxBracket = $data['MAX('.$status.')'];
		$over = $taxBasis - $taxBracket;
		
		//get Exemption Definite & Percentage
		$sql = "SELECT EXEMPTION_DEFINITE,EXEMPTION_PERCENT FROM 
				`witholding_tax` WHERE ".$status."='".$taxBracket."' 
				AND PAYMENT_MODE_ID_FK='".$pmodeID."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		$percent = $data['EXEMPTION_PERCENT']/100;
		$definite = $data['EXEMPTION_DEFINITE'];
		
		//compute withholding tax
		$withholdingTax = $definite + ($over*$percent);
		$sql = "UPDATE `salary` SET WithholdingTax='".$withholdingTax."' 
				WHERE EmployeeNumber='".$info[0]."' AND 
				start_date='".$info[1]."' AND end_date='".$info[2]."'";
		mysql_query($sql);//update withholding tax
	}//compute wittholding tax
	
	function compute($info,$taxStatus){
		$this->grossPay($info);//compute Gross Pay
		$this->totalPay($info);//compute Total Pay
		$taxBasis = $this->taxBasis($info);//compute Tax Basis
		$this->computeWithholdingTax($taxStatus,$taxBasis,$info,$this->paymentMode($info));
		
		/*compute netpay here*/
	}
	
	function dailyRate($info){
		$monthlyRate = $this->getMonthlyRate($info[0]);//get monthly rate
		
		//look for number of working days in a month
		$sql = "SELECT * FROM `variables` WHERE Name='WorkingDaysPerMonth'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		$N = $data['Value'];
		
		$dailyRate = $monthlyRate/$N;//compute daily Rate
		
		$sql = "UPDATE `salary` SET DailyRate='".$dailyRate."' WHERE 
				EmployeeNumber='".$info[0]."' AND start_date='".$info[1]."' 
				AND end_date='".$info[2]."'";
		mysql_query($sql);//update gross pay
		
	}//function for computing daily rate
	
	function getTaxExemption(){
		/*GET EXEMPTION*/
		$query = mysql_query("SELECT * FROM `tax_status` 
				WHERE status='".$taxStatus."'");
		
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		return $data['exemption'];
	}
	
	function grossPay($info){
		//select all employee data
		$data = $this->selectSalaryData($info[0],$info[1],$info[2]);
		
		$gross = $data['PayPeriodRate'] - $data['AbsencesTardiness'] +
		         $data['Overtime'] + $data['Holiday'] + $data['TaxRefund'] +
				 $data['NightDifferential'];
		$sql = "UPDATE `salary` SET GrossPay='".$gross."' WHERE 
				EmployeeNumber='".$info[0]."' AND start_date='".$info[1]."' 
				AND end_date='".$info[2]."'";
		mysql_query($sql);//update gross pay
	}//function that computes gross pay
	
	function totalPay($info){
		//select all employee data
		$data = $this->selectSalaryData($info[0],$info[1],$info[2]);
	
		$totalPay = $data['GrossPay'] + $data['NonTax'] +
					$data['TaxShield'];
		$sql = "UPDATE `salary` SET TotalPay='".$totalPay."' WHERE 
				EmployeeNumber='".$info[0]."' AND start_date='".$info[1]."' 
				AND end_date='".$info[2]."'";
		
		mysql_query($sql);//update total pay
	}//function for computing Total Pay
	
	function taxBasis($info){
		//select all employee data
		$data = $this->selectSalaryData($info[0],$info[1],$info[2]);
	
		$taxBasis = $data['PayPeriodRate'] - $data['AbsencesTardiness'] +
					$data['Overtime'] + $data['Overtime'] + $data['Holiday'] +
					$data['NightDifferential'] - $data['SSS'] -
					$data['Philhealth'] - $data['Pagibig'];
		$sql = "UPDATE `salary` SET WithholdingBasis='".$taxBasis."' WHERE 
				EmployeeNumber='".$info[0]."' AND start_date='".$info[1]."' 
				AND end_date='".$info[2]."'";
		mysql_query($sql);//update withholding tax basis
		
		return $taxBasis;
	}//compute withholding tax basis
}
?>