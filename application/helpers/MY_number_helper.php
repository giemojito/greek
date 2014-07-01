<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * My numbers Helpers
 *
 * @package     String
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Anggie Septian ^_^ @greeking-solutions
 * @link        ----------
 */

/**
 * Formats a numbers
 *
 * @access	public
 * @param	mixed	// will be cast as int
 * @return	string
 */
if ( ! function_exists('number_format'))
{
	function number_format($num) {
        return number_format($num, 0, ',', '.');
	}
}

/* Location: application/helpers/MY_number_helper.php */
