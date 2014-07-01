<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_utilitas
 */
class M_utilitas extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->dbutil();
        $this->load->dbforge();
    }

    // Returns an array of database names:
    function show_dbs()
    {
        $dbs = $this->dbutil->list_databases();

        // foreach($dbs as $db)
        // {
        //     echo $db;
        // }

        return $dbs;
    }

    // Sometimes it's helpful to know whether a particular database exists.
    // Returns a boolean TRUE/FALSE. Usage example:
    function select_db($db)
    {
        if ($this->dbutil->database_exists($db))
        {
           // some code...
        }
    }

    // Permits you to optimize a table using the table name specified in the first parameter.
    // Returns TRUE/FALSE based on success or failure:
    function optimize_table($table)
    {
        if ($this->dbutil->optimize_table($table))
        {
            // echo 'Success!';
            return TRUE;
        }

        return FALSE;
    }

    // Permits you to repair a table using the table name specified in the first parameter.
    // Returns TRUE/FALSE based on success or failure:
    function repair_table($table)
    {
        if ($this->dbutil->repair_table($table))
        {
            // echo 'Success!';
            return TRUE;
        }

        return FALSE;
    }

    // Permits you to optimize the database your DB class is currently connected to.
    // Returns an array containing the DB status messages or FALSE on failure.
    function optimize_database($db)
    {
        $result = $this->dbutil->optimize_database();

        if ($result !== FALSE)
        {
            print_r($result);
        }
    }
    
    // Permits you to create the database specified in the first parameter.
    // Returns TRUE/FALSE based on success or failure:
    function create_db($db)
    {
        if ($this->dbforge->create_database($db))
        {
            // echo 'Database created!';
            return TRUE;
        }

        return FALSE;
    }

    // Permits you to drop the database specified in the first parameter.
    // Returns TRUE/FALSE based on success or failure:
    function drop_db($db)
    {
        if ($this->dbforge->drop_database($db))
        {
            // echo 'Database deleted!';
            return TRUE;
        }

        return FALSE;
    }

    // Executes a DROP TABLE sql
    // gives DROP TABLE or VIEWS IF EXISTS table_name
    function drop_table($table)
    {
        if($this->dbforge->drop_table($table))
        {
            return TRUE;
        }

        return FALSE;
    }

    // Executes a TABLE rename
    // gives ALTER TABLE oldtable RENAME TO newtable
    function rename_table($oldtable, $newtable)
    {
        if($this->dbforge->rename_table($oldtable, $newtable))
        {
            return TRUE;
        }

        return FALSE;
    }

}