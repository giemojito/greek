<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Object to Array
 *
 * @param	object
 * @return	array
**/
if ( ! function_exists('object_to_array')) {
	function object_to_array($object)
	{
		if ( ! is_object($object)) {
			return $object;
		}

		$array = array();
		foreach (get_object_vars($object) as $key => $val) {
			if ( ! is_object($val) && ! is_array($val)) {
				$array[$key] = $val;
			}
		}

		return $array;
	}
}


/**
 * Object to Array
 *
 * @param	object
 * @return	array
 */
if ( ! function_exists('object_to_array_batch')) {
	function object_to_array_batch($object)
	{
		if ( ! is_object($object)) {
			return $object;
		}

		$array = array();
		$out = get_object_vars($object);
		$fields = array_keys($out);

		foreach ($fields as $val) {
			$i = 0;
			foreach ($out[$val] as $data)
			{
				$array[$i][$val] = $data;
				$i++;
			}
		}

		return $array;
	}
}

/**
 * Array to Object
 *
 * @param	array
 * @return	object
**/
if ( ! function_exists('array_to_object')) {
	function array_to_object($array)
	{
		if ( ! is_array($array)) {
			return $array;
		}

		return (object) $array;
	}
}


/**
 * Array to Object
 *
 * @param	array
 * @return	object
 */
if ( ! function_exists('array_to_object_batch')) {
	function array_to_object_batch($array)
	{
		if ( ! is_array($array)) {
			return $array;
		}

		$i = 0;
		foreach ($a as $key => $value) {
			$array[$key] = $value;
			if (is_array($value)) {
				$array[$key] = (object) $value;
			}
			++$i;
		}

		return (object) $array;

	}
}

// function get_merged_result($ids) {
// 	$this->db->select("column");
// 	$this->db->distinct();
// 	$this->db->from("table_name");
// 	$this->db->where_in("id",$model_ids);
// 	$this->db->get();
// 	$query1 = $this->db->last_query();

// 	$this->db->select("column2 as column");
// 	$this->db->distinct();
// 	$this->db->from("table_name");
// 	$this->db->where_in("id",$model_ids);

// 	$this->db->get();
// 	$query2 =  $this->db->last_query();
// 	$query = $this->db->query($query1." UNION ".$query2);

// 	return $query->result();
// }