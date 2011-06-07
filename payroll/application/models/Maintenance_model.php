<?php
class Maintenance_model extends CI_Model {
	//Department Maintenance
	function Dept_getall() {//select all the list of department
		$this->load->database();
		$query = $this->db->query('SELECT * FROM dept_main');
		return $query->result();
	}
	function Dept_update(){//Update a department
		$dept = mysql_real_escape_string($this->input->post('dept'));
		$id = mysql_real_escape_string($this->input->post('id'));
		$this->db->query('UPDATE dept_main SET dept="'.$dept.'" WHERE id="'.$id.'"');
	}
	function Dept_delete(){//delete a department
		$this->db->where('id',$this->input->post('id'));
		$this->db->delete('dept_main'); 
	}
	function Dept_insert(){//insert department
		$data = mysql_real_escape_string($this->input->post('dept'));
		$this->db->query('INSERT INTO dept_main(`dept`) VALUES ("'.$data.'")');
		$this->insert_history("dept_main","insert",$data);
	}
	//Position Maintenance
	function Pos_getall() {//select all the list of position
		$this->load->database();
		$query = $this->db->query('SELECT * FROM pos_main');
		return $query->result();
	}
	function Pos_update(){//Update a department
		$position = mysql_real_escape_string($this->input->post('position'));
		$id = mysql_real_escape_string($this->input->post('id'));		
		$this->db->query('UPDATE pos_main SET position="'.$position.'" WHERE id="'.$id.'"');
	}
	function Pos_delete(){//delete a department
		$this->db->where('id',$this->input->post('id'));
		$this->db->delete('pos_main'); 
	}
	function Pos_insert(){//insert department
		$data = mysql_real_escape_string($this->input->post('position'));
		$this->db->query('INSERT INTO pos_main(`position`) VALUES ("'.$data.'")');
		$this->insert_history("pos_main","insert",$data);
	}
	//User Maintenance
	function User_getall() {//select all the list of position
		$this->load->database();
		$query = $this->db->query('SELECT DISTINCT `user_right` FROM user_main');
		return $query->result();
	}
	function User_update(){//Update a department
		$user = mysql_real_escape_string($this->input->post('user'));
		$this->db->query('UPDATE user_main SET user_right="'.$user.'" WHERE user_right="'.$this->input->post('hidden').'"');
	}
	function User_delete(){//delete a department
		//$this->db->where('id',$this->input->post('id'));
		//$this->db->delete('user_main');
		$this->db->query('DROP TABLE `'.$this->input->post('user_right').'`');
	}	
	function User_insert(){//insert department
		$data=$this->input->post('user');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","viewemp")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","editemp")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","addemp")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","allleave")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","accleave")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","position")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","dept")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","taxstatus")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","shift")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","sss")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","phil")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","wth")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","access")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","user")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","type")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","day")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","timesheet")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","1","viewpay")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","1","leave")');
		$this->db->query('INSERT INTO user_main(`user_right`,`type`,`privilege`) VALUES ("'.$data.'","0","history")');
		$this->insert_history("user_main","insert",$data);
	}
	//Employee Type Maintenance
	function Type_getall() {//select all the list of employee type
		$this->load->database();
		$query = $this->db->query('SELECT * FROM emp_type');
		return $query->result();
	}
	function Type_update(){//Update an employee type
		$type = mysql_real_escape_string($this->input->post('type'));
		$id = mysql_real_escape_string($this->input->post('id'));		
		$this->db->query('UPDATE emp_type SET type="'.$type.'" WHERE id="'.$id.'"');
	}
	function Type_delete(){//delete a type
		$this->db->where('id',$this->input->post('id'));
		$this->db->delete('emp_type'); 
	}
	function Type_insert(){//insert type
		
		$data = mysql_real_escape_string($this->input->post('type'));
		$this->insert_history("emp_type","insert",$data);
		$this->db->query('INSERT INTO emp_type(`type`) VALUES ("'.$data.'")');
	}
	//Tax Maintenance
	function Tax_getall() {//select all the list of employee type
		$this->load->database();
		$query = $this->db->query('SELECT * FROM `tax_status` ORDER BY status');
		return $query->result();
	}
	function Tax_update(){//Update an employee type
		$status = mysql_real_escape_string($this->input->post('status'));
		$desc = mysql_real_escape_string($this->input->post('desc'));
		$ex = mysql_real_escape_string($this->input->post('ex'));
		$id = mysql_real_escape_string($this->input->post('id'));
		$this->db->query('UPDATE tax_status SET `status`="'.$status.'",`desc`="'.$desc.'",`exemption`="'.$ex.'" WHERE `id`="'.$id.'"');
	}
	function Tax_delete(){//delete a type
		$this->db->where('id',$this->input->post('id'));
		$this->db->delete('tax_status'); 
	}
	function Tax_insert(){//insert type
		$status = mysql_real_escape_string($this->input->post('status'));
		$desc = mysql_real_escape_string($this->input->post('desc'));
		$ex = mysql_real_escape_string($this->input->post('ex'));
		$this->db->query('INSERT INTO tax_status(`status`,`desc`,`exemption`) VALUES ("'.$status.'","'.$desc.'","'.$ex.'")');
		$this->insert_history("tax_status","insert",$status);
	}
	function day_getall() {//select all the list of department
		$this->load->database();
		$query = $this->db->query('SELECT * FROM daily_desc');
		return $query->result();
	}
	function day_update(){//Update a department
		$title = mysql_real_escape_string($this->input->post('title'));
		$id = mysql_real_escape_string($this->input->post('id'));
		$desc = mysql_real_escape_string($this->input->post('desc'));
		$payrate = mysql_real_escape_string($this->input->post('payrate'));
		$this->db->query('UPDATE `daily_desc` SET `title`="'.$title.'", `desc`="'.$desc.'", `payrate`="'.$payrate.'" WHERE `id`="'.$id.'"');
	}
	function day_delete(){//delete a department
		$this->db->where('id',mysql_real_escape_string($this->input->post('id')));
		$this->db->delete('daily_desc'); 
	}
	function day_insert(){//insert department
		$title = mysql_real_escape_string($this->input->post('title'));
		$desc = mysql_real_escape_string($this->input->post('desc'));
		$payrate = mysql_real_escape_string($this->input->post('payrate'));
		$this->db->query('INSERT INTO daily_desc(`title`,`desc`,`payrate`) VALUES ("'.$title.'","'.$desc.'","'.$payrate.'")');
		$this->insert_history("daily_desc","insert",$title);
	}
	function duplicate_Type($str){
		//search if type is existing
		$query = mysql_query("SELECT * from `emp_type` WHERE type LIKE '".$str."'");
		
		//count number of rows produced by the query
		$rows = mysql_num_rows($query);
	
		if($rows>0) return FALSE;
			//type already exists
		else return TRUE;
	}//check if duplicate employee type
	function duplicate_daytype($str){
		//search if user right is existing
		$query = mysql_query("SELECT * from `daiy_desc` WHERE title LIKE '".$str."'");
		
		//count number of rows produced by the query
		$rows = mysql_num_rows($query);
	
		if($rows>0) return FALSE;
			//user right already exists
		else return TRUE;
	}
	function duplicate_usertype($str){
		//search if user right is existing
		$query = mysql_query("SELECT * from `user_main` WHERE user_right LIKE '".$str."'");
		
		//count number of rows produced by the query
		$rows = mysql_num_rows($query);
	
		if($rows>0) return FALSE;
			//user right already exists
		else return TRUE;
	}//check if duplicate user right
	
	function duplicate_positiontype($str){
		//search if position is existing
		$query = mysql_query("SELECT * from `pos_main` WHERE position LIKE '".$str."'");
		
		//count number of rows produced by the query
		$rows = mysql_num_rows($query);
	
		if($rows>0) return FALSE;
			//position already exists
		else return TRUE;
	}//check if duplicate position
	
	function duplicate_department($str){
		//search if department is existing
		$query = mysql_query("SELECT * from `dept_main` WHERE dept LIKE '".$str."'");
		
		//count number of rows produced by the query
		$rows = mysql_num_rows($query);
	
		if($rows>0) return FALSE;
			//department already exists
		else return TRUE;
	}//check if duplicate department
	function duplicate_taxstatus($str){
		//search if position is existing
		$query = mysql_query("SELECT * from `tax_status` WHERE status LIKE '".$str."'");
		
		//count number of rows produced by the query
		$rows = mysql_num_rows($query);
	
		if($rows>0){ return FALSE;
		}//type already exists
		else return TRUE;
	}//check if duplicate department
	function insert_history($table,$action,$person)
	{
		//insert to history
		$query=$this->db->query('SELECT NOW() time FROM dual');
		foreach($query->result() as $row)
		$today=$row->time;
		$name=$this->session->userdata("fname").' '.$this->session->userdata("sname");
		$this->db->query('INSERT INTO history(`date`,`user`,`person`,`table`,`action`) VALUES ("'.$today.'","'.$name.'","'.$person.'","'.$table.'","'.$action.'")');
	}
}
?>