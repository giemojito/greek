<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('pdf_create')) {
    function pdf_create($html, $filename = '', $stream = 'TRUE', $paper = "letter", $orientation = "portrait")
    // function pdf_create($html, $filename='', $stream=TRUE) 
    {
        $CI =& get_instance();
        $CI->load->helper(array('file'));
        require_once("dompdf/dompdf_config.inc.php");

        if (get_magic_quotes_gpc()) {
            $html = stripslashes($html);
        }

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();

        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => false));
            
            $path = 'files/pdf/';
            $pdf = pdf_create($html, 'filename', false);
            write_file($path . $filename . PDF_EXT, $pdf);
        } else {
            return $dompdf->output();
            // $path = 'files/pdf/';
            // $pdf = $dompdf->output();
            // write_file($path . $filename . PDF_EXT, $pdf);
        }
    }
}

/* Location: application/helpers/pdf_helper.php */