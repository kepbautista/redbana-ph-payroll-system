<?php
class Maintenance_model extends CI_Model {
	//Department Maintenance
	function Dept_getall() {//select all the list of department
		$this->load->database();
		$query = $this->db->query('SELECT * FROM dept_main');
		return $query->result();
	}
	function Dept_update(){//Update a department
		$dept=$this->input->post('dept');
		$id=$this->input->post('id');		
		$this->db->query('UPDATE dept_main SET dept="'.$dept.'" WHERE id="'.$id.'"');
	}
	function Dept_delete(){//delete a department
		$this->db->where('id',$this->input->post('id'));
		$this->db->delete('dept_main'); 
	}
	function Dept_insert(){//insert department
		$data=$this->input->post('dept');
		$this->db->query('INSERT INTO dept_main(`dept`) VALUES ("'.$data.'")');
	}
	//Position Maintenance
	function Pos_getall() {//select all the list of position
		$this->load->database();
		$query = $this->db->query('SELECT * FROM pos_main');
		return $query->result();
	}
	function Pos_update(){//Update a department
		$position=$this->input->post('position');
		$id=$this->input->post('id');		
		$this->db->query('UPDATE pos_main SET position="'.$position.'" WHERE id="'.$id.'"');
	}
	function Pos_delete(){//delete a department
		$this->db->where('id',$this->input->post('id'));
		$this->db->delete('pos_main'); 
	}
	function Pos_insert(){//insert department
		$data=$this->input->post('position');
		$this->db->query('INSERT INTO pos_main(`position`) VALUES ("'.$data.'")');
	}
	//User Maintenance
	function User_getall() {//select all the list of position
		$this->load->database();
		$query = $this->db->query('SELECT DISTINCT `user_right` FROM user_main');
		return $query->result();
	}
	function User_update(){//Update a department
		$user=$this->input->post('user');
		$this->db->query('UPDATE user_main SET user_right="'.$user.'" WHERE user_right="'.$this->input->post('hidden').'"');
	}
	function User_delete(){//delete a department
		//$this->db->where('id',$this->input->post('id'));
		//$this->db->delete('user_main');
		$this->db->query('DROP TABLE `'.$this->input->post('user_right').'`');
	}
	function User_insert(){//insert department
		$data=$this->input->post('user');
		$this->db->query('INSERT INTO user_main(`user_right`,`privilege`) VALUES ("'.$data.'","addemp")');
		$this->db->query('INSERT INTO user_main(`user_right`,`privilege`) VALUES ("'.$data.'","viewemp")');
	}
	//Employee Type Maintenance
	function Type_getall() {//select all the list of employee type
		$this->load->database();
		$query = $this->db->query('SELECT * FROM emp_type');
		return $query->result();
	}
	function Type_update(){//Update an employee type
		$type=$this->input->post('type');
		$id=$this->input->post('id');		
		$this->db->query('UPDATE emp_type SET type="'.$type.'" WHERE id="'.$id.'"');
	}
	function Type_delete(){//delete a type
		$this->db->where('id',$this->input->post('id'));
		$this->db->delete('emp_type'); 
	}
	function Type_insert(){//insert type
		$data=$this->input->post('type');
		$this->db->query('INSERT INTO emp_type(`type`) VALUES ("'.$data.'")');
	}
	//Tax Maintenance
	function Tax_getall() {//select all the list of employee type
		$this->load->database();
		$query = $this->db->query('SELECT * FROM tax_status');
		return $query->result();
	}
	function Tax_update(){//Update an employee type
		$status=$this->input->post('status');
		$desc=$this->input->post('desc');
		$ex=$this->input->post('ex');
		$id=$this->input->post('id');		
		$this->db->query('UPDATE tax_status SET `status`="'.$status.'",`desc`="'.$desc.'",`exemption`="'.$ex.'" WHERE `id`="'.$id.'"');
	}
	function Tax_delete(){//delete a type
		$this->db->where('id',$this->input->post('id'));
		$this->db->delete('tax_status'); 
	}
	function Tax_insert(){//insert type
		$status=$this->input->post('status');
		$desc=$this->input->post('desc');
		$ex=$this->input->post('ex');
		$this->db->query('INSERT INTO tax_status(`status`,`desc`,`exemption`) VALUES ("'.$status.'","'.$desc.'","'.$ex.'")');
	}
}
?>