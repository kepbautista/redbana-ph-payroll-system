<?php
class History extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->model('history_model');
		$this->load->model('login_model');
	}
	
	function getall()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("history"))
			{
				$data['query']=$this->history_model->history_getall();	
				$data['trows']=$data['query']->num_rows();
				$this->load->view('history_view',$data);	
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
}
?>