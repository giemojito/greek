<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Greeking Greek Navbar Html
 *
 * This class enables the creation rekursif navbar top, right or in left
 * and don't worry this class will automatic return menu with role by group
 * 
 * @package     Greeking HTML
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Anggie Septian ^_^ @greeking-solutions
 * @email       anggie.if04@gmail.com
**/ 
 
class Greek_Navbar {

    var $CI;

    public function __construct($config = array())
    {
        $this->CI =& get_instance();
    }

    private function acl_group($usergroupid)
    {
        $this->CI->db->where('usergroupid', $usergroupid);
        $vars = $this->CI->db->get('greekgroup')->row();
        return $vars;
    }

    private function acl_user($grouplevel)
    {
        $this->CI->db->select('menuid');
        $this->CI->db->where('grouplevel', $grouplevel);
        $result = $this->CI->db->get('greekgroupmenu')->result();
        $res = array();

        foreach ($result as $key) {
            $res[] = $key->menuid;
        }

        return $res;
    }

    private function have_child($parent)
    {
        $this->CI->db->where('parentid', $parent);
        $hasil = $this->CI->db->get('greekmenu')->num_rows();
        return $hasil;
    }

    private function _get($parent = '0')
    {
        $usergroupid = $this->CI->session->userdata('usergroupid');
        $group = $this->acl_group($usergroupid);

        $menu = '<ul id="menu" class="">';
        if ($group->grouplevel > 2) {
            $acl = $this->acl_user($group->grouplevel);
            if (sizeof($acl) > 0) {
                $this->CI->db->where_in('menuid', $acl, FALSE);
                $result = $this->CI->db->get('greekmenu')->result();
            }
            else {
                $result = '';
            }
        }
        else {
            $result = $this->CI->db->get('greekmenu')->result();
        }

        if (is_array($result)) {
            foreach ($result as $res) {
                if ($res->parentid == $parent) {
                    $child = $this->have_child($res->menuid);
                    
                    if ($child > 0) {
                        $menu .= '<li class=""><a href="javascript:;"><i class="fa fa-windows"></i>&nbsp&nbsp&nbsp<span class="link-title">' . $res->menu . ' </span><span class="fa arrow"></span></a>';
                        $menu .= $this->_get($res->menuid);
                    }
                    else {
                        $menu .= '<li class=""><a href="'.base_url().$res->link.'"><i class="fa fa-windows"></i>&nbsp&nbsp&nbsp<span class="link-title">' . $res->menu . '</span></a></li>';
                    }

                    $menu .= "</li>";
                }
            }
        }
        else {
            $menu .= '';
        }
    
        $menu .= "</ul>";
        return $menu;
    }

    public function to_string()
    {
        return $this->_get();
    }
    
    public function to_print()
    {
        echo $this->_get();
    }

    // Print all menus no filter just print all
    // need function get_menu & print_child
    function _menu()
    {
        $retval = $this->get_menu();
        $navbar = "<ul>";

        foreach ($retval as $greekmenu) {
            $child = sizeof($greekmenu['child']);
            if ($child > 0) {
                $navbar .= '<li><a href="javascript:;">'.$greekmenu['nama'].'</a></li>';
                $navbar .= $this->print_child($greekmenu['child']);
            }
            else {
                $navbar .= '<li><a href="#">'.$greekmenu['nama'].'</a></li>';
            }
        }

        $navbar .= "</ul>";

        return $navbar;
    }

    private function print_child($data)
    {
        $str = "<ul>";

        foreach ($data as $list) {
            $str .= "<li><a href='javascript:#;'>" . $list['nama'] . "</a></li>";
            $subchild = $this->print_child($list['child']);

            if ($subchild != '') {
                $str .= "<ul>".$subchild."</ul>";
            }

            $str .= "</li>";
        }

        $str .= "</ul>";

        return $str;
    }

    
    private function get_menu($induk = 0)
    {
        $data = array();
        $this->CI->db->from('tbl_menu');
        $this->CI->db->where('id_parent', $induk);
        $result = $this->CI->db->get();

        foreach($result->result() as $row)
        {
            $data[] = array (
                'id' => $row->menuid,
                'nama' => $row->menu,
                // recursive
                'child' => $this->get_menu($row->menuid)
            );
        }

        return $data;
    }

    // long journey
    // needed to test rekursif menu with filter or roles
    function __nav($parent = '0')
    {
        $usergroupid = $this->CI->session->userdata('usergroupid');
        $grouplevel = '4';
        $group = $this->acl_group($usergroupid);
        $this->acl = $this->acl_user($grouplevel);

        // $this->CI->db->where('id_parent', $parent);
        // if ($group->grouplevel > 2) {
        if ($grouplevel > 2) {
            $this->CI->db->where_in('menuid', $this->acl, FALSE);
            $result = $this->CI->db->get('tbl_menu');

            $menu = '<ul>';
            foreach ($result->result() as $res) {
                if ($res->id_parent == $parent) {
                    $child = $this->have_child($res->menuid);
                    if ($child > 0) {
                        $menu .= '<li>';
                        $menu .= '<a href="#">' . $res->menu . '</a>';
                        $menu .= $this->get_child($res->menuid);
                    }
                    else {
                        $menu .= '<li>' . $res->menu . '</li>';
                    }
                    $menu .= "</li>";
                }
            }   
            $menu .= "</ul>";
            return $menu;
        }
        else {
            return $this->_menu();
        }
    }

    private function get_child($parent = '0')
    {
        $this->CI->db->where('id_parent', $parent);
        $result = $this->CI->db->get('tbl_menu');
        
        $menu = '<ul>';
        foreach ($result->result() as $val) {
            if (in_array($val->menuid, $this->acl) === TRUE) {
                $menu .= '<li>' . $val->menu.'<br>';
                $menu .= $this->get_child($val->menuid);
            }
                
            $menu .= '</li>';
        }
        $menu .= '</ul>';

        return $menu;
    }



}