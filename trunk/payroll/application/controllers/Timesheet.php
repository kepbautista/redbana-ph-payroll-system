<?php
class Timesheet extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
	}
	function wa()
	{
	$this->load->view('View_time');
	}
	function Inserttodate()
	{
	$this->load->helper('form');  
	$this->load->model('Timesheet_model');
	$data['mos']= $this->Timesheet_model->buildMonthDropdown(); 
	$date_rows=$this->Timesheet_model->Timesheet_viewalltime_rows(1);
	if ($date_rows==0)
	{
		$this->Timesheet_model->insert_time();
	}
	$data['date']=$this->input->post('date');
	$data['trows']=$this->Timesheet_model->Timesheet_viewalltime_rows(1);
	$data['query']=$this->Timesheet_model->Timesheet_viewalltime(1);	
	$data['date_today']=date("Y/n/j");
	$data['mos']= $this->Timesheet_model->buildMonthDropdown(); 
	list($year,$month,$day) = explode('-', $data['date']);
	$data['year_s']=$year;
	$data['month_s']=$month;
	$data['day_s']=$day;
	$this->load->view('date_inserted',$data);
	}
	function EditTime()//view the timesheet for today 
	{
	$this->load->helper('form');  
	$this->load->model('Timesheet_model');
	$data['edit']=$this->input->post('empnum');
	$data['date']=$this->input->post('date');
	$data['hour']=range(00,23);
	$data['minute']=range(00,59);
	$data['second']=range(00,59);
	$data['months'] = $this->Timesheet_model->buildMonthDropdown(); 
	$data['days'] = range(1,31);
	$data['years'] = range(2011,2030); 
	$date=$this->input->post('date');
	list($year,$month,$day) = explode('-', $date);
	$data['mos']= $this->Timesheet_model->buildMonthDropdown(); 
	$data['year_s']=$year;
	$data['month_s']=$month;
	$data['day_s']=$day;
	$data['query']=$this->Timesheet_model->Timesheet_viewalltime(1);	
	$this->load->view('Edit_time',$data);
	}
	function Viewotherdate()//view the timesheet for today 
	{
	$this->load->helper('form');  
	$this->load->model('Timesheet_model');
	$data['date']=$this->input->post('yrs').'-'.$this->input->post('mos').'-'.$this->input->post('days');
	list($year,$month,$day) = explode('-', $data['date']);
	$data['trows']=$this->Timesheet_model->Timesheet_viewalltime_rows(3);
	$data['query']=$this->Timesheet_model->Timesheet_viewalltime(3);	
	$data['mos']= $this->Timesheet_model->buildMonthDropdown(); 
	$data['year_s']=$year;
	$data['date_today']=date("Y/n/j");
	$data['month_s']=$month;
	$data['day_s']=$day;
	$this->load->view('View_otherdate',$data);
	}
	function Updatetime()//view the timesheet for today 
	{
	$this->load->helper('form');  
	$this->load->model('Timesheet_model');
	$this->Timesheet_model->Update();
	list($year,$month,$day) = explode('-', $this->input->post('date'));
	$data['query']=$this->Timesheet_model->Timesheet_viewalltime(1);	
	$data['mos']= $this->Timesheet_model->buildMonthDropdown(); 
	$data['year_s']=$year;
	$data['month_s']=$month;
	$data['day_s']=$day;
	$this->load->view('dateupdated',$data);
	}
	function ViewTimeSheet()//view the timesheet for today 
	{
	$this->load->helper('form');  
	$this->load->model('Timesheet_model');
	$data['date']=date("Y-n-j");
	$date=date("Y/n/j");
	list($year,$month,$day) = explode('/', $date);
	$data['trows']=$this->Timesheet_model->Timesheet_viewalltime_rows(2);
	$data['query']=$this->Timesheet_model->Timesheet_viewalltime(2);	
	$data['mos']= $this->Timesheet_model->buildMonthDropdown(); 
	$data['year_s']=$year;
	$data['month_s']=$month;
	$data['day_s']=$day;
	$this->load->view('View_time',$data);
	}
	
}
?>