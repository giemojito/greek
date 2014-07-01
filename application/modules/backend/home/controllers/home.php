<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Admin_Controller {
    
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
      
      /*
       * Alert Message
       * Initial $this->greek_alert->message 
       * and paramter1 mesage, parameter2 TRUE(success)/FALSE(error)/WARNING(warning)/INFO(info)
       * example:
       * $this->greek_alert->message('Hope U see This message!!!!', 'FALSE');
      */
      
      // $this->data['message'] = $this->greek_alert->message('Hope U see This message!!!!', 'FALSE');
      $this->data['base64_encode'] = 'testinggg';
      $this->_render_parser('home/landing');
    }

      function alltoolbar()
      {
            $this->greek_toolbar->add('add', '#', 'Tambah');
            $this->greek_toolbar->add('activate', '#', 'Activate');
            $this->greek_toolbar->add('deactivate', '#', 'Deactivate');
            $this->greek_toolbar->add('cancel', '#', 'cancel');
            $this->greek_toolbar->add('delete', '#', 'Hapus');
            $this->greek_toolbar->add('print', '#', 'Print');
            $this->greek_toolbar->add('refresh', '#', 'Refresh');
            $this->greek_toolbar->add('pdf', '#', 'PDF');
            $this->greek_toolbar->add('excel', '#', 'excel');
            $this->greek_toolbar->add('save', '#', 'save');
            $this->greek_toolbar->add('edit', '#', 'edit');
            $this->greek_toolbar->add('find', '#', 'Search');
            $this->greek_toolbar->add('showall', '#', 'Show all');
            $this->greek_toolbar->add('sort', '#', 'Sort');
            $this->greek_toolbar->add('default', '#', 'default');
            $this->data['toolbar'] = $this->greek_toolbar->to_string();

            $this->_render('home/toolbar');
      }
}