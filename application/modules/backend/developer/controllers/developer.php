<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Developer extends Admin_Controller {
    
	public function __construct()
	{
		parent::__construct();
        $this->load->helper(array('date'));
	}

    /**
     * Display the system information, including Greek System and PHP versions,
     * to the user
     *
     * @access public
     *
     * @return void
     */
    public function sysinfo()
    {
        $this->_render('developer/sys_info');
    }


    /**
     * Display the list of modules in the Greek installation
     *
     * @access public
     *
     * @return void
     */
    public function modules()
    {
        $this->_render('developer/modules_info');
    }


    /**
     * Display the PHP info settings to the user
     *
     * @access public
     *
     * @return void
     */
    public function phpinfo()
    {
        ob_start();

        phpinfo();

        $buffer = ob_get_contents();

        ob_end_clean();

        $output = (preg_match("/<body.*?".">(.*)<\/body>/is", $buffer, $match)) ? $match['1'] : $buffer;
        $output = preg_replace("/<a href=\"http:\/\/www.php.net\/\">.*?<\/a>/", "", $output);
        $output = preg_replace("/<a href=\"http:\/\/www.zend.com\/\">.*?<\/a>/", "", $output);
        $output = preg_replace("/<h2 align=\"center\">PHP License<\/h2>.*?<\/table>/si", "", $output);
        $output = preg_replace("/<h2>PHP License.*?<\/table>/is", "", $output);
        $output = preg_replace("/<table(.*?)bgcolor=\".*?\">/", "\n\n<table\\1>", $output);
        $output = preg_replace("/<table(.*?)>/", "\n\n<table class=\"table table-striped\" style=\"table-layout: fixed;\">", $output);
        $output = preg_replace("/<a.*?<\/a>/", "", $output);
        $output = preg_replace("/<th(.*?)>/", "<th \\1 >", $output);
        $output = preg_replace("/<hr.*?>/", "<br />", $output);
        $output = preg_replace("/<tr(.*?).*?".">/", "<tr\\1>\n", $output);
        $output = preg_replace("/<td(.*?).*?".">/", "<td><div style=\"word-wrap: break-word; white-space:-moz-pre-wrap;\">\n", $output);
        $output = preg_replace('/<h(1|2)\s*(class="p")?/i', '<h\\1', $output);


        $this->data['phpinfo'] = $output;
        $this->_render('developer/php_info');
    }
    //end php_info()

}