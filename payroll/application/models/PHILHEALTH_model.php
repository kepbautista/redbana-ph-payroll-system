<?php
class Philhealth_model extends CI_Model {
	function Philhealthmodel(){
		// load the parent constructor
		parent::_Model();

	}
	
	function get_all_data() {
		// again, we use the db to get the data from table ‘form’
		$data['result']=$this->db->get('philhealth');
		return $data['result'];
	}

	
}
?>