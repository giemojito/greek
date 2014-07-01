<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_auth
 */
class M_auth extends CI_Model {

	var $tbl = 'greekuser';
	
	function __construct()
	{
		parent::__construct();
	}

	function validasi($user, $pass)
	{
		$this->db->where('username', $user);
		$this->db->where('password', $pass);
		$this->db->where('isenabled', '1');

		$result = $this->db->get($this->tbl)->row();
		if(!empty($result)) {
			return true;
		}
		else {
			return false;
		}
	}

	function getDataUser($id)
	{
		$this->db->where('username', $id);
		$result = $this->db->get($this->tbl)->row();
		return $result;
	}

	function UpdateDataUser($key, $data)
    {
        $this->db->where('username', $key)->update($this->tbl, $data);
    }

}
