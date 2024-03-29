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
        'rangel' => $this->input->post('rangel'),
        'rangeh' => $this->input->post('rangeh'),
		'msc' => $this->input->post('msc'),
        'ser' => $this->input->post('ser'),
        'see' => $this->input->post('see'),
        'stotal' => $this->input->post('stotal'),
		'ecer' => $this->input->post('ecer'),
		'ter' => $this->input->post('ter'),
		'tee' => $this->input->post('tee'),
		'ttotal' => $this->input->post('ttotal'),
        'totalcont' => $this->input->post('totalcont')
		);
		$this->db->where('id',$this->input->post('hidden'));
		$this->db->update('sss',$data);  
		//insert to history
		$query=$this->db->query('SELECT NOW() time FROM dual');
		foreach($query->result() as $row)
			$today=$row->time;
			
		$name = $this->session->userdata("fname").' '.$this->session->userdata("sname");
		$bracket= $this->input->post('rangel').'-'.$this->input->post('rangeh');
		$this->db->query('INSERT INTO history(`date`,`user`,`person`,`table`,`action`) VALUES ("'.$today.'","'.$name.'","'.$bracket.'","sss","update")');
	
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
		$rangel = $_POST['rangel'];
		$rangeh = $_POST['rangeh'];
		$msc = $_POST['msc'];
		$ser = $_POST['ser'];
		$see = $_POST['see'];
		$stotal = $_POST['stotal'];
		$ecer = $_POST['ecer'];
		$ter = $_POST['ter'];
		$tee = $_POST['tee'];
		$ttotal = $_POST['ttotal'];
		$totalcont = $_POST['totalcont'];
		
		for($i=0;$i<$N;$i++){
			$query = "INSERT INTO `sss` VALUES 
			('".$rangel[$i]."','".$rangeh[$i]."','"
			.$ser[$i]."','".$see[$i]."','".$stotal[$i]."','"
			.$ecer[$i]."','".$ter[$i]."','".$tee[$i]."','"
			.$ttotal[$i]."','".$msc[$i]."','".$totalcont[$i]."',"
			."'null')";
			mysql_query($query);	// insert each new bracket
			//insert to history
			$query=$this->db->query('SELECT NOW() time FROM dual');
			foreach($query->result() as $row)
				$today=$row->time;
			$name = 	$name = $this->session->userdata("fname").' '.$this->session->userdata("sname");
			$bracket= $rangel[$i].'-'.$rangeh[$i];
			$this->db->query('INSERT INTO history(`date`,`user`,`person`,`table`,`action`) VALUES ("'.$today.'","'.$name.'","'.$bracket.'","sss","insert")');
		
		}
	}	// insert SSS Brackets
}
?>