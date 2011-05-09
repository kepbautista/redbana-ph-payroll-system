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
}
?>