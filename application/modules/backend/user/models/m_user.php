<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_user
 */
class M_user extends CI_Model {

    var $tbl = 'greekuser';
	
    function __construct()
    {
        parent::__construct();
    }
    
    function getAll()
    {
        $vars = $this->db->get($this->tbl);
        return $vars->result();
    }
    
    function getGroup($id)
    {
        $this->db->where('user_id', $id);
        $vars = $this->db->get($this->tbl);
        return $vars->row();
    }
	
	function get($field, $val)
    {
        $this->db->where($field, $val);
        $vars = $this->db->get($this->tbl);
        return $vars->row();
    }
    
    function Add($data)
    {
        $this->db->insert_batch($this->tbl, $data);
    }
    
    function Update($id, $data)
    {
		$this->db->where('user_id', $id)->update($this->tbl, $data);
    }
	
	function UpdateBatch($data, $key)
	{
		$this->db->update_batch($this->tbl, $data, $key);
	}
    
    function Delete($id)
    {
        $this->db->where('user_id', $id)->delete($this->tbl);
    }

}