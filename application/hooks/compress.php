<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function compress()
{
  $CI =& get_instance();
  $buffer = $CI->output->get_output();
 
  $search = array(
    // replace end of line by a space
    '/\n/',
    // strip whitespaces after tags, except space
    '/\>[^\S ]+/s',
    // strip whitespaces before tags, except space
    '/[^\S ]+\</s',
    // shorten multiple whitespace sequences
    '/(\s)+/s'
  );
 
  $replace = array(
    ' ',
    '>',
    '<',
    '\\1'
  );

  $buffer = preg_replace($search, $replace, $buffer);

  $CI->output->set_output($buffer);
  $CI->output->_display();
}