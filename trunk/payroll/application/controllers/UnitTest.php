<?php
/*File Name: UnitTest.php
  Date: June 2, 2011
  Program Description: Unit Test for Functions
  
	Guide:
	$test - function to be tested (preferably, a function with
			return value)
	$expected_result - result that you expect to see from the test
	$test_name (optional) - brief description of the function
						    to be tested
							
	Reminders:
	*If you created a new test, please add this to the
		list of tests. The file "functions_tested.txt"
		is located in the base folder (payroll folder).
		This is also the location of redbana_payroll.sql
		Please follow the format. If you want to know the 
		format, please refer to Function Number 1.
	*To see how unit test works, type in your url: 
	 For function w/o parameter:
		"http://localhost/payroll/index.php/unittest/index"
	 For function w/ parameter:
		"http://localhost/payroll/index.php/unittest/payrollfinalized/3"
	*This controller is not included in the list of functionalities for
		our project. It's only for testing purposes so, no need
		to create views, models, sessions, privileges, etc. for this
		functionality/controller.
*/
class UnitTest extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('unit_test');
		$this->load->model('Payroll_model');
	}
	
	function runTest($test,$expected_result,$test_name){
		$this->unit->run($test,$expected_result,$test_name);
		echo $this->unit->report();
	}//run unit testing
	
	function index(){
		$test = 1 + 1;
		$expected_result = 2;
		$test_name = 'Adds one plus one';
		$this->runTest($test,$expected_result,$test_name);
	}//a simple test
	
	function payrollfinalized($check){
		$test = $this->Payroll_model->payrollfinalized($check);
		$expected_result = false;
		$test_name = "Check if pay period is finalized";
		$this->runTest($test,$expected_result,$test_name);
	}//test for payrollfinalized function in Payroll_model
}
?>