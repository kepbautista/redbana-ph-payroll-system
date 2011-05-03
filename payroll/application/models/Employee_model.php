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
		$query = $this->db->query('SELECT a.empnum,a.fname,a.password,a.mname,a.sname,a.bdate,a.sdate,a.mrate,a.position,a.dept,b.desc,a.payment_mode,a.gender FROM employee a,employee_status b WHERE a.status=b.id');
		return $query->result();
	}
	 function Employee_viewalltime() {
		$this->load->database();
		$date=$this->input->post('date');
		$query = $this->db->query('SELECT a.fname,a.mname,a.sname,b.empnum  apple ,b.login,b.logout,b.date FROM timesheet b,employee a WHERE b.empnum=a.empnum AND b.date="'.$date.'"');	
		return $query->result();
	}
	function Employee_viewalltime_rows() {
		$this->load->database();
		$date=$this->input->post('date');
		$query = $this->db->query('SELECT a.fname,a.mname,a.sname,b.empnum,b.login,b.logout,b.date FROM timesheet b,employee a WHERE b.empnum=a.empnum AND b.date="'.$date.'"');	
		return $query->num_rows();
	}
	function View_time() {
		$this->load->database();
		$date=date("Y/n/j");
		$query = $this->db->query('SELECT id,empnum,date,login,logout FROM timesheet where date="'.$date.'"');
		return  $query->num_rows();
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
	function Employee_edit() {//edit info of an employee
		$this->load->database();
		$empnum=$this->input->post('empnum');
		$sql = "SELECT `empnum`,`fname`,`password`,`mname`,`sname`,`bdate`,`sdate`,`mrate`,`position`,`dept`,`status`,`payment_mode`,`gender` FROM employee WHERE empnum = '".$empnum."'"; 	
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
		'status'=>$this->input->post('status'),
        'sdate'=>$sdate,
		'bdate'=>$bdate,
		'password'=>$this->input->post('password'),
		'position'=>$this->input->post('position'),
		'dept'=>$this->input->post('dept'),
		'mrate'=>$this->input->post('mrate'),
		'gender'=>$this->input->post('gender'),
		'payment_mode'=>$this->input->post('payment_mode')
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
		'status'=>$this->input->post('status'),
        'sdate'=>$sdate,
		'bdate'=>$bdate,
		'password'=>$this->input->post('password'),
		'position'=>$this->input->post('position'),
		'dept'=>$this->input->post('dept'),
		'mrate'=>$this->input->post('mrate'),
		'gender'=>$this->input->post('gender'),
		'payment_mode'=>$this->input->post('payment_mode')
		);
		$this->db->where('empnum',$this->input->post('hidden'));
		$this->db->update('employee',$data); 
	}
	function Employee_delete(){
		$this->db->where('empnum',$this->input->post('empnum'));
		$this->db->delete('employee'); 
	}
}
?>