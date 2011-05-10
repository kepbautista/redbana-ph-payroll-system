<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sss extends CI_Controller {

	function __construct()
	{
		parent::__construct();	// to load controller constructor
		$this->load->helper('url');	// to load the url helper file
		$this->load->library('table');	// to invoke the the class names
	}
	
	function GetAll()
	{
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Sss_model');	// to load a model
		$data['query'] = $this->Sss_model->Sss_getall();
		$data['trows'] = $this->Sss_model->Sss_numrows();
		$this->load->view('sss_view',$data);	// to load a particular view file
	}
	
	function PrintAll($message)
	{
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Sss_model');	// to load a model
		$data['query'] = $this->Sss_model->Sss_getall();
		$data['trows'] = $this->Sss_model->Sss_numrows();
		$data['message'] = $message;
		$this->load->view('sss_view',$data);	// to load a particular view file
	}
	
	function Edit()
	{
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Sss_model');	// to load a model
		$data['edit'] = $this->input->post('hidden');
		$data['query'] = $this->Sss_model->Sss_getall();
		$data['trows'] = $this->Sss_model->Sss_numrows();
		$this->load->view('sss_edit',$data);	// to load a particular view file	
		$this->load->library('session');	// to invoke the the class name
		$this->load->database();	// to load the database and connect to MySQL
		$this->load->library('table');	// to invoke the the class name
		$this->load->helper(array('form','url'));	// load the needed helpers
	}
	
	function Update()
	{
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Sss_model');	// to load a model
		$this->Sss_model->Sss_update();
		$data['query']=$this->Sss_model->Sss_getall();
		$data['trows']=$this->Sss_model->Sss_numrows();
		$this->load->view('sss_view',$data);	// to load a particular view file
	}
	
	function Insert()
	{
		$display = "";
		$flag = $this->ValidateInsert();
		
		if(in_array(1,$flag)) $display = $display."<li>Values should be numeric.</li>";
		if(in_array(2,$flag)) $display = $display."<li>Values should not be negative.</li>";
		
		if($display=="") $this->Insertdb();//add brackets is going to be successful
		else{
			$message = "<ul><li>Adding brackets not successfull.</li>".$display."</ul>";
			$this->PrintAll($message);
		}//add brackets not succesfull
		
	}//function that will insert another bracket to the SSS Table
	
	function Insertdb(){
		$this->load->helper('form');	// to load the url helper file
		$this->load->model('Sss_model');	// to load a model
		$this->Sss_model->SSS_insertBrackets();//insert the brackets
		$data['query'] = $this->Sss_model->Sss_getall();
		$this->GetAll();
	}
	
	function ValidateInsert(){
		$flag = array();
		
		/*Check if all fields have valid values.*/
		foreach($_POST['rangel'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['rangeh'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['msc'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['ser'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['see'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['stotal'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['ecer'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['ter'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['tee'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['ttotal'] as $value) array_push($flag,$this->CheckNumber($value));
		foreach($_POST['totalcont'] as $value) array_push($flag,$this->CheckNumber($value));
	
		return $flag;
	}//this function validates the inserted values for the brackets
	
	function CheckNumber($n){
		if(!is_numeric($n)) return 1;//not a number
		else if($n<0) return 2;//negative number
		else return 0;
	}//check if number is valid or not
}
?>