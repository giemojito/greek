<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Greeking Greek Toolbar Html
 *
 * This class enables the creation button header on content
 * 
 * @package     Greeking HTML
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Anggie Septian ^_^ @greeking-solutions
 * @email       anggie.if04@gmail.com
**/ 
 
class Greek_Toolbar { 
    private $data = array();
    
    public $title;
    
    public $subtitle;
    
    public function add($name, $url, $title = null)
    {
        $this->data[] = array('url' => $url, 'name' => $name, 'title' => $title);
    }
    
    private function _get()
    {
        $buffer = "";
        $toolbar = sizeof($this->data);
        if ($toolbar > 0) {
            foreach ($this->data as $item) {
            	switch (trim(strtolower($item['name']))) {
            		case 'add':
            			$btn = 'btn-success';
            			$icon = 'fa fa-plus';
            			break;
            		case 'activate':
            			$btn = 'btn-success';
            			$icon = 'fa fa-check';
            			break;
            		case 'deactivate':
            			$btn = 'btn-danger';
            			$icon = 'fa fa-minus';
            			break;
            		case 'cancel':
            			$btn = 'btn-danger';
            			$icon = 'fa fa-times';
                        break;
                    case 'delete':
                        $btn = 'btn-danger';
                        $icon = 'fa fa-eraser';
            			break;
            		case 'print':
            			$btn = 'btn-info';
            			$icon = 'fa fa-print';
            			break; 
            		case 'refresh':
            			$btn = 'btn-info';
            			$icon = 'fa fa-refresh';
            			break;
            		case 'pdf':
            			$btn = 'btn-metis-4';
            			$icon = 'fa fa-building-o';
            			break;
            		case 'excel':
            			$btn = 'btn-metis-4';
            			$icon = 'fa fa-file-text';
            			break;
            		case 'save':
            			$btn = 'btn-metis-5';
            			$icon = 'fa fa-save';
            			break;
            		case 'edit':
                        $btn = 'btn-metis-5';
                        $icon = 'fa fa-edit';
                        break;
                    case 'find':
            			$btn = 'btn-default';
                        $icon = 'fa fa-search';
                        break;
                    case 'showall':
                        $btn = 'btn-metis-6';
                        $icon = 'glyphicon glyphicon-align-justify';
                        break;
                    case 'sort':
                        $btn = 'btn-metis-6';
                        $icon = 'glyphicon glyphicon-sort';
                        // $icon = 'glyphicon glyphicon-sort-by-alphabet'; // a - z
                        // $icon = 'glyphicon glyphicon-sort-by-alphabet-alt'; // z - a
                        // $icon = 'glyphicon glyphicon-sort-by-order'; // 1 - 9
                        // $icon = 'glyphicon glyphicon-sort-by-order-alt'; // 9 - 1
                        // $icon = 'glyphicon glyphicon-sort-by-attributes';
                        // $icon = 'glyphicon glyphicon-sort-by-attributes-alt';
                        break;
            		default:
            			$btn = 'btn-default';
            			$icon = 'fa fa-th-large';
            			break;
            	}
	            $buffer .= '
	            	<div class="btn-group">
	            		<a class="btn '.$btn.' btn-sm" href="'.$item['url'].'" data-original-title="'.$item['title'].'" data-toggle="tooltip">
	                	<i class="'.$icon.' fa-2x"></i>
	              		</a>
	            	</div>
	            ';
            }

            $buffer = "<div class='box'><header><div class='toolbar'>$buffer</div></header></div>";        
        }
        else {
            $buffer = "&nbsp;";
        }
       
        return $buffer;
    }
    
    public function to_string() {
        return $this->_get();
    }
    
    public function to_print() {
        echo $this->_get();
    }
}