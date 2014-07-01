<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap extends Admin_Controller {
    
    public function index()
    {
      /* all this content used output compression for faster page load 
       * so if you echo variable u will getting a blank page or error content encoding
       * Do not 'echo' but
       * used $this->output->set_output('value');
       * example: $var = 'hope you see this';
       * $this->output->set_output($var);
       * 
       * @greeking-solutions
      */
      
      /*
       * leave it blank if used javascript, css, libcss and lib by default system
       * or
       * Initial javascript(_set_js), css(_set_css), libcss(_set_libcss) and lib(_set_lib) 
       * and paramter1 array, parameter2 merge TRUE/FALSE
       * if parameter2 is TRUE and then the ouput will merger between default and parsing
       * example:
       * $this->_set_libcss(array('bootstrap/css/bootstrap', 'magic/magic'), 'TRUE');
      */

      $this->_render('rekap/landing');
    }

}