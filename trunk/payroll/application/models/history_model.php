<?php
class History_model extends CI_Model {
	//History
	function history_getall() {//select all the list of department
		$this->load->database();
		$query = $this->db->query('SELECT * FROM history');
		return $query->result();
	}

}