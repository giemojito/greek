<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['site_title'] = 'App development by Greeking-solutions';
$config['site_description'] = 'App development by Greeking-solutions';
$config['site_author'] = 'greeking-solutions: @anjie, @revi, @sugih';
$config['site_keywords'] = 'SI, App, Application, Greeking-solutions';

$config['site_footerleft'] = 'copyright &copy; ' . date("Y") . ' | Greeking-solutions';
$config['site_footerright'] = 'Elapsed time : <strong>{elapsed_time}</strong> second Memory Usage : <strong>{memory_usage}</strong>';

/*
| -------------------------------------------------------------------
|  Initialize JS
| -------------------------------------------------------------------
| These are the js located in the assets js folder
|
| Initialize here
|
*/
$config["javascript"] = array('main.min');

/*
| -------------------------------------------------------------------
|  Initialize CSS
| -------------------------------------------------------------------
| These are the css located in the assets css folder
|
| Initialize here
|
*/
$config["css"] = array('main.min', 'theme');
$config["lib_css"] = array('bootstrap/css/bootstrap.min', 'Font-Awesome/css/font-awesome.min');

/*
| -------------------------------------------------------------------
|  Initialize Lib javascript
| -------------------------------------------------------------------
| These are the css located in the assets css folder
|
| Initialize here
|
*/
$config["lib"] = array('bootstrap/js/bootstrap.min', 'screenfull/screenfull');

/* End of file custom.php */
/* Location: ./application/config/development/custom.php */