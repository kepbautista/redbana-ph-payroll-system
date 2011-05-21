<?php
class Leave_model extends CI_Model {
	
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
    function Leave_getall() {//select all the info of an employee from employee table
		$this->load->database();
		//$data['result']=$this->db->get('leave');
		//return $data['result'];
		$query = $this->db->get('leave');
		return $query->result();
	}

	function Leave_numrows() {//count number of rows
		$this->load->database();
		$empnum = mysql_real_escape_string($this->input->post('empnum'));
		$query = $this->db->get_where('leave',array('empnum'=>$empnum));
		return $query->num_rows();
	}
	function Leave_Insert(){
		
		$fday = mysql_real_escape_string($this->input->post('fday'));
		$fmonth = mysql_real_escape_string($this->input->post('fmonth'));
		$fyear = mysql_real_escape_string($this->input->post('fyear'));
		$sday = mysql_real_escape_string($this->input->post('sday'));
		$smonth = mysql_real_escape_string($this->input->post('smonth'));
		$syear = mysql_real_escape_string($this->input->post('syear'));
		$rday = mysql_real_escape_string($this->input->post('rday'));
		$rmonth = mysql_real_escape_string($this->input->post('rmonth'));
		$ryear = mysql_real_escape_string($this->input->post('ryear'));
		$filedate = $fyear.'-'.$fmonth.'-'.$fday;
		$startdate = $syear.'-'.$smonth.'-'.$sday;
		$returndate = $ryear.'-'.$rmonth.'-'.$rday;
		$data = array(
		'empnum' => mysql_real_escape_string($this->input->post('empnum')),
		'filedate' => $filedate,       
	    'startdate' => $startdate,
		'returndate' => $returndate,
		'type' => mysql_real_escape_string($this->input->post('type')),
		'reason' => mysql_real_escape_string($this->input->post('reason')),
		);
		$this->db->insert('leave',$data); 
	}
	function Leave_approve(){
		$data = array(
		'empnum' => mysql_real_escape_string($this->input->post('empnum')),
		'filedate' => $filedate,       
	    'startdate' => $startdate,
		'returndate' => $returndate,
		'type' => mysql_real_escape_string($this->input->post('type')),
		'reason' => mysql_real_escape_string($this->input->post('reason')),
		'approval' => mysql_real_escape_string($this->input->post('approval'))
		);
		$this->db->where('empnum',$_POST['empnum']);
		$this->db->update('leave',$data); 
	}
}
?>