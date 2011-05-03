<?php

class Admin_model extends CI_Model {
function Signupmodel(){
// load the parent constructor
parent::__Model;
}
function submit_posted_data($fname, $mname, $sname, $eadd, $empnum,$password,$status,$mrate,$payment_mode,$position,$dept,$gender,$sdate,$bdate,$type) {
// db is initialized in the controller, to interact with the database.
	$data = array('fname'=>$this->input->post('fname'),'mname'=>$this->input->post('mname'),'sname'=>$this->input->post('sname'), 'email'=>$this->input->post('eadd'), 'empnum'=>$this->input->post('empnum'), 'password'=>$this->input->post('password'),'status'=>$this->input->post('status'), 'mrate'=>$this->input->post('mrate'),'payment_mode'=>$this->input->post('payment_mode'),'position'=>$this->input->post('position'),'dept'=>$this->input->post('dept'),'gender'=>$this->input->post('gender'),'sdate'=>$this->input->post('sdate'),'bdate'=>$this->input->post('bdate')); 
	$this->db->insert('employee',$data);
	
}
/*
function get_all_data() {
// again, we use the db to get the data from table ‘form’
$data['result']=$this->db->get('Product');
return $data['result'];
}


function check_exists_username($username){
	
	$query = "SELECT Username from admin where Username = ?";
	$result = $this->db->query($query,$username);
	
	if($result->num_rows() > 0){
		return true;
	}else{
		return false;
	}
}


function getclass($username1){
		$this->db->where('Username', $username1);
		$this->db->select('Class');
		$class1 = $this->db->get('admin');
		echo $class1;
		//if ($stock=='cashier') echo "CASHIER";
		//return $stock;

}		

	*/
function validate_superuser($empnum1)
{
		$this->db->where('empnum', $empnum1);
		$this->db->where('type', "superuser");
		$query = $this->db->get('employee');	
		if($query->num_rows == 1)return true;
		else return false;
}
function validate_hr($empnum1)
{
		$this->db->where('empnum', $empnum1);
		$this->db->where('type', "hr");
		$query = $this->db->get('employee');	
		if($query->num_rows == 1)return true;
		else return false;
}
function validate_accounting($empnum1)
{
		$this->db->where('empnum', $empnum1);
		$this->db->where('type', "accounting");
		$query = $this->db->get('employee');	
		if($query->num_rows == 1)return true;
		else return false;
}
function validate_emp($empnum1)
{
		$this->db->where('empnum', $empnum1);
		$this->db->where('type', "employee");
		$query = $this->db->get('user');	
		if($query->num_rows == 1)return true;
		else return false;
}
function validate_supervisor($empnum1)
{
		$this->db->where('empnum', $empnum1);
		$this->db->where('type', "supervisor");
		$query = $this->db->get('employee');	
		if($query->num_rows == 1)return true;
		else return false;
}
}
?>