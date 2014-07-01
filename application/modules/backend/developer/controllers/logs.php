<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('language');
		$this->lang->load('logs');

		$this->data['log_threshold'] = $this->config->item('log_threshold');
	}

	/**
	 * Lists all log files and allows you to change the log_threshold.
	 *
	 * @access public
	 *
	 * @return void
	**/
	public function index()
	{
		extract($_POST, EXTR_PREFIX_ALL, "post");
		$this->load->helper('file');

		// Are we doing bulk actions?
		if (isset($post_delete)) {
			if (is_array($post_checked) && count($post_checked)) {
				foreach ($post_checked as $file) {
					@unlink($this->config->item('log_path') . $file);

					// Log system the activity, istable
					// $activity_text = 'log file ' . date('F j, Y', strtotime(str_replace('.php', '', str_replace('log-', '', $file))));
					// log_activity($this->current_user->id, ucfirst($activity_text) . ' deleted from: ' . $this->input->ip_address(), 'logs');
				}

				$this->greek_alert->flash(sprintf(lang('log_deleted'), count($post_checked)), 'TRUE');
			}
		}
		elseif (isset($post_delete_all)) {
			delete_files($this->config->item('log_path'));
			
			// restore the index.html file
			@copy(APPPATH . '/index.html', $this->config->item('log_path') . '/index.html');

			// Log system the activity, istable
			$activity_text = "all log files";
			// log_activity($this->current_user->id, ucfirst($activity_text) . ' deleted from: ' . $this->input->ip_address(), 'logs');

			$this->greek_alert->flash("Successfully deleted " . $activity_text, 'TRUE');
		}

		// Load the Log Files
		$logs = get_filenames($this->config->item('log_path'));
        arsort($logs);

		// Pagination
		$this->load->library('pagination');

		$offset = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
		$limit = 10;

		$this->pager['base_url'] = site_url('/developer/logs/index');
		$this->pager['total_rows'] = sizeof($logs);
		$this->pager['per_page'] = $limit;
		$this->pager['uri_segment']	= 4;

		$this->pagination->initialize($this->pager);

		$this->data['logs'] = array_slice($logs, $offset, $limit);
		$this->_render('developer/logs');
	}

	/**
	 * Display the page which lets the user choose the logging threshold.
	 *
	 * @access public
	 *
	 * @return void
	**/
	public function settings()
	{
		$this->data['toolbar_title'] = lang('log_title_settings');
		$this->_render('developer/settings');
	}

	/**
	 * Saves the logging threshold value.
	 *
	 * @access public
	 *
	 * @return void
	**/
	public function enable()
	{
		extract($_POST, EXTR_PREFIX_ALL, "post");
		if (isset($post_save)) {

			// $this->load->helper('config_file');
			// if (write_config('config', array('log_threshold' => $post_log_threshold)))  {
			if ($this->write_config('config', array('log_threshold' => $post_log_threshold)))  {
				// Log the activity
				// log_activity(intval($this->current_user->id), 'Log settings modified from: ' . $this->input->ip_address(), 'logs');

				$this->greek_alert->flash('Log settings successfully saved.', 'TRUE');
			}
			else {
				$this->greek_alert->flash('Unable to save log settings. Check the write permissions on <b>application/config.php</b> and try again.', 'FALSE');
			}
		}

		redirect('/developer/logs');
	}

	/**
	 * Shows the contents of a single log file.
	 *
	 * @access public
	 *
	 * @param string $file The full name of the file to view (including extension).
	 *
	 * @return void
	**/
	public function view($file = '')
	{
		if (empty($file)) {
			$this->greek_alert->flash("No log file provided.", 'FALSE');
			redirect('/developer/logs');
		}

		$path = $this->config->item('log_path') . $file;
		if (file_exists($path)) {
			$this->data['log_content'] = file($path);
		}

		$this->data['log_file'] = $file;
		$this->data['log_file_pretty'] = date('F j, Y', strtotime(str_replace('.php', '', str_replace('log-', '', $file))));
		$this->_render('developer/view');
	}

	function write_config($file = '', $settings = null, $module = '', $apppath = APPPATH)
	{
		if (empty($file) || ! is_array($settings)) {
			return FALSE;
		}

		$config_file = 'config/'.$file;

		// Look in module first
		$found = FALSE;
		if ($module) {
			$file_details = Modules::find($config_file, $module, '');

			if (! empty($file_details) && ! empty($file_details[0])) {
				$config_file = implode("", $file_details);
				$found = TRUE;
			}
		}

		// Fall back to application directory
		if (! $found) {
			$config_file = $apppath.$config_file;
			$found = is_file($config_file.EXT);
		}

		// Load the file so we can loop through the lines
		if ($found) {
			$contents = file_get_contents($config_file.EXT);
			$empty = FALSE;
		}
		else {
			$contents = '';
			$empty = TRUE;
		}

		foreach ($settings as $name => $val) {
			// Is the config setting in the file?
			$start = strpos($contents, '$config[\''.$name.'\']');
			$end = strpos($contents, ';', $start);

			$search = substr($contents, $start, $end-$start+1);

			// var_dump($search); die();

			if (is_array($val)) {
				// get the array output
				$val = config_array_output($val);
			}
			elseif (is_numeric($val)) {
				$val = $val;
			}
			else {
				$val ="\"$val\"";
			}

			if (!$empty) {
				$contents = str_replace($search, '$config[\''.$name.'\'] = '. $val .';', $contents);
			}
			else {
				$contents .= '$config[\''.$name.'\'] = '. $val .";\n";
			}
		}

		// Backup the file for safety
		$source = $config_file.EXT;
		$dest = $module == '' ? $apppath . 'archives/' . $file . EXT . '.bak' : $config_file . EXT . '.bak';

		if ($empty === FALSE) copy($source, $dest);

		// Make sure the file still has the php opening header in it...
		if (strpos($contents, '<?php') === FALSE){
			$contents = '<?php if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');' . "\n\n" . $contents;
		}

		// Write the changes out...
		$this->load->helper('file');
		$result = write_file($config_file.EXT, $contents);

		if ($result === FALSE) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
}
