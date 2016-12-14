<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Password extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
       $this->my_header_view_admin();


        $this->load->view('admin/footer2');
    }

}
