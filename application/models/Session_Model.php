<?php

defined('BASEPATH') or exit('no direct script allowed');

class Session_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function my_check_session() {
        //saving urls
        $this->load->helper('url');
        $usertype = 'not logged';
        if ($this->uri->segment(1) == str_replace('/', '', ADMIN_DIRFOLDER_NAME)) {
            if (!$this->session->userdata('validated_admin')) {
                redirect('admin/login');
            } else {
                $usertype = 'admin';
            }
        } else {
            if (!$this->session->userdata('validated_client')) {
                redirect(base_url('login'));
            } else {
                $usertype = 'client';
            }
        }
        save_current_url($usertype);
    }

}
