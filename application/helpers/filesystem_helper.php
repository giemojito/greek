<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('recursive_mkdir')) {
    function recursive_mkdir($path, $mode = 0777)
    {
        $dirs = explode(DIRECTORY_SEPARATOR , $path);
        $count = sizeof($dirs);
        $path = '.';
        for ($i = 0; $i < $count; ++$i) {
            $path .= DIRECTORY_SEPARATOR . $dirs[$i];
            if ( ! is_dir($path) && !mkdir($path, $mode)) {
                return false;
            }
        }
        
        return true;
    }
}

if ( ! function_exists('mkdirs')) {
    function mkdirs($dir, $mode = 0777, $recursive = true) {
        if (is_null($dir) || $dir === "" ) {
            return FALSE;
        }
        
        if (is_dir($dir) || $dir === "/" ) {
            return TRUE;
        }

        if (mkdirs(dirname($dir), $mode, $recursive)) {
            return mkdir('files/'.$dir, $mode);
        }

        return FALSE;
    }
}

if ( ! function_exists('rrmdir')) {
    function rrmdir($dir, $recursive = 'FALSE') {
        $res = glob($dir . '/*');
        $count = sizeof($res);

        if ($recursive == 'TRUE') {
            foreach ($res as $file) {
                if (is_dir($file)) {
                    rrmdir($file);
                }
                else {
                    unlink($file);
                }
            }

            $flag = rmdir($dir);
            $msg = $flag ? "Directory deleted" : "Error in deleting directory";
        }
        else {
            if ($count > 2) {
                $flag = false;
                $msg = "Directory is not empty";
            }
            else {
                $flag = rmdir($filename);
                $msg = $flag ? "Directory deleted" : "Error in deleting directory";
            }
        }

        return $msg;
    }
}

if ( ! function_exists('rglob')) {
    function rglob ($dir, $card = "*") {
        $data = array();
        $handle = opendir($dir);
        while ($file = readdir($handle)) {
            if ($card == "*") {
                array_push($data, $file);
            }
            else if (substr_count(strtolower($file), strtolower($card)) > 0) {
                array_push($data, $file);
            }
        }

        closedir($handle);
        
        return $data;
    }
}

/* Location: application/helpers/filesystem_helper.php */