<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kabkota extends Admin_Controller {
    
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_kabkota');
	}

	function index()
    {
        // extracting parameters
        extract($_GET,EXTR_PREFIX_ALL,"get");
        $where = '';
        if (isset($get_nama) && $get_nama != "") {
            $where['nama like'] = '%'.$get_nama.'%';
        }

        if (isset($get_d1) && preg_match("/[0-9]{2}/",$get_d1)) {
            $where['fullcode like'] = $get_d1.'%';
        }

        $this->data['header'] = 'Daftar Kabupaten / Kota';
        $tblheader = '
            <form name="theForm" id="theForm" method="post" action="">
            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <div class="checker">
                                <span class="checked">
                                    <input class="uniform" type="checkbox" name="dati2id" id="dati2id" onChange="javascript:checkAll();">
                                </span>
                            </div>
                        </th>
                        <th>Nama</th>
                        <th>Provinsi</th>
                        <th>Kode</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
        ';
        
        $vars = $this->m_kabkota->getAll($where);

        $tblcontent = '';
        $no = 1;
        foreach ($vars as $var) {
            $tblcontent .= '
                <tr>
                    <td>' . $no . '</td>
                    <td>
                        <div class="checker">
                            <span class="checked">
                                <input class="uniform" type="checkbox" name="dati2id['.$var->dati2id.']" id="dati2id'.$no.'" value="'.$var->dati2id.'">
                            </span>
                        </div>
                    </td>
                    <td>' . $var->nama . '</td>
                    <td>' . $var->dati1nama . '</td>
                    <td>' . $var->fullcode . '</td>
                    <td align="left"> 
                        <a class="btn btn-default btn-xs btn-circle btn-grad" href="kabkota/edit/'.$var->dati2id.'" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-xs btn-circle btn-grad" href="kabkota/delFromList?dati2id='.$var->dati2id.'" title="Delete">
                            <i class="fa fa-eraser"></i>
                        </a>
                    </td>
                </tr>
            ';
            ++$no;
        } 
        $numOfRow = $no;
        $tblfooter = '</tbody></table></form>';

        $this->greek_toolbar->add('add', 'kabkota/add', 'Tambah');
        $this->greek_toolbar->add('delete', 'javascript:delFromList();', 'Hapus');
        $this->greek_toolbar->add('refresh', 'kabkota/', 'Refresh');
        $this->data['toolbar'] = $this->greek_toolbar->to_string();

        $this->data['numOfRow'] = $numOfRow;
        $this->data['tables'] = $tblheader . $tblcontent . $tblfooter;

        $d1 = $this->m_kabkota->getPropinsi();
        $sel = isset($get_d1) ? $get_d1 : "";
        $this->data['formdropdown'] = _crtDropdown($d1, 'd1', $sel, 'onchange="document.searchForm.submit();"');
        $get_nama = isset($get_nama) ? $get_nama : "";
        $this->data['get_nama'] = $get_nama;

        $this->_render('kabkota/landing');
	}

	function add()
	{
		$this->greek_toolbar->add('save', 'javascript:submitForm();', 'Simpan!');
        $this->greek_toolbar->add('cancel', 'javascript:window.history.go(-1);', 'Cancel!');
        $this->data['toolbar'] = $this->greek_toolbar->to_string();
        $this->data['action'] = 'add';

        $d1 = $this->m_kabkota->getPropinsi();
        $this->data['formdropdown'] = _crtDropdown($d1, 'dati1id', '', 'onchange="d1change();"');

		$this->_render('kabkota/alter');
	}

    function edit($dati2id)
    {
        $this->greek_toolbar->add('save', 'javascript:submitForm();', 'Simpan!');
        $this->greek_toolbar->add('cancel', 'javascript:window.history.go(-1);', 'Cancel!');
        $this->data['toolbar'] = $this->greek_toolbar->to_string();
        
        $this->data['action'] = 'edit';
        
        $d2 = $this->m_kabkota->getKabkota($dati2id);
        $this->data['obj'] = $d2;
        
        if (sizeof($d2) > 0) {
            list($d1,$d2) = explode(".", $d2->fullcode);
        }

        $this->data['d1'] = $d1;
        $this->data['d2'] = $d2;

        $prov = $this->m_kabkota->getPropinsi();
        $this->data['formdropdown'] = _crtDropdown($prov, 'd1', $d1, 'onchange="document.searchForm.submit();"');

        $this->_render('kabkota/alter');
    }

    function cgi()
    {
        // die('<pre>'.print_r($_POST,1).'</pre>');
        extract($_POST, EXTR_PREFIX_ALL, "post");
        switch ($post_action) {
            case 'add':
                $prov = $this->m_general->get_dati1($post_dati1id);
                $fullcode = "$post_d1.$post_d2";
                $res = $this->m_kabkota->get('fullcode', $fullcode);
                echo $this->db->last_query();

                // check duplikasi
                if (sizeof($res) > 0) {
                    // duplicate
                    $message = "Kode $fullcode suda ada!";
                    $flag = 'FALSE';
                    $this->greek_alert->flash($message, $flag);
                    redirect('kabkota/add');
                }

                $obj = array(
                    array(
                        'fullcode' => $fullcode,
                        'nama' => $post_nama,
                        'dati1nama' => $prov->nama,
                        'isln' => $post_isln
                    ),
                );

                $res = $this->m_kabkota->Add($obj);
                if ($res > 0) {
                    $message = "Kabkota gagal ditambah!";
                    $flag = 'FALSE';
                }
                else {
                    $message = "Kabkota berhasil ditambah!!";
                    $flag = 'TRUE';
                }

                $this->greek_alert->flash($message, $flag);
                redirect('kabkota');
                break;
            
            case 'edit':
                $obj = array(
                    'fullcode' => $post_fullcode,
                    'nama' => $post_nama,
                    'singkatan' => $post_singkatan,
                    'isln' => $post_isln
                );

                $res = $this->m_provinsi->Update($post_dati1id, $obj);
                if ($res > 0) {
                    $message = "Data Kabkota gagal diupdate!";
                    $flag = 'FALSE';
                }
                else {
                    $message = "Data Kabkota berhasil diupdate!";
                    $flag = 'TRUE';
                }

                $this->greek_alert->flash($message, $flag);
                redirect('kabkota');
				break;
		}
	}

    function delFromList()
    {
        extract($_POST, EXTR_PREFIX_ALL, "post");
        extract($_GET, EXTR_PREFIX_ALL, "get");

        if (is_array($post_dati2id))
        {
            $res = $this->m_kabkota->Delete($post_dati2id);
        }
        else {
            $res = $this->m_kabkota->Delete($get_dati2id);
        }

        if ($res > 0) {
            $message = "Data gagal dihapus!";
            $flag = 'FALSE';
        }
        else {
            $message = "Data berhasil dihapus!!";
            $flag = 'TRUE';
        }

        $this->greek_alert->flash($message, $flag);
        redirect('kabkota');
    }

}