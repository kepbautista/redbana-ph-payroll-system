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
		$query = $this->db->query('SELECT a.fname,a.mname,a.sname,a.shift_id,b.absence_reason,b.work_date,b.empnum ,b.time_in,b.time_out,b.date_in,b.date_out,b.restday FROM timesheet b,employee a WHERE b.empnum=a.empnum AND b.work_date="'.$date.'"');	
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
		$query = $this->db->query('SELECT a.fname,a.mname,a.sname,b.empnum,b.work_date ,b.time_in,b.time_out,b.date_in,b.date_out FROM timesheet b,employee a WHERE b.empnum=a.empnum AND b.work_date="'.$date.'"');	
		return $query->num_rows();
	}
	function Insert_time($data) {
		
		$this->load->database();
		$shifts = $data['shifts'];
		$date_in = $this->input->post('date');		//removed the very long escaping sequence, in the foreach later below, it will be automatically escaped by CodeIgniter
		
		$query = $this->db->get('employee');
		
		foreach ($query->result() as $row)
		{	
			/*
				abe | 09JUN2011_1200 | changed this foreach loop generally
										added mechanism in automatically determining when should the date_out be in case of 'overflow' shifts
			*/			
			$date_out = $date_in;
			
			if( $shifts[intval($row->shift_id)]['OVERFLOW'] == 1 ){							
				$tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
				$date_out = date("Y-m-d", $tomorrow);
			}
			
			
			$sql_x = "INSERT INTO `timesheet` (`work_date`,`date_in`,`time_in`,`date_out`,`time_out`,`shift_id`,`empnum`,`type`) VALUES (?, ?, ?, ?, ?, ?, ?, ? ); ";
			$query_execution_result = $this->db->query($sql_x, array(
										$date_in,
										$date_in,
										$shifts[intval($row->shift_id)]['START_TIME'],
										$date_out,
										$shifts[intval($row->shift_id)]['END_TIME'],
										$row->shift_id,
										$row->empnum,
										$this->input->post('type')
									) 
			);

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
		$date_in = date("Y-m-d", mktime(0, 0, 0, mysql_real_escape_string($this->input->post('date_in1')),
					mysql_real_escape_string($this->input->post('date_in2')),
					mysql_real_escape_string($this->input->post('date_in3'))));
		
		/**echo mysql_real_escape_string($this->input->post('date_in1')).' ';
		echo mysql_real_escape_string($this->input->post('date_in2')).' ';
		echo mysql_real_escape_string($this->input->post('date_in3')).' ';
		*/if(mysql_real_escape_string($this->input->post('restday')) == 'on') $restday_checked = 1;
		
		//echo mktime($this->input->post('time_out1'),$this->input->post('time_out2'),$this->input->post('time_out3'));
	//$time_in= DATE("H:i:s", STRTOTIME($time_in));
	//$time_out= DATE("H:i:s", STRTOTIME($time_out));
	//	echo $date_out;
	//echo $time_in.'\n'.$time_out.'\n'.$date_out;
		$this->db->query('UPDATE timesheet SET absence_reason="'.$absence_reason.'",date_in="'.$date_in.'",date_out="'.$date_out.'",time_out="'.$time_out.'",time_in="'.$time_in.'",restday="'.$restday_checked.'" WHERE empnum="'.$emp.'" AND work_date="'.mysql_real_escape_string($this->input->post('date')).'"');
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