<?php
class Employee_model extends CI_Model {
	
	public function get_status() {//get the description of the status
        $this->db->select('id, desc');
        $this->db->from('employee_status');
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $data[$row['id']]=$row['desc'];
        }
        return $data;
	}
	public function get_bank() {//get the description of the status
        $this->db->select('id, name');
        $this->db->from('bank_main');
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $data[$row['name']]=$row['name'];
        }
        return $data;
	}
	public function get_user_right() {//get the description of the status
        $this->db->select('id, user_right');
        $this->db->from('user_main');
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $data[$row['user_right']]=$row['user_right'];
        }
        return $data;
	}
	public function get_tax() {//get the description of the status
        $this->db->select('id, status');
        $this->db->from('tax_status');
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $data[$row['status']]=$row['status'];
        }
        return $data;
	}
	public function get_dept() {//get the description of the status
        $this->db->select('id, dept');
        $this->db->from('dept_main');
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $data[$row['dept']]=$row['dept'];
        }
        return $data;
	}
	public function get_pos() {//get the description of the status
        $this->db->select('id, position');
        $this->db->from('pos_main');
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $data[$row['position']]=$row['position'];
        }
        return $data;
	}
	public function get_type() {//get the description of the status
        $this->db->select('id, type');
        $this->db->from('emp_type');
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $data[$row['type']]=$row['type'];
        }
        return $data;
	}
	function buildMonthDropdown()//builds month dropdown for date
    {
        $month=array(
            '01'=>'January',
            '02'=>'February',
            '03'=>'March',
            '04'=>'April',
            '05'=>'May',
            '06'=>'June',
            '07'=>'July',
            '08'=>'August',
            '09'=>'September',
            '10'=>'October',
            '11'=>'November',
            '12'=>'December');
        return $month;
    }
    function Employee_getall() {//select all the info of an employee from employee table
		$this->load->database();
		$query = $this->db->query('SELECT * FROM employee');
		return $query->result();
	}
	function Employee_edit() {//edit info of an employee
		$this->load->database();
		$empnum=$this->input->post('empnum');
		$sql = "SELECT * FROM employee WHERE empnum = '".$empnum."'"; 	
		$query=$this->db->query($sql);
		return $query->result();
	}
	function Employee_numrows() {//count number of rows
		$this->load->database();
		$empnum=$this->input->post('empnum');
		$query = $this->db->get_where('employee',array('empnum'=>$empnum));
		return $query->num_rows();
	}
	function Employee_Insert(){
	
		$sday=$this->input->post('sday');
		$smonth=$this->input->post('smonth');
		$syear=$this->input->post('syear');
		$bday=$this->input->post('bday');
		$bmonth=$this->input->post('bmonth');
		$byear=$this->input->post('byear');
		$sdate=$syear . '-' . $smonth. '-' . $sday;
		$bdate=$byear . '-' . $bmonth. '-' . $bday;
		$data = array(
		'empnum'=>$this->input->post('empnum'),
        'fname'=>$this->input->post('fname'),
		'sname'=>$this->input->post('sname'),
        'mname'=>$this->input->post('mname'),
        'sdate'=>$sdate,
		'bdate'=>$bdate,
		'password'=>$this->input->post('password'),
		'position'=>$this->input->post('position'),
		'dept'=>$this->input->post('dept'),
		'mrate'=>$this->input->post('mrate'),
		'gender'=>$this->input->post('gender'),
		'user_right'=>$this->input->post('user_right'),
		'payment_mode'=>$this->input->post('payment_mode'),
		
		'title'=>$this->input->post('title'),
		'civil_status'=>$this->input->post('cstatus'),
		'emp_status'=>$this->input->post('emp_status'),
		'emp_type'=>$this->input->post('emp_type'),
		'tax_status'=>$this->input->post('tax_status'),
		'hphone'=>$this->input->post('hphone'),
		'mphone'=>$this->input->post('mphone'),
		'email'=>$this->input->post('email'),
		'address'=>$this->input->post('address'),
		'zipcode'=>$this->input->post('zip'),
		'sssno'=>$this->input->post('sss'),
		'tinno'=>$this->input->post('tin'),
		'pagibig'=>$this->input->post('pagibig'),
		'philno'=>$this->input->post('phil'),
		'bank'=>$this->input->post('bank_name'),
		'baccount'=>$this->input->post('baccount')
		);
		$this->db->insert('employee',$data); 
	}
	function Employee_update(){
		$sday=$this->input->post('sday');
		$smonth=$this->input->post('smonth');
		$syear=$this->input->post('syear');
		$bday=$this->input->post('bday');
		$bmonth=$this->input->post('bmonth');
		$byear=$this->input->post('byear');
		$sdate=$syear . '-' . $smonth. '-' . $sday;
		$bdate=$byear . '-' . $bmonth. '-' . $bday;
		$data = array(
		'empnum'=>$this->input->post('empnum'),
        'fname'=>$this->input->post('fname'),
		'sname'=>$this->input->post('sname'),
        'mname'=>$this->input->post('mname'),
        'sdate'=>$sdate,
		'bdate'=>$bdate,
		'password'=>$this->input->post('password'),
		'position'=>$this->input->post('position'),
		'dept'=>$this->input->post('dept'),
		'mrate'=>$this->input->post('mrate'),
		'gender'=>$this->input->post('gender'),
		'user_right'=>$this->input->post('user_right'),
		'payment_mode'=>$this->input->post('payment_mode'),
		
		'title'=>$this->input->post('title'),
		'civil_status'=>$this->input->post('cstatus'),
		'emp_status'=>$this->input->post('emp_status'),
		'emp_type'=>$this->input->post('emp_type'),
		'tax_status'=>$this->input->post('tax_status'),
		'hphone'=>$this->input->post('hphone'),
		'mphone'=>$this->input->post('mphone'),
		'email'=>$this->input->post('email'),
		'address'=>$this->input->post('address'),
		'zipcode'=>$this->input->post('zip'),
		'sssno'=>$this->input->post('sss'),
		'tinno'=>$this->input->post('tin'),
		'pagibig'=>$this->input->post('pagibig'),
		'philno'=>$this->input->post('phil'),
		'bank'=>$this->input->post('bank_name'),
		'baccount'=>$this->input->post('baccount')
		);
		$this->db->where('empnum',$_POST['empnum']);
		$this->db->update('employee',$data); 
	}
	function Employee_delete(){
		$this->db->where('empnum',$this->input->post('empnum'));
		$this->db->delete('employee');
		$this->db->where('empnum',$this->input->post('empnum'));
		$this->db->delete('timesheet'); 
	}//delete an employee
	
	function duplicate_EmployeeNum($empnum){
		//search if employee number is existing
		$query = mysql_query("SELECT * from `employee` WHERE empnum LIKE '".$empnum."'");
		
		//count number of rows produced by the query
		$rows = mysql_num_rows($query);
	
		if($rows>0) return FALSE;
			//employee number already exists
		else return TRUE;
	}
	//HR
	function Employee_updateTime(){
		$login=$this->input->post('login1').':'.$this->input->post('login2').':'.$this->input->post('login3').' '.$this->input->post('login4');
		$logout=$this->input->post('logout1').':'.$this->input->post('logout2').':'.$this->input->post('logout3').' '.$this->input->post('logout4');
		$login=DATE("H:i:s", STRTOTIME($login));//converts 1pm to 13:00:00
        $logout=DATE("H:i:s", STRTOTIME($logout));//converts 1pm to 13:00:00
		$this->db->query('UPDATE timesheet SET login="'.$login.'",logout="'.$logout.'" WHERE empnum="'.$this->input->post('empnum').'" AND
		date="'.$this->input->post('date').'"');
	}
	function Employee_viewalltime($cases) {
		$this->load->database();
		if ($cases==1)
			$date=$this->input->post('date');
		else if ($cases==2)
			$date=date("Y/n/j");
		else $date=$this->input->post('yrs').'-'.$this->input->post('mos').'-'.$this->input->post('days');
		$query = $this->db->query('SELECT a.fname,a.mname,a.sname,b.empnum ,b.login,b.logout,b.date FROM timesheet b,employee a WHERE b.empnum=a.empnum AND b.date="'.$date.'"');	
		return $query->result();
	}
	function Employee_viewalltime_rows($cases) {
		$this->load->database();
		if ($cases==1)
			$date=$this->input->post('date');
		else if ($cases==2)
			$date=date("Y/n/j");
		else $date=$this->input->post('yrs').'-'.$this->input->post('mos').'-'.$this->input->post('days');
		$query = $this->db->query('SELECT a.fname,a.mname,a.sname,b.empnum,b.login,b.logout,b.date FROM timesheet b,employee a WHERE b.empnum=a.empnum AND b.date="'.$date.'"');	
		return $query->num_rows();
	}
	function Insert_time() {
		$this->load->database();
		$date=$this->input->post('date');
		$query=$this->db->get('employee');
		foreach ($query->result() as $row)
		{
			$query1 = $this->db->query('INSERT INTO timesheet(`login`,`logout`,`empnum`,`date`) VALUES("00:00:00","00:00:00","'.$row->empnum.'","'.$date.'")');
		}
	}
}
?>