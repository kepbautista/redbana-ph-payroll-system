<?php
class Maintenance extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
	}
	
	//department maintenance
	function Deptview()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$data['query']=$this->Maintenance_model->Dept_getall();	
		$this->load->view('Dept_view',$data);
	}
	
	function DeptEdit()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$data['query']=$this->Maintenance_model->Dept_getall();	
		$data['edit']=$this->input->post('dept');
		$this->load->view('Dept_edit',$data);
	}
	
	function DeptUpdate()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->Dept_update();	
		$data['query']=$this->Maintenance_model->Dept_getall();	
		$this->load->view('Dept_view',$data);
	}
	
	function DeptInsert()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->Dept_insert();	
		$data['query']=$this->Maintenance_model->Dept_getall();	
		$this->load->view('Dept_view',$data);
	}
	
	function DeptDelete()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->Dept_delete();	
		$data['query']=$this->Maintenance_model->Dept_getall();	
		$this->load->view('Dept_view',$data);
	}
	
	//positon maintenance
	function Posview()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$data['query']=$this->Maintenance_model->Pos_getall();	
		$this->load->view('Pos_view',$data);
	}
	
	function PosEdit()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$data['query']=$this->Maintenance_model->Pos_getall();	
		$data['edit']=$this->input->post('position');
		$this->load->view('Pos_edit',$data);
	}
	
	function PosUpdate()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->Pos_update();	
		$data['query']=$this->Maintenance_model->Pos_getall();	
		$this->load->view('Pos_view',$data);
	}
	
	function PosInsert()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->Pos_insert();	
		$data['query']=$this->Maintenance_model->Pos_getall();	
		$this->load->view('Pos_view',$data);
	}
	
	function PosDelete()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->Pos_delete();	
		$data['query']=$this->Maintenance_model->Pos_getall();	
		$this->load->view('Pos_view',$data);
	}
	
	//User maintenance
	function Userview()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$data['query']=$this->Maintenance_model->User_getall();	
		$this->load->view('User_view',$data);
	}
	
	function UserEdit()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$data['query']=$this->Maintenance_model->User_getall();	
		$data['edit']=$this->input->post('user');
		$this->load->view('User_edit',$data);
	}
	
	function UserUpdate()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->User_update();	
		$data['query']=$this->Maintenance_model->User_getall();	
		$this->load->view('User_view',$data);
	}
	
	function UserInsert()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->User_insert();	
		$data['query']=$this->Maintenance_model->User_getall();	
		$this->load->view('User_view',$data);
	}
	
	function UserDelete()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->User_delete();	
		$data['query']=$this->Maintenance_model->User_getall();	
		$this->load->view('User_view',$data);
	}

	//Employment Type Maintenance
	function Typeview()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$data['query']=$this->Maintenance_model->Type_getall();	
		$this->load->view('Type_view',$data);
	}
	
	function TypeEdit()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$data['query']=$this->Maintenance_model->Type_getall();	
		$data['edit']=$this->input->post('type');
		$this->load->view('Type_edit',$data);
	}
	
	function TypeUpdate()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->Type_update();	
		$data['query']=$this->Maintenance_model->Type_getall();	
		$this->load->view('Type_view',$data);
	}
	
	function TypeInsert()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		
		if ($this->input->post('type')!="")
			$this->Maintenance_model->Type_insert();
			
		$data['query']=$this->Maintenance_model->Type_getall();	
		$this->load->view('Type_view',$data);
	}
	
	function TypeDelete()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->Type_delete();	
		$data['query']=$this->Maintenance_model->Type_getall();	
		$this->load->view('Type_view',$data);
	}
	
	//Tax Maintenance
	function Taxview()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$data['query']=$this->Maintenance_model->Tax_getall();	
		$this->load->view('Tax_view',$data);
	}
	
	function TaxEdit()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$data['query']=$this->Maintenance_model->Tax_getall();	
		$data['edit']=$this->input->post('id');
		$this->load->view('Tax_edit',$data);
	}
	
	function TaxUpdate()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->Tax_update();	
		$data['query']=$this->Maintenance_model->Tax_getall();	
		$this->load->view('Tax_view',$data);
	}
	
	function TaxInsert()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		
		//if ($this->input->post('status')!="" && $this->input->post('ex')!="" && $this->input->post('desc')!="")
		$this->Maintenance_model->Tax_insert();	
		$data['query']=$this->Maintenance_model->Tax_getall();	
		$this->load->view('Tax_view',$data);
	}
	
	function TaxDelete()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->Tax_delete();	
		$data['query']=$this->Maintenance_model->Tax_getall();	
		$this->load->view('Tax_view',$data);
	}
}
?>