<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| Pagination Config
| -------------------------------------------------------------------
| Just applying codeigniter's standard pagination config with twitter
| bootstrap stylings
| 
| @file		pagination.php
| 
*/

// $config['base_url'] = '';
// $config['per_page'] = 2;
// $config['uri_segment'] = 3;
// $config['num_links'] = 9;
// $config['page_query_string'] = TRUE;
// // $config['use_page_numbers'] = TRUE;
// $config['query_string_segment'] = 'page';

$config['full_tag_open'] = '<div align="right"><ul class="pagination pagination-sm">';
$config['full_tag_close'] = '</ul></div>';

// $config['first_link'] = '&laquo; First';
$config['first_link'] = '&Larr; First';
$config['first_tag_open'] = '<li class="prev page">';
$config['first_tag_close'] = '</li>';

// $config['last_link'] = 'Last &raquo;';
$config['last_link'] = 'Last &Rarr;';
$config['last_tag_open'] = '<li class="next page">';
$config['last_tag_close'] = '</li>';

$config['next_link'] = 'Next &rarr;';
$config['next_tag_open'] = '<li class="next page">';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = '&larr; Previous';
$config['prev_tag_open'] = '<li class="prev page">';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="active"><a href="">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li class="page">';
$config['num_tag_close'] = '</li>';

// $config['display_pages'] = FALSE;
$config['anchor_class'] = 'follow_link';



/* This Application Must Be Used With BootStrap 3 *  */
// $config['full_tag_open'] = "<ul class='pagination'>";
// $config['full_tag_close'] ="</ul>";

// $config['num_tag_open'] = '<li>';
// $config['num_tag_close'] = '</li>';

// $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
// $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

// $config['next_tag_open'] = "<li>";
// $config['next_tag_close'] = "</li>";

// $config['prev_tag_open'] = "<li>";
// $config['prev_tag_close'] = "</li>";

// $config['first_tag_open'] = "<li>";
// $config['first_tag_close'] = "</li>";

// $config['last_tag_open'] = "<li>";
// $config['last_tag_close'] = "</li>";


/* End of file pagination.php */
/* Location: ./application/config/pagination.php */