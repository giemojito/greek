<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * insert logged system
 * @objA parsing data
 * @objB action ( 'add', 'delete', 'update', 'cek' )
 * @objC table
 * @objD description (opsional)
 * @access public
 */
if ( ! function_exists('logged')) {
    function logged($objA, $objB, $objC = 'master', $objD)
    {
        $CI =& get_instance();
        $CI->load->library(array('user_agent'));
        $CI->load->database();
        
        if ($CI->agent->is_browser()) {
            $agent = $CI->agent->browser() . ' ' . $CI->agent->version();
        }
        elseif ($CI->agent->is_robot()) {
            $agent = $CI->agent->robot();
        }
        elseif ($CI->agent->is_mobile()) {
            $agent = $CI->agent->mobile();
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

        // build your data array here
        $arr = array(
             'username' => '',
             'name' => '',
             'email' => '',
             'lastlogin' => date('Y-m-d H:i:s'),
             'host' => $ip,
             'useragentbrowser' => $agent,
             'useragentplatform' => $CI->agent->platform()
        );

        $data = array_merge($objA, $arr);

        return $CI->db->insert('prefix' . $objD, $data);
    }

}

/* Location: application/helpers/loggedsystem_helper.php */