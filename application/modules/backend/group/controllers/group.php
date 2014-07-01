<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends Admin_Controller {
    
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('security'));
		$this->load->model('m_group');
	}

	function index()
    {
        $this->data['header'] = 'Daftar Group';
        $tblheader = '
            <form name="theForm" id="theForm" method="post" action="">
            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <div class="checker">
                                <span class="checked">
                                    <input class="uniform" type="checkbox" name="usergroupid" id="usergroupid" onChange="javascript:checkAll();">
                                </span>
                            </div>
                        </th>
                        <th>Group</th>
                        <th>Desc</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
        ';
        
        $vars = $this->m_group->getAll();

        $tblcontent = '';
        $no = 1;
        foreach ($vars as $var) {
            $tblcontent .= '
                <tr>
                    <td>' . $no . '</td>
                    <td>
                        <div class="checker">
                            <span class="checked">
                                <input class="uniform" type="checkbox" name="usergroupid['.$var->usergroupid.']" id="usergroupid'.$no.'" value="'.$var->usergroupid.'">
                            </span>
                        </div>
                    </td>
                    <td>' . $var->name . '</td>
                    <td>' . $var->description . '</td>
                    <td>' . $var->grouplevel . '</td>
                    <td align="left"> 
                        <a class="btn btn-default btn-xs btn-circle btn-grad" href="group/edit/'.$var->usergroupid.'" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-xs btn-circle btn-grad" href="group/delFromList?usergroupid='.$var->usergroupid.'" title="Delete">
                            <i class="fa fa-eraser"></i>
                        </a>
                    </td>
                </tr>
            ';
            ++$no;
        } 
        $numOfRow = $no;
        $tblfooter = '</tbody></table></form>';

        $this->greek_toolbar->add('add', 'group/add', 'Tambah');
        $this->greek_toolbar->add('delete', 'javascript:delFromList();', 'Hapus');
        $this->greek_toolbar->add('refresh', 'group', 'Refresh');
        $this->data['toolbar'] = $this->greek_toolbar->to_string();

        $this->data['numOfRow'] = $numOfRow;
        $this->data['tables'] = $tblheader . $tblcontent . $tblfooter;
        $this->_render('group/landing');
	}

	function add()
	{
		$this->greek_toolbar->add('save', 'javascript:submitForm();', 'Simpan!');
        $this->greek_toolbar->add('cancel', 'javascript:window.history.go(-1);', 'Cancel!');
        $this->data['toolbar'] = $this->greek_toolbar->to_string();
        $this->data['action'] = 'add';
        $this->data['level'] = $this->m_group->Max();
		$this->_render('group/alter');
	}

    function edit($usergroupid)
    {
        $this->greek_toolbar->add('save', 'javascript:submitForm();', 'Simpan!');
        $this->greek_toolbar->add('cancel', 'javascript:window.history.go(-1);', 'Cancel!');
        $this->data['toolbar'] = $this->greek_toolbar->to_string();
        $this->data['action'] = 'edit';
        $this->data['obj'] = $this->m_group->getGroup($usergroupid);
        $this->_render('group/alter');
    }

    function cgi()
    {
        extract($_POST, EXTR_PREFIX_ALL, "post");
        switch ($post_action) {
            case 'add':
                $obj = array(
                    array(
                        'name' => $post_groupname,
                        'description' => $post_groupdesc,
                        'grouplevel' => $post_grouplevel
                    ),
                );

                $res = $this->m_group->Add($obj);
                if ($res > 0) {
                    $message = "Group gagal ditambah!";
                    $flag = 'FALSE';
                }
                else {
                    $message = "Group berhasil ditambah!";
                    $flag = 'TRUE';
                }

                $this->greek_alert->flash($message, $flag);
                redirect('group');
                break;
            
            case 'edit':
                $obj = array(
                    'name' => $post_groupname,
                    'description' => $post_groupdesc,
                    'grouplevel' => $post_grouplevel
                );

                $res = $this->m_group->Update($post_usergroupid, $obj);
                if ($res > 0) {
                    $message = "Group gagal diupdate!";
                    $flag = 'FALSE';
                }
                else {
                    $message = "Group berhasil diupdate!";
                    $flag = 'TRUE';
                }

                $this->greek_alert->flash($message, $flag);
                redirect('group');
				break;
		}
	}

    function delFromList()
    {
        extract($_POST, EXTR_PREFIX_ALL, "post");
        extract($_GET, EXTR_PREFIX_ALL, "get");

        if (is_array($post_usergroupid))
        {
            $res = $this->m_group->Delete($post_usergroupid);
        }
        else {
            $res = $this->m_group->Delete($usergroupid);
        }

        if ($res > 0) {
            $message = "Group gagal dihapus!";
            $flag = 'FALSE';
        }
        else {
            $message = "Group berhasil dihapus!";
            $flag = 'TRUE';
        }

        $this->greek_alert->flash($message, $flag);
        redirect('group');
    }

}