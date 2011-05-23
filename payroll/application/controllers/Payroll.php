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
	
	function PayrollInfoView(){
		$this->load->model('Payroll_model');
		$data['payperiod'] = $this->Payroll_model->getPayPeriods();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('payperiod','Pay Period','callback_finalized');
		
		if($this->form_validation->run() == TRUE)
			echo ":)";
			/*Gagawin 'pag i-ffinalize na natin si payroll...*/
		
		$this->load->view('Payroll_view',$data);
	}//view the payroll for specified cutoff

	function EditPayslip(){
		//get information
		$empnum = $this->input->post('empnum');
		$startDate = $this->input->post('startDate');
		$endDate = $this->input->post('endDate');
		
		$this->load->model('Payroll_model');
		$data = $this->Payroll_model->getPayslip($empnum,$startDate,$endDate);
		$data['EmployeeName'] = $this->Payroll_model->getName($empnum);
		
		$this->load->view('EditPayslip_view',$data);
	}
	
	function NetPay(){
		$cutoffL = '2011-04-24';
		$cutoffH = '2011-05-07';
		$empnum = '2008-00196';
	
		$this->load->model('Payroll_model');
		$this->Payroll_model->computeNetPay($empnum,$cutoffL,$cutoffH);
		
	}//function for computing Withholding Tax
	
	function finalized($payperiod){
		$this->load->model('Payroll_model');
		$response = $this->Payroll_model->payrollFinalized($payperiod);
		$this->form_validation->set_message('finalized',"This %s is already finalized.");
		
		return $response;
	}//evaluate if payperiod is already finalized
}
?>