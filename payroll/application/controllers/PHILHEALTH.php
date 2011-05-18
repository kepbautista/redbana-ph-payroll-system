<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Philhealth extends CI_Controller {

	function __construct()
	{
		parent::__construct();	// to load controller constructor
		$this->load->helper('url');	// to load the url helper file
		$this->load->library('table');	// to invoke the the class name
	}
			
	function GetAll()
	{
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Philhealth_model');	// to load a model
		$data['query'] = $this->Philhealth_model->Philhealth_getall();
		$data['trows'] = $this->Philhealth_model->Philhealth_numrows();
		$this->load->view('philhealth_view',$data);	// to load a particular view file
	}
	
	function PrintAll($message)
	{
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Philhealth_model');	// to load a model
		$data['query'] = $this->Philhealth_model->Philhealth_getall();
		$data['trows'] = $this->Philhealth_model->Philhealth_numrows();
		$data['message'] = $message;
		$this->load->view('philhealth_view',$data);	// to load a particular view file
	}
	
	function Edit()
	{
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Philhealth_model');	// to load a model
		$data['edit'] = $this->input->post('hidden');
		$data['query'] = $this->Philhealth_model->Philhealth_getall();
		$data['trows'] = $this->Philhealth_model->Philhealth_numrows();
		$this->load->view('philhealth_edit',$data);	// to load a particular view file
		$this->load->library('session');	// to invoke the the class name
		$this->load->database();	// to load the database and connect to MySQL
		$this->load->library('table');	// to invoke the the class name
		$this->load->helper(array('form','url'));	// load the needed helpers
	}
				
	function Update()
	{
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Philhealth_model');	// to load a model
		$this->Philhealth_model->Philhealth_update();
		$data['query'] = $this->Philhealth_model->Philhealth_getall();
		$data['trows'] = $this->Philhealth_model->Philhealth_numrows();
		$this->load->view('philhealth_view',$data);	// to load a particular view file
	}

	function Insert()
	{
		$display = "";
		$flag = $this->ValidateInsert();
		
		if(in_array(1,$flag)) $display = $display."<li>Values should be numeric.</li>";
		if(in_array(2,$flag)) $display = $display."<li>Vlaues should not be negative.</li>";
		
		if($display=="") $this->Insertdb();	// add brackets is going to be successful
		else{
			$message = "<ul><li>Adding brckets not successful.</li>".$display."</ul>";
			$this->PrintAll($message);
		}	// add brackets not successful
	}	// function that will insert another bracket to the PhilHealth Table

	function Insertdb(){
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Philhealth_model');	// to load a model
		$this->Philhealth_model->PHILHEALTH_insertBrackets();	// insert the brackets
		$data['query'] = $this->Philhealth_model->Philhealth_getall();
		$this->GetAll();
	}
	
	function ValidateInsert(){
		$flag = array();
		
		// check if all fileds have valid values
		foreach($_POST['bracket'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['rangel'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['rangeh'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['base'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['total'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['pes'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['per'] as $value) array_push($flag,$this->CheckNumber($value));
		
		return $flag;
	}	// this function validates the inserted values for the brackets
	
	function CheckNumber($n){
		if(!is_numeric($n)) return 1;	// not a number
		else if($n<0) return 2;	// negative number
		else return 0;
	}	// check if number is valid or not
	
	function DeleteBrackets(){
		echo $_POST['query'];
	}	// function for deleting a philhealth bracket
}			
?>