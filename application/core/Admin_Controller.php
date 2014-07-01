<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends CI_Controller {
	
	// Page info
	protected $data = Array();
	protected $pageName = FALSE;
	protected $template = "main";
	protected $hasNav = TRUE;

	// Page contents
	protected $javascript = array();
	protected $libs = array();
	protected $css = array();
	protected $libcss = array();
	protected $fonts = array();

	// Page Meta
	protected $title = FALSE;
	protected $description = FALSE;
	protected $keywords = FALSE;
	protected $author = FALSE;
	protected $footerleft = FALSE;
	protected $footerright = FALSE;
	
	function __construct()
	{	
		parent::__construct();

		if ($this->session->userdata('islogin') == '' OR $this->session->userdata('islogin') == '6') {
			redirect('welcome');
		}

		// Page Meta
		$this->data["uri_segment_1"] = $this->uri->segment(1);
		$this->data["uri_segment_2"] = $this->uri->segment(2);
		$this->title = $this->config->item('site_title');
		$this->description = $this->config->item('site_description');
		$this->keywords = $this->config->item('site_keywords');
		$this->author = $this->config->item('site_author');
		$this->footerleft = $this->config->item('site_footerleft');
		$this->footerright = $this->config->item('site_footerright');
		
		// Page contents
		$this->javascript = $this->config->item('javascript');
		$this->libs = $this->config->item('lib');
		$this->css = $this->config->item('css');
		$this->libcss = $this->config->item('lib_css');
		
		// Page User Information
		$this->username = ucfirst($this->session->userdata('name'));
		$this->usergroup = $this->m_general->GetGroup($this->session->userdata('usergroupid'));
		$this->useravatar = $this->session->userdata('avatar') == '' ? 'default-avatar-'.$this->session->userdata('jk').'.png' : $this->session->userdata('avatar');
		$this->userlastlogin = date("d-F-Y H:i:s", $this->session->userdata('lastlogin'));

      	// $this->nav = $this->m_general->nav();
      	$this->nav = $this->greek_navbar->to_string();

		$this->pageName = strToLower(get_class($this));
	}
	
	protected function _render_parser($view, $renderData = "FULLPAGE")
	{
        switch (trim(strtoupper($renderData))) {
	        case "AJAX" :
	            $this->parser->parse($view, $this->data);
	        	break;
	        case 'BASE64':
	        	// compress_output is FALSE
	        		// echo base64_encode($this->data["base64_encode"]);
	        	// or content used compress_output is TRUE
	        	$this->output->set_output(base64_encode($this->data["base64_encode"]));
	        	break;
	        case 'IFRAME':
	        	# code...
	        	break;
	        case "JSON" :
	        	// compress_output is FALSE
	            	// echo json_encode($this->data);
	            // or content used compress_output is TRUE
	        	$this->output->set_output(json_encode($this->data));
	        	break;
	        case 'SERIALIZE':
	        	// compress_output is FALSE
	        		// echo serialize($this->data["serialize"]);
	        	// or content used compress_output is TRUE
	        	$this->output->set_output(serialize($this->data["serialize"]));
	        	break;
	        case "FULLPAGE" :
	        default :
				// static
				$toTpl["javascript"] = $this->multi_parser($this->_set_js(), 'javascript');
				$toTpl["libs"] = $this->multi_parser($this->_set_lib(), 'libs');
				$toTpl["css"] = $this->multi_parser($this->_set_css(), 'css');
				$toTpl["libcss"] = $this->multi_parser($this->_set_libcss(), 'libcss');
				$toTpl["fonts"] = $this->multi_parser($this->fonts, 'fonts');

				// meta
				$toTpl["title"] = $this->title;
				$toTpl["description"] = $this->description;
				$toTpl["keywords"] = $this->keywords;
				$toTpl["author"] = $this->author;

				// footer
				$toTpl["footerleft"] = $this->footerleft;
				$toTpl["footerright"] = $this->footerright;
				
				// data
				$toBody["content_body"] = $this->parser->parse($view, array_merge($this->data, $toTpl), true);
				
				// nav menu
				if ($this->hasNav) {
					$this->load->helper("nav");

					$toMenu["pageName"] = $this->pageName;
					$toMenu["username"] = $this->username;
					$toMenu["usergroup"] = ucfirst($this->usergroup->name);
					$toMenu["useravatar"] = $this->useravatar;
					$toMenu["userlastlogin"] = $this->userlastlogin;
					$toMenu["nav"] = $this->nav;

					$toHeader["nav"] = $this->parser->parse("greek/parser/nav", $toMenu, true);
				}

				$toHeader["basejs"] = $this->parser->parse("greek/parser/basejs", $this->data, true);
				
				$toBody["header"] = $this->parser->parse("greek/parser/header", $toHeader, true);
				$toBody["footer"] = $this->parser->parse("greek/parser/footer", $toTpl, true);

				// simpleModal
				$toBody['modal'] = $this->parser->parse("greek/parser/modal", $toTpl, true);
				
				$toTpl["body"] = $this->parser->parse("greek/parser/" . $this->template, $toBody, true);
				
				// render view
				// $this->parser->parse("greek/parser/default".HTM_EXT, $toTpl);
				$this->parser->parse("greek/parser/default", $toTpl);
				break;
	    }
	}

	protected function _render($view, $renderData = "FULLPAGE")
	{
        switch (trim(strtoupper($renderData))) {
	        case "AJAX" :
	            $this->load->view($view, $this->data);
	        	break;
	        case 'BASE64':
	        	// compress_output is FALSE
	        		// echo base64_encode($this->data["base64_encode"]);
	        	// or content used compress_output is TRUE
	        	$this->output->set_output(base64_encode($this->data["base64_encode"]));
	        	break;
	        case 'IFRAME':
	        	# code...
	        	break;
	        case "JSON" :
	        	// compress_output is FALSE
	            	// echo json_encode($this->data);
	            // or content used compress_output is TRUE
	        	$this->output->set_output(json_encode($this->data));
	        	break;
	        case 'SERIALIZE':
	        	// compress_output is FALSE
	        		// echo serialize($this->data["serialize"]);
	        	// or content used compress_output is TRUE
	        	$this->output->set_output(serialize($this->data["serialize"]));
	        	break;
	        case "FULLPAGE" :
	        default :
				// static
				$toTpl["javascript"] = $this->_set_js();
				$toTpl["libs"] = $this->_set_lib();
				$toTpl["css"] = $this->_set_css();
				$toTpl["libcss"] = $this->_set_libcss();
				$toTpl["fonts"] = $this->fonts;

				// meta
				$toTpl["title"] = $this->title;
				$toTpl["description"] = $this->description;
				$toTpl["keywords"] = $this->keywords;
				$toTpl["author"] = $this->author;

				// footer
				$toTpl["footerleft"] = $this->footerleft;
				$toTpl["footerright"] = $this->footerright;
				
				// data
				$toBody["content_body"] = $this->load->view($view, array_merge($this->data, $toTpl), true);
				
				// nav menu
				if ($this->hasNav) {
					$this->load->helper("nav");
					
					$toMenu["pageName"] = $this->pageName;
					$toMenu["username"] = $this->username;
					$toMenu["usergroup"] = ucfirst($this->usergroup->name);
					$toMenu["useravatar"] = $this->useravatar;
					$toMenu["userlastlogin"] = $this->userlastlogin;
					$toMenu["nav"] = $this->nav;

					$toHeader["nav"] = $this->load->view("greek/view/nav", $toMenu, true);
				}

				$toHeader["basejs"] = $this->load->view("greek/view/basejs", $this->data, true);
				
				$toBody["header"] = $this->load->view("greek/view/header", $toHeader, true);
				$toBody["footer"] = $this->load->view("greek/view/footer", '', true);

				// simpleModal
				$toBody['modal'] = $this->load->view("greek/view/modal", '', true);
				
				$toTpl["body"] = $this->load->view("greek/view/" . $this->template, $toBody, true);
				
				// render view
				// $this->load->view("greek/view/default".HTM_EXT, $toTpl);
				$this->load->view("greek/view/default", $toTpl);
				break;
	    }
	}

	function _set_css($css = null, $merge = 'FALSE')
	{
		if ( is_null($css) ) {
      		return $this->css;
		}

		if ($merge == 'TRUE') {
			return $this->css = array_merge($this->css, $css);
		}

		return $this->css = $css;
  	}

  	function _set_js($js = null, $merge = 'FALSE')
  	{
		if ( is_null($js) ) {
      		return $this->javascript;
		}

		if ($merge == 'TRUE') {
			return $this->javascript = array_merge($this->javascript, $js);
		}

		return $this->javascript = $js;
  	}

  	function _set_lib($lib = null, $merge = 'FALSE')
  	{
		if ( is_null($lib) ) {
      		return $this->libs;
		}

		if ($merge == 'TRUE') {
			return $this->libs = array_merge($this->libs, $lib);
		}

		return $this->libs = $lib;
  	}

  	function _set_libcss($libcss = null, $merge = 'FALSE')
  	{
		if ( is_null($libcss) ) {
      		return $this->libcss;
		}

		if ($merge == 'TRUE') {
			return $this->libcss = array_merge($this->libcss, $libcss);
		}

		return $this->libcss = $libcss;
  	}

  	function multi_parser($objA, $objB)
  	{
  		$arr = array();
  		foreach ($objA as $key => $value) {
  			$arr[$key][$objB] = $value;
  		}

  		return $arr;
  	}
}
