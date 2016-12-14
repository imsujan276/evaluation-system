<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Batch extends MY_Controller {

    private $my_input;

    public function __construct() {
        parent::__construct();
        $this->my_input = array(
            array(
                'field' => 'batch_name',
                'label' => 'Batch Name',
                'rules' => 'required|alpha_numeric_spaces|min_length[3]|max_length[20]',
                'type' => 'text'
            ),
        );
    }

    public function index() {
        $this->my_header_view_admin();

        $this->load->model('Batch_Model');
        $this->load->view('admin/table', array(
            'caption' => 'Batch List',
            'table' => $this->Batch_Model->table_view(),
            'href' => 'batch/add',
            'button_label' => 'Add Batch'
        ));
        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    private function validation() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules($this->my_input);
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
    }

    private function form() {
        $this->load->helper('form');
        $myform = array(
            'action' => 'batch/add',
            'button_name' => 'add_batch_button',
            'button_label' => 'Add Batch',
            'attr' => $this->my_input,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Add Batch'
        ));
    }

    public function add() {

        $this->my_header_view_admin();
        $this->validation();


        if (!$this->form_validation->run()) {
            $this->form();
        } else {

            $value = $this->input->post('batch_name', TRUE);

            $this->load->model('Batch_Model');
            $data = array(
                'batch_name' => $value,
                'admin_id' => $this->session->userdata('admin_id'),
            );
            $msg = ($this->Batch_Model->add($data)) ? '"' . $value . '" Added!' : 'Failed to add.';

            $this->load->view('admin/msg', array(
                'msg' => $msg
            ));
        }

        $this->load->view('admin/footer2');
    }

}
