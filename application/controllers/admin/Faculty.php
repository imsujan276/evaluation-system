<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Faculty extends MY_Controller {

    private $my_input;
    private $my_input_schedule;

    public function __construct() {
        parent::__construct();
    }

    private function add_faculty_validation() {
        $this->load->model('Branch_Model');
        $this->my_input = array(
            array(
                'field' => 'firstname',
                'label' => 'First Name',
                'rules' => 'required|human_name|min_length[4]|max_length[20]',
                'type' => 'text'
            ),
            array(
                'field' => 'lastname',
                'label' => 'Last Name',
                'rules' => 'required|human_name|min_length[4]|max_length[20]',
                'type' => 'text'
            ),
            array(
                'field' => 'school_id',
                'label' => 'School ID',
                'rules' => 'required|school_id|is_unique[student.student_school_id]|is_unique[faculty.faculty_school_id]',
                'type' => 'text',
            ),
            array(
                'field' => 'pin',
                'label' => 'Pin',
                'rules' => 'required|numeric|exact_length[6]',
                'type' => 'text',
            ),
            array(
                'field' => 'branch_id',
                'label' => 'Branch',
                'rules' => 'required|numeric',
                'type' => 'combo',
                'combo_value' => $this->Branch_Model->combo()
            ),
        );
    }

    public function schedule($id = NULL) {
        $row = $this->check_id_($id);
        $this->my_header_view_admin();

        $this->view_schedule($row);
        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    public function index() {
        $this->add_faculty_validation();
        $this->my_header_view_admin();

        $this->load->model('Faculty_Model');
        $this->load->view('admin/table', array(
            'caption' => 'Faculty List',
            'table' => $this->Faculty_Model->table_view(),
            'href' => 'faculty/add',
            'button_label' => 'Add Faculty'
        ));
        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    private function form_faculty() {
        $this->load->helper('form');
        $myform = array(
            'action' => 'faculty/add',
            'button_name' => 'add_faculty_button',
            'button_label' => 'Add Faculty',
            'attr' => $this->my_input,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Add Faculty'
        ));
    }

    private function view_schedule($row) {
        $this->load->model('Schedule_Model');
        $this->load->view('admin/table', array(
            'caption' => 'Schedule List of "' . $row->faculty_lastname . ', ' . $row->faculty_name . '" | ' . $row->faculty_school_id . '.',
            'table' => $this->Schedule_Model->table_view($row->faculty_id),
            'href' => 'faculty/add-subject-schedule/' . $row->faculty_id,
            'button_label' => 'Add Subject Schedule to "' . $row->faculty_lastname . ', ' . $row->faculty_name . '".'
        ));
    }

    private function add_schdule_validation() {
        $this->load->helper('combobox');

        $this->load->model('Subject_Term_Model');
        $this->my_input_schedule = array(
            array(
                'field' => 's_start',
                'label' => 'Start Time',
                'rules' => 'required',
                'type' => 'combo',
                'combo_value' => my_time_for_combo()
            ),
            array(
                'field' => 's_end',
                'label' => 'End Time',
                'rules' => 'required',
                'type' => 'combo',
                'combo_value' => my_time_for_combo()
            ),
            array(
                'field' => 'subject_term_id',
                'label' => 'Subject / Term',
                'rules' => 'required',
                'type' => 'combo',
                'combo_value' => $this->Subject_Term_Model->combo()
            ),
            array(
                'field' => 's_room',
                'label' => 'Room',
                'rules' => 'required|alpha_numeric_spaces|min_length[4]|max_length[10]',
                'type' => 'text'
            ),
            array(
                'field' => 's_m',
                'label' => 'Monday',
                'type' => 'checkbox'
            ),
            array(
                'field' => 's_t',
                'label' => 'Tuesday',
                'type' => 'checkbox'
            ),
            array(
                'field' => 's_w',
                'label' => 'Wednesday',
                'type' => 'checkbox'
            ),
            array(
                'field' => 's_th',
                'label' => 'Thursday',
                'type' => 'checkbox'
            ),
            array(
                'field' => 's_f',
                'label' => 'Friday',
                'type' => 'checkbox'
            ),
            array(
                'field' => 's_s',
                'label' => 'Saturday',
                'type' => 'checkbox'
            ),
            array(
                'field' => 's_su',
                'label' => 'Sunday',
                'type' => 'checkbox'
            ),
        );
    }

    private function form_schedule($row_f) {
        $this->load->helper('form');
        $myform = array(
            'action' => 'faculty/add-subject-schedule/' . $row_f->faculty_id,
            'button_name' => 'add_schedule_button',
            'button_label' => 'Add Schedule',
            'attr' => $this->my_input_schedule,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Add Subject Schedule of "' . $row_f->faculty_lastname . ', ' . $row_f->faculty_name . '" | ' . $row_f->faculty_school_id . '.',
        ));
    }

    public function add_subject_schedule($id = NULL) {
        $row_f = $this->check_id_($id);
        $this->my_header_view_admin();

        $this->load->library('form_validation');
        $this->add_schdule_validation();

        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');

        $this->form_validation->set_rules($this->my_input_schedule);
        if (!$this->form_validation->run()) {
            $this->form_schedule($row_f);
        } else {

            $data = array(
                'schedule_start' => $this->input->post('s_start', TRUE),
                'schedule_end' => $this->input->post('s_end', TRUE),
                'schedule_room' => $this->input->post('s_room', TRUE),
                'schedule_id' => $this->input->post('schedule_id', TRUE),
                'faculty_id' => $id,
                'subject_term_id' => $this->input->post('subject_term_id', TRUE),
                'admin_id' => $this->session->userdata('admin_id'),
            );
            if (!is_null($this->input->post('s_m'))) {
                $data['schedule_m'] = TRUE;
            }
            if (!is_null($this->input->post('s_t'))) {
                $data['schedule_t'] = TRUE;
            }
            if (!is_null($this->input->post('s_w'))) {
                $data['schedule_w'] = TRUE;
            }
            if (!is_null($this->input->post('s_th'))) {
                $data['schedule_th'] = TRUE;
            }
            if (!is_null($this->input->post('s_f'))) {
                $data['schedule_f'] = TRUE;
            }
            if (!is_null($this->input->post('s_s'))) {
                $data['schedule_s'] = TRUE;
            }
            if (!is_null($this->input->post('s_su'))) {
                $data['schedule_su'] = TRUE;
            }

            $this->load->model('Schedule_Model');
            $msg = ($this->Schedule_Model->add($data)) ? 'Added! <br />' : 'Failed to add.<br />';
            $this->load->view('admin/msg', array(
                'msg' => $msg
            ));
        }
        $this->view_schedule($row_f);
        $this->load->view('admin/footer2');
    }

    public function add() {

        $this->my_header_view_admin();

        $this->load->library('form_validation');
        $this->add_faculty_validation();
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');

        $this->form_validation->set_rules($this->my_input);


        if (!$this->form_validation->run()) {
            $this->form_faculty();
        } else {

            $data = array(
                'faculty_name' => $this->input->post('firstname', TRUE),
                'faculty_lastname' => $this->input->post('lastname', TRUE),
                'faculty_school_id' => $this->input->post('school_id', TRUE),
                'branch_id' => $this->input->post('branch_id', TRUE),
                'faculty_pin' => password_hash($this->input->post('pin', TRUE), 1),
                'admin_id' => $this->session->userdata('admin_id'),
            );
            $this->load->model('Faculty_Model');
            $msg = ($this->Faculty_Model->add($data)) ? 'Faculty Added!' : 'Failed to add.';

            $this->load->view('admin/msg', array(
                'msg' => $msg
            ));
        }

        $this->load->view('admin/footer2');
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

}
