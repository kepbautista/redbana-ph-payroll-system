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
		$this->load->library('form_validation');//load form validation library
	}
	
	function validateForm($type){
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
			case 'day': $this->form_validation->set_rules('desc','Description',
					'required|callback_script_input');
						$this->form_validation->set_rules(floatval('payrate'),'Payrate',
					'required|numeric|greater_than[0]');
					break;
			case 'taxstatus': $this->form_validation->set_rules('status','Tax Status',
					'required|callback_script_input');
							$this->form_validation->set_rules('desc','Description',
					'required|callback_script_input');
							$this->form_validation->set_rules(floatval('ex'),'Exemption',
					'required|numeric|greater_than[0]');
					break;	
		}
	}//function for validating forms
	
	//department maintenance
	function Deptview()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("dept"))
			{
				$data['query']=$this->Maintenance_model->Dept_getall();	
				$this->load->view('Dept_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function DeptEdit()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("dept"))
			{
				$data['query']=$this->Maintenance_model->Dept_getall();	
				$data['edit']=$this->input->post('dept');
				$this->load->view('Dept_edit',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function DeptUpdate()//main page of department maintenance
	{
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("dept"))
			{
				$data['query'] = $this->Maintenance_model->Dept_getall();
				$this->validateForm('dept');
				
				if($this->form_validation->run() == FALSE)
					$this->load->view('Dept_view',$data);
					//validation errors are present
				else $this->UpdateDept();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}	
	function DeptInsert()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("dept"))
			{
				$data['query'] = $this->Maintenance_model->Dept_getall();
				$this->validateForm('dept');
				
				if($this->form_validation->run() == FALSE)
					$this->load->view('Dept_view',$data);
					//validation errors are present
				else $this->InsertDept();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function UpdateDept(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("dept"))
			{
				$this->Maintenance_model->Dept_update();
				$data['query'] = $this->Maintenance_model->Dept_getall();
				$this->load->view('Dept_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}//function for updating a department
	
	function InsertDept(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("dept"))
			{
				$this->Maintenance_model->Dept_insert();
				$data['query'] = $this->Maintenance_model->Dept_getall();
				$this->load->view('Dept_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}//function for adding a department
	
	//positon maintenance
	function Posview()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("position"))
			{
				$data['query']=$this->Maintenance_model->Pos_getall();	
				$this->load->view('Pos_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function PosEdit()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("position"))
			{
				$data['query']=$this->Maintenance_model->Pos_getall();	
				$data['edit']=$this->input->post('position');
				$this->load->view('Pos_edit',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');

	}
	
	function PosUpdate()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("position"))
			{
				$data['query'] = $this->Maintenance_model->Pos_getall();
				$this->validateForm('position');
				
				if ($this->form_validation->run() == FALSE)
					$this->load->view('Pos_view',$data);
					//validation errors are present
				else $this->UpdatePos();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function PosInsert()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("position"))
			{
				$data['query'] = $this->Maintenance_model->Pos_getall();
				$this->validateForm('position');
				
				if ($this->form_validation->run() == FALSE)
					$this->load->view('Pos_view',$data);
					//validation errors are present
				else $this->InsertPos();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function UpdatePos(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("position"))
			{
				$this->Maintenance_model->Pos_update();
				$data['query'] = $this->Maintenance_model->Pos_getall();
				$this->load->view('Pos_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}//function for updating a position
	
	function InsertPos(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("position"))
			{
				$this->Maintenance_model->Pos_insert();
				$data['query'] = $this->Maintenance_model->Pos_getall();
				$this->load->view('Pos_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}//function for adding a position
	
	//User maintenance
	function Userview()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("user"))
			{
				$data['query']=$this->Maintenance_model->User_getall();	
				$this->load->view('User_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');

	}
	
	function UserEdit()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("user"))
			{
				$data['query']=$this->Maintenance_model->User_getall();	
				$data['edit']=$this->input->post('user');
				$this->load->view('User_edit',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function UserUpdate()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("user"))
			{
				$data['query']=$this->Maintenance_model->User_getall();	
				$this->validateForm('user');
				
				if ($this->form_validation->run() == FALSE)
					$this->load->view('User_view',$data);
					//validation errors are present
				else $this->UpdateUser();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function UserInsert()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("user"))
			{
				$data['query'] = $this->Maintenance_model->User_getall();
				$this->validateForm('user');		
				
				if($this->form_validation->run() == FALSE)
					$this->load->view('User_view',$data);
				else $this->InsertUser();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function InsertUser(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("user"))
			{
				$this->Maintenance_model->User_insert();
				$data['query']=$this->Maintenance_model->User_getall();
				$this->load->view('User_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}//function for adding a user right
	
	function UpdateUser(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("user"))
			{
				$this->Maintenance_model->User_update();
				$data['query']=$this->Maintenance_model->User_getall();
				$this->load->view('User_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}//function for updating a user right

	//Employment Type Maintenance
	function Typeview()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("type"))
			{
				$data['query'] = $this->Maintenance_model->Type_getall();	
				$this->load->view('Type_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function TypeEdit()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("type"))
			{
				$data['query'] = $this->Maintenance_model->Type_getall();	
				$data['edit'] = $this->input->post('type');
				$this->load->view('Type_edit',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function TypeUpdate()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("type"))
			{
				$data['query'] = $this->Maintenance_model->Type_getall();	
				$this->validateForm('type');
				
				if ($this->form_validation->run() == FALSE)
					$this->load->view('Type_view',$data);
					//validation errors are present
				else $this->UpdateType();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function TypeInsert()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("type"))
			{
				$data['query'] = $this->Maintenance_model->Type_getall(); 
				$this->validateForm('type');
				
				if ($this->form_validation->run() == FALSE)
					$this->load->view('Type_view',$data);
					//validation errors are present
				else $this->InsertType();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function UpdateType(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("type"))
			{
				$this->Maintenance_model->Type_update();
				$data['query'] = $this->Maintenance_model->Type_getall();
				$this->load->view('Type_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}//function for updating employee type
	
	function InsertType(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("type"))
			{
				$this->Maintenance_model->Type_insert();
				$data['query'] = $this->Maintenance_model->Type_getall();
				$this->load->view('Type_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}//function for inserting an employee type to the database
	
	//Tax Maintenance
	function Taxview()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("taxstatus"))
			{
				$data['query']=$this->Maintenance_model->Tax_getall();	
				$this->load->view('Tax_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function TaxEdit()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("taxstatus"))
			{
				$data['query']=$this->Maintenance_model->Tax_getall();	
				$data['edit']=$this->input->post('id');
				$this->load->view('Tax_edit',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');

	}
	
	function TaxUpdate()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("taxstatus"))
			{
				$data['query']=$this->Maintenance_model->Tax_getall();
				$this->validateForm('taxstatus');
				if ($this->form_validation->run() == FALSE)
					$this->load->view('Tax_view',$data);
					//validation errors are present
				else $this->UpdateTax();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function TaxInsert()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("taxstatus"))
			{
				$data['query']=$this->Maintenance_model->Tax_getall();
				$this->validateForm('taxstatus');
				
				if ($this->form_validation->run() == FALSE)
					$this->load->view('Tax_view',$data);
					//validation errors are present
				else $this->InsertTax();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function UpdateTax(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("taxstatus"))
			{
				$this->Maintenance_model->Tax_update();
				$data['query']=$this->Maintenance_model->Tax_getall();
				$this->load->view('Tax_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}//function for updating tax status
	
	function InsertTax(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("taxstatus"))
			{
				$this->Maintenance_model->Tax_insert();
				$data['query']=$this->Maintenance_model->Tax_getall();
				$this->load->view('Tax_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');

	}//function for adding a tax status
	//Daily Description
	function dayview()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("day"))
			{
				$this->load->helper('form');  
				$this->load->model('Maintenance_model');
				$data['query']=$this->Maintenance_model->day_getall();	
				$this->load->view('day_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function dayEdit()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("day"))
			{
				$this->load->helper('form');  
				$this->load->model('Maintenance_model');
				$data['query']=$this->Maintenance_model->day_getall();	
				$data['edit']=$this->input->post('title');
				$this->load->view('day_edit',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	
	function dayUpdate()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("day"))
			{
				$this->load->helper('form');  
				$data['query'] = $this->Maintenance_model->day_getall();
				$this->load->model('Maintenance_model');	
				$this->validateForm('day');	
				if ($this->form_validation->run() == FALSE)
					$this->load->view('day_view',$data);
					//validation errors are present
				else $this->UpdateDay();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	function dayInsert()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("day"))
			{
				$this->load->helper('form');  
				$data['query'] = $this->Maintenance_model->day_getall();
				$this->load->model('Maintenance_model');
				$this->validateForm('day');
				if ($this->form_validation->run() == FALSE)
					$this->load->view('day_view',$data);
					//validation errors are present
				else $this->InsertDay();
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	function UpdateDay(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("day"))
			{
				$this->Maintenance_model->day_update();
				$data['query']=$this->Maintenance_model->day_getall();
				$this->load->view('day_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}//function for updating type of day
	function InsertDay(){
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("day"))
			{
				$this->Maintenance_model->day_insert();
				$data['query']=$this->Maintenance_model->day_getall();
				$this->load->view('day_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}//function for inserting type of day
	function dayDelete()//main page of department maintenance
	{	
		if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("day"))
			{
				$this->load->helper('form');  
				$this->load->model('Maintenance_model');
				$this->Maintenance_model->day_delete();	
				$data['query']=$this->Maintenance_model->day_getall();	
				$this->load->view('day_view',$data);
			}else $this->load->view('no_access');
		}
		else
			redirect('login');
	}
	function duplicate_type($str){
		$response = $this->Maintenance_model->duplicate_Type($str);	
		$this->form_validation->set_message('duplicate_type','"'.$str.'" %s already exists.');
		return $response;
	}//check if duplicate type
	
	function duplicate_usertype($str){	
		$response = $this->Maintenance_model->duplicate_usertype($str);
		$this->form_validation->set_message('duplicate_usertype','"'.$str.'" %s already exists.');
		return $response;
	}//check if duplicate user type
	function duplicate_daytype($str){	
		$response = $this->Maintenance_model->duplicate_daytype($str);
		$this->form_validation->set_message('duplicate_daytype','"'.$str.'" %s already exists.');
		return $response;
	}
	function duplicate_positiontype($str){	
		$response = $this->Maintenance_model->duplicate_positiontype($str);
		$this->form_validation->set_message('duplicate_positiontype','"'.$str.'" %s already exists.');
		return $response;
	}//check if duplicate position type
	
	function duplicate_department($str){	
		$response = $this->Maintenance_model->duplicate_department($str);
		$this->form_validation->set_message('duplicate_department','"'.$str.'" %s already exists.');
		return $response;
	}//check if duplicate position typefunction duplicate_department($str){

	function duplicate_taxstatus($str){
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