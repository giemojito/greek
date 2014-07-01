<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Databases extends Admin_Controller {

    /**
     * Path to the backups
     *
     * @access private
     *
     * @var string
     */
    private $backup_folder  = 'db/backups/';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('number', 'file'));
        $this->load->helper('language');
        $this->lang->load('developer');
        $this->backup_folder = APPPATH . $this->backup_folder;
    }
    
    public function index()
    {
        $tblheader = '
            <form name="theForm" id="theForm" method="post" action="databases/cgi">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            <input class="check-all" type="checkbox">
                        </th>
                        <th>Table Name</th>
                        <th># Records</th>
                        <th>Data Size</th>
                        <th>Index Size</th>
                        <th>Data Free</th>
                        <th>Engine</th>
                    </tr>
                </thead>
                <tbody>
        ';
        
        $tblcontent = '';
        foreach ($this->db->query('SHOW TABLE STATUS')->result() as $table) {
            $tblcontent .= '
                <tr>
                    <td class="column-check">
                        <input type="checkbox" class="checked[]" value="'.$table->Name.'" name="checked[]">
                    </td>
                    <td><a href="'.base_url('developer').'/databases/browse/'.$table->Name.'">' . $table->Name . '</a></td>
                    <td>' . $table->Rows . '</td>
                    <td>' . byte_format($table->Data_length) . '</td>
                    <td>' . byte_format($table->Index_length) . '</td>
                    <td>' . byte_format($table->Data_free) . '</td>
                    <td>' . $table->Engine . '</td>
                </tr>
            ';
        } 
        $tblfooter = '</tbody></table>
        <div id="div-1" class="body">
            <div class="form-group">
                <label class="control-label col-lg-2">With selected : </label>
                <div class="col-lg-2">
                    <select name="action" class="form-control">
                        <option value="backup">'.lang('db_backup').'</option>
                        <option value="repair">'.lang('db_repair').'</option>
                        <option value="optimize">'.lang('db_optimize').'</option>
                        <option>------</option>
                        <option value="drop">'.lang('db_drop').'</option>
                    </select>
                </div>
                <input type="submit" value="'.lang('db_apply').'" class="btn btn-primary" />
            </div>
        </div>
        </form>';

        $this->data['tables'] = $tblheader . $tblcontent . $tblfooter;

        $this->_render('developer/databases');
    }

    /**
     * Browse the DB tables
     *
     * @access public
     *
     * @param string $table Name of the table to browse
     *
     * @return void
    **/
    public function browse($table = '')
    {
        $this->data['tables'] = $this->db->get($table)->result();
        $this->data['query'] = $this->db->last_query();

        $this->_render('developer/browse');
    }

    /**
     * List the existing backups
     *
     * @access public
     *
     * @return void
     */
    public function backups()
    {
        // Get a list of existing backup files
        $this->data['backups'] = get_dir_file_info($this->backup_folder);
        if (isset($_POST['delete'])) {
            $checked = $this->input->post('checked');

            // Make sure we have something to delete
            if (is_array($checked) && count($checked) > 0) {
                // Delete the files.
                foreach ($checked as $file) {
                    unlink($this->backup_folder . $file) or die("can't delete file");
                }

                // Tell them it was good.
                $message = sizeof($checked) . ' backup files were deleted.';
                $flag = 'TRUE';
            }
            else {
                $message = 'No backup files were selected for deletion';
                $flag = 'INFO';
            }
            
            $this->greek_alert->flash($message, $flag);
            $this->greek_alert->flash($message, $flag);
            redirect('developer/databases/backups');
        }
        else {
            $this->_render('developer/backups');
        }
    }

    /**
     * Do a force download on a backup file.
     *
     * @access public
     *
     * @param string $filename Name of the file to download
     *
     * @return void
     */
    public function get_backup($filename = null)
    {
        // CSRF could try `../../dev/temperamental-special-file` or `COM1`
        // and we'd really rather exclude the possibility of that happening anyway.
        if (preg_match('{[\\/]}', $filename) || ! fnmatch('*.*', $filename)) {
            $this->security->csrf_show_error();
        }

        $this->load->helper('download');

        if (file_exists($this->backup_folder . $filename)) {
            $data = file_get_contents($this->backup_folder . $filename);
            force_download($filename, $data);

            redirect('/database/backups');
        }
        else {
            // File doesn't exist
            // Template::set_message($filename . ' could not be found.', 'error');
            redirect('/developer/database/backups');
        }
    }

    /**
     * Perform a restore from a database backup.
     *
     * @access public
     *
     * @param string $filename Name of the file to restore
     *
     * @return void
     */
    public function restore($filename = null)
    {
        if (isset($_POST['restore']) && ! empty($filename)) {
            // Load the file from disk.
            $this->load->helper('file');
            $file = file($this->backup_folder . $filename);

            $retval = '';
            $templine = '';

            if (!empty($file)) {
                // Loop through each line
                foreach ($file as $line) {
                    // Skip it if it's a comment
                    if (substr(trim($line), 0, 1) != '#' || substr($line, 0 ,1) != '') {
                        // Add this line to the current segment
                        $templine .= $line;

                        // If it has a semicolon at the end, it's the end of a query.
                        if (substr(trim($line), -1, 1) == ';') {
                            // Perform the query...
                            if($this->db->query($templine)) {
                                // Query Success
                                $retval .= "<pre><strong style='color: green;'>Successfull Query</strong>: <span class='small'>$templine</span><br/></pre>";

                                // so reset our templine so we can start a new one
                                $templine = '';
                            }
                            else {
                                $retval .= "<strong style='color:red'>Unsuccessful Query:</strong> $templine<br/><br/>";
                                $templine = '';
                            }
                        }
                    }
                }

                // Tell the results
                $this->data['results'] = $retval;
            }
            else
            {
                // Couldn't read from file.
                // Template::set_message('Could not read the file: /application/db/backups/' . $filename . '.', 'error');
                // redirect(SITE_AREA .'/developer/database/backups');
            }
        }

        $this->data['filename'] = $filename;
        $this->_render('developer/restore');
    }

    function cgi()
    {
        extract($_POST, EXTR_PREFIX_ALL, "post");

        switch ($post_action) {
            case 'backup':
                $hide_form = $this->backup($post_checked);
                break;
            case 'repair':
                $this->repair($post_checked);
                break;
            case 'optimize':
                $this->optimize();
                break;
            case 'drop':
                $hide_form = $this->drop($post_checked);
                break;
        }
    }

    /**
     * Performs the actual backup.
     *
     * @access public
     *
     * @param array $tables Array of tables
     *
     * @return bool
    **/
    public function backup($tables = null)
    {
        extract($_POST, EXTR_PREFIX_ALL, "post");

        // Show the form
        if (! empty($tables) && is_array($tables) && sizeof($tables) > 0) {
            $this->data['tables'] = $tables;
            $this->data['file'] = 'Backup_' . date('Y-m-j_His');
        }
        else if (isset($post_backup)) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('file_name', 'lang:db_filename', 'required|trim|max_length[220]');
            $this->form_validation->set_rules('drop_tables', 'lang:db_drop_tables', 'required|trim|one_of[0,1]');
            $this->form_validation->set_rules('add_inserts', 'lang:db_add_inserts', 'required|trim|one_of[0,1]');
            $this->form_validation->set_rules('file_type', 'lang:db_compress_type', 'required|trim|one_of[txt,gzip,zip]');
            $this->form_validation->set_rules('tables', 'lang:db_tables', 'required|is_array');

            if ($this->form_validation->run() !== FALSE) {
                // Do the backup.
                $this->load->dbutil();

                $add_drop = ($post_drop_tables == '1');
                $add_insert = ($post_add_inserts == '1');

                $extension = $post_file_type;
                
                if ($extension == 'gzip') {
                    $extension = 'gz';
                }

                $basename = $post_file_name . '.' . $extension;
                $filename = $this->backup_folder . $basename;

                $prefs = array(
                    'tables'        => $post_tables,
                    'format'        => $post_file_type,
                    'filename'      => $filename,
                    'add_drop'      => $add_drop,
                    'add_insert'    => $add_insert
                );

                $backup =& $this->dbutil->backup($prefs);
                write_file($filename, $backup);

                if (file_exists($filename)) {
                    $this->greek_alert->flash('Backup file successfully saved. It can be found at <a href="'. html_escape(site_url('/developer/databases/get_backup/' .  $basename)) .'">'. html_escape($filename) .'</a>.', 'TRUE');
                }
                else {
                    $this->greek_alert->flash('There was a problem saving the backup file.', 'FALSE');
                }

                redirect('/developer/databases');
            }
            else {
                $this->data['tables'] = $post_tables;
                $this->greek_alert->flash('There was a problem saving the backup file.', 'FALSE');
            }
        }
        // end if

        $this->data['toolbar_title'] = 'Create New Backup';
        $this->_render('developer/backup');
    }
    // end backup()

    /**
     * Repairs database tables.
     *
     * @access private
     *
     * @param array $tables Array of tables to repair
     *
     * @return mixed
    **/
    private function repair($tables=null)
    {
        if (is_array($tables)) {
            $count = count($tables);
            $failed = 0;

            $this->load->dbutil();

            foreach ($tables as $table) {
                if (!$this->dbutil->repair_table($table)) {
                    $failed += 1;
                }
            }

            // Tell them the results
            $flag = $failed == 0 ? 'TRUE' : 'FALSE';
            $this->greek_alert->flash(($count - $failed) .' of '. $count .' tables were successfully repaired.', $flag);
            redirect('/developer/databases');
        }
        else {
            $this->greek_alert->flash('No tables were selected to repair', 'FALSE');
            redirect('/developer/databases');
        }
        // end if

        return;
    }
    // end repair()

    /**
     * Optimize the entire database
     *
     * @access private
     *
     * @return void
    **/
    private function optimize()
    {
        $this->load->dbutil();

        $result = $this->dbutil->optimize_database();

        if ($result == FALSE) {
            $this->greek_alert->flash('alert::Unable to optimize the database.', 'FALSE');
        }
        else {
            $this->greek_alert->flash('success::The database was successfully optimized.', 'TRUE');
        }

        redirect('/developer/databases', 'location');
    }
    // end optimize()

    /**
     * Drop database tables.
     *
     * @access public
     *
     * @param array $tables Array of table to drop
     *
     * @return bool
    **/
    public function drop($tables = null)
    {
        extract($_POST, EXTR_PREFIX_ALL, "post");

        if ( ! empty($tables)) {
            // Show our verification screen.
            $this->data['tables'] = $tables;
            $this->_render('developer/drop');
        }
        else if (isset($post_tables) && is_array($post_tables)) {
            // Actually delete the tables....
            $this->load->dbforge();

            foreach ($post_tables as $table) {
                // dbforge automatically adds the prefix, so we need to remove it.
                $prefix = $this->db->dbprefix;

                if (strncmp($table, $prefix, strlen($prefix)) === 0) {
                    $table = substr($table, strlen($prefix));
                    @$this->dbforge->drop_table($table);
                }
            }

            $grammar = sizeof($post_tables == 1) ? ' table' : ' tables';
            $this->greek_alert->flash(sizeof($post_tables) . ' ' . $grammar . ' successfully dropped.', 'TRUE');
            redirect('/developer/databases');
        }
        else {
            $this->greek_alert->flash('No tables were selected to drop', 'FALSE');
            redirect('/developer/databases');
        }
    }
    // end drop()
}