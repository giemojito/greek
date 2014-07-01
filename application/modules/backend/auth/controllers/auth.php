<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_auth'));
		$this->load->helper(array('string', 'security', 'email'));
		$this->load->library('user_agent');
	}

	public function login()
	{
		extract($_POST, EXTR_PREFIX_ALL, "post");

		if ($this->agent->is_browser()) {
		    $agent = $this->agent->browser() . ' ' . $this->agent->version();
		}
		elseif ($this->agent->is_robot()) {
		    $agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile()) {
		    $agent = $this->agent->mobile();
		}
		else {
		    $agent = 'Uh-oh! Neither Alien variable was set.';
		}

        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
           $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif(!empty($_SERVER['REMOTE_ADDR'])) {
           $ip = $_SERVER['REMOTE_ADDR'];
        }
        else {
           $ip = "Uh-oh! Neither IP variable was set.";
        }

	 	$post_password = hash_password($post_password);
		$valid = $this->m_auth->validasi($post_username, $post_password);

		if ($valid) {
            $now = time();
            $session_id = $this->session->userdata('session_id');
            $obj = array(
            	'islogin' => '7',
            	'lastlogin' => $now,
            	'sessionid' => $session_id
        	);
            $this->m_auth->UpdateDataUser($post_username, $obj);

			$userdata = $this->m_auth->getDataUser($post_username);

			unset($userdata->password);
            unset($userdata->usernamehash);

            $this->session->set_userdata($userdata);

			redirect('home');
		} else {
			$this->session->set_flashdata('msg','Username / Password salah!');
			redirect('welcome');
		}
	}

	function destroy()
	{
		$session_id = $this->session->userdata('session_id');
		$username = $this->session->userdata('username');

		$obj = array(
			'islogin' => '6',
        	'sessionid' => ''
    	);

        $this->m_auth->UpdateDataUser($username, $obj);
		
		$this->session->unset_userdata($session_id);
		$this->session->sess_destroy();
		redirect('welcome');
	}

	function switch_login()
	{
		$username = $this->session->userdata('username');
		$userdata = $this->m_auth->getDataUser($username);

		$gid = $userdata->usergroupid;
		$myname = $userdata->username;
        $username = $_GET["username"];

        if (($gid == "1" || $myname == "admin") && $username != "greek") {
        	$res = $this->m_auth->getDataUser($username);
        	if ($res) {
        		$this->session->sess_destroy();
        		
        		$userdata = $this->m_auth->getDataUser($username);

				unset($userdata->password);
            	unset($userdata->usernamehash);

           		$this->session->set_userdata($userdata);

				redirect('home');
        	}
        }
		else {
			redirect('home');
		}
    }

    function userdata()
    {
    	echo '<pre>';
    	$this->output->set_output($this->session->userdata('islogin'));
    	exit();
    }

}

/* End of file */