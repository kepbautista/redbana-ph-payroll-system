<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sss_model extends CI_Model {
	function Sssmodel()
	{	
		parent::_Model();	// to load the parent constructor
		$this->load->library('table');	// to invoke the the class name
	}
	
	function Sss_getall()
	{
		$this->load->database();	// loads and initializes the database class
		$query = $this->db->query('SELECT `rangel`,`rangeh`,`msc`,`ser`,`see`,`stotal`,`ecer`,`ter`,`tee`,`ttotal`,`totalcont`,`id` FROM sss GROUP BY `rangel`');
		return $query->result();
	}
	
	function Sss_numrows()
	{
		$this->load->database();	// loads and initializes the database class
		$trows = $this->db->query('SELECT `rangel`,`rangeh`,`msc`,`ser`,`see`,`stotal`,`ecer`,`ter`,`tee`,`ttotal`,`totalcont` FROM sss GROUP BY `rangel`');
		return $trows->num_rows();
	}
	function Sss_update(){
		$this->load->database();	// loads and initializes the database class
		$data = array(
        'rangel'=>$this->input->post('rangel'),
        'rangeh'=>$this->input->post('rangeh'),
		'msc'=>$this->input->post('msc'),
        'ser'=>$this->input->post('ser'),
        'see'=>$this->input->post('see'),
        'stotal'=>$this->input->post('stotal'),
		'ecer'=>$this->input->post('ecer'),
		'ter'=>$this->input->post('ter'),
		'tee'=>$this->input->post('tee'),
		'ttotal'=>$this->input->post('ttotal'),
        'totalcont'=>$this->input->post('totalcont')
		);
		$this->db->where('id',$this->input->post('hidden'));
		$this->db->update('sss',$data);  
	}
	
	function get($id)
	{
		$this->load->database();	
		$query = $this->db->getwhere('sss',array('id'=>$id));
		return $query->row_array();        
	}
}
?>