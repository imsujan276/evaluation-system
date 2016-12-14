<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 */
defined('BASEPATH') or exit('Direct Script is not allowed');

class History extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->my_header_view_admin();

        $this->load->model('Url_Model');

        $this->load->view('admin/table', array(
            'caption' => 'Url List',
            'table' => $this->Url_Model->table_view(),
            'href'=>'',
            'button_label'=>''
        ));

        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

}
