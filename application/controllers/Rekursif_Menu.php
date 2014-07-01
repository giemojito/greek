<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekursif_Menu extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function greek_paging()
	{
		$this->load->library(array('greek_table'));
		$this->greek_table->set_header(array('#','Kode', 'Nama','Singkatan','Is Luarnegeri?'));

		// initialize by user
		$this->greek_table->init_offset($this->uri->segment(3));
		$this->greek_table->displayed_rows = 10;
		// $this->greek_table->is_display_all_rows = TRUE;
		$str = "select * from master_dati2";
		$obj = $this->greek_table->get_data($str);

		// initialize by class greek_table just sent the table
		// $obj = $this->greek_table->get_data('master_dati2');

		$i = 0;
		foreach ($obj as $value) {
	        $rowArr = array(
	            $value['dati2id'],
	            $value['fullcode'],
	            $value['nama'],
	            $value['dati1nama'],
	            $value['isln']
	    	);

	    	$this->greek_table->add_row($rowArr);
	    	++$i;
    	}

    	$this->data['mytable'] = $this->greek_table->to_string();
		$this->load->view('paging', $this->data);
	}

	function index()
	{
		echo $this->menu('0', $ret = "");
		exit();
	}

	private function _menu()
	{
		$retval = $this->m_general->get_menu();
		$navbar = "<ul>";

		foreach ($retval as $greekmenu) {
			$child = sizeof($greekmenu['child']);
			if ($child > 0) {
				$navbar .= '<li><a href="javascript:;">'.$greekmenu['nama'].'</a></li>';
				$navbar .= $this->print_child($greekmenu['child']);
			}
			else {
				$navbar .= '<li><a href="#">'.$greekmenu['nama'].'</a></li>';
			}
		}

		$navbar .= "</ul>";

		return $navbar;
	}

	function print_child($data)
	{
	    $str = "<ul>";

	    foreach ($data as $list) {
	        $str .= "<li><a href='javascript:#;'>" . $list['nama'] . "</a></li>";
	        $subchild = $this->print_child($list['child']);

	        if ($subchild != '') {
	            $str .= "<ul>".$subchild."</ul>";
	        }

	        $str .= "</li>";
	    }

	    $str .= "</ul>";

	    return $str;
	}

	private function menu($parent = 0, $hasil) 
	{
		$w = $this->db->query("SELECT * from tbl_menu_copy where id_parent='" . $parent . "'");

		if (($w->num_rows()) > 0) {
			$hasil .= "<ul>";
		}
		
		foreach ($w->result() as $h) {
			$hasil .= "<li>" . $h->menu;
			$hasil = $this->menu($h->menuid, $hasil);
			$hasil .= "</li>";
		}
		
		if (($w->num_rows) > 0) {
			$hasil .= "</ul>";
		}

		return $hasil;
	}


	function dropdown()
    {
		$dt1 = $this->m_general->get_dati1('master_dati1');

 		foreach ($dt1 as $value) {
 			$data['prp'][''] = '';
 			$data['prp'][$value->fullcode] = $value->nama;
 		}

 		$this->load->view('dropdown'.HTM_EXT, $data);
    }

    function dati2()
    {
    	extract($_POST, EXTR_PREFIX_ALL, 'post');
    	$headers = explode(',', $this->input->get_request_header('Accept', TRUE));
    	$dati2 = $this->m_general->get_dati2($post_dati1);
        
        $obj = "<option value=''></option>";
        foreach ($dati2 as $item) {
        	$obj .= '<option value="'.substr($item->fullcode,3,2).'">'.$item->nama.'</option>';
        }

        switch ($headers['0']) {
        	case 'application/json':
		        echo json_encode($obj);
        		break;
        	
        	case '*/*':
        	default:
        		return $obj;
        		break;
        }
    }

    function dati3()
    {
    	$headers = explode(',', $this->input->get_request_header('Accept', TRUE));
    	extract($_POST, EXTR_PREFIX_ALL, 'post');

    	$dati2 = $post_dati1.'.'.$post_dati2;
    	$dati3 = $this->m_general->get_dati3($dati2);

        $obj = "<option value=''></option>";
        foreach ($dati3 as $item) {
        	$obj .= '<option value="'.substr($item->fullcode,6,2).'">'.$item->nama.'</option>';
        }

        switch ($headers['0']) {
        	case 'text/javascript':
        	case 'application/json':
		        echo json_encode($obj);
        		break;
        	
        	default:
        		echo $obj;
        		break;
        }
    }

    function dati4()
    {
    	$headers = explode(',', $this->input->get_request_header('Accept', TRUE));
    	extract($_POST, EXTR_PREFIX_ALL, 'post');

    	$dati3 = implode('.', $_POST);
    	$dati4 = $this->m_general->get_dati4($dati3);

        $obj = "<option value=''></option>";
        foreach ($dati4 as $item) {
        	$obj .= '<option value="'.substr($item->fullcode,9,4).'">'.$item->nama.'</option>';
        }

        switch ($headers['0']) {
        	case 'text/javascript':
        	case 'application/json':
		        echo json_encode($obj);
        		break;
        	
        	default:
        		echo $obj;
        		break;
        }
    }
}
