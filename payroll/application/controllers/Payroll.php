<?php
/*File Name: Payroll.php
  Date: May 17, 2011
  Program Description: Contains all payroll computations.
*/
class Payroll extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->model('Payroll_model');
		$this->load->model('Payperiod_model');
		$this->load->library('form_validation');
		$this->load->model('login_model');
	}
	
	function validateForm(){		
		if(is_numeric($this->input->post('DailyRate')))
			$this->form_validation->set_rules(floatval('DailyRate'),'Daily Rate','required|numeric|greater_than[0]');
		else
			$this->form_validation->set_rules('DailyRate','Daily Rate','required|numeric|greater_than[0]');
		if(is_numeric($this->input->post('TaxRefund')))
			$this->form_validation->set_rules(floatval('TaxRefund'),'Tax Refund','numeric|greater_than[0]');
		else
			$this->form_validation->set_rules('TaxRefund','Tax Refund','numeric|greater_than[0]');
		if(is_numeric($this->input->post('HolidayAdjustment')))
			$this->form_validation->set_rules(floatval('HolidayAdjustment'),'Holiday Adjustment','numeric|greater_than[0]');
		else
			$this->form_validation->set_rules('HolidayAdjustment','Holiday Adjustment','numeric|greater_than[0]');
		if(is_numeric($this->input->post('NonTax')))
			$this->form_validation->set_rules(floatval('NonTax'),'Non-Tax','numeric|greater_than[0]');
		else
			$this->form_validation->set_rules('NonTax','Non-Tax','numeric|greater_than[0]');
		if(is_numeric($this->input->post('TaxShield')))
			$this->form_validation->set_rules(floatval('TaxShield'),'TaxShield','numeric|greater_than[0]');
		else
			$this->form_validation->set_rules('TaxShield','TaxShield','numeric|greater_than[0]');
		if(is_numeric($this->input->post('PagibigLoan')))
			$this->form_validation->set_rules(floatval('PagibigLoan'),'Pag-Ibig Loan','numeric|greater_than[0]');
		else
			$this->form_validation->set_rules('PagibigLoan','Pag-Ibig Loan','numeric|greater_than[0]');
		if(is_numeric($this->input->post('SSSLoan')))
			$this->form_validation->set_rules(floatval('SSSLoan'),'SSS Loan','numeric|greater_than[0]');
		else
			$this->form_validation->set_rules('SSSLoan','SSS Loan','numeric|greater_than[0]');
		if(is_numeric($this->input->post('CompanyLoan')))
			$this->form_validation->set_rules(floatval('CompanyLoan'),'Company Loan','numeric|greater_than[0]');
		else
			$this->form_validation->set_rules('CompanyLoan','Company Loan','numeric|greater_than[0]');
		if(is_numeric($this->input->post('CellphoneCharges')))
			$this->form_validation->set_rules(floatval('CellphoneCharges'),'Cellphone Charges','numeric|greater_than[0]');
		else
			$this->form_validation->set_rules('CellphoneCharges','Cellphone Charges','numeric|greater_than[0]');
		if(is_numeric($this->input->post('AdvancestoEmployee')))
			$this->form_validation->set_rules(floatval('AdvancestoEmployee'),'Advances to Employee','numeric|greater_than[0]');
		else
			$this->form_validation->set_rules('AdvancestoEmployee','Advances to Employee','numeric|greater_than[0]');
		$this->form_validation->set_rules('Status','Status','callback_script_input');
	}//function for validating edit pay slip form
	
	function PayrollInfoView(){
		if(($this->login_model->isUser_LoggedIn())==FALSE ){			
			redirect('login');
		}
		else{
			if(($this->login_model->can_Access("viewpay"))==FALSE)
				redirect('super');
		}
	
		if(!$this->Payroll_model->emptyPayperiod()){
			$data['payperiod'] = $this->Payroll_model->getPayPeriods();
		
			if(isset($_POST['GeneratePayroll'])){
				$payperiod = $this->input->post('payperiod');
		
				//check if pay period is finalized
				if($this->Payroll_model->payrollFinalized($payperiod))
					$data['finalized'] = true;
				else $data['finalized'] = false;
			
				$cutoff = $this->Payroll_model->returnCutoff($payperiod);
				$data['start_date'] = $cutoff['start_date'];
				$data['end_date'] = $cutoff['end_date'];
			
				//get all pay slips
				$data['info'] = $this->Payroll_model->getPayroll($data['start_date'],$data['end_date']);	
			}
			
			$this->load->view('Payroll_view',$data);
		}
		else
			redirect('AttendanceController');
			//no existing pay period yet
	}//view the payroll for specified cutoff
	
	/**VIEW PAY SLIP INDIVIDUALLY
	(NOT SUPERUSER USER RIGHT)**/
	function IndividualPayslip(){
		if(($this->login_model->isUser_LoggedIn())==FALSE ){			
			redirect('login');
		}
		else{
			if(($this->login_model->can_Access("viewslip"))==FALSE)
				redirect('super');
		}
	
		if(isset($_POST['payslip']))
			$payperiod = $this->input->post('payperiod');
			//user selected pay period
		else
			$payperiod = $this->Payroll_model->getLatestPayperiod();
			//get latest pay period (default view)
		
		$data['EmployeeNumber'] = $this->session->userData('empnum');
		$cutoff = $this->Payroll_model->returnCutoff($payperiod);
		$data['start_date'] = $cutoff['start_date'];
		$data['end_date'] = $cutoff['end_date'];
			
		if($this->Payroll_model->payslipExists($data['EmployeeNumber'],
			$data['start_date'],$data['end_date'])){	
			$data = $this->Payroll_model->getPayslip($data['EmployeeNumber'],
					$data['start_date'],$data['end_date']);
			
			$data['current'] = $payperiod;//pass current pay period
			$data['payperiod'] = $this->Payroll_model->getPayPeriods();
			
			//check if pay period is finalized
			if($this->Payroll_model->payrollFinalized($payperiod))
				$data['finalized'] = true;
			else $data['finalized'] = false;
			
			$this->load->view('viewpayslip',$data);
		}
		else{
			$data['EmployeeName'] = $this->Payperiod_model->getName($data['EmployeeNumber']);
			$data['current'] = $payperiod;//pass current pay period
			$data['payperiod'] = $this->Payroll_model->getPayPeriods();
			
			$this->load->view('nopayslip',$data);
		}
	}

	function EditPayslip(){
		if(($this->login_model->isUser_LoggedIn())==FALSE ){			
			redirect('login');
		}
		else{
			if(($this->login_model->can_Access("viewpay"))==FALSE)
				redirect('super');
		}
	
		$data['EmployeeNumber'] = $_POST['EmployeeNumber'];
		$data['start_date'] = $_POST['start_date'];
		$data['end_date'] = $_POST['end_date'];
		
		$this->NetPay();//compute partial net pay
		
		$data = $this->Payroll_model->getPayslip($data['EmployeeNumber'],$data['start_date'],$data['end_date']);
		
		if(isset($_POST['view'])){
			$data['payperiod'] = $this->Payroll_model->getPayPeriods();
			$this->load->view('ViewPayslip',$data);
		}//view pay slip only
		else if(!isset($_POST['edit'])){
			//get information
			foreach($_POST as $key => $value)
				$data[$key] = $value;
			
			$this->validateForm();

			if ($this->form_validation->run() == FALSE)
				$this->load->view('EditPayslip_view',$data);
			else $this->UpdatePayslip();//update pay slip
		}//edit pay slip
		else	
			$this->load->view('EditPayslip_view',$data);
			//Edit Pay Slip Form is loaded for the 1st time	
	}
	
	function UpdatePayslip(){
		if(($this->login_model->isUser_LoggedIn())==FALSE ){			
			redirect('login');
		}
		else{
			if(($this->login_model->can_Access("viewpay"))==FALSE)
				redirect('super');
		}
		
		//get needed information
		$empnum = $_POST['EmployeeNumber'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
	
		$this->Payroll_model->UpdatePayslip();
		$this->NetPay();
		$data = $this->Payroll_model->getPayslip($empnum,$start_date,$end_date);
		$data['payperiod'] = $this->Payroll_model->getPayPeriods();
		$this->load->view('ViewPayslip',$data);		
	}//Update a pay slip
	
	function NetPay(){
		if(($this->login_model->isUser_LoggedIn())==FALSE ){			
			redirect('login');
		}
		else{
			if(($this->login_model->can_Access("viewpay"))==FALSE)
				redirect('super');
		}
	
		//get information
		$empnum = $_POST['EmployeeNumber'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		
		$this->Payroll_model->computeNetPay($empnum,$start_date,$end_date);
	}//function for computing Withholding Tax
	
	function script_input($str){
		$response = TRUE;
	
		//user entered a script as input
		if((stripos($str,"script") !== false)){
			if((stripos($str,"<") !== false) && (stripos($str,">") !== false)){
				$this->form_validation->set_message('script_input', 'Invalid &ltscript&gt&lt/script&gt input for %s');
				$response = FALSE;
			}
		}	
		return $response;
	}//check if user entered a script as input
	
	function finalized($payperiod){
		$response = $this->Payroll_model->payrollFinalized($payperiod);
		$this->form_validation->set_message('finalized',"This %s is already finalized.");
		
		return $response;
	}//evaluate if payperiod is already finalized
}
?>