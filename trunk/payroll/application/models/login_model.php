<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}
	
	//by abe, 03may2011 1711H : ano ba talaga, 'Signupmodel' which does not correspond to the filename of our model or '__construct()' ?
	//remove either upon deciding.
	
	/*function Signupmodel()
	{
		// load the parent constructor
		parent::__Model;
		$this->load->library('session');
	}*/

	function validate()
	{
		$this->db->where('empnum', $this->input->post('empnum'));
		$this->db->where('password', ($this->input->post('password')));
		$query = $this->db->get('employee');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		else 
		{
			return false;
		}
		
	}
	
	function isUser_LoggedIn()
	{
		/*
		*	Made by abe, 03may2011 1702
		*   -basically checks whether a user is still logged in.
		*	-useful so that, only logged in users can access the functionalities.
		*/
		$result = $this->session->userdata('logged_in');
		
		return $result;
	}
}//CLASS

/* End of file login_model.php */
/* Location: ./application/models/login_model.php */