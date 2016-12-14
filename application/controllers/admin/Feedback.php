<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Feedback extends MY_Controller {

    private $my_input;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Semester_Model', 'Batch_Model', 'Division_Model', 'Branch_Model'));
    }

    public function index() {
        $this->my_header_view_admin();


        $this->form_process();


        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    private function form_process() {
        $this->load->library('form_validation');
        $this->validation();
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
        $this->form_validation->set_rules($this->my_input);
        if (!$this->form_validation->run()) {
            $this->form();
        } else {
            $branch_id = $this->input->post('branch_id');

            $this->faculty_view($branch_id);
        }
    }

    private function faculty_view($branch_id) {
        $this->load->model('Faculty_Model');

        $row = $this->Branch_Model->get(array('branch_id' => $branch_id))->row();

        $this->load->view('admin/table', array(
            'caption' => 'Faculty List from Branch "' . $row->branch_name . '".',
            'table' => $this->Faculty_Model->table_view_feed_back($branch_id),
            'href' => NULL,
            'button_label' => NULL
        ));
    }

    private function validation() {

        $this->my_input = array(
            array(
                'field' => 'branch_id',
                'label' => 'Branch',
                'rules' => 'required|numeric',
                'type' => 'combo',
                'combo_value' => $this->Branch_Model->combo(),
            ),
        );
    }

    public function result($schedule_id = NULL) {
        $row_sched = $this->check_id_sched($schedule_id);

        $this->my_header_view_admin();

        $this->load->model('Score_Model');
        $this->load->view('admin/table', array(
            'caption' => 'Result ',
            'table' => $this->Score_Model->table_view($row_sched->schedule_id),
            'href' => NULL,
            'button_label' => NULL
        ));

        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    public function schedule($id = NULL) {
        $row = $this->check_id_($id);
        $this->my_header_view_admin();

        $this->load->model('Schedule_Model');
        $this->load->view('admin/table', array(
            'caption' => 'Schedule List of "' . $row->faculty_lastname . ', ' . $row->faculty_name . '" | ' . $row->faculty_school_id . '.',
            'table' => $this->Schedule_Model->table_view($row->faculty_id, TRUE),
            'href' => NULL,
            'button_label' => NULL
        ));

        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    private function check_id_sched($id = NULL) {
        if (is_null($id)) {
            show_404();
        }

        $this->load->model('Schedule_Model');
        $rs = $this->Schedule_Model->get(array(
            'schedule_id' => $id
        ));
        if (!$rs) {
            show_404();
        }
        return $rs->row();
    }

    private function check_id_($id = NULL) {
        if (is_null($id)) {
            show_404();
        }

        $this->load->model('Faculty_Model');
        $rs = $this->Faculty_Model->get(array(
            'faculty_id' => $id
        ));
        if (!$rs) {
            show_404();
        }
        return $rs->row();
    }

    private function form() {

        $this->load->helper('form');
        $myform = array(
            'action' => 'feedback',
            'button_name' => 'btn',
            'button_label' => 'Choose',
            'attr' => $this->my_input,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Branch'
        ));
    }

}
