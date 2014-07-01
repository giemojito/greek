<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Greeking Greek Table Html
 *
 * This class enables the creation table and pagination
 * 
 * @package     Greeking HTML
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Anggie Septian ^_^ @greeking-solutions
 * @email       anggie.if04@gmail.com
**/ 
 
class Greek_Table {

    var $CI;
    var $template = NULL;

    /**
     * 
     * PROTECTED attributes
     * 
    **/ 
    // table headers container
    protected $headers;

    // table rows container
    protected $rows = array();
    protected $class;
    protected $method;

    /**
     * 
     * PUBLIC attributes
     * 
    **/ 
    public $page;

    // total rows that fetched
    public $total_rows;

    // num of displayed rows in one page
    public  $displayed_rows = 25;

    // flag displaying all row item data
    public  $is_display_all_rows = false;

    // flag displaying html table pagination links
    public  $is_display_links = true;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('table');
        $this->class = $this->CI->router->fetch_class(); 
        $this->method = $this->CI->router->fetch_method();

        $this->page = $this->init_offset();
    }

    function init_offset($offset = '')
    {
        if ($offset === '') {
            $page = ($this->CI->uri->segment(3)) ? $this->CI->uri->segment(3) : 0;
        }
        else {
            $page = $offset;
        }

        return $page;
    }
    
    function get_data($obj)
    {
        $str = explode(" ", $obj);
        switch (strtolower($str['0'])) {
            case 'select':
                if ($this->is_display_all_rows === TRUE) {
                    // all row displayed, no need for paging
                    $this->is_display_links = FALSE;
                    $sql = $obj;
                }
                else {
                    $idx = strpos(strtolower($obj), " where ");
                    if ($idx !== false) {
                        $part1 = substr($obj, 0, $idx);
                        $part2 = substr($obj, $idx);

                        $idx2  = strpos(strtolower($part2), " order by ");
                        $part2 = $idx2 !== false ? substr($part2, 0, $idx2) : $part2;
                    }
                    else {
                        $part1 = $obj;
                        $idx2  = strpos(strtolower($part1), " order by ");
                        $part1 = $idx2 !== false ? substr($part1, 0, $idx2) : $part1;
                        $part2 = "";
                    }

                    $sql = $part1;
                    $sql = str_replace(substr($sql, 0, strpos(strtolower($sql), " from ")), 'select count(*) as counter', $sql) . $part2;

                    $res = $this->CI->db->query($sql)->result();
                    $this->total_rows = $res[0]->counter;
                
                    // not all row displayed, use paging
                    $sql = $obj . ($this->is_display_all_rows ? "" : " limit $this->displayed_rows offset $this->page");
                }

                $data = $this->CI->db->query($sql)->result_array();
                break;
            
            default:
                $this->total_rows = $this->CI->db->get($obj)->num_rows();

                if ($this->is_display_all_rows === TRUE) {
                    // all row displayed, no need for paging
                    $data = $this->CI->db->get($obj)->result_array();
                    $this->is_display_links = FALSE;
                }
                else {
                    // not all row displayed, use paging
                    $data = $this->CI->db->get($obj, $this->displayed_rows, $this->page)->result_array();
                }
                break;
        }

        return $data;
    }

    function set_template($template)
    {
        if ( ! is_array($template)) {
            return FALSE;
        }

        $this->template = $template;
    }

    public function set_header($header)
    {
        $this->headers = $header;
    }

    public function add_row($row)
    {
        $this->rows[] = $row;
    }

    /**
     * Real Generate the table
     *
     * @access  private
     * @param   mixed
     * @return  string
    **/
    private function _get()
    {
        $buffer = "";
        $buffer .= $this->is_display_links === TRUE ? $this->_create_link() : "";
        $buffer .= $this->_create_row();
        $buffer .= $this->is_display_links === TRUE ? $this->_create_link() : "";

        // Clear table class properties before generating the table
        $this->clear();
        return $buffer;
    }

    /**
     * Generate the pagination links
     *
     * @access  private
     * @return  string
    **/
    private function _create_link()
    {
        $config_paging['base_url'] = base_url($this->class.'/'.$this->method);
        $config_paging['total_rows'] = $this->total_rows;
        $config_paging['per_page'] = $this->displayed_rows;
        $config_paging['num_links'] = 3;
        $config_paging['uri_segment'] = 3;
        $this->CI->pagination->initialize($config_paging);

        return $this->CI->pagination->create_links();
    }

    /**
     * Generate the table heading and table body 
     *
     * @access  private
     * @return  string
    **/
    private function _create_row()
    {
        $this->CI->table->set_template($this->_init_template());
        $this->CI->table->set_heading($this->headers);
        $this->CI->table->set_empty("&nbsp;"); 
        return $this->CI->table->generate($this->rows);
    }

    /**
     * Generate the table
     *
     * @access  public
     * @return  string
    **/
    public function to_string()
    {
        return $this->_get();
    }
    
    /**
     * Print Generate the table
     *
     * @access  public
    **/
    public function to_print()
    {
        echo $this->_get();
    }

    /**
     * Clears the table arrays.  Useful if multiple tables are being generated
     *
     * @access  public
     * @return  void
    **/
    function clear()
    {
        $this->rows = array();
        $this->headers = array();
    }

    /**
     * Compile Template
     *
     * @access  private
     * @return  void
    **/
    private function _init_template()
    {
        return $this->template == NULL ? $this->_default_template() : $this->template;
    }

    /**
     * Default Template
     *
     * @access  private
     * @return  void
    **/
    private function _default_template()
    {
        $template = array (
            'table_open' => '<form name="theForm" id="theForm" method="post" action="">
            <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">',

            'thead_open' => '<thead>',
            'thead_close' => '</thead>',

            'heading_row_start' => '<tr>',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',

            'tbody_open' => '<tbody>',
            'tbody_close' => '</tbody>',

            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',

            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',

            'table_close' => '</table></form>'
        );

        return $template;
    }

}