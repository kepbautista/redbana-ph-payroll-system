<?php
	class Philhealth_model extends CI_Model{
		function Philhealthmodel()
		{
			parent::_Model();	// to load the parent constructor
		}
	
		function Philhealth_getall()
		{
			$this->load->database();	// loads and initializes the database class
			$query = $this->db->query('SELECT `bracket`, `rangel`, `rangeh`, `base`, `total`, `pes`, `per`,`id` FROM philhealth GROUP BY `rangel`');
			return $query->result();
			//$data['result']=$this->db->get('philhealth');
			//return $data['result'];
		}

		function Philhealth_numrows()
		{
			$this->load->database();	// loads and initializes the database class
			$trows = $this->db->query('SELECT `bracket`, `rangel`, `rangeh`, `base`, `total`, `pes`, `per` FROM philhealth GROUP BY `rangel`');
			return $trows->num_rows();
		}
		
		function Philhealth_update()
		{
			$this->load->database();	// loads and initializes the database class
			$data = array(
			'bracket'=>$this->input->post('bracket'),
			'rangel'=>$this->input->post('rangel'),
			'rangeh'=>$this->input->post('rangeh'),
			'base'=>$this->input->post('base'),
			'total'=>$this->input->post('total'),
			'pes'=>$this->input->post('pes'),
			'per'=>$this->input->post('per')
			);
			
			$this->db->where('id',$this->input->post('hidden'));
			$this->db->update('philhealth',$data);  
		}
		
		function get($id)
		{
			$this->load->database();	// loads and initializes the database class
			$query = $this->db->getwhere('philhealth',array('id'=>$id));
			return $query->row_array();
		}
}
?>