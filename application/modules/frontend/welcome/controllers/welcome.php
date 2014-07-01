<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Frontend_Controller {
    
    public function index()
    {
      /*
       * leave it blank if used javascript, css, libcss and lib by default system
       * or
       * Initial javascript(_set_js), css(_set_css), libcss(_set_libcss) and lib(_set_lib) 
       * and paramter1 array, parameter2 merge TRUE/FALSE
       * if parameter2 is TRUE and then the ouput will merger between default and parsing
       * example:
       * $this->_set_libcss(array('bootstrap/css/bootstrap', 'magic/magic'), 'TRUE');
      */
      $this->_set_js(array('login'));
      $this->_set_libcss(array('bootstrap/css/bootstrap', 'magic/magic'), 'TRUE');
		  $this->_render('welcome/landing');
    }

    function pdf()
    {
      $this->load->helper(array('dompdf', 'file'));
      // http://localhost/greeking-solutions/home
      $obj = $this->_render('home/landing');
      $html = $this->output->get_output('$obj');
      pdf_create($html, 'filename');
      // or
      // if you want to write it to disk and/or send it as an attachment     
      $path = 'files/pdf/';
      $data = pdf_create($html, 'filename', false);
      write_file($path . 'filename' . PDF_EXT, $data);
    }

    function json()
    {
      $this->data["GLOB_MARK"] = GLOB_MARK;
      $this->_render('', "JSON");
    }

    function base64()
    {
      $this->data["base64_encode"] = GLOB_MARK;
      $this->_render('', "BASE64");
    }

    function serialize()
    {
      $this->data["serialize"] = GLOB_MARK;
      $this->_render('', "SERIALIZE");
    }

}