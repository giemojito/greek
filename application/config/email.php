<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
| -------------------------------------------------------------------
| EMAIL CONFIG
| -------------------------------------------------------------------
| Email Preferences
*/

/* Config initialize dari objek email menggunakan SMTP */
$config['useragent'] = 'Monev';
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_user'] = '';
$config['smtp_pass'] = '';
$config['smtp_port'] = 465;
$config['wordwrap'] = TRUE;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['priority'] = 1;
$config['newline'] = "\r\n";

/* Config initialize dari objek email menggunakan MAIL */
/*
$config['useragent'] = 'Monev';
$config['protocol'] = 'mail';
$config['mailpath'] = '/usr/sbin/sendmail';
$config['wordwrap'] = TRUE;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['priority'] = 1;
$config['newline'] = "\r\n";
*/

/* Config initialize dari objek email menggunakan SENDMAIL */
/*
$config['useragent'] = 'Monev';
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$config['wordwrap'] = TRUE;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['priority'] = 1;
$config['newline'] = "\r\n";
*/

/* End of file email.php */ 
/* Location: ./application/config/email.php */