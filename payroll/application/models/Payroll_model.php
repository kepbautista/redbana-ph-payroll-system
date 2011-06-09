<?php
/**File Name: Payroll_model.php
   Program Description: Payroll Computations invloving database
**/

class Payroll_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->database();
	}//constructor
	
	function emptyPayperiod(){
		$sql = "SELECT * FROM `payperiod`";
		$query = mysql_query($sql);
		
		if(mysql_num_rows($query) > 0)
			return false;
		else return true;
	}//check if pay period is empty
	
	function getPayPeriods(){
		$query = $this->db->query('SELECT * FROM `payperiod`
				 ORDER BY START_DATE');
		
		foreach($query->result_array() as $value)
			$data[$value['ID']] = $value['START_DATE']." to ".$value['END_DATE'];
		
		return $data;
	}//function for getting all existing payperiod
	
	function getPaymentModes(){
		$query = $this->db->query('SELECT * FROM `payment_mode`
				 ORDER BY ID');
		
		foreach($query->result_array() as $value)
			$data[$value['ID']] = $value['TITLE'];
		
		return $data;
	}//function for getting all payment modes
	
	function payrollFinalized($payperiod){
		$sql = "SELECT FINALIZED FROM `payperiod`
				WHERE id='".$payperiod."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		if($data['FINALIZED']==1)
			return true;
		else
			return false;
	
	}//function for checking in the database if payroll is finalized
	
	function returnCutoff($payperiod){
		$sql = "SELECT * FROM `payperiod` 
				WHERE id='".$payperiod."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
	
		$data['start_date'] = $data['START_DATE'];
		$data['end_date'] = $data['END_DATE'];
	
		return $data;
	}//return cutoff start and end date
	
	function getLatestPayperiod(){
		$sql = "SELECT MAX(ID) FROM `payperiod`";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		return $data['MAX(ID)'];
	}//get the latest payperiod
	
	function getPayroll($start_date,$end_date){	
		$sql = "SELECT EmployeeNumber,EmployeeName 
			FROM `salary` WHERE
			start_date='".$start_date."' 
			AND end_date='".$end_date."' 
			ORDER BY EmployeeNumber";
		$query = mysql_query($sql);
		
		while($row = mysql_fetch_array($query)){
			$info['EmployeeNumber'] = $row['EmployeeNumber'];
			$info['EmployeeName'] = $row['EmployeeName'];
			$data[] = $info;
		}//get all data needed from salary table
		
		return $data;
	}//get payroll for said pay period
	
	function getPayslip($empnum,$start_date,$end_date){
		$sql = $this->db->query("SELECT * FROM `salary` 
				WHERE EmployeeNumber = '".$empnum.
				"' AND start_date='".$start_date."' 
				AND end_date='".$end_date."'");
		$query = $sql->result_array();
		
		foreach($query[0] as $key => $value){
			if(is_numeric($value))
				$data[$key] = number_format($value,2,'.',',');
			else
				$data[$key] = $value;
		}
		
		return $data;
	}//function that gets the information on an employee's pay slip
	
	function payslipExists($empnum,$start_date,$end_date){
		$sql = "SELECT * FROM `salary` WHERE 
				EmployeeNumber = '".$empnum.
				"' AND start_date='".$start_date."' 
				AND end_date='".$end_date."'";
		$query = mysql_query($sql);
		
		if(mysql_num_rows($query) > 0)
			return true;
		else return false;
	}//check if pay slip exists for said employee
	
	function getPayperiod($start_date,$end_date){
		$sql = "SELECT * FROM `payperiod` WHERE start_date='".$start_date."'
				AND end_date='".$end_date."'";
		
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		return $data['ID'];
	}//function get pay period ID
	
	function UpdatePayslip(){
		//get needed information
		$EmployeeNumber = $this->input->post('EmployeeNumber');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$DailyRate = $this->input->post('DailyRate');
		$HolidayAdjustment = $this->input->post('HolidayAdjustment');
		$TaxRefund = $this->input->post('TaxRefund');
		$NonTax = $this->input->post('NonTax');
		$TaxShield = $this->input->post('TaxShield');
		$PagibigLoan = $this->input->post('PagibigLoan');
		$SSSLoan = $this->input->post('SSSLoan');
		$CompanyLoan = $this->input->post('CompanyLoan');
		$CellphoneCharges = $this->input->post('CellphoneCharges');
		$AdvancestoEmployee = $this->input->post('AdvancestoEmployee');
		$Status = mysql_real_escape_string($this->input->post('Status'));
	
		$sql = "UPDATE `salary` SET DailyRate='".$DailyRate."',
				HolidayAdjustment='".$HolidayAdjustment."',
				TaxRefund='".$TaxRefund."',NonTax='".$NonTax."',
				TaxShield='".$TaxShield."',PagibigLoan='".$PagibigLoan."', 
				SSSLoan='".$SSSLoan."',CompanyLoan='".$CompanyLoan."',
				CellphoneCharges='".$CellphoneCharges."',
				AdvancestoEmployee='".$AdvancestoEmployee."',
				Status='".$Status."'
				WHERE EmployeeNumber='".$EmployeeNumber."'
				AND start_date='".$start_date."' AND 
				end_date='".$end_date."'";
		mysql_query($sql);
		
		$payperiod = $this->getPayPeriod($start_date,$end_date);
		$sql = "UPDATE `payroll_absence` SET 
				daily_rate='".$DailyRate."' WHERE 
				payperiod='".$payperiod."'";
		mysql_query($sql);
	}//function that updates the Payslip
	
	function selectSalaryData($empnum,$start_date,$end_date){
		//select data from salary table
		$sql = "SELECT * FROM `salary` WHERE 
				EmployeeNumber = '".$empnum.
				"' AND start_date='".$start_date."' 
				AND end_date='".$end_date."'";
		
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		return $data;
	}//select needed employee data from salary table
	
	function getDailyRate($empnum,$start_date,$end_date){
		$sql = "SELECT DailyRate from `salary` 
				WHERE EmployeeNumber='".$empnum."' 
				AND start_date='".$start_date."' 
				AND end_date='".$end_date."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		return $data['DailyRate'];
	}//get daily rate for the payperiod
	
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
		
		if($paymentMode==1)
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
	
	function getVariable($info){
		//get the value for pagibig
		$sql = "SELECT * FROM `variables` WHERE Name='".$info."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		$value = $data['Value'];
	
		return $value;
	}//compute get value for pagibig
	
	function governmentContribs($info,$sss,$philhealth,$pagibig){	
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
		$this->absencesTardiness($empnum,$start_date,$end_date);
		//compute deductions for absences, tardiness and suspensions
		
		if($this->paymentMode($info)==1){
			/**get if end of the month or not**/
			if(!$this->endOfMonth($start_date,$end_date)){
				$sss = $this->getSSS($empnum);//sss contributions
				$philhealth = $this->getPhilhealth($empnum);//philhealth contributions
			}
			else $pagibig = $this->getVariable('PagIbig');//for pagibig contributions
			
			//call function for Government Dues
			$this->governmentContribs($info,$sss,$philhealth,$pagibig);
		}
		else{
			$philhealth = $this->getPhilhealth($empnum);//sss contributions
			$sss = $this->getSSS($empnum);//philhealth contributions
			$pagibig = $this->getVariable('PagIbig');//for pagibig contributions
			
			//call function for Government Dues
			$this->governmentContribs($info,$sss,$philhealth,$pagibig);
		}
		
		$taxStatus = $this->getTaxStatus($empnum);//get Tax Status
		$this->compute($info,$taxStatus);
	}//perform arithmetic computations for net pay
	
	function getLate($empnum,$start_date,$end_date){
		$payperiod = $this->getPayperiod($start_date,$end_date);
		$sql = "SELECT tardiness_min FROM `payroll_absence` 
				WHERE empnum='".$empnum."' AND
				payperiod='".$payperiod."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		/**MAMAYA NA PO YUNG TARDINESS...**/
		
		return 0;
	}//get minutes late in a certain pay period
	
	function getAbsences($empnum,$start_date,$end_date){
		$payperiod = $this->getPayperiod($start_date,$end_date);
		$sql = "SELECT absences_lwop_days FROM `payroll_absence` 
				WHERE empnum='".$empnum."' AND
				payperiod='".$payperiod."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		$days = $data['absences_lwop_days'];
		
		$dailyRate = $this->getDailyRate($empnum,$start_date,$end_date);
		$deduct = $dailyRate * $days;
		
		return $deduct;
	}//get number of absences in a payperiod
	
	function getSuspensions($empnum,$start_date,$end_date){
		return 0;
	}
	
	function absencesTardiness($empnum,$start_date,$end_date){
		$deduct = $this->getLate($empnum,$start_date,$end_date)
				+ $this->getAbsences($empnum,$start_date,$end_date);
				+ $this->getSuspensions($empnum,$start_date,$end_date);
		$deduct *= -1;
		
		$sql = "UPDATE `salary` SET 
				AbsencesTardiness='".$deduct."' 
				WHERE EmployeeNumber='".$empnum."' AND 
				start_date='".$start_date."' 
				AND end_date='".$end_date."'";
		mysql_query($sql);
	}//update deduction for Absences/Tardiness
	
	function getHolidayRate($empnum,$start_date,$end_date){
		$holidayPay = 0;//initialize holiday pay for current pay period
	
		$sql = "SELECT empnum,work_date,type FROM `timesheet` 
				WHERE work_date>='".$start_date."' 
				AND work_date<='".$end_date."' 
				AND empnum='".$empnum."'";
		$query = mysql_query($sql);
		
		while($row = mysql_fetch_array($query)){
			$empnum = $row['empnum'];
			$work_date = $row['work_date'];
			$type = $row['type'];
			
			//get daily rate of employee for the current pay period
			$dailyRate = $this->getDailyRate($empnum,$start_date,$end_date);
			
			/*Check number of hours
			If half-day, divide daily rate by 2*/
			if($this->getHours($empnum,$work_date) <= 4)
				$dailyRate /= 2;

			$payrate = $this->getPayRate($type);//get pay rate
			$holidayPay += ($dailyRate * ($payrate/100));
		}
		
		/*update holiday pay for current pay period*/
		$sql = "UPDATE `salary` SET Holiday='".$holidayPay."' WHERE 
				EmployeeNumber='".$empnum."' AND start_date='".$start_date."' 
				AND end_date='".$end_date."'";
		mysql_query($sql);
	}//function for computing holiday pay for current pay period
	
	function getPayRate($dayType){
		$sql = "SELECT payrate FROM `daily_desc`
				WHERE id='".$dayType."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
	
		return $data['payrate'];
	}////get pay rate for day description
	
	function getHours($empnum,$work_date){
		$sql = "SELECT date_in,date_out,
				time_in,time_out FROM `timesheet` WHERE 
				work_date='".$work_date."' AND 
				empnum='".$empnum."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		$date_in = $data['date_in'];
		$date_out = $data['date_out'];
		$time_in = $data['time_in'];
		$time_out = $data['time_out'];
		
		$sql = "SELECT TIMEDIFF('".$date_out." ".$time_out."'
				,'".$date_in." ".$time_in."')";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		
		return ($data[0] - 1);
	}//get hours per day
	
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
		//get status for withholding tax table
		$status = $this->getWithholdingStatus($taxStatus);
	
		/*get withholding tax bracket*/
		$sql = "SELECT MAX(".$status.") FROM `witholding_tax` 
				WHERE ".$status."<='".$taxBasis."' AND 
				PAYMENT_MODE_ID_FK='".$paymentMode."'";
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		$taxBracket = $data['MAX('.$status.')'];
		$over = $taxBasis - $taxBracket;
		
		//get Exemption Definite & Percentage
		$sql = "SELECT EXEMPTION_DEFINITE,EXEMPTION_PERCENT FROM 
				`witholding_tax` WHERE ".$status."='".$taxBracket."' 
				AND PAYMENT_MODE_ID_FK='".$paymentMode."'";
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
		$this->getHolidayRate($info[0],$info[1],$info[2]);
		$this->grossPay($info);//compute Gross Pay
		$this->totalPay($info);//compute Total Pay
		$taxBasis = $this->taxBasis($info);//compute Tax Basis
		$this->computeWithholdingTax($taxStatus,$taxBasis,$info,$this->paymentMode($info));
		
		/**COMPUTE NET PAY**/
		//select data from salary table
		$data = $this->selectSalaryData($info[0],$info[1],$info[2]);
		$netpay = $data['TotalPay'] - ($data["WithholdingTax"]
				 + $data['SSS'] + $data['Philhealth']
				 + $data['Pagibig'] + $data['PagibigLoan']
				 + $data['SSSLoan'] + $data['CompanyLoan']
				 + $data['CellphoneCharges'] 
				 + $data['AdvancestoEmployee']);
		
		$sql = "UPDATE `salary` SET Netpay='".$netpay."' WHERE 
				EmployeeNumber='".$info[0]."' AND 
				start_date='".$info[1]."' AND 
				end_date='".$info[2]."'";
		mysql_query($sql);
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
		
		$gross = $data['PayPeriodRate'] + $data['AbsencesTardiness'] +
		         $data['Overtime'] + $data['Holiday'] + $data['HolidayAdjustment'] +
				 $data['TaxRefund'] + $data['NightDifferential'] ;
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
	
		$taxBasis = $data['PayPeriodRate'] + $data['AbsencesTardiness'] +
					$data['Overtime'] + $data['Holiday'] +
					$data['NightDifferential'] + $data['HolidayAdjustment'] +
					$data['TaxRefund'] - ($data['SSS'] +
					$data['Philhealth'] + $data['Pagibig']);
		$sql = "UPDATE `salary` SET WithholdingBasis='".$taxBasis."' WHERE 
				EmployeeNumber='".$info[0]."' AND start_date='".$info[1]."' 
				AND end_date='".$info[2]."'";
		mysql_query($sql);//update withholding tax basis
		
		return $taxBasis;
	}//compute withholding tax basis
}
?>