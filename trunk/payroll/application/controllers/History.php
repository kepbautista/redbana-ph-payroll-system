<?php
class Maintenance extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->model('Maintenance_model');
		$this->load->model('login_model');
		if ( ($this->login_model->isUser_LoggedIn())==FALSE ) 	
		{			
			redirect('login');
		}
		else
		{
			if (($this->login_model->can_Access("history"))==FALSE)
				redirect('super');
		}
	}
	function history()//main page of history
	{	
		$data['query']=$this->Maintenance_model->history_getall();	
		$this->load->view('history_view',$data);	
	}
}		
?>