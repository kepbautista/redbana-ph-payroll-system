<?php
/*File Name: ComputePayroll.php
  Date: May 17, 2011
  Program Description: Contains all payroll computations.
*/
class ComputePayroll extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('form');
	}
	
	function PayrollInfoView(){
		$this->load->model('ComputePayroll_model');
		$data['payperiod'] = $this->ComputePayroll_model->getPayPeriods();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('payperiod','Pay Period','callback_finalized');
		
		
		if($this->form_validation->run() == TRUE)
			echo ":)";
			/*Gagawin 'pag i-ffinalize na natin si payroll...*/
		
		$this->load->view('ComputePayroll_view',$data);
	}
	
	function NetPay(){
		$cutoffL = '2011-05-01';
		$cutoffH = '2011-05-15';
		$empnum = '2008-00196';
	
		$this->load->model('ComputePayroll_model');
		$this->ComputePayroll_model->computeNetPay($empnum,$cutoffL,$cutoffH);
		
	}//function for computing Withholding Tax
	
	function finalized($payperiod){
		$this->load->model('ComputePayroll_model');
		$response = $this->ComputePayroll_model->payrollFinalized($payperiod);
		$this->form_validation->set_message('finalized',"This %s is already finalized.");
		
		return $response;
	}//evaluate if payperiod is already finalized
}
?>