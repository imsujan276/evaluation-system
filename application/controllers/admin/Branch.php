<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Branch extends MY_Controller {

    private $my_input;

    public function __construct() {
        parent::__construct();
        $this->my_input = array(
            array(
                'field' => 'branch_name',
                'label' => 'Branch Name',
                'rules' => 'required|alpha_numeric_spaces|min_length[3]|max_length[20]',
                'type' => 'text'
            ),
        );
    }

    public function index() {
        $this->my_header_view_admin();

        $this->load->model('Branch_Model');
        $this->load->view('admin/table', array(
            'caption' => 'Branch List',
            'table' => $this->Branch_Model->table_view(),
            'href' => 'branch/add',
            'button_label' => 'Add Branch'
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
            'action' => 'branch/add',
            'button_name' => 'add_branch_button',
            'button_label' => 'Add Branch',
            'attr' => $this->my_input,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Add Branch'
        ));
    }

    public function add() {

        $this->my_header_view_admin();
        $this->validation();


        if (!$this->form_validation->run()) {
            $this->form();
        } else {

            $value = $this->input->post('branch_name', TRUE);

            $this->load->model('Branch_Model');

            $data = array(
                'branch_name' => $value,
                'admin_id' => $this->session->userdata('admin_id'),
            );
            $msg = ($this->Branch_Model->add($data)) ? '"' . $value . '" Added!' : 'Failed to add.';

            $this->load->view('admin/msg', array(
                'msg' => $msg
            ));
        }

        $this->load->view('admin/footer2');
    }

}
