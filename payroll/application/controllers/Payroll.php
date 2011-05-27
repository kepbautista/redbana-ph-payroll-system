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
	}
	
	function validateForm(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules(floatval('DailyRate'),'Daily Rate','required|numeric|greater_than[0]');
		$this->form_validation->set_rules(floatval('TaxRefund'),'Tax Refund','numeric|greater_than[0]');
		$this->form_validation->set_rules(floatval('NonTax'),'Non-Tax','numeric|greater_than[0]');
		$this->form_validation->set_rules(floatval('TaxShield'),'TaxShield','numeric|greater_than[0]');
		$this->form_validation->set_rules(floatval('PagibigLoan'),'Pag-Ibig Loan','numeric|greater_than[0]');
		$this->form_validation->set_rules(floatval('SSSLoan'),'SSS Loan','numeric|greater_than[0]');
		$this->form_validation->set_rules(floatval('CompanyLoan'),'Company Loan','numeric|greater_than[0]');
		$this->form_validation->set_rules(floatval('AdvancestoOfficer'),'Advances to Officer','numeric|greater_than[0]');
		$this->form_validation->set_rules(floatval('CellphoneCharges'),'Cellphone Charges','numeric|greater_than[0]');
		$this->form_validation->set_rules(floatval('AdvancestoEmployee'),'Advances to Employee','numeric|greater_than[0]');
		$this->form_validation->set_rules('Remarks','Remarks','callback_script_input');
		$this->form_validation->set_rules('Status','Status','callback_script_input');
	}//function for validating edit pay slip form
	
	function PayrollInfoView(){
		$this->load->model('Payroll_model');
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
	}//view the payroll for specified cutoff

	function EditPayslip(){
		$data['EmployeeNumber'] = $_POST['EmployeeNumber'];
		$data['start_date'] = $_POST['start_date'];
		$data['end_date'] = $_POST['end_date'];
		
		if(isset($_POST['netpay']))
			$this->NetPay();
		else if(!isset($_POST['edit'])){
			//get information
			foreach($_POST as $key => $value)
				$data[$key] = $value;
		
			$this->load->model('Payroll_model');
			$this->validateForm();
			
			if ($this->form_validation->run() == FALSE)
				$this->load->view('EditPayslip_view',$data);
			else $this->UpdatePayslip();//update pay slip
		}
		else{
			$this->load->model('Payroll_model');
			$data = $this->Payroll_model->getPayslip($data['EmployeeNumber'],$data['start_date'],$data['end_date']);
			$data['EmployeeName'] = $this->Payroll_model->getName($data['EmployeeNumber']);
			$this->load->view('EditPayslip_view',$data);
		}//Edit Pay Slip Form is loaded for the 1st time
	}
	
	function UpdatePayslip(){
		//get needed information
		$empnum = $_POST['EmployeeNumber'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		
		$this->load->model('Payroll_model');
		$this->Payroll_model->UpdatePayslip();
		$data = $this->Payroll_model->getPayslip($empnum,$start_date,$end_date);
		$data['EmployeeName'] = $this->Payroll_model->getName($empnum);
		$this->NetPay();
	}//Update a pay slip
	
	function NetPay(){
		//get information
		$empnum = $_POST['EmployeeNumber'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
	
		$this->load->model('Payroll_model');
		$this->Payroll_model->computeNetPay($empnum,$start_date,$end_date);
		$data = $this->Payroll_model->getPayslip($empnum,$start_date,$end_date);
		$data['EmployeeName'] = $this->Payroll_model->getName($empnum);
		$this->load->view('ViewPayslip',$data);
	}//function for computing Withholding Tax
	
	/**VIEW PAY SLIP INDIVIDUALLY
	(FOR NOT SUPERUSER USER RIGHT)**/
	
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
		$this->load->model('Payroll_model');
		$response = $this->Payroll_model->payrollFinalized($payperiod);
		$this->form_validation->set_message('finalized',"This %s is already finalized.");
		
		return $response;
	}//evaluate if payperiod is already finalized
}
?>