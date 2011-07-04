<?php

class Message_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function add($data)
    {
        $this->db->insert('messages', $data);
    }
    
    function get($limit=5, $offset=0)
    {
        //$this->db->orderby('id', 'DESC');
        $this->db->limit($limit, $offset);
        
        return $this->db->get('messages')->result();
    }
    
    function get_latest()
    {
        $this->db->orderby('id', 'DESC');
        $this->db->limit(1, 0);
        
        return $this->db->get('messages')->result();
    }
}

?>
