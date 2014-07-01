<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_general
 */
class M_general extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}

	function getRecords($tbl, $limit, $offset)
	{
		$vars = $this->db->get($tbl, $limit, $offset)->result_array();
		return $vars;

		// return $this->db->get($tbl, $limit, $offset);
	}

	function getAll($tbl)
    {
        $vars = $this->db->get($tbl);
        return $vars;
    }
    
 //    function Add($data, $tbl)
 //    {
 //        $this->db->insert($tbl, $data);
 //    }

 //    function AddBatch($data, $tbl)
 //    {
 //        $this->db->insert_batch($tbl, $data);
 //    }
    
 //    function UpdateBatch($data, $key, $tbl)
	// {
	// 	$this->db->update_batch($tbl, $data, $key);
	// }

 //    function Update($id, $data, $tbl)
 //    {
 //        $this->db->where('id', $id)->update($tbl, $data);
 //    }
    
 //    function Delete($id, $tbl)
 //    {
 //        $this->db->where('id', $id)->delete($tbl);
 //    }

    function GetGroup($usergroupid)
    {
        $this->db->where('usergroupid', $usergroupid);
        $vars = $this->db->get('greekgroup')->row();
        return $vars;
    }

	function get_dati1($obj)
	{
		$vars = $this->db->get($obj);
        return $vars->result();

        
  //       $this->db->where('fullcode', $obj);
		// $vars = $this->db->get('master_dati1');
  //       return $vars->row();
	}

	function get_dati2($where = '')
	{
		$this->db->like('fullcode', $where.'.', 'after');
		$vars = $this->db->get('master_dati2');
		return $vars->result();
	}

	function get_dati3($where = '')
	{
		$this->db->like('fullcode', $where.'.', 'after');
		$vars = $this->db->get('master_dati3');
		return $vars->result();
	}

	function get_dati4($where = '')
	{
		$this->db->like('fullcode', $where.'.', 'after');
		$vars = $this->db->get('master_dati4');
		return $vars->result();
	}

	function getObj($tbl)
    {
        $this->db->select('fullcode, nama');
        $Vars = $this->db->get($tbl);
        
        return $Vars->result();;
    }
	
}
