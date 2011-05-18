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
		'bracket'=>$this->input->post('bracket'),
		'rangel'=>$this->input->post('rangel'),
		'rangeh'=>$this->input->post('rangeh'),
		'base'=>$this->input->post('base'),
		'total'=>$this->input->post('total'),
		'pes'=>$this->input->post('pes'),
		'per'=>$this->input->post('per')
		);
		$this->db->where('id',$this->input->post('hidden'));
		$this->db->update('philhealth',$data);  
	}
		
	function get($id)
	{
		$this->load->database();	// loads and initializes the database class
		$query = $this->db->getwhere('philhealth',array('id'=>$id));
		return $query->row_array();
	}

	function PHILHEALTH_insertBrackets(){
		$N = count($_POST['bracket']);
		
		// transfer post data
		$bracket = $_POST['bracket'];
		$rangel = $_POST['rangel'];
		$rangeh = $_POST['rangeh'];
		$base = $_POST['base'];
		$total = $_POST['total'];
		$pes = $_POST['pes'];
		$per = $_POST['per'];
		
		for($i=0;$i<$N;$i++){
			$query = "INSERT INTO `philhealth` VALUES
			('".$bracket[$i]."', '".$rangel[$i]."',
			'".$rangeh[$i]."', '".$base[$i]."',
			'".$total[$i]."', '".$pes[$i]."',
			'".$per[$i]."', "."'null')";
			mysql_query($query);	// insert each new bracket
		}
	}	// insert Philhealth Brackets
}
?>