<?php
class Timesheet extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		global $data;

		$data = array();
		
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('form');  		
		$this->load->model('Timesheet_model');
		$this->load->model('Shift_model');
		$this->load->model('Attendance_model');
		
		$data['absence_reason_category'] = $this->Attendance_model->getAbsenceReasons();
		
	}
	
	function wa()
	{
		$this->load->view('View_time');
	}
	
	function Inserttodate()
	{
		$data['absence_reasons'] = $this->Attendance_model->getAbsenceReasons();
		$data['shifts'] = $this->Shift_model->makeAssociativeArray_of_Shifts();
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
	
		$data['absence_reasons'] = $this->Attendance_model->getAbsenceReasons();
		$data['shifts'] = $this->Shift_model->makeAssociativeArray_of_Shifts();
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
		$data['absence_reasons'] = $this->Attendance_model->getAbsenceReasons();
		$data['type']=$this->Timesheet_model->get_desc();
		$data['shifts'] = $this->Shift_model->makeAssociativeArray_of_Shifts();		
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
	
		$data['absence_reasons'] = $this->Attendance_model->getAbsenceReasons();
		$data['shifts'] = $this->Shift_model->makeAssociativeArray_of_Shifts();		
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
		$data['date']=date("Y-n-j");
		$date=date("Y/n/j");
		$data['type']=$this->Timesheet_model->get_desc();
		list($year,$month,$day) = explode('/', $date);
		$data['absence_reasons'] = $this->Attendance_model->getAbsenceReasons();
		$data['shifts'] = $this->Shift_model->makeAssociativeArray_of_Shifts();
		//die(var_dump($data['shifts']));
		$data['trows']=$this->Timesheet_model->Timesheet_viewalltime_rows(2);
		$data['query']=$this->Timesheet_model->Timesheet_viewalltime(2);	
		//die(var_dump($data['query']));
		$data['mos']= $this->Timesheet_model->buildMonthDropdown(); 
		$data['year_s']=$year;
		$data['month_s']=$month;
		$data['day_s']=$day;
		$this->load->view('View_time',$data);
	}
	
}
?>