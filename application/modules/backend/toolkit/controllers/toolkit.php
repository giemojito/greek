<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Toolkit extends Admin_Controller {
    
	public function __construct()
	{
		parent::__construct();
        $this->load->helper(array('security'));
		$this->load->model('m_toolkit');
	}

    function index()
    {
        $random = "greek" . substr(md5(uniqid("greeking", true)), 0, 5);
        echo $random;
    }

	public function genpasswd()
    {
        // get data greekuser where usergroupid > 1 because < 1 is level top admin :D
        $res = $this->m_toolkit->getdata();

        $upd = array();
        $buffer = "";
        foreach ($res as $item) {
            $random = "greek" . substr(md5(uniqid("greeking", true)), 0, 5);

            $passwd = hash_password($random);
            $upd[] = array($passwd, $item->userid);

            $buffer .= "$item->username,$random\n";
        }

        // $res = $db->queries($upd, "update greekuser set password = ? where userid = ?");

        $handle = fopen ("genuserpassword.csv", "w+");
        $res = fwrite ($handle, $buffer);
        fclose ($handle);

        echo "document.getElementById('restext').value = 'Process ok';";
    }
}