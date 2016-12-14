<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Category extends MY_Controller {

    private $my_input;

    public function __construct() {
        parent::__construct();
        $this->my_input = array(
            array(
                'field' => 'category_name',
                'label' => 'Category Name',
                'rules' => 'required|alpha_numeric_spaces|min_length[4]|max_length[20]',
                'type' => 'text'
            ),
        );
    }

    public function index() {
        $this->my_header_view_admin();
        $this->load->model('Category_Model');
        $this->load->view('admin/table', array(
            'table' => $this->Category_Model->table_view(),
            'href' => 'category/add',
            'button_label' => 'Add Category',
            'caption' => 'Category List'
        ));
        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    private function form() {
        $this->load->helper('form');
        $myform = array(
            'action' => 'category/add/',
            'button_name' => 'add_category_button',
            'button_label' => 'Add Category',
            'attr' => $this->my_input,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Add Category'
        ));
    }

    public function add() {
        $this->my_header_view_admin();
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->my_input);
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');

        if (!$this->form_validation->run()) {
            $this->form();
        } else {
            $this->load->model('Category_Model');

            $this->load->view('admin/msg', array(
                'msg' => ($this->Category_Model->add(array(
                    'category_name' => $this->input->post('category_name'),
                    'admin_id' => $this->session->userdata('admin_id'),
                ))) ? 'Done<br />' : 'Failed<br />'
            ));
        }
        $this->load->view('admin/footer2');
    }

}
