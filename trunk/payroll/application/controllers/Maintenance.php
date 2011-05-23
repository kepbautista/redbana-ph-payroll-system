<?php
class Maintenance extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
	}
	
	function validateForm($type){
		//load form validation library
		$this->load->library('form_validation');
		
		switch($type){
		case 'user': $this->form_validation->set_rules($type,'User Right',
				'required|callback_script_input|callback_duplicate_usertype');
				break;
		case 'position': $this->form_validation->set_rules($type,'Position',
				'required|callback_script_input|callback_duplicate_positiontype');
				break;
		case 'dept': $this->form_validation->set_rules($type,'Department',
				'required|callback_script_input|callback_duplicate_department');
				break;
		case 'type': $this->form_validation->set_rules($type,'Employee Type',
				'required|callback_script_input|callback_duplicate_type');
				break;
		case 'taxstatus': $this->form_validation->set_rules('status','Tax Status',
				'required|callback_script_input|callback_duplicate_taxstatus');
						  $this->form_validation->set_rules('desc','Description',
				'required|callback_script_input');
						  $this->form_validation->set_rules('ex','Exemption',
				'required|numeric|greater_than[0]');
				break;	
		}
		
	}//function for validating forms
	
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
		$this->validateForm('dept');
		if($this->form_validation->run() == TRUE)
		{
			$this->Maintenance_model->Dept_update();
			redirect('maintenance/deptview');
		}
	}	
	function DeptInsert()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		
		$this->validateForm('dept');
		
		if($this->form_validation->run() == TRUE)
		{
			$this->Maintenance_model->Dept_insert();
			redirect('maintenance/deptview');
		}	
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
		
		$this->validateForm('position');
		
		if ($this->form_validation->run() == TRUE)
		{	
			$this->Maintenance_model->Pos_update();	
			redirect('maintenance/posview');
		}
	}
	
	function PosInsert()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		
		$this->validateForm('position');
		
		if ($this->form_validation->run() == TRUE)
		{
			$this->Maintenance_model->Pos_insert();	
			redirect('maintenance/posview');
		}
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
		$data['query']=$this->Maintenance_model->User_getall();	
		
		$this->validateForm('user');
		
		if ($this->form_validation->run() == TRUE)
			$this->Maintenance_model->User_update();
		
		$this->load->view('User_view',$data);
	}
	
	function UserInsert()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$data['query']=$this->Maintenance_model->User_getall();
		
		$this->validateForm('user');		
		
		if($this->form_validation->run() == FALSE)
			$this->load->view('User_view',$data);
		else $this->InsertUser();
	}
	
	function InsertUser(){
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
		
		$this->validateForm('type');	
		if ($this->form_validation->run() == TRUE)
		{
			$this->Maintenance_model->Type_update();
			redirect('maintenance/typeview');
		}
	}
	
	function TypeInsert()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		
		$this->validateForm('type');
		
		if ($this->form_validation->run() == TRUE)
		{
			$this->Maintenance_model->Type_insert();
			redirect('maintenance/typeview');
		}
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
		
		$this->validateForm('taxstatus');
		
		if ($this->form_validation->run() == TRUE)
		{
			$this->Maintenance_model->Tax_update();
			redirect('maintenance/taxview');
		}
	}	
	function TaxInsert()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		
		$this->validateForm('taxstatus');
		
		if ($this->form_validation->run() == TRUE)
		{
			$this->Maintenance_model->Tax_insert();
			redirect('maintenance/taxview');
		}
	}
	
	function TaxDelete()//main page of department maintenance
	{	
		$this->load->helper('form');  
		$this->load->model('Maintenance_model');
		$this->Maintenance_model->Tax_delete();	
		$data['query']=$this->Maintenance_model->Tax_getall();	
		$this->load->view('Tax_view',$data);
	}
	
	function duplicate_type($str){	
		$this->load->helper('form'); 
		$this->load->model('Maintenance_model');
		$response = $this->Maintenance_model->duplicate_Type($str);
		
		$this->form_validation->set_message('duplicate_type','"'.$str.'" %s already exists.');
		
		return $response;
	}//check if duplicate type
	
	function duplicate_usertype($str){	
		$this->load->helper('form'); 
		$this->load->model('Maintenance_model');
		$response = $this->Maintenance_model->duplicate_usertype($str);
		
		$this->form_validation->set_message('duplicate_usertype','"'.$str.'" %s already exists.');
		
		return $response;
	}//check if duplicate user type
	
	function duplicate_positiontype($str){	
		$this->load->helper('form'); 
		$this->load->model('Maintenance_model');
		$response = $this->Maintenance_model->duplicate_positiontype($str);
		
		$this->form_validation->set_message('duplicate_positiontype','"'.$str.'" %s already exists.');
		
		return $response;
	}//check if duplicate position type
	
	function duplicate_department($str){	
		$this->load->helper('form'); 
		$this->load->model('Maintenance_model');
		$response = $this->Maintenance_model->duplicate_department($str);
		
		$this->form_validation->set_message('duplicate_department','"'.$str.'" %s already exists.');
		
		return $response;
	}//check if duplicate position typefunction duplicate_department($str){

	function duplicate_taxstatus($str){	
		$this->load->helper('form'); 
		$this->load->model('Maintenance_model');
		$response = $this->Maintenance_model->duplicate_taxstatus($str);
		
		$this->form_validation->set_message('duplicate_taxstatus','"'.$str.'" %s already exists.');
		
		return $response;
	}//check if duplicate tax status		
	
	function script_input($str){
		$response = TRUE;
	
		//user entered a script as input
		if((stripos($str,"script") !== false)){
			if((stripos($str,"<") !== false) && (stripos($str,">") !== false)){
				$this->form_validation->set_message('script_input', 'Invalid &ltscript&gt&lt/script&gt input for %s');
				$response = FALSE;
			}
		}	
		return $response;
	}//check if user entered a script as input
	
}
?>