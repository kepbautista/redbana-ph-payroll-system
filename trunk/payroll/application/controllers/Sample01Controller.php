<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sample01Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Attendance_model");
	}
	
	function index()
	{		
		$this->Attendance_model->getTardiness(3, 1);
		$this->Attendance_model->get_OverTime(3, 1);
		$this->Attendance_model->get_UnderTime(3, 1);
		$this->Attendance_model->get_NightDifferential(3, 1);		
		echo var_dump($this->Attendance_model->generate_OT_and_ND_Cost(3, 1));		
	}
}
	