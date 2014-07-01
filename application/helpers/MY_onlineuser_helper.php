<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('visitors')) {
	function visitors($obj = '')
	{
		$CI =& get_instance();
		$CI->load->database();

		$CI->db->where('user_data ==', '');
		$CI->->count_all('ci_sessions');
        return $vars->result();
	}
}

/* End of file application/helpers/MY_onlineuser_helper.php */
