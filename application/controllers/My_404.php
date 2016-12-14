<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class My_404 extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($msg = NULL) {
        $this->load->view('my_404');
    }

}
