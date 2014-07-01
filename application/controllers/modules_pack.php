<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Modules_pack extends CI_Controller {
  //--------------------------------------------------------------------
  // Module Functions
  //--------------------------------------------------------------------

  function index()
  {
    echo 'hope u see this';
  }

  /**
   * Returns an array of the folders that modules are allowed to be stored in.
   * These are set in *bonfire/application/third_party/MX/Modules.php*.
   *
   * @return array The folders that modules are allowed to be stored in.
   */
  function module_folders()
  {
    return array_keys(modules::$locations);
  }

  /**
   * Returns a list of all modules in the system.
   *
   * @param bool $exclude_core Whether to exclude the Bonfire core modules or not
   *
   * @return array A list of all modules in the system.
   */
  function module_list($exclude_core = false)
  {
    $this->load->helper('directory');
    $map = array();


    foreach ($this->module_folders() as $folder)
    {
      // If we're excluding core modules and this module
      // is in the core modules folder... ignore it.
      // if ($exclude_core && strpos($folder, 'bonfire/modules') !== false) {
      //   continue;
      // }

      $dirs = directory_map($folder, 1);
      
      if ( ! is_array($dirs)) {
        $dirs = array();
      }

      $map = array_merge($map, $dirs);
    }
    
    // Clean out any html or php files
    if ($count = sizeof($map)) {
      for ($i = 0; $i < $count; $i++) {
        if (strpos($map[$i], '.html') !== false || strpos($map[$i], '.php') !== false) {
          unset($map[$i]);
        }
      }
    }

    return $map;
  }

  /**
   * Returns the 'module_config' array from a modules config/config.php
   * file. The 'module_config' contains more information about a module,
   * and even provide enhanced features within the UI. All fields are optional
   *
   * @author Liam Rutherford (http://www.liamr.com)
   *
   * <code>
   * $config['module_config'] = array(
   *  'name'      => 'Blog',      // The name that is displayed in the UI
   *  'description' => 'Simple Blog', // May appear at various places within the UI
   *  'author'    => 'Your Name',   // The name of the module's author
   *  'homepage'    => 'http://...',  // The module's home on the web
   *  'version'   => '1.0.1',     // Currently installed version
   *  'menu'      => array(     // A view file containing an <ul> that will be the sub-menu in the main nav.
   *    'context' => 'path/to/view'
   *  )
   * );
   * </code>
   *
   * @param $module_name string The name of the module.
   * @param $return_full boolean If true, will return the entire config array. If false, will return only the 'module_config' portion.
   *
   * @return array An array of config settings, or an empty array if empty/not found.
   */
  function module_config($module_name = null, $return_full = false)
  {
    $config_param = array();

    $config_file = $this->module_file_path($module_name, 'config', 'config.php');

    if (file_exists($config_file)) {
      include($config_file);

      /* Check for the optional module_config and serialize if exists*/
      if (isset($config['module_config'])) {
        $config_param = $config['module_config'];
      }
      else if ($return_full === true && isset($config) && is_array($config)) {
        $config_param = $config;
      }
    }

    return $config_param;
  }

  /**
   * Finds the path to a module's file.
   *
   * @param $module string The name of the module to find.
   * @param $folder string The folder within the module to search for the file (ie. controllers).
   * @param $file string The name of the file to search for.
   *
   * @return string The full path to the file.
   */
  function module_file_path($module = null, $folder = null, $file = null)
  {
    if (empty($module) || empty($folder) || empty($file)) {
      return false;
    }

    foreach ($this->module_folders() as $module_folder) {
      $test_file = $module_folder . $module .'/'. $folder .'/'. $file;

      if (is_file($test_file)) {
        return $test_file;
      }
    }
  }

  
  /**
   * Display the list of modules in the Bonfire installation
   *
   * @access public
   *
   * @return void
   */
  public function modules()
  {
    $modules = $this->module_list();
    $configs = array();

    foreach ($modules as $module)
    {
      $configs[$module] = $this->module_config($module);

      if (!isset($configs[$module]['name']))
      {
        $configs[$module]['name'] = ucwords($module);
      }
    }

    ksort($configs);
    die('<pre>'.print_r($configs,1).'</pre>');
    Template::set('modules', $configs);

    Template::render();

  }

}

