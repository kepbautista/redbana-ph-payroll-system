<?php
class History_model extends CI_Model {
	//History
	function history_getall() {//select all the list of department
		$this->load->database();
		$query = $this->db->query('SELECT DATE_FORMAT (`date`, "%M %e, %Y, %l:%i%p") AS date,DATE_FORMAT (`date`, "%l:%i%p") AS time, `user`, `person`,`table`,`action`,`data` FROM history  ORDER BY `id` DESC');
		return $query;
	}

}