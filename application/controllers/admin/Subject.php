<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Subject extends MY_Controller {

    private $my_add_subject_input;
    private $my_add_term_input;

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->my_header_view_admin();

        $this->view_subject();

        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    private function add_term_validation() {
        $this->load->model(array('Semester_Model', 'Batch_Model', 'Division_Model'));
        $this->my_add_term_input = array(
            array(
                'field' => 'semester_id',
                'label' => 'Semester',
                'rules' => 'required|numeric',
                'type' => 'combo',
                'combo_value' => $this->Semester_Model->combo(),
            ),
            array(
                'field' => 'batch_id',
                'label' => 'Batch',
                'rules' => 'required|numeric',
                'type' => 'combo',
                'combo_value' => $this->Batch_Model->combo(),
            ),
            array(
                'field' => 'division_id',
                'label' => 'Division',
                'rules' => 'required|numeric',
                'type' => 'combo',
                'combo_value' => $this->Division_Model->combo(),
            ),
        );
    }

    private function add_subject_validation() {

        $this->my_add_subject_input = array(
            array(
                'field' => 'subject_code',
                'label' => 'Subject Code',
                'rules' => 'required|alpha_numeric_spaces|min_length[3]|max_length[10]',
                'type' => 'text'
            ), array(
                'field' => 'subject_desc',
                'label' => 'Subject Description',
                'rules' => 'required|alpha_numeric_spaces|min_length[3]|max_length[20]',
                'type' => 'text'
            ),
        );
    }

    public function term($sub_id) {
        $row_sub = $this->check_id_($sub_id);
        $this->my_header_view_admin();

        $this->load->model('Subject_Term_Model');
        $this->load->view('admin/table', array(
            'caption' => 'Subject Term List of "' . $row_sub->subject_code . ' - ' . $row_sub->subject_desc . '".',
            'table' => $this->Subject_Term_Model->table_view_term($sub_id),
            'href' => 'subject/add-term/' . $sub_id,
            'button_label' => 'Add Subject Term',
        ));


        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    public function add_term($sub_id = NULL) {
        $row_sub = $this->check_id_($sub_id);
        $this->my_header_view_admin();

        $this->load->library('form_validation');
        $this->add_term_validation();
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');

        $this->form_validation->set_rules($this->my_add_term_input);


        if (!$this->form_validation->run()) {
            $this->form_term($row_sub);
        } else {

            $data = array(
                'subject_id' => $sub_id,
                'semester_id' => $this->input->post('semester_id', TRUE),
                'batch_id' => $this->input->post('batch_id', TRUE),
                'division_id' => $this->input->post('division_id', TRUE),
                'admin_id' => $this->session->userdata('admin_id'),
            );
            $this->load->model('Subject_Term_Model');
            $msg = ($this->Subject_Term_Model->add($data)) ? 'Added!<br />' : 'Failed to add.<br />';

            $this->load->view('admin/msg', array(
                'msg' => $msg,
            ));
        }
        //    $this->view_subject();
        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    private function view_subject() {

        $this->load->model('Subject_Model');
        $this->load->view('admin/table', array(
            'caption' => 'Subject List',
            'table' => $this->Subject_Model->table_view(),
            'href' => 'subject/add/',
            'button_label' => 'Add Subject',
        ));
    }

    private function form_term($row_sub) {
        $this->load->helper('form');
        $myform = array(
            'action' => 'subject/add-term/' . $row_sub->subject_id,
            'button_name' => 'add_term_button',
            'button_label' => 'Add Subject Term',
            'attr' => $this->my_add_term_input,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Add Term of subject "' . $row_sub->subject_code . ' - ' . $row_sub->subject_desc . '"'
        ));
    }

    private function form_subject() {
        $this->load->helper('form');
        $myform = array(
            'action' => 'subject/add/',
            'button_name' => 'add_subject_button',
            'button_label' => 'Add Subject',
            'attr' => $this->my_add_subject_input,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Add Subject'
        ));
    }

    public function add() {

        $this->my_header_view_admin();

        $this->load->library('form_validation');
        $this->add_subject_validation();
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');

        $this->form_validation->set_rules($this->my_add_subject_input);


        if (!$this->form_validation->run()) {
            $this->form_subject();
        } else {

            $tmp = $this->input->post('subject_desc', TRUE);
            $data = array(
                'subject_desc' => $tmp,
                'subject_code' => $this->input->post('subject_code', TRUE),
                'admin_id' => $this->session->userdata('admin_id'),
            );
            $this->load->model('Subject_Model');
            $msg = ($this->Subject_Model->add($data)) ? '"' . $tmp . '" Added!<br />' : 'Failed to add.<br />';

            $this->load->view('admin/msg', array(
                'msg' => $msg,
            ));
        }
        $this->view_subject();
        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    private function check_id_($id = NULL) {
        if (is_null($id)) {
            show_404();
        }

        $this->load->model('Subject_Model');
        $rs = $this->Subject_Model->get(array(
            'subject_id' => $id
        ));
        if (!$rs) {
            show_404();
        }
        return $rs->row();
    }

}
