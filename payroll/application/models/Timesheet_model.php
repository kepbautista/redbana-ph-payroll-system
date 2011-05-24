<?php
class Timesheet_model extends CI_Model {
	function buildMonthDropdown()//builds month dropdown for date
    {
        $month=array(
            '01'=>'Jan',
            '02'=>'Feb',
            '03'=>'Mar',
            '04'=>'Apr',
            '05'=>'May',
            '06'=>'Jun',
            '07'=>'Jul',
            '08'=>'Aug',
            '09'=>'Sep',
            '10'=>'Oct',
            '11'=>'Nov',
            '12'=>'Dec');
        return $month;
    }
	function get_desc() {//get the description of the status
        $this->db->select('id, title');
        $this->db->from('daily_desc');
        $query = $this->db->get();
        foreach($query->result_array() as $row)
            $data[$row['id']]=$row['title'];
        return $data;
	}

	function Timesheet_viewalltime($cases) {
		$this->load->database();
		if ($cases==1)
			$date = mysql_real_escape_string($this->input->post('date'));
		else if ($cases==2)
			$date = date("Y-n-j");
		else $date = mysql_real_escape_string($this->input->post('yrs'))
					.'-'.mysql_real_escape_string($this->input->post('mos'))
					.'-'.mysql_real_escape_string($this->input->post('days'));
		$query = $this->db->query('SELECT a.fname,a.mname,a.sname,a.shift_id,b.absence_reason,b.empnum ,b.time_in,b.time_out,b.date_in,b.date_out,b.restday FROM timesheet b,employee a WHERE b.empnum=a.empnum AND b.date_in="'.$date.'"');	
		return $query->result();
	}
	function Timesheet_viewalltime_rows($cases) {
		$this->load->database();
		if ($cases==1)
			$date = $this->input->post('date');
		else if ($cases==2)
			$date = date("Y/n/j");
		else $date = mysql_real_escape_string($this->input->post('yrs')).
					'-'.mysql_real_escape_string($this->input->post('mos'))
					.'-'.mysql_real_escape_string($this->input->post('days'));
		$query = $this->db->query('SELECT a.fname,a.mname,a.sname,b.empnum ,b.time_in,b.time_out,b.date_in,b.date_out FROM timesheet b,employee a WHERE b.empnum=a.empnum AND b.date_in="'.$date.'"');	
		return $query->num_rows();
	}
	function Insert_time() {
		$this->load->database();
		$date = mysql_real_escape_string($this->input->post('date'));
		$query = $this->db->get('employee');
		foreach ($query->result() as $row)
		{
			$query1 = $this->db->query('INSERT INTO timesheet(`date_in`,`time_in`,`date_out`,`time_out`,`empnum`,`type`) VALUES("'.$date.'","00:00:00","'.$date.'","00:00:00","'.$row->empnum.'","'.$_POST['type'].'")');
		}
	}
	function Update()
	{
		$restday_checked = 0;
		$emp = mysql_real_escape_string($this->input->post('empnum'));
		$absence_reason = mysql_real_escape_string($this->input->post('ABSENCE_REASON'));
		//die(var_dump($absence_reason));
		$time_in = mysql_real_escape_string($this->input->post('time_in1')).
					':'.mysql_real_escape_string($this->input->post('time_in2'))
					.':'.mysql_real_escape_string($this->input->post('time_in3'));
		$time_out = mysql_real_escape_string($this->input->post('time_out1'))
					.':'.mysql_real_escape_string($this->input->post('time_out2'))
					.':'.mysql_real_escape_string($this->input->post('time_out3'));
		$date_out = date("Y-m-d", mktime(0, 0, 0, mysql_real_escape_string($this->input->post('date_out1')),
					mysql_real_escape_string($this->input->post('date_out2')),
					mysql_real_escape_string($this->input->post('date_out3'))));
		
		if(mysql_real_escape_string($this->input->post('restday')) == 'on') $restday_checked = 1;
		
		//echo mktime($this->input->post('time_out1'),$this->input->post('time_out2'),$this->input->post('time_out3'));
	//$time_in= DATE("H:i:s", STRTOTIME($time_in));
	//$time_out= DATE("H:i:s", STRTOTIME($time_out));
	//	echo $date_out;
	//echo $time_in.'\n'.$time_out.'\n'.$date_out;
		$this->db->query('UPDATE timesheet SET absence_reason="'.$absence_reason.'",date_out="'.$date_out.'",time_out="'.$time_out.'",time_in="'.$time_in.'",restday="'.$restday_checked.'" WHERE empnum="'.$emp.'" AND date_in="'.mysql_real_escape_string($this->input->post('date')).'"');
		/**$data = array(
		'time_in'=>STRTOTIME($time_in),
        'time_out'=>STRTOTIME($time_out),
		'date_out'=>$date_out);
		$this->db->where('date_in',$_POST['date']);
		$this->db->where('empnum',$_POST['empnum']);
		$this->db->update('timesheet',$data);*/ 
	}
	
}
?>