<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('call_service')) {
	function call_service($url, $parameter) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);

        $fields_string = "";
        if (is_array($parameter)) foreach($parameter as $key => $value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string,'&');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);

        $curl_response = curl_exec($curl);
        curl_close($curl);
        return $curl_response;
    }
}

if ( ! function_exists('cUrl')) {
	function cUrl($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PROXY, 'cache3.itb.ac.id:8080');
		$result = curl_exec($ch);
		$content = json_decode($result, true);
		
		if ($content == false) {
			$content = "ERR REQUETS TO SERVER";
		}

		return $content;
	}
}

// output : images folder path
if ( ! function_exists('IMG')) {
	function IMG($obj = '')
	{
		return BASEURL() . "assets/images/" . $obj;
	}
}

// output : css folder path
if ( ! function_exists('CSS')) {
	function CSS($obj = '')
	{
		return BASEURL() . "assets/css/" . $obj;
	}
}

// output : javascript folder path
if ( ! function_exists('JS')) {
	function JS($obj = '')
	{
		return BASEURL() . "assets/js/" . $obj;
	}
}

// output : libraries folder path
if ( ! function_exists('LIB')) {
	function LIB($obj = '')
	{
		return BASEURL() . "application/libraries/" . $obj;
	}
}

// output : libraries folder path
if ( ! function_exists('FILESS')) {
	function FILESS($obj = '')
	{
		return BASEURL() . "files/" . $obj . "/";
	}
}

// output : base_url
if ( ! function_exists('BASEURL')) {
	function BASEURL()
	{
		$CI =& get_instance();
		return base_url();
	}
}

/* End of file application/helpers/MY_security_helper.php */
