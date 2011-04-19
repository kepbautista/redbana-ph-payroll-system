<?php

class Login_model extends CI_Model {
function Signupmodel(){
// load the parent constructor
parent::__Model;
$this->load->library('session');
}

function validate()
	{
		$this->db->where('empnum', $this->input->post('empnum'));
		$this->db->where('password', ($this->input->post('password')));
		$query = $this->db->get('user');
		
		if($query->num_rows == 1)
		{
		
		return true;
		}
		else 
		{
			return false;
		}
		
	}
}

?>