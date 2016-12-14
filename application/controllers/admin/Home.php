<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model(array('Semester_Model', 'Batch_Model', 'Division_Model', 'Branch_Model'));
    }

    public function index() {
       // $this->load->view('admin/header');
        $this->my_header_view_admin();
        $this->load->view('admin/home');
        $this->load->view('admin/footer2');
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect(base_url('admin/login'), 'refresh');
    }

}
