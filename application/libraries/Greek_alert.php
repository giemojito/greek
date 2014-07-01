<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Greeking Greek Alert Html
 *
 * This class enables the creation alert flash message
 * 
 * @package     Greeking HTML
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Anggie Septian ^_^ @greeking-solutions
 * @email       anggie.if04@gmail.com
**/ 
 
class Greek_Alert {

    var $CI;

    public function __construct($config = array())
    {
        $this->CI =& get_instance();
        $this->CI->load->library(array('session'));
    }

    public function message($msg, $flag = null)
    {
        $data = array('message' => $msg, 'flag' => strtoupper($flag));
        $this->CI->session->set_flashdata($data);

        // Bug Fixed
        // return $this->_get();
        $this->_get();
    }


    public function _get() {
        $message = $this->CI->session->flashdata('message');
        $flag = $this->CI->session->flashdata('flag');
        if ($message == "") {
            return "";
        }
        
        if ($flag == "TRUE") {
            $class = 'alert-success';
            $message = "<strong>MESSAGE!!</strong><br/>" . $message;
        }
        else if ($flag === "FALSE") {
            $class = 'alert-danger';
            $message = "<strong>ERROR!!</strong><br/>" . $message;
        }
        else if ($flag == "WARNING") {
            $class = 'alert-warning';
            $message = "<strong>WARNING!!</strong><br/>" . $message;
        }
        else {
            $class = 'alert-info';
            $message = "<strong>INFO!!</strong><br/>" . $message;
        }
        
        // $buffer = "
        //     <script language='javascript' type='text/javascript'>
        //         setTimeout(function() {
        //             document.getElementById('messageLayer__').innerHTML = '<div class=\'alert $class\' id=\'messageLayer\' style=\'visibility: visible;\'><button class=\'close\' data-dismiss=\'alert\' type=\'button\'>×</button>$message</div>';
        //         },1000);

        //         setTimeout(function() {document.getElementById('messageLayer').style.display = 'none';},10000);
        //     </script>
        // ";

        $buffer = "
            <div class='alert $class' id='messageLayer' style='visibility: visible;'>
                <button class='close' data-dismiss='alert' type='button'>×</button>
                $message
            </div>

            <script language='javascript' type='text/javascript'>
                setTimeout(function() {document.getElementById('messageLayer').style.display = 'none';},10000);
            </script>
        ";

        // return $buffer;
        $this->CI->session->set_flashdata('alert', $buffer);
    }

    public function to_string()
    {
        return $this->_get();
    }

    public function to_print()
    {
        echo $this->_get();
    }

    public function flash($msg, $flag = null) {
        if ($msg == "") {
            return "";
        }
        
        if ($flag == "TRUE") {
            $class = 'alert-success';
            $message = "<strong>MESSAGE!!</strong><br/>" . $msg;
        }
        else if ($flag === "FALSE") {
            $class = 'alert-danger';
            $message = "<strong>ERROR!!</strong><br/>" . $msg;
        }
        else if ($flag == "WARNING") {
            $class = 'alert-warning';
            $message = "<strong>WARNING!!</strong><br/>" . $msg;
        }
        else {
            $class = 'alert-info';
            $message = "<strong>INFO!!</strong><br/>" . $msg;
        }

        $buffer = "
            <div class='alert $class' id='messageLayer' style='visibility: visible;'>
                <button class='close' data-dismiss='alert' type='button'>×</button>
                $message
            </div>

            <script language='javascript' type='text/javascript'>
                setTimeout(function() {document.getElementById('messageLayer').style.display = 'none';},20000);
            </script>
        ";

        $this->CI->session->set_flashdata('alert', $buffer);
    }

}

