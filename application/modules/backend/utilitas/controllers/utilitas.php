<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utilitas extends Admin_Controller {
    
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_utilitas');
	}

	public function backup_db()
   	{
		/* Store All Table name in an Array */
		$return = "";
		$allTables = array();
		$result = mysql_query('SHOW TABLES');

		while($row = mysql_fetch_row($result))
		{
			$allTables[] = $row[0];
		}
		die('<pre>'.print_r(get_instance()->db->database,1).'</pre>');

		foreach($allTables as $table) {
			$result = mysql_query('SELECT * FROM ' . $table);

			$num_fields = mysql_num_fields($result);

			$return.= 'DROP TABLE IF EXISTS ' . $table . ';';

			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));

			$return .= "\n\n" . $row2[1] . ";\n\n";

			for ($i = 0; $i < $num_fields; $i++) {
				while($row = mysql_fetch_row($result))
				{
					$return .= 'INSERT INTO ' . $table . ' VALUES(';
					for($j = 0; $j<$num_fields; $j++) {
						$row[$j] = addslashes($row[$j]);
						$row[$j] = str_replace("\n", "\\n", $row[$j]);

						if (isset($row[$j])) {
							$return .= '"' . $row[$j] . '"';
						} 
						else {
							$return .= '""';
						}

						if ($j < ($num_fields-1)) {
							$return .= ',';
						}
					}

					$return .= ");\n";
				}
			}

			$return .= "\n\n";
		}
		// Create Backup Folder

		$folder = 'Database_Backup/';

		if (!is_dir($folder))

		mkdir($folder, 0755, true);
		chmod($folder, 0755);

		$date = date('m-d-Y-H-i-s', time()); 
		$filename = $folder . "Import-" . get_instance()->db->database . "-" . $date; 

		$handle = fopen($filename . '.sql', 'w+');

		fwrite($handle, $return);
		fclose($handle);

		echo "Backup of Database Taken";
	}

	function index() {
    	die('<pre>'.print_r(get_instance(),1).'</pre>');
		$db_name = 'sireservasi';

		$this->load->dbutil();
		if ($this->dbutil->database_exists($db_name))
        {
           echo 'Database already exist';
        }
        else
        {
           echo 'Database success create';
        }

        exit();

		// if($this->m_utilitas->drop_db($db_name))
		// {
			$dbs = $this->m_utilitas->show_dbs();
			// foreach ($dbs as $db) {
			// 	# code...
			// 	echo $db . "\n";
			// }
		// }
		die('<pre>'.print_r($dbs,1).'</pre>');
	}

    function backup() {
        // Delete first table view if u have
    	// $this->m_utilitas->Del_view();

    	// $this->load->library('zip');
    	// $this->zip->add_data($name, $data);

        // Load the file helper and write the file to your server
    	$this->load->helper('download');
    	$tanggal = date('Ymd-His');
    	$namaFile = $tanggal . '.sql';

        // Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $backup =& $this->dbutil->backup();

        // Load the download helper and send the file to your desktop
        force_download($namaFile, $backup);
    }

    function backup2() {
        // Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $backup =& $this->dbutil->backup();

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file('/path/to/mybackup.gz', $backup);

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('mybackup.gz', $backup);

        /* Setting Backup Preferences
         * Backup preferences are set by submitting an array of values to the first parameter of the backup function. Example:
         */
        // $prefs = array(
        //     // Array of tables to backup.
        //     'tables' => array('table1', 'table2'),
        //     // List of tables to omit from the backup
        //     'tables' => array(),
        //     // gzip, zip, txt
        //     'format' => 'txt',
        //     // File name – NEEDED ONLY WITH ZIP FILES
        //     'filename' => 'mybackup.sql',
        //     // Whether to add DROP TABLE statements to backup file
        //     'add_drop' => TRUE,
        //     // Whether to add INSERT data to backup file
        //     'add_insert' => TRUE,
        //     // Newline character used in backup file
        //     'newline' => "\n"
        // );

        // $this->dbutil->backup($prefs);
    }


    // Sebelum melakukan restore extrak dahulu file zip sehingga menjadi file extension .sql
    // Sebagai alternatif, anda bisa membuat aplikasi upload file database yang akan di restore ke dalam folder yang sudah ditentukan misalnya folder backupdb
    // Setelah file berada di folder tersebut, maka script akan membaca file tersebut dan melakukan proses restore
    
    function restore() {
    	// First delete the database when the restore process fails
    	$this->Edit_model->hapus_db();

    	// Upload the file first
    	$fupload = $_FILES['datafile'];
    	$nama = $_FILES['datafile']['name'];
    	if(isset($fupload)) {
    		$lokasi_file = $fupload['tmp_name'];
    		$direktori = "backupdb/$nama";
    		move_uploaded_file($lokasi_file, "$direktori");
		}

		// restore database
		$isi_file = file_get_contents($direktori);
		$string_query = rtrim($isi_file, "\n;" );
		$array_query = explode(";", $string_query);

		foreach($array_query as $query) {
			$this->db->query($query);
		}

		$data['page'] = 'restore';
		$this->load->view('home', $data);
    }

    function restore2() {
        $isi_file = file_get_contents('./database/db20110603182125.sql');
        $string_query = rtrim($isi_file, "\n;");
        $array_query = explode(";", $query);
        
        foreach($array_query as $query) {
            $this->db->query($query);
        }
    }
}