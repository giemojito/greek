<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * My Mcrypt Helpers
 *
 * @package     String
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Anggie Septian ^_^ @greeking-solutions
 * @link        ----------
 */

/**
 * Encrypt
 *
 * @access  public
 * @param   string
 * @param   string
 * @param   bool
 * @return  string
 */
if (! function_exists('encrypt')) {
    function encrypt( $msg, $k, $base64 = false, $iv = '»^{Ë’ÒšÎC•—´6°™FR«IËþÍ &ÞÐQ/§x`')
    {
        if ( ! $td = mcrypt_module_open('rijndael-256', '', 'cbc', ''))
            return false;
 
        $msg = serialize($msg);

        if ( mcrypt_generic_init($td, $k, $iv) !== 0 )
            return false;
 
        $msg = mcrypt_generic($td, $msg);
        $msg = $iv . $msg;
        $mac = pbkdf2($msg, $k, 1000, 32);
        $msg .= $mac;
 
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
 
        if ( $base64 ) $msg = base64_encode($msg);
 
        return $msg;
    }  
}

/**
 * Pbkdf2
 *
 * @access  public
 * @param   array
 * @return  string
 */
if (! function_exists('pbkdf2')) {
    function pbkdf2( $p, $s, $c, $kl, $a = 'sha256')
    {
        // Hash length
        $hl = strlen(hash($a, null, true));

        // Key blocks to compute
        $kb = ceil($kl / $hl);
        
        // Derived key
        $dk = '';
        
        // Create key
        for ($block = 1; $block <= $kb; $block ++) {
            // Initial hash for this block
            $ib = $b = hash_hmac($a, $s . pack('N', $block), $p, true);
 
            // Perform block iterations
            for ($i = 1; $i < $c; $i ++) {
                // XOR each iterate
                $ib ^= ($b = hash_hmac($a, $b, $p, true));
            }
 
            // Append iterated block
            $dk .= $ib;
        }
 
        // Return derived key of correct length
        return substr($dk, 0, $kl);
    }
}

/**
 * hash_password
 *
 * @access  public
 * @param   string
 * @return  string
 */
if ( ! function_exists('hash_password')) {
    function hash_password($str, $type = 'sha1', $salt = NULL) {
        $salt = (is_null($salt)) ? find_salt() : $salt;

        if ($type == 'sha1') {
            return sha1($salt.$str);
        }

        if ($type == 'md5') {
            return md5($salt.$str);
        }

        if ($type == 'crypt') {
            return crypt($str, '$2y$08$'.$salt.'$');
        }
    }
}

/**
* Finds the salt from a config
*
* @param   string  hashed password
* @return  string
*/
if ( ! function_exists('find_salt')) {
    function find_salt() {
        $CI = & get_instance();
        $salt = $CI->config->item('encryption_key');

        return base64_encode($salt);
    }
}

if ( ! function_exists('check_password')) {
    function check_password($input_password, $store_password) {
        if (empty($input_password)) {
            return false;
        }

        if (is_string($input_password)) {
            $salt = find_salt();
            $password = hash_password($input_password, '', $salt);
            
            // compare it
            if ($password === $store_password) {
                return true;
            }
        }
        
        return false;
    }
}

/* End of file application/helpers/MY_security_helper.php */
