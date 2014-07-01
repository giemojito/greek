<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_provinsi
 */
class M_provinsi extends CI_Model {

    var $tbl = 'master_dati1';
	
    function __construct()
    {
        parent::__construct();
    }
    
    function getAll($where = '')
    {
        if ($where != '')
        {
            if (is_array($where)) {
                $this->db->where($where);
            }
            else {
                $this->db->where($where, NULL, FALSE);
            }
        }

        $vars = $this->db->get($this->tbl);
        return $vars->result();
    }
    
    function getProv($dati1id)
    {
        $this->db->where('dati1id', $dati1id);
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
		$this->db->where('dati1id', $id)->update($this->tbl, $data);
    }
	
	function UpdateBatch($data, $key)
	{
		$this->db->update_batch($this->tbl, $data, $key);
	}
    
    function Delete($id)
    {
        if (is_array($id)) {
            $this->db->where_in('dati1id', $id)->delete($this->tbl);
        }
        else {
            $this->db->where('dati1id', $id)->delete($this->tbl);
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