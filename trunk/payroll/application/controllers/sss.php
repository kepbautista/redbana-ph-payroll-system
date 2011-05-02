<?php
class Sss extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	function GetAll()
	{
	$this->load->helper('form');  
	$this->load->model('Sss_model');
	$data['query']=$this->Sss_model->Sss_getall();
	$data['trows']=$this->Sss_model->Sss_numrows();
	$this->load->view('sss_view',$data);
	}	
	function Edit()
	{
	$this->load->helper('form');  
	$this->load->model('Sss_model');
	$data['edit'] = $this->input->post('hidden');
	$data['query']=$this->Sss_model->Sss_getall();
	$data['trows']=$this->Sss_model->Sss_numrows();
	$this->load->view('sss_edit',$data);	
	}
	function Update()
	{
	$this->load->helper('form');  
	$this->load->model('Sss_model');
	$this->Sss_model->Sss_update();//($this->input->post('hidden'),$this->input->post('rangel'),$this->input->post('rangeh'),$this->input->post('msc'),$this->input->post('ser'),$this->input->post('stotal'),$this->input->post('ecer'),$this->input->post('ter'),$this->input->post('tee'),$this->input->post('ttotal'),$this->input->post('totalcont'));
	$data['query']=$this->Sss_model->Sss_getall();
	$data['trows']=$this->Sss_model->Sss_numrows();
	$this->load->view('sss_view',$data);
	}	
}
?>