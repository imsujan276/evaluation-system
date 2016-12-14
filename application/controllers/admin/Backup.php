<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Backup extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->my_header_view_admin();
        $this->load->view('admin/msg', array(
            'msg' => anchor(base_url('admin/backup/download'), 'Download Back up Database.', array('class' => 'btn btn-success btn-mini'))
        ));
        $this->load->view('admin/backup');
        $this->load->view('admin/footer2');
    }

    public function download() {
        $this->load->model('Backup_Model');
        $this->load->helper('download');
        $this->Backup_Model->backup();
    }

}
