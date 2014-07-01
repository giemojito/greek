<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_developer
 */
class M_developer extends CI_Model {

    var $tbl = 'greekgroup';
	
    function __construct()
    {
        parent::__construct();
    }
    
    function getAll()
    {
        $this->db->where('isdisplayed', '1');
        $vars = $this->db->get($this->tbl);
        return $vars->result();
    }
    
    function getGroup($id)
    {
        $this->db->where('usergroupid', $id);
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
		$this->db->where('usergroupid', $id)->update($this->tbl, $data);
    }
	
	function UpdateBatch($data, $key)
	{
		$this->db->update_batch($this->tbl, $data, $key);
	}
    
    function Delete($id)
    {
        if (is_array($id)) {
            $this->db->where_in('usergroupid', $id)->delete($this->tbl);
        }
        else {
            $this->db->where('usergroupid', $id)->delete($this->tbl);
        }
    }

    function Max()
    {
        $this->db->select_max('grouplevel');
        $query = $this->db->get($this->tbl);
        
        foreach ($query->row() as $value) {
            $max = $value * 2;
        }

        return $max;
    }

}