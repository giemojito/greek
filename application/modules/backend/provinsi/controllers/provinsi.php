<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Provinsi extends Admin_Controller {
    
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_provinsi');
	}

	function index()
    {
        // extracting parameters
        extract($_GET,EXTR_PREFIX_ALL,"get");
        $where = '';
        if (isset($get_nama) && $get_nama != "") {
            $where['nama like'] = '%'.$get_nama.'%';
        }

        $this->data['header'] = 'Daftar Provinsi';
        $tblheader = '
            <form name="theForm" id="theForm" method="post" action="">
            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <div class="checker">
                                <span class="checked">
                                    <input class="uniform" type="checkbox" name="dati1id" id="dati1id" onChange="javascript:checkAll();">
                                </span>
                            </div>
                        </th>
                        <th>Nama</th>
                        <th>Singkatan</th>
                        <th>Kode</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
        ';
        
        $vars = $this->m_provinsi->getAll($where);

        $tblcontent = '';
        $no = 1;
        foreach ($vars as $var) {
            $tblcontent .= '
                <tr>
                    <td>' . $no . '. </td>
                    <td>
                        <div class="checker">
                            <span class="checked">
                                <input class="uniform" type="checkbox" name="dati1id['.$var->dati1id.']" id="dati1id'.$no.'" value="'.$var->dati1id.'">
                            </span>
                        </div>
                    </td>
                    <td>' . $var->nama . '</td>
                    <td>' . $var->singkatan . '</td>
                    <td>' . $var->fullcode . '</td>
                    <td align="left"> 
                        <a class="btn btn-default btn-xs btn-circle btn-grad" href="provinsi/edit/'.$var->dati1id.'" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-xs btn-circle btn-grad" href="provinsi/delFromList?dati1id='.$var->dati1id.'" title="Delete">
                            <i class="fa fa-eraser"></i>
                        </a>
                    </td>
                </tr>
            ';
            ++$no;
        } 
        $numOfRow = $no;
        $tblfooter = '</tbody></table></form>';

        $this->greek_toolbar->add('add', 'provinsi/add', 'Tambah');
        $this->greek_toolbar->add('delete', 'javascript:delFromList();', 'Hapus');
        $this->greek_toolbar->add('refresh', 'provinsi/', 'Refresh');
        $this->data['toolbar'] = $this->greek_toolbar->to_string();

        $this->data['numOfRow'] = $numOfRow;
        $this->data['tables'] = $tblheader . $tblcontent . $tblfooter;
        $this->_render('provinsi/landing');
	}

	function add()
	{
		$this->greek_toolbar->add('save', 'javascript:submitForm();', 'Simpan!');
        $this->greek_toolbar->add('cancel', 'javascript:window.history.go(-1);', 'Cancel!');
        $this->data['toolbar'] = $this->greek_toolbar->to_string();
        $this->data['action'] = 'add';
		$this->_render('provinsi/alter');
	}

    function edit($dati1id)
    {
        $this->greek_toolbar->add('save', 'javascript:submitForm();', 'Simpan!');
        $this->greek_toolbar->add('cancel', 'javascript:window.history.go(-1);', 'Cancel!');
        $this->data['toolbar'] = $this->greek_toolbar->to_string();
        $this->data['action'] = 'edit';
        $this->data['obj'] = $this->m_provinsi->getProv($dati1id);
        $this->_render('provinsi/alter');
    }

    function cgi()
    {
        extract($_POST, EXTR_PREFIX_ALL, "post");
        switch ($post_action) {
            case 'add':
                $obj = array(
                    array(
                        'fullcode' => $post_fullcode,
                        'nama' => $post_nama,
                        'singkatan' => $post_singkatan,
                        'isln' => $post_isln
                    ),
                );

                $res = $this->m_provinsi->Add($obj);
                if ($res > 0) {
                    $message = "Provinsi gagal ditambah!";
                    $flag = 'FALSE';
                }
                else {
                    $message = "Provinsi berhasil ditambah!";
                    $flag = 'TRUE';
                }

                $this->greek_alert->flash($message, $flag);
                redirect('provinsi');
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
                    $message = "Group gagal diupdate!";
                    $flag = 'FALSE';
                }
                else {
                    $message = "Group berhasil diupdate!";
                    $flag = 'TRUE';
                }

                $this->greek_alert->flash($message, $flag);
                redirect('provinsi');
				break;
		}
	}

    function delFromList()
    {
        extract($_POST, EXTR_PREFIX_ALL, "post");
        extract($_GET, EXTR_PREFIX_ALL, "get");

        if (is_array($post_dati1id))
        {
            $res = $this->m_provinsi->Delete($post_dati1id);
        }
        else {
            $res = $this->m_provinsi->Delete($get_dati1id);
        }

        if ($res > 0) {
            $message = "Provinsi gagal dihapus!";
            $flag = 'FALSE';
        }
        else {
            $message = "Provinsi berhasil dihapus!";
            $flag = 'TRUE';
        }

        $this->greek_alert->flash($message, $flag);
        redirect('provinsi');
    }

}