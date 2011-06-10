<?php
/*File Name: Employee_model.php
  Program Description: Database Queries that basically modifies
					   information in the `employee` table
  Use mysql_real_escape_string() function in phpmysql to avoid
  SQL Injections.
*/
class Employee_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();		
		$this->load->model('Payperiod_model');
		$this->load->model('ErrorReturn_model');
		$this->load->library('session');	
	}
	
	public function get_status() {//get the description of the status
        $this->db->select('id, desc');
        $this->db->from('employee_status');
        $query = $this->db->get();
        foreach($query->result_array() as $row)
            $data[$row['id']]=$row['desc'];
        
        return $data;
	}
	
	public function get_shift() {//get the description of the status
        $this->db->select('ID,START_TIME,END_TIME');
        $this->db->from('shift');
        $query = $this->db->get();
        foreach($query->result_array() as $row)
            $data[$row['ID']]=$row['ID'].'.) '.$row['START_TIME'].'-'.$row['END_TIME'];
        
        return $data;
	}
	public function getPmode() {//get the options for payment mode
        $this->db->select('id, title');
        $this->db->from('payment_mode');
        $query = $this->db->get();
        foreach($query->result_array() as $row)
            $data[$row['id']]=$row['title'];
        
        return $data;
	}

	public function get_user_right() {//get the description of the status
        $query = $this->db->query('SELECT DISTINCT `user_right` FROM user_main');
        foreach($query->result_array() as $row)
            $data[$row['user_right']]=$row['user_right'];
        
        return $data;
	}
	
	public function get_tax() {//get the description of the status
        $this->db->select('id, status');
        $this->db->from('tax_status');
        $query = $this->db->get();
        foreach($query->result_array() as $row)
            $data[$row['status']]=$row['status'];
        
        return $data;
	}
	
	public function get_dept() {//get the description of the status
        $this->db->select('id, dept');
        $this->db->from('dept_main');
        $query = $this->db->get();
        foreach($query->result_array() as $row)
            $data[$row['dept']]=$row['dept'];
        
        return $data;
	}
	
	public function get_pos() {//get the description of the status
        $this->db->select('id, position');
        $this->db->from('pos_main');
        $query = $this->db->get();
        foreach($query->result_array() as $row)
            $data[$row['position']]=$row['position'];
        
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
		$query = $this->db->query('SELECT * FROM `employee`');
		return $query->result();
	}
	function Employee_get($emp) {//select all the info of a specific employee
		$this->load->database();
		$query = $this->db->query('SELECT * FROM employee WHERE empnum = "'.$emp.'"');
		return $query->result();
	}
	function Employee_getRows($emp) {//select all the info of a specific employee
		$this->load->database();
		$query = $this->db->query('SELECT * FROM employee WHERE empnum = "'.$emp.'"');
		return $query->num_rows();
	}
	function Employee_edit() {//edit info of an employee
		$this->load->database();
		$empnum=$this->input->post('empnum');
		$sql = "SELECT * FROM `employee` WHERE empnum = '".$empnum."'"; 	
		$query=$this->db->query($sql);
		return $query->result();
	}
	
	function Employee_numrows() {//count number of rows
		$this->load->database();
		$empnum=$this->input->post('empnum');
		$query = $this->db->get_where('employee',array('empnum'=>$empnum));
		return $query->num_rows();
	}
	
	function Employee_Insert(){//insert employee information to the database
		
		//insert to history
		$query=$this->db->query('SELECT NOW() time FROM dual');
		foreach($query->result() as $row)
		$today=$row->time;
		$name=$this->session->userdata("fname").' '.$this->session->userdata("sname");
		$person=$this->input->post('fname').' '.$this->input->post('sname');
		$this->db->query('INSERT INTO history(`date`,`user`,`person`,`table`,`action`) VALUES ("'.$today.'","'.$name.'","'.$person.'","employee","insert")');
		
		$sday = mysql_real_escape_string($this->input->post('sday'));
		$smonth = mysql_real_escape_string($this->input->post('smonth'));
		$syear = mysql_real_escape_string($this->input->post('syear'));
		$bday = mysql_real_escape_string($this->input->post('bday'));
		$bmonth = mysql_real_escape_string($this->input->post('bmonth'));
		$byear = $this->input->post('byear');
		$sdate = $syear.'-'.$smonth.'-'.$sday;
		$bdate = $byear.'-'.$bmonth.'-'.$bday;
		$data = array(
		'empnum' => mysql_real_escape_string($this->input->post('empnum')),
        'fname' => mysql_real_escape_string($this->input->post('fname')),
		'sname' => mysql_real_escape_string($this->input->post('sname')),
        'mname' => mysql_real_escape_string($this->input->post('mname')),
		'shift_id' => mysql_real_escape_string($this->input->post('shift_id')),
        'sdate' => $sdate,
		'bdate' => $bdate,
		'password' => mysql_real_escape_string($this->input->post('password')),
		'position' => mysql_real_escape_string($this->input->post('position')),
		'dept' => mysql_real_escape_string($this->input->post('dept')),
		'mrate' => mysql_real_escape_string($this->input->post('mrate')),
		'gender' => mysql_real_escape_string($this->input->post('gender')),
		'user_right' => mysql_real_escape_string($this->input->post('user_right')),
		'payment_mode' => mysql_real_escape_string($this->input->post('pmode')),
		
		'title' => mysql_real_escape_string($this->input->post('title')),
		'civil_status' => mysql_real_escape_string($this->input->post('cstatus')),
		'emp_status' => mysql_real_escape_string($this->input->post('emp_status')),
		'emp_type' => mysql_real_escape_string($this->input->post('emp_type')),
		'tax_status' => mysql_real_escape_string($this->input->post('tax_status')),
		'hphone' => mysql_real_escape_string($this->input->post('hphone')),
		'mphone'=> mysql_real_escape_string($this->input->post('mphone')),
		'email' => mysql_real_escape_string($this->input->post('email')),
		'address' => mysql_real_escape_string($this->input->post('address')),
		'zipcode' => mysql_real_escape_string($this->input->post('zip')),
		'sssno' => mysql_real_escape_string($this->input->post('sss')),
		'tinno' => mysql_real_escape_string($this->input->post('tin')),
		'pagibig' => mysql_real_escape_string($this->input->post('pagibig')),
		'philno' => mysql_real_escape_string($this->input->post('phil')),
		);
		
		$this->db->insert('employee',$data);
		$leavedata = array(
		'empnum' => mysql_real_escape_string($this->input->post('empnum')),
		'numofleave' => 0,
		'maxleave' => 10
		);
		$this->db->insert('maxleave',$leavedata);
	}
	function Employee_update(){
		$empnum=mysql_real_escape_string($this->input->post('empnum'));
		$sday = mysql_real_escape_string($this->input->post('sday'));
		$smonth = mysql_real_escape_string($this->input->post('smonth'));
		$syear = mysql_real_escape_string($this->input->post('syear'));
		$bday = mysql_real_escape_string($this->input->post('bday'));
		$bmonth = mysql_real_escape_string($this->input->post('bmonth'));
		$byear = mysql_real_escape_string($this->input->post('byear'));
		$sdate = $syear.'-'.$smonth.'-'.$sday;
		$bdate = $byear.'-'.$bmonth.'-'.$bday;
		$change="";
		$query=$this->db->query('SELECT * FROM employee WHERE empnum="'.$empnum.'"');
		//getchanges
		$query=$this->db->query('SELECT * FROM employee WHERE empnum="'.$empnum.'"');
		foreach($query->result() as $row)
		{
			if ($row->fname!=mysql_real_escape_string($this->input->post('fname')))
				$change= $change.'first name, ';
			if ($row->shift_id!=mysql_real_escape_string($this->input->post('shift_id')))
				$change= $change.'shift id, ';
			if ($row->sname!=mysql_real_escape_string($this->input->post('sname')))
				$change= $change.'last name, ';
			if ($row->mname!=mysql_real_escape_string($this->input->post('mname')))
				$change= $change.'middle name, ';
			if ($row->sdate!=$sdate)
				$change= $change.'starting date, ';
			if ($row->bdate!=$bdate)
				$change= $change.'birth date, ';
			if ($row->password!=mysql_real_escape_string($this->input->post('password')))
				$change= $change.'password, ';
			if ($row->position!=mysql_real_escape_string($this->input->post('position')))
				$change= $change.'position, ';
			if ($row->mrate!=mysql_real_escape_string($this->input->post('mrate')))
				$change= $change.'monthly rate, ';
			if ($row->dept!=mysql_real_escape_string($this->input->post('dept')))
				$change= $change.'department, ';
			if ($row->gender!=mysql_real_escape_string($this->input->post('gender')))
				$change= $change.'gender, ';
			if ($row->user_right!=mysql_real_escape_string($this->input->post('user_right')))
				$change= $change.'user right, ';
			if ($row->payment_mode!=mysql_real_escape_string($this->input->post('pmode')))
				$change= $change.'payment mode, ';
			if ($row->title!=mysql_real_escape_string($this->input->post('title')))
				$change= $change.'title, ';
			if ($row->civil_status!=mysql_real_escape_string($this->input->post('cstatus')))
				$change= $change.'civil status, ';
			if ($row->emp_status!=mysql_real_escape_string($this->input->post('emp_status')))
				$change= $change.'employee status, ';
			if ($row->emp_type!=mysql_real_escape_string($this->input->post('emp_type')))
				$change= $change.'employee type, ';
			if ($row->tax_status!=mysql_real_escape_string($this->input->post('tax_status')))
				$change= $change.'tax status, ';
			if ($row->hphone!=mysql_real_escape_string($this->input->post('hphone')))
				$change= $change.'home number, ';
			if ($row->mphone!=mysql_real_escape_string($this->input->post('mphone')))
				$change= $change.'mobile number, ';
			if ($row->email!=mysql_real_escape_string($this->input->post('email')))
				$change= $change.'email address, ';
			if ($row->address!=mysql_real_escape_string($this->input->post('address')))
				$change= $change.'home address, ';
			if ($row->zipcode!=mysql_real_escape_string($this->input->post('zip')))
				$change= $change.'zipcode, ';
			if ($row->sssno!=mysql_real_escape_string($this->input->post('sss')))
				$change= $change.'sss number, ';
			if ($row->tinno!=mysql_real_escape_string($this->input->post('tin')))
				$change= $change.'tin number, ';
			if ($row->pagibig!=mysql_real_escape_string($this->input->post('pagibig')))
				$change= $change.'pagibig number, ';
			if ($row->philno!=mysql_real_escape_string($this->input->post('phil')))
				$change= $change.'philhealth number, ';
		}
		//insert to history
		$query=$this->db->query('SELECT NOW() time FROM dual');
		foreach($query->result() as $row)
		$today=$row->time;
		$name=$this->session->userdata("fname").' '.$this->session->userdata("sname");
		$person=mysql_real_escape_string($this->input->post('fname')).' '.mysql_real_escape_string($this->input->post('sname'));
		if($change!="")
			$this->db->query('INSERT INTO history(`date`,`user`,`data`,`person`,`table`,`action`) VALUES ("'.$today.'","'.$name.'","'.$change.'","'.$person.'","employee","update")');
		$data = array(
		'empnum' => mysql_real_escape_string($this->input->post('empnum')),
        'fname' => mysql_real_escape_string($this->input->post('fname')),
		'shift_id' => mysql_real_escape_string($this->input->post('shift_id')),
        'sname' => mysql_real_escape_string($this->input->post('sname')),
        'mname' => mysql_real_escape_string($this->input->post('mname')),
        'sdate' => $sdate,
		'bdate' => $bdate,
		'password' => mysql_real_escape_string($this->input->post('password')),
		'position' => mysql_real_escape_string($this->input->post('position')),
		'dept' => mysql_real_escape_string($this->input->post('dept')),
		'mrate' => mysql_real_escape_string($this->input->post('mrate')),
		'gender' => mysql_real_escape_string($this->input->post('gender')),
		'user_right' => mysql_real_escape_string($this->input->post('user_right')),
		'payment_mode' => mysql_real_escape_string($this->input->post('pmode')),
		
		'title' => mysql_real_escape_string($this->input->post('title')),
		'civil_status' => mysql_real_escape_string($this->input->post('cstatus')),
		'emp_status' => mysql_real_escape_string($this->input->post('emp_status')),
		'emp_type' => mysql_real_escape_string($this->input->post('emp_type')),
		'tax_status' => mysql_real_escape_string($this->input->post('tax_status')),
		'hphone' => mysql_real_escape_string($this->input->post('hphone')),
		'mphone' => mysql_real_escape_string($this->input->post('mphone')),
		'email' => mysql_real_escape_string($this->input->post('email')),
		'address' => mysql_real_escape_string($this->input->post('address')),
		'zipcode' => mysql_real_escape_string($this->input->post('zip')),
		'sssno' => mysql_real_escape_string($this->input->post('sss')),
		'tinno' => mysql_real_escape_string($this->input->post('tin')),
		'pagibig' => mysql_real_escape_string($this->input->post('pagibig')),
		'philno' => mysql_real_escape_string($this->input->post('phil')),
		);
		$this->db->where('empnum',$_POST['empnum']);
		$this->db->update('employee',$data); 
	}
	
	function Employee_delete(){
		//insert to history
		$query=$this->db->query('SELECT NOW() time FROM dual');
		foreach($query->result() as $row)
		$today=$row->time;
		$name=$this->session->userdata("fname").' '.$this->session->userdata("sname");
		$person=$this->get_Name($this->input->post('empnum'));
		$this->db->query('INSERT INTO history(`date`,`user`,`person`,`table`,`action`) VALUES ("'.$today.'","'.$name.'","'.$person.'","employee","delete")');
		
		$this->db->where('empnum',$this->input->post('empnum'));
		$this->db->delete('employee');
		$this->db->where('empnum',$this->input->post('empnum'));
		$this->db->delete('timesheet'); 
	}//delete an employee
	function get_Name($empnum){
		//search if employee number is existing
		$query = mysql_query("SELECT * from `employee` WHERE empnum LIKE '".$empnum."'");
		foreach($query->result() as $row)
		$name=$row->fname.' '.$row->sname;
		return $name;
	}
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
		$login = mysql_real_escape_string($this->input->post('login1'))
				.':'.mysql_real_escape_string($this->input->post('login2'))
				.':'.mysql_real_escape_string($this->input->post('login3'))
				.' '.mysql_real_escape_string($this->input->post('login4'));
		$logout = mysql_real_escape_string($this->input->post('logout1'))
				.':'.mysql_real_escape_string($this->input->post('logout2'))
				.':'.mysql_real_escape_string($this->input->post('logout3'))
				.' '.mysql_real_escape_string($this->input->post('logout4'));
		$login = DATE("H:i:s", STRTOTIME($login));//converts 1pm to 13:00:00
        $logout = DATE("H:i:s", STRTOTIME($logout));//converts 1pm to 13:00:00
		$this->db->query('UPDATE `timesheet` SET login="'.$login.'",logout="'.$logout.'" WHERE empnum="'.$this->input->post('empnum').'" AND
		date="'.mysql_real_escape_string($this->input->post('date')).'"');
	}
	
	function Employee_viewalltime($cases) {
		$this->load->database();
		if ($cases==1)
			$date = mysql_real_escape_string($this->input->post('date'));
		else if ($cases==2)
			$date = date("Y/n/j");
		else $date = mysql_real_escape_string($this->input->post('yrs'))
					.'-'.mysql_real_escape_string($this->input->post('mos'))
					.'-'.mysql_real_escape_string($this->input->post('days'));
		$query = $this->db->query('SELECT a.fname,a.mname,a.sname,b.empnum ,b.login,b.logout,b.date FROM `timesheet` b,employee a WHERE b.empnum=a.empnum AND b.date="'.$date.'"');	
		return $query->result();
	}
	
	function Employee_viewalltime_rows($cases) {
		$this->load->database();
		if ($cases==1)
			$date = mysql_real_escape_string($this->input->post('date'));
		else if ($cases==2)
			$date = date("Y/n/j");
		else $date = mysql_real_escape_string($this->input->post('yrs'))
					.'-'.mysql_real_escape_string($this->input->post('mos'))
					.'-'.mysql_real_escape_string($this->input->post('days'));
		$query = $this->db->query('SELECT a.fname,a.mname,a.sname,b.empnum,b.login,b.logout,b.date 
				FROM `timesheet` b,employee a WHERE b.empnum=a.empnum AND b.date="'.$date.'"');	
		return $query->num_rows();
	}
	
	function Insert_time() {
		$this->load->database();
		$date = mysql_real_escape_string($this->input->post('date'));
		$query = $this->db->get('employee');
		foreach ($query->result() as $row)
		{
			$query1 = $this->db->query('INSERT INTO `timesheet`(`login`,`logout`,`empnum`,`date`)
					  VALUES("00:00:00","00:00:00","'.$row->empnum.'","'.$date.'")');
		}
	}
	
	function getAllEmployees_eligible_this_PayPeriod($payperiod_obj = NULL, $payment_mode = NULL)
	{
		/*
			made | abe | 19MAY2011_1242
			changed | abe | 19MAY2011_1415 | $payperiod_obj is now the first param, MySQL obj, row directly accessible
			returns BOOLEAN FALSE if no payperiod or payment mode specified
			returns NULL if no gotten from dB
			returns ARRAY of objects gotten from dB, where the indices are the employees' nums
		*/
		$returnThisArray = array();
		
		if( $payperiod_obj == NULL  or $payment_mode == NULL)
		{
			return FALSE;			
		}
		
		/*
			no more determining if payperiods is empty here, i think the user
			won't arrive here without specifying a valid payperiod
		*/				
		$sql_x = "SELECT * from `employee` WHERE `sdate` <= ?"; 
		$rows_result = $this->db->query($sql_x, array($payperiod_obj->END_DATE) )->result();
		
		if( empty($rows_result) ) return NULL;		
		foreach($rows_result as $each_employee) $returnThisArray[$each_employee->empnum]  = $each_employee;				

		return $returnThisArray;		
	}//getAllEmployees_eligible...
	
	function insert_privilege($user) {//select all the info of a specific employee
		if (isset($_POST['position'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="position"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="position"'); 
		if (isset($_POST['allleave'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="allleave"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="allleave"'); 
		if (isset($_POST['viewemp'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="viewemp"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="viewemp"'); 
		if (isset($_POST['editemp'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="editemp"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="editemp"'); 
		if (isset($_POST['addemp'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="addemp"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="addemp"'); 
		if (isset($_POST['accleave'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="accleave"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="accleave"'); 
		if (isset($_POST['taxstatus'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="taxstatus"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="taxstatus"'); 
		if (isset($_POST['shift'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="shift"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="shift"'); 
		if (isset($_POST['sss'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="sss"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="sss"'); 
		if (isset($_POST['phil'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="phil"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="phil"'); 
		if (isset($_POST['wth'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="wth"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="wth"'); 
		if (isset($_POST['viewpay'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="viewpay"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="viewpay"'); 
		if (isset($_POST['leave'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="leave"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="leave"'); 
		if (isset($_POST['dept'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="dept"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="dept"'); 
		if (isset($_POST['access'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="access"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="access"'); 
		if (isset($_POST['use'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="user"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="user"'); 
		if (isset($_POST['type'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="type"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="type"'); 
		if (isset($_POST['day'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="day"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="day"'); 
		if (isset($_POST['timesheet'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="timesheet"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="timesheet"'); 
		if (isset($_POST['history'])) 
			$this->db->query('UPDATE `user_main` SET type="1" WHERE user_right ="'.$user.'" AND privilege ="history"'); 
		else 
			$this->db->query('UPDATE `user_main` SET type="0" WHERE user_right ="'.$user.'" AND privilege ="history"'); 
		
	}
	function get_privilege($user_right) {//select all the info of a specific employee
		$this->load->database();
		$query = $this->db->query('SELECT `privilege` FROM user_main WHERE user_right = "'.$user_right.'" AND type="1"');
		return $query->result();
	}
	function get_privilegeRows($user_right)
	{
		$this->load->database();
		$query = $this->db->query('SELECT DISTINCT `privilege`  FROM user_main WHERE user_right = "'.$user_right.'"');
		return $query->num_rows();
	}
	
	function get_Employees_Associative()
	{
		$employees = $this->Employee_getall();
		$returnThisArray = array();
		
		if( empty($employees) )
		{
			return NULL;
		}else
		
		foreach($employees as $each_emp)
		{
			$returnThisArray[$each_emp->empnum] = $each_emp;
		}
		
		return $returnThisArray;
	}
	
	function getDailyRate_from_SalaryTable($payperiod_obj, $empnum)
	{
	    if( !isset($payperiod_obj) or 
            !isset($payperiod_obj->START_DATE) or
            !isset($payperiod_obj->END_DATE)
		){
			$this->ErrorReturn_model->createSingleError(704, NULL, NULL);
		}
	
		$sql_x = "SELECT `DailyRate` FROM `salary` WHERE `start_date` = ? AND `end_date` = ? and `EmployeeNumber` = ?";
		$array_result = $this->db->query( $sql_x, array($payperiod_obj->START_DATE, $payperiod_obj->END_DATE, $empnum) )->result();
	
		if( empty($array_result) ) return $this->ErrorReturn_model->createSingleError(409, NULL, NULL);
		else return $this->ErrorReturn_model->createSingleError(0, $array_result[0]->DailyRate, NULL);		
	}
	
}//class
?>