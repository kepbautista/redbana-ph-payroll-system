<?php
class Form_model extends CI_Model {
	function Formmodel(){
		// load the parent constructor
		parent::_Model();

	}
	function submit_posted_data() {
		// db is initialized in the controller, to interact with the database. 
		$data = $this->db->get('form'); 
		$this->db->insert('form',$_POST);  
		 
	}
	function get_all_data() {
		// again, we use the db to get the data from table ‘form’
		$data['result']=$this->db->get('form');
		return $data['result'];
	}

	function check_exists_id($id){

		$this->db->where('id', $id);
		$query = $this->db->get('form');
		
		if($query->num_rows() > 0){
			
			return true;
		}else{
			//$this->db->where('name', $name);
			//$query1 = $this->db->get('form');
			//if($query1->num_rows() > 0){
				//return true;
			//}else return false;
			return false;
		}
	}
		
		
function validate($name,$qty, $remarks)
	{
		
		$this->db->where('name', $this->input->post('name'));
		$this->db->where('qty', $this->input->post('qty'));
		$this->db->where('remarks', $this->input->post('remarks'));
		$query = $this->db->get('form');
		
		if($query->num_rows == 1)
		{
		return false;
		}
		else 
		{
		return true;
		}
		
	}
	function delete($checkBox,$i){
		
		$this->db->where('id', $checkBox[$i]);
		$this->db->delete('form');
	}
	
}
?>	
