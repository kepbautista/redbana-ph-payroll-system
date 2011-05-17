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
	
	function WithholdingCompute(){
		$cutoffL = '2011-03-15';
		$cutoffH = '2011-03-31';
		$empnum = '2008-00196';
	
		$this->load->model('ComputePayroll_model');
		$this->ComputePayroll_model->getWithholdingTax($empnum,$cutoffL,$cutoffH);
		
	}//function for computing Withholding Tax
}
?>