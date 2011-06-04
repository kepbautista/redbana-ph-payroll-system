<?php
class Accounting extends CI_Controller {	
	function __construct(){
		parent::__construct();// load Controller constructor
		$this->load->library('session');// load the model we will be using
		$this->load->database();// load the database and connect to MySQL
		$this->load->helper(array('form','url'));// load the needed helpers
	}
				
	function index() {
		if ($this->session->userdata('logged_in') != TRUE)
			redirect('login');
		else $this->load->view('accounting_home');	
	}//Display the posted entries
			
}//Process the posted form			
?>