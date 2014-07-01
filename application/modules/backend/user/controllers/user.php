<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Admin_Controller {
    
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('security'));
		$this->load->model('m_user');
	}

	function index()
    {
        $this->data['header'] = "Daftar User";

        $tblheader = '
            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <div class="checker">
                                <span class="checked">
                                    <input class="uniform" type="checkbox" name="cuserid" id="cuserid" onChange="javascript:checkAll();">
                                </span>
                            </div>
                        </th>
                        <th>Username</th>
                        <th>Fullname</th>
                        <th>Group</th>
                        <th>Email</th>
                        <th>Last Login</th>
                        <th>Is Login?</th>
                        <th>Is Active?</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
        ';
        
        $vars = $this->m_user->getAll();

        $tblcontent = '';
        $no = 1;
        foreach ($vars as $var) {
            $group = $this->m_general->GetGroup($var->usergroupid);
            $lastlogin = $var->lastlogin == "0" ? "&nbsp;" : date("d-F-Y H:i:s", $var->lastlogin);
            
            $islogin = $var->islogin == '7' ? '<a class="btn btn-success btn-xs btn-circle btn-grad" href="#" title="Force logout!"> <i class="fa fa-play-circle"></i></a>' : "&nbsp";

            $isactive = $var->isenabled == '1' ? '<a class="btn btn-success btn-xs btn-circle btn-grad" href="#"><i class="fa fa-check"></i></a>' : '<a class="btn btn-danger btn-xs btn-circle btn-grad" href="#"><i class="fa fa-check"></i></a>';
            $tblcontent .= '
                <tr>
                    <td>' . $no . '</td>
                    <td>
                        <div class="checker">
                            <span class="checked">
                                <input class="uniform" type="checkbox" name="userid['.$var->user_id.']" id="userid'.$no.'" value="'.$var->user_id.'">
                            </span>
                        </div>
                    </td>
                    <td>' . $var->username . '</td>
                    <td>' . $var->name . '</td>
                    <td>' . $group->name . '</td>
                    <td>' . $var->email . '</td>
                    <td>' . $lastlogin . '</td>
                    <td align="center">' . $islogin . '</td>
                    <td align="center">' . $isactive . '</td>
                    <td align="right"> 
                    '. ($group->grouplevel <= "2" ? '&nbsp' : '<a class="btn btn-metis-3 btn-xs btn-circle btn-grad" href="#" title="Reset Password">
                            <i class="fa fa-key"></i>
                        </a>'
                    ) .'
                        <a class="btn btn-default btn-xs btn-circle btn-grad" href="#" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-xs btn-circle btn-grad" href="#" title="Delete">
                            <i class="fa fa-times"></i>
                        </a>
                    </td>
                </tr>
            ';
            ++$no;
        } 
        $numOfRow = $no;

        $tblfooter = '</tbody></table>';
        $this->data['numOfRow'] = $numOfRow;
        $this->data['tables'] = $tblheader . $tblcontent . $tblfooter;

        $this->greek_toolbar->add('add', 'user/add', 'Tambah');
        $this->greek_toolbar->add('activate', 'javascript:activateFromList();', 'Aktifkan');
        $this->greek_toolbar->add('deactivate', 'javascript:deactivateFromList();', 'Nonaktifkan');
        $this->greek_toolbar->add('delete', 'javascript:delFromList();', 'Hapus');
        $this->greek_toolbar->add('refresh', 'user', 'Refresh');
        $this->greek_toolbar->add('print', '#', 'Print');
        $this->greek_toolbar->add('excel', '#', 'Export to Excel');
        $this->greek_toolbar->add('pdf', '#', 'Export to PDF');
        $this->greek_toolbar->add('save', '#', 'simpan');
        $this->greek_toolbar->add('edit', '#', 'Edit');
        $this->data['toolbar'] = $this->greek_toolbar->to_string();
        
        $this->data['message'] = $this->greek_alert->message('Juaraaa!!!!');
        $this->_render('user/landing');

	}

	function cgi()
	{
		extract($_POST, EXTR_PREFIX_ALL, "post");

		switch ($post_action) {
			case 'add':
                $post_username = strtolower($post_username);
                $usernamehash = md5($post_username);
                $post_password = hash_password($post_password);

                $obj = $this->m_user->get_user($post_username);
                if (sizeof($obj) > 0) {
                    $message =  "Username tersebut sudah ada!";
                    redirect();
                }

                $greekuser = array(
                	'username' => $post_username,
                	'usernamehash' => $usernamehash,
                	'password' => $post_password,
                	'name' => $post_name,
                	'address' => $post_address,
                	'email' => $post_email,
                	'nope' => $post_nope,
                	'usergroupid' => $usergroupid
            	);

                if($this->m_user->Add($greekuser)) {
                    $message = "User berhasil ditambah!";
                } else {
                    $message = "User gagal ditambah!";
                }

                redirect('controllers/list');
				break;
			
			case 'edit':
                $usernamehash = md5($post_username);
                $greekuser = array(
                	'name' => $post_name,
                	'address' => $post_address,
                	'email' => $post_email,
                	'nope' => $post_nope,
                	'usergroupid' => $usergroupid
            	);

                $res = $this->m_user->Update($usernamehash, $greekuser);
                
                if ($res > 0) {
                    $message = "Data user berhasil diupdate!";
                } else {
                    $message = "Data user gagal diupdate!";
                }

                redirect('controller/list');
				break;

			case 'chpasswd':
				$res = $this->m_user->get_user(md5($post_username));

                if (check_password($post_oldpassword, $res->password)) {
                   	$greekuser = array(
                   		'password' => hash_password($post_password),
               		);

                    $resupd = $this->Update($res->user_id, $greekuser);
                }

                if ($resupd > 0) {
                    $message = "Data user berhasil diupdate!";
                } else {
                    $message = "Data user gagal diupdate!";
                }

                redirect('$controller/chpasswd');
				break;

			case 'setpasswd':
				// Masih bingung di case ini. :D
                $password = hash_password($post_password);
				break;
		}
	}

}