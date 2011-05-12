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
		$empnum=$this->input->post('empnum');
		$query = $this->db->get_where('leave',array('empnum'=>$empnum));
		return $query->num_rows();
	}
	function Leave_Insert(){
		
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
		'empnum'=>$this->input->post('empnum'),
		'filedate'=>$filedate,       
	    'startdate'=>$startdate,
		'returndate'=>$returndate,
		'type'=>$this->input->post('type'),
		'reason'=>$this->input->post('reason'),
		);
		$this->db->insert('leave',$data); 
	}
	function Leave_approve(){
		$data = array(
		'empnum'=>$this->input->post('empnum'),
		'filedate'=>$filedate,       
	    'startdate'=>$startdate,
		'returndate'=>$returndate,
		'type'=>$this->input->post('type'),
		'reason'=>$this->input->post('reason'),
		'approval'=>$this->input->post('approval')
		);
		$this->db->where('empnum',$_POST['empnum']);
		$this->db->update('leave',$data); 
	}
}
?>