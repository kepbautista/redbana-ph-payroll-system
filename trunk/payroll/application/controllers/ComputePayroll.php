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
	}
	
	function PayrollInfoView(){
		$this->load->view('ComputePayroll_view');
	}
	
	function NetPay(){
		$cutoffL = '2011-05-01';
		$cutoffH = '2011-05-15';
		$empnum = '2008-00196';
	
		$this->load->model('ComputePayroll_model');
		$this->ComputePayroll_model->computeNetPay($empnum,$cutoffL,$cutoffH);
		
	}//function for computing Withholding Tax
}
?>