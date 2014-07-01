<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('auto_code'))
{
	function auto_code($tabel, $inisial)
	{
		// $CI =& get_instance();
		// $CI->load->database(); 

		// $sql = "select * from table"; 
		// $query = $CI->db->query($sql);
		// $row = $query->result();

		$struktur = mysql_query("SELECT * FROM $tabel");
		$field = mysql_field_name($struktur, 0);
		$panjang = mysql_field_len($struktur, 0);
		$query = mysql_query("SELECT max(".$field.") FROM ".$tabel);
		$row = mysql_fetch_array($query);
		
		if($row[0] == "") {
			$angka	= 0;
		}
		else {
			$angka	= substr($row[0], strlen($inisial));
		}
		
		++$angka;
		$angka = strval($angka);
		$tmp = "";
		
		for ($i = 1; $i <= ($panjang-strlen($inisial)-strlen($angka)); $i++) {
			$tmp	= $tmp."0";
		}
			
		return $inisial.$tmp.$angka;
	}
}

/* Location: application/helpers/MY_string_helper.php */
