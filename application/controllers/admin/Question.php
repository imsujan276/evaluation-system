<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Question extends MY_Controller {

    private $my_input;

    public function __construct() {
        parent::__construct();
        $this->load->model('Category_Model');
        $this->my_input = array(
            array(
                'field' => 'question_short',
                'label' => 'Question Key',
                'rules' => 'required|alpha_numeric_spaces|min_length[4]|max_length[6]',
                'type' => 'text'
            ),
            array(
                'field' => 'question_long',
                'label' => 'Question',
                'rules' => 'required|alpha_numeric_spaces|min_length[10]|max_length[250]',
                'type' => 'textarea'
            ),
            array(
                'field' => 'category_id',
                'label' => 'Category',
                'rules' => 'required',
                'type' => 'combo',
                'combo_value' => $this->Category_Model->combo()
            ),
        );
    }

    public function index() {
        $this->my_header_view_admin();

        $this->load->model('Question_Model');
        $this->load->view('admin/table', array(
            'table' => $this->Question_Model->table_view(),
            'href' => 'question/add',
            'button_label' => 'Add Question',
            'caption' => 'Question List'
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
            'action' => 'question/add',
            'button_name' => 'add_question_button',
            'button_label' => 'Add Question',
            'attr' => $this->my_input,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Add Question'
        ));
    }

    public function add() {

        $this->my_header_view_admin();
        $this->validation();


        if (!$this->form_validation->run()) {
            $this->form();
        } else {

            $data = array(
                'question_short' => $this->input->post('question_short', TRUE),
                'question_long' => $this->input->post('question_long', TRUE),
                'category_id' => $this->input->post('category_id', TRUE),
                'admin_id' => $this->session->userdata('admin_id'),
            );
            $this->load->model('Question_Model');
            $msg = ($this->Question_Model->add($data)) ? 'Question Added!' : 'Failed to add.';

            $this->load->view('admin/msg', array(
                'msg' => $msg
            ));
        }

        $this->load->view('admin/footer2');
    }

}
