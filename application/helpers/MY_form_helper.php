<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('_crtDropdown'))
{
	function _crtDropdown($obj, $name, $selected = '', $js = '', $class_style = 'form-control', $all = TRUE)
	{
        $buffer = "<select " . ($class_style == "" ? "" : "class=\"$class_style\"") . " name=\"$name\" id=\"$name\" " . ($js == "" ? "" : $js) . ">";
        if ($all) $buffer .= "<option value=\"\" selected > </option>";
		
        foreach ($obj as $row)
		{
            $buffer .= "<option value=\"" . $row['fullcode'] . "\"";
			if ($row['fullcode'] == $selected) $buffer .= " selected ";
            $buffer .= " >" . $row['nama'] . "</option>";
        }

        $buffer .= "</select>";

		return $buffer;
    }
}

/* Location: application/helpers/MY_form_helper.php */
