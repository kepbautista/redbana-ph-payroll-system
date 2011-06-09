<?php
class Leave_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
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
    function Leave_getall() {//select all the info of an employee from leave table
		$this->load->database();
		$query = $this->db->get('leave');
		return $query->result();
	}
	
	function Leave_edit() {			//choose a certain row from the employee and leave table to be edited.
		$this->load->database();
		$empnum=$this->input->post('empnum');
		$filedate=$this->input->post('filedate');
		$query = $this->db->query('SELECT * FROM `employee` `a`, `leave` `b` WHERE `b`.`empnum`=`a`.`empnum` AND `b`.`filedate`="'.$filedate.'" AND `a`.`empnum`="'.$empnum.'"');	
		return $query->result();
	}

	function Leave_delete(){			//delete a leave row.
		$this->db->where('empnum',$this->input->post('empnum'));
		$this->db->delete('leave');
	}
	
	function Leave_getinfo(){			//this is for viewing all the employee information from the joint table of employee and leave
		$this->load->database();
		$query = $this->db->query('SELECT * FROM `employee` `a`, `leave` `b` WHERE `b`.`empnum`=`a`.`empnum`');	
		return $query->result();
	}
	
	function Leave_getmaxinfo(){			//this is for viewing all the employee information from the joint table of employee and leave
		$this->load->database();
		$query = $this->db->query('SELECT * FROM `maxleave` `a`, `employee` `b` WHERE `b`.`empnum`=`a`.`empnum`');	
		return $query->result();
	}
	
	function EditoneMax() {//count number of rows
		$this->load->database();
		$max=$this->input->post('maxleave');
		$empnum=$this->input->post('empnum');
		$sql_x = 'UPDATE `maxleave` SET `maxleave` = ? WHERE `empnum` =?';
		$this->db->query($sql_x, array($max, $this->input->post('empnum') ) );
	}
	
	function Leave_numrows() {//count number of rows
		$this->load->database();
		$empnum=$this->input->post('empnum');
		$query = $this->db->get_where('leave',array('empnum'=>$empnum));
		return $query->num_rows();
	}
	function Leave_Insert(){			//insert a leave form
		
		$fday=$this->input->post('fday');
		$fmonth=$this->input->post('fmonth');
		$fyear=$this->input->post('fyear');
		$sday=$this->input->post('sday');
		$smonth=$this->input->post('smonth');
		$syear=$this->input->post('syear');
		$rday=$this->input->post('rday');
		$rmonth=$this->input->post('rmonth');
		$ryear=$this->input->post('ryear');
		$filedate=$fyear . '-' . $fmonth. '-' . $fday;
		$startdate=$syear . '-' . $smonth. '-' . $sday;
		$returndate=$ryear . '-' . $rmonth. '-' . $rday;
		$data = array(
		'empnum' => $this->session->userdata('empnum'),
		'filedate'=>$filedate,       
	    'startdate'=>$startdate,
		'returndate'=>$returndate,
		'type'=>$this->input->post('type'),
		'reason'=>$this->input->post('reason'),
		);
		$this->db->insert('leave',$data); 
	}
	function Leave_approved(){			//update the approval of a row to "approved"
		$app = "approved";
		$row = $this->db->where('empnum',$this->input->post('empnum'));
		$sql_x = 'UPDATE `leave` SET `approval` = ? WHERE `empnum` = ? AND `filedate` = ?';
		$this->db->query($sql_x, array($app, $this->input->post('empnum'),$this->input->post('filedate') ) );
		
		
	}
	function Leave_notapproved(){		//update the approval of a row to " not approved"
		$this->db->where('empnum',$this->input->post('empnum'));
		$app = "not approved";
		$row = $this->db->where('empnum',$this->input->post('empnum'));
		$sql_x = 'UPDATE `leave` SET `approval` = ? WHERE `empnum` = ? AND `filedate` = ?';
		$this->db->query($sql_x, array($app, $this->input->post('empnum'),$this->input->post('filedate') ) );
	}
	function checkmax(){
		$emp = $this->input->post('empnum');
		
		$sql = 'SELECT numofleave FROM `maxleave` WHERE empnum ="'.$emp.'"';
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		$num = $data['numofleave'];
		
		$sql = 'SELECT maxleave FROM `maxleave` WHERE empnum ="'.$emp.'"';
		$query = mysql_query($sql);
		$data = mysql_fetch_array($query);
		$max = $data['maxleave'];
	
		if($num < $max) {
		$num+= 1;
		$sql_x = 'UPDATE `maxleave` SET `numofleave` = ? WHERE `empnum` = ?';
		$this->db->query($sql_x, array($num, $emp) );
		$this->Leave_approved();
		}
		else echo "wahaha sobra na";
	}
	function Empview()		//view an employee's previous leaves 
	{
		$emp = $this->session->userdata('empnum');
		$sql_x = 'SELECT * FROM `leave` WHERE `empnum` = ?';
		$query = $this->db->query($sql_x, array($emp));
		if(empty($query)) return NULL;
		else return $query->result();
	}
	
}
?>