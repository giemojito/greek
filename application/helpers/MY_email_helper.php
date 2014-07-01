<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Send email menggunakan SMTP */
if (! function_exists('send_smtp')) {
    function send_smtp($to, $subject, $msg)
    {
        $CI =& get_instance();
        $CI->load->library(array('email'));

        $CI->email->from('anggie.if04@gmail.com', 'Mojito');
        $CI->email->to($to);
        // $CI->email->cc();
        // $CI->email->bcc();
        $CI->email->subject($subject);
        $CI->email->message($msg);

        if($CI->email->send()) {
            return 'Your email was sent, successfully.';
        }
        else {
            return $CI->email->print_debugger();
        }
    }
}

/* Send email menggunakan MAIL */
if (! function_exists('send_mail')) {
	function send_mail($to, $subject, $msg)
    {
        $CI =& get_instance();
        $CI->load->library(array('email'));

        $CI->email->from('anggie.if04@gmail.com', 'Mojito');
        $CI->email->to($to);
        // $CI->email->cc();
        // $CI->email->bcc();
        $CI->email->subject($subject);
        $CI->email->message($msg);

        if($CI->email->send()) {
            return 'Your email was sent, successfully.';
        }
        else {
            return $CI->email->print_debugger();
        }
    }
}

/* Send email menggunakan SENDMAIL */
if (! function_exists('send_sendmail')) {
	function send_sendmail($to, $subject, $msg)
    {
        $CI =& get_instance();
        $CI->load->library(array('email'));
    
        $CI->email->from('anggie.if04@gmail.com', 'Mojito');
        $CI->email->to($to);
        // $CI->email->cc();
        // $CI->email->bcc();
        $CI->email->subject($subject);
        $CI->email->message($msg);

        if($CI->email->send()) {
            return 'Your email was sent, successfully.';
        }
        else {
            return $CI->email->print_debugger();
        }
    }
}

/* End of file application/helpers/MY_email_helper.php */
