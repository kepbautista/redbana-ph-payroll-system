<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sss_model extends CI_Model {
	function Sssmodel()
	{	
		parent::_Model();	// to load the parent constructor
		$this->load->library('table');	// to invoke the the class name
	}
	
	function Sss_getall()
	{
		$this->load->database();	// loads and initializes the database class
		$query = $this->db->query('SELECT `rangel`,`rangeh`,`msc`,`ser`,`see`,`stotal`,`ecer`,`ter`,`tee`,`ttotal`,`totalcont`,`id` FROM sss GROUP BY `rangel`');
		return $query->result();
	}
	
	function Sss_numrows()
	{
		$this->load->database();	// loads and initializes the database class
		$trows = $this->db->query('SELECT `rangel`,`rangeh`,`msc`,`ser`,`see`,`stotal`,`ecer`,`ter`,`tee`,`ttotal`,`totalcont` FROM sss GROUP BY `rangel`');
		return $trows->num_rows();
	}
	
	function Sss_update()
	{
		$this->load->database();	// loads and initializes the database class
		$data = array(
        'rangel' => mysql_real_escape_string($this->input->post('rangel')),
        'rangeh' => mysql_real_escape_string($this->input->post('rangeh')),
		'msc' => mysql_real_escape_string($this->input->post('msc')),
        'ser' => mysql_real_escape_string($this->input->post('ser')),
        'see' => mysql_real_escape_string($this->input->post('see')),
        'stotal' => mysql_real_escape_string($this->input->post('stotal')),
		'ecer' => mysql_real_escape_string($this->input->post('ecer')),
		'ter' => mysql_real_escape_string($this->input->post('ter')),
		'tee' => mysql_real_escape_string($this->input->post('tee')),
		'ttotal' => mysql_real_escape_string($this->input->post('ttotal')),
        'totalcont' => mysql_real_escape_string($this->input->post('totalcont'))
		);
		$this->db->where('id',$this->input->post('hidden'));
		$this->db->update('sss',$data);  
	}
	
	function get($id)
	{
		$this->load->database();	// loads and initializes the database class	
		$query = $this->db->getwhere('sss',array('id'=>$id));
		return $query->row_array();        
	}
	
	function SSS_insertBrackets(){
		$N = count($_POST['rangel']);
		
		// transfer post data
		$rangel = mysql_real_escape_string($_POST['rangel']);
		$rangeh = mysql_real_escape_string($_POST['rangeh']);
		$msc = mysql_real_escape_string($_POST['msc']);
		$ser = mysql_real_escape_string($_POST['ser']);
		$see = mysql_real_escape_string($_POST['see']);
		$stotal = mysql_real_escape_string($_POST['stotal']);
		$ecer = mysql_real_escape_string($_POST['ecer']);
		$ter = mysql_real_escape_string($_POST['ter']);
		$tee = mysql_real_escape_string($_POST['tee']);
		$ttotal = mysql_real_escape_string($_POST['ttotal']);
		$totalcont = mysql_real_escape_string($_POST['totalcont']);
		
		for($i=0;$i<$N;$i++){
			$query = "INSERT INTO `sss` VALUES 
			('".$rangel[$i]."','".$rangeh[$i]."','"
			.$ser[$i]."','".$see[$i]."','".$stotal[$i]."','"
			.$ecer[$i]."','".$ter[$i]."','".$tee[$i]."','"
			.$ttotal[$i]."','".$msc[$i]."','".$totalcont[$i]."',"
			."'null')";
			mysql_query($query);	// insert each new bracket
		}
	}	// insert SSS Brackets
}
?>