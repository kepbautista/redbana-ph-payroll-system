<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Philhealth_model extends CI_Model {
	function Philhealthmodel()
	{
		parent::_Model();	// to load the parent constructor
		$this->load->library('table');	// to invoke the the class name
	}
	
	function Philhealth_getall()
	{
		$this->load->database();	// loads and initializes the database class
		$query = $this->db->query('SELECT `bracket`, `rangel`, `rangeh`, `base`, `total`, `pes`, `per`,`id` FROM philhealth GROUP BY `bracket`');
		return $query->result();
	}

	function Philhealth_numrows()
	{
		$this->load->database();	// loads and initializes the database class
		$trows = $this->db->query('SELECT `bracket`, `rangel`, `rangeh`, `base`, `total`, `pes`, `per` FROM philhealth GROUP BY `bracket`');
		return $trows->num_rows();
	}
		
	function Philhealth_update()
	{
		$this->load->database();	// loads and initializes the database class
		$data = array(
		'bracket' => mysql_real_escape_string($this->input->post('bracket')),
		'rangel' => mysql_real_escape_string($this->input->post('rangel')),
		'rangeh' => mysql_real_escape_string($this->input->post('rangeh')),
		'base' => mysql_real_escape_string($this->input->post('base')),
		'total' => mysql_real_escape_string($this->input->post('total')),
		'pes' => mysql_real_escape_string($this->input->post('pes')),
		'per' => mysql_real_escape_string($this->input->post('per'))
		);
		$this->db->where('id',$this->input->post('hidden'));
		$this->db->update('philhealth',$data); 
			//insert to history
		$query=$this->db->query('SELECT NOW() time FROM dual');
		foreach($query->result() as $row)
			$today=$row->time;
		$name = $this->session->userdata("fname").' '.$this->session->userdata("sname");
		$bracket= mysql_real_escape_string($this->input->post('bracket'));
		$this->db->query('INSERT INTO history(`date`,`user`,`person`,`table`,`action`) VALUES ("'.$today.'","'.$name.'","'.$bracket.'","philhealth","update")');

	}
		
	function get($id)
	{
		$this->load->database();	// loads and initializes the database class
		$query = $this->db->getwhere('philhealth',array('id'=>$id));
		return $query->row_array();
	}

	function PHILHEALTH_insertPHBrackets(){
		$N = count($_POST['bracket']);
		
		// transfer post data
		$bracket = mysql_real_escape_string($_POST['bracket']);
		$rangel = mysql_real_escape_string($_POST['rangel']);
		$rangeh = mysql_real_escape_string($_POST['rangeh']);
		$base = mysql_real_escape_string($_POST['base']);
		$total = mysql_real_escape_string($_POST['total']);
		$pes = mysql_real_escape_string($_POST['pes']);
		$per = mysql_real_escape_string($_POST['per']);
		
		for($i=0;$i<$N;$i++){
			$query = "INSERT INTO `philhealth` VALUES
			('".$bracket[$i]."', '".$rangel[$i]."',
			'".$rangeh[$i]."', '".$base[$i]."',
			'".$total[$i]."', '".$pes[$i]."',
			'".$per[$i]."', "."'null')";
			mysql_query($query);	// insert each new bracket
			//insert to history
			$query=$this->db->query('SELECT NOW() time FROM dual');
			foreach($query->result() as $row)
				$today=$row->time;
			$name = 	$name = $this->session->userdata("fname").' '.$this->session->userdata("sname");
			$bracket= $bracket[$i];
			$this->db->query('INSERT INTO history(`date`,`user`,`person`,`table`,`action`) VALUES ("'.$today.'","'.$name.'","'.$bracket.'","philhealth","insert")');
		}
	}	// insert Philhealth Brackets
}
?>